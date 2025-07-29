<?php
/**
 * Test du style exactement comme la deuxième photo
 * Gris clair lisible, pas de beige, compact
 */

echo "<h1>📸 Test Style Deuxième Photo - Gris Clair Lisible</h1>\n";

echo "<h2>🎯 Style exactement comme la deuxième photo</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Caractéristiques reproduites :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Fond gris clair</strong> : #f1f3f4 (comme Google)</li>\n";
echo "<li>✅ <strong>Texte noir lisible</strong> : #202124</li>\n";
echo "<li>✅ <strong>Pas de bordures</strong> : border: none</li>\n";
echo "<li>✅ <strong>Coins arrondis</strong> : border-radius: 8px</li>\n";
echo "<li>✅ <strong>3 colonnes mobile</strong> : Lisibilité optimale</li>\n";
echo "<li>✅ <strong>Sélection bleue</strong> : #1a73e8 (bleu Google)</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🚫 Problèmes résolus</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Fini les problèmes :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Plus de beige</strong> : Couleurs neutres uniquement</li>\n";
echo "<li>❌ <strong>Plus illisible</strong> : Contraste parfait</li>\n";
echo "<li>❌ <strong>Plus d'espace gaspillé</strong> : Compact et efficace</li>\n";
echo "<li>❌ <strong>Plus de bordures</strong> : Design épuré</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Palette de couleurs exacte</h2>\n";
echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Couleurs de la deuxième photo :</h3>\n";
echo "<ul>\n";
echo "<li>🔘 <strong>Fond normal</strong> : #f1f3f4 (gris clair Google)</li>\n";
echo "<li>⚫ <strong>Texte</strong> : #202124 (noir Google)</li>\n";
echo "<li>🔘 <strong>Hover</strong> : #e8eaed (gris plus foncé)</li>\n";
echo "<li>🔵 <strong>Sélectionné</strong> : #1a73e8 (bleu Google)</li>\n";
echo "<li>🤍 <strong>Texte sélectionné</strong> : white</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Code CSS de la deuxième photo</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Styles reproduits exactement :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Grille comme la deuxième photo */\n";
echo ".slots-grid-planity {\n";
echo "  display: grid;\n";
echo "  grid-template-columns: repeat(3, 1fr); /* 3 colonnes mobile */\n";
echo "  gap: 0.5rem; /* Espacement lisible */\n";
echo "  padding: 0.5rem;\n";
echo "}\n\n";
echo "/* Boutons gris clair lisibles */\n";
echo ".slot-btn-planity {\n";
echo "  padding: 12px 8px;\n";
echo "  min-height: 44px;\n";
echo "  border-radius: 8px;\n";
echo "  background: #f1f3f4; /* Gris clair Google */\n";
echo "  border: none; /* Pas de bordures */\n";
echo "  color: #202124; /* Noir Google lisible */\n";
echo "  font-size: 14px;\n";
echo "  font-weight: 500;\n";
echo "}\n\n";
echo "/* Hover subtil */\n";
echo ".slot-btn-planity:hover {\n";
echo "  background: #e8eaed; /* Gris plus foncé */\n";
echo "  transform: translateY(-1px);\n";
echo "}\n\n";
echo "/* Sélection bleue Google */\n";
echo ".slot-btn-planity[disabled] {\n";
echo "  background: #1a73e8; /* Bleu Google */\n";
echo "  color: white;\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>📱 Simulation exacte de la deuxième photo</h2>\n";

echo "<div style='max-width:400px;margin:20px auto;padding:0;background:white;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);'>\n";
echo "<h3 style='font-size:1rem;font-weight:600;color:#202124;margin:0 0 0.5rem 0;padding:1rem 0.5rem 0;'>CRÉNEAUX DISPONIBLES</h3>\n";

echo "<div style='padding:0.5rem;'>\n";
echo "<div style='display:grid;grid-template-columns:repeat(3,1fr);gap:0.5rem;'>\n";

// Simulation exacte de la deuxième photo
$creneaux = [
    "09:00", "09:30", "10:00",
    "10:30", "11:00", "11:30", 
    "12:00", "12:30", "13:00"
];

foreach ($creneaux as $index => $creneau) {
    $isSelected = $index === 1; // Simuler 09:30 sélectionné comme dans la photo
    
    if ($isSelected) {
        $style = "background:#1a73e8;color:white;cursor:not-allowed;";
        $onclick = "";
    } else {
        $style = "background:#f1f3f4;color:#202124;cursor:pointer;";
        $onclick = "onclick='alert(\"✅ Créneau sélectionné !\\n\\nHeure: {$creneau}\\nStyle: Exactement comme la deuxième photo\\n\\n→ Gris clair lisible !\")' ";
        $onclick .= "onmouseover='this.style.background=\"#e8eaed\";this.style.transform=\"translateY(-1px)\";this.style.boxShadow=\"0 2px 4px rgba(0,0,0,0.1)\";' ";
        $onclick .= "onmouseout='this.style.background=\"#f1f3f4\";this.style.transform=\"translateY(0)\";this.style.boxShadow=\"none\";'";
    }
    
    echo "<button style='display:flex;align-items:center;justify-content:center;padding:12px 8px;min-height:44px;border-radius:8px;border:none;font-size:14px;font-weight:500;line-height:1;transition:all 0.2s ease;{$style}' {$onclick}>";
    echo $creneau;
    echo "</button>\n";
}

echo "</div>\n";

// Ajouter le bouton "Voir plus" comme dans la photo
echo "<div style='text-align:center;margin-top:1rem;'>\n";
echo "<button style='background:none;border:none;color:#1a73e8;font-size:14px;font-weight:500;cursor:pointer;padding:8px;' onclick='alert(\"Voir plus de créneaux...\")'>Voir plus</button>\n";
echo "</div>\n";

echo "</div>\n";

echo "<div style='padding:1rem;background:#f8f9fa;text-align:center;border-top:1px solid #e5e7eb;'>\n";
echo "<button style='background:#6c757d;color:white;border:none;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:500;cursor:pointer;margin-right:10px;'>← Retour</button>\n";
echo "<button style='background:#1a73e8;color:white;border:none;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:500;cursor:pointer;'>Suivant →</button>\n";
echo "</div>\n";

echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez le style exactement comme la deuxième photo</em></p>\n";

echo "<h2>🔍 Comparaison avant/après</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Aspect</th><th style='border:1px solid #ddd;padding:8px;'>Première photo (Problème)</th><th style='border:1px solid #ddd;padding:8px;'>Deuxième photo (Solution)</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Couleur fond</td><td style='border:1px solid #ddd;padding:8px;'>Beige (#c4b39a)</td><td style='border:1px solid #ddd;padding:8px;'>Gris clair (#f1f3f4)</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Lisibilité</td><td style='border:1px solid #ddd;padding:8px;'>Difficile à lire</td><td style='border:1px solid #ddd;padding:8px;'>Parfaitement lisible</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Bordures</td><td style='border:1px solid #ddd;padding:8px;'>Bordures visibles</td><td style='border:1px solid #ddd;padding:8px;'>Pas de bordures</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Espace</td><td style='border:1px solid #ddd;padding:8px;'>Beaucoup gaspillé</td><td style='border:1px solid #ddd;padding:8px;'>Compact et efficace</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Sélection</td><td style='border:1px solid #ddd;padding:8px;'>Peu visible</td><td style='border:1px solid #ddd;padding:8px;'>Bleu Google visible</td></tr>\n";
echo "</table>\n";

echo "<h2>🧪 Test de l'affichage</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page de réservation</li>\n";
echo "<li>Naviguer jusqu'à l'étape <strong>Date & Heure</strong></li>\n";
echo "<li>Sélectionner une date disponible</li>\n";
echo "<li>Vérifier que l'affichage ressemble à la deuxième photo :</li>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Fond gris clair</strong> : #f1f3f4 lisible</li>\n";
echo "<li>✅ <strong>Texte noir</strong> : #202124 parfaitement lisible</li>\n";
echo "<li>✅ <strong>Pas de beige</strong> : Couleurs neutres uniquement</li>\n";
echo "<li>✅ <strong>3 colonnes</strong> : Lisibilité optimale</li>\n";
echo "<li>✅ <strong>Compact</strong> : Pas d'espace gaspillé</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Affichage exactement comme la deuxième photo :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🔘 <strong>Gris clair lisible</strong> : #f1f3f4 comme Google</li>\n";
echo "<li>⚫ <strong>Texte noir</strong> : #202124 parfaitement lisible</li>\n";
echo "<li>🚫 <strong>Pas de beige</strong> : Fini les couleurs illisibles</li>\n";
echo "<li>📱 <strong>3 colonnes mobile</strong> : Lisibilité optimale</li>\n";
echo "<li>🔵 <strong>Sélection bleue</strong> : #1a73e8 bien visible</li>\n";
echo "<li>⚡ <strong>Compact</strong> : Pas d'espace gaspillé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Style deuxième photo parfaitement reproduit :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🔘 <strong>Gris clair Google</strong> : #f1f3f4 parfaitement lisible</li>\n";
echo "<li>⚫ <strong>Texte noir</strong> : #202124 contraste parfait</li>\n";
echo "<li>🚫 <strong>Zéro beige</strong> : Couleurs neutres uniquement</li>\n";
echo "<li>📱 <strong>Lisibilité parfaite</strong> : 3 colonnes optimales</li>\n";
echo "<li>🔵 <strong>Sélection visible</strong> : Bleu Google #1a73e8</li>\n";
echo "<li>⚡ <strong>Compact efficace</strong> : Pas d'espace gaspillé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📸 Style deuxième photo parfaitement reproduit ! 🎯</p>\n";
?>
