<?php
/**
 * 🎨 TEMPLATE PANNEAU NOTIFICATIONS MODERNE & MINIMALISTE
 * ================================================================
 * Template pour le panneau latéral de notifications refondu
 * Design moderne inspiré Planity/Fresha pour SaaS beauté
 * Version: 3.0.0 - Refonte complète
 */

// Sécurité WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Récupérer les notifications avec compteurs par type
$notifications_all = IB_Notifications::get_recent('admin', 50);
$notifications_unread = IB_Notifications::get_unread('admin');
$unread_count = count($notifications_unread);

// Compteurs par type pour les onglets
$bookings_count = 0;
$emails_count = 0;
$archived_count = 0;

foreach ($notifications_all as $notif) {
    if (in_array($notif->type, ['booking_new', 'booking_confirmed', 'booking_cancelled'])) {
        $bookings_count++;
    } elseif ($notif->type === 'email') {
        $emails_count++;
    }
}

// Enregistrer les assets modernes
wp_enqueue_style('ib-notif-refonte', plugin_dir_url(__FILE__) . '../assets/css/ib-notif-refonte.css', [], '3.0.0');
wp_enqueue_script('ib-notif-refonte', plugin_dir_url(__FILE__) . '../assets/js/ib-notif-refonte.js', ['jquery'], '3.0.0', true);

// Variables JavaScript
wp_localize_script('ib-notif-refonte', 'ib_notif_vars', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('ib_notifications_nonce'),
    'strings' => [
        'loading' => __('Chargement...', 'institut-booking'),
        'error' => __('Erreur de chargement', 'institut-booking'),
        'no_notifications' => __('Aucune notification', 'institut-booking'),
        'mark_read' => __('Marquer comme lu', 'institut-booking'),
        'delete' => __('Supprimer', 'institut-booking'),
        'archive' => __('Archiver', 'institut-booking'),
        'confirm_delete' => __('Êtes-vous sûr de vouloir supprimer cette notification ?', 'institut-booking'),
    ]
]);
?>


<!-- Panneau de notifications moderne et pastel -->
<div class="ib-notif-refonte" id="ib-notif-refonte">
    <div class="ib-notif-panel-refonte" id="ib-notif-panel-refonte">
        <div class="ib-notif-header-refonte">
            <div class="ib-notif-header-top">
                <h2 class="ib-notif-title-refonte">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                        <path d="m13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    Notifications
                </h2>
                <button class="ib-notif-close-refonte" id="ib-notif-close" aria-label="Fermer">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="ib-notif-tabs-refonte">
                <button class="ib-notif-tab-refonte active" data-tab="all">
                    <span class="ib-notif-tab-icon">📆</span> Toutes
                    <span class="tab-count"><?php echo count($notifications_all); ?></span>
                </button>
                <button class="ib-notif-tab-refonte" data-tab="bookings">
                    <span class="ib-notif-tab-icon">📅</span> Réservations
                    <span class="tab-count"><?php echo $bookings_count; ?></span>
                </button>
                <button class="ib-notif-tab-refonte" data-tab="emails">
                    <span class="ib-notif-tab-icon">📩</span> Emails
                    <span class="tab-count"><?php echo $emails_count; ?></span>
                </button>
                <button class="ib-notif-tab-refonte" data-tab="archived">
                    <span class="ib-notif-tab-icon">📂</span> Archivées
                    <span class="tab-count"><?php echo $archived_count; ?></span>
                </button>
            </div>
            <div class="ib-notif-search-refonte">
                <div class="ib-notif-search-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                </div>
                <input type="text"
                       class="ib-notif-search-input-refonte"
                       placeholder="Rechercher un client, service..."
                       id="ib-notif-search-input"
                       autocomplete="off">
            </div>
        </div>
        <div class="ib-notif-content-refonte" id="ib-notif-content">
            <?php if (empty($notifications_all)): ?>
                <div class="ib-notif-empty-refonte">
                    <div class="ib-notif-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                            <path d="m13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </div>
                    <h3 class="ib-notif-empty-title">Aucune notification</h3>
                    <p class="ib-notif-empty-text">
                        Vous êtes à jour ! Les nouvelles notifications apparaîtront ici.
                    </p>
                </div>
            <?php else: ?>
                <?php 
                $grouped_notifications = [];
                $email_notifications = [];
                $other_notifications = [];
                foreach ($notifications_all as $notification) {
                    if ($notification->type === 'email') {
                        $email_notifications[] = $notification;
                    } else {
                        $other_notifications[] = $notification;
                    }
                }
                foreach ($other_notifications as $notification) {
                    echo render_notification_card_refonte($notification);
                }
                if (count($email_notifications) > 3) {
                    echo render_notification_group_refonte('emails', $email_notifications);
                } else {
                    foreach ($email_notifications as $notification) {
                        echo render_notification_card_refonte($notification);
                    }
                }
                ?>
            <?php endif; ?>
            <div class="ib-notif-loading" id="ib-notif-loading" style="display: none;">
                <div class="ib-notif-spinner"></div>
            </div>
        </div>
    </div>
    <div class="ib-notif-overlay-refonte" id="ib-notif-overlay"></div>
    <div class="ib-notif-selection-bar" id="ib-notif-selection-bar">
        <div class="ib-notif-selection-count">
            <span id="ib-notif-selection-count">0</span> sélectionnée(s)
        </div>
        <div class="ib-notif-selection-actions">
            <button class="ib-notif-selection-btn" id="ib-notif-select-all" title="Tout sélectionner">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                </svg>
                Tout sélectionner
            </button>
            <button class="ib-notif-selection-btn" id="ib-notif-mark-read">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
                    <polyline points="20,6 9,17 4,12"/>
                </svg>
                Marquer comme lu
            </button>
            <button class="ib-notif-selection-btn" id="ib-notif-archive">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
                    <polyline points="21,8 21,21 3,21 3,8"/>
                    <rect x="1" y="3" width="22" height="5"/>
                    <line x1="10" y1="12" x2="14" y2="12"/>
                </svg>
                Archiver
            </button>
            <button class="ib-notif-selection-btn" id="ib-notif-delete">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
                    <polyline points="3,6 5,6 21,6"/>
                    <path d="m19 6v14a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2v-14m3 0v-2a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                Supprimer
            </button>
        </div>
    </div>
</div>

<?php
/**
 * Fonction pour rendre une carte de notification moderne
 */
function render_notification_card_refonte($notification) {
    $is_unread = ($notification->status === 'unread');
    $type_class = get_notification_type_class_refonte($notification->type);
    $icon = get_notification_icon_refonte($notification->type);
    $badge = get_notification_badge_refonte($notification);
    $time_ago = format_time_ago_refonte($notification->created_at);
    $client_name = $notification->client_name ?? 'Client';
    $message = format_notification_message_refonte($notification);
    
    ob_start();
    ?>
    <div class="ib-notif-card-refonte <?php echo $is_unread ? 'is-unread' : ''; ?>" 
         data-notification-id="<?php echo esc_attr($notification->id); ?>"
         data-type="<?php echo esc_attr($notification->type); ?>"
         data-link="<?php echo esc_attr($notification->link ?? ''); ?>"
         data-client="<?php echo esc_attr($client_name); ?>"
         data-service="<?php echo esc_attr($notification->service_name ?? ''); ?>">
        
        <!-- Checkbox de sélection (masquée par défaut) -->
        <div class="ib-notif-card-checkbox">
            <label class="ib-notif-checkbox">
                <input type="checkbox" value="<?php echo esc_attr($notification->id); ?>">
                <span class="ib-notif-checkbox-mark"></span>
            </label>
        </div>

        <!-- Badge de statut -->
        <?php echo $badge; ?>

        <!-- Header avec icône et métadonnées -->
        <div class="ib-notif-card-header">
            <div class="ib-notif-card-icon <?php echo $type_class; ?>">
                <?php echo $icon; ?>
            </div>
            <div class="ib-notif-card-meta">
                <div class="ib-notif-card-client">
                    <?php echo esc_html($client_name); ?>
                </div>
                <div class="ib-notif-card-action">
                    <?php echo $message; ?>
                </div>
            </div>
        </div>

        <!-- Footer avec date et actions -->
        <div class="ib-notif-card-footer">
            <div class="ib-notif-card-date"><?php echo esc_html($time_ago); ?></div>
            <div class="ib-notif-card-actions">
                <button class="ib-notif-card-action-btn" 
                        title="Marquer comme lu" 
                        onclick="markAsRead('<?php echo esc_js($notification->id); ?>')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14">
                        <polyline points="20,6 9,17 4,12"/>
                    </svg>
                </button>
                <button class="ib-notif-card-action-btn" 
                        title="Supprimer" 
                        onclick="deleteNotification('<?php echo esc_js($notification->id); ?>')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14">
                        <polyline points="3,6 5,6 21,6"/>
                        <path d="m19 6v14a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2v-14m3 0v-2a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Fonction pour rendre un groupe de notifications
 */
function render_notification_group_refonte($group_key, $notifications) {
    $count = count($notifications);
    $group_title = get_group_title_refonte($group_key, $count);
    $is_expanded = false; // Par défaut fermé

    ob_start();
    ?>
    <div class="ib-notif-group-refonte <?php echo $is_expanded ? 'expanded' : ''; ?>" data-group="<?php echo esc_attr($group_key); ?>">
        <div class="ib-notif-group-header" onclick="toggleGroup('<?php echo esc_js($group_key); ?>')">
            <div class="ib-notif-group-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
                    <path d="m4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2h-16c-1.1 0-2-.9-2-2v-12c0-1.1.9-2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <?php echo esc_html($group_title); ?>
                <span class="ib-notif-group-count"><?php echo $count; ?></span>
            </div>
            <div class="ib-notif-group-toggle">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
                    <polyline points="6,9 12,15 18,9"/>
                </svg>
            </div>
        </div>
        <div class="ib-notif-group-content">
            <?php foreach ($notifications as $notification): ?>
                <?php echo render_notification_card_refonte($notification); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Fonctions utilitaires pour les notifications
 */
function get_notification_type_class_refonte($type) {
    $type_map = [
        'booking_new' => 'type-booking',
        'booking_confirmed' => 'type-booking',
        'booking_cancelled' => 'type-cancellation',
        'email' => 'type-email',
        'reminder' => 'type-reminder'
    ];
    return $type_map[$type] ?? 'type-booking';
}

function get_notification_icon_refonte($type) {
    $icon_map = [
        'booking_new' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>',
        'booking_confirmed' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
            <polyline points="20,6 9,17 4,12"/>
        </svg>',
        'booking_cancelled' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>',
        'email' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
            <path d="m4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2h-16c-1.1 0-2-.9-2-2v-12c0-1.1.9-2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
        </svg>',
        'reminder' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="m13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>'
    ];
    return $icon_map[$type] ?? $icon_map['booking_new'];
}

function get_notification_badge_refonte($notification) {
    if ($notification->status === 'unread') {
        return '<div class="ib-notif-card-badge status-new">Nouveau</div>';
    }

    $badge_map = [
        'booking_confirmed' => '<div class="ib-notif-card-badge status-confirmed">Confirmé</div>',
        'booking_cancelled' => '<div class="ib-notif-card-badge status-cancelled">Annulé</div>'
    ];

    return $badge_map[$notification->type] ?? '';
}

function format_notification_message_refonte($notification) {
    $service = $notification->service_name ? '<span class="ib-notif-card-service">' . esc_html($notification->service_name) . '</span>' : '';

    $message_map = [
        'booking_new' => "a réservé {$service}",
        'booking_confirmed' => "réservation {$service} confirmée",
        'booking_cancelled' => "a annulé {$service}",
        'email' => 'email envoyé',
        'reminder' => "rappel pour {$service}"
    ];

    return $message_map[$notification->type] ?? esc_html($notification->message);
}

function format_time_ago_refonte($date_string) {
    $date = new DateTime($date_string);
    $now = new DateTime();
    $diff = $now->getTimestamp() - $date->getTimestamp();

    if ($diff < 60) return 'À l\'instant';
    if ($diff < 3600) return floor($diff / 60) . 'm';
    if ($diff < 86400) return floor($diff / 3600) . 'h';
    if ($diff < 604800) return floor($diff / 86400) . 'j';

    return $date->format('j M');
}

function get_group_title_refonte($group_key, $count) {
    $title_map = [
        'emails' => "{$count} emails envoyés aujourd'hui"
    ];
    return $title_map[$group_key] ?? "{$count} notifications";
}
