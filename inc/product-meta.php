<?php
/**
 * Custom product meta registration and admin UX.
 */

if (!defined('ABSPATH')) {
    exit;
}

function florence_child_get_product_meta_schema(): array
{
    return [
        'model_number'          => ['type' => 'string'],
        'udi_di'                => ['type' => 'string'],
        'hts_code'              => ['type' => 'string'],
        'country_of_origin'     => ['type' => 'string'],
        'usmca_qualified'       => ['type' => 'boolean'],
        'unit_packaging'        => ['type' => 'string'],
        'case_quantity'         => ['type' => 'integer'],
        'fluid_resistance_mmHg' => ['type' => 'number'],
        'bfe_percent'           => ['type' => 'number'],
        'pfe_percent'           => ['type' => 'number'],
        'shelf_life_months'     => ['type' => 'number'],
        'datasheet_pdf'         => ['type' => 'integer'],
        'ifu_pdf'               => ['type' => 'integer'],
        'coa_pdf'               => ['type' => 'integer'],
        'sds_pdf'               => ['type' => 'integer'],
        'usmca_co_pdf'          => ['type' => 'integer'],
    ];
}

function florence_child_register_product_meta(): void
{
    foreach (florence_child_get_product_meta_schema() as $meta_key => $schema) {
        register_post_meta('product', $meta_key, [
            'single'            => true,
            'type'              => $schema['type'],
            'show_in_rest'      => true,
            'default'           => null,
            'sanitize_callback' => static function ($value) use ($schema) {
                switch ($schema['type']) {
                    case 'integer':
                        return $value === '' ? null : (int) $value;
                    case 'number':
                        return $value === '' ? null : (float) $value;
                    case 'boolean':
                        return (bool) $value;
                    case 'string':
                    default:
                        return $value === '' ? '' : sanitize_text_field($value);
                }
            },
            'auth_callback'     => static function () {
                return current_user_can('edit_products');
            },
        ]);
    }
}
add_action('init', 'florence_child_register_product_meta');

function florence_child_product_data_tab(array $tabs): array
{
    $tabs['florence_regulatory'] = [
        'label'    => __('Regulatory & Specs', 'florence-static-child'),
        'target'   => 'florence_regulatory_data',
        'class'    => ['hide_if_grouped'],
        'priority' => 70,
    ];

    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'florence_child_product_data_tab');

function florence_child_render_regulatory_panel(): void
{
    echo '<div id="florence_regulatory_data" class="panel woocommerce_options_panel">';
    echo '<div class="options_group">';

    foreach (florence_child_get_product_meta_schema() as $meta_key => $schema) {
        $field_label = ucwords(str_replace(['_', 'pdf'], [' ', 'PDF'], $meta_key));
        $value = get_post_meta(get_the_ID(), $meta_key, true);

        $args = [
            'id'          => $meta_key,
            'label'       => $field_label,
            'value'       => $value,
            'description' => '',
            'desc_tip'    => false,
        ];

        if ('boolean' === $schema['type']) {
            woocommerce_wp_checkbox(
                array_merge($args, [
                    'value'   => (bool) $value ? 'yes' : 'no',
                    'cbvalue' => 'yes',
                ])
            );
        } elseif ('integer' === $schema['type'] || 'number' === $schema['type']) {
            $attributes = 'integer' === $schema['type'] ? ['step' => 1] : [];
            woocommerce_wp_text_input(
                array_merge($args, [
                    'type'              => 'number',
                    'custom_attributes' => $attributes,
                ])
            );
        } else {
            woocommerce_wp_text_input($args);
        }
    }

    echo '</div></div>';
}
add_action('woocommerce_product_data_panels', 'florence_child_render_regulatory_panel');

function florence_child_save_regulatory_meta(WC_Product $product): void
{
    foreach (florence_child_get_product_meta_schema() as $meta_key => $schema) {
        $raw = $_POST[$meta_key] ?? null; // phpcs:ignore WordPress.Security.NonceVerification

        if ('boolean' === $schema['type']) {
            $product->update_meta_data(
                $meta_key,
                (isset($_POST[$meta_key]) && 'yes' === $raw) ? 1 : 0 // phpcs:ignore WordPress.Security.NonceVerification
            );
            continue;
        }

        if (null === $raw || $raw === '') {
            $product->delete_meta_data($meta_key);
            continue;
        }

        if ('integer' === $schema['type']) {
            $product->update_meta_data($meta_key, (int) $raw);
        } elseif ('number' === $schema['type']) {
            $product->update_meta_data($meta_key, (float) $raw);
        } else {
            $product->update_meta_data($meta_key, sanitize_text_field($raw));
        }
    }
}
add_action('woocommerce_admin_process_product_object', 'florence_child_save_regulatory_meta');

function florence_child_product_columns(array $columns): array
{
    $new_columns = [];

    foreach ($columns as $key => $label) {
        if ('cb' === $key) {
            $new_columns[$key] = $label;
            continue;
        }

        if ('name' === $key) {
            $new_columns[$key] = $label;
            $new_columns['sku'] = __('SKU', 'florence-static-child');
            $new_columns['product_cat'] = __('Category', 'florence-static-child');
            $new_columns['aami_level'] = __('AAMI Level', 'florence-static-child');
            $new_columns['compliance'] = __('Compliance', 'florence-static-child');
            $new_columns['usmca'] = __('USMCA Qualified', 'florence-static-child');
            $new_columns['modified'] = __('Last Updated', 'florence-static-child');
            continue;
        }
    }

    return $new_columns;
}
add_filter('manage_edit-product_columns', 'florence_child_product_columns');

function florence_child_product_custom_column(string $column, int $post_id): void
{
    switch ($column) {
        case 'sku':
            $sku = get_post_meta($post_id, '_sku', true);
            echo $sku ? esc_html($sku) : esc_html__('—', 'florence-static-child');
            break;
        case 'product_cat':
            $terms = get_the_term_list($post_id, 'product_cat', '', ', ');
            echo $terms ? $terms : esc_html__('—', 'florence-static-child');
            break;
        case 'aami_level':
            $terms = wp_get_post_terms($post_id, 'pa_aami-level');
            echo $terms ? esc_html($terms[0]->name) : esc_html__('—', 'florence-static-child');
            break;
        case 'compliance':
            $terms = wp_get_post_terms($post_id, 'pa_compliance');
            echo $terms ? esc_html($terms[0]->name) : esc_html__('—', 'florence-static-child');
            break;
        case 'usmca':
            $value = (bool) get_post_meta($post_id, 'usmca_qualified', true);
            echo $value ? esc_html__('Yes', 'florence-static-child') : esc_html__('No', 'florence-static-child');
            break;
        case 'modified':
            $modified = get_post_field('post_modified', $post_id);
            echo esc_html(mysql2date(get_option('date_format') . ' ' . get_option('time_format'), $modified));
            break;
    }
}
add_action('manage_product_posts_custom_column', 'florence_child_product_custom_column', 10, 2);
