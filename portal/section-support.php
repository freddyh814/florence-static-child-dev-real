<section class="portal-section">
    <h1><?php esc_html_e( 'Support & Help Desk', 'florence-static' ); ?></h1>
    <div class="portal-grid">
        <article class="portal-card">
            <h2><?php esc_html_e( 'Open a Ticket', 'florence-static' ); ?></h2>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="portal_support" />
                <?php wp_nonce_field( 'portal_support', 'portal_nonce' ); ?>
                <label><?php esc_html_e( 'Subject', 'florence-static' ); ?>
                    <input type="text" name="subject" required />
                </label>
                <label><?php esc_html_e( 'Describe the issue', 'florence-static' ); ?>
                    <textarea name="message" rows="5" required></textarea>
                </label>
                <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Send to Florence', 'florence-static' ); ?></button>
            </form>
        </article>
        <article class="portal-card">
            <h2><?php esc_html_e( 'Existing Tickets', 'florence-static' ); ?></h2>
            <?php florence_portal_render_requests_table( 'fl_support_ticket', florence_portal_is_internal() ); ?>
        </article>
    </div>
</section>
