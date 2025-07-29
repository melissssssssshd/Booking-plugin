<?php
/**
 * Diagnostic complet du système d'envoi d'emails
 * Test de wp_mail et identification des problèmes
 */

// Seulement accessible aux admins
if (!current_user_can('manage_options')) {
    wp_die('Accès non autorisé');
}

echo "<h1>📧 Diagnostic Complet des Emails</h1>\n";

echo "<h2>🔍 Test de la configuration WordPress</h2>\n";

// Test 1: Configuration de base
echo "<h3>1. Configuration de base</h3>\n";
echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<strong>Site URL:</strong> " . get_site_url() . "<br>\n";
echo "<strong>Admin Email:</strong> " . get_option('admin_email') . "<br>\n";
echo "<strong>Nom du site:</strong> " . get_bloginfo('name') . "<br>\n";
echo "<strong>WordPress Version:</strong> " . get_bloginfo('version') . "<br>\n";
echo "</div>\n";

// Test 2: Fonction wp_mail disponible
echo "<h3>2. Fonction wp_mail</h3>\n";
if (function_exists('wp_mail')) {
    echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
    echo "✅ <strong>wp_mail() est disponible</strong>\n";
    echo "</div>\n";
} else {
    echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
    echo "❌ <strong>wp_mail() n'est pas disponible</strong>\n";
    echo "</div>\n";
}

// Test 3: Test d'envoi simple
echo "<h3>3. Test d'envoi simple</h3>\n";
$test_email = get_option('admin_email');
$test_subject = 'Test Email Institut Booking - ' . date('Y-m-d H:i:s');
$test_message = '<h2>Test Email</h2><p>Ceci est un test d\'envoi d\'email depuis Institut Booking.</p><p>Envoyé le: ' . date('Y-m-d H:i:s') . '</p>';
$test_headers = array('Content-Type: text/html; charset=UTF-8');

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<strong>Tentative d'envoi vers:</strong> " . $test_email . "<br>\n";
echo "<strong>Sujet:</strong> " . $test_subject . "<br>\n";

$test_result = wp_mail($test_email, $test_subject, $test_message, $test_headers);

if ($test_result) {
    echo "<div style='background:#e8f5e8;padding:10px;border:1px solid #4caf50;margin-top:10px;'>\n";
    echo "✅ <strong>Email de test envoyé avec succès</strong><br>\n";
    echo "Vérifiez votre boîte email (et les spams)\n";
    echo "</div>\n";
} else {
    echo "<div style='background:#ffebee;padding:10px;border:1px solid #f44336;margin-top:10px;'>\n";
    echo "❌ <strong>Échec de l'envoi de l'email de test</strong>\n";
    echo "</div>\n";
}
echo "</div>\n";

// Test 4: Configuration SMTP
echo "<h3>4. Configuration SMTP</h3>\n";
echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";

// Vérifier si un plugin SMTP est actif
$smtp_plugins = array(
    'wp-mail-smtp/wp_mail_smtp.php' => 'WP Mail SMTP',
    'easy-wp-smtp/easy-wp-smtp.php' => 'Easy WP SMTP',
    'post-smtp/postman-smtp.php' => 'Post SMTP',
    'wp-smtp/wp-smtp.php' => 'WP SMTP'
);

$active_smtp = false;
foreach ($smtp_plugins as $plugin_path => $plugin_name) {
    if (is_plugin_active($plugin_path)) {
        echo "✅ <strong>Plugin SMTP actif:</strong> " . $plugin_name . "<br>\n";
        $active_smtp = true;
    }
}

if (!$active_smtp) {
    echo "⚠️ <strong>Aucun plugin SMTP détecté</strong><br>\n";
    echo "WordPress utilise la fonction mail() PHP par défaut<br>\n";
    echo "<em>Recommandation: Installer un plugin SMTP pour une meilleure fiabilité</em>\n";
}
echo "</div>\n";

// Test 5: Vérification des templates d'email
echo "<h3>5. Templates d'email configurés</h3>\n";
echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";

$thank_you_template = get_option('ib_notify_client_thankyou', '');
if (!empty($thank_you_template)) {
    echo "✅ <strong>Template de remerciement configuré</strong><br>\n";
    echo "<details><summary>Voir le template</summary>\n";
    echo "<div style='background:#fff;padding:10px;border:1px solid #ccc;margin:5px 0;'>\n";
    echo htmlspecialchars($thank_you_template) . "\n";
    echo "</div></details>\n";
} else {
    echo "⚠️ <strong>Template de remerciement non configuré</strong><br>\n";
    echo "Le template par défaut sera utilisé\n";
}

$confirm_template = get_option('ib_notify_client_confirm', '');
if (!empty($confirm_template)) {
    echo "✅ <strong>Template de confirmation configuré</strong><br>\n";
} else {
    echo "⚠️ <strong>Template de confirmation non configuré</strong>\n";
}
echo "</div>\n";

// Test 6: Test de la fonction send_thank_you
echo "<h3>6. Test de la fonction send_thank_you</h3>\n";

// Récupérer la dernière réservation pour test
global $wpdb;
$last_booking = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}ib_bookings ORDER BY id DESC LIMIT 1");

if ($last_booking) {
    echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
    echo "<strong>Dernière réservation trouvée:</strong><br>\n";
    echo "ID: " . $last_booking->id . "<br>\n";
    echo "Client: " . $last_booking->client_name . "<br>\n";
    echo "Email: " . $last_booking->client_email . "<br>\n";
    echo "Date: " . $last_booking->date . "<br>\n";
    
    if (!empty($last_booking->client_email) && is_email($last_booking->client_email)) {
        echo "<br><strong>Test d'envoi du remerciement:</strong><br>\n";
        
        // Inclure la classe de notifications
        require_once plugin_dir_path(__FILE__) . 'includes/notifications.php';
        
        // Tester l'envoi
        $send_result = IB_Notifications::send_thank_you($last_booking->id);
        
        if ($send_result !== false) {
            echo "<div style='background:#e8f5e8;padding:10px;border:1px solid #4caf50;margin-top:10px;'>\n";
            echo "✅ <strong>Fonction send_thank_you exécutée</strong><br>\n";
            echo "Vérifiez l'email du client: " . $last_booking->client_email . "\n";
            echo "</div>\n";
        } else {
            echo "<div style='background:#ffebee;padding:10px;border:1px solid #f44336;margin-top:10px;'>\n";
            echo "❌ <strong>Échec de la fonction send_thank_you</strong>\n";
            echo "</div>\n";
        }
    } else {
        echo "<div style='background:#fff3e0;padding:10px;border:1px solid #ff9800;margin-top:10px;'>\n";
        echo "⚠️ <strong>Email client invalide ou manquant</strong><br>\n";
        echo "Email: '" . $last_booking->client_email . "'\n";
        echo "</div>\n";
    }
    echo "</div>\n";
} else {
    echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
    echo "⚠️ <strong>Aucune réservation trouvée pour le test</strong>\n";
    echo "</div>\n";
}

// Test 7: Vérification des logs d'erreur
echo "<h3>7. Logs d'erreur WordPress</h3>\n";
echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";

if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    echo "✅ <strong>Logs d'erreur activés</strong><br>\n";
    $log_file = WP_CONTENT_DIR . '/debug.log';
    if (file_exists($log_file)) {
        echo "📁 <strong>Fichier de log:</strong> " . $log_file . "<br>\n";
        
        // Lire les dernières lignes du log
        $log_lines = file($log_file);
        $recent_lines = array_slice($log_lines, -20); // 20 dernières lignes
        
        $email_errors = array_filter($recent_lines, function($line) {
            return stripos($line, 'mail') !== false || stripos($line, 'smtp') !== false || stripos($line, 'IB Booking') !== false;
        });
        
        if (!empty($email_errors)) {
            echo "<strong>Erreurs récentes liées aux emails:</strong><br>\n";
            echo "<div style='background:#fff;padding:10px;border:1px solid #ccc;font-family:monospace;font-size:12px;max-height:200px;overflow-y:auto;'>\n";
            foreach ($email_errors as $error) {
                echo htmlspecialchars($error) . "<br>\n";
            }
            echo "</div>\n";
        } else {
            echo "✅ <strong>Aucune erreur email récente dans les logs</strong>\n";
        }
    } else {
        echo "⚠️ <strong>Fichier de log non trouvé</strong>\n";
    }
} else {
    echo "⚠️ <strong>Logs d'erreur désactivés</strong><br>\n";
    echo "Pour activer: WP_DEBUG_LOG = true dans wp-config.php\n";
}
echo "</div>\n";

// Test 8: Recommandations
echo "<h2>💡 Recommandations</h2>\n";

echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h3>Pour résoudre les problèmes d'email:</h3>\n";
echo "<ol>\n";
echo "<li><strong>Installer un plugin SMTP</strong> (WP Mail SMTP recommandé)</li>\n";
echo "<li><strong>Configurer un service email</strong> (Gmail, SendGrid, Mailgun, etc.)</li>\n";
echo "<li><strong>Vérifier les spams</strong> côté client</li>\n";
echo "<li><strong>Tester avec différents emails</strong> (Gmail, Outlook, etc.)</li>\n";
echo "<li><strong>Activer les logs</strong> pour diagnostiquer les erreurs</li>\n";
echo "<li><strong>Vérifier la configuration serveur</strong> (fonction mail() PHP)</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🔧 Actions immédiates</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>Si les emails ne s'envoient toujours pas:</h3>\n";
echo "<ol>\n";
echo "<li><strong>Installer WP Mail SMTP:</strong><br>\n";
echo "   - Aller dans Extensions → Ajouter<br>\n";
echo "   - Rechercher 'WP Mail SMTP'<br>\n";
echo "   - Installer et activer</li>\n";
echo "<li><strong>Configurer Gmail SMTP:</strong><br>\n";
echo "   - SMTP Host: smtp.gmail.com<br>\n";
echo "   - Port: 587<br>\n";
echo "   - Encryption: TLS<br>\n";
echo "   - Utiliser un mot de passe d'application</li>\n";
echo "<li><strong>Tester l'envoi</strong> depuis WP Mail SMTP</li>\n";
echo "<li><strong>Revenir tester</strong> les emails Institut Booking</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>📞 Support technique</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Informations pour le support:</h3>\n";
echo "<ul>\n";
echo "<li><strong>WordPress Version:</strong> " . get_bloginfo('version') . "</li>\n";
echo "<li><strong>PHP Version:</strong> " . PHP_VERSION . "</li>\n";
echo "<li><strong>Plugin Institut Booking:</strong> Actif</li>\n";
echo "<li><strong>Fonction wp_mail:</strong> " . (function_exists('wp_mail') ? 'Disponible' : 'Non disponible') . "</li>\n";
echo "<li><strong>SMTP Plugin:</strong> " . ($active_smtp ? 'Actif' : 'Non configuré') . "</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#2196f3;font-weight:bold;'>📧 Diagnostic terminé - Vérifiez les recommandations ci-dessus 📧</p>\n";
?>
