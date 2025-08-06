<?php
/**
 * Script de test pour vérifier le fonctionnement des notifications
 * Accès: /wp-content/plugins/Booking-plugin-version02/test-notifications-fix.php
 */

define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

global $wpdb;

echo "<h1>🔧 Test des Notifications - Diagnostic Complet</h1>";

// 1. Vérifier les dernières notifications dans la base
echo "<h2>📊 Dernières notifications dans la base de données</h2>";
$notifications = $wpdb->get_results(
    "SELECT id, type, status, created_at, 
    SUBSTRING(message, 1, 100) as message_preview 
    FROM {$wpdb->prefix}ib_notifications 
    ORDER BY created_at DESC 
    LIMIT 10"
);

if ($notifications) {
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Type</th><th>Statut</th><th>Date</th><th>Message</th></tr>";
    
    foreach ($notifications as $notif) {
        $status_color = $notif->status === 'unread' ? '#ffeb3b' : '#e8f5e8';
        echo sprintf(
            "<tr style='background: %s;'><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
            $status_color,
            $notif->id,
            $notif->type,
            $notif->status,
            $notif->created_at,
            htmlspecialchars($notif->message_preview)
        );
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>❌ Aucune notification trouvée dans la base de données</p>";
}

// 2. Vérifier les scripts enregistrés
echo "<h2>📜 Scripts JavaScript enregistrés</h2>";
global $wp_scripts;

$scripts_to_check = [
    'ib-ultra-simple-notification',
    'ib-admin-script',
    'ib-notif-selection',
    'ib-notif-refonte'
];

echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>Script</th><th>Statut</th><th>Dépendances</th><th>Variables</th></tr>";

foreach ($scripts_to_check as $script) {
    if (isset($wp_scripts->registered[$script])) {
        $script_obj = $wp_scripts->registered[$script];
        $deps = implode(', ', $script_obj->deps);
        $vars = isset($script_obj->extra['data']) ? 'Oui' : 'Non';
        echo "<tr style='background: #e8f5e8;'><td>{$script}</td><td>✅ Enregistré</td><td>{$deps}</td><td>{$vars}</td></tr>";
    } else {
        echo "<tr style='background: #ffebee;'><td>{$script}</td><td>❌ Non enregistré</td><td>-</td><td>-</td></tr>";
    }
}
echo "</table>";

// 3. Vérifier les hooks AJAX
echo "<h2>🔗 Hooks AJAX enregistrés</h2>";
$ajax_hooks = [
    'wp_ajax_ib_get_notifications' => has_action('wp_ajax_ib_get_notifications'),
    'wp_ajax_ib_mark_notification_read' => has_action('wp_ajax_ib_mark_notification_read'),
    'wp_ajax_ib_mark_all_notifications_read' => has_action('wp_ajax_ib_mark_all_notifications_read'),
    'wp_ajax_ib_delete_notification' => has_action('wp_ajax_ib_delete_notification')
];

echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>Hook AJAX</th><th>Statut</th></tr>";

foreach ($ajax_hooks as $hook => $status) {
    $status_text = $status ? '✅ Enregistré' : '❌ Non enregistré';
    $bg_color = $status ? '#e8f5e8' : '#ffebee';
    echo "<tr style='background: {$bg_color};'><td>{$hook}</td><td>{$status_text}</td></tr>";
}
echo "</table>";

// 4. Test AJAX en direct
echo "<h2>🧪 Test AJAX en direct</h2>";
echo "<button id='test-ajax-btn' style='background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Tester le chargement des notifications</button>";
echo "<div id='test-results' style='margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px; display: none;'></div>";

// 5. Vérifier les fichiers CSS/JS
echo "<h2>📁 Vérification des fichiers</h2>";
$files_to_check = [
    'assets/js/ultra-simple-notification.js',
    'assets/js/admin-script.js',
    'assets/css/ib-notif-bell.css',
    'assets/js/ib-notif-refonte.js',
    'assets/css/ib-notif-refonte.css'
];

echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>Fichier</th><th>Statut</th><th>Taille</th></tr>";

foreach ($files_to_check as $file) {
    $path = dirname(__FILE__) . '/' . $file;
    if (file_exists($path)) {
        $size = round(filesize($path) / 1024, 2) . ' KB';
        echo "<tr style='background: #e8f5e8;'><td>{$file}</td><td>✅ Existe</td><td>{$size}</td></tr>";
    } else {
        echo "<tr style='background: #ffebee;'><td>{$file}</td><td>❌ Manquant</td><td>-</td></tr>";
    }
}
echo "</table>";

?>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#test-ajax-btn').click(function() {
        $('#test-results').show().html('🔄 Test en cours...');
        
        console.log('🧪 Test AJAX démarré');
        console.log('Variables disponibles:', {
            ajaxurl: typeof ajaxurl !== 'undefined' ? ajaxurl : 'NON DÉFINI',
            ib_notif_vars: typeof ib_notif_vars !== 'undefined' ? ib_notif_vars : 'NON DÉFINI',
            IBNotifBell: typeof IBNotifBell !== 'undefined' ? IBNotifBell : 'NON DÉFINI'
        });
        
        var ajaxUrl = '';
        var nonce = '';
        
        // Essayer de récupérer les variables AJAX
        if (typeof ib_notif_vars !== 'undefined') {
            ajaxUrl = ib_notif_vars.ajaxurl || '';
            nonce = ib_notif_vars.nonce || '';
        } else if (typeof IBNotifBell !== 'undefined') {
            ajaxUrl = IBNotifBell.ajaxurl || '';
            nonce = IBNotifBell.nonce || '';
        } else if (typeof ajaxurl !== 'undefined') {
            ajaxUrl = ajaxurl;
            nonce = '<?php echo wp_create_nonce('ib_notifications_nonce'); ?>';
        }
        
        if (!ajaxUrl) {
            $('#test-results').html('❌ Erreur: URL AJAX non trouvée');
            return;
        }
        
        if (!nonce) {
            $('#test-results').html('❌ Erreur: Nonce non trouvé');
            return;
        }
        
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'ib_get_notifications',
                nonce: nonce,
                limit: 5
            },
            success: function(response) {
                console.log('✅ Réponse AJAX:', response);
                
                if (response.success) {
                    var notifs = response.data.recent || [];
                    var html = '<h3>✅ Test réussi!</h3>';
                    html += '<p><strong>Notifications trouvées:</strong> ' + notifs.length + '</p>';
                    html += '<p><strong>Non lues:</strong> ' + (response.data.unread_count || 0) + '</p>';
                    
                    if (notifs.length > 0) {
                        html += '<h4>Dernières notifications:</h4><ul>';
                        notifs.slice(0, 3).forEach(function(notif) {
                            html += '<li><strong>' + notif.type + '</strong>: ' + (notif.message || 'Pas de message') + '</li>';
                        });
                        html += '</ul>';
                    }
                    
                    $('#test-results').html(html);
                } else {
                    $('#test-results').html('❌ Erreur: ' + (response.data || 'Réponse invalide'));
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Erreur AJAX:', {xhr, status, error});
                $('#test-results').html('❌ Erreur AJAX: ' + error + ' (Status: ' + status + ')');
            }
        });
    });
});
</script>

<style>
table { margin-bottom: 20px; }
th, td { text-align: left; padding: 8px; }
h2 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 5px; }
</style>
