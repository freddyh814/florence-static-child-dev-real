<?php
/**
 * Catalog-only behaviors (no pricing or cart actions).
 */

if (!defined('ABSPATH')) {
    exit;
}

function florence_child_get_rfq_url(): string
{
    return home_url('/request-quote/');
}

function florence_child_get_samples_url(): string
{
    return home_url('/request-samples/');
}

add_filter('woocommerce_get_price_html', '__return_empty_string');
add_filter('woocommerce_variable_price_html', '__return_empty_string');
add_filter('woocommerce_grouped_price_html', '__return_empty_string');
add_filter('woocommerce_price_html', '__return_empty_string');
add_filter('woocommerce_cart_item_price', '__return_empty_string');
add_filter('woocommerce_cart_item_subtotal', '__return_empty_string');
add_filter('woocommerce_is_purchasable', '__return_false');
add_filter('woocommerce_widget_cart_is_hidden', '__return_true');

add_action('init', function (): void {
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
});

add_action('template_redirect', function (): void {
    $redirect_url = florence_child_get_rfq_url();

    if (function_exists('is_cart') && is_cart()) {
        wp_safe_redirect($redirect_url, 301);
        exit;
    }

    if (function_exists('is_checkout') && is_checkout()) {
        wp_safe_redirect($redirect_url, 301);
        exit;
    }

    if (!empty($_REQUEST['add-to-cart'])) { // phpcs:ignore WordPress.Security.NonceVerification
        $product_id = absint($_REQUEST['add-to-cart']); // phpcs:ignore WordPress.Security.NonceVerification
        $url = add_query_arg('product', $product_id, $redirect_url);
        wp_safe_redirect($url);
        exit;
    }
});

add_filter('woocommerce_add_to_cart_validation', function ($passed, $product_id, $quantity) {
    if (function_exists('wc_add_notice')) {
        wc_add_notice(__('Purchasing is disabled. Please request a quote.', 'florence-static-child'), 'notice');
    }

    return false;
}, 10, 3);
