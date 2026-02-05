
/**
 * Catalog App
 * Handles search, filtering, and display of the product catalog.
 * Supports EN/ES localization, Live Search, Procurement Tools.
 */

document.addEventListener('DOMContentLoaded', () => {

    // --- State Management ---
    const STATE = {
        products: window.FL_CATALOG_DATA || [],
        lang: 'en',
        filters: {
            search: '',
            category: 'All',
            tier: 'All',
            sterile: 'All',
            size: 'All'
        },
        view: 'card', // 'card' or 'table'
        pinned: [],  // Array of product IDs
        selected: [] // Array of product IDs (for export)
    };

    // --- Persistence Keys ---
    const STORAGE_KEY_SESSION = 'fl_catalog_session_v1';
    const STORAGE_KEY_PINNED = 'fl_catalog_pinned_v1';

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
            noResults: "No matching products found.",
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
            loading: "Loading catalog...",
            pin: "Pin to top",
            unpin: "Unpin",
            exportCSV: "Export Selected CSV",
            clearSearch: "Clear search"
        },
        es: {
            searchPlaceholder: "Buscar productos (ej. 'Bata quirúrgica', '310130', 'XL', 'estéril')",
            filterCategory: "Categoría",
            filterTier: "Nivel",
            filterSterile: "Estéril",
            filterSize: "Talla",
            resetFilters: "Restablecer filtros",
            showingResults: "Mostrando {count} resultados",
            noResults: "No se encontraron resultados coincidentes.",
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
            loading: "Cargando catálogo...",
            pin: "Fijar arriba",
            unpin: "Desfijar",
            exportCSV: "Exportar CSV",
            clearSearch: "Borrar búsqueda"
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
        viewToggle: document.getElementById('fl-view-toggle'),
        heroTitle: document.querySelector('.catalog-hero h1'),
        heroSubtext: document.querySelector('.catalog-hero .subtext'),
        labelCategory: document.querySelector('.filter-group:nth-child(1) label'),
        labelTier: document.querySelector('.filter-group:nth-child(2) label'),
        labelSterile: document.querySelector('.filter-group:nth-child(3) label'),
        labelSize: document.querySelector('.filter-group:nth-child(4) label'),
        langButtons: document.querySelectorAll('[data-lang-button]'),
        // Dynamic elements will be injected/queried as needed
        controlsContainer: document.querySelector('.results-meta')
    };

    if (!dom.root) return;

    // --- Initialization ---
    init();

    function init() {
        // 1. Load Persistence
        loadState();

        // 2. Detect Language
        detectLanguage();

        // 3. Inject Utilities
        injectExportButton();

        // 4. Bind Events
        bindEvents();

        // 5. Initial Render
        render();
    }

    // --- Persistence Logic ---
    function loadState() {
        // Load Pinned (LocalStorage - Persistent)
        try {
            const savedPinned = localStorage.getItem(STORAGE_KEY_PINNED);
            if (savedPinned) {
                STATE.pinned = JSON.parse(savedPinned);
            }
        } catch (e) { console.warn('Local storage access denied'); }

        // Load Session (SessionStorage - Temporary)
        try {
            const savedSession = sessionStorage.getItem(STORAGE_KEY_SESSION);
            if (savedSession) {
                const sessionData = JSON.parse(savedSession);
                STATE.filters = { ...STATE.filters, ...sessionData.filters };
                STATE.view = sessionData.view || 'card';
                // Restore input value
                if (dom.searchInput) dom.searchInput.value = STATE.filters.search;
                // Restore filter dropdowns
                if (dom.filterCategory) dom.filterCategory.value = STATE.filters.category;
                if (dom.filterTier) dom.filterTier.value = STATE.filters.tier;
                if (dom.filterSterile) dom.filterSterile.value = STATE.filters.sterile;
                if (dom.filterSize) dom.filterSize.value = STATE.filters.size;
                if (dom.viewToggle) dom.viewToggle.checked = (STATE.view === 'table');
            }
        } catch (e) { console.warn('Session storage access denied'); }

        // URL params override session if present (deep linking)
        readUrlParams();
    }

    function saveState() {
        // Save Session
        try {
            const sessionData = {
                filters: STATE.filters,
                view: STATE.view
            };
            sessionStorage.setItem(STORAGE_KEY_SESSION, JSON.stringify(sessionData));
        } catch (e) { }

        // Save Pinned
        try {
            localStorage.setItem(STORAGE_KEY_PINNED, JSON.stringify(STATE.pinned));
        } catch (e) { }
    }

    function detectLanguage() {
        const htmlLang = document.documentElement.lang.toLowerCase();
        if (htmlLang.includes('es')) {
            STATE.lang = 'es';
        } else {
            const activeBtn = document.querySelector('[data-lang-button].is-active');
            if (activeBtn) {
                const lang = activeBtn.getAttribute('data-lang-button');
                if (lang === 'es') STATE.lang = 'es';
            }
        }
        applyLanguageToUI();
    }

    function injectExportButton() {
        if (!dom.controlsContainer) return;
        // Check if exists
        if (document.getElementById('fl-export-btn')) return;

        const btn = document.createElement('button');
        btn.id = 'fl-export-btn';
        btn.className = 'btn btn-link btn-export';
        btn.style.marginLeft = '16px';
        btn.style.display = 'none'; // Hidden by default, shown in table view
        btn.textContent = I18N[STATE.lang].exportCSV;

        // Insert before result count or append
        dom.controlsContainer.appendChild(btn);

        btn.addEventListener('click', exportCSV);
    }

    function bindEvents() {
        // Search
        dom.searchInput.addEventListener('input', debounce((e) => {
            const val = e.target.value.trim().toLowerCase();
            STATE.filters.search = val;

            // "Search Whole Inventory" Rule:
            // If user types a search term, reset Category to 'All' so we don't limit results.
            if (val.length > 0 && STATE.filters.category !== 'All') {
                STATE.filters.category = 'All';
                if (dom.filterCategory) dom.filterCategory.value = 'All';
            }

            saveState();
            // updateUrl(); // Optional: updating URL on every keystroke can be spammy
            render();
        }, 300));

        dom.searchClear.addEventListener('click', () => {
            dom.searchInput.value = '';
            STATE.filters.search = '';
            STATE.selected = []; // Clear selection on full reset? Maybe keep it.
            saveState();
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
                saveState();
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
                STATE.selected = [];

                dom.searchInput.value = '';
                dom.filterCategory.value = 'All';
                dom.filterTier.value = 'All';
                dom.filterSterile.value = 'All';
                dom.filterSize.value = 'All';

                saveState();
                render();
            });
        }

        // View Toggle
        if (dom.viewToggle) {
            dom.viewToggle.addEventListener('change', (e) => {
                STATE.view = e.target.checked ? 'table' : 'card';
                saveState();
                render();
            });
        }

        // Language
        dom.langButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const newLang = btn.getAttribute('data-lang-button');
                if (newLang && newLang !== STATE.lang) {
                    STATE.lang = newLang;
                    applyLanguageToUI();
                    render();
                }
            });
        });
    }

    function readUrlParams() {
        const params = new URLSearchParams(window.location.search);
        // We only override if params explicitly exist
        if (params.has('q')) {
            STATE.filters.search = params.get('q').toLowerCase();
            dom.searchInput.value = STATE.filters.search;
        }
        if (params.has('category')) {
            const catSlug = params.get('category');
            const catName = mapSlugToCategory(catSlug);
            if (catName) {
                STATE.filters.category = catName;
                const option = Array.from(dom.filterCategory.options).find(o => o.value === catName);
                if (option) dom.filterCategory.value = catName;
            }
        }
    }

    // --- Core Logic ---

    function highlightText(text, query) {
        if (!text) return '';
        if (!query) return text;
        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return text.replace(regex, '<mark class="highlight">$1</mark>');
    }

    function togglePin(id) {
        if (STATE.pinned.includes(id)) {
            STATE.pinned = STATE.pinned.filter(pid => pid !== id);
        } else {
            STATE.pinned.push(id);
        }
        saveState();
        render(); // Re-sort
    }

    function toggleSelection(id) {
        if (STATE.selected.includes(id)) {
            STATE.selected = STATE.selected.filter(sid => sid !== id);
        } else {
            STATE.selected.push(id);
        }
        // No full render needed, maybe just button state update?
        // But for table we might want row highlight.
        // Let's re-render to allow UI updates or just update the export btn text if we want counts.
    }

    function exportCSV() {
        const dict = I18N[STATE.lang];
        // Identify which products to export
        // If selection exists, export selection. Else export current visible list.

        let productsToExport = [];

        if (STATE.selected.length > 0) {
            productsToExport = STATE.products.filter(p => STATE.selected.includes(p.id));
        } else {
            // Re-run filter logic to get currently visible
            productsToExport = getFilteredProducts();
        }

        if (productsToExport.length === 0) return;

        // Build CSV
        const headers = [dict.tableProduct, dict.tableCode, dict.tableCategory, dict.tableDetails];
        const rows = productsToExport.flatMap(p => {
            const name = (STATE.lang === 'es' && p.name_es) ? p.name_es : p.name;
            const category = (STATE.lang === 'es' && p.category_es) ? p.category_es : p.category;

            return p.skus.map(s => {
                return [
                    `"${name.replace(/"/g, '""')}"`, // Escape quotes
                    `"${s.code}"`,
                    `"${category}"`,
                    `"${s.size} / ${s.sterile ? (STATE.lang === 'es' ? 'Estéril' : 'Sterile') : (STATE.lang === 'es' ? 'No estéril' : 'Non-sterile')}"`
                ].join(',');
            });
        });

        const csvContent = "data:text/csv;charset=utf-8,"
            + headers.join(",") + "\n"
            + rows.join("\n");

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "florence_catalog_export.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function getFilteredProducts() {
        return STATE.products.filter(p => {
            const pNameEn = (p.name || '').toLowerCase();
            const pNameEs = (p.name_es || '').toLowerCase();
            const pDescEn = (p.description || '').toLowerCase();
            const pDescEs = (p.description_es || '').toLowerCase();
            const query = STATE.filters.search;

            const matchesSearch = !query ||
                pNameEn.includes(query) ||
                pNameEs.includes(query) ||
                pDescEn.includes(query) ||
                pDescEs.includes(query) ||
                p.id.includes(query) ||
                p.skus.some(s => s.code.toLowerCase().includes(query) || s.health_code.includes(query));

            const matchesCategory = STATE.filters.category === 'All' || p.category === STATE.filters.category;
            const matchesTier = STATE.filters.tier === 'All' || p.tier === STATE.filters.tier;

            let matchesSterile = true;
            if (STATE.filters.sterile === 'Sterile') matchesSterile = p.filters.sterile === true;
            if (STATE.filters.sterile === 'Non-Sterile') matchesSterile = p.filters.sterile === false;

            const matchesSize = STATE.filters.size === 'All' || p.filters.sizes.includes(STATE.filters.size);

            return matchesSearch && matchesCategory && matchesTier && matchesSterile && matchesSize;
        });
    }

    function applyLanguageToUI() {
        const dict = I18N[STATE.lang];
        if (dom.heroTitle) dom.heroTitle.textContent = (STATE.lang === 'es') ? 'Productos' : 'Products';
        if (dom.heroSubtext) dom.heroSubtext.textContent = (STATE.lang === 'es') ?
            "Busque por nombre, código, talla, estéril o clave." :
            "Search by product name, code, size, sterile status, or health sector code.";
        dom.searchInput.placeholder = dict.searchPlaceholder;
        if (dom.labelCategory) dom.labelCategory.textContent = dict.filterCategory;
        if (dom.labelTier) dom.labelTier.textContent = dict.filterTier;
        if (dom.labelSterile) dom.labelSterile.textContent = dict.filterSterile;
        if (dom.labelSize) dom.labelSize.textContent = dict.filterSize;
        if (dom.resetBtn) dom.resetBtn.textContent = dict.resetFilters;
        if (dom.filterCategory.options[0]) dom.filterCategory.options[0].textContent = dict.allCategories;
        if (dom.filterTier.options[0]) dom.filterTier.options[0].textContent = dict.allTiers;
        if (dom.filterSterile.options[0]) dom.filterSterile.options[0].textContent = dict.any;
        if (dom.filterSize.options[0]) dom.filterSize.options[0].textContent = dict.allSizes;

        // Update Export Button Text
        const exportBtn = document.getElementById('fl-export-btn');
        if (exportBtn) exportBtn.textContent = dict.exportCSV;
    }

    function render() {
        const filtered = getFilteredProducts();

        // Sorting: Pinned items first
        filtered.sort((a, b) => {
            const aPinned = STATE.pinned.includes(a.id);
            const bPinned = STATE.pinned.includes(b.id);
            if (aPinned && !bPinned) return -1;
            if (!aPinned && bPinned) return 1;
            return 0; // Maintain default order
        });

        const dict = I18N[STATE.lang];
        dom.resultsCount.textContent = dict.showingResults.replace('{count}', filtered.length);

        // Show/Hide Export Button based on view
        const exportBtn = document.getElementById('fl-export-btn');
        if (exportBtn) {
            exportBtn.style.display = (STATE.view === 'table') ? 'inline-block' : 'none';
        }

        if (filtered.length === 0) {
            // Only show empty state if we have a search query or active filters
            // But spec says "restore all products" when input is empty. Initial load has empty input -> shows all.
            // So if filtered is 0, it really means no results.
            dom.resultsContainer.innerHTML = `<div class="catalog-empty">${dict.noResults}</div>`;
        } else {
            dom.resultsContainer.innerHTML = '';
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
            const category = (STATE.lang === 'es' && p.category_es) ? p.category_es : p.category;

            // Highlight
            const highlightedName = highlightText(name, STATE.filters.search);
            const isPinned = STATE.pinned.includes(p.id);

            const card = document.createElement('div');
            card.className = `cat-card ${isPinned ? 'is-pinned' : ''}`;

            const tierClass = (p.tier.toLowerCase() === 'premium') ? 'badge--premium' : 'badge--standard';

            card.innerHTML = `
                <div class="cat-card__header">
                    <div class="cat-header-top">
                         <div class="cat-badges">
                            <span class="badge ${tierClass}">${p.tier}</span>
                            <span class="badge badge--cat">${category}</span>
                        </div>
                        <button class="btn-pin" data-id="${p.id}" title="${isPinned ? dict.unpin : dict.pin}">
                            ${isPinned ? '★' : '☆'}
                        </button>
                    </div>
                   
                    <h4>${highlightedName}</h4>
                </div>
                
                <div class="cat-desc">${desc}</div>
                
                <div class="cat-card__specs">
                    ${p.skus.slice(0, 3).map(s => {
                return `<span class="sku-tag">${highlightText(s.code, STATE.filters.search)}</span>`;
            }).join('')}
                    ${p.skus.length > 3 ? `<span class="sku-more">+${p.skus.length - 3}</span>` : ''}
                </div>
                <button class="btn btn-primary btn-sm btn-view-details" data-id="${p.id}">${dict.viewDetails}</button>
            `;

            // Pin Event
            card.querySelector('.btn-pin').addEventListener('click', () => togglePin(p.id));

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
                        <th class="col-select"></th>
                        <th>${dict.tableCode}</th>
                        <th>${dict.tableProduct}</th>
                        <th>${dict.tableCategory}</th>
                        <th>${dict.tableDetails}</th>
                        <th></th> 
                    </tr>
                </thead>
                <tbody>
        `;

        // We will build rows programmatically to attach events easier, 
        // OR render HTML string and attach events via delegation. Delegation is safer for performance here.
        // Let's use pure HTML generation but add IDs for row selection.

        html += '</tbody></table>';
        tableWrapper.innerHTML = html;
        const tbody = tableWrapper.querySelector('tbody');

        products.forEach(p => {
            const name = (STATE.lang === 'es' && p.name_es) ? p.name_es : p.name;
            const category = (STATE.lang === 'es' && p.category_es) ? p.category_es : p.category;
            const isPinned = STATE.pinned.includes(p.id);
            const isSelected = STATE.selected.includes(p.id);

            // Highlight Name
            const highlightedName = highlightText(name, STATE.filters.search);

            p.skus.forEach((s, index) => {
                const tr = document.createElement('tr');
                if (isPinned) tr.classList.add('is-pinned-row');

                // Highlight Code
                const highlightedCode = highlightText(s.code, STATE.filters.search);

                tr.innerHTML = `
                    <td class="col-select">
                        ${index === 0 ? `<input type="checkbox" class="row-select-cb" data-id="${p.id}" ${isSelected ? 'checked' : ''}>` : ''}
                    </td>
                    <td class="code-cell">${highlightedCode}</td>
                    <td class="name-cell">
                        ${index === 0 ? `<strong>${highlightedName}</strong>` : ''}
                        ${(index === 0 && isPinned) ? '<span class="pinned-icon">★</span>' : ''}
                    </td>
                    <td>${category}</td>
                    <td>
                        <span class="detail-pill">${s.size}</span>
                        ${s.sterile ? '<span class="detail-icon sterile" title="Sterile">✓</span>' : ''}
                    </td>
                    <td class="col-actions">
                         ${index === 0 ? `<button class="btn-pin-table" data-id="${p.id}">${isPinned ? 'Unpin' : 'Pin'}</button>` : ''}
                    </td>
                `;

                // Events
                const cb = tr.querySelector('.row-select-cb');
                if (cb) {
                    cb.addEventListener('change', () => toggleSelection(p.id));
                }
                const pinBtn = tr.querySelector('.btn-pin-table');
                if (pinBtn) {
                    pinBtn.addEventListener('click', () => togglePin(p.id));
                }

                tbody.appendChild(tr);
            });
        });

        dom.resultsContainer.appendChild(tableWrapper);
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

    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

});
