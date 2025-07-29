<?php
/**
 * Test forçage des styles gris/blanc/noir
 * Styles avec !important pour surcharger tout
 */

echo "<h1>💪 Test Forçage Styles - Gris/Blanc/Noir Forcé</h1>\n";

echo "<h2>🎯 Styles forcés avec !important</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Forçage des couleurs :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>!important partout</strong> : Priorité maximale</li>\n";
echo "<li>✅ <strong>Sélecteurs spécifiques</strong> : Ciblage précis</li>\n";
echo "<li>✅ <strong>Surcharge complète</strong> : Écrase tout beige</li>\n";
echo "<li>✅ <strong>Styles inline forcés</strong> : JavaScript surchargé</li>\n";
echo "<li>✅ <strong>Palette pure</strong> : Gris/Blanc/Noir uniquement</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 CSS de forçage</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Styles avec priorité maximale :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Forçage total des créneaux */\n";
echo ".slot-btn,\n";
echo ".slot-btn-planity,\n";
echo "button[class*='slot'],\n";
echo "[class*='slot'] button {\n";
echo "  background: #ffffff !important;\n";
echo "  color: #111827 !important;\n";
echo "  border: 1px solid #e5e7eb !important;\n";
echo "  border-radius: 6px !important;\n";
echo "}\n\n";
echo "/* Hover forcé */\n";
echo ".slot-btn:hover,\n";
echo ".slot-btn-planity:hover {\n";
echo "  background: #f3f4f6 !important;\n";
echo "  color: #374151 !important;\n";
echo "  border-color: #d1d5db !important;\n";
echo "}\n\n";
echo "/* Sélection forcée */\n";
echo ".slot-btn[disabled],\n";
echo ".slot-btn-planity[disabled] {\n";
echo "  background: #111827 !important;\n";
echo "  color: white !important;\n";
echo "  border-color: #111827 !important;\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🔧 Injection du CSS de forçage</h2>\n";

echo "<style>\n";
echo "/* FORÇAGE TOTAL - PRIORITÉ MAXIMALE */\n";
echo ".slot-btn,\n";
echo ".slot-btn-planity,\n";
echo "button[class*='slot'],\n";
echo "[class*='slot'] button,\n";
echo "#slots-list button,\n";
echo ".slots-grid-planity button {\n";
echo "  background: #ffffff !important;\n";
echo "  color: #111827 !important;\n";
echo "  border: 1px solid #e5e7eb !important;\n";
echo "  border-radius: 6px !important;\n";
echo "  font-size: 14px !important;\n";
echo "  font-weight: 500 !important;\n";
echo "  padding: 12px 6px !important;\n";
echo "  min-height: 48px !important;\n";
echo "  transition: all 0.2s ease !important;\n";
echo "}\n\n";
echo "/* Hover forcé */\n";
echo ".slot-btn:hover,\n";
echo ".slot-btn-planity:hover,\n";
echo "button[class*='slot']:hover,\n";
echo "[class*='slot'] button:hover,\n";
echo "#slots-list button:hover,\n";
echo ".slots-grid-planity button:hover {\n";
echo "  background: #f3f4f6 !important;\n";
echo "  color: #374151 !important;\n";
echo "  border-color: #d1d5db !important;\n";
echo "  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;\n";
echo "}\n\n";
echo "/* Sélection forcée */\n";
echo ".slot-btn[disabled],\n";
echo ".slot-btn-planity[disabled],\n";
echo "button[class*='slot'][disabled],\n";
echo "[class*='slot'] button[disabled],\n";
echo "#slots-list button[disabled],\n";
echo ".slots-grid-planity button[disabled] {\n";
echo "  background: #111827 !important;\n";
echo "  color: white !important;\n";
echo "  border-color: #111827 !important;\n";
echo "  cursor: not-allowed !important;\n";
echo "}\n\n";
echo "/* Grille forcée */\n";
echo ".slots-grid-planity {\n";
echo "  display: grid !important;\n";
echo "  grid-template-columns: repeat(5, 1fr) !important;\n";
echo "  gap: 0.4rem !important;\n";
echo "  padding: 0.4rem !important;\n";
echo "  width: 100% !important;\n";
echo "  box-sizing: border-box !important;\n";
echo "}\n";
echo "</style>\n";

echo "<h2>📱 Test avec styles forcés</h2>\n";

echo "<div style='max-width:400px;margin:20px auto;padding:0;background:white;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);'>\n";
echo "<h3 style='font-size:1rem;font-weight:600;color:#111827;margin:0 0 0.5rem 0;padding:1rem 0.4rem 0;'>CRÉNEAUX DISPONIBLES</h3>\n";

echo "<div style='padding:0.4rem;margin:0;box-sizing:border-box;'>\n";
echo "<div class='slots-grid-planity'>\n";

// Simulation avec styles forcés
$creneaux = [
    "09:00", "09:30", "10:00", "10:30", "11:00",
    "11:30", "12:00", "12:30", "13:00", "13:30", 
    "14:00", "14:30", "15:00", "15:30", "16:00"
];

foreach ($creneaux as $index => $creneau) {
    $isSelected = $index === 7; // Simuler 12:30 sélectionné
    
    if ($isSelected) {
        echo "<button class='slot-btn-planity' disabled>";
    } else {
        echo "<button class='slot-btn-planity' onclick='alert(\"✅ Créneau sélectionné !\\n\\nHeure: {$creneau}\\nStyles: Forcés avec !important\\nCouleurs: Gris/Blanc/Noir\\n\\n→ Beige éliminé !\")' >";
    }
    echo $creneau;
    echo "</button>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "<div style='padding:1rem 0.4rem;background:#f8f9fa;text-align:center;border-top:1px solid #e5e7eb;'>\n";
echo "<button style='background:#6c757d;color:white;border:none;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:500;cursor:pointer;margin-right:10px;'>← Retour</button>\n";
echo "<button style='background:#111827;color:white;border:none;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:500;cursor:pointer;'>Suivant →</button>\n";
echo "</div>\n";

echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez les styles forcés - Devrait être blanc/gris/noir</em></p>\n";

echo "<h2>🧪 Instructions de test</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li><strong>Copier le CSS de forçage</strong> ci-dessus</li>\n";
echo "<li><strong>Aller sur la page de réservation</strong></li>\n";
echo "<li><strong>Ouvrir les outils développeur</strong> (F12)</li>\n";
echo "<li><strong>Aller dans l'onglet Console</strong></li>\n";
echo "<li><strong>Coller et exécuter ce code :</strong></li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;margin:10px 0;'>\n";
echo "<h3>Code JavaScript à exécuter :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "// Injection CSS de forçage\n";
echo "const forceStyle = document.createElement('style');\n";
echo "forceStyle.textContent = `\n";
echo ".slot-btn, .slot-btn-planity, button[class*='slot'], [class*='slot'] button, #slots-list button, .slots-grid-planity button {\n";
echo "  background: #ffffff !important;\n";
echo "  color: #111827 !important;\n";
echo "  border: 1px solid #e5e7eb !important;\n";
echo "  border-radius: 6px !important;\n";
echo "}\n";
echo ".slot-btn:hover, .slot-btn-planity:hover { background: #f3f4f6 !important; color: #374151 !important; }\n";
echo ".slot-btn[disabled], .slot-btn-planity[disabled] { background: #111827 !important; color: white !important; }\n";
echo "`;\n";
echo "document.head.appendChild(forceStyle);\n";
echo "console.log('✅ Styles forcés appliqués !');\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Après forçage des styles :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>⚪ <strong>Fond blanc pur</strong> : #ffffff forcé</li>\n";
echo "<li>⚫ <strong>Texte noir</strong> : #111827 forcé</li>\n";
echo "<li>🔘 <strong>Bordures grises</strong> : #e5e7eb forcé</li>\n";
echo "<li>🔘 <strong>Hover gris clair</strong> : #f3f4f6 forcé</li>\n";
echo "<li>⚫ <strong>Sélection noire</strong> : #111827 forcé</li>\n";
echo "<li>🚫 <strong>Zéro beige</strong> : Complètement éliminé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🔧 Solution permanente</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>Pour appliquer définitivement :</h3>\n";
echo "<ol>\n";
echo "<li><strong>Ajouter le CSS de forçage</strong> au fichier booking-form.css</li>\n";
echo "<li><strong>Placer à la fin</strong> pour priorité maximale</li>\n";
echo "<li><strong>Utiliser !important</strong> sur tous les styles</li>\n";
echo "<li><strong>Cibler tous les sélecteurs</strong> possibles</li>\n";
echo "<li><strong>Tester sur mobile et desktop</strong></li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Styles forcés - Beige définitivement éliminé :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>💪 <strong>Forçage total</strong> : !important partout</li>\n";
echo "<li>⚪ <strong>Blanc pur forcé</strong> : #ffffff</li>\n";
echo "<li>⚫ <strong>Noir forcé</strong> : #111827</li>\n";
echo "<li>🔘 <strong>Gris forcés</strong> : #e5e7eb, #f3f4f6</li>\n";
echo "<li>🚫 <strong>Beige éliminé</strong> : Aucune trace</li>\n";
echo "<li>🎯 <strong>Priorité maximale</strong> : Surcharge tout</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>💪 Styles forcés - Beige définitivement éliminé ! 🎯</p>\n";
?>
