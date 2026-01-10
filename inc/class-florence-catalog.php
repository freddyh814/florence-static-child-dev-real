<?php
/**
 * Class Florence_Catalog
 * Handles data fetching and normalization for the JS-powered catalog.
 */

class Florence_Catalog
{

    /**
     * Map internal slugs/keywords to frontend Categories.
     */
    private static $category_map = [
        'gowns' => 'Isolation & Surgical Gowns',
        'masks' => 'Face Masks & Respiratory',
        'packs' => 'Drapes & Procedure Packs',
        'access' => 'Gloves & Accessories',
        'private' => 'Private Label Programs',
    ];

    /**
     * Get the full catalog dataset as an array.
     */
    public static function get_catalog_data()
    {
        $products = [];

        // 1. Fetch all 'fl_catalog_family' posts
        $args = [
            'post_type' => 'fl_catalog_family',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $slug = get_post_field('post_name', $post_id);
                $title = get_the_title();
                $content = get_the_content();

                // Get Family Metadata
                $headers_str = get_post_meta($post_id, '_fl_spec_headers', true);
                $rows_str = get_post_meta($post_id, '_fl_spec_rows', true); // Newline separated JSON strings

                // Determine Category & Tier from Terms or Slug
                $terms = get_the_terms($post_id, 'fl_catalog_category');
                $term_slug = $terms && !is_wp_error($terms) ? $terms[0]->slug : '';

                $category = self::infer_category($term_slug, $slug);
                $tier = strpos($term_slug, 'premium') !== false || strpos($slug, 'premium') !== false ? 'Premium' : 'Standard';

                // Parse Rows (SKUs)
                $skus = [];
                if ($rows_str) {
                    $lines = explode("\n", $rows_str);
                    $headers = array_map('trim', explode(',', $headers_str));

                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (empty($line))
                            continue;

                        // Decode the JSON array string: ["202321","060...","✓","S","30"]
                        $row_data = json_decode($line, true);
                        if (!is_array($row_data))
                            continue;

                        // Create a map of Header -> Value
                        $sku_map = [];
                        foreach ($headers as $index => $h_name) {
                            if (isset($row_data[$index])) {
                                $sku_map[strtolower($h_name)] = $row_data[$index];
                            }
                        }

                        // Extract normalized fields
                        $code = isset($sku_map['código']) ? $sku_map['código'] : (isset($sku_map['código']) ? $sku_map['código'] : ''); // utf8 check?
                        if (empty($code) && isset($sku_map['codigo']))
                            $code = $sku_map['codigo']; // fallback

                        $sterile_val = isset($sku_map['estéril']) ? $sku_map['estéril'] : (isset($sku_map['esteril']) ? $sku_map['esteril'] : 'X');
                        $is_sterile = ($sterile_val === '✓' || $sterile_val === '√' || strtolower($sterile_val) === 'si' || strtolower($sterile_val) === 'yes');

                        $size = isset($sku_map['talla']) ? $sku_map['talla'] : (isset($sku_map['medida']) ? $sku_map['medida'] : 'One Size');
                        $gsm = isset($sku_map['gsm']) ? $sku_map['gsm'] : '';
                        $h_code = isset($sku_map['clave sector salud']) ? $sku_map['clave sector salud'] : '';
                        if ($h_code === '—')
                            $h_code = '';

                        $skus[] = [
                            'code' => $code,
                            'sterile' => $is_sterile,
                            'size' => $size,
                            'gsm' => $gsm,
                            'health_code' => $h_code
                        ];
                    }
                }

                // If no SKUs, skip product (or handle as "Coming Soon")
                if (empty($skus))
                    continue;

                // Flatten for Search: Add each SKU as a searchable entry or Aggregate?
                // Request asks for "Product Results", so one card per Product Family, expanding to see specs.
                // But filters need to work. So we attach all metadata to the Product Family.

                $all_sizes = array_unique(array_column($skus, 'size'));
                $all_codes = array_column($skus, 'code');
                $is_any_sterile = in_array(true, array_column($skus, 'sterile'));

                $products[] = [
                    'id' => $post_id,
                    'name' => $title,
                    'category' => $category,
                    'tier' => $tier,
                    'type' => self::infer_type($category, $title),
                    'description' => strip_tags($content), // Plain text for search
                    'content_html' => $content, // For display
                    'skus' => $skus, // Full detailed list
                    'filters' => [
                        'sizes' => $all_sizes,
                        'codes' => $all_codes,
                        'sterile' => $is_any_sterile,
                    ]
                ];
            }
            wp_reset_postdata();
        }

        return $products;
    }

    /**
     * Infer 'Isolation & Surgical Gowns' etc from slug
     */
    private static function infer_category($term_slug, $post_slug)
    {
        $haystack = $term_slug . ' ' . $post_slug;

        if (strpos($haystack, 'bata') !== false || strpos($haystack, 'uniforme') !== false || strpos($haystack, 'ropa') !== false) {
            return 'Isolation & Surgical Gowns';
        }
        if (strpos($haystack, 'cubrebocas') !== false || strpos($haystack, 'respir') !== false) {
            return 'Face Masks & Respiratory';
        }
        if (strpos($haystack, 'paquete') !== false || strpos($haystack, 'kit') !== false || strpos($haystack, 'campo') !== false || strpos($haystack, 'sabana') !== false || strpos($haystack, 'drape') !== false) {
            return 'Drapes & Procedure Packs';
        }
        if (strpos($haystack, 'accesorio') !== false || strpos($haystack, 'gorro') !== false || strpos($haystack, 'bota') !== false || strpos($haystack, 'zapat') !== false) {
            return 'Gloves & Accessories';
        }
        if (strpos($haystack, 'esterilizacion') !== false || strpos($haystack, 'tyvek') !== false) {
            return 'Gloves & Accessories'; // Or create a new one? Map to Acc for now per scope, or leave "Accessories" generic.
        }

        return 'Other';
    }

    private static function infer_type($category, $title)
    {
        if (stripos($title, 'pack') !== false || stripos($title, 'set') !== false || stripos($title, 'kit') !== false || stripos($title, 'paquete') !== false) {
            return 'Pack/Kit';
        }
        if ($category === 'Isolation & Surgical Gowns')
            return 'Garment';
        if ($category === 'Face Masks & Respiratory')
            return 'Accessory'; // Mask is usually accessory or garment?
        if (stripos($title, 'drape') !== false || stripos($title, 'campo') !== false || stripos($title, 'sabana') !== false) {
            return 'Drape/Sheet';
        }
        return 'Accessory';
    }
}
