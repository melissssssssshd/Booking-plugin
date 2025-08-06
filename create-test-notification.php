<?php
/**
 * Script pour créer une notification de test
 * Accès: /wp-content/plugins/Booking-plugin-version02/create-test-notification.php
 */

define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Charger les classes nécessaires
require_once plugin_dir_path(__FILE__) . 'includes/notifications.php';

echo "<h1>🧪 Création d'une notification de test</h1>";

// Créer une notification de test
$test_message = "Test de notification - " . date('Y-m-d H:i:s');
$test_link = admin_url('admin.php?page=institut-booking-bookings');

// Utiliser la méthode IB_Notifications::add
IB_Notifications::add('reservation', $test_message, 'admin', $test_link);

echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "✅ <strong>Notification de test créée avec succès!</strong><br>";
echo "Message: " . htmlspecialchars($test_message) . "<br>";
echo "Type: reservation<br>";
echo "Cible: admin<br>";
echo "Lien: " . htmlspecialchars($test_link);
echo "</div>";

// Vérifier que la notification a bien été créée
global $wpdb;
$latest_notification = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}ib_notifications ORDER BY created_at DESC LIMIT 1"
);

if ($latest_notification) {
    echo "<h2>📊 Dernière notification dans la base</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f8f9fa;'>";
    echo "<th>ID</th><th>Type</th><th>Message</th><th>Statut</th><th>Date</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $latest_notification->id . "</td>";
    echo "<td>" . $latest_notification->type . "</td>";
    echo "<td>" . htmlspecialchars($latest_notification->message) . "</td>";
    echo "<td>" . $latest_notification->status . "</td>";
    echo "<td>" . $latest_notification->created_at . "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<p style='color: red;'>❌ Aucune notification trouvée dans la base de données</p>";
}

// Compter les notifications non lues
$unread_count = $wpdb->get_var(
    "SELECT COUNT(*) FROM {$wpdb->prefix}ib_notifications WHERE status = 'unread' AND target = 'admin'"
);

echo "<h2>📈 Statistiques</h2>";
echo "<p><strong>Notifications non lues:</strong> " . $unread_count . "</p>";

// Test de récupération via la classe IB_Notifications
echo "<h2>🔍 Test de récupération des notifications</h2>";

try {
    $recent_notifications = IB_Notifications::get_recent('admin', 5);
    echo "<p>✅ <strong>Récupération réussie:</strong> " . count($recent_notifications) . " notifications récentes</p>";
    
    if (!empty($recent_notifications)) {
        echo "<h3>Dernières notifications récupérées:</h3>";
        echo "<ul>";
        foreach ($recent_notifications as $notif) {
            echo "<li><strong>" . $notif->type . "</strong>: " . htmlspecialchars($notif->message) . " (" . $notif->created_at . ")</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ <strong>Erreur lors de la récupération:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='test-notifications-fix.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔧 Retour au diagnostic</a></p>";
echo "<p><a href='" . admin_url('admin.php?page=institut-booking') . "' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📊 Voir dans l'admin</a></p>";
?>
