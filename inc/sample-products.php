<?php
if (!defined('ABSPATH')) {
    exit;
}

function florence_child_seed_sample_products(): void
{
    if (defined('WP_CLI') && WP_CLI && !defined('FLORENCE_ALLOW_SAMPLE_SEED')) {
        return;
    }

    if (!function_exists('WC')) {
        return;
    }

    if (get_option('florence_child_samples_seeded')) {
        return;
    }

    update_option('florence_child_seed_last_attempt', current_time('mysql'), false);

    $products = [
        [
            'name'        => 'Isolation Gown — Level 2',
            'slug'        => 'isolation-gown-level-2',
            'sku'         => 'FM-IG-L2',
            'category'    => 'gowns',
            'image_id'    => 98,
            'short'       => 'Disposable SMS isolation gown with Level 2 reinforcement and knit cuffs.',
            'description' => 'SMS polypropylene gown with kimono sleeves, knit cuffs, and four belt ties for secure Level 2 protection.',
            'attributes'  => [
                'pa_aami-level'  => ['2'],
                'pa_sterility'   => ['non-sterile'],
                'pa_material'    => ['sms'],
                'pa_compliance'  => ['iso-13485', 'fda-initial-importer'],
            ],
            'meta'        => [
                'model_number'          => 'IG-L2-2025',
                'country_of_origin'     => 'Mexico',
                'unit_packaging'        => '10/pack, 10 packs/case',
                'case_quantity'         => 100,
                'usmca_qualified'       => 1,
                'fluid_resistance_mmHg' => 50,
                'datasheet_pdf'         => 97,
            ],
        ],
        [
            'name'        => 'Surgical Drape — Reinforced',
            'slug'        => 'surgical-drape-reinforced',
            'sku'         => 'FM-SD-R',
            'category'    => 'drapes',
            'image_id'    => 99,
            'short'       => 'Sterile SMMS drape with reinforced fenestration.',
            'description' => '90×180 cm drape featuring adhesive reinforcement, fluid control channel, and sterile barrier properties.',
            'attributes'  => [
                'pa_sterility'  => ['sterile'],
                'pa_material'   => ['smms'],
                'pa_compliance' => ['iso-13485', 'cofepris'],
            ],
            'meta'        => [
                'model_number'      => 'SD-R-90x180',
                'country_of_origin' => 'Mexico',
                'unit_packaging'    => '5/pack, 20 packs/case',
                'case_quantity'     => 100,
                'usmca_qualified'   => 1,
            ],
        ],
        [
            'name'        => 'Procedure Mask — ASTM F2100',
            'slug'        => 'procedure-mask-astm-f2100',
            'sku'         => 'FM-PM-A2',
            'category'    => 'masks',
            'image_id'    => 100,
            'short'       => 'ASTM Level 2 mask with melt-blown filtration and latex-free loops.',
            'description' => '3-ply polypropylene procedure mask offering >98% BFE/PFE, adjustable nose bridge, and latex-free comfort.',
            'attributes'  => [
                'pa_astm-f2100' => ['level-2'],
                'pa_latex-free' => ['yes'],
                'pa_compliance' => ['iso-13485'],
                'pa_color'      => ['blue'],
            ],
            'meta'        => [
                'model_number'          => 'PM-A2-050',
                'country_of_origin'     => 'Mexico',
                'unit_packaging'        => '50/box, 20 boxes/case',
                'case_quantity'         => 1000,
                'usmca_qualified'       => 1,
                'bfe_percent'           => 98,
                'pfe_percent'           => 98,
                'fluid_resistance_mmHg' => 120,
            ],
        ],
    ];

    foreach ($products as $data) {
        $product_id = wc_get_product_id_by_sku($data['sku']);
        $post_data = [
            'post_title'   => $data['name'],
            'post_name'    => $data['slug'],
            'post_type'    => 'product',
            'post_status'  => 'publish',
            'post_content' => $data['description'],
            'post_excerpt' => $data['short'],
        ];

        if ($product_id) {
            $post_data['ID'] = $product_id;
            wp_update_post($post_data);
        } else {
            $product_id = wp_insert_post($post_data);
        }

        if (is_wp_error($product_id) || !$product_id) {
            continue;
        }

        if (!empty($data['image_id'])) {
            set_post_thumbnail($product_id, (int) $data['image_id']);
        }

        if (!empty($data['category'])) {
            wp_set_object_terms($product_id, (array) $data['category'], 'product_cat', false);
        }

        $attribute_meta = [];
        $position = 0;
        foreach ($data['attributes'] as $taxonomy => $terms) {
            wp_set_object_terms($product_id, (array) $terms, $taxonomy, false);
            $attribute_meta[$taxonomy] = [
                'name'         => $taxonomy,
                'value'        => '',
                'position'     => $position++,
                'is_visible'   => 1,
                'is_variation' => 0,
                'is_taxonomy'  => 1,
            ];
        }

        update_post_meta($product_id, '_product_attributes', $attribute_meta);
        update_post_meta($product_id, '_visibility', 'visible');
        update_post_meta($product_id, '_stock_status', 'instock');
        update_post_meta($product_id, '_manage_stock', 'no');
        update_post_meta($product_id, '_sku', $data['sku']);
        update_post_meta($product_id, '_regular_price', '');
        update_post_meta($product_id, '_price', '');

        foreach ($data['meta'] as $meta_key => $value) {
            update_post_meta($product_id, $meta_key, $value);
        }
    }

    update_option('florence_child_samples_seeded', 1, false);
}
add_action('init', 'florence_child_seed_sample_products', 30);
