<?php if ( current_user_can( 'upload_files' ) || in_array( 'florence_distributor', (array) wp_get_current_user()->roles, true ) ) : ?>
<div class="portal-modal" data-portal-po-modal>
    <div class="portal-modal__dialog">
        <button class="portal-modal__close" type="button" data-portal-po-close>&times;</button>
        <h2><?php esc_html_e( 'Upload Purchase Order', 'florence-static' ); ?></h2>
        <form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="portal_po" />
            <?php wp_nonce_field( 'portal_po', 'portal_nonce' ); ?>
            <label><?php esc_html_e( 'PO Number', 'florence-static' ); ?>
                <input type="text" name="po_number" required />
            </label>
            <label><?php esc_html_e( 'Status', 'florence-static' ); ?>
                <select name="status">
                    <option value="submitted"><?php esc_html_e( 'Submitted', 'florence-static' ); ?></option>
                    <option value="processing"><?php esc_html_e( 'Processing', 'florence-static' ); ?></option>
                    <option value="received"><?php esc_html_e( 'Received', 'florence-static' ); ?></option>
                </select>
            </label>
            <label><?php esc_html_e( 'Upload PDF', 'florence-static' ); ?>
                <input type="file" name="po_file" accept="application/pdf" />
            </label>
            <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Upload', 'florence-static' ); ?></button>
        </form>
    </div>
</div>
<?php endif; ?>
