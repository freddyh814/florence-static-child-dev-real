<?php
/**
 * Product archive overrides.
 */

defined('ABSPATH') || exit;

get_header('shop');
?>
<?php $has_sidebar = is_active_sidebar('shop-filters'); ?>
<div class="woocommerce-archive-wrapper">
    <?php do_action('woocommerce_before_main_content'); ?>

    <header class="woocommerce-products-header">
        <h1 class="woocommerce-products-header__title"><?php woocommerce_page_title(); ?></h1>
        <?php do_action('woocommerce_archive_description'); ?>
    </header>

    <div class="request-filter-bar">
        <form method="get">
            <?php
            $search_query = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
            $selected_cat = isset($_GET['product_cat']) ? sanitize_text_field(wp_unslash($_GET['product_cat'])) : '';
            $selected_aami = isset($_GET['filter_pa_aami-level']) ? sanitize_text_field(wp_unslash($_GET['filter_pa_aami-level'])) : '';
            $selected_sterility = isset($_GET['filter_pa_sterility']) ? sanitize_text_field(wp_unslash($_GET['filter_pa_sterility'])) : '';
            $selected_astm = isset($_GET['filter_pa_astm-f2100']) ? sanitize_text_field(wp_unslash($_GET['filter_pa_astm-f2100'])) : '';
            $selected_sizes = isset($_GET['filter_pa_sizes']) ? sanitize_text_field(wp_unslash($_GET['filter_pa_sizes'])) : '';
            $selected_compliance = isset($_GET['filter_pa_compliance']) ? sanitize_text_field(wp_unslash($_GET['filter_pa_compliance'])) : '';
            ?>
            <input type="search" name="s" value="<?php echo esc_attr($search_query); ?>" placeholder="<?php esc_attr_e('Search products', 'florence-static-child'); ?>" />
            <?php
            wp_dropdown_categories([
                'taxonomy'        => 'product_cat',
                'name'            => 'product_cat',
                'value_field'     => 'slug',
                'selected'        => $selected_cat,
                'show_option_all' => __('All Categories', 'florence-static-child'),
                'hide_empty'      => false,
            ]);
            ?>
            <?php
            $filter_taxonomies = [
                'pa_aami-level'  => [$selected_aami, __('AAMI Level', 'florence-static-child'), 'filter_pa_aami-level'],
                'pa_sterility'   => [$selected_sterility, __('Sterility', 'florence-static-child'), 'filter_pa_sterility'],
                'pa_astm-f2100'  => [$selected_astm, __('ASTM Level', 'florence-static-child'), 'filter_pa_astm-f2100'],
                'pa_sizes'       => [$selected_sizes, __('Sizes', 'florence-static-child'), 'filter_pa_sizes'],
                'pa_compliance'  => [$selected_compliance, __('Compliance', 'florence-static-child'), 'filter_pa_compliance'],
            ];
            foreach ($filter_taxonomies as $taxonomy => $config) :
                [$selected_value, $label, $input_name] = $config;
                $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
                ?>
                <select name="<?php echo esc_attr($input_name); ?>">
                    <option value=""><?php echo esc_html($label); ?></option>
                    <?php if (!is_wp_error($terms)) : ?>
                        <?php foreach ($terms as $term) : ?>
                            <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($selected_value, $term->slug); ?>><?php echo esc_html($term->name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            <?php endforeach; ?>
            <?php
            $reserved_filters = [
                'filter_pa_aami-level',
                'filter_pa_sterility',
                'filter_pa_astm-f2100',
                'filter_pa_sizes',
                'filter_pa_compliance',
            ];
            foreach ($_GET as $key => $value) : // phpcs:ignore WordPress.Security.NonceVerification
                ?>
                <?php if (strpos($key, 'filter_') === 0 && !in_array($key, $reserved_filters, true)) : ?>
                    <?php
                    $clean_value = is_array($value)
                        ? implode(',', array_map('sanitize_text_field', wp_unslash($value)))
                        : sanitize_text_field(wp_unslash($value));
                    ?>
                    <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($clean_value); ?>" />
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit" class="button"><?php esc_html_e('Filter', 'florence-static-child'); ?></button>
        </form>
    </div>

    <div class="shop-layout <?php echo $has_sidebar ? 'has-sidebar' : 'no-sidebar'; ?>">
        <?php if ($has_sidebar) : ?>
            <aside class="shop-sidebar">
                <div class="shop-sidebar-wrapper">
                    <?php dynamic_sidebar('shop-filters'); ?>
                </div>
            </aside>
        <?php endif; ?>
        <main class="shop-grid">
            <?php if (woocommerce_product_loop()) : ?>
                <?php do_action('woocommerce_before_shop_loop'); ?>

                <?php woocommerce_product_loop_start(); ?>

                <?php while (have_posts()) : ?>
                    <?php the_post(); ?>
                    <?php do_action('woocommerce_shop_loop'); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action('woocommerce_after_shop_loop'); ?>
            <?php else : ?>
                <?php do_action('woocommerce_no_products_found'); ?>
            <?php endif; ?>
        </main>
    </div>

    <?php do_action('woocommerce_after_main_content'); ?>
</div>
<?php
get_footer('shop');
