<?php
/**
 * Test de l'affichage ultra-compact avec palette neutre
 * Gris/Blanc/Noir - Maximum de créneaux visibles
 */

echo "<h1>⚡ Test Ultra-Compact - Palette Neutre Gris/Blanc/Noir</h1>\n";

echo "<h2>🎯 Optimisation maximale</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Améliorations ultra-compactes :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>4 colonnes mobile</strong> : Maximum de créneaux visibles</li>\n";
echo "<li>✅ <strong>Hauteur réduite</strong> : 32px au lieu de 48px</li>\n";
echo "<li>✅ <strong>Gap minimal</strong> : 0.2rem entre créneaux</li>\n";
echo "<li>✅ <strong>Palette neutre</strong> : Gris/Blanc/Noir uniquement</li>\n";
echo "<li>✅ <strong>16+ créneaux visibles</strong> : Au lieu de 6-9</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Palette de couleurs neutre</h2>\n";
echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Couleurs utilisées :</h3>\n";
echo "<ul>\n";
echo "<li>🤍 <strong>Fond normal</strong> : #ffffff (blanc pur)</li>\n";
echo "<li>🔘 <strong>Bordure</strong> : #d1d5db (gris clair)</li>\n";
echo "<li>⚫ <strong>Texte</strong> : #374151 (gris foncé)</li>\n";
echo "<li>🔘 <strong>Hover fond</strong> : #f9fafb (gris très clair)</li>\n";
echo "<li>⚫ <strong>Sélectionné</strong> : #111827 (noir/gris très foncé)</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Code CSS ultra-compact</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Grille et boutons optimisés :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Grille ultra-compacte */\n";
echo ".slots-grid-planity {\n";
echo "  display: grid;\n";
echo "  grid-template-columns: repeat(4, 1fr); /* 4 colonnes mobile */\n";
echo "  gap: 0.2rem; /* Gap minimal */\n";
echo "  padding: 0.2rem;\n";
echo "}\n\n";
echo "/* Boutons ultra-compacts */\n";
echo ".slot-btn-planity {\n";
echo "  padding: 6px 4px;\n";
echo "  min-height: 32px; /* Très compact */\n";
echo "  border-radius: 4px;\n";
echo "  background: #ffffff; /* Blanc pur */\n";
echo "  border: 1px solid #d1d5db; /* Gris clair */\n";
echo "  color: #374151; /* Gris foncé */\n";
echo "  font-size: 12px;\n";
echo "}\n\n";
echo "/* Hover neutre */\n";
echo ".slot-btn-planity:hover {\n";
echo "  background: #f9fafb; /* Gris très clair */\n";
echo "  border-color: #9ca3af;\n";
echo "}\n\n";
echo "/* Sélection noire */\n";
echo ".slot-btn-planity[disabled] {\n";
echo "  background: #111827; /* Noir/gris très foncé */\n";
echo "  color: white;\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🔍 Comparaison des optimisations</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Aspect</th><th style='border:1px solid #ddd;padding:8px;'>Avant</th><th style='border:1px solid #ddd;padding:8px;'>Ultra-Compact</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Colonnes mobile</td><td style='border:1px solid #ddd;padding:8px;'>3 colonnes</td><td style='border:1px solid #ddd;padding:8px;'>4 colonnes</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Hauteur bouton</td><td style='border:1px solid #ddd;padding:8px;'>48px</td><td style='border:1px solid #ddd;padding:8px;'>32px</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Gap</td><td style='border:1px solid #ddd;padding:8px;'>0.4rem</td><td style='border:1px solid #ddd;padding:8px;'>0.2rem</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Créneaux visibles</td><td style='border:1px solid #ddd;padding:8px;'>6-9 créneaux</td><td style='border:1px solid #ddd;padding:8px;'>16+ créneaux</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Couleurs</td><td style='border:1px solid #ddd;padding:8px;'>Colorées</td><td style='border:1px solid #ddd;padding:8px;'>Gris/Blanc/Noir</td></tr>\n";
echo "</table>\n";

echo "<h2>📱 Simulation ultra-compacte</h2>\n";

echo "<div style='max-width:400px;margin:20px auto;padding:0;background:white;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);'>\n";
echo "<h3 style='font-size:1rem;font-weight:600;color:#374151;margin:0 0 0.25rem 0;padding:0.75rem 0.5rem 0;'>CRÉNEAUX DISPONIBLES</h3>\n";

echo "<div style='padding:0.2rem;'>\n";
echo "<div style='display:grid;grid-template-columns:repeat(4,1fr);gap:0.2rem;max-height:300px;overflow-y:auto;'>\n";

// Simulation de créneaux ultra-compacts
$creneaux = [
    "09:00", "09:30", "10:00", "10:30",
    "11:00", "11:30", "12:00", "12:30", 
    "13:00", "13:30", "14:00", "14:30",
    "15:00", "15:30", "16:00", "16:30",
    "17:00", "17:30", "18:00", "18:30"
];

foreach ($creneaux as $index => $creneau) {
    $isSelected = $index === 6; // Simuler une sélection
    $isDisabled = $index % 7 === 0; // Simuler quelques créneaux indisponibles
    
    if ($isSelected) {
        $style = "background:#111827;color:white;border:1px solid #111827;cursor:not-allowed;";
        $onclick = "";
    } elseif ($isDisabled) {
        $style = "background:#ffffff;color:#9ca3af;border:1px solid #d1d5db;cursor:not-allowed;opacity:0.5;";
        $onclick = "";
    } else {
        $style = "background:#ffffff;color:#374151;border:1px solid #d1d5db;cursor:pointer;";
        $onclick = "onclick='alert(\"✅ Créneau sélectionné !\\n\\nHeure: {$creneau}\\nStyle: Ultra-compact neutre\\n\\n→ 16+ créneaux visibles !\")' ";
        $onclick .= "onmouseover='this.style.background=\"#f9fafb\";this.style.borderColor=\"#9ca3af\";this.style.boxShadow=\"0 1px 2px rgba(0,0,0,0.1)\";' ";
        $onclick .= "onmouseout='this.style.background=\"#ffffff\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"none\";'";
    }
    
    echo "<button style='display:flex;align-items:center;justify-content:center;padding:6px 4px;min-height:32px;border-radius:4px;font-size:12px;font-weight:500;line-height:1;transition:all 0.15s ease;{$style}' {$onclick}>";
    echo $creneau;
    echo "</button>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "<div style='padding:0.75rem;background:#f8f9fa;text-align:center;border-top:1px solid #e5e7eb;'>\n";
echo "<button style='background:#6c757d;color:white;border:none;padding:10px 20px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;margin-right:8px;'>← Retour</button>\n";
echo "<button style='background:#111827;color:white;border:none;padding:10px 20px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;'>Suivant →</button>\n";
echo "</div>\n";

echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez l'affichage ultra-compact avec 16+ créneaux visibles</em></p>\n";

echo "<h2>🧪 Test de l'optimisation</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page de réservation</li>\n";
echo "<li>Naviguer jusqu'à l'étape <strong>Date & Heure</strong></li>\n";
echo "<li>Sélectionner une date disponible</li>\n";
echo "<li>Vérifier l'affichage ultra-compact :</li>\n";
echo "<ul>\n";
echo "<li>✅ <strong>4 colonnes mobile</strong> : Maximum de créneaux</li>\n";
echo "<li>✅ <strong>Palette neutre</strong> : Gris/Blanc/Noir uniquement</li>\n";
echo "<li>✅ <strong>16+ créneaux visibles</strong> : Optimisation maximale</li>\n";
echo "<li>✅ <strong>Hauteur 32px</strong> : Ultra-compact</li>\n";
echo "<li>✅ <strong>Gap minimal</strong> : 0.2rem entre créneaux</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Affichage ultra-compact optimisé :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📱 <strong>4 colonnes mobile</strong> : Utilisation maximale de l'espace</li>\n";
echo "<li>💻 <strong>Desktop adaptatif</strong> : Encore plus de colonnes</li>\n";
echo "<li>📏 <strong>Hauteur 32px</strong> : Ultra-compact</li>\n";
echo "<li>🎨 <strong>Palette neutre</strong> : Gris/Blanc/Noir professionnel</li>\n";
echo "<li>⚡ <strong>16+ créneaux visibles</strong> : Optimisation maximale</li>\n";
echo "<li>🚀 <strong>UX parfaite</strong> : Navigation ultra-fluide</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Créneaux ultra-compacts parfaitement optimisés :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>⚡ <strong>16+ créneaux visibles</strong> : Optimisation maximale</li>\n";
echo "<li>📱 <strong>4 colonnes mobile</strong> : Utilisation parfaite de l'espace</li>\n";
echo "<li>🎨 <strong>Palette neutre</strong> : Gris/Blanc/Noir professionnel</li>\n";
echo "<li>📏 <strong>Ultra-compact</strong> : 32px de hauteur</li>\n";
echo "<li>🔘 <strong>Gap minimal</strong> : 0.2rem entre créneaux</li>\n";
echo "<li>🚀 <strong>UX optimale</strong> : Zéro espace gaspillé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>⚡ Affichage ultra-compact avec palette neutre parfaitement optimisé ! 🎯</p>\n";
?>
