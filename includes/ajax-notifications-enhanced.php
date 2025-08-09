<?php
if (!defined('ABSPATH')) exit;

/**
 * Gestionnaire AJAX amélioré pour les notifications ultra-modernes
 */
class IB_Ajax_Notifications_Enhanced {
    
    public static function init() {
        // Actions AJAX pour les utilisateurs connectés
        add_action('wp_ajax_ib_get_notifications', [self::class, 'get_notifications']);
        add_action('wp_ajax_ib_delete_notification', [self::class, 'delete_notification']);
        add_action('wp_ajax_ib_delete_all_notifications', [self::class, 'delete_all_notifications']);
        add_action('wp_ajax_ib_mark_notification_read', [self::class, 'mark_notification_read']);
        add_action('wp_ajax_ib_mark_all_notifications_read', [self::class, 'mark_all_notifications_read']);
        add_action('wp_ajax_ib_check_new_notifications', [self::class, 'check_new_notifications']);

        // Enregistrer les scripts et styles modernes
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_modern_assets']);

        // Debug : vérifier que les actions sont bien enregistrées
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('🔧 IB_Ajax_Notifications_Enhanced: Actions AJAX enregistrées');
        }
    }
    
    /**
     * Récupérer les notifications avec pagination et filtrage
     */
    public static function get_notifications() {
        // Debug
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('🔧 get_notifications appelée avec POST: ' . print_r($_POST, true));
        }

        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce') &&
            !wp_verify_nonce($_POST['nonce'], 'ib_notif_bell')) {
            wp_die('Erreur de sécurité');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 50;
        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        $type_filter = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
        
        // Construire la requête - MODIFIÉ pour ne retourner que les nouvelles réservations
        $where_conditions = [
            "target = 'admin'",
            "type = 'reservation'"  // On ne garde que les nouvelles réservations
        ];
        $params = [];
        
        if (!empty($search)) {
            $where_conditions[] = "message LIKE %s";
            $params[] = '%' . $wpdb->esc_like($search) . '%';
        }
        
        // Désactivé le filtrage par type car on ne veut que les nouvelles réservations
        // if (!empty($type_filter) && $type_filter !== 'all') {
        //     // Mapping des filtres vers les types de base de données
        //     $type_mapping = [
        //         'confirmed' => ['booking_confirmed', 'booking_new', 'reservation'],
        //         'cancelled' => ['booking_cancelled'],
        //         'reminder' => ['booking_pending']
        //     ];
        //     
        //     if (isset($type_mapping[$type_filter])) {
        //         $placeholders = implode(',', array_fill(0, count($type_mapping[$type_filter]), '%s'));
        //         $where_conditions[] = "type IN ($placeholders)";
        //         $params = array_merge($params, $type_mapping[$type_filter]);
        //     }
        // }
        
        $where_clause = implode(' AND ', $where_conditions);
        $params[] = $limit;
        
        $query = "SELECT * FROM $table WHERE $where_clause ORDER BY created_at DESC LIMIT %d";
        $notifications = $wpdb->get_results($wpdb->prepare($query, $params));
        
        // Compter les non lues - MODIFIÉ pour ne compter que les nouvelles réservations
        $unread_query = $wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE target = 'admin' AND status = 'unread' AND type = 'reservation'"
        );
        $unread_count = $wpdb->get_var($unread_query);
        
        // Formater les données pour le frontend
        $formatted_notifications = [];
        foreach ($notifications as $notification) {
            $formatted_notifications[] = [
                'id' => $notification->id,
                'type' => $notification->type,
                'message' => $notification->message,
                'status' => $notification->status,
                'link' => $notification->link,
                'created_at' => $notification->created_at,
                'target' => $notification->target
            ];
        }
        
        wp_send_json_success([
            'notifications' => $formatted_notifications,
            'unread_count' => intval($unread_count),
            'total_count' => count($formatted_notifications)
        ]);
    }
    
    /**
     * Marquer une notification comme lue
     */
    public static function mark_notification_read() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce') && 
            !wp_verify_nonce($_POST['nonce'], 'ib_notif_bell')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        
        if (!$notification_id) {
            wp_send_json_error('ID de notification manquant');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        $result = $wpdb->update(
            $table,
            ['status' => 'read'],
            ['id' => $notification_id, 'target' => 'admin'],
            ['%s'],
            ['%d', '%s']
        );
        
        if ($result !== false) {
            wp_send_json_success(['message' => 'Notification marquée comme lue']);
        } else {
            wp_send_json_error('Erreur lors de la mise à jour');
        }
    }
    
    /**
     * Marquer toutes les notifications comme lues
     */
    public static function mark_all_notifications_read() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce') && 
            !wp_verify_nonce($_POST['nonce'], 'ib_notif_bell')) {
            wp_die('Erreur de sécurité');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        $result = $wpdb->update(
            $table,
            ['status' => 'read'],
            ['target' => 'admin', 'status' => 'unread'],
            ['%s'],
            ['%s', '%s']
        );
        
        if ($result !== false) {
            wp_send_json_success(['message' => 'Toutes les notifications ont été marquées comme lues']);
        } else {
            wp_send_json_error('Erreur lors de la mise à jour');
        }
    }
    
    /**
     * Supprimer une notification
     */
    public static function delete_notification() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce') && 
            !wp_verify_nonce($_POST['nonce'], 'ib_notif_bell')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        
        if (!$notification_id) {
            wp_send_json_error('ID de notification manquant');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        $result = $wpdb->delete(
            $table,
            ['id' => $notification_id, 'target' => 'admin'],
            ['%d', '%s']
        );
        
        if ($result !== false) {
            wp_send_json_success(['message' => 'Notification supprimée']);
        } else {
            wp_send_json_error('Erreur lors de la suppression');
        }
    }
    
    /**
     * Supprimer toutes les notifications
     */
    public static function delete_all_notifications() {
        // Vérifier le nonce de sécurité et les permissions
        if (!check_ajax_referer('ib_notifications_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => 'Erreur de sécurité. Veuillez rafraîchir la page et réessayer.'
            ], 403);
        }

        // Vérifier les capacités utilisateur
        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                'message' => 'Vous n\'avez pas les permissions nécessaires pour effectuer cette action.'
            ], 403);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'ib_notifications';
        
        // Compter le nombre de notifications avant suppression pour le log
        $count_before = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE type = 'booking_new'");
        
        // Supprimer uniquement les notifications de nouvelles réservations
        $result = $wpdb->delete(
            $table_name,
            ['type' => 'booking_new'],
            ['%s']
        );
        
        if ($result === false) {
            wp_send_json_error([
                'message' => 'Une erreur est survenue lors de la suppression des notifications.',
                'error' => $wpdb->last_error
            ]);
        }
        
        // Mettre à jour le cache si nécessaire
        if (function_exists('wp_cache_flush')) {
            wp_cache_flush();
        }
        
        wp_send_json_success([
            'message' => 'Toutes les notifications ont été supprimées avec succès.',
            'deleted_count' => $count_before
        ]);
    }
    
    /**
     * Vérifier s'il y a de nouvelles notifications
     */
    public static function check_new_notifications() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce') && 
            !wp_verify_nonce($_POST['nonce'], 'ib_notif_bell')) {
            wp_die('Erreur de sécurité');
        }
        
        $last_check = isset($_POST['last_check']) ? sanitize_text_field($_POST['last_check']) : '';
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        $query = "SELECT COUNT(*) FROM $table WHERE target = 'admin'";
        $params = [];
        
        if (!empty($last_check)) {
            $query .= " AND created_at > %s";
            $params[] = $last_check;
        }
        
        $new_count = $wpdb->get_var($wpdb->prepare($query, $params));
        
        wp_send_json_success([
            'has_new' => $new_count > 0,
            'new_count' => intval($new_count)
        ]);
    }
    
    /**
     * Enregistrer les assets modernes (CSS et JS)
     */
    public static function enqueue_modern_assets($hook) {
        // Charger sur toutes les pages admin pour les notifications
        if (!is_admin()) {
            return;
        }
        
        $plugin_url = plugin_dir_url(__FILE__) . '../assets/';
        $version = '2024.1.2-enhanced-' . time(); // Force cache refresh
        
        // Enregistrer le script ultra-moderne
        wp_enqueue_script(
            'ib-ultra-notifications',
            $plugin_url . 'js/ultra-simple-notification.js',
            ['jquery'],
            $version,
            true
        );

        // Passer les variables nécessaires au JavaScript
        wp_localize_script('ib-ultra-notifications', 'ib_notif_vars', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ib_notifications_nonce'),
            'strings' => [
                'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer cette notification ?',
                'error_occurred' => 'Une erreur est survenue. Veuillez réessayer.',
                'notification_deleted' => 'Notification supprimée',
                'all_marked_read' => 'Toutes les notifications ont été marquées comme lues',
                'no_notifications' => 'Aucune notification',
                'loading' => 'Chargement...'
            ]
        ]);
    }
}

// Initialiser la classe
IB_Ajax_Notifications_Enhanced::init();
