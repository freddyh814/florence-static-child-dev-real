<?php
/**
 * Florence portal support (roles, CPTs, routing, form handlers).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// -----------------------------
// Roles & Capabilities
// -----------------------------
function florence_portal_register_roles() {
    $roles = [
        'florence_buyer'       => __( 'Florence Buyer', 'florence-static' ),
        'florence_distributor' => __( 'Florence Distributor', 'florence-static' ),
        'florence_internal'    => __( 'Florence Internal', 'florence-static' ),
    ];

    foreach ( $roles as $role => $label ) {
        if ( ! get_role( $role ) ) {
            add_role( $role, $label, [ 'read' => true ] );
        }
    }
}
add_action( 'init', 'florence_portal_register_roles' );

function florence_portal_is_internal( $user = null ) {
    $user = $user ?: wp_get_current_user();
    if ( ! $user instanceof WP_User ) {
        return false;
    }
    if ( user_can( $user, 'manage_options' ) ) {
        return true;
    }
    return in_array( 'florence_internal', (array) $user->roles, true );
}

// -----------------------------
// CPTs & Meta
// -----------------------------
function florence_portal_register_cpts() {
    register_post_type(
        'fl_product',
        [
            'labels'       => [
                'name'          => __( 'Portal Products', 'florence-static' ),
                'singular_name' => __( 'Portal Product', 'florence-static' ),
            ],
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => true,
            'menu_icon'    => 'dashicons-pressthis',
            'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'show_in_rest' => true,
        ]
    );

    register_post_type(
        'fl_compliance_doc',
        [
            'labels'       => [
                'name'          => __( 'Compliance Docs', 'florence-static' ),
                'singular_name' => __( 'Compliance Doc', 'florence-static' ),
            ],
            'public'       => false,
            'show_ui'      => true,
            'supports'     => [ 'title', 'editor', 'custom-fields' ],
            'menu_icon'    => 'dashicons-media-document',
            'show_in_rest' => true,
        ]
    );

    register_taxonomy(
        'fl_doc_type',
        'fl_compliance_doc',
        [
            'labels'       => [
                'name'          => __( 'Document Types', 'florence-static' ),
                'singular_name' => __( 'Document Type', 'florence-static' ),
            ],
            'public'       => false,
            'show_ui'      => true,
            'show_admin_column' => true,
        ]
    );

    $request_cpts = [
        'fl_quote_request'   => __( 'Quote Requests', 'florence-static' ),
        'fl_sample_request'  => __( 'Sample Requests', 'florence-static' ),
        'fl_purchase_order'  => __( 'Purchase Orders', 'florence-static' ),
        'fl_support_ticket'  => __( 'Support Tickets', 'florence-static' ),
    ];

    foreach ( $request_cpts as $type => $label ) {
        register_post_type(
            $type,
            [
                'labels'       => [ 'name' => $label, 'singular_name' => $label ],
                'public'       => false,
                'show_ui'      => true,
                'supports'     => [ 'title', 'editor', 'custom-fields' ],
                'menu_icon'    => 'dashicons-feedback',
            ]
        );
    }
}
add_action( 'init', 'florence_portal_register_cpts' );

function florence_portal_register_meta() {
    $product_meta = [
        'fl_category',
        'fl_specs',
        'fl_packaging',
        'fl_moq',
        'fl_lead_time',
        'fl_label_notes',
    ];

    foreach ( $product_meta as $meta_key ) {
        register_post_meta(
            'fl_product',
            $meta_key,
            [
                'single'       => true,
                'type'         => 'string',
                'show_in_rest' => true,
                'auth_callback' => function () {
                    return current_user_can( 'edit_posts' );
                },
            ]
        );
    }

    register_post_meta(
        'fl_compliance_doc',
        'fl_doc_product',
        [
            'single'       => true,
            'type'         => 'integer',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can( 'edit_posts' );
            },
        ]
    );
}
add_action( 'init', 'florence_portal_register_meta' );

// -----------------------------
// Routing & Pages
// -----------------------------
function florence_portal_query_vars( $vars ) {
    $vars[] = 'portal_section';
    $vars[] = 'portal_item';
    return $vars;
}
add_filter( 'query_vars', 'florence_portal_query_vars' );

function florence_portal_rewrite_rules() {
    add_rewrite_rule( '^portal/login/?$', 'index.php?pagename=portal-login', 'top' );
    add_rewrite_rule( '^portal/?$', 'index.php?pagename=portal&portal_section=dashboard', 'top' );
    add_rewrite_rule( '^portal/([^/]+)/?$', 'index.php?pagename=portal&portal_section=$matches[1]', 'top' );
    add_rewrite_rule( '^portal/([^/]+)/([^/]+)/?$', 'index.php?pagename=portal&portal_section=$matches[1]&portal_item=$matches[2]', 'top' );
}
add_action( 'init', 'florence_portal_rewrite_rules' );

function florence_portal_ensure_pages() {
    $pages = [
        'portal'       => [
            'title'    => 'Portal',
            'template' => 'page-portal.php',
        ],
        'portal-login' => [
            'title'    => 'Portal Login',
            'template' => 'page-portal-login.php',
        ],
    ];

    foreach ( $pages as $slug => $data ) {
        $page = get_page_by_path( $slug );
        $postarr = [
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ];

        if ( $page ) {
            $postarr['ID'] = $page->ID;
            $page_id       = wp_update_post( $postarr );
        } else {
            $page_id = wp_insert_post( $postarr );
        }

        if ( ! is_wp_error( $page_id ) && ! empty( $data['template'] ) ) {
            update_post_meta( $page_id, '_wp_page_template', $data['template'] );
        }
    }
}
add_action( 'after_setup_theme', 'florence_portal_ensure_pages' );

// -----------------------------
// Form Handlers
// -----------------------------
function florence_portal_prepare_items( $product_ids, $quantities ) {
    $items = [];
    if ( is_array( $product_ids ) && is_array( $quantities ) ) {
        foreach ( $product_ids as $index => $product_id ) {
            $product_id = absint( $product_id );
            $qty        = isset( $quantities[ $index ] ) ? absint( $quantities[ $index ] ) : 0;
            if ( $product_id && $qty > 0 ) {
                $items[] = [ 'product' => $product_id, 'qty' => $qty ];
            }
        }
    }
    return $items;
}

function florence_portal_handle_quote_request() {
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( wp_login_url() );
        exit;
    }
    check_admin_referer( 'portal_quote', 'portal_nonce' );

    $items = florence_portal_prepare_items( $_POST['product'] ?? [], $_POST['quantity'] ?? [] );
    $notes = isset( $_POST['notes'] ) ? wp_kses_post( wp_unslash( $_POST['notes'] ) ) : '';

    $post_id = wp_insert_post(
        [
            'post_type'   => 'fl_quote_request',
            'post_status' => 'publish',
            'post_title'  => sprintf( 'Quote Request – %s', wp_get_current_user()->display_name ),
            'post_author' => get_current_user_id(),
        ]
    );

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, '_fl_request_items', wp_json_encode( $items ) );
        update_post_meta( $post_id, '_fl_request_notes', $notes );
        update_post_meta( $post_id, '_fl_request_status', 'new' );
    }

    wp_safe_redirect( site_url( '/portal/quotes' ) );
    exit;
}
add_action( 'admin_post_portal_quote', 'florence_portal_handle_quote_request' );
add_action( 'admin_post_nopriv_portal_quote', 'florence_portal_handle_quote_request' );

function florence_portal_handle_sample_request() {
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( wp_login_url() );
        exit;
    }
    check_admin_referer( 'portal_sample', 'portal_nonce' );

    $items = florence_portal_prepare_items( $_POST['product'] ?? [], $_POST['quantity'] ?? [] );
    $notes = isset( $_POST['notes'] ) ? wp_kses_post( wp_unslash( $_POST['notes'] ) ) : '';

    $post_id = wp_insert_post(
        [
            'post_type'   => 'fl_sample_request',
            'post_status' => 'publish',
            'post_title'  => sprintf( 'Sample Request – %s', wp_get_current_user()->display_name ),
            'post_author' => get_current_user_id(),
        ]
    );

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, '_fl_request_items', wp_json_encode( $items ) );
        update_post_meta( $post_id, '_fl_request_notes', $notes );
        update_post_meta( $post_id, '_fl_request_status', 'new' );
    }

    wp_safe_redirect( site_url( '/portal/samples' ) );
    exit;
}
add_action( 'admin_post_portal_sample', 'florence_portal_handle_sample_request' );
add_action( 'admin_post_nopriv_portal_sample', 'florence_portal_handle_sample_request' );

function florence_portal_handle_support_request() {
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( wp_login_url() );
        exit;
    }
    check_admin_referer( 'portal_support', 'portal_nonce' );

    $subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : __( 'Support request', 'florence-static' );
    $message = isset( $_POST['message'] ) ? wp_kses_post( wp_unslash( $_POST['message'] ) ) : '';

    $post_id = wp_insert_post(
        [
            'post_type'   => 'fl_support_ticket',
            'post_status' => 'publish',
            'post_title'  => $subject,
            'post_content'=> $message,
            'post_author' => get_current_user_id(),
        ]
    );

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, '_fl_ticket_status', 'open' );
    }

    wp_safe_redirect( site_url( '/portal/support' ) );
    exit;
}
add_action( 'admin_post_portal_support', 'florence_portal_handle_support_request' );
add_action( 'admin_post_nopriv_portal_support', 'florence_portal_handle_support_request' );

function florence_portal_handle_po_upload() {
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( wp_login_url() );
        exit;
    }
    check_admin_referer( 'portal_po', 'portal_nonce' );

    $po_number = isset( $_POST['po_number'] ) ? sanitize_text_field( wp_unslash( $_POST['po_number'] ) ) : ''; 
    $status    = isset( $_POST['status'] ) ? sanitize_text_field( wp_unslash( $_POST['status'] ) ) : 'submitted';

    $post_id = wp_insert_post(
        [
            'post_type'   => 'fl_purchase_order',
            'post_status' => 'publish',
            'post_title'  => $po_number ? sprintf( 'PO %s', $po_number ) : sprintf( 'PO %s', current_time( 'Ymd-His' ) ),
            'post_author' => get_current_user_id(),
        ]
    );

    if ( ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, '_fl_po_status', $status );
        update_post_meta( $post_id, '_fl_po_number', $po_number );

        if ( ! empty( $_FILES['po_file']['name'] ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $file = wp_handle_upload( $_FILES['po_file'], [ 'test_form' => false ] );
            if ( empty( $file['error'] ) && ! empty( $file['url'] ) ) {
                update_post_meta( $post_id, '_fl_po_file', esc_url_raw( $file['url'] ) );
            }
        }
    }

    wp_safe_redirect( site_url( '/portal/orders' ) );
    exit;
}
add_action( 'admin_post_portal_po', 'florence_portal_handle_po_upload' );
add_action( 'admin_post_nopriv_portal_po', 'florence_portal_handle_po_upload' );

function florence_portal_handle_profile_update() {
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( wp_login_url() );
        exit;
    }
    check_admin_referer( 'portal_profile', 'portal_nonce' );

    $user_id = get_current_user_id();
    $display_name = isset( $_POST['display_name'] ) ? sanitize_text_field( wp_unslash( $_POST['display_name'] ) ) : '';
    $company      = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
    $title        = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
    $phone        = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';

    if ( $display_name ) {
        wp_update_user( [ 'ID' => $user_id, 'display_name' => $display_name ] );
    }
    update_user_meta( $user_id, 'fl_company', $company );
    update_user_meta( $user_id, 'fl_title', $title );
    update_user_meta( $user_id, 'fl_phone', $phone );

    wp_safe_redirect( add_query_arg( 'updated', '1', site_url( '/portal/account' ) ) );
    exit;
}
add_action( 'admin_post_portal_profile', 'florence_portal_handle_profile_update' );
add_action( 'admin_post_nopriv_portal_profile', 'florence_portal_handle_profile_update' );

