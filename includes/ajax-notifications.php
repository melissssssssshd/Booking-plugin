<?php
if (!defined('ABSPATH')) exit;

/**
 * Gestionnaire AJAX pour les notifications modernes
 * Version 2024 - Actions pour l'interface modernisée
 */

class IB_Ajax_Notifications {
    
    public static function init() {
        // Actions AJAX pour les utilisateurs connectés
        add_action('wp_ajax_ib_get_notifications', [self::class, 'get_notifications']);
        add_action('wp_ajax_ib_delete_notification', [self::class, 'delete_notification']);
        add_action('wp_ajax_ib_mark_notification_read', [self::class, 'mark_notification_read']);
        add_action('wp_ajax_ib_mark_all_notifications_read', [self::class, 'mark_all_notifications_read']);
        add_action('wp_ajax_ib_check_new_notifications', [self::class, 'check_new_notifications']);
        
        // Enregistrer les scripts et styles modernes
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_modern_assets']);
    }
    
    /**
     * Récupérer les notifications avec pagination
     */
    public static function get_notifications() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 15;
        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        
        // Récupérer les notifications
        $notifications = IB_Notifications::get_recent('admin', $limit, $search);
        $unread_notifications = IB_Notifications::get_unread('admin');
        
        wp_send_json_success([
            'recent' => $notifications,
            'unread_count' => count($unread_notifications),
            'total_count' => count($notifications)
        ]);
    }
    
    /**
     * Supprimer une notification
     */
    public static function delete_notification() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_id = intval($_POST['id']);
        
        if ($notification_id <= 0) {
            wp_send_json_error('ID de notification invalide');
        }
        
        global $wpdb;
        $result = $wpdb->delete(
            $wpdb->prefix . 'ib_notifications',
            ['id' => $notification_id],
            ['%d']
        );
        
        if ($result === false) {
            wp_send_json_error('Erreur lors de la suppression de la notification');
        }
        
        // Log de l'action
        error_log("[IB Booking] Notification supprimée: ID {$notification_id}");
        
        wp_send_json_success([
            'message' => 'Notification supprimée avec succès',
            'deleted_id' => $notification_id
        ]);
    }
    
    /**
     * Marquer une notification comme lue
     */
    public static function mark_notification_read() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $notification_id = intval($_POST['id']);
        
        if ($notification_id <= 0) {
            wp_send_json_error('ID de notification invalide');
        }
        
        IB_Notifications::mark_as_read($notification_id);
        
        wp_send_json_success([
            'message' => 'Notification marquée comme lue',
            'read_id' => $notification_id
        ]);
    }
    
    /**
     * Marquer toutes les notifications comme lues
     */
    public static function mark_all_notifications_read() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        IB_Notifications::mark_all_as_read('admin');
        
        wp_send_json_success([
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }
    
    /**
     * Vérifier s'il y a de nouvelles notifications
     */
    public static function check_new_notifications() {
        // Vérifier le nonce de sécurité
        if (!wp_verify_nonce($_POST['nonce'], 'ib_notifications_nonce')) {
            wp_die('Erreur de sécurité');
        }
        
        $last_check = isset($_POST['last_check']) ? sanitize_text_field($_POST['last_check']) : '';
        
        global $wpdb;
        $query = "SELECT COUNT(*) FROM {$wpdb->prefix}ib_notifications WHERE target = 'admin'";
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
        // Ne charger que sur les pages d'admin de notre plugin
        if (strpos($hook, 'institut-booking') === false && strpos($hook, 'mon-plugin-booking') === false) {
            return;
        }
        
        $plugin_url = plugin_dir_url(__FILE__) . '../assets/';
        $version = '2024.1.1-modern-' . time(); // Force cache refresh
        
        // CSS moderne intégré directement dans ib-notif-bell.css

        // Enregistrer le JS moderne
        wp_enqueue_script(
            'ib-notif-modern',
            $plugin_url . 'js/ib-notif-modern.js',
            ['jquery'],
            $version,
            true
        );

        // Enregistrer le script d'amélioration UI moderne
        wp_enqueue_script(
            'ib-notification-ui-enhancer',
            $plugin_url . 'js/notification-ui-enhancer.js',
            ['jquery'],
            $version,
            true
        );

        // Passer les variables nécessaires au JavaScript
        wp_localize_script('ib-notif-modern', 'ib_notif_vars', [
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

        // Configuration pour l'améliorateur UI
        wp_localize_script('ib-notification-ui-enhancer', 'IBNotifUIConfig', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ib_notifications_nonce'),
            'animations' => [
                'enabled' => true,
                'duration' => 300,
                'easing' => 'cubic-bezier(0.4, 0, 0.2, 1)'
            ],
            'features' => [
                'modernUI' => true,
                'microInteractions' => true,
                'enhancedAnimations' => true
            ]
        ]);
    }
    
    /**
     * Ajouter le script inline pour initialiser le nonce
     */
    public static function add_inline_script() {
        if (is_admin()) {
            echo '<script type="text/javascript">';
            echo 'var ib_notif_nonce = "' . wp_create_nonce('ib_notifications_nonce') . '";';
            echo 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';
            echo '</script>';
        }
    }
    
    /**
     * Générer le HTML moderne pour la cloche de notifications
     */
    public static function render_notification_bell() {
        $unread_notifications = IB_Notifications::get_unread('admin', 10);
        $unread_count = count($unread_notifications);
        
        ?>
        <div class="ib-notif-bell">
            <button class="ib-notif-bell-btn" title="Notifications">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                </svg>
                <?php if ($unread_count > 0): ?>
                    <span class="ib-notif-badge"><?php echo $unread_count > 99 ? '99+' : $unread_count; ?></span>
                <?php endif; ?>
            </button>
            
            <div class="ib-notif-dropdown" style="display: none;">
                <div class="ib-notif-dropdown-header">
                    🔔 Notifications
                    <?php if ($unread_count > 0): ?>
                        <button class="ib-notif-mark-all">Tout marquer comme lu</button>
                    <?php endif; ?>
                </div>
                
                <div class="ib-notif-list">
                    <?php if (empty($unread_notifications)): ?>
                        <div class="ib-notif-empty">
                            <div style="font-size: 3em; margin-bottom: 0.5em;">🔔</div>
                            <div>Aucune notification</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($unread_notifications as $notification): ?>
                            <?php echo self::render_notification_item($notification); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Générer le HTML d'un élément de notification moderne
     */
    public static function render_notification_item($notification) {
        $is_unread = $notification->status === 'unread';
        $type_class = self::get_notification_type_class($notification->type);
        $icon = self::get_notification_icon($notification->type);
        $title = self::get_notification_title($notification->type);
        $formatted_date = self::format_notification_date($notification->created_at);
        
        ob_start();
        ?>
        <div class="ib-notif-item-modern <?php echo $is_unread ? 'unread' : ''; ?> <?php echo esc_attr($type_class); ?>" 
             data-notif-id="<?php echo esc_attr($notification->id); ?>">
            
            <button class="ib-notif-modern-delete" title="Supprimer cette notification">
                ×
            </button>
            
            <div class="ib-notif-modern-header">
                <div class="ib-notif-modern-icon">
                    <?php echo $icon; ?>
                </div>
                
                <div class="ib-notif-modern-title-row">
                    <span class="ib-notif-modern-title-<?php echo esc_attr($type_class); ?>">
                        <?php echo esc_html($title); ?>
                    </span>
                    <?php if ($is_unread): ?>
                        <span class="ib-notif-modern-badge-nouveau">Nouveau</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ib-notif-modern-sub">
                <?php echo esc_html($notification->message); ?>
            </div>
            
            <div class="ib-notif-modern-footer">
                <div class="ib-notif-modern-date">
                    <?php echo esc_html($formatted_date); ?>
                </div>
                
                <?php if (!empty($notification->link)): ?>
                    <a href="<?php echo esc_url($notification->link); ?>" class="ib-notif-modern-link">
                        Voir détails
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Obtenir la classe CSS pour le type de notification
     */
    private static function get_notification_type_class($type) {
        $type_map = [
            'booking_confirmed' => 'confirmed',
            'booking_cancelled' => 'cancelled',
            'booking_pending' => 'pending',
            'booking_new' => 'new',
            'email' => 'generic'
        ];
        return $type_map[$type] ?? 'generic';
    }
    
    /**
     * Obtenir l'icône pour le type de notification
     */
    private static function get_notification_icon($type) {
        $icon_map = [
            'booking_confirmed' => '✅',
            'booking_cancelled' => '❌',
            'booking_pending' => '⏳',
            'booking_new' => '🆕',
            'email' => '📧'
        ];
        return $icon_map[$type] ?? '🔔';
    }
    
    /**
     * Obtenir le titre pour le type de notification
     */
    private static function get_notification_title($type) {
        $title_map = [
            'booking_confirmed' => 'Réservation confirmée',
            'booking_cancelled' => 'Réservation annulée',
            'booking_pending' => 'Réservation en attente',
            'booking_new' => 'Nouvelle réservation',
            'email' => 'Email'
        ];
        return $title_map[$type] ?? 'Notification';
    }
    
    /**
     * Formater la date de notification
     */
    private static function format_notification_date($date_string) {
        $date = new DateTime($date_string);
        $now = new DateTime();
        $diff = $now->diff($date);
        
        if ($diff->days == 0) {
            if ($diff->h == 0) {
                if ($diff->i == 0) {
                    return "À l'instant";
                }
                return "Il y a {$diff->i} min";
            }
            return "Il y a {$diff->h} h";
        } elseif ($diff->days == 1) {
            return "Hier";
        } else {
            return $date->format('d M, H:i');
        }
    }
}

// DÉSACTIVÉ - Cause des conflits avec le script final
// add_action('init', [IB_Ajax_Notifications::class, 'init']);
// add_action('admin_head', [IB_Ajax_Notifications::class, 'add_inline_script']);
