<?php
$products_count = wp_count_posts( 'fl_product' )->publish ?? 0;
$quotes_count   = wp_count_posts( 'fl_quote_request' )->publish ?? 0;
$samples_count  = wp_count_posts( 'fl_sample_request' )->publish ?? 0;
$orders_count   = wp_count_posts( 'fl_purchase_order' )->publish ?? 0;
?>
<section class="portal-section">
    <h1><?php esc_html_e( 'Portal Dashboard', 'florence-static' ); ?></h1>
    <div class="portal-grid portal-grid--stats">
        <article class="portal-card portal-card--stat">
            <p><?php esc_html_e( 'Products', 'florence-static' ); ?></p>
            <strong><?php echo esc_html( $products_count ); ?></strong>
        </article>
        <article class="portal-card portal-card--stat">
            <p><?php esc_html_e( 'Quotes', 'florence-static' ); ?></p>
            <strong><?php echo esc_html( $quotes_count ); ?></strong>
        </article>
        <article class="portal-card portal-card--stat">
            <p><?php esc_html_e( 'Samples', 'florence-static' ); ?></p>
            <strong><?php echo esc_html( $samples_count ); ?></strong>
        </article>
        <article class="portal-card portal-card--stat">
            <p><?php esc_html_e( 'Purchase Orders', 'florence-static' ); ?></p>
            <strong><?php echo esc_html( $orders_count ); ?></strong>
        </article>
    </div>
    <div class="portal-grid">
        <article class="portal-card">
            <h2><?php esc_html_e( 'Quick Links', 'florence-static' ); ?></h2>
            <ul class="portal-quick-links">
                <li><a href="<?php echo esc_url( site_url( '/portal/products' ) ); ?>"><?php esc_html_e( 'Browse products', 'florence-static' ); ?></a></li>
                <li><a href="<?php echo esc_url( site_url( '/portal/documents' ) ); ?>"><?php esc_html_e( 'Compliance library', 'florence-static' ); ?></a></li>
                <li><a href="<?php echo esc_url( site_url( '/portal/quotes/new' ) ); ?>"><?php esc_html_e( 'Request a quote', 'florence-static' ); ?></a></li>
                <li><a href="<?php echo esc_url( site_url( '/portal/samples/new' ) ); ?>"><?php esc_html_e( 'Request samples', 'florence-static' ); ?></a></li>
            </ul>
        </article>
        <article class="portal-card">
            <h2><?php esc_html_e( 'Recent Documents', 'florence-static' ); ?></h2>
            <?php
            $recent_docs = get_posts(
                [
                    'post_type'      => 'fl_compliance_doc',
                    'posts_per_page' => 5,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]
            );
            if ( $recent_docs ) : ?>
                <ul class="portal-doc-list">
                    <?php foreach ( $recent_docs as $doc ) : ?>
                        <li>
                            <strong><?php echo esc_html( get_the_title( $doc ) ); ?></strong>
                            <span><?php echo esc_html( get_the_date( '', $doc ) ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p><?php esc_html_e( 'Documents will appear here once uploaded.', 'florence-static' ); ?></p>
            <?php endif; ?>
        </article>
    </div>
</section>
