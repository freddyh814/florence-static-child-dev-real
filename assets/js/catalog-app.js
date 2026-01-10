/**
 * Florence Catalog Controller
 * Handles search, filtering, and table toggling.
 */
document.addEventListener('DOMContentLoaded', function() {
    const catalogRoot = document.getElementById('fl-catalog-root');
    if (!catalogRoot) return;

    // Data injected from PHP
    const catalogData = window.FL_CATALOG_DATA || [];
    
    // State
    let state = {
        query: '',
        filters: {
            category: 'All',
            tier: 'All',
            sterile: 'All',
            size: 'All',
            type: 'All'
        },
        view: 'grid' // 'grid' | 'table'
    };

    // DOM Elements
    const searchInput = document.getElementById('fl-search-input');
    const clearSearchBtn = document.getElementById('fl-search-clear');
    const resultsContainer = document.getElementById('fl-results-container');
    const resultsCount = document.getElementById('fl-results-count');
    const viewToggle = document.getElementById('fl-view-toggle');
    const resetBtns = document.querySelectorAll('.fl-reset-btn');
    
    // Filter Elements
    const filterEls = {
        category: document.getElementById('filter-category'),
        tier: document.getElementById('filter-tier'),
        sterile: document.getElementById('filter-sterile'),
        size: document.getElementById('filter-size'),
        type: document.getElementById('filter-type'),
    };

    // Initialize
    init();

    function init() {
        // Read URL Params
        const params = new URLSearchParams(window.location.search);
        if (params.has('category')) {
            // Map slug to Name if needed, or loosely match
            const slug = params.get('category').toLowerCase();
            state.filters.category = mapSlugToCategory(slug);
            if (filterEls.category) filterEls.category.value = state.filters.category;
        }
        if (params.has('q')) {
            state.query = params.get('q');
            searchInput.value = state.query;
            state.filters.category = 'All'; // Specific search overrides category landing usually, but let's keep it flexible
            filterEls.category.value = 'All';
        }

        bindEvents();
        render();
    }

    function mapSlugToCategory(slug) {
        const map = {
            'gowns': 'Isolation & Surgical Gowns',
            'masks': 'Face Masks & Respiratory',
            'drapes': 'Drapes & Procedure Packs',
            'packs': 'Drapes & Procedure Packs',
            'accessories': 'Gloves & Accessories',
            'private-label': 'Private Label Programs'
        };
        // Fuzzy match or direct lookup
        for (let key in map) {
            if (slug.includes(key)) return map[key];
        }
        return 'All';
    }

    function bindEvents() {
        // Search (Debounced)
        let debounceTimer;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                state.query = e.target.value.trim();
                updateSearchUI();
                render();
            }, 300);
        });

        // Clear Search
        clearSearchBtn.addEventListener('click', () => {
            state.query = '';
            searchInput.value = '';
            updateSearchUI();
            render();
            searchInput.focus();
        });

        // Filters
        Object.keys(filterEls).forEach(key => {
            filterEls[key].addEventListener('change', (e) => {
                state.filters[key] = e.target.value;
                render();
            });
        });

        // Reset
        resetBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                resetFilters();
            });
        });

        // View Toggle
        viewToggle.addEventListener('change', (e) => {
            state.view = e.target.checked ? 'table' : 'grid';
            render();
        });
    }

    function resetFilters() {
        state.query = '';
        searchInput.value = '';
        state.filters = {
            category: 'All',
            tier: 'All',
            sterile: 'All',
            size: 'All',
            type: 'All'
        };
        
        // Reset UI
        Object.keys(filterEls).forEach(key => filterEls[key].value = 'All');
        updateSearchUI();
        render();
    }

    function updateSearchUI() {
        if (state.query.length > 0) {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
        }
    }

    function filterData() {
        return catalogData.filter(item => {
            // 1. Text Search (Name, Code, Desc, Health Code)
            if (state.query) {
                const q = state.query.toLowerCase();
                const searchable = [
                    item.name,
                    item.description,
                    item.filters.codes.join(' '),
                    item.skus.map(s => s.health_code).join(' ')
                ].join(' ').toLowerCase();
                
                if (!searchable.includes(q)) return false;
            }

            // 2. Category
            if (state.filters.category !== 'All' && item.category !== state.filters.category) return false;

            // 3. Tier
            if (state.filters.tier !== 'All' && item.tier !== state.filters.tier) return false;

            // 4. Product Type
            if (state.filters.type !== 'All' && item.type !== state.filters.type) return false;

            // 5. Sterile
            if (state.filters.sterile !== 'All') {
                const wantSterile = state.filters.sterile === 'Sterile';
                // If filtering for Sterile, item must have at least one sterile SKU
                // If filtering for Non-Sterile, item must have at least one non-sterile SKU (or all non-sterile?)
                // Simplified: If 'Sterile' selected, show items that ARE sterile. 
                // Using 'filters.sterile' boolean from PHP which is "is_any_sterile"
                if (wantSterile && !item.filters.sterile) return false;
                if (!wantSterile && item.filters.sterile) return false; // Strict? Or relaxed?
                // Let's assume strict separation for now or check individual SKUs
            }

            // 6. Size
            if (state.filters.size !== 'All') {
                if (!item.filters.sizes.includes(state.filters.size)) return false;
            }

            return true;
        });
    }

    function render() {
        const filtered = filterData();
        
        // Update Count
        resultsCount.textContent = `Showing ${filtered.length} results`;

        if (state.filters.category === 'Private Label Programs' && filtered.length === 0) {
           // Special Empty State handled in renderEmpty? Or Just show custom header?
           // Proceed to empty state but maybe inject Private Label Content
        }

        if (filtered.length === 0) {
            resultsContainer.innerHTML = renderEmpty();
            return;
        }

        if (state.view === 'grid') {
            resultsContainer.innerHTML = `<div class="catalog-grid-view">${filtered.map(renderCard).join('')}</div>`;
            bindCardEvents();
        } else {
            resultsContainer.innerHTML = renderTable(filtered);
        }
    }

    function renderEmpty() {
        return `
            <div class="catalog-empty">
                <h3>No matches found</h3>
                <p>Try adjusting your search or filters.</p>
                <button class="fl-reset-btn btn btn-secondary">Reset Filters</button>
            </div>
        `;
    }

    function renderCard(item) {
        const isPack = item.type === 'Pack/Kit';
        
        return `
            <article class="cat-card">
                <div class="cat-card__header">
                    <div class="cat-badges">
                        <span class="badge badge--${item.tier.toLowerCase()}">${item.tier}</span>
                        <span class="badge badge--cat">${item.category}</span>
                    </div>
                    <h4>${item.name}</h4>
                </div>
                
                <div class="cat-card__specs">
                    <div class="spec-row">
                        <span>Code:</span> <strong>${item.filters.codes[0] || '-'}</strong>
                    </div>
                    <div class="spec-row">
                        <span>Sterile:</span> <strong>${item.filters.sterile ? 'Yes' : 'No'}</strong>
                    </div>
                </div>

                <div class="cat-card__body">
                    <p class="cat-desc">${item.description.substring(0, 100)}...</p>
                    
                    <details class="cat-details">
                        <summary>View Details</summary>
                        <div class="cat-details-inner">
                            ${item.content_html}
                            
                            ${renderSkuTable(item.skus)}
                        </div>
                    </details>
                </div>
            </article>
        `;
    }

    function renderSkuTable(skus) {
        return `
            <table class="sku-mini-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Size</th>
                        <th>H. Code</th>
                    </tr>
                </thead>
                <tbody>
                    ${skus.map(s => `
                        <tr>
                            <td>${s.code}</td>
                            <td>${s.size}</td>
                            <td>${s.health_code}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    function renderTable(items) {
        return `
            <div class="catalog-table-wrapper">
                <table class="catalog-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Size</th>
                            <th>Sterile</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items.map(item => `
                            <tr>
                                <td><strong>${item.name}</strong></td>
                                <td>${item.filters.codes[0]}</td>
                                <td>${item.category}</td>
                                <td>${item.filters.sizes.join(', ')}</td>
                                <td>${item.filters.sterile ? 'Yes' : 'No'}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    function bindCardEvents() {
         // Re-bind resets inside empty state if needed
         const freshResets = resultsContainer.querySelectorAll('.fl-reset-btn');
         freshResets.forEach(btn => btn.addEventListener('click', () => resetFilters()));
    }

});
