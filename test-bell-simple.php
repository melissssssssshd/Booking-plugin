<?php
/**
 * Test simple de la cloche de notifications
 * Accès: /wp-content/plugins/Booking-plugin-version02/test-bell-simple.php
 */

define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Simuler l'environnement admin
set_current_screen('dashboard');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Cloche de Notifications</title>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f1f1f1; 
        }
        .test-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .status { 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px; 
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🔔 Test de la Cloche de Notifications</h1>
        
        <div class="status info">
            <strong>Instructions:</strong><br>
            1. Cette page charge le script ultra-simple-notification.js<br>
            2. La cloche moderne devrait apparaître en haut à droite<br>
            3. Cliquez sur la cloche pour voir les notifications<br>
            4. Vérifiez la console pour les logs de débogage
        </div>

        <?php
        // Vérifier les notifications dans la base
        global $wpdb;
        $notifications_count = $wpdb->get_var(
            "SELECT COUNT(*) FROM {$wpdb->prefix}ib_notifications WHERE status = 'unread' AND target = 'admin'"
        );
        
        echo "<div class='status " . ($notifications_count > 0 ? 'success' : 'info') . "'>";
        echo "<strong>Notifications non lues dans la base:</strong> " . $notifications_count;
        echo "</div>";
        
        // Charger jQuery
        wp_enqueue_script('jquery');
        
        // Charger notre script de notifications
        wp_enqueue_script(
            'ib-ultra-simple-notification',
            plugin_dir_url(__FILE__) . 'assets/js/ultra-simple-notification.js',
            ['jquery'],
            '1.0-' . time(),
            true
        );
        
        // Variables AJAX
        wp_localize_script('ib-ultra-simple-notification', 'ib_notif_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ib_notifications_nonce'),
            'admin_nonce' => wp_create_nonce('ib_admin_nonce')
        ));
        
        // Charger les scripts
        wp_print_scripts();
        ?>

        <div class="status info">
            <strong>Variables JavaScript chargées:</strong><br>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    const vars = document.getElementById('js-vars');
                    vars.innerHTML = 
                        'ib_notif_vars: ' + (typeof ib_notif_vars !== 'undefined' ? '✅ Chargé' : '❌ Non défini') + '<br>' +
                        'ajaxurl: ' + (typeof ajaxurl !== 'undefined' ? '✅ Chargé' : '❌ Non défini') + '<br>' +
                        'jQuery: ' + (typeof jQuery !== 'undefined' ? '✅ Chargé' : '❌ Non défini');
                }, 1000);
            });
            </script>
            <div id="js-vars">Chargement...</div>
        </div>

        <div class="status info">
            <strong>Console de débogage:</strong><br>
            Ouvrez la console du navigateur (F12) pour voir les logs de débogage du script.
        </div>

        <button onclick="testNotificationCreation()" style="background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 10px 5px;">
            🧪 Créer une notification de test
        </button>

        <button onclick="testAjaxCall()" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 10px 5px;">
            📡 Tester l'appel AJAX
        </button>

        <div id="test-results" style="margin-top: 20px;"></div>
    </div>

    <script>
    function testNotificationCreation() {
        const results = document.getElementById('test-results');
        results.innerHTML = '<div class="status info">🔄 Création d\'une notification de test...</div>';
        
        fetch('create-test-notification.php')
            .then(response => response.text())
            .then(data => {
                results.innerHTML = '<div class="status success">✅ Notification créée! Rechargez la page pour voir le badge.</div>';
                setTimeout(() => location.reload(), 2000);
            })
            .catch(error => {
                results.innerHTML = '<div class="status error">❌ Erreur: ' + error.message + '</div>';
            });
    }

    function testAjaxCall() {
        const results = document.getElementById('test-results');
        results.innerHTML = '<div class="status info">🔄 Test de l\'appel AJAX...</div>';
        
        if (typeof jQuery === 'undefined') {
            results.innerHTML = '<div class="status error">❌ jQuery non disponible</div>';
            return;
        }
        
        if (typeof ib_notif_vars === 'undefined') {
            results.innerHTML = '<div class="status error">❌ Variables AJAX non disponibles</div>';
            return;
        }
        
        jQuery.ajax({
            url: ib_notif_vars.ajaxurl,
            type: 'POST',
            data: {
                action: 'ib_get_notifications',
                nonce: ib_notif_vars.nonce,
                limit: 5
            },
            success: function(response) {
                console.log('✅ Réponse AJAX:', response);
                if (response.success) {
                    const count = response.data.recent ? response.data.recent.length : 0;
                    results.innerHTML = '<div class="status success">✅ AJAX fonctionne! ' + count + ' notifications trouvées.</div>';
                } else {
                    results.innerHTML = '<div class="status error">❌ Erreur AJAX: ' + (response.data || 'Réponse invalide') + '</div>';
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Erreur AJAX:', {xhr, status, error});
                results.innerHTML = '<div class="status error">❌ Erreur AJAX: ' + error + '</div>';
            }
        });
    }
    </script>
</body>
</html>
