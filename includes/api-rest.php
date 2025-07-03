<?php
// API RESTful de base pour le plugin
if (!defined('ABSPATH')) exit;

add_action('rest_api_init', function() {
    register_rest_route('institut-booking/v1', '/bookings', [
        'methods' => 'GET',
        'callback' => function($request) {
            if (!current_user_can('manage_options')) return new WP_Error('forbidden', 'Accès refusé', ['status' => 403]);
            require_once plugin_dir_path(__FILE__) . '/class-bookings.php';
            $bookings = IB_Bookings::get_all();
            return rest_ensure_response($bookings);
        },
        'permission_callback' => '__return_true',
    ]);
    // Ajoute d'autres endpoints (clients, services, etc.)
});

add_action('wp_ajax_ib_get_slots', 'ib_get_slots');
add_action('wp_ajax_nopriv_ib_get_slots', 'ib_get_slots');
function ib_get_slots() {
    file_put_contents(__DIR__.'/debug_ajax.txt', print_r($_POST, true));
    $employee_id = intval($_POST['employee_id']);
    $service_id = intval($_POST['service_id']);
    $date = sanitize_text_field($_POST['date']);

    // --- LOGIQUE RÉELLE DE DISPONIBILITÉ ---
    // Exemple : horaires de travail de l'employé (à remplacer par ta logique)
    $work_hours = ['09:00','10:00','11:00','14:00','15:00','16:00'];

    // Récupère les réservations existantes pour cet employé, ce service, ce jour
    global $wpdb;
    $booked = $wpdb->get_col($wpdb->prepare(
        "SELECT time FROM {$wpdb->prefix}ib_bookings WHERE employee_id=%d AND service_id=%d AND date=%s",
        $employee_id, $service_id, $date
    ));
    // Filtre les créneaux déjà réservés
    $available = array_values(array_diff($work_hours, $booked));

    wp_send_json_success($available);
    wp_die();
}
