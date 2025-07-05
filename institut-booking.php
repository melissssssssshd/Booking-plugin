<?php
/**
 * Plugin Name: Booking-plugin-master
 * Description: Un plugin de réservation simple avec employés, services et agenda.
 * Version: 1.0
 * Author: Mélissa
 */

if (!defined('ABSPATH')) exit;

// Définition des constantes
define('IB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('IB_PLUGIN_URL', plugin_dir_url(__FILE__));

// Chargement des helpers de base
require_once IB_PLUGIN_DIR . 'includes/helpers.php';

// Chargement des classes principales
require_once IB_PLUGIN_DIR . 'includes/class-services.php';
require_once IB_PLUGIN_DIR . 'includes/class-employees.php';
require_once IB_PLUGIN_DIR . 'includes/class-bookings.php';
require_once IB_PLUGIN_DIR . 'includes/class-clients.php';
require_once IB_PLUGIN_DIR . 'includes/class-extras.php';
require_once IB_PLUGIN_DIR . 'includes/class-coupons.php';
require_once IB_PLUGIN_DIR . 'includes/class-feedback.php';
require_once IB_PLUGIN_DIR . 'includes/class-logs.php';
require_once IB_PLUGIN_DIR . 'includes/class-settings.php';
require_once IB_PLUGIN_DIR . 'includes/class-push.php';
require_once IB_PLUGIN_DIR . 'includes/class-whatsapp.php';
require_once IB_PLUGIN_DIR . 'includes/class-calendar.php';
require_once IB_PLUGIN_DIR . 'includes/class-categories.php';
require_once IB_PLUGIN_DIR . 'includes/class-availability.php';

// Chargement des fichiers d'installation et de rôles
require_once IB_PLUGIN_DIR . 'includes/install.php';
require_once IB_PLUGIN_DIR . 'includes/roles.php';

// Chargement des fichiers de notification
require_once IB_PLUGIN_DIR . 'includes/notifications.php';
require_once IB_PLUGIN_DIR . 'includes/sms.php';

// Chargement des fichiers admin UNIQUEMENT dans les callbacks de menu (voir plus bas)

// Enregistrement des menus admin
function ib_admin_menu() {
    // SUPPRESSION de la vérification de droits
    // if (!current_user_can('administrator')) {
    //     return;
    // }

    add_menu_page(
        __('Institut Booking', 'institut-booking'),
        __('Institut Booking', 'institut-booking'),
        'manage_options',
        'institut-booking',
        'institut_booking_fullpage',
        'dashicons-calendar-alt',
        30
    );

    // Sous-menus
    add_submenu_page(
        'institut-booking',
        __('Dashboard', 'institut-booking'),
        __('Dashboard', 'institut-booking'),
        'manage_options',
        'institut-booking',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Services', 'institut-booking'),
        __('Services', 'institut-booking'),
        'manage_options',
        'institut-booking-services',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking-services',
        __('Catégories', 'institut-booking'),
        __('Catégories', 'institut-booking'),
        'manage_options',
        'institut-booking-categories',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Employés', 'institut-booking'),
        __('Employés', 'institut-booking'),
        'manage_options',
        'institut-booking-employees',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Réservations', 'institut-booking'),
        __('Réservations', 'institut-booking'),
        'manage_options',
        'institut-booking-bookings',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Clients', 'institut-booking'),
        __('Clients', 'institut-booking'),
        'manage_options',
        'institut-booking-clients',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Notifications', 'institut-booking'),
        __('Notifications', 'institut-booking'),
        'manage_options',
        'institut-booking-notifications',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('SMS', 'institut-booking'),
        __('SMS', 'institut-booking'),
        'manage_options',
        'institut-booking-sms',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Synchronisation Calendrier', 'institut-booking'),
        __('Synchronisation Calendrier', 'institut-booking'),
        'manage_options',
        'institut-booking-calendar-sync',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Paramètres', 'institut-booking'),
        __('Paramètres', 'institut-booking'),
        'manage_options',
        'institut-booking-settings',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Agenda', 'institut-booking'),
        __('Agenda', 'institut-booking'),
        'manage_options',
        'institut-booking-calendar',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Coupons', 'institut-booking'),
        __('Coupons', 'institut-booking'),
        'manage_options',
        'institut-booking-coupons',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Extras', 'institut-booking'),
        __('Extras', 'institut-booking'),
        'manage_options',
        'institut-booking-extras',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Analytics', 'institut-booking'),
        __('Analytics', 'institut-booking'),
        'manage_options',
        'institut-booking-analytics',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Logs', 'institut-booking'),
        __('Logs', 'institut-booking'),
        'manage_options',
        'institut-booking-logs',
        'institut_booking_fullpage'
    );

    add_submenu_page(
        'institut-booking',
        __('Avis', 'institut-booking'),
        __('Avis', 'institut-booking'),
        'manage_options',
        'institut-booking-feedback',
        'institut_booking_fullpage'
    );
}
add_action('admin_menu', 'ib_admin_menu');

// Enregistrement des assets
function ib_admin_assets($hook) {
    // Vérifier si nous sommes sur une page de notre plugin
    if (strpos($hook, 'institut-booking') === false) {
        return;
    }

    // Enregistrement des styles
    wp_enqueue_style('ib-admin-style', IB_PLUGIN_URL . 'assets/css/admin-style.css', [], '1.0');
    wp_enqueue_style('dashicons');
    
    // Enregistrement des scripts
    wp_enqueue_script('ib-admin', IB_PLUGIN_URL . 'assets/js/admin.js', ['jquery'], '1.0', true);
    
    // Ajout des dépendances pour les datepickers et colorpickers
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'ib_admin_assets');

// Shortcode du formulaire de réservation
function ib_booking_form_shortcode() {
    ob_start();
    include IB_PLUGIN_DIR . 'partials/booking-form.php';
    return ob_get_clean();
}
add_shortcode('institut_booking_form', 'ib_booking_form_shortcode');

// Activation du plugin
register_activation_hook(__FILE__, 'ib_install_plugin');

// Action AJAX pour les créneaux disponibles
add_action('wp_ajax_get_available_slots', 'handle_get_available_slots');
add_action('wp_ajax_nopriv_get_available_slots', 'handle_get_available_slots');

function handle_get_available_slots() {
    check_ajax_referer('ib_nonce', 'nonce');
    
    $employee_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;
    $service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : 0;
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    
    if (!$employee_id || !$service_id || !$date) {
        wp_send_json_error(['message' => 'Paramètres manquants']);
        return;
    }
    
    $slots = IB_Availability::get_available_slots($employee_id, $service_id, $date);
    
    wp_send_json_success($slots);
}

// Traitement des actions extras (WordPress-compliant)
add_action('admin_init', function() {
    if (!is_admin() || !isset($_GET['page']) || $_GET['page'] !== 'institut-booking-extras') return;
    if (isset($_POST['ib_add_extra'])) {
        IB_Extras::add($_POST['service_id'], $_POST['name'], $_POST['price'], $_POST['duration']);
        wp_redirect(admin_url('admin.php?page=institut-booking-extras&added=1'));
        exit;
    }
    if (isset($_GET['delete'])) {
        IB_Extras::delete((int)$_GET['delete']);
        wp_redirect(admin_url('admin.php?page=institut-booking-extras&deleted=1'));
        exit;
    }
    if (isset($_POST['ib_update_extra'])) {
        IB_Extras::update($_POST['id'], $_POST['service_id'], $_POST['name'], $_POST['price'], $_POST['duration']);
        wp_redirect(admin_url('admin.php?page=institut-booking-extras&updated=1'));
        exit;
    }
});

// Traitement des actions coupons (WordPress-compliant)
add_action('admin_init', function() {
    if (!is_admin() || !isset($_GET['page']) || $_GET['page'] !== 'institut-booking-coupons') return;
    if (isset($_POST['ib_add_coupon'])) {
        IB_Coupons::add($_POST['code'], $_POST['discount'], $_POST['type'], $_POST['usage_limit'], $_POST['valid_from'], $_POST['valid_to']);
        wp_redirect(admin_url('admin.php?page=institut-booking-coupons&added=1'));
        exit;
    }
    if (isset($_GET['delete'])) {
        IB_Coupons::delete((int)$_GET['delete']);
        wp_redirect(admin_url('admin.php?page=institut-booking-coupons&deleted=1'));
        exit;
    }
    if (isset($_POST['ib_update_coupon'])) {
        IB_Coupons::update($_POST['id'], $_POST['code'], $_POST['discount'], $_POST['type'], $_POST['usage_limit'], $_POST['valid_from'], $_POST['valid_to']);
        wp_redirect(admin_url('admin.php?page=institut-booking-coupons&updated=1'));
        exit;
    }
});

// Traitement des actions catégories (WordPress-compliant)
add_action('admin_init', function() {
    if (!is_admin() || !isset($_GET['page']) || $_GET['page'] !== 'institut-booking-categories') return;
    global $wpdb;
    if (isset($_POST['ib_add_category'])) {
        IB_Categories::add($_POST['name'], $_POST['color'], $_POST['icon']);
        wp_redirect(admin_url('admin.php?page=institut-booking-categories&added=1'));
        exit;
    }
    if (isset($_GET['delete'])) {
        IB_Categories::delete((int)$_GET['delete']);
        wp_redirect(admin_url('admin.php?page=institut-booking-categories&deleted=1'));
        exit;
    }
    if (isset($_POST['ib_update_category'])) {
        IB_Categories::update($_POST['id'], $_POST['name'], $_POST['color'], $_POST['icon']);
        wp_redirect(admin_url('admin.php?page=institut-booking-categories&updated=1'));
        exit;
    }
});

// Traitement des actions réglages (WordPress-compliant)
add_action('admin_init', function() {
    if (!is_admin() || !isset($_GET['page']) || $_GET['page'] !== 'ib-settings') return;
    // Sauvegarde des couleurs
    if (isset($_POST['save_settings'])) {
        update_option('ib_color_primary', sanitize_hex_color($_POST['color_primary']));
        update_option('ib_color_accent', sanitize_hex_color($_POST['color_accent']));
        update_option('ib_color_secondary', sanitize_hex_color($_POST['color_secondary']));
        update_option('ib_color_danger', sanitize_hex_color($_POST['color_danger']));
        wp_redirect(admin_url('admin.php?page=ib-settings&colors_saved=1'));
        exit;
    }
    // Changement de mode d'affichage
    if (isset($_POST['ib_save_color_mode'])) {
        update_option('ib_color_mode', sanitize_text_field($_POST['ib_color_mode']));
        wp_redirect(admin_url('admin.php?page=ib-settings&mode_saved=1'));
        exit;
    }
    // Sauvegarde horaires hebdo
    if (isset($_POST['ib_save_hours'])) {
        update_option('ib_company_hours', $_POST['hours']);
        wp_redirect(admin_url('admin.php?page=ib-settings&hours_saved=1'));
        exit;
    }
    // Ajout jour off
    if (isset($_POST['ib_add_offday']) && !empty($_POST['offday'])) {
        $offdays = get_option('ib_company_offdays', []);
        $offdays[] = $_POST['offday'];
        $offdays = array_unique($offdays);
        update_option('ib_company_offdays', $offdays);
        wp_redirect(admin_url('admin.php?page=ib-settings&offday_added=1'));
        exit;
    }
    // Suppression jour off
    if (isset($_GET['remove_offday'])) {
        $offdays = get_option('ib_company_offdays', []);
        $offdays = array_diff($offdays, [$_GET['remove_offday']]);
        update_option('ib_company_offdays', $offdays);
        wp_redirect(admin_url('admin.php?page=ib-settings&offday_removed=1'));
        exit;
    }
    // Ajout journée spéciale
    if (isset($_POST['ib_add_specialday']) && !empty($_POST['specialday'])) {
        $specials = get_option('ib_company_specialdays', []);
        $specials[$_POST['specialday']] = [
            'start' => $_POST['special_start'],
            'end' => $_POST['special_end']
        ];
        update_option('ib_company_specialdays', $specials);
        wp_redirect(admin_url('admin.php?page=ib-settings&specialday_added=1'));
        exit;
    }
    // Suppression journée spéciale
    if (isset($_GET['remove_specialday'])) {
        $specials = get_option('ib_company_specialdays', []);
        unset($specials[$_GET['remove_specialday']]);
        update_option('ib_company_specialdays', $specials);
        wp_redirect(admin_url('admin.php?page=ib-settings&specialday_removed=1'));
        exit;
    }
});

// Traitement des actions notifications (WordPress-compliant)
add_action('admin_init', function() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'institut-booking-notifications') return;
    if (isset($_POST['save_notifications'])) {
        update_option('ib_notify_client_confirm', wp_kses_post($_POST['notify_client_confirm']));
        update_option('ib_notify_client_cancel', wp_kses_post($_POST['notify_client_cancel']));
        update_option('ib_notify_admin_confirm', wp_kses_post($_POST['notify_admin_confirm']));
        update_option('ib_notify_admin_cancel', wp_kses_post($_POST['notify_admin_cancel']));
        update_option('ib_notify_recept_confirm', wp_kses_post($_POST['notify_recept_confirm']));
        update_option('ib_notify_recept_cancel', wp_kses_post($_POST['notify_recept_cancel']));
        update_option('ib_notify_reminder', wp_kses_post($_POST['notify_reminder']));
        wp_redirect(admin_url('admin.php?page=institut-booking-notifications&saved=1'));
        exit;
    }
});

// Traitement des actions notifications avancées (WordPress-compliant)
add_action('admin_init', function() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'institut-booking-notifications-advanced') return;
    if (isset($_POST['ib_save_notifications_advanced'])) {
        update_option('ib_push_enable', isset($_POST['ib_push_enable']) ? 1 : 0);
        update_option('ib_whatsapp_enable', isset($_POST['ib_whatsapp_enable']) ? 1 : 0);
        update_option('ib_whatsapp_token', sanitize_text_field($_POST['ib_whatsapp_token']));
        update_option('ib_reminder_enable', isset($_POST['ib_reminder_enable']) ? 1 : 0);
        update_option('ib_reminder_time', sanitize_text_field($_POST['ib_reminder_time']));
        wp_redirect(admin_url('admin.php?page=institut-booking-notifications-advanced&saved=1'));
        exit;
    }
});

// Traitement des actions SMS (WordPress-compliant)
add_action('admin_init', function() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'institut-booking-sms') return;
    if (isset($_POST['save_sms'])) {
        update_option('ib_twilio_sid', sanitize_text_field($_POST['twilio_sid']));
        update_option('ib_twilio_token', sanitize_text_field($_POST['twilio_token']));
        update_option('ib_twilio_from', sanitize_text_field($_POST['twilio_from']));
        wp_redirect(admin_url('admin.php?page=institut-booking-sms&saved=1'));
        exit;
    }
});

// Traitement des actions synchronisation calendrier (WordPress-compliant)
add_action('admin_init', function() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'institut-booking-calendar-sync') return;
    if (isset($_POST['ib_save_calendar_sync'])) {
        update_option('ib_gcal_client_id', sanitize_text_field($_POST['ib_gcal_client_id']));
        update_option('ib_gcal_client_secret', sanitize_text_field($_POST['ib_gcal_client_secret']));
        update_option('ib_outlook_client_id', sanitize_text_field($_POST['ib_outlook_client_id']));
        update_option('ib_outlook_client_secret', sanitize_text_field($_POST['ib_outlook_client_secret']));
        wp_redirect(admin_url('admin.php?page=institut-booking-calendar-sync&saved=1'));
        exit;
    }
});

// Traitement des actions feedback (WordPress-compliant)
add_action('admin_init', function() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'ib-feedback') return;
    if (isset($_GET['delete'])) {
        IB_Feedback::delete((int)$_GET['delete']);
        wp_redirect(admin_url('admin.php?page=ib-feedback&deleted=1'));
        exit;
    }
    if (isset($_GET['moderate'])) {
        IB_Feedback::moderate((int)$_GET['moderate'], $_GET['status']);
        wp_redirect(admin_url('admin.php?page=ib-feedback&moderated=1'));
        exit;
    }
});

// Traitement des actions réceptionniste (WordPress-compliant)
add_action('admin_init', function() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'institut-booking-receptionist') return;
    if (isset($_POST['add_booking'])) {
        IB_Bookings::add([
            'service_id' => $_POST['service_id'],
            'employee_id' => $_POST['employee_id'],
            'client_name' => $_POST['client_name'],
            'client_email' => $_POST['client_email'],
            'date' => $_POST['date'],
            'time' => $_POST['time'],
        ]);
        wp_redirect(admin_url('admin.php?page=institut-booking-receptionist&added=1'));
        exit;
    }
    if (isset($_GET['delete'])) {
        IB_Bookings::delete($_GET['delete']);
        wp_redirect(admin_url('admin.php?page=institut-booking-receptionist&deleted=1'));
        exit;
    }
});

// Enqueue scripts and styles for the booking form on the frontend
function ib_enqueue_booking_form_assets() {
    // Only enqueue on pages where the shortcode is present (optional: optimize if needed)
    wp_enqueue_style('ib-admin-style', IB_PLUGIN_URL . 'assets/css/admin-style.css', [], '1.0');
    // Ajout d'un versioning dynamique pour forcer le rafraîchissement du JS
    wp_enqueue_script('ib-admin-script', IB_PLUGIN_URL . 'assets/js/admin-script.js', ['jquery'], time(), true);
    wp_enqueue_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], null, true);
    wp_enqueue_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], null);
    // Enqueue le script de gestion des créneaux
    // wp_enqueue_script('ib-booking-form', IB_PLUGIN_URL . 'assets/js/booking-form.js', ['jquery'], time(), true);
    // Inject ajaxurl for frontend
    wp_localize_script('ib-booking-form', 'ajaxurl', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'ib_enqueue_booking_form_assets');

// ROUTER WEB APP
function institut_booking_fullpage() {
    // Vérifier si l'utilisateur est admin
    if (!current_user_can('administrator')) {
        wp_die(__('Accès refusé. Vous devez être administrateur pour accéder à cette page.', 'institut-booking'));
    }

    // Masquer le menu admin WP et notifications
    echo '<style>
        #adminmenumain, #wpadminbar, #wpfooter, .update-nag, .notice, .error, .updated { display: none !important; }
        #wpcontent, #wpbody-content { margin-left: 0 !important; }
        body.wp-admin { background: #f4f6fb; }
    </style>';

    // Récupérer le slug de la page actuelle
    $current_page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : 'institut-booking';
    $route = str_replace('institut-booking-', '', $current_page);
    if ($route === 'institut-booking') {
        $route = 'dashboard';
    }

    // Capture le contenu de la page dans un buffer
    ob_start();
    switch ($route) {
        case 'dashboard':
            include IB_PLUGIN_DIR . 'admin/page-dashboard.php';
            break;
        case 'services':
            include IB_PLUGIN_DIR . 'admin/page-services.php';
            break;
        case 'employees':
            include IB_PLUGIN_DIR . 'admin/page-employees.php';
            break;
        case 'bookings':
            include IB_PLUGIN_DIR . 'admin/page-bookings.php';
            break;
        case 'clients':
            include IB_PLUGIN_DIR . 'admin/page-clients.php';
            break;
        case 'extras':
            include IB_PLUGIN_DIR . 'admin/page-extras.php';
            break;
        case 'coupons':
            include IB_PLUGIN_DIR . 'admin/page-coupons.php';
            break;
        case 'categories':
            include IB_PLUGIN_DIR . 'admin/page-categories.php';
            break;
        case 'notifications':
            include IB_PLUGIN_DIR . 'admin/page-notifications.php';
            break;
        case 'notifications-advanced':
            include IB_PLUGIN_DIR . 'admin/page-notifications-advanced.php';
            break;
        case 'sms':
            include IB_PLUGIN_DIR . 'admin/page-sms.php';
            break;
        case 'calendar-sync':
            include IB_PLUGIN_DIR . 'admin/page-calendar-sync.php';
            break;
        case 'settings':
            include IB_PLUGIN_DIR . 'admin/page-settings.php';
            if (function_exists('institut_booking_settings_page')) {
                institut_booking_settings_page();
            }
            break;
        case 'calendar':
            include IB_PLUGIN_DIR . 'admin/page-calendar.php';
            break;
        case 'feedback':
            include IB_PLUGIN_DIR . 'admin/page-feedback.php';
            break;
        case 'analytics':
            include IB_PLUGIN_DIR . 'admin/page-analytics.php';
            break;
        case 'logs':
            include IB_PLUGIN_DIR . 'admin/page-logs.php';
            break;
        default:
            echo '<h2>Page introuvable</h2>';
    }
    $GLOBALS['ib_page_content'] = ob_get_clean();
    include IB_PLUGIN_DIR . 'admin/layout.php';
}

// Charger le CSS web app sur la page du plugin
function ib_enqueue_webapp_css($hook) {
    if (isset($_GET['page']) && $_GET['page'] === 'institut-booking') {
        // wp_enqueue_style('ib-admin', IB_PLUGIN_URL . 'assets/css/admin.css', [], '1.0'); // Désactivé pour éviter les conflits
        wp_enqueue_style('ib-admin-style', IB_PLUGIN_URL . 'assets/css/admin-style.css', [], '1.0');
    }
}
add_action('admin_enqueue_scripts', 'ib_enqueue_webapp_css');

// Fin du fichier, ne rien ajouter après cette ligne pour éviter toute sortie parasite.

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('jquery');
});
