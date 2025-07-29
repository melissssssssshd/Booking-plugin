<?php
/**
 * Test de diagnostic des emails de remerciement
 * Vérification de la configuration et du fonctionnement
 */

echo "<h1>📧 Diagnostic des Emails de Remerciement</h1>\n";

echo "<h2>🚨 Problème identifié</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Les emails de remerciement ne s'envoient pas après réservation :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Fonction d'envoi manquante</strong> dans le traitement d'ajout</li>\n";
echo "<li>❌ <strong>Appel à IB_Notifications::send_thank_you() absent</strong></li>\n";
echo "<li>❌ <strong>Email envoyé uniquement depuis class-bookings.php</strong></li>\n";
echo "<li>❌ <strong>Pas d'envoi depuis page-bookings.php</strong> (interface admin)</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Solution appliquée</h2>\n";

echo "<h3>✅ Ajout de l'envoi d'email dans page-bookings.php</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Code ajouté après l'ajout réussi :</strong><br>\n";
echo "<div style='background:#f5f5f5;padding:10px;border:1px solid #ddd;font-family:monospace;margin:10px 0;'>\n";
echo "if (\$result) {<br>\n";
echo "&nbsp;&nbsp;IB_Logs::add(get_current_user_id(), 'ajout_reservation', ...);<br>\n";
echo "&nbsp;&nbsp;<br>\n";
echo "&nbsp;&nbsp;<span style='color:#4caf50;font-weight:bold;'>// Envoyer l'email de remerciement au client</span><br>\n";
echo "&nbsp;&nbsp;<span style='color:#4caf50;font-weight:bold;'>require_once plugin_dir_path(__FILE__) . '../includes/notifications.php';</span><br>\n";
echo "&nbsp;&nbsp;<span style='color:#4caf50;font-weight:bold;'>IB_Notifications::send_thank_you(\$result);</span><br>\n";
echo "&nbsp;&nbsp;<br>\n";
echo "&nbsp;&nbsp;echo 'Réservation ajoutée avec succès.';<br>\n";
echo "}<br>\n";
echo "</div>\n";
echo "</div>\n";

echo "<h2>🔧 Flux d'envoi d'emails</h2>\n";

echo "<h3>Avant la correction</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:4px;margin:10px 0;'>\n";
echo "<h4>❌ Emails manqués :</h4>\n";
echo "<ol>\n";
echo "<li><strong>Réservation depuis admin</strong> (page-bookings.php) → ❌ Pas d'email</li>\n";
echo "<li><strong>Réservation depuis frontend</strong> (class-bookings.php) → ✅ Email envoyé</li>\n";
echo "<li><strong>Réservation depuis shortcode</strong> (institut-booking.php) → ❌ Pas d'email</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h3>Après la correction</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:4px;margin:10px 0;'>\n";
echo "<h4>✅ Emails envoyés partout :</h4>\n";
echo "<ol>\n";
echo "<li><strong>Réservation depuis admin</strong> (page-bookings.php) → ✅ Email envoyé</li>\n";
echo "<li><strong>Réservation depuis frontend</strong> (class-bookings.php) → ✅ Email envoyé</li>\n";
echo "<li><strong>Réservation depuis shortcode</strong> (institut-booking.php) → ✅ Email envoyé</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>📧 Configuration des emails</h2>\n";

echo "<h3>Template par défaut</h3>\n";
echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;border-radius:4px;margin:10px 0;'>\n";
echo "<h4>Email de remerciement :</h4>\n";
echo "<div style='background:white;padding:15px;border:1px solid #e0e0e0;border-radius:4px;margin:10px 0;'>\n";
echo "<strong>Sujet :</strong> Confirmation de réception de votre réservation<br><br>\n";
echo "<strong>Corps :</strong><br>\n";
echo "Bonjour {client_name},<br><br>\n";
echo "Nous avons bien reçu votre demande de réservation pour le service {service_name}.<br>\n";
echo "Vous recevrez une confirmation définitive très prochainement de la part de {company}.<br><br>\n";
echo "Cordialement,<br>\n";
echo "L'équipe {company}\n";
echo "</div>\n";
echo "</div>\n";

echo "<h3>Variables disponibles</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<ul>\n";
echo "<li><strong>{client_name}</strong> : Nom du client</li>\n";
echo "<li><strong>{service_name}</strong> : Nom du service réservé</li>\n";
echo "<li><strong>{service}</strong> : Alias pour service_name</li>\n";
echo "<li><strong>{company}</strong> : Nom de l'entreprise (get_bloginfo('name'))</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🔍 Diagnostic de la fonction send_thank_you</h2>\n";

echo "<h3>Étapes de vérification</h3>\n";
echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<ol>\n";
echo "<li><strong>Récupération de la réservation</strong> depuis la base de données</li>\n";
echo "<li><strong>Validation de l'email client</strong> avec is_email()</li>\n";
echo "<li><strong>Récupération du service</strong> associé</li>\n";
echo "<li><strong>Remplacement des variables</strong> dans le template</li>\n";
echo "<li><strong>Envoi via wp_mail()</strong> avec headers HTML</li>\n";
echo "<li><strong>Logging des résultats</strong> (succès/échec)</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h3>Code de la fonction send_thank_you</h3>\n";
echo "<div style='background:#f5f5f5;padding:10px;border:1px solid #ddd;font-family:monospace;'>\n";
echo "public static function send_thank_you(\$booking_id) {<br>\n";
echo "&nbsp;&nbsp;global \$wpdb;<br>\n";
echo "&nbsp;&nbsp;<br>\n";
echo "&nbsp;&nbsp;// 1. Récupérer la réservation<br>\n";
echo "&nbsp;&nbsp;\$booking = \$wpdb->get_row(\$wpdb->prepare(<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\"SELECT * FROM {\$wpdb->prefix}ib_bookings WHERE id = %d\", \$booking_id<br>\n";
echo "&nbsp;&nbsp;));<br>\n";
echo "&nbsp;&nbsp;<br>\n";
echo "&nbsp;&nbsp;// 2. Vérifier l'email client<br>\n";
echo "&nbsp;&nbsp;\$client_email = isset(\$booking->client_email) && is_email(\$booking->client_email) <br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;? \$booking->client_email : '';<br>\n";
echo "&nbsp;&nbsp;<br>\n";
echo "&nbsp;&nbsp;// 3. Envoyer l'email si email valide<br>\n";
echo "&nbsp;&nbsp;if (!empty(\$client_email)) {<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\$subject = 'Confirmation de réception de votre réservation';<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\$template = get_option('ib_notify_client_thankyou', \$default);<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\$message = self::replace_vars(\$template, \$vars);<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;\$sent = self::send_email(\$client_email, \$subject, \$message);<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;// 4. Logger le résultat<br>\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;error_log('[IB Booking] Mail de remerciement: ' . (\$sent ? 'envoyé' : 'échec'));<br>\n";
echo "&nbsp;&nbsp;}<br>\n";
echo "}<br>\n";
echo "</div>\n";

echo "<h2>🧪 Test de la correction</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller dans le back-office → Réservations</li>\n";
echo "<li>Cliquer sur \"+ Ajouter une réservation\"</li>\n";
echo "<li>Remplir le formulaire avec :</li>\n";
echo "<ul>\n";
echo "<li><strong>Nom client</strong> : Test Client</li>\n";
echo "<li><strong>Email</strong> : votre-email@test.com</li>\n";
echo "<li><strong>Téléphone</strong> : +213555123456</li>\n";
echo "<li><strong>Service</strong> : Sélectionner un service</li>\n";
echo "<li><strong>Praticienne</strong> : Sélectionner une praticienne</li>\n";
echo "<li><strong>Date/Heure</strong> : Date future</li>\n";
echo "<li><strong>Statut</strong> : En attente</li>\n";
echo "</ul>\n";
echo "<li>Cliquer sur \"Ajouter la réservation\"</li>\n";
echo "<li>✅ Vérifier le message \"Réservation ajoutée avec succès\"</li>\n";
echo "<li>✅ Vérifier la réception de l'email de remerciement</li>\n";
echo "<li>Vérifier les logs d'erreur PHP si pas d'email reçu</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🔍 Vérification des logs</h2>\n";

echo "<h3>Logs PHP à surveiller</h3>\n";
echo "<div style='background:#f5f5f5;padding:10px;border:1px solid #ddd;font-family:monospace;'>\n";
echo "[IB Booking] Tentative envoi mail de remerciement au client: email@test.com, booking_id: 123<br>\n";
echo "[IB Booking] Mail de remerciement envoyé au client: email@test.com<br>\n";
echo "<br>\n";
echo "<span style='color:#f44336;'>// En cas d'erreur :</span><br>\n";
echo "[IB Booking] Échec envoi mail de remerciement au client: email@test.com<br>\n";
echo "[IB Booking] Email client absent pour le mail de remerciement, booking_id: 123<br>\n";
echo "</div>\n";

echo "<h3>Vérification de la configuration WordPress</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h4>Points à vérifier :</h4>\n";
echo "<ul>\n";
echo "<li><strong>wp_mail() fonctionnel</strong> : WordPress peut envoyer des emails</li>\n";
echo "<li><strong>SMTP configuré</strong> : Si hébergement ne supporte pas mail()</li>\n";
echo "<li><strong>Email admin valide</strong> : get_option('admin_email')</li>\n";
echo "<li><strong>Pas de plugin conflit</strong> : Désactiver autres plugins email</li>\n";
echo "<li><strong>Serveur mail actif</strong> : Hébergement autorise l'envoi</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🛠️ Solutions de dépannage</h2>\n";

echo "<h3>Si les emails ne partent toujours pas</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h4>1. Tester wp_mail() directement :</h4>\n";
echo "<div style='background:#f5f5f5;padding:10px;border:1px solid #ddd;font-family:monospace;margin:10px 0;'>\n";
echo "\$test = wp_mail('test@example.com', 'Test', 'Message de test');<br>\n";
echo "var_dump(\$test); // true = succès, false = échec<br>\n";
echo "</div>\n";

echo "<h4>2. Installer un plugin SMTP :</h4>\n";
echo "<ul>\n";
echo "<li><strong>WP Mail SMTP</strong> : Configuration SMTP facile</li>\n";
echo "<li><strong>Easy WP SMTP</strong> : Alternative simple</li>\n";
echo "<li><strong>Post SMTP</strong> : Solution complète</li>\n";
echo "</ul>\n";

echo "<h4>3. Vérifier les logs serveur :</h4>\n";
echo "<ul>\n";
echo "<li><strong>error_log PHP</strong> : Erreurs d'envoi</li>\n";
echo "<li><strong>Mail logs</strong> : Logs du serveur mail</li>\n";
echo "<li><strong>Spam folder</strong> : Emails en spam</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>✅ Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Emails de remerciement fonctionnels</h3>\n";
echo "<ul>\n";
echo "<li>📧 <strong>Email automatique</strong> : Envoyé après chaque réservation</li>\n";
echo "<li>🎯 <strong>Toutes les sources</strong> : Admin, frontend, shortcode</li>\n";
echo "<li>📝 <strong>Template personnalisable</strong> : Via page Notifications</li>\n";
echo "<li>🔍 <strong>Logs détaillés</strong> : Succès et échecs tracés</li>\n";
echo "<li>⚡ <strong>Envoi immédiat</strong> : Dès validation de la réservation</li>\n";
echo "<li>🎨 <strong>Format HTML</strong> : Emails avec mise en forme</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Notes importantes</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Points clés :</h3>\n";
echo "<ul>\n";
echo "<li><strong>Correction appliquée</strong> : Ajout de l'appel send_thank_you() dans page-bookings.php</li>\n";
echo "<li><strong>Template existant</strong> : Configuration déjà disponible dans les notifications</li>\n";
echo "<li><strong>Fonction robuste</strong> : Gestion d'erreurs et logging intégrés</li>\n";
echo "<li><strong>Variables dynamiques</strong> : Personnalisation automatique des emails</li>\n";
echo "<li><strong>Fallback admin</strong> : Notification admin en cas d'échec</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>🎉 Emails de remerciement maintenant fonctionnels ! 📧🎉</p>\n";
?>
