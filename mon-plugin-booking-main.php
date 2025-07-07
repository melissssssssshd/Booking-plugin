<?php
/*
Plugin Name: Booking-plugin-master
Description: Plugin de réservation institut.
Version: 1.0
*/

// add_action('admin_menu', function() {
//     add_menu_page(
//         'Agenda', // Titre de la page
//         'Agenda', // Menu
//         'administrator', // Capability comme les autres pages (ou 'manage_options')
//         'ib-calendar', // Slug
//         function() {
//             include plugin_dir_path(__FILE__) . 'admin/page-calendar.php';
//         }
//     );
// });
// ...autres hooks et initialisations du plugin ici...

require_once plugin_dir_path(__FILE__) . 'includes/api-rest.php';

error_log('ENQUEUE IB ADMIN SCRIPT');
error_log('JS PATH: ' . plugins_url('assets/js/admin-script.js', __FILE__));
add_action('admin_enqueue_scripts', function($hook) {
    wp_enqueue_script(
        'ib-admin-script',
        plugins_url('assets/js/admin-script.js', __FILE__),
        array(),
        '1.0',
        true
    );
    wp_localize_script('ib-admin-script', 'ajaxurl', admin_url('admin-ajax.php'));
});
