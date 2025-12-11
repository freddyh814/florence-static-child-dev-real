<?php
/**
 * Catalog category view.
 */

global $wp_query;
$term = $wp_query->get_queried_object();

get_header();
$intro = get_term_meta( $term->term_id, 'fl_catalog_intro', true );

$query = new WP_Query(
    [
        'post_type'      => 'fl_catalog_family',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'tax_query'      => [
            [
                'taxonomy' => 'fl_catalog_category',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ],
        ],
    ]
);
?>
<main class="florence-page florence-catalog">
    <section class="florence-hero compact">
        <div class="container">
            <p class="eyebrow">Catálogo</p>
            <h1><?php echo esc_html( $term->name ); ?></h1>
            <?php if ( $intro ) : ?>
                <p class="lead"><?php echo wp_kses_post( $intro ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="florence-section">
        <div class="container">
            <?php if ( $query->have_posts() ) : ?>
                <?php while ( $query->have_posts() ) : $query->the_post();
                    $headers = get_post_meta( get_the_ID(), '_fl_spec_headers', true );
                    $header_array = array_map( 'trim', explode( ',', $headers ) );
                    $rows    = florence_catalog_get_spec_rows( get_the_ID() );
                    ?>
                    <article class="catalog-family">
                        <h2><?php the_title(); ?></h2>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="family-image">
                                <?php the_post_thumbnail( 'large' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="family-description">
                            <p class="label"><?php esc_html_e( 'Descripción', 'florence' ); ?></p>
                            <div class="copy">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <?php if ( ! empty( $header_array ) && ! empty( $rows ) ) : ?>
                            <div class="family-spec-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <?php foreach ( $header_array as $header ) : ?>
                                                <th><?php echo esc_html( $header ); ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ( $rows as $row ) : ?>
                                            <tr>
                                                <?php foreach ( $row as $cell ) : ?>
                                                    <td><?php echo wp_kses_post( $cell ); ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <p><?php esc_html_e( 'Products coming soon.', 'florence' ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="florence-section cta-block">
        <div class="container">
            <h2><?php esc_html_e( '¿Listo para configurar tu pedido?', 'florence' ); ?></h2>
            <p><?php esc_html_e( 'Comparte tu formulary o lista de SKUs para armar cotizaciones, solicitudes de muestras y paquetes de cumplimiento a medida.', 'florence' ); ?></p>
            <div class="cta-actions">
                <a class="btn btn-primary" href="<?php echo esc_url( site_url( '/contact' ) ); ?>"><?php esc_html_e( 'Solicitar cotización', 'florence' ); ?></a>
                <a class="btn" href="<?php echo esc_url( site_url( '/certifications' ) ); ?>"><?php esc_html_e( 'Solicitar documentación', 'florence' ); ?></a>
            </div>
        </div>
    </section>
</main>
<?php get_footer();
