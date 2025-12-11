<?php
/**
 * Admin CSV exporter for medical data.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', function (): void {
    add_submenu_page(
        'edit.php?post_type=product',
        __('Export (Medical)', 'florence-static-child'),
        __('Export (Medical)', 'florence-static-child'),
        'manage_woocommerce',
        'florence-medical-export',
        'florence_child_render_export_page'
    );
});

function florence_child_render_export_page(): void
{
    if (!current_user_can('manage_woocommerce')) {
        wp_die(__('You do not have permission to export products.', 'florence-static-child'));
    }

    if (isset($_POST['florence_medical_export']) && check_admin_referer('florence_medical_export')) { // phpcs:ignore WordPress.Security.NonceVerification
        florence_child_stream_export_csv();
        exit;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Medical Product Export', 'florence-static-child'); ?></h1>
        <form method="post">
            <?php wp_nonce_field('florence_medical_export'); ?>
            <p><?php esc_html_e('Export all WooCommerce products with medical attributes and regulatory meta as CSV.', 'florence-static-child'); ?></p>
            <p><button class="button button-primary" name="florence_medical_export" value="1"><?php esc_html_e('Download CSV', 'florence-static-child'); ?></button></p>
        </form>
    </div>
    <?php
}

function florence_child_stream_export_csv(): void
{
    $filename = 'florence-medical-' . date('Ymd-Hi') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Pragma: no-cache');
    header('Expires: 0');

    $out = fopen('php://output', 'w');

    $meta_keys = array_keys(florence_child_get_product_meta_schema());
    $meta_headers = array_map(static function ($key) {
        return ucwords(str_replace('_', ' ', $key));
    }, $meta_keys);

    $attribute_map = [
        'pa_aami-level' => 'AAMI Level',
        'pa_astm-f2100' => 'ASTM F2100',
        'pa_sterility'  => 'Sterility',
        'pa_material'   => 'Material',
        'pa_sizes'      => 'Sizes',
        'pa_latex-free' => 'Latex Free',
        'pa_color'      => 'Color',
        'pa_compliance' => 'Compliance',
    ];

    $headers = array_merge(
        ['Product ID', 'Name', 'SKU', 'Categories'],
        array_values($attribute_map),
        $meta_headers
    );
    fputcsv($out, $headers);

    $products = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    foreach ($products as $product_post) {
        $product = wc_get_product($product_post->ID);
        if (!$product) {
            continue;
        }

        $row = [
            $product->get_id(),
            $product->get_name(),
            $product->get_sku(),
            implode(', ', wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'names'])),
        ];

        foreach ($attribute_map as $taxonomy => $label) {
            $terms = wp_get_post_terms($product->get_id(), $taxonomy, ['fields' => 'names']);
            $row[] = implode(', ', is_wp_error($terms) ? [] : $terms);
        }

        foreach ($meta_keys as $meta_key) {
            $row[] = $product->get_meta($meta_key);
        }

        fputcsv($out, $row);
    }

    fclose($out);
}
