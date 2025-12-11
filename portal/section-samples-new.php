<?php
$products = get_posts(
    [
        'post_type'      => 'fl_product',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]
);
?>
<section class="portal-section">
    <h1><?php esc_html_e( 'Request Samples', 'florence-static' ); ?></h1>
    <form class="portal-card" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="portal_sample" />
        <?php wp_nonce_field( 'portal_sample', 'portal_nonce' ); ?>
        <div class="portal-grid portal-grid--form">
            <?php for ( $i = 0; $i < 3; $i++ ) : ?>
                <div>
                    <label><?php esc_html_e( 'Product', 'florence-static' ); ?>
                        <select name="product[]">
                            <option value=""><?php esc_html_e( 'Select product', 'florence-static' ); ?></option>
                            <?php foreach ( $products as $product ) : ?>
                                <option value="<?php echo esc_attr( $product->ID ); ?>"><?php echo esc_html( $product->post_title ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label><?php esc_html_e( 'Quantity', 'florence-static' ); ?>
                        <input type="number" name="quantity[]" min="0" />
                    </label>
                </div>
            <?php endfor; ?>
        </div>
        <label><?php esc_html_e( 'Notes / delivery details', 'florence-static' ); ?>
            <textarea name="notes" rows="4"></textarea>
        </label>
        <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Submit sample request', 'florence-static' ); ?></button>
        <a class="btn btn-secondary" href="<?php echo esc_url( site_url( '/portal/samples' ) ); ?>"><?php esc_html_e( 'Back to samples', 'florence-static' ); ?></a>
    </form>
</section>
