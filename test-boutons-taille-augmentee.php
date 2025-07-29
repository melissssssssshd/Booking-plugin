<?php
/**
 * Test boutons créneaux avec taille augmentée
 * Meilleure visibilité et facilité d'utilisation
 */

echo "<h1>👁️ Test Boutons Taille Augmentée - Visibilité Optimale</h1>\n";

echo "<h2>🎯 Taille augmentée pour meilleure visibilité</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Améliorations de visibilité :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Hauteur augmentée</strong> : 48px au lieu de 36px</li>\n";
echo "<li>✅ <strong>Padding augmenté</strong> : 12px au lieu de 8px</li>\n";
echo "<li>✅ <strong>Font-size augmentée</strong> : 14px au lieu de 12px</li>\n";
echo "<li>✅ <strong>Gap augmenté</strong> : 0.4rem au lieu de 0.25rem</li>\n";
echo "<li>✅ <strong>Border-radius augmenté</strong> : 6px au lieu de 4px</li>\n";
echo "<li>✅ <strong>Facilité d'utilisation</strong> : Touch-friendly mobile</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📏 Comparaison des tailles</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Propriété</th><th style='border:1px solid #ddd;padding:8px;'>Avant (Trop petit)</th><th style='border:1px solid #ddd;padding:8px;'>Après (Visible)</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Hauteur</td><td style='border:1px solid #ddd;padding:8px;'>36px</td><td style='border:1px solid #ddd;padding:8px;'>48px</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Padding</td><td style='border:1px solid #ddd;padding:8px;'>8px 4px</td><td style='border:1px solid #ddd;padding:8px;'>12px 6px</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Font-size</td><td style='border:1px solid #ddd;padding:8px;'>12px</td><td style='border:1px solid #ddd;padding:8px;'>14px</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Gap</td><td style='border:1px solid #ddd;padding:8px;'>0.25rem</td><td style='border:1px solid #ddd;padding:8px;'>0.4rem</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Border-radius</td><td style='border:1px solid #ddd;padding:8px;'>4px</td><td style='border:1px solid #ddd;padding:8px;'>6px</td></tr>\n";
echo "</table>\n";

echo "<h2>📝 Code CSS taille augmentée</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Boutons avec meilleure visibilité :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Grille avec gap augmenté */\n";
echo ".slots-grid-planity {\n";
echo "  display: grid;\n";
echo "  grid-template-columns: repeat(5, 1fr);\n";
echo "  gap: 0.4rem; /* Augmenté pour visibilité */\n";
echo "  padding: 0.4rem;\n";
echo "}\n\n";
echo "/* Boutons taille augmentée */\n";
echo ".slot-btn-planity {\n";
echo "  padding: 12px 6px; /* Augmenté */\n";
echo "  min-height: 48px; /* Augmenté */\n";
echo "  border-radius: 6px; /* Augmenté */\n";
echo "  background: #ffffff;\n";
echo "  border: 1px solid #e5e7eb;\n";
echo "  color: #111827;\n";
echo "  font-size: 14px; /* Augmenté */\n";
echo "  font-weight: 500;\n";
echo "}\n\n";
echo "/* Hover avec meilleure visibilité */\n";
echo ".slot-btn-planity:hover {\n";
echo "  background: #f3f4f6;\n";
echo "  border-color: #d1d5db;\n";
echo "  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);\n";
echo "}\n\n";
echo "/* Sélection bien visible */\n";
echo ".slot-btn-planity[disabled] {\n";
echo "  background: #111827;\n";
echo "  color: white;\n";
echo "  border-color: #111827;\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>📱 Simulation avec taille augmentée</h2>\n";

echo "<div style='max-width:400px;margin:20px auto;padding:0;background:white;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);'>\n";
echo "<h3 style='font-size:1rem;font-weight:600;color:#111827;margin:0 0 0.5rem 0;padding:1rem 0.4rem 0;'>CRÉNEAUX DISPONIBLES</h3>\n";

echo "<div style='padding:0.4rem;margin:0;box-sizing:border-box;'>\n";
echo "<div style='display:grid;grid-template-columns:repeat(5,1fr);gap:0.4rem;width:100%;box-sizing:border-box;'>\n";

// Simulation avec taille augmentée
$creneaux = [
    "09:00", "09:30", "10:00", "10:30", "11:00",
    "11:30", "12:00", "12:30", "13:00", "13:30", 
    "14:00", "14:30", "15:00", "15:30", "16:00"
];

foreach ($creneaux as $index => $creneau) {
    $isSelected = $index === 3; // Simuler 10:30 sélectionné
    
    if ($isSelected) {
        $style = "background:#111827;color:white;border:1px solid #111827;cursor:not-allowed;";
        $onclick = "";
    } else {
        $style = "background:#ffffff;color:#111827;border:1px solid #e5e7eb;cursor:pointer;";
        $onclick = "onclick='alert(\"✅ Créneau sélectionné !\\n\\nHeure: {$creneau}\\nTaille: 48px de hauteur\\nVisibilité: Optimale\\n\\n→ Boutons bien visibles !\")' ";
        $onclick .= "onmouseover='this.style.background=\"#f3f4f6\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"0 1px 3px rgba(0,0,0,0.1)\";' ";
        $onclick .= "onmouseout='this.style.background=\"#ffffff\";this.style.borderColor=\"#e5e7eb\";this.style.boxShadow=\"none\";'";
    }
    
    echo "<button style='display:flex;align-items:center;justify-content:center;padding:12px 6px;min-height:48px;border-radius:6px;font-size:14px;font-weight:500;line-height:1;transition:all 0.2s ease;width:100%;box-sizing:border-box;{$style}' {$onclick}>";
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

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez les boutons avec taille augmentée pour meilleure visibilité</em></p>\n";

echo "<h2>🔍 Avantages de la taille augmentée</h2>\n";

echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h3>Bénéfices pour l'utilisateur :</h3>\n";
echo "<ul>\n";
echo "<li>👁️ <strong>Meilleure visibilité</strong> : Boutons plus grands et lisibles</li>\n";
echo "<li>📱 <strong>Touch-friendly</strong> : Plus facile à cliquer sur mobile</li>\n";
echo "<li>🎯 <strong>Précision améliorée</strong> : Moins d'erreurs de clic</li>\n";
echo "<li>♿ <strong>Accessibilité</strong> : Conforme aux standards d'accessibilité</li>\n";
echo "<li>⚡ <strong>UX améliorée</strong> : Interaction plus fluide</li>\n";
echo "<li>🔤 <strong>Texte lisible</strong> : 14px au lieu de 12px</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🧪 Test de la visibilité</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page de réservation</li>\n";
echo "<li>Tester sur <strong>mobile et desktop</strong></li>\n";
echo "<li>Naviguer jusqu'à l'étape <strong>Date & Heure</strong></li>\n";
echo "<li>Sélectionner une date disponible</li>\n";
echo "<li>Vérifier la visibilité des boutons :</li>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Hauteur 48px</strong> : Boutons bien visibles</li>\n";
echo "<li>✅ <strong>Texte 14px</strong> : Parfaitement lisible</li>\n";
echo "<li>✅ <strong>Facilité de clic</strong> : Touch-friendly</li>\n";
echo "<li>✅ <strong>5 colonnes</strong> : Toujours optimisé</li>\n";
echo "<li>✅ <strong>Palette neutre</strong> : Blanc/Gris/Noir</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Boutons parfaitement visibles :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>👁️ <strong>Visibilité optimale</strong> : 48px de hauteur</li>\n";
echo "<li>📱 <strong>Mobile-friendly</strong> : Facile à cliquer</li>\n";
echo "<li>🔤 <strong>Texte lisible</strong> : 14px parfaitement visible</li>\n";
echo "<li>🎯 <strong>Précision améliorée</strong> : Moins d'erreurs</li>\n";
echo "<li>⚪ <strong>Palette neutre</strong> : Blanc/Gris/Noir</li>\n";
echo "<li>🚀 <strong>UX excellente</strong> : Interaction fluide</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>⚖️ Équilibre optimal</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>Compromis parfait :</h3>\n";
echo "<ul>\n";
echo "<li>📱 <strong>5 colonnes maintenues</strong> : Optimisation de l'espace</li>\n";
echo "<li>👁️ <strong>Visibilité améliorée</strong> : Boutons plus grands</li>\n";
echo "<li>⚡ <strong>15+ créneaux visibles</strong> : Toujours beaucoup</li>\n";
echo "<li>🎯 <strong>Facilité d'utilisation</strong> : Touch-friendly</li>\n";
echo "<li>🔤 <strong>Lisibilité parfaite</strong> : Texte 14px</li>\n";
echo "<li>🚀 <strong>UX optimale</strong> : Meilleur des deux mondes</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Boutons créneaux parfaitement optimisés :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>👁️ <strong>Visibilité parfaite</strong> : 48px de hauteur</li>\n";
echo "<li>📱 <strong>5 colonnes optimisées</strong> : Espace maximisé</li>\n";
echo "<li>🔤 <strong>Texte lisible</strong> : 14px parfaitement visible</li>\n";
echo "<li>⚪ <strong>Palette neutre</strong> : Blanc/Gris/Noir pure</li>\n";
echo "<li>🎯 <strong>Touch-friendly</strong> : Facilité d'utilisation mobile</li>\n";
echo "<li>🚀 <strong>UX excellente</strong> : Équilibre parfait</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>👁️ Boutons créneaux parfaitement visibles et utilisables ! 🎯</p>\n";
?>
