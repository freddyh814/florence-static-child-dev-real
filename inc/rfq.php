<?php
/**
 * RFQ CPT + forms.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('FLORENCE_RFQ_STATUSES')) {
    define('FLORENCE_RFQ_STATUSES', ['Open', 'In Review', 'Quoted', 'Closed']);
}

function florence_child_register_rfq_cpt(): void
{
    register_post_type('rfq', [
        'labels' => [
            'name'          => __('RFQs', 'florence-static-child'),
            'singular_name' => __('RFQ', 'florence-static-child'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'supports'            => ['title'],
        'menu_icon'           => 'dashicons-media-text',
    ]);
}
add_action('init', 'florence_child_register_rfq_cpt');

function florence_child_rfq_columns($columns)
{
    $columns = [
        'cb'       => $columns['cb'],
        'title'    => __('Reference', 'florence-static-child'),
        'product'  => __('Product', 'florence-static-child'),
        'company'  => __('Company', 'florence-static-child'),
        'email'    => __('Email', 'florence-static-child'),
        'quantity' => __('Quantity', 'florence-static-child'),
        'status'   => __('Status', 'florence-static-child'),
        'date'     => $columns['date'],
    ];

    return $columns;
}
add_filter('manage_edit-rfq_columns', 'florence_child_rfq_columns');

function florence_child_rfq_column_content($column, $post_id)
{
    $meta = get_post_meta($post_id);

    switch ($column) {
        case 'product':
            echo esc_html($meta['product_name'][0] ?? '—');
            break;
        case 'company':
            echo esc_html($meta['company'][0] ?? '—');
            break;
        case 'email':
            echo esc_html($meta['email'][0] ?? '—');
            break;
        case 'quantity':
            echo esc_html($meta['quantity'][0] ?? '—');
            break;
        case 'status':
            echo esc_html($meta['rfq_status'][0] ?? 'Open');
            break;
    }
}
add_action('manage_rfq_posts_custom_column', 'florence_child_rfq_column_content', 10, 2);

function florence_child_rfq_quick_edit($column, $post_type): void
{
    if ('status' !== $column || 'rfq' !== $post_type) {
        return;
    }
    ?>
    <fieldset class="inline-edit-col-team">
        <div class="inline-edit-col">
            <label>
                <span class="title"><?php esc_html_e('Status', 'florence-static-child'); ?></span>
                <select name="rfq_status">
                    <?php foreach (FLORENCE_RFQ_STATUSES as $status) : ?>
                        <option value="<?php echo esc_attr($status); ?>"><?php echo esc_html($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
    </fieldset>
    <?php
}
add_action('quick_edit_custom_box', 'florence_child_rfq_quick_edit', 10, 2);

function florence_child_save_rfq_status($post_id): void
{
    if ('rfq' !== get_post_type($post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (!empty($_POST['rfq_status']) && in_array($_POST['rfq_status'], FLORENCE_RFQ_STATUSES, true)) {
        update_post_meta($post_id, 'rfq_status', sanitize_text_field($_POST['rfq_status']));
    }
}
add_action('save_post_rfq', 'florence_child_save_rfq_status');

function florence_child_render_rfq_form(bool $sample_request = false): string
{
    if (!function_exists('wc_get_product')) {
        return __('WooCommerce is required for RFQ forms.', 'florence-static-child');
    }

    $prefill_source = $_GET['rfq_product'] ?? $_GET['product'] ?? 0; // phpcs:ignore WordPress.Security.NonceVerification
    $prefill_id = absint($prefill_source);
    $product = $prefill_id ? wc_get_product($prefill_id) : null;

    $errors = [];
    $success = '';

    if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['florence_rfq_nonce']) && wp_verify_nonce($_POST['florence_rfq_nonce'], 'florence_submit_rfq')) { // phpcs:ignore WordPress.Security.NonceVerification
        $result = florence_child_process_rfq_submission($sample_request);
        if (is_wp_error($result)) {
            $errors[] = $result->get_error_message();
        } else {
            $success = sprintf(__('Thank you! Your reference ID is #%d.', 'florence-static-child'), $result);
        }
    }

    ob_start();
    if ($errors) {
        echo '<div class="rfq-errors">' . esc_html(implode(' ', $errors)) . '</div>';
    }
    if ($success) {
        echo '<div class="rfq-success">' . esc_html($success) . '</div>';
    }

    $action_url = esc_url(get_permalink());
    ?>
    <form class="florence-rfq-form" method="post" enctype="multipart/form-data" action="<?php echo $action_url; ?>">
        <?php wp_nonce_field('florence_submit_rfq', 'florence_rfq_nonce'); ?>
        <input type="hidden" name="florence_rfq_type" value="<?php echo $sample_request ? 'sample' : 'rfq'; ?>" />
        <div class="rfq-grid">
            <label>
                <span><?php esc_html_e('Product', 'florence-static-child'); ?></span>
                <input type="text" name="product_name" value="<?php echo esc_attr($product ? $product->get_name() : ($_POST['product_name'] ?? '')); ?>" <?php echo $product ? 'readonly' : ''; ?> />
                <input type="hidden" name="product_id" value="<?php echo esc_attr($product ? $product->get_id() : ($_POST['product_id'] ?? '')); ?>" />
                <input type="hidden" name="sku" value="<?php echo esc_attr($product ? $product->get_sku() : ($_POST['sku'] ?? '')); ?>" />
                <input type="hidden" name="model_number" value="<?php echo esc_attr($product ? get_post_meta($product->get_id(), 'model_number', true) : ($_POST['model_number'] ?? '')); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Quantity', 'florence-static-child'); ?></span>
                <input type="number" name="quantity" min="1" required value="<?php echo esc_attr($_POST['quantity'] ?? ''); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Company', 'florence-static-child'); ?></span>
                <input type="text" name="company" required value="<?php echo esc_attr($_POST['company'] ?? ''); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Contact Name', 'florence-static-child'); ?></span>
                <input type="text" name="contact_name" required value="<?php echo esc_attr($_POST['contact_name'] ?? ''); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Email', 'florence-static-child'); ?></span>
                <input type="email" name="email" required value="<?php echo esc_attr($_POST['email'] ?? ''); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Phone', 'florence-static-child'); ?></span>
                <input type="text" name="phone" required value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Region / State', 'florence-static-child'); ?></span>
                <input type="text" name="region_state" value="<?php echo esc_attr($_POST['region_state'] ?? ''); ?>" />
            </label>
            <label>
                <span><?php esc_html_e('Need By Date', 'florence-static-child'); ?></span>
                <input type="date" name="need_by_date" value="<?php echo esc_attr($_POST['need_by_date'] ?? ''); ?>" />
            </label>
        </div>
        <label>
            <span><?php esc_html_e('Compliance Requirements', 'florence-static-child'); ?></span>
            <select name="compliance_requirements[]" multiple>
                <option value="AAMI" <?php echo !empty($_POST['compliance_requirements']) && in_array('AAMI', (array) $_POST['compliance_requirements'], true) ? 'selected' : ''; ?>>AAMI Level</option>
                <option value="ASTM" <?php echo !empty($_POST['compliance_requirements']) && in_array('ASTM', (array) $_POST['compliance_requirements'], true) ? 'selected' : ''; ?>>ASTM F2100</option>
                <option value="Sterility" <?php echo !empty($_POST['compliance_requirements']) && in_array('Sterility', (array) $_POST['compliance_requirements'], true) ? 'selected' : ''; ?>>Sterility</option>
                <option value="Latex-Free" <?php echo !empty($_POST['compliance_requirements']) && in_array('Latex-Free', (array) $_POST['compliance_requirements'], true) ? 'selected' : ''; ?>>Latex-Free</option>
            </select>
        </label>
        <label>
            <span><?php esc_html_e('Notes', 'florence-static-child'); ?></span>
            <textarea name="notes" rows="4"><?php echo esc_textarea($_POST['notes'] ?? ''); ?></textarea>
        </label>
        <label>
            <span><?php esc_html_e('Specification PDF (optional)', 'florence-static-child'); ?></span>
            <input type="file" name="rfq_attachment" accept="application/pdf" />
        </label>
        <?php if ($sample_request) : ?>
            <h4><?php esc_html_e('Sample Shipping Details', 'florence-static-child'); ?></h4>
            <div class="rfq-grid">
                <label>
                    <span><?php esc_html_e('Ship To Name', 'florence-static-child'); ?></span>
                    <input type="text" name="ship_to_name" value="<?php echo esc_attr($_POST['ship_to_name'] ?? ''); ?>" />
                </label>
                <label>
                    <span><?php esc_html_e('Ship To Address', 'florence-static-child'); ?></span>
                    <input type="text" name="ship_to_address" value="<?php echo esc_attr($_POST['ship_to_address'] ?? ''); ?>" />
                </label>
                <label>
                    <span><?php esc_html_e('City', 'florence-static-child'); ?></span>
                    <input type="text" name="ship_to_city" value="<?php echo esc_attr($_POST['ship_to_city'] ?? ''); ?>" />
                </label>
                <label>
                    <span><?php esc_html_e('State / Province', 'florence-static-child'); ?></span>
                    <input type="text" name="ship_to_state" value="<?php echo esc_attr($_POST['ship_to_state'] ?? ''); ?>" />
                </label>
                <label>
                    <span><?php esc_html_e('Postal Code', 'florence-static-child'); ?></span>
                    <input type="text" name="ship_to_postal" value="<?php echo esc_attr($_POST['ship_to_postal'] ?? ''); ?>" />
                </label>
                <label>
                    <span><?php esc_html_e('Country', 'florence-static-child'); ?></span>
                    <input type="text" name="ship_to_country" value="<?php echo esc_attr($_POST['ship_to_country'] ?? ''); ?>" />
                </label>
            </div>
        <?php endif; ?>
        <button type="submit" class="button button-primary"><?php echo $sample_request ? esc_html__('Request Samples', 'florence-static-child') : esc_html__('Submit RFQ', 'florence-static-child'); ?></button>
    </form>
    <?php
    return ob_get_clean();
}

function florence_child_process_rfq_submission(bool $sample_request)
{
    $required = ['quantity', 'company', 'contact_name', 'email', 'phone'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) { // phpcs:ignore WordPress.Security.NonceVerification
            return new WP_Error('missing_field', __('Please fill in all required fields.', 'florence-static-child'));
        }
    }

    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0; // phpcs:ignore WordPress.Security.NonceVerification
    $product_name = sanitize_text_field($_POST['product_name'] ?? 'General Product'); // phpcs:ignore WordPress.Security.NonceVerification
    $sku = sanitize_text_field($_POST['sku'] ?? ''); // phpcs:ignore WordPress.Security.NonceVerification
    $model_number = sanitize_text_field($_POST['model_number'] ?? ''); // phpcs:ignore WordPress.Security.NonceVerification

    $post_id = wp_insert_post([
        'post_type'   => 'rfq',
        'post_status' => 'private',
        'post_title'  => sprintf('RFQ - %s (%s)', sanitize_text_field($_POST['company']), current_time('mysql')), // phpcs:ignore WordPress.Security.NonceVerification
    ]);

    if (is_wp_error($post_id)) {
        return $post_id;
    }

    $meta = [
        'product_id'              => $product_id,
        'product_name'            => $product_name,
        'sku'                     => $sku,
        'model_number'            => $model_number,
        'quantity'                => absint($_POST['quantity']),
        'company'                 => sanitize_text_field($_POST['company']),
        'contact_name'            => sanitize_text_field($_POST['contact_name']),
        'email'                   => sanitize_email($_POST['email']),
        'phone'                   => sanitize_text_field($_POST['phone']),
        'region_state'            => sanitize_text_field($_POST['region_state'] ?? ''),
        'need_by_date'            => sanitize_text_field($_POST['need_by_date'] ?? ''),
        'compliance_requirements' => array_map('sanitize_text_field', $_POST['compliance_requirements'] ?? []),
        'notes'                   => sanitize_textarea_field($_POST['notes'] ?? ''),
        'source_page_url'         => esc_url_raw($_POST['_wp_http_referer'] ?? ''),
        'sample_request'          => $sample_request ? 1 : 0,
        'rfq_status'              => 'Open',
    ];

    if ($sample_request) {
        $meta = array_merge($meta, [
            'ship_to_name'    => sanitize_text_field($_POST['ship_to_name'] ?? ''),
            'ship_to_address' => sanitize_text_field($_POST['ship_to_address'] ?? ''),
            'ship_to_city'    => sanitize_text_field($_POST['ship_to_city'] ?? ''),
            'ship_to_state'   => sanitize_text_field($_POST['ship_to_state'] ?? ''),
            'ship_to_postal'  => sanitize_text_field($_POST['ship_to_postal'] ?? ''),
            'ship_to_country' => sanitize_text_field($_POST['ship_to_country'] ?? ''),
        ]);
    }

    foreach ($meta as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }

    if (!empty($_FILES['rfq_attachment']['name'])) { // phpcs:ignore WordPress.Security.NonceVerification
        $file = $_FILES['rfq_attachment']; // phpcs:ignore WordPress.Security.NonceVerification
        if ('application/pdf' !== $file['type']) {
            wp_delete_post($post_id, true);
            return new WP_Error('invalid_file', __('Only PDF uploads are allowed.', 'florence-static-child'));
        }
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachment_id = media_handle_upload('rfq_attachment', $post_id);
        if (!is_wp_error($attachment_id)) {
            update_post_meta($post_id, 'attachment_id', $attachment_id);
        }
    }

    florence_child_notify_rfq($post_id, $meta, $sample_request);

    return $post_id;
}

function florence_child_notify_rfq(int $post_id, array $meta, bool $sample_request): void
{
    $admin_email = get_option('admin_email');
    $subject = sprintf('[Florence Medical] %s #%d', $sample_request ? __('Sample Request', 'florence-static-child') : __('RFQ', 'florence-static-child'), $post_id);

    $body = "Reference ID: #{$post_id}\n";
    if (!empty($meta['product_id'])) {
        $body .= 'Product URL: ' . get_permalink((int) $meta['product_id']) . "\n";
    }
    foreach ($meta as $key => $value) {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        $body .= ucwords(str_replace('_', ' ', $key)) . ': ' . $value . "\n";
    }

    wp_mail($admin_email, $subject, $body);

    if (!empty($meta['email'])) {
        $confirmation = sprintf(__('We have received your %s. Reference ID: #%d.', 'florence-static-child'), $sample_request ? __('sample request', 'florence-static-child') : __('RFQ', 'florence-static-child'), $post_id);
        wp_mail($meta['email'], __('Florence Medical Submission', 'florence-static-child'), $confirmation);
    }
}

function florence_child_rfq_shortcode($atts, $content = ''): string
{
    return florence_child_render_rfq_form(false);
}
add_shortcode('rfq_form', 'florence_child_rfq_shortcode');

function florence_child_sample_shortcode($atts, $content = ''): string
{
    return florence_child_render_rfq_form(true);
}
add_shortcode('sample_form', 'florence_child_sample_shortcode');
