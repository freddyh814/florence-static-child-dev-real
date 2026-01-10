
/**
 * Catalog App
 * Handles search, filtering, and display of the product catalog.
 * Supports EN/ES localization.
 */

document.addEventListener('DOMContentLoaded', () => {

    // --- State Management ---
    const STATE = {
        products: window.FL_CATALOG_DATA || [],
        lang: 'en', // Default
        filters: {
            search: '',
            category: 'All',
            tier: 'All',
            sterile: 'All',
            size: 'All'
        },
        view: 'card' // 'card' or 'table'
    };

    // --- I18N Dictionary ---
    const I18N = {
        en: {
            searchPlaceholder: "Search products (e.g., 'Surgical gown', '310130', 'XL', 'sterile')",
            filterCategory: "Category",
            filterTier: "Tier",
            filterSterile: "Sterile",
            filterSize: "Size",
            resetFilters: "Reset filters",
            showingResults: "Showing {count} results",
            noResults: "No matches found.",
            viewDetails: "View details",
            tableCode: "Code",
            tableProduct: "Product",
            tableDetails: "Details (Size / Sterile)",
            tableCategory: "Category",
            allCategories: "All Categories",
            allTiers: "All Tiers",
            allSizes: "All Sizes",
            any: "Any",
            yes: "Yes",
            no: "No",
            loading: "Loading catalog..."
        },
        es: {
            searchPlaceholder: "Buscar productos (ej. 'Bata quirúrgica', '310130', 'XL', 'estéril')",
            filterCategory: "Categoría",
            filterTier: "Nivel",
            filterSterile: "Estéril",
            filterSize: "Talla",
            resetFilters: "Restablecer filtros",
            showingResults: "Mostrando {count} resultados",
            noResults: "No se encontraron resultados.",
            viewDetails: "Ver detalles",
            tableCode: "Código",
            tableProduct: "Producto",
            tableDetails: "Detalles (Talla / Estéril)",
            tableCategory: "Categoría",
            allCategories: "Todas las Categorías",
            allTiers: "Todos los Niveles",
            allSizes: "Todas las Tallas",
            any: "Cualquiera",
            yes: "Sí",
            no: "No",
            loading: "Cargando catálogo..."
        }
    };

    // --- DOM Elements ---
    const dom = {
        root: document.getElementById('fl-catalog-root'),
        resultsContainer: document.getElementById('fl-results-container'),
        searchInput: document.getElementById('fl-search-input'),
        searchClear: document.getElementById('fl-search-clear'),
        filterCategory: document.getElementById('filter-category'),
        filterTier: document.getElementById('filter-tier'),
        filterSterile: document.getElementById('filter-sterile'),
        filterSize: document.getElementById('filter-size'),
        resetBtn: document.querySelector('.fl-reset-btn'),
        resultsCount: document.getElementById('fl-results-count'),
        viewToggle: document.getElementById('fl-view-toggle'), // Checkbox
        heroTitle: document.querySelector('.catalog-hero h1'),
        heroSubtext: document.querySelector('.catalog-hero .subtext'),
        labelCategory: document.querySelector('.filter-group:nth-child(1) label'),
        labelTier: document.querySelector('.filter-group:nth-child(2) label'),
        labelSterile: document.querySelector('.filter-group:nth-child(3) label'),
        labelSize: document.querySelector('.filter-group:nth-child(4) label'),
        cardLabel: document.querySelector('.view-toggle-wrapper span:first-child'),
        tableLabel: document.querySelector('.view-toggle-wrapper span:last-child'),
        langButtons: document.querySelectorAll('[data-lang-button]')
    };

    if (!dom.root) return; // Exit if not on catalog page

    // --- Initialization ---
    init();

    function init() {
        // Detect initial language
        detectLanguage();

        // Bind Events
        bindEvents();

        // Read URL Params
        readUrlParams();

        // Initial Render
        render();
    }

    function detectLanguage() {
        // Check html lang attribute or header active class
        const htmlLang = document.documentElement.lang.toLowerCase();
        if (htmlLang.includes('es')) {
            STATE.lang = 'es';
        } else {
            // Check active button logic from header if present
            const activeBtn = document.querySelector('[data-lang-button].is-active');
            if (activeBtn) {
                const lang = activeBtn.getAttribute('data-lang-button');
                if (lang === 'es') STATE.lang = 'es';
            }
        }
        applyLanguageToUI();
    }

    function bindEvents() {
        // Search
        dom.searchInput.addEventListener('input', debounce((e) => {
            STATE.filters.search = e.target.value.trim().toLowerCase();
            updateUrl();
            render();
        }, 300));

        dom.searchClear.addEventListener('click', () => {
            dom.searchInput.value = '';
            STATE.filters.search = '';
            updateUrl();
            render();
            dom.searchInput.focus();
        });

        // Filters
        [dom.filterCategory, dom.filterTier, dom.filterSterile, dom.filterSize].forEach(el => {
            if (!el) return;
            el.addEventListener('change', () => {
                STATE.filters.category = dom.filterCategory.value;
                STATE.filters.tier = dom.filterTier.value;
                STATE.filters.sterile = dom.filterSterile.value;
                STATE.filters.size = dom.filterSize.value;
                updateUrl();
                render();
            });
        });

        // Reset
        if (dom.resetBtn) {
            dom.resetBtn.addEventListener('click', () => {
                STATE.filters.search = '';
                STATE.filters.category = 'All';
                STATE.filters.tier = 'All';
                STATE.filters.sterile = 'All';
                STATE.filters.size = 'All';

                dom.searchInput.value = '';
                dom.filterCategory.value = 'All';
                dom.filterTier.value = 'All';
                dom.filterSterile.value = 'All';
                dom.filterSize.value = 'All';

                updateUrl();
                render();
            });
        }

        // View Toggle
        if (dom.viewToggle) {
            dom.viewToggle.addEventListener('change', (e) => {
                STATE.view = e.target.checked ? 'table' : 'card';
                render();
            });
        }

        // Language Switch Events (Header integration)
        dom.langButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const newLang = btn.getAttribute('data-lang-button');
                if (newLang && newLang !== STATE.lang) {
                    STATE.lang = newLang;
                    applyLanguageToUI();
                    render(); // Re-render products in new language
                }
            });
        });
    }

    function readUrlParams() {
        const params = new URLSearchParams(window.location.search);

        // Search with pre-fill
        if (params.has('q')) {
            STATE.filters.search = params.get('q').toLowerCase();
            dom.searchInput.value = STATE.filters.search;
        }

        // Category mapping (slug -> Name)
        if (params.has('category')) {
            const catSlug = params.get('category');
            const catName = mapSlugToCategory(catSlug);
            if (catName) {
                STATE.filters.category = catName;
                // If the option exists in dropdown, select it
                const option = Array.from(dom.filterCategory.options).find(o => o.value === catName);
                if (option) dom.filterCategory.value = catName;
            }
        }
    }

    function updateUrl() {
        const params = new URLSearchParams();
        if (STATE.filters.search) params.set('q', STATE.filters.search);

        // Only set category param if it's one of our main slugs for deep linking logic
        // Reverse map simple implementation for core categories
        if (STATE.filters.category !== 'All') {
            // Check specific slugs
            if (STATE.filters.category.includes('Gowns')) params.set('category', 'gowns');
            else if (STATE.filters.category.includes('Masks')) params.set('category', 'masks');
            else if (STATE.filters.category.includes('Drapes')) params.set('category', 'drapes');
            else if (STATE.filters.category.includes('Accessories')) params.set('category', 'accessories');
            else if (STATE.filters.category.includes('Private')) params.set('category', 'private-label');
        }

        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.replaceState(null, '', newUrl);
    }

    // --- Rendering ---

    function applyLanguageToUI() {
        const dict = I18N[STATE.lang];

        // Hero
        if (dom.heroTitle) dom.heroTitle.textContent = (STATE.lang === 'es') ? 'Productos' : 'Products';
        if (dom.heroSubtext) dom.heroSubtext.textContent = (STATE.lang === 'es') ?
            "Busque por nombre, código, talla, estéril o clave." :
            "Search by product name, code, size, sterile status, or health sector code.";

        // Inputs
        dom.searchInput.placeholder = dict.searchPlaceholder;

        // Labels
        if (dom.labelCategory) dom.labelCategory.textContent = dict.filterCategory;
        if (dom.labelTier) dom.labelTier.textContent = dict.filterTier;
        if (dom.labelSterile) dom.labelSterile.textContent = dict.filterSterile;
        if (dom.labelSize) dom.labelSize.textContent = dict.filterSize;
        if (dom.resetBtn) dom.resetBtn.textContent = dict.resetFilters;

        // Dropdown placeholders (first option)
        if (dom.filterCategory.options[0]) dom.filterCategory.options[0].textContent = dict.allCategories;
        if (dom.filterTier.options[0]) dom.filterTier.options[0].textContent = dict.allTiers;
        if (dom.filterSterile.options[0]) dom.filterSterile.options[0].textContent = dict.any;
        if (dom.filterSize.options[0]) dom.filterSize.options[0].textContent = dict.allSizes;

        // View Toggle Labels
        // Note: Simple text replacement
        // dom.cardLabel.textContent = (STATE.lang === 'es') ? 'Tarjetas' : 'Card';
        // dom.tableLabel.textContent = (STATE.lang === 'es') ? 'Tabla' : 'Table';
    }

    function render() {
        // Filter Data
        const filtered = STATE.products.filter(p => {
            // Determine text to search against (check both langs for robust search if user types English in Spanish mode)
            const pNameEn = (p.name || '').toLowerCase();
            const pNameEs = (p.name_es || '').toLowerCase();
            const pDescEn = (p.description || '').toLowerCase();
            const pDescEs = (p.description_es || '').toLowerCase();

            const matchesSearch = !STATE.filters.search ||
                pNameEn.includes(STATE.filters.search) ||
                pNameEs.includes(STATE.filters.search) ||
                pDescEn.includes(STATE.filters.search) ||
                pDescEs.includes(STATE.filters.search) ||
                p.id.includes(STATE.filters.search) ||
                p.skus.some(s => s.code.toLowerCase().includes(STATE.filters.search) || s.health_code.includes(STATE.filters.search));

            const matchesCategory = STATE.filters.category === 'All' || p.category === STATE.filters.category; // Note: Category logic relies on the English key for filtering currently
            const matchesTier = STATE.filters.tier === 'All' || p.tier === STATE.filters.tier;

            // Check Sterile (at least one SKU matches)
            let matchesSterile = true;
            if (STATE.filters.sterile === 'Sterile') matchesSterile = p.filters.sterile === true;
            if (STATE.filters.sterile === 'Non-Sterile') matchesSterile = p.filters.sterile === false;

            // Check Size (at least one SKU matches)
            const matchesSize = STATE.filters.size === 'All' || p.filters.sizes.includes(STATE.filters.size);

            return matchesSearch && matchesCategory && matchesTier && matchesSterile && matchesSize;
        });

        // Update Count
        const dict = I18N[STATE.lang];
        dom.resultsCount.textContent = dict.showingResults.replace('{count}', filtered.length);

        // Render Content
        if (filtered.length === 0) {
            dom.resultsContainer.innerHTML = `<div class="catalog-empty">${dict.noResults}</div>`;
        } else {
            dom.resultsContainer.innerHTML = ''; // Clear
            if (STATE.view === 'card') {
                renderGrid(filtered, dict);
            } else {
                renderTable(filtered, dict);
            }
        }
    }

    function renderGrid(products, dict) {
        const grid = document.createElement('div');
        grid.className = 'catalog-grid-view';

        products.forEach(p => {
            const name = (STATE.lang === 'es' && p.name_es) ? p.name_es : p.name;
            const desc = (STATE.lang === 'es' && p.description_es) ? p.description_es : p.description;
            // Use English category for consistency with logic or add display map
            const category = (STATE.lang === 'es' && p.category_es) ? p.category_es : p.category;

            const card = document.createElement('div');
            card.className = 'cat-card'; // Use cat-card to match CSS styling

            const tierClass = (p.tier.toLowerCase() === 'premium') ? 'badge--premium' : 'badge--standard';

            card.innerHTML = `
                <div class="cat-card__header">
                    <div class="cat-badges">
                        <span class="badge ${tierClass}">${p.tier}</span>
                        <span class="badge badge--cat">${category}</span>
                    </div>
                    <h4>${name}</h4>
                </div>
                
                <div class="cat-desc">${desc}</div>
                
                <div class="cat-card__specs">
                    ${p.skus.slice(0, 3).map(s => `<span style="font-weight: 700; color: #000000; margin-right: 6px;">${s.code}</span>`).join('')}
                    ${p.skus.length > 3 ? `<span style="color: #64748b; font-size: 0.9em;">+${p.skus.length - 3}</span>` : ''}
                </div>
                <button class="btn btn-primary btn-sm btn-view-details" data-id="${p.id}" style="width: 100%; justify-content: center;">${dict.viewDetails}</button>
            `;

            // Add click listener for details
            const btn = card.querySelector('.btn-view-details');
            if (btn) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    // No-op for now
                });
            }

            grid.appendChild(card);
        });
        dom.resultsContainer.appendChild(grid);
    }

    function renderTable(products, dict) {
        const tableWrapper = document.createElement('div');
        tableWrapper.className = 'catalog-table-wrapper';

        let html = `
            <table class="catalog-table">
                <thead>
                    <tr>
                        <th>${dict.tableCode}</th>
                        <th>${dict.tableProduct}</th>
                        <th>${dict.tableCategory}</th>
                        <th>${dict.tableDetails}</th>
                    </tr>
                </thead>
                <tbody>
        `;

        products.forEach(p => {
            const name = (STATE.lang === 'es' && p.name_es) ? p.name_es : p.name;
            const category = (STATE.lang === 'es' && p.category_es) ? p.category_es : p.category;

            p.skus.forEach(s => {
                html += `
                    <tr>
                        <td class="code-cell">${s.code}</td>
                        <td class="name-cell"><strong>${name}</strong></td>
                        <td>${category}</td>
                        <td>
                            <span class="detail-pill">${s.size}</span>
                            ${s.sterile ? '<span class="detail-icon sterile" title="Sterile">✓</span>' : ''}
                        </td>
                    </tr>
                `;
            });
        });

        html += '</tbody></table>';
        tableWrapper.innerHTML = html;
        dom.resultsContainer.appendChild(tableWrapper);
    }

    // Helper
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function mapSlugToCategory(slug) {
        if (!slug) return null;
        if (slug === 'gowns') return 'Isolation & Surgical Gowns';
        if (slug === 'masks') return 'Face Masks & Respiratory';
        if (slug === 'drapes') return 'Drapes & Procedure Packs';
        if (slug === 'accessories') return 'Gloves & Accessories';
        if (slug === 'private-label') return 'Private Label Programs';
        return 'All';
    }

});
