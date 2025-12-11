<?php
/**
 * Template Name: Portal Login
 */

if ( is_user_logged_in() ) {
    wp_safe_redirect( site_url( '/portal' ) );
    exit;
}

$error = '';
if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
    check_admin_referer( 'portal_login', 'portal_login_nonce' );
    $creds = [
        'user_login'    => sanitize_user( wp_unslash( $_POST['user_login'] ?? '' ) ),
        'user_password' => wp_unslash( $_POST['user_pass'] ?? '' ),
        'remember'      => ! empty( $_POST['rememberme'] ),
    ];
    $user = wp_signon( $creds, false );
    if ( is_wp_error( $user ) ) {
        $error = $user->get_error_message();
    } else {
        wp_safe_redirect( site_url( '/portal' ) );
        exit;
    }
}

get_header();
?>
<section class="portal-login">
    <div class="portal-login__panel">
        <h1><?php esc_html_e( 'Florence Partner Portal', 'florence-static' ); ?></h1>
        <p><?php esc_html_e( 'Sign in with your portal credentials. Need access? Contact Florence ops.', 'florence-static' ); ?></p>
        <?php if ( $error ) : ?>
            <div class="portal-alert portal-alert--error"><?php echo wp_kses_post( $error ); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <?php wp_nonce_field( 'portal_login', 'portal_login_nonce' ); ?>
            <label>
                <?php esc_html_e( 'Email', 'florence-static' ); ?>
                <input type="text" name="user_login" required />
            </label>
            <label>
                <?php esc_html_e( 'Password', 'florence-static' ); ?>
                <input type="password" name="user_pass" required />
            </label>
            <label class="portal-login__remember">
                <input type="checkbox" name="rememberme" /> <?php esc_html_e( 'Remember me', 'florence-static' ); ?>
            </label>
            <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Sign in', 'florence-static' ); ?></button>
            <p class="portal-login__help"><a href="<?php echo esc_url( wp_lostpassword_url( site_url( '/portal/login' ) ) ); ?>"><?php esc_html_e( 'Forgot your password?', 'florence-static' ); ?></a></p>
        </form>
    </div>
</section>
<?php get_footer();
