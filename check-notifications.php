<?php
/**
 * Script temporaire pour vérifier les notifications
 * Accès: /wp-content/plugins/mon-plugin-booking/check-notifications.php
 */

define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

global $wpdb;

// Récupérer les 10 dernières notifications
$notifications = $wpdb->get_results(
    "SELECT id, type, status, created_at, 
    SUBSTRING(message, 1, 100) as message_preview 
    FROM {$wpdb->prefix}ib_notifications 
    ORDER BY created_at DESC 
    LIMIT 10"
);

// Afficher les résultats
echo "<h2>Dernières notifications dans la base de données</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>ID</th><th>Type</th><th>Statut</th><th>Date</th><th>Message</th></tr>";

if (!empty($notifications)) {
    foreach ($notifications as $notif) {
        echo sprintf(
            "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
            $notif->id,
            htmlspecialchars($notif->type),
            htmlspecialchars($notif->status),
            $notif->created_at,
            htmlspecialchars($notif->message_preview)
        );
    }
} else {
    echo "<tr><td colspan='5'>Aucune notification trouvée dans la base de données.</td></tr>";
}

echo "</table>";

// Vérifier la configuration de la table
$table_info = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}ib_notifications");

echo "<h2>Structure de la table des notifications</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Champ</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th><th>Extra</th></tr>";

foreach ($table_info as $column) {
    echo sprintf(
        "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
        $column->Field,
        $column->Type,
        $column->Null,
        $column->Key,
        $column->Default ?? 'NULL',
        $column->Extra
    );
}

echo "</table>";

// Vérifier les variables JavaScript
$ib_notif_vars = [
    'IBNotifBell' => isset($wp_scripts->registered['ib-notif-bell']) ? $wp_scripts->registered['ib-notif-bell']->extra['data'] ?? 'Non défini' : 'Script non enregistré',
    'admin-script' => isset($wp_scripts->registered['admin-script']) ? $wp_scripts->registered['admin-script']->extra['data'] ?? 'Non défini' : 'Script non enregistré'
];

echo "<h2>Variables JavaScript</h2>";
echo "<pre>" . print_r($ib_notif_vars, true) . "</pre>";

// Vérifier les hooks AJAX
echo "<h2>Hooks AJAX enregistrés</h2>";
$ajax_hooks = [
    'wp_ajax_ib_get_notifications' => has_action('wp_ajax_ib_get_notifications'),
    'wp_ajax_nopriv_ib_get_notifications' => has_action('wp_ajax_nopriv_ib_get_notifications'),
    'wp_ajax_ib_mark_notification_read' => has_action('wp_ajax_ib_mark_notification_read'),
    'wp_ajax_ib_mark_all_notifications_read' => has_action('wp_ajax_ib_mark_all_notifications_read')
];

echo "<pre>" . print_r($ajax_hooks, true) . "</pre>";

// Vérifier la dernière erreur PHP
$last_error = error_get_last();
if ($last_error) {
    echo "<h2>Dernière erreur PHP</h2>";
    echo "<pre>" . print_r($last_error, true) . "</pre>";
}

// Vérifier les logs d'erreurs
$debug_log = ini_get('error_log');
if (file_exists($debug_log)) {
    $log_content = file_get_contents($debug_log);
    $log_entries = array_filter(explode("\n", $log_content));
    $recent_entries = array_slice($log_entries, -10); // 10 dernières lignes
    
    echo "<h2>Derniers logs d'erreurs</h2>";
    echo "<pre>" . implode("\n", $recent_entries) . "</pre>";
} else {
    echo "<p>Aucun fichier de log trouvé à: " . htmlspecialchars($debug_log) . "</p>";
}
