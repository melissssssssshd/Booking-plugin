<?php
/**
 * Test ticket Planity centré et moderne
 * Design épuré noir/blanc/gris
 */

echo "<h1>🎫 Test Ticket Planity Centré</h1>\n";

echo "<h2>🎨 Design épuré moderne</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Nouveau style Planity :</h3>\n";
echo "<ul>\n";
echo "<li>🎯 <strong>Centrage parfait</strong> : Ticket centré sur toutes les tailles d'écran</li>\n";
echo "<li>🎨 <strong>Design épuré</strong> : Palette noir/blanc/gris minimaliste</li>\n";
echo "<li>✨ <strong>Icône moderne</strong> : Check simple et élégant</li>\n";
echo "<li>📱 <strong>Responsive</strong> : Adaptation mobile parfaite</li>\n";
echo "<li>🔧 <strong>Typographie</strong> : Inter/Roboto pour la modernité</li>\n";
echo "<li>📋 <strong>Layout structuré</strong> : Informations bien organisées</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎫 Aperçu du ticket moderne</h2>\n";

// Inclure le CSS inline pour la démo
echo "<style>\n";
echo ".demo-ticket {\n";
echo "  background: #ffffff;\n";
echo "  border-radius: 16px;\n";
echo "  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);\n";
echo "  border: 1px solid #e5e7eb;\n";
echo "  padding: 2rem;\n";
echo "  max-width: 480px;\n";
echo "  margin: 2rem auto;\n";
echo "  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;\n";
echo "  display: flex;\n";
echo "  flex-direction: column;\n";
echo "  align-items: center;\n";
echo "  text-align: center;\n";
echo "}\n";
echo ".demo-success-icon {\n";
echo "  background: #f9fafb;\n";
echo "  color: #374151;\n";
echo "  border-radius: 50%;\n";
echo "  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);\n";
echo "  border: 1px solid #e5e7eb;\n";
echo "  display: flex;\n";
echo "  align-items: center;\n";
echo "  justify-content: center;\n";
echo "  width: 64px;\n";
echo "  height: 64px;\n";
echo "  margin: 0 auto 1.5rem auto;\n";
echo "}\n";
echo ".demo-success-badge {\n";
echo "  background: #111827;\n";
echo "  color: #ffffff;\n";
echo "  font-size: 18px;\n";
echo "  font-weight: 600;\n";
echo "  border-radius: 8px;\n";
echo "  padding: 12px 24px;\n";
echo "  margin-bottom: 1.5rem;\n";
echo "}\n";
echo ".demo-success-message {\n";
echo "  color: #6b7280;\n";
echo "  font-size: 16px;\n";
echo "  font-weight: 500;\n";
echo "  margin-bottom: 2rem;\n";
echo "  line-height: 1.5;\n";
echo "}\n";
echo ".demo-ticket-details {\n";
echo "  background: #f9fafb;\n";
echo "  border-radius: 12px;\n";
echo "  padding: 1.5rem;\n";
echo "  margin-bottom: 2rem;\n";
echo "  width: 100%;\n";
echo "  font-size: 14px;\n";
echo "  color: #374151;\n";
echo "  border: 1px solid #e5e7eb;\n";
echo "  text-align: left;\n";
echo "}\n";
echo ".demo-ticket-details > div {\n";
echo "  display: flex;\n";
echo "  justify-content: space-between;\n";
echo "  align-items: center;\n";
echo "  padding: 8px 0;\n";
echo "  border-bottom: 1px solid #e5e7eb;\n";
echo "}\n";
echo ".demo-ticket-details > div:last-child {\n";
echo "  border-bottom: none;\n";
echo "}\n";
echo ".demo-ticket-label {\n";
echo "  color: #6b7280;\n";
echo "  font-weight: 500;\n";
echo "  min-width: 80px;\n";
echo "}\n";
echo ".demo-ticket-value {\n";
echo "  color: #111827;\n";
echo "  font-weight: 600;\n";
echo "}\n";
echo ".demo-download-btn {\n";
echo "  background: #111827;\n";
echo "  color: #ffffff;\n";
echo "  border: none;\n";
echo "  border-radius: 8px;\n";
echo "  padding: 12px 24px;\n";
echo "  font-size: 14px;\n";
echo "  font-weight: 600;\n";
echo "  cursor: pointer;\n";
echo "  transition: all 0.2s ease;\n";
echo "}\n";
echo ".demo-download-btn:hover {\n";
echo "  background: #374151;\n";
echo "}\n";
echo "@media (max-width: 600px) {\n";
echo "  .demo-ticket {\n";
echo "    padding: 1.5rem 1rem;\n";
echo "    max-width: 95vw;\n";
echo "    margin: 1.5rem auto;\n";
echo "  }\n";
echo "  .demo-success-icon {\n";
echo "    width: 56px;\n";
echo "    height: 56px;\n";
echo "  }\n";
echo "  .demo-success-badge {\n";
echo "    font-size: 16px;\n";
echo "    padding: 10px 20px;\n";
echo "  }\n";
echo "  .demo-success-message {\n";
echo "    font-size: 14px;\n";
echo "  }\n";
echo "  .demo-ticket-details {\n";
echo "    padding: 1rem;\n";
echo "    font-size: 13px;\n";
echo "  }\n";
echo "}\n";
echo "</style>\n";

echo "<div class='demo-ticket'>\n";

echo "<div class='demo-success-icon'>\n";
echo "<svg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' style='width: 28px; height: 28px;'>\n";
echo "<path d='M20 6L9 17l-5-5'/>\n";
echo "</svg>\n";
echo "</div>\n";

echo "<div class='demo-success-badge'>Réservation confirmée</div>\n";

echo "<div class='demo-success-message'>Merci pour votre réservation !<br>Un email de confirmation vous a été envoyé.</div>\n";

echo "<div class='demo-ticket-details'>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Service</span>\n";
echo "<span class='demo-ticket-value'>Soin du visage</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Praticienne</span>\n";
echo "<span class='demo-ticket-value'>Lamia</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Date</span>\n";
echo "<span class='demo-ticket-value'>2025-07-31</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Créneau</span>\n";
echo "<span class='demo-ticket-value'>11:30</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Client</span>\n";
echo "<span class='demo-ticket-value'>Melissa Hadj</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Email</span>\n";
echo "<span class='demo-ticket-value'>melissa@gmail.com</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Téléphone</span>\n";
echo "<span class='demo-ticket-value'>+213 555 666 10</span>\n";
echo "</div>\n";
echo "<div>\n";
echo "<span class='demo-ticket-label'>Prix</span>\n";
echo "<span class='demo-ticket-value'>3 000 DA</span>\n";
echo "</div>\n";
echo "</div>\n";

echo "<div style='display: flex; justify-content: center;'>\n";
echo "<button class='demo-download-btn' onclick='alert(\"✅ Ticket Planity moderne !\\n\\n→ Design épuré noir/blanc/gris\\n→ Centrage parfait\\n→ Responsive mobile\\n→ Typographie moderne\\n→ Layout structuré\")'>\n";
echo "Télécharger le ticket\n";
echo "</button>\n";
echo "</div>\n";

echo "</div>\n";

echo "<h2>🎨 Caractéristiques du design</h2>\n";

echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Palette de couleurs Planity :</h3>\n";
echo "<ul style='display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;'>\n";
echo "<li style='background:#111827;color:#ffffff;padding:8px 12px;border-radius:6px;text-align:center;'><strong>#111827</strong><br>Noir principal</li>\n";
echo "<li style='background:#374151;color:#ffffff;padding:8px 12px;border-radius:6px;text-align:center;'><strong>#374151</strong><br>Gris foncé</li>\n";
echo "<li style='background:#6b7280;color:#ffffff;padding:8px 12px;border-radius:6px;text-align:center;'><strong>#6b7280</strong><br>Gris moyen</li>\n";
echo "<li style='background:#e5e7eb;color:#111827;padding:8px 12px;border-radius:6px;text-align:center;'><strong>#e5e7eb</strong><br>Gris clair</li>\n";
echo "<li style='background:#f9fafb;color:#111827;padding:8px 12px;border-radius:6px;text-align:center;'><strong>#f9fafb</strong><br>Gris très clair</li>\n";
echo "<li style='background:#ffffff;color:#111827;padding:8px 12px;border-radius:6px;text-align:center;border:1px solid #e5e7eb;'><strong>#ffffff</strong><br>Blanc pur</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📱 Responsive design</h2>\n";

echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h3>Adaptations mobile :</h3>\n";
echo "<ul>\n";
echo "<li>📱 <strong>Largeur adaptative</strong> : 95vw sur mobile, 480px sur desktop</li>\n";
echo "<li>🎯 <strong>Centrage parfait</strong> : margin auto sur tous les écrans</li>\n";
echo "<li>📏 <strong>Padding réduit</strong> : 1.5rem/1rem sur mobile vs 2rem desktop</li>\n";
echo "<li>🔘 <strong>Icône compacte</strong> : 56px sur mobile vs 64px desktop</li>\n";
echo "<li>📝 <strong>Texte optimisé</strong> : Tailles réduites pour mobile</li>\n";
echo "<li>📋 <strong>Détails compacts</strong> : Padding et font-size adaptés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🔧 Améliorations apportées</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>Changements majeurs :</h3>\n";
echo "<ul>\n";
echo "<li>🎯 <strong>Centrage absolu</strong> : display: flex + align-items: center</li>\n";
echo "<li>🎨 <strong>Palette épurée</strong> : Fini les couleurs pastel/rose</li>\n";
echo "<li>✨ <strong>Icône simplifiée</strong> : Check moderne au lieu du cercle complexe</li>\n";
echo "<li>📋 <strong>Layout structuré</strong> : Flex layout pour les détails</li>\n";
echo "<li>🔘 <strong>Bouton moderne</strong> : Style Planity cohérent</li>\n";
echo "<li>📱 <strong>Mobile-first</strong> : Responsive design optimisé</li>\n";
echo "<li>🔧 <strong>Typographie</strong> : Inter/Roboto pour la modernité</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🧪 Test en conditions réelles</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li><strong>Vider le cache</strong> : Navigateur + plugin cache</li>\n";
echo "<li><strong>Recharger la page</strong> : Hard refresh (Ctrl+F5)</li>\n";
echo "<li><strong>Compléter une réservation</strong> : Aller jusqu'au ticket</li>\n";
echo "<li><strong>Observer le centrage</strong> : Ticket parfaitement centré</li>\n";
echo "<li><strong>Vérifier le design</strong> : Palette noir/blanc/gris</li>\n";
echo "<li><strong>Tester mobile</strong> : Mode responsive, adaptation parfaite</li>\n";
echo "<li><strong>Tester le bouton</strong> : Téléchargement PDF fonctionnel</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🔍 Signaux de réussite</h2>\n";

echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>✅ Indicateurs que ça fonctionne :</h3>\n";
echo "<ul>\n";
echo "<li>🎯 <strong>Centrage parfait</strong> : Ticket au centre de l'écran</li>\n";
echo "<li>🎨 <strong>Design épuré</strong> : Palette noir/blanc/gris cohérente</li>\n";
echo "<li>✨ <strong>Icône moderne</strong> : Check simple et élégant</li>\n";
echo "<li>📋 <strong>Layout structuré</strong> : Informations bien alignées</li>\n";
echo "<li>🔘 <strong>Bouton stylé</strong> : Style Planity noir avec hover</li>\n";
echo "<li>📱 <strong>Mobile parfait</strong> : Adaptation responsive fluide</li>\n";
echo "<li>🔧 <strong>Typographie</strong> : Polices modernes et lisibles</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📋 Checklist finale</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>📋 Vérifications :</h3>\n";
echo "<ul>\n";
echo "<li>☑️ <strong>CSS modernisé</strong> : Styles Planity appliqués</li>\n";
echo "<li>☑️ <strong>JavaScript mis à jour</strong> : Template ticket modifié</li>\n";
echo "<li>☑️ <strong>Centrage parfait</strong> : Flex layout + margin auto</li>\n";
echo "<li>☑️ <strong>Responsive design</strong> : Adaptations mobile ajoutées</li>\n";
echo "<li>☑️ <strong>Palette cohérente</strong> : Noir/blanc/gris partout</li>\n";
echo "<li>☑️ <strong>Icône moderne</strong> : SVG check simplifié</li>\n";
echo "<li>☑️ <strong>Bouton stylé</strong> : Design Planity cohérent</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Ticket Planity centré et moderne parfait :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🎯 <strong>Centrage absolu</strong> : Parfaitement centré sur tous les écrans</li>\n";
echo "<li>🎨 <strong>Design épuré</strong> : Palette noir/blanc/gris minimaliste</li>\n";
echo "<li>✨ <strong>Modernité</strong> : Icônes, typographie et layout modernes</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Adaptation mobile fluide</li>\n";
echo "<li>🔧 <strong>UX optimisée</strong> : Lisibilité et ergonomie parfaites</li>\n";
echo "<li>🚀 <strong>Performance</strong> : CSS optimisé et léger</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>🎫 Ticket Planity centré et moderne parfaitement créé ! 🎯</p>\n";
?>
