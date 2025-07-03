<?php
/*
Plugin Name: Mon Plugin Booking
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
