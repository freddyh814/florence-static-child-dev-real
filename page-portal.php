<?php
/**
 * Template Name: Florence Portal
 */

if ( ! is_user_logged_in() ) {
    wp_safe_redirect( site_url( '/portal/login' ) );
    exit;
}

get_header();

$section    = get_query_var( 'portal_section' ) ?: 'dashboard';
$item_slug  = get_query_var( 'portal_item' );
$current    = wp_get_current_user();
$is_internal = florence_portal_is_internal( $current );

$nav_items = [
    'dashboard' => __( 'Dashboard', 'florence-static' ),
    'products'  => __( 'Products', 'florence-static' ),
    'documents' => __( 'Documents', 'florence-static' ),
    'quotes'    => __( 'Quotes', 'florence-static' ),
    'samples'   => __( 'Samples', 'florence-static' ),
    'orders'    => __( 'Orders / POs', 'florence-static' ),
    'support'   => __( 'Support', 'florence-static' ),
    'account'   => __( 'Account', 'florence-static' ),
];

$products = get_posts(
    [
        'post_type'      => 'fl_product',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]
);

function florence_portal_render_product_summary( $product ) {
    $category = get_post_meta( $product->ID, 'fl_category', true );
    $moq      = get_post_meta( $product->ID, 'fl_moq', true );
    $lead     = get_post_meta( $product->ID, 'fl_lead_time', true );
    ?>
    <article class="portal-card portal-card--product">
        <h3><?php echo esc_html( get_the_title( $product ) ); ?></h3>
        <p class="portal-card__meta"><?php echo esc_html( $category ); ?></p>
        <p><?php echo wp_trim_words( get_the_excerpt( $product ), 20 ); ?></p>
        <ul class="portal-card__stats">
            <?php if ( $moq ) : ?>
                <li><strong><?php esc_html_e( 'MOQ:', 'florence-static' ); ?></strong> <?php echo esc_html( $moq ); ?></li>
            <?php endif; ?>
            <?php if ( $lead ) : ?>
                <li><strong><?php esc_html_e( 'Lead time:', 'florence-static' ); ?></strong> <?php echo esc_html( $lead ); ?></li>
            <?php endif; ?>
        </ul>
        <a class="btn btn-secondary" href="<?php echo esc_url( site_url( '/portal/products/' . $product->post_name ) ); ?>"><?php esc_html_e( 'View Details', 'florence-static' ); ?></a>
    </article>
    <?php
}

function florence_portal_render_docs_table( $is_internal, $current_user_id ) {
    $docs = get_posts(
        [
            'post_type'      => 'fl_compliance_doc',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]
    );
    if ( ! $docs ) {
        echo '<p>' . esc_html__( 'No documents available yet.', 'florence-static' ) . '</p>';
        return;
    }
    ?>
    <div class="portal-table-wrapper">
        <table class="portal-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Document', 'florence-static' ); ?></th>
                    <th><?php esc_html_e( 'Type', 'florence-static' ); ?></th>
                    <th><?php esc_html_e( 'Product', 'florence-static' ); ?></th>
                    <th><?php esc_html_e( 'Download', 'florence-static' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $docs as $doc ) :
                    $product_id = (int) get_post_meta( $doc->ID, 'fl_doc_product', true );
                    $product    = $product_id ? get_post( $product_id ) : null;
                                        $file       = function_exists( 'get_field' ) ? get_field( 'file', $doc->ID ) : null;
                    $file_url   = $file && is_array( $file ) ? $file['url'] : get_post_meta( $doc->ID, 'fl_doc_file', true );
                    ?>
                    <tr>
                        <td><?php echo esc_html( get_the_title( $doc ) ); ?></td>
                        <td><?php echo esc_html( wp_strip_all_tags( get_the_term_list( $doc->ID, 'fl_doc_type', '', ', ', '' ) ) ?: __( 'General', 'florence-static' ) ); ?></td>
                        <td><?php echo esc_html( $product ? $product->post_title : __( 'All products', 'florence-static' ) ); ?></td>
                        <td>
                            <?php if ( $file_url ) : ?>
                                <a class="btn btn-secondary" href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View', 'florence-static' ); ?></a>
                            <?php else : ?>
                                <em><?php esc_html_e( 'Attached in editor', 'florence-static' ); ?></em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function florence_portal_render_requests_table( $type, $is_internal ) {
    $args = [
        'post_type'      => $type,
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    if ( ! $is_internal ) {
        $args['author'] = get_current_user_id();
    }

    $posts = get_posts( $args );
    if ( ! $posts ) {
        echo '<p>' . esc_html__( 'No records yet.', 'florence-static' ) . '</p>';
        return;
    }
    ?>
    <div class="portal-table-wrapper">
        <table class="portal-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Title', 'florence-static' ); ?></th>
                    <th><?php esc_html_e( 'Status', 'florence-static' ); ?></th>
                    <th><?php esc_html_e( 'Created', 'florence-static' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $posts as $post ) :
                    $status = get_post_meta( $post->ID, '_fl_request_status', true ) ?: get_post_meta( $post->ID, '_fl_ticket_status', true ) ?: get_post_meta( $post->ID, '_fl_po_status', true );
                    ?>
                    <tr>
                        <td><?php echo esc_html( get_the_title( $post ) ); ?></td>
                        <td><span class="portal-pill"><?php echo esc_html( $status ?: __( 'New', 'florence-static' ) ); ?></span></td>
                        <td><?php echo esc_html( get_the_date( '', $post ) ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
<div class="portal-layout">
    <aside class="portal-sidebar">
        <p class="portal-sidebar__welcome"><?php printf( esc_html__( 'Hello %s', 'florence-static' ), esc_html( $current->display_name ) ); ?></p>
        <nav>
            <ul>
                <?php foreach ( $nav_items as $slug => $label ) : ?>
                    <li>
                        <a class="<?php echo $section === $slug ? 'is-active' : ''; ?>" href="<?php echo esc_url( site_url( '/portal/' . $slug ) ); ?>"><?php echo esc_html( $label ); ?></a>
                    </li>
                <?php endforeach; ?>
                <li><a href="<?php echo esc_url( wp_logout_url( site_url( '/portal/login' ) ) ); ?>"><?php esc_html_e( 'Log out', 'florence-static' ); ?></a></li>
            </ul>
        </nav>
    </aside>
    <main class="portal-main">
        <?php switch ( $section ) {
            case 'products':
                if ( $item_slug ) {
                    $product = get_page_by_path( $item_slug, OBJECT, 'fl_product' );
                    if ( $product ) :
                        $specs      = get_post_meta( $product->ID, 'fl_specs', true );
                        $packaging  = get_post_meta( $product->ID, 'fl_packaging', true );
                        $docs = get_posts(
                            [
                                'post_type'      => 'fl_compliance_doc',
                                'posts_per_page' => -1,
                                'meta_key'       => 'fl_doc_product',
                                'meta_value'     => $product->ID,
                            ]
                        );
                        ?>
                        <section class="portal-section">
                            <a class="btn btn-secondary" href="<?php echo esc_url( site_url( '/portal/products' ) ); ?>">&larr; <?php esc_html_e( 'Back to catalog', 'florence-static' ); ?></a>
                            <div class="portal-card portal-card--product-detail">
                                <h1><?php echo esc_html( get_the_title( $product ) ); ?></h1>
                                <p><?php echo wpautop( $product->post_content ); ?></p>
                                <div class="portal-grid">
                                    <div>
                                        <h4><?php esc_html_e( 'Specifications', 'florence-static' ); ?></h4>
                                        <p><?php echo nl2br( esc_html( $specs ) ); ?></p>
                                    </div>
                                    <div>
                                        <h4><?php esc_html_e( 'Packaging & logistics', 'florence-static' ); ?></h4>
                                        <p><?php echo nl2br( esc_html( $packaging ) ); ?></p>
                                    </div>
                                </div>
                                <div class="portal-card__actions">
                                    <a class="btn btn-primary" href="<?php echo esc_url( site_url( '/portal/quotes/new' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'florence-static' ); ?></a>
                                    <a class="btn btn-secondary" href="<?php echo esc_url( site_url( '/portal/samples/new' ) ); ?>"><?php esc_html_e( 'Request Samples', 'florence-static' ); ?></a>
                                </div>
                            </div>
                            <div class="portal-card">
                                <h2><?php esc_html_e( 'Related documents', 'florence-static' ); ?></h2>
                                <?php if ( $docs ) : ?>
                                    <ul class="portal-doc-list">
                                        <?php foreach ( $docs as $doc ) : ?>
                                            <li>
                                                <strong><?php echo esc_html( get_the_title( $doc ) ); ?></strong>
                                                <a class="btn btn-secondary" href="<?php echo esc_url( get_permalink( $doc ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open', 'florence-static' ); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <p><?php esc_html_e( 'No linked documents yet.', 'florence-static' ); ?></p>
                                <?php endif; ?>
                            </div>
                        </section>
                        <?php
                    else :
                        echo '<p>' . esc_html__( 'Product not found.', 'florence-static' ) . '</p>';
                    endif;
                } else {
                    echo '<section class="portal-section"><h1>' . esc_html__( 'Product Catalog', 'florence-static' ) . '</h1><div class="portal-grid">';
                    foreach ( $products as $product ) {
                        florence_portal_render_product_summary( $product );
                    }
                    echo '</div></section>';
                }
                break;

            case 'documents':
                echo '<section class="portal-section"><h1>' . esc_html__( 'Compliance Library', 'florence-static' ) . '</h1>';
                florence_portal_render_docs_table( $is_internal, get_current_user_id() );
                echo '</section>';
                break;

            case 'quotes':
                if ( 'new' === $item_slug ) {
                    include locate_template( 'portal/section-quotes-new.php', false, false );
                } else {
                    echo '<section class="portal-section">';
                    echo '<div class="portal-section__header">';
                    echo '<div><h1>' . esc_html__( 'Quote Requests', 'florence-static' ) . '</h1></div>';
                    echo '<a class="btn btn-primary" href="' . esc_url( site_url( '/portal/quotes/new' ) ) . '">' . esc_html__( 'New Quote', 'florence-static' ) . '</a>';
                    echo '</div>';
                    florence_portal_render_requests_table( 'fl_quote_request', $is_internal );
                    echo '</section>';
                }
                break;

            case 'samples':
                if ( 'new' === $item_slug ) {
                    include locate_template( 'portal/section-samples-new.php', false, false );
                } else {
                    echo '<section class="portal-section">';
                    echo '<div class="portal-section__header">';
                    echo '<div><h1>' . esc_html__( 'Sample Requests', 'florence-static' ) . '</h1></div>';
                    echo '<a class="btn btn-primary" href="' . esc_url( site_url( '/portal/samples/new' ) ) . '">' . esc_html__( 'New Sample Request', 'florence-static' ) . '</a>';
                    echo '</div>';
                    florence_portal_render_requests_table( 'fl_sample_request', $is_internal );
                    echo '</section>';
                }
                break;

            case 'orders':
                echo '<section class="portal-section">';
                echo '<div class="portal-section__header">';
                echo '<div><h1>' . esc_html__( 'Purchase Orders', 'florence-static' ) . '</h1></div>';
                if ( current_user_can( 'upload_files' ) || in_array( 'florence_distributor', (array) $current->roles, true ) ) {
                    echo '<button class="btn btn-primary" data-portal-po-toggle>' . esc_html__( 'Upload PO', 'florence-static' ) . '</button>';
                }
                echo '</div>';
                florence_portal_render_requests_table( 'fl_purchase_order', $is_internal );
                include locate_template( 'portal/section-po-upload.php', false, false );
                echo '</section>';
                break;

            case 'support':
                include locate_template( 'portal/section-support.php', false, false );
                break;

            case 'account':
                include locate_template( 'portal/section-account.php', false, false );
                break;

            case 'dashboard':
            default:
                include locate_template( 'portal/section-dashboard.php', false, false );
                break;
        }
        ?>
    </main>
</div>
<?php get_footer();
