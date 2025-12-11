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
    <h1><?php esc_html_e( 'Request a Quote', 'florence-static' ); ?></h1>
    <form class="portal-card" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="portal_quote" />
        <?php wp_nonce_field( 'portal_quote', 'portal_nonce' ); ?>
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
        <label><?php esc_html_e( 'Notes / requirements', 'florence-static' ); ?>
            <textarea name="notes" rows="4"></textarea>
        </label>
        <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Submit request', 'florence-static' ); ?></button>
        <a class="btn btn-secondary" href="<?php echo esc_url( site_url( '/portal/quotes' ) ); ?>"><?php esc_html_e( 'Back to quotes', 'florence-static' ); ?></a>
    </form>
</section>
