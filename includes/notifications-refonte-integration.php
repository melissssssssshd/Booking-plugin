<?php
/**
 * 🎨 INTÉGRATION DU SYSTÈME DE NOTIFICATIONS MODERNE
 * ================================================================
 * Intégration du nouveau panneau de notifications refondu
 * avec l'architecture existante du plugin
 * Version: 3.0.0 - Refonte complète
 */

if (!defined('ABSPATH')) {
    exit;
}

class IB_Notifications_Refonte_Integration {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init();
    }
    
    /**
     * 🚀 INITIALISATION
     */
    public function init() {
        // Hooks d'initialisation
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_footer', [$this, 'render_notification_panel']);
        
        // Actions AJAX pour le nouveau système
        add_action('wp_ajax_ib_get_notifications_refonte', [$this, 'ajax_get_notifications']);
        add_action('wp_ajax_ib_mark_notifications_read', [$this, 'ajax_mark_notifications_read']);
        add_action('wp_ajax_ib_archive_notifications', [$this, 'ajax_archive_notifications']);
        add_action('wp_ajax_ib_delete_notifications', [$this, 'ajax_delete_notifications']);
        
        // Système d'archivage automatique
        add_action('ib_daily_cleanup', [$this, 'auto_archive_notifications']);
        
        // Programmer le nettoyage quotidien
        if (!wp_next_scheduled('ib_daily_cleanup')) {
            wp_schedule_event(time(), 'daily', 'ib_daily_cleanup');
        }
        
        // Améliorer la table des notifications si nécessaire
        add_action('admin_init', [$this, 'maybe_upgrade_notifications_table']);
    }
    
    /**
     * 📦 ENREGISTREMENT DES ASSETS
     */
    public function enqueue_assets($hook) {
        // Charger sur toutes les pages admin du plugin
        if (strpos($hook, 'institut-booking') === false) {
            return;
        }
        
        $plugin_url = plugin_dir_url(__FILE__) . '../assets/';
        $version = '3.0.0-' . time(); // Force cache refresh en développement
        
        // CSS moderne
        wp_enqueue_style(
            'ib-notif-refonte',
            $plugin_url . 'css/ib-notif-refonte.css',
            [],
            $version
        );
        
        // JavaScript moderne
        wp_enqueue_script(
            'ib-notif-refonte',
            $plugin_url . 'js/ib-notif-refonte.js',
            ['jquery'],
            $version,
            true
        );
        
        // Variables JavaScript
        wp_localize_script('ib-notif-refonte', 'ib_notif_vars', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ib_notifications_nonce'),
            'settings' => [
                'auto_refresh' => get_option('ib_notif_auto_refresh', true),
                'refresh_interval' => get_option('ib_notif_refresh_interval', 30000),
                'auto_archive_days' => get_option('ib_notif_auto_archive_days', 7),
            ],
            'strings' => [
                'loading' => __('Chargement...', 'institut-booking'),
                'error' => __('Erreur de chargement', 'institut-booking'),
                'no_notifications' => __('Aucune notification', 'institut-booking'),
                'mark_read' => __('Marquer comme lu', 'institut-booking'),
                'delete' => __('Supprimer', 'institut-booking'),
                'archive' => __('Archiver', 'institut-booking'),
                'confirm_delete' => __('Êtes-vous sûr de vouloir supprimer cette notification ?', 'institut-booking'),
                'confirm_delete_multiple' => __('Êtes-vous sûr de vouloir supprimer ces notifications ?', 'institut-booking'),
                'selection_mode_activated' => __('Mode sélection activé', 'institut-booking'),
                'notifications_marked_read' => __('Notifications marquées comme lues', 'institut-booking'),
                'notifications_archived' => __('Notifications archivées', 'institut-booking'),
                'notifications_deleted' => __('Notifications supprimées', 'institut-booking'),
            ]
        ]);
    }
    
    /**
     * 🎨 RENDU DU PANNEAU DE NOTIFICATIONS
     */
    public function render_notification_panel() {
        // Vérifier si on est sur une page admin du plugin
        $screen = get_current_screen();
        if (!$screen || strpos($screen->id, 'institut-booking') === false) {
            return;
        }
        
        // Inclure le template moderne
        include plugin_dir_path(__FILE__) . '../templates/notification-panel-refonte.php';
    }
    
    /**
     * 📥 AJAX - RÉCUPÉRER LES NOTIFICATIONS
     */
    public function ajax_get_notifications() {
        // Vérifier le nonce
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 50;
        $tab = isset($_POST['tab']) ? sanitize_text_field($_POST['tab']) : 'all';
        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        
        // Récupérer les notifications selon l'onglet
        $notifications = $this->get_notifications_by_tab($tab, $limit, $search);
        $unread_notifications = IB_Notifications::get_unread('admin');
        
        // Compteurs par type
        $counts = $this->get_notification_counts();
        
        wp_send_json_success([
            'recent' => $notifications,
            'unread_count' => count($unread_notifications),
            'total_count' => $counts['total'],
            'bookings_count' => $counts['bookings'],
            'emails_count' => $counts['emails'],
            'archived_count' => $counts['archived']
        ]);
    }
    
    /**
     * ✅ AJAX - MARQUER COMME LU (MULTIPLE)
     */
    public function ajax_mark_notifications_read() {
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_ids = isset($_POST['notification_ids']) ? $_POST['notification_ids'] : [];
        
        if (empty($notification_ids)) {
            wp_send_json_error('Aucune notification sélectionnée');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        // Préparer la requête avec placeholders
        $placeholders = implode(',', array_fill(0, count($notification_ids), '%d'));
        $query = $wpdb->prepare(
            "UPDATE {$table} SET status = 'read' WHERE id IN ({$placeholders})",
            $notification_ids
        );
        
        $result = $wpdb->query($query);
        
        if ($result !== false) {
            wp_send_json_success([
                'message' => sprintf(__('%d notification(s) marquée(s) comme lue(s)', 'institut-booking'), count($notification_ids))
            ]);
        } else {
            wp_send_json_error('Erreur lors de la mise à jour');
        }
    }
    
    /**
     * 📂 AJAX - ARCHIVER LES NOTIFICATIONS
     */
    public function ajax_archive_notifications() {
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_ids = isset($_POST['notification_ids']) ? $_POST['notification_ids'] : [];
        
        if (empty($notification_ids)) {
            wp_send_json_error('Aucune notification sélectionnée');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        // Marquer comme archivées
        $placeholders = implode(',', array_fill(0, count($notification_ids), '%d'));
        $query = $wpdb->prepare(
            "UPDATE {$table} SET status = 'archived', archived_at = NOW() WHERE id IN ({$placeholders})",
            $notification_ids
        );
        
        $result = $wpdb->query($query);
        
        if ($result !== false) {
            wp_send_json_success([
                'message' => sprintf(__('%d notification(s) archivée(s)', 'institut-booking'), count($notification_ids))
            ]);
        } else {
            wp_send_json_error('Erreur lors de l\'archivage');
        }
    }
    
    /**
     * 🗑️ AJAX - SUPPRIMER LES NOTIFICATIONS
     */
    public function ajax_delete_notifications() {
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_ids = isset($_POST['notification_ids']) ? $_POST['notification_ids'] : [];
        
        if (empty($notification_ids)) {
            wp_send_json_error('Aucune notification sélectionnée');
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        // Supprimer définitivement
        $placeholders = implode(',', array_fill(0, count($notification_ids), '%d'));
        $query = $wpdb->prepare(
            "DELETE FROM {$table} WHERE id IN ({$placeholders})",
            $notification_ids
        );
        
        $result = $wpdb->query($query);
        
        if ($result !== false) {
            wp_send_json_success([
                'message' => sprintf(__('%d notification(s) supprimée(s)', 'institut-booking'), count($notification_ids))
            ]);
        } else {
            wp_send_json_error('Erreur lors de la suppression');
        }
    }
    
    /**
     * 🔄 ARCHIVAGE AUTOMATIQUE
     */
    public function auto_archive_notifications() {
        $auto_archive_days = get_option('ib_notif_auto_archive_days', 7);
        
        if ($auto_archive_days <= 0) {
            return; // Archivage automatique désactivé
        }
        
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';
        
        // Archiver les notifications résolues anciennes
        $query = $wpdb->prepare(
            "UPDATE {$table} 
             SET status = 'archived', archived_at = NOW(), archive_reason = 'auto_cleanup'
             WHERE status = 'read' 
             AND created_at < DATE_SUB(NOW(), INTERVAL %d DAY)
             AND status != 'archived'",
            $auto_archive_days
        );
        
        $result = $wpdb->query($query);
        
        if ($result > 0) {
            error_log("IB Notifications: {$result} notifications archivées automatiquement");
        }
    }

    /**
     * 📊 RÉCUPÉRER LES NOTIFICATIONS PAR ONGLET
     */
    private function get_notifications_by_tab($tab, $limit, $search = '') {
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';

        $where_conditions = ["target = 'admin'"];
        $params = [];

        // Filtrer par onglet
        switch ($tab) {
            case 'bookings':
                $where_conditions[] = "type IN ('booking_new', 'booking_confirmed', 'booking_cancelled')";
                break;
            case 'emails':
                $where_conditions[] = "type = 'email'";
                break;
            case 'archived':
                $where_conditions[] = "status = 'archived'";
                break;
            case 'all':
            default:
                $where_conditions[] = "status != 'archived'";
                break;
        }

        // Filtrer par recherche
        if (!empty($search)) {
            $where_conditions[] = "(message LIKE %s OR type LIKE %s)";
            $params[] = '%' . $wpdb->esc_like($search) . '%';
            $params[] = '%' . $wpdb->esc_like($search) . '%';
        }

        $where_clause = implode(' AND ', $where_conditions);
        $params[] = $limit;

        $query = "SELECT * FROM {$table} WHERE {$where_clause} ORDER BY created_at DESC LIMIT %d";

        return $wpdb->get_results($wpdb->prepare($query, $params));
    }

    /**
     * 📈 RÉCUPÉRER LES COMPTEURS DE NOTIFICATIONS
     */
    private function get_notification_counts() {
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';

        // Total (non archivées)
        $total = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE target = 'admin' AND status != 'archived'"
        ));

        // Réservations
        $bookings = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table}
             WHERE target = 'admin'
             AND status != 'archived'
             AND type IN ('booking_new', 'booking_confirmed', 'booking_cancelled')"
        ));

        // Emails
        $emails = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table}
             WHERE target = 'admin'
             AND status != 'archived'
             AND type = 'email'"
        ));

        // Archivées
        $archived = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE target = 'admin' AND status = 'archived'"
        ));

        return [
            'total' => intval($total),
            'bookings' => intval($bookings),
            'emails' => intval($emails),
            'archived' => intval($archived)
        ];
    }

    /**
     * 🔧 MISE À JOUR DE LA TABLE DES NOTIFICATIONS
     */
    public function maybe_upgrade_notifications_table() {
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';

        // Vérifier si les nouvelles colonnes existent
        $columns = $wpdb->get_col("DESCRIBE {$table}");

        $new_columns = [
            'archived_at' => 'DATETIME NULL',
            'archive_reason' => 'VARCHAR(255) NULL',
            'client_name' => 'VARCHAR(255) NULL',
            'service_name' => 'VARCHAR(255) NULL'
        ];

        foreach ($new_columns as $column => $definition) {
            if (!in_array($column, $columns)) {
                $wpdb->query("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
            }
        }

        // Ajouter des index pour les performances
        $indexes = [
            'idx_status' => 'status',
            'idx_type' => 'type',
            'idx_created_at' => 'created_at',
            'idx_archived_at' => 'archived_at'
        ];

        foreach ($indexes as $index_name => $column) {
            $existing_indexes = $wpdb->get_results("SHOW INDEX FROM {$table} WHERE Key_name = '{$index_name}'");
            if (empty($existing_indexes)) {
                $wpdb->query("CREATE INDEX {$index_name} ON {$table} ({$column})");
            }
        }
    }

    /**
     * 🧹 NETTOYAGE INTELLIGENT DES NOTIFICATIONS
     */
    public function smart_cleanup_notifications() {
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';

        // 1. Supprimer les notifications de nouvelle réservation si la réservation est confirmée/annulée
        $wpdb->query("
            DELETE n1 FROM {$table} n1
            INNER JOIN {$table} n2 ON n1.message LIKE CONCAT('%', SUBSTRING_INDEX(SUBSTRING_INDEX(n2.message, ' pour ', -1), ' le ', 1), '%')
            WHERE n1.type = 'booking_new'
            AND n2.type IN ('booking_confirmed', 'booking_cancelled')
            AND n1.created_at < n2.created_at
        ");

        // 2. Regrouper les notifications d'email similaires
        $this->group_similar_email_notifications();

        // 3. Supprimer les anciennes notifications archivées (plus de 30 jours)
        $wpdb->query($wpdb->prepare(
            "DELETE FROM {$table}
             WHERE status = 'archived'
             AND archived_at < DATE_SUB(NOW(), INTERVAL 30 DAY)"
        ));
    }

    /**
     * 📧 REGROUPER LES NOTIFICATIONS D'EMAIL SIMILAIRES
     */
    private function group_similar_email_notifications() {
        global $wpdb;
        $table = $wpdb->prefix . 'ib_notifications';

        // Identifier les groupes d'emails similaires du même jour
        $groups = $wpdb->get_results("
            SELECT DATE(created_at) as date_group,
                   COUNT(*) as count,
                   MIN(id) as keep_id,
                   GROUP_CONCAT(id) as all_ids
            FROM {$table}
            WHERE type = 'email'
            AND status != 'archived'
            AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)
            GROUP BY DATE(created_at)
            HAVING COUNT(*) > 3
        ");

        foreach ($groups as $group) {
            $ids_to_delete = explode(',', $group->all_ids);
            $keep_id = array_shift($ids_to_delete); // Garder le premier

            if (!empty($ids_to_delete)) {
                // Mettre à jour le message du premier pour indiquer le regroupement
                $wpdb->update(
                    $table,
                    [
                        'message' => sprintf('%d emails envoyés le %s', $group->count, $group->date_group),
                        'type' => 'email_group'
                    ],
                    ['id' => $keep_id]
                );

                // Supprimer les autres
                $placeholders = implode(',', array_fill(0, count($ids_to_delete), '%d'));
                $wpdb->query($wpdb->prepare(
                    "DELETE FROM {$table} WHERE id IN ({$placeholders})",
                    $ids_to_delete
                ));
            }
        }
    }
}

// Initialiser l'intégration
IB_Notifications_Refonte_Integration::get_instance();
