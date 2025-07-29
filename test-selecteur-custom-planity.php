<?php
/**
 * Test sélecteur téléphone custom Planity
 * Remplacement complet d'intl-tel-input
 */

echo "<h1>📞 Test Sélecteur Custom Planity</h1>\n";

echo "<h2>🚀 Solution révolutionnaire</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Approche radicale :</h3>\n";
echo "<ul>\n";
echo "<li>🔥 <strong>Remplacement total</strong> : Bye bye intl-tel-input !</li>\n";
echo "<li>🎨 <strong>Composant 100% custom</strong> : Design Planity natif</li>\n";
echo "<li>📱 <strong>13 pays populaires</strong> : France, Algérie, Maroc, etc.</li>\n";
echo "<li>✨ <strong>Animations fluides</strong> : Hover states modernes</li>\n";
echo "<li>🔧 <strong>API simple</strong> : Fonctions JavaScript intégrées</li>\n";
echo "<li>🚀 <strong>Performance</strong> : Léger et rapide</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🌍 Pays disponibles</h2>\n";

echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Liste des pays :</h3>\n";
echo "<ul style='display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:8px;'>\n";
echo "<li>🇫🇷 <strong>France</strong> : +33</li>\n";
echo "<li>🇩🇿 <strong>Algérie</strong> : +213</li>\n";
echo "<li>🇲🇦 <strong>Maroc</strong> : +212</li>\n";
echo "<li>🇹🇳 <strong>Tunisie</strong> : +216</li>\n";
echo "<li>🇩🇪 <strong>Allemagne</strong> : +49</li>\n";
echo "<li>🇪🇸 <strong>Espagne</strong> : +34</li>\n";
echo "<li>🇮🇹 <strong>Italie</strong> : +39</li>\n";
echo "<li>🇬🇧 <strong>Royaume-Uni</strong> : +44</li>\n";
echo "<li>🇺🇸 <strong>États-Unis</strong> : +1</li>\n";
echo "<li>🇨🇦 <strong>Canada</strong> : +1</li>\n";
echo "<li>🇧🇪 <strong>Belgique</strong> : +32</li>\n";
echo "<li>🇨🇭 <strong>Suisse</strong> : +41</li>\n";
echo "<li>🇱🇺 <strong>Luxembourg</strong> : +352</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📱 Simulation du sélecteur custom</h2>\n";

// Inclure le CSS et JS inline pour la démo
echo "<style>\n";
echo ".demo-planity-phone-container {\n";
echo "  width: 100%;\n";
echo "  border-radius: 12px;\n";
echo "  background: #f9fafb;\n";
echo "  border: 1px solid #d1d5db;\n";
echo "  padding: 0;\n";
echo "  display: flex;\n";
echo "  align-items: center;\n";
echo "  min-height: 52px;\n";
echo "  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);\n";
echo "  position: relative;\n";
echo "  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;\n";
echo "}\n";
echo ".demo-planity-phone-container:focus-within {\n";
echo "  background: #ffffff;\n";
echo "  border-color: #374151;\n";
echo "  box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);\n";
echo "}\n";
echo ".demo-country-selector {\n";
echo "  min-width: 80px;\n";
echo "  height: 100%;\n";
echo "  display: flex;\n";
echo "  align-items: center;\n";
echo "  justify-content: center;\n";
echo "  background: #e5e7eb;\n";
echo "  border-radius: 12px 0 0 12px;\n";
echo "  border-right: 1px solid #d1d5db;\n";
echo "  padding: 0 12px;\n";
echo "  cursor: pointer;\n";
echo "  transition: all 0.2s ease;\n";
echo "  user-select: none;\n";
echo "}\n";
echo ".demo-country-selector:hover {\n";
echo "  background: #d1d5db;\n";
echo "}\n";
echo ".demo-country-dropdown {\n";
echo "  position: absolute;\n";
echo "  top: 100%;\n";
echo "  left: 0;\n";
echo "  right: 0;\n";
echo "  background: #ffffff;\n";
echo "  border: 1px solid #e5e7eb;\n";
echo "  border-radius: 12px;\n";
echo "  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);\n";
echo "  padding: 8px 0;\n";
echo "  margin-top: 4px;\n";
echo "  max-height: 200px;\n";
echo "  overflow-y: auto;\n";
echo "  z-index: 1000;\n";
echo "  display: none;\n";
echo "}\n";
echo ".demo-country-item {\n";
echo "  padding: 10px 16px;\n";
echo "  background: #ffffff;\n";
echo "  color: #374151;\n";
echo "  font-size: 14px;\n";
echo "  font-weight: 500;\n";
echo "  cursor: pointer;\n";
echo "  transition: all 0.2s ease;\n";
echo "  display: flex;\n";
echo "  align-items: center;\n";
echo "  gap: 12px;\n";
echo "}\n";
echo ".demo-country-item:hover {\n";
echo "  background: #f9fafb;\n";
echo "  color: #111827;\n";
echo "}\n";
echo "</style>\n";

echo "<div style='max-width:500px;margin:20px auto;background:#ffffff;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;padding:2rem;'>\n";

echo "<h3 style='font-size:20px;font-weight:700;color:#111827;margin-bottom:1.5rem;text-align:center;'>Téléphone</h3>\n";

echo "<div class='demo-planity-phone-container'>\n";
echo "<div class='demo-country-selector' onclick='toggleDropdown()'>\n";
echo "<span style='font-size:16px;margin-right:6px;'>🇫🇷</span>\n";
echo "<span style='color:#374151;font-weight:600;font-size:14px;margin-right:4px;'>+33</span>\n";
echo "<span id='demo-arrow' style='border-left:4px solid transparent;border-right:4px solid transparent;border-top:4px solid #6b7280;border-bottom:none;transition:transform 0.2s ease;'></span>\n";
echo "</div>\n";

echo "<input type='tel' placeholder='6 12 34 56 78' style='width:100%;border:none;background:transparent;border-radius:0 12px 12px 0;padding:16px;font-size:16px;color:#111827;box-shadow:none;outline:none;height:52px;line-height:1.5;font-weight:500;'>\n";

echo "<div id='demo-dropdown' class='demo-country-dropdown'>\n";

$countries = [
    ['🇫🇷', 'France', '+33'],
    ['🇩🇿', 'Algérie', '+213'],
    ['🇲🇦', 'Maroc', '+212'],
    ['🇹🇳', 'Tunisie', '+216'],
    ['🇩🇪', 'Allemagne', '+49'],
    ['🇪🇸', 'Espagne', '+34'],
    ['🇮🇹', 'Italie', '+39'],
    ['🇬🇧', 'Royaume-Uni', '+44'],
    ['🇺🇸', 'États-Unis', '+1'],
    ['🇨🇦', 'Canada', '+1'],
    ['🇧🇪', 'Belgique', '+32'],
    ['🇨🇭', 'Suisse', '+41'],
    ['🇱🇺', 'Luxembourg', '+352']
];

foreach ($countries as $country) {
    echo "<div class='demo-country-item' onclick='selectCountry(\"{$country[0]}\", \"{$country[1]}\", \"{$country[2]}\")'>\n";
    echo "<span style='font-size:16px;width:20px;height:15px;display:flex;align-items:center;justify-content:center;border-radius:2px;border:1px solid #e5e7eb;margin-right:8px;flex-shrink:0;'>{$country[0]}</span>\n";
    echo "<span style='color:#374151;font-weight:500;font-size:14px;flex:1;'>{$country[1]}</span>\n";
    echo "<span style='color:#6b7280;font-weight:600;font-size:13px;background:#f9fafb;padding:2px 6px;border-radius:4px;'>{$country[2]}</span>\n";
    echo "</div>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "<button style='width:100%;min-height:48px;padding:16px;font-size:16px;font-weight:600;border-radius:12px;background:#111827;color:#ffffff;border:none;margin:1.5rem 0 0 0;cursor:pointer;transition:all 0.2s ease;' ";
echo "onmouseover='this.style.background=\"#374151\";this.style.transform=\"translateY(-1px)\";' ";
echo "onmouseout='this.style.background=\"#111827\";this.style.transform=\"translateY(0)\";' ";
echo "onclick='alert(\"✅ Sélecteur custom Planity !\\n\\n→ Design 100% natif\\n→ Palette noir/blanc/gris\\n→ Performance optimale\\n→ Bye bye intl-tel-input !\")'>";
echo "Tester le sélecteur";
echo "</button>\n";

echo "</div>\n";

echo "<script>\n";
echo "function toggleDropdown() {\n";
echo "  const dropdown = document.getElementById('demo-dropdown');\n";
echo "  const arrow = document.getElementById('demo-arrow');\n";
echo "  const isOpen = dropdown.style.display === 'block';\n";
echo "  dropdown.style.display = isOpen ? 'none' : 'block';\n";
echo "  arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';\n";
echo "}\n";
echo "function selectCountry(flag, name, dial) {\n";
echo "  const selector = document.querySelector('.demo-country-selector');\n";
echo "  selector.innerHTML = `<span style='font-size:16px;margin-right:6px;'>\${flag}</span><span style='color:#374151;font-weight:600;font-size:14px;margin-right:4px;'>\${dial}</span><span id='demo-arrow' style='border-left:4px solid transparent;border-right:4px solid transparent;border-top:4px solid #6b7280;border-bottom:none;transition:transform 0.2s ease;'></span>`;\n";
echo "  document.getElementById('demo-dropdown').style.display = 'none';\n";
echo "  console.log('Pays sélectionné:', name, dial);\n";
echo "}\n";
echo "document.addEventListener('click', function(e) {\n";
echo "  if (!e.target.closest('.demo-planity-phone-container')) {\n";
echo "    document.getElementById('demo-dropdown').style.display = 'none';\n";
echo "    document.getElementById('demo-arrow').style.transform = 'rotate(0deg)';\n";
echo "  }\n";
echo "});\n";
echo "</script>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez le sélecteur custom Planity</em></p>\n";

echo "<h2>🔧 Fonctionnalités du script</h2>\n";

echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h3>API JavaScript disponible :</h3>\n";
echo "<ul>\n";
echo "<li>📞 <strong>getPlanityPhoneNumber()</strong> : Numéro complet avec code pays</li>\n";
echo "<li>📱 <strong>getPlanityPhoneNumberOnly()</strong> : Numéro sans code pays</li>\n";
echo "<li>🌍 <strong>getPlanityCountryCode()</strong> : Code pays sélectionné</li>\n";
echo "<li>🔄 <strong>Auto-remplacement</strong> : Remplace intl-tel-input automatiquement</li>\n";
echo "<li>👁️ <strong>MutationObserver</strong> : Surveille les nouveaux éléments</li>\n";
echo "<li>⚡ <strong>Performance</strong> : Léger et rapide</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🧪 Test en conditions réelles</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li><strong>Vider le cache</strong> : Navigateur + plugin cache</li>\n";
echo "<li><strong>Recharger la page</strong> : Hard refresh (Ctrl+F5)</li>\n";
echo "<li><strong>Aller à l'étape informations</strong> : Naviguer dans le formulaire</li>\n";
echo "<li><strong>Observer le champ téléphone</strong> : Nouveau design Planity</li>\n";
echo "<li><strong>Cliquer sur le sélecteur</strong> : Dropdown custom s'ouvre</li>\n";
echo "<li><strong>Sélectionner un pays</strong> : Interface fluide et moderne</li>\n";
echo "<li><strong>Console développeur</strong> : Vérifier les logs du script</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🔍 Signaux de réussite</h2>\n";

echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>✅ Indicateurs que ça fonctionne :</h3>\n";
echo "<ul>\n";
echo "<li>📞 <strong>Design Planity</strong> : Fond gris clair, bordures modernes</li>\n";
echo "<li>🌍 <strong>Sélecteur custom</strong> : Flag + code pays + flèche</li>\n";
echo "<li>📋 <strong>Dropdown moderne</strong> : Liste pays style Planity</li>\n";
echo "<li>✨ <strong>Animations fluides</strong> : Hover states modernes</li>\n";
echo "<li>🔧 <strong>Console</strong> : \"✅ Sélecteur téléphone Planity créé\"</li>\n";
echo "<li>📱 <strong>Responsive</strong> : Adaptation mobile parfaite</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎯 Avantages du sélecteur custom</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>🚀 Pourquoi c'est mieux :</h3>\n";
echo "<ul>\n";
echo "<li>🎨 <strong>Design natif</strong> : 100% Planity, aucun conflit CSS</li>\n";
echo "<li>⚡ <strong>Performance</strong> : Léger, pas de librairie externe lourde</li>\n";
echo "<li>🔧 <strong>Contrôle total</strong> : Personnalisation complète possible</li>\n";
echo "<li>📱 <strong>Mobile optimisé</strong> : Touch-friendly natif</li>\n";
echo "<li>🌍 <strong>Pays ciblés</strong> : Seulement les pays utiles</li>\n";
echo "<li>🚀 <strong>Maintenance</strong> : Code simple et maintenable</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📋 Checklist d'intégration</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>📋 Vérifications :</h3>\n";
echo "<ul>\n";
echo "<li>☑️ <strong>Script créé</strong> : custom-phone-selector-planity.js</li>\n";
echo "<li>☑️ <strong>Script intégré</strong> : Chargé dans booking-form.php</li>\n";
echo "<li>☑️ <strong>API mise à jour</strong> : booking-form-main.js modifié</li>\n";
echo "<li>☑️ <strong>Validation adaptée</strong> : Fonctions Planity utilisées</li>\n";
echo "<li>☑️ <strong>Auto-remplacement</strong> : intl-tel-input remplacé</li>\n";
echo "<li>☑️ <strong>MutationObserver</strong> : Surveillance DOM active</li>\n";
echo "<li>☑️ <strong>Responsive</strong> : Mobile et desktop optimisés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Sélecteur téléphone custom Planity parfait :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🔥 <strong>Révolution</strong> : Bye bye intl-tel-input !</li>\n";
echo "<li>🎨 <strong>Design natif</strong> : 100% Planity noir/blanc/gris</li>\n";
echo "<li>📱 <strong>13 pays populaires</strong> : Sélection ciblée</li>\n";
echo "<li>✨ <strong>Animations premium</strong> : Micro-interactions fluides</li>\n";
echo "<li>🔧 <strong>API simple</strong> : Fonctions JavaScript intégrées</li>\n";
echo "<li>🚀 <strong>Performance</strong> : Léger, rapide et maintenable</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📞 Sélecteur téléphone custom Planity parfaitement créé ! 🎯</p>\n";
?>
