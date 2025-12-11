<?php
/**
 * Child theme setup and utilities.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('florence_child_is_woo_view')) {
    function florence_child_is_woo_view(): bool
    {
        if (!function_exists('is_woocommerce')) {
            return false;
        }

        return is_woocommerce() || is_cart() || is_checkout() || is_account_page();
    }
}

if (!function_exists('florence_child_is_rfq_endpoint')) {
    function florence_child_is_rfq_endpoint(): bool
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        return in_array($path, ['request-quote', 'request-samples'], true);
    }

    function florence_child_current_path(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/';
        return $path;
    }
}

add_action('after_setup_theme', function (): void {
    load_child_theme_textdomain('florence-static-child', get_stylesheet_directory() . '/languages');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

add_action('widgets_init', function (): void {
    register_sidebar([
        'name'          => __('Shop Filters Sidebar', 'florence-static-child'),
        'id'            => 'shop-filters',
        'description'   => __('Sidebar used on product archive pages for layered navigation widgets.', 'florence-static-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
});

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style(
        'florence-static-child',
        get_stylesheet_uri(),
        [],
        time() // Forced cache busting
    );

    if (florence_child_is_woo_view()) {
        $asset_path = get_stylesheet_directory() . '/assets/css/products.css';
        wp_enqueue_style(
            'florence-products',
            get_stylesheet_directory_uri() . '/assets/css/products.css',
            [],
            file_exists($asset_path) ? filemtime($asset_path) : wp_get_theme()->get('Version')
        );
    }
});

add_filter('request', function (array $vars): array {
    if (!is_admin() && isset($_GET['product']) && florence_child_is_rfq_endpoint()) { // phpcs:ignore WordPress.Security.NonceVerification
        unset($vars['product']);
    }

    return $vars;
});

add_action('template_redirect', function (): void {
    if (!florence_child_is_rfq_endpoint()) {
        return;
    }

    if (!isset($_GET['product']) || isset($_GET['rfq_product'])) { // phpcs:ignore WordPress.Security.NonceVerification
        return;
    }

    $product_id = absint($_GET['product']); // phpcs:ignore WordPress.Security.NonceVerification
    $target = add_query_arg(['rfq_product' => $product_id], home_url(florence_child_current_path()));
    wp_safe_redirect($target);
    exit;
});
