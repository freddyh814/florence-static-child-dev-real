<?php
/**
 * Template Name: Catalog Hub
 */

get_header();
$categories = get_terms(
    [
        'taxonomy'   => 'fl_catalog_category',
        'hide_empty' => false,
        'orderby'    => 'name',
    ]
);
?>
<main class="florence-page florence-catalog">
    <section class="florence-hero compact">
        <div class="container">
            <p class="eyebrow">Catálogo / Catalog</p>
            <h1>Florence Medical Catalog</h1>
            <p class="lead">Traceable surgical textiles, nearshore logistics, and importer-of-record accountability engineered for hospital sourcing teams.</p>
        </div>
    </section>

    <section class="florence-section">
        <div class="container">
            <h2><?php esc_html_e( 'Nuestros productos', 'florence' ); ?></h2>
            <div class="catalog-grid">
                <?php foreach ( $categories as $category ) :
                    $intro = get_term_meta( $category->term_id, 'fl_catalog_intro', true );
                    ?>
                    <article class="catalog-card">
                        <h3>
                            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                                <?php echo esc_html( $category->name ); ?>
                            </a>
                        </h3>
                        <?php if ( $intro ) : ?>
                            <p><?php echo wp_kses_post( $intro ); ?></p>
                        <?php endif; ?>
                        <a class="catalog-link" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                            <?php esc_html_e( 'Ver categoría →', 'florence' ); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="florence-section cta-block">
        <div class="container">
            <h2><?php esc_html_e( 'Hablemos. Estamos listos para innovar contigo.', 'florence' ); ?></h2>
            <p><?php esc_html_e( 'Comparte tu formulary, solicita muestras con documentación o agenda una sesión con el equipo de cumplimiento.', 'florence' ); ?></p>
            <div class="cta-actions">
                <a class="btn btn-primary" href="<?php echo esc_url( site_url( '/contact' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'florence' ); ?></a>
                <a class="btn" href="<?php echo esc_url( site_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contactar ahora', 'florence' ); ?></a>
            </div>
        </div>
    </section>
</main>
<?php get_footer();
