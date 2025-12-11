<?php
$user    = wp_get_current_user();
$company = get_user_meta( $user->ID, 'fl_company', true );
$title   = get_user_meta( $user->ID, 'fl_title', true );
$phone   = get_user_meta( $user->ID, 'fl_phone', true );
$updated = isset( $_GET['updated'] );
?>
<section class="portal-section">
    <h1><?php esc_html_e( 'Account Profile', 'florence-static' ); ?></h1>
    <?php if ( $updated ) : ?>
        <div class="portal-alert portal-alert--success"><?php esc_html_e( 'Profile updated successfully.', 'florence-static' ); ?></div>
    <?php endif; ?>
    <div class="portal-grid">
        <article class="portal-card">
            <h2><?php esc_html_e( 'Contact Information', 'florence-static' ); ?></h2>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="portal_profile" />
                <?php wp_nonce_field( 'portal_profile', 'portal_nonce' ); ?>
                <label><?php esc_html_e( 'Display Name', 'florence-static' ); ?>
                    <input type="text" name="display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
                </label>
                <label><?php esc_html_e( 'Company / Facility', 'florence-static' ); ?>
                    <input type="text" name="company" value="<?php echo esc_attr( $company ); ?>" />
                </label>
                <label><?php esc_html_e( 'Title / Role', 'florence-static' ); ?>
                    <input type="text" name="title" value="<?php echo esc_attr( $title ); ?>" />
                </label>
                <label><?php esc_html_e( 'Phone', 'florence-static' ); ?>
                    <input type="tel" name="phone" value="<?php echo esc_attr( $phone ); ?>" />
                </label>
                <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Save profile', 'florence-static' ); ?></button>
            </form>
        </article>
        <article class="portal-card">
            <h2><?php esc_html_e( 'Account Details', 'florence-static' ); ?></h2>
            <ul class="portal-quick-links">
                <li><strong><?php esc_html_e( 'Email', 'florence-static' ); ?>:</strong> <?php echo esc_html( $user->user_email ); ?></li>
                <li><strong><?php esc_html_e( 'Username', 'florence-static' ); ?>:</strong> <?php echo esc_html( $user->user_login ); ?></li>
                <li><strong><?php esc_html_e( 'Roles', 'florence-static' ); ?>:</strong> <?php echo esc_html( implode( ', ', $user->roles ) ); ?></li>
                <li><strong><?php esc_html_e( 'Last login', 'florence-static' ); ?>:</strong> <?php echo esc_html( get_user_meta( $user->ID, 'last_login', true ) ?: __( 'N/A', 'florence-static' ) ); ?></li>
            </ul>
        </article>
    </div>
</section>
