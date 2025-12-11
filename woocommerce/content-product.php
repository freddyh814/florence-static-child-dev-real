<?php
/**
 * Loop product card.
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$badges = [];
$badge_map = [
    'pa_aami-level' => __('AAMI Level', 'florence-static-child'),
    'pa_sterility'  => __('Sterility', 'florence-static-child'),
    'pa_astm-f2100' => __('ASTM F2100', 'florence-static-child'),
];

foreach ($badge_map as $taxonomy => $label) {
    $terms = wc_get_product_terms($product->get_id(), $taxonomy, ['fields' => 'names']);
    if ($terms) {
        $badges[] = $label . ': ' . $terms[0];
    }
}
?>
<li <?php wc_product_class('woo-grid-card', $product); ?>>
    <a href="<?php the_permalink(); ?>" class="woo-card-media">
        <?php echo $product->get_image(); ?>
    </a>
    <div class="woo-card-body">
        <h2 class="woocommerce-loop-product__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ($badges) : ?>
            <ul class="woo-badges">
                <?php foreach ($badges as $badge) : ?>
                    <li class="woo-badge"><?php echo esc_html($badge); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="woo-card-actions">
            <a class="button" href="<?php echo esc_url(add_query_arg('product', $product->get_id(), florence_child_get_rfq_url())); ?>"><?php esc_html_e('Request Quote', 'florence-static-child'); ?></a>
        </div>
    </div>
</li>
