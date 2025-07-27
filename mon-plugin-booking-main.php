<?php
/*
Plugin Name: Booking-plugin-master
Description: Plugin de réservation institut.
Version: 1.0
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/api-rest.php';
// DÉSACTIVÉ - Cause des conflits avec le script final
// require_once plugin_dir_path(__FILE__) . 'includes/ajax-notifications.php';

// DÉSACTIVÉ - Cause des conflits avec le script final
// add_action('admin_enqueue_scripts', function($hook) {
//     wp_enqueue_script(
//         'ib-admin-script',
//         plugins_url('assets/js/admin-script.js', __FILE__),
//         array(),
//         '1.0',
//         true
//     );
//
//     wp_localize_script('ib-admin-script', 'ib_admin_vars', array(
//         'ajaxurl' => admin_url('admin-ajax.php')
//     ));
//
//     wp_localize_script('ib-admin-script', 'IBNotifBell', array(
//         'ajaxurl' => admin_url('admin-ajax.php'),
//         'nonce' => wp_create_nonce('ib_notifications_nonce')
//     ));
// });

// Add AJAX handlers for notifications
add_action('wp_ajax_ib_get_notifications', 'ib_ajax_get_notifications');
add_action('wp_ajax_ib_mark_notification_read', 'ib_ajax_mark_notification_read');
add_action('wp_ajax_ib_mark_all_notifications_read', 'ib_ajax_mark_all_notifications_read');

function ib_ajax_get_notifications() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
        wp_die('Security check failed');
    }
    
    // Include notifications class if not loaded
    if (!class_exists('IB_Notifications')) {
        require_once plugin_dir_path(__FILE__) . 'includes/notifications.php';
    }
    
    $recent = IB_Notifications::get_recent('admin', 15);
    $unread_count = count(IB_Notifications::get_unread('admin'));
    
    wp_send_json_success([
        'recent' => $recent,
        'unread_count' => $unread_count
    ]);
}

function ib_ajax_mark_notification_read() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
        wp_die('Security check failed');
    }
    
    $id = intval($_POST['id']);
    
    // Include notifications class if not loaded
    if (!class_exists('IB_Notifications')) {
        require_once plugin_dir_path(__FILE__) . 'includes/notifications.php';
    }
    
    IB_Notifications::mark_as_read($id);
    wp_send_json_success();
}

function ib_ajax_mark_all_notifications_read() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
        wp_die('Security check failed');
    }
    
    // Include notifications class if not loaded
    if (!class_exists('IB_Notifications')) {
        require_once plugin_dir_path(__FILE__) . 'includes/notifications.php';
    }
    
    IB_Notifications::mark_all_as_read('admin');
    wp_send_json_success();
}
