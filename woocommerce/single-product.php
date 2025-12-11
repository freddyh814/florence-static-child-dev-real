<?php
/**
 * Single product layout.
 */

defined('ABSPATH') || exit;

global $product;

get_header('shop');
?>
<div class="single-product-wrapper">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php do_action('woocommerce_before_single_product'); ?>
        <?php $product = wc_get_product(get_the_ID()); ?>
        <article id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
            <div class="single-product-hero">
                <div class="single-product-gallery">
                    <?php
                    if (function_exists('woocommerce_show_product_images')) {
                        woocommerce_show_product_images();
                    } else {
                        echo $product->get_image('large');
                    }
                    ?>
                </div>
                <div class="single-product-summary">
                    <h1><?php the_title(); ?></h1>
                    <p class="product-excerpt"><?php echo wp_kses_post(get_the_excerpt()); ?></p>
                    <div class="woo-badges">
                        <?php
                        $badge_taxonomies = [
                            'pa_compliance'  => __('Compliance', 'florence-static-child'),
                            'pa_aami-level'  => __('AAMI Level', 'florence-static-child'),
                            'pa_astm-f2100'  => __('ASTM F2100', 'florence-static-child'),
                        ];
                        foreach ($badge_taxonomies as $taxonomy => $label) {
                            $terms = wc_get_product_terms($product->get_id(), $taxonomy, ['fields' => 'names']);
                            if ($terms) {
                                echo '<span class="woo-badge">' . esc_html($label . ': ' . implode(', ', $terms)) . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <div class="single-product-cta">
                        <a class="button" href="<?php echo esc_url(add_query_arg('product', $product->get_id(), florence_child_get_rfq_url())); ?>"><?php esc_html_e('Request Quote', 'florence-static-child'); ?></a>
                        <a class="button button-secondary" href="<?php echo esc_url(add_query_arg('product', $product->get_id(), florence_child_get_samples_url())); ?>"><?php esc_html_e('Request Samples', 'florence-static-child'); ?></a>
                    </div>
                </div>
            </div>

            <?php
            $spec_fields = [
                'model_number'          => __('Model Number', 'florence-static-child'),
                'udi_di'                => __('UDI-DI', 'florence-static-child'),
                'hts_code'              => __('HTS Code', 'florence-static-child'),
                'country_of_origin'     => __('Country of Origin', 'florence-static-child'),
                'unit_packaging'        => __('Unit Packaging', 'florence-static-child'),
                'case_quantity'         => __('Case Quantity', 'florence-static-child'),
                'fluid_resistance_mmHg' => __('Fluid Resistance (mmHg)', 'florence-static-child'),
                'bfe_percent'           => __('BFE (%)', 'florence-static-child'),
                'pfe_percent'           => __('PFE (%)', 'florence-static-child'),
                'shelf_life_months'     => __('Shelf Life (Months)', 'florence-static-child'),
                'usmca_qualified'       => __('USMCA Qualified', 'florence-static-child'),
            ];
            $spec_items = [];
            foreach ($spec_fields as $meta_key => $label) {
                $value = $product->get_meta($meta_key);
                if ($value !== '' && $value !== null) {
                    $spec_items[] = [
                        'label' => $label,
                        'value' => 'usmca_qualified' === $meta_key
                            ? (($value) ? __('Yes', 'florence-static-child') : __('No', 'florence-static-child'))
                            : $value,
                    ];
                }
            }
            ?>
            <?php if ($spec_items) : ?>
                <section class="product-spec-grid">
                    <?php foreach ($spec_items as $spec) : ?>
                        <div class="spec-item">
                            <div class="spec-label"><?php echo esc_html($spec['label']); ?></div>
                            <div class="spec-value"><?php echo esc_html($spec['value']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php
            $download_map = [
                'datasheet_pdf' => __('Datasheet', 'florence-static-child'),
                'ifu_pdf'       => __('IFU', 'florence-static-child'),
                'coa_pdf'       => __('COA', 'florence-static-child'),
                'sds_pdf'       => __('SDS', 'florence-static-child'),
                'usmca_co_pdf'  => __('USMCA Certificate', 'florence-static-child'),
            ];
            $downloads = [];
            foreach ($download_map as $meta_key => $label) {
                $attachment_id = (int) $product->get_meta($meta_key);
                if ($attachment_id) {
                    $url = wp_get_attachment_url($attachment_id);
                    if ($url) {
                        $downloads[] = ['label' => $label, 'url' => $url];
                    }
                }
            }
            ?>
            <?php if ($downloads) : ?>
                <div class="product-downloads">
                    <?php foreach ($downloads as $file) : ?>
                        <a class="button button-secondary" href="<?php echo esc_url($file['url']); ?>" target="_blank" rel="noopener">
                            <?php echo esc_html($file['label']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php woocommerce_output_product_data_tabs(); ?>
            <?php woocommerce_related_products(['posts_per_page' => 3, 'columns' => 3]); ?>
        </article>
        <?php do_action('woocommerce_after_single_product'); ?>
    <?php endwhile; ?>
</div>
<?php
get_footer('shop');
