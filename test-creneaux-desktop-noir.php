<?php
/**
 * Test créneaux desktop avec couleur noire
 * Amélioration de la lisibilité sur desktop
 */

echo "<h1>🖥️ Test Créneaux Desktop - Couleur Noire</h1>\n";

echo "<h2>🎯 Amélioration lisibilité desktop</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Corrections apportées :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Couleur noire</strong> : #111827 au lieu de gris clair</li>\n";
echo "<li>✅ <strong>Bordures grises</strong> : #e5e7eb au lieu de beige</li>\n";
echo "<li>✅ <strong>Fond blanc pur</strong> : #ffffff</li>\n";
echo "<li>✅ <strong>Hover amélioré</strong> : #374151 gris foncé</li>\n";
echo "<li>✅ <strong>Spécifique desktop</strong> : @media (min-width: 769px)</li>\n";
echo "<li>✅ <strong>Lisibilité parfaite</strong> : Contraste optimal</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🔍 Comparaison avant/après</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Aspect</th><th style='border:1px solid #ddd;padding:8px;'>Avant (Gris clair)</th><th style='border:1px solid #ddd;padding:8px;'>Après (Noir)</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Couleur texte</td><td style='border:1px solid #ddd;padding:8px;'>#a48d78 (brun gris)</td><td style='border:1px solid #ddd;padding:8px;'>#111827 (noir)</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Lisibilité</td><td style='border:1px solid #ddd;padding:8px;'>Difficile à lire</td><td style='border:1px solid #ddd;padding:8px;'>Parfaitement lisible</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Bordures</td><td style='border:1px solid #ddd;padding:8px;'>#e9aebc (beige rosé)</td><td style='border:1px solid #ddd;padding:8px;'>#e5e7eb (gris neutre)</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Hover</td><td style='border:1px solid #ddd;padding:8px;'>#a48d78 (même couleur)</td><td style='border:1px solid #ddd;padding:8px;'>#374151 (gris foncé)</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Contraste</td><td style='border:1px solid #ddd;padding:8px;'>Faible</td><td style='border:1px solid #ddd;padding:8px;'>Optimal</td></tr>\n";
echo "</table>\n";

echo "<h2>📝 CSS desktop spécifique</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Styles desktop avec couleur noire :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Forçage couleur noire desktop */\n";
echo "@media (min-width: 769px) {\n";
echo "  .slots-col .slot-btn,\n";
echo "  #slots-list .slot-btn,\n";
echo "  .slots-grid .slot-btn {\n";
echo "    color: #111827 !important; /* Noir */\n";
echo "    border-color: #e5e7eb !important; /* Gris clair */\n";
echo "    background: #ffffff !important; /* Blanc pur */\n";
echo "  }\n\n";
echo "  /* Hover desktop */\n";
echo "  .slots-col .slot-btn:hover {\n";
echo "    color: #374151 !important; /* Gris foncé */\n";
echo "    background: #f3f4f6 !important; /* Gris très clair */\n";
echo "    border-color: #d1d5db !important; /* Gris moyen */\n";
echo "  }\n";
echo "}\n\n";
echo "/* Styles généraux corrigés */\n";
echo ".slot-btn {\n";
echo "  color: #111827; /* Noir au lieu de #a48d78 */\n";
echo "  border: 1.5px solid #e5e7eb; /* Gris au lieu de beige */\n";
echo "  background: #fff;\n";
echo "  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🖥️ Simulation desktop avec couleur noire</h2>\n";

echo "<div style='max-width:800px;margin:20px auto;padding:20px;background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);'>\n";
echo "<h3 style='font-size:1.2rem;font-weight:600;color:#111827;margin:0 0 1rem 0;'>CRÉNEAUX DISPONIBLES</h3>\n";

echo "<div style='display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:12px;'>\n";

// Simulation desktop avec couleur noire
$creneaux = [
    "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
    "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", 
    "15:00", "15:30", "16:00", "16:30", "17:00", "17:30"
];

foreach ($creneaux as $index => $creneau) {
    $isSelected = $index === 7; // Simuler 12:30 sélectionné
    
    if ($isSelected) {
        $style = "background:#111827;color:white;border:1.5px solid #111827;cursor:not-allowed;";
        $onclick = "";
    } else {
        $style = "background:#ffffff;color:#111827;border:1.5px solid #e5e7eb;cursor:pointer;";
        $onclick = "onclick='alert(\"✅ Créneau sélectionné !\\n\\nHeure: {$creneau}\\nCouleur: Noir #111827\\nVersion: Desktop\\n\\n→ Lisibilité parfaite !\")' ";
        $onclick .= "onmouseover='this.style.background=\"#f3f4f6\";this.style.color=\"#374151\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"0 2px 8px rgba(0,0,0,0.1)\";' ";
        $onclick .= "onmouseout='this.style.background=\"#ffffff\";this.style.color=\"#111827\";this.style.borderColor=\"#e5e7eb\";this.style.boxShadow=\"0 1px 6px rgba(0,0,0,0.05)\";'";
    }
    
    echo "<button style='width:100%;min-height:40px;padding:0.4em 0.6em;border-radius:0.8em;font-weight:500;font-size:0.9em;box-shadow:0 1px 6px rgba(0,0,0,0.05);transition:all 0.2s;display:flex;align-items:center;justify-content:center;{$style}' {$onclick}>";
    echo $creneau;
    echo "</button>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez les créneaux desktop avec couleur noire</em></p>\n";

echo "<h2>🧪 Test de la lisibilité</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page de réservation</li>\n";
echo "<li>Utiliser un <strong>écran desktop</strong> (largeur > 768px)</li>\n";
echo "<li>Naviguer jusqu'à l'étape <strong>Date & Heure</strong></li>\n";
echo "<li>Sélectionner une date disponible</li>\n";
echo "<li>Observer les créneaux disponibles :</li>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Couleur noire</strong> : #111827 parfaitement lisible</li>\n";
echo "<li>✅ <strong>Bordures grises</strong> : #e5e7eb neutres</li>\n";
echo "<li>✅ <strong>Fond blanc</strong> : #ffffff pur</li>\n";
echo "<li>✅ <strong>Hover gris foncé</strong> : #374151 visible</li>\n";
echo "<li>✅ <strong>Contraste optimal</strong> : Lisibilité parfaite</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>📱 Responsive maintenu</h2>\n";

echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h3>Comportement responsive :</h3>\n";
echo "<ul>\n";
echo "<li>🖥️ <strong>Desktop (>768px)</strong> : Couleur noire forcée</li>\n";
echo "<li>📱 <strong>Mobile (≤768px)</strong> : Styles mobile maintenus</li>\n";
echo "<li>🔄 <strong>Cohérence</strong> : Même palette gris/blanc/noir</li>\n";
echo "<li>⚡ <strong>Performance</strong> : Media queries optimisées</li>\n";
echo "<li>🎯 <strong>Spécificité</strong> : !important pour priorité</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Desktop avec couleur noire parfaite :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🖥️ <strong>Couleur noire</strong> : #111827 parfaitement lisible</li>\n";
echo "<li>🔘 <strong>Bordures grises</strong> : #e5e7eb neutres</li>\n";
echo "<li>⚪ <strong>Fond blanc pur</strong> : #ffffff</li>\n";
echo "<li>🔘 <strong>Hover gris foncé</strong> : #374151 visible</li>\n";
echo "<li>👁️ <strong>Contraste optimal</strong> : Lisibilité parfaite</li>\n";
echo "<li>📱 <strong>Responsive maintenu</strong> : Mobile inchangé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>✨ Avantages de la couleur noire</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>Bénéfices pour l'utilisateur :</h3>\n";
echo "<ul>\n";
echo "<li>👁️ <strong>Lisibilité maximale</strong> : Contraste parfait</li>\n";
echo "<li>♿ <strong>Accessibilité</strong> : Conforme WCAG</li>\n";
echo "<li>🎯 <strong>Clarté</strong> : Heures parfaitement visibles</li>\n";
echo "<li>⚡ <strong>Rapidité</strong> : Lecture instantanée</li>\n";
echo "<li>🎨 <strong>Cohérence</strong> : Palette unifiée</li>\n";
echo "<li>🚀 <strong>UX améliorée</strong> : Moins de fatigue visuelle</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Créneaux desktop avec couleur noire parfaite :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🖥️ <strong>Desktop optimisé</strong> : Couleur noire #111827</li>\n";
echo "<li>👁️ <strong>Lisibilité parfaite</strong> : Contraste optimal</li>\n";
echo "<li>🔘 <strong>Bordures neutres</strong> : Gris #e5e7eb</li>\n";
echo "<li>⚪ <strong>Fond blanc pur</strong> : #ffffff</li>\n";
echo "<li>🔘 <strong>Hover visible</strong> : Gris foncé #374151</li>\n";
echo "<li>📱 <strong>Responsive maintenu</strong> : Mobile inchangé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>🖥️ Créneaux desktop avec couleur noire parfaitement lisible ! 🎯</p>\n";
?>
