<?php
/**
 * Catalog data model (categories + product families + spec tables).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register taxonomy + CPT.
add_action( 'init', function () {
    $labels = [
        'name'          => __( 'Catalog Categories', 'florence' ),
        'singular_name' => __( 'Catalog Category', 'florence' ),
        'menu_name'     => __( 'Catalog Categories', 'florence' ),
    ];

    register_taxonomy(
        'fl_catalog_category',
        [ 'fl_catalog_family' ],
        [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => [ 'slug' => 'catalogo' ],
        ]
    );

    $family_labels = [
        'name'          => __( 'Catalog Products', 'florence' ),
        'singular_name' => __( 'Catalog Product', 'florence' ),
        'menu_name'     => __( 'Catalog Products', 'florence' ),
    ];

    register_post_type(
        'fl_catalog_family',
        [
            'labels'        => $family_labels,
            'public'        => true,
            'has_archive'   => false,
            'rewrite'       => [ 'slug' => 'catalogo/producto' ],
            'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'show_in_rest'  => true,
            'menu_position' => 21,
            'taxonomies'    => [ 'fl_catalog_category' ],
        ]
    );
} );

// Category intro meta.
add_action( 'fl_catalog_category_add_form_fields', function () {
    ?>
    <div class="form-field">
        <label for="fl_catalog_intro"><?php esc_html_e( 'Intro Text', 'florence' ); ?></label>
        <textarea name="fl_catalog_intro" id="fl_catalog_intro" rows="3" class="large-text"></textarea>
        <p class="description"><?php esc_html_e( 'Short paragraph for the category landing page.', 'florence' ); ?></p>
    </div>
    <?php
} );

add_action( 'fl_catalog_category_edit_form_fields', function ( $term ) {
    $value = get_term_meta( $term->term_id, 'fl_catalog_intro', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="fl_catalog_intro"><?php esc_html_e( 'Intro Text', 'florence' ); ?></label></th>
        <td>
            <textarea name="fl_catalog_intro" id="fl_catalog_intro" rows="4" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
            <p class="description"><?php esc_html_e( 'Short paragraph for the category landing page.', 'florence' ); ?></p>
        </td>
    </tr>
    <?php
}, 10, 1 );

add_action( 'edited_fl_catalog_category', 'florence_save_catalog_category_meta' );
add_action( 'created_fl_catalog_category', 'florence_save_catalog_category_meta' );

function florence_save_catalog_category_meta( $term_id ) {
    if ( isset( $_POST['fl_catalog_intro'] ) ) {
        update_term_meta( $term_id, 'fl_catalog_intro', wp_kses_post( wp_unslash( $_POST['fl_catalog_intro'] ) ) );
    }
}

// Product spec meta box.
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'fl_catalog_spec',
        __( 'Specification Table', 'florence' ),
        'florence_render_catalog_spec_metabox',
        'fl_catalog_family',
        'normal',
        'high'
    );
} );

function florence_render_catalog_spec_metabox( $post ) {
    $headers = get_post_meta( $post->ID, '_fl_spec_headers', true );
    $rows    = get_post_meta( $post->ID, '_fl_spec_rows', true );
    wp_nonce_field( 'fl_catalog_spec', 'fl_catalog_spec_nonce' );
    ?>
    <p><?php esc_html_e( 'Define the columns (comma separated) and rows (JSON or comma-separated per line).', 'florence' ); ?></p>
    <p>
        <label for="fl_spec_headers"><strong><?php esc_html_e( 'Headers', 'florence' ); ?></strong></label>
        <input type="text" name="fl_spec_headers" id="fl_spec_headers" class="widefat" value="<?php echo esc_attr( $headers ); ?>" />
        <span class="description"><?php esc_html_e( 'Example: Código, Nivel AAMI, Estéril, Tallas, GSM, Empaque', 'florence' ); ?></span>
    </p>
    <p>
        <label for="fl_spec_rows"><strong><?php esc_html_e( 'Rows', 'florence' ); ?></strong></label>
        <textarea name="fl_spec_rows" id="fl_spec_rows" rows="6" class="widefat" placeholder='["FL-6401","Nivel 4","✓","XL","80","10 unidades"]'><?php echo esc_textarea( $rows ); ?></textarea>
        <span class="description"><?php esc_html_e( 'One row per line. Use JSON array or comma-separated values.', 'florence' ); ?></span>
    </p>
    <?php
}

add_action( 'save_post_fl_catalog_family', function ( $post_id ) {
    if ( ! isset( $_POST['fl_catalog_spec_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['fl_catalog_spec_nonce'] ), 'fl_catalog_spec' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $headers = isset( $_POST['fl_spec_headers'] ) ? sanitize_text_field( wp_unslash( $_POST['fl_spec_headers'] ) ) : '';
    $rows    = isset( $_POST['fl_spec_rows'] ) ? wp_unslash( $_POST['fl_spec_rows'] ) : '';

    update_post_meta( $post_id, '_fl_spec_headers', $headers );
    update_post_meta( $post_id, '_fl_spec_rows', wp_kses_post( $rows ) );
} );

function florence_catalog_get_spec_rows( $post_id ) {
    $raw = get_post_meta( $post_id, '_fl_spec_rows', true );
    if ( empty( $raw ) ) {
        return [];
    }
    $lines = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
    $rows  = [];
    foreach ( $lines as $line ) {
        if ( preg_match( '/^\[.*\]$/', $line ) ) {
            $decoded = json_decode( $line, true );
            if ( is_array( $decoded ) ) {
                $rows[] = array_map( 'wp_kses_post', $decoded );
                continue;
            }
        }
        $rows[] = array_map( 'wp_kses_post', array_map( 'trim', explode( ',', $line ) ) );
    }
    return $rows;
}
