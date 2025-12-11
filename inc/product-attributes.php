<?php
/**
 * Ensure product taxonomies/attributes exist for the medical catalog.
 */

if (!defined('ABSPATH')) {
    exit;
}

function florence_child_ensure_catalog_entities(): void
{
    if (!class_exists('WooCommerce')) {
        return;
    }

    $categories = [
        'gowns'       => __('Gowns', 'florence-static-child'),
        'drapes'      => __('Drapes', 'florence-static-child'),
        'masks'       => __('Masks', 'florence-static-child'),
        'packs'       => __('Packs', 'florence-static-child'),
        'accessories' => __('Accessories', 'florence-static-child'),
    ];

    foreach ($categories as $slug => $name) {
        if (!term_exists($slug, 'product_cat')) {
            wp_insert_term($name, 'product_cat', ['slug' => $slug]);
        }
    }

    $attributes = [
        'aami-level' => [
            'label' => __('AAMI Level', 'florence-static-child'),
            'terms' => ['1', '2', '3', '4'],
        ],
        'astm-f2100' => [
            'label' => __('ASTM F2100', 'florence-static-child'),
            'terms' => ['Level 1', 'Level 2', 'Level 3'],
        ],
        'sterility' => [
            'label' => __('Sterility', 'florence-static-child'),
            'terms' => ['Sterile', 'Non-sterile'],
        ],
        'material' => [
            'label' => __('Material', 'florence-static-child'),
            'terms' => ['SMS', 'SMMS', 'PP/PE', 'Polypropylene', 'Polyethylene'],
        ],
        'sizes' => [
            'label' => __('Sizes', 'florence-static-child'),
            'terms' => ['S', 'M', 'L', 'XL', 'XXL'],
        ],
        'latex-free' => [
            'label' => __('Latex Free', 'florence-static-child'),
            'terms' => ['Yes', 'No'],
        ],
        'color' => [
            'label' => __('Color', 'florence-static-child'),
            'terms' => ['Blue', 'Yellow', 'Green', 'White'],
        ],
        'compliance' => [
            'label' => __('Compliance', 'florence-static-child'),
            'terms' => ['ISO 13485', 'COFEPRIS', 'FDA Initial Importer', 'FDA 510(k)'],
        ],
    ];

    foreach ($attributes as $slug => $config) {
        $taxonomy = 'pa_' . $slug;
        $attribute_id = wc_attribute_taxonomy_id_by_name($taxonomy);

        if (!$attribute_id) {
            $attribute_id = wc_create_attribute([
                'slug'         => $slug,
                'name'         => $config['label'],
                'type'         => 'select',
                'order_by'     => 'menu_order',
                'has_archives' => true,
            ]);
        }

        if (is_wp_error($attribute_id)) {
            continue;
        }

        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
            'fields'     => 'names',
        ]);
        $existing = is_wp_error($terms) ? [] : $terms;

        foreach ($config['terms'] as $term_name) {
            if (!in_array($term_name, $existing, true)) {
                wp_insert_term($term_name, $taxonomy);
            }
        }
    }
}

add_action('init', 'florence_child_ensure_catalog_entities', 15);
