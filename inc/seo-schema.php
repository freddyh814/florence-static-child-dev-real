<?php
/**
 * Schema adjustments for catalog-only mode.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('woocommerce_structured_data_product', function (array $data, WC_Product $product): array {
    if (isset($data['offers'])) {
        unset($data['offers']);
    }

    $meta_keys = [
        'fluid_resistance_mmHg' => __('Fluid Resistance (mmHg)', 'florence-static-child'),
        'bfe_percent'           => __('Bacterial Filtration Efficiency (%)', 'florence-static-child'),
        'pfe_percent'           => __('Particle Filtration Efficiency (%)', 'florence-static-child'),
        'unit_packaging'        => __('Unit Packaging', 'florence-static-child'),
        'case_quantity'         => __('Case Quantity', 'florence-static-child'),
    ];

    $additional = $data['additionalProperty'] ?? [];

    foreach ($meta_keys as $meta_key => $label) {
        $value = $product->get_meta($meta_key);
        if ($value !== '' && $value !== null) {
            $additional[] = [
                '@type' => 'PropertyValue',
                'name'  => $label,
                'value' => $value,
            ];
        }
    }

    if ($additional) {
        $data['additionalProperty'] = $additional;
    }

    return $data;
}, 10, 2);
