<?php
/**
 * Template Name: Catalog Hub
 * Template Post Type: page
 */

get_header();

// Fetch Data Using Helper
$catalog_data = Florence_Catalog::get_catalog_data();

// Extract unique values for Filters
$all_sizes = [];
$all_types = [];
foreach ($catalog_data as $p) {
    if (!empty($p['filters']['sizes']))
        $all_sizes = array_merge($all_sizes, $p['filters']['sizes']);
    if (!empty($p['type']))
        $all_types[] = $p['type'];
}
$all_sizes = array_unique($all_sizes);
sort($all_sizes);
$all_types = array_unique($all_types);
sort($all_types);

// Serialize for JS
$json_data = json_encode($catalog_data);
?>

<script>
    window.FL_CATALOG_DATA = <?php echo $json_data; ?>;
</script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/catalog-app.js" defer></script>

<main class="florence-page florence-catalog-hub">

    <!-- Hero + Search -->
    <section class="catalog-hero">
        <div class="container">
            <h1>Products</h1>
            <p class="subtext">Search by product name, code, size, sterile status, or health sector code.</p>

            <div class="catalog-search-wrapper">
                <input type="text" id="fl-search-input"
                    placeholder="Search products (e.g., 'Surgical gown', '310130', 'XL', 'sterile')" autocomplete="off">
                <button id="fl-search-clear" class="search-clear" aria-label="Clear search">&times;</button>
            </div>
        </div>
    </section>

    <!-- Controls -->
    <section class="catalog-controls">
        <div class="container">
            <div class="filters-bar">

                <div class="filter-group">
                    <label>Category</label>
                    <div class="select-wrapper">
                        <select id="filter-category">
                            <option value="All">All Categories</option>
                            <option value="Isolation & Surgical Gowns">Isolation & Surgical Gowns</option>
                            <option value="Face Masks & Respiratory">Face Masks & Respiratory</option>
                            <option value="Drapes & Procedure Packs">Drapes & Procedure Packs</option>
                            <option value="Gloves & Accessories">Gloves & Accessories</option>
                            <option value="Private Label Programs">Private Label Programs</option>
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Tier</label>
                    <div class="select-wrapper">
                        <select id="filter-tier">
                            <option value="All">All Tiers</option>
                            <option value="Standard">Standard</option>
                            <option value="Premium">Premium</option>
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Sterile</label>
                    <div class="select-wrapper">
                        <select id="filter-sterile">
                            <option value="All">Any</option>
                            <option value="Sterile">Yes</option>
                            <option value="Non-Sterile">No</option>
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Size</label>
                    <div class="select-wrapper">
                        <select id="filter-size">
                            <option value="All">All Sizes</option>
                            <?php foreach ($all_sizes as $s): ?>
                                <option value="<?php echo esc_attr($s); ?>">
                                    <?php echo esc_html($s); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button class="fl-reset-btn btn-link">Reset filters</button>
            </div>

            <div class="results-meta">
                <span id="fl-results-count">Showing 0 results</span>

                <div class="view-toggle-wrapper">
                    <span>Card</span>
                    <label class="switch">
                        <input type="checkbox" id="fl-view-toggle">
                        <span class="slider round"></span>
                    </label>
                    <span>Table</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Results -->
    <section class="catalog-results" id="fl-catalog-root">
        <div class="container" id="fl-results-container">
            <!-- JS Renders here -->
            <div class="catalog-loader">Loading catalog...</div>
        </div>
    </section>

</main>

<?php get_footer(); ?>