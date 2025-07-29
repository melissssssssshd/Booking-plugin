<?php
/**
 * Test du style Planity mobile sans marges avec prix et durées formatés
 * Interface pleine largeur avec affichage optimisé des prix et durées
 */

echo "<h1>📱 Style Planity Mobile - Sans Marges + Prix/Durées Formatés</h1>\n";

echo "<h2>🚨 Améliorations finales appliquées</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Problèmes précédents :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Marges gauche/droite</strong> - Espace perdu sur les côtés</li>\n";
echo "<li>❌ <strong>Prix mal formaté</strong> - \"à partir de\" superflu</li>\n";
echo "<li>❌ <strong>Durée sans unité</strong> - Juste des chiffres</li>\n";
echo "<li>❌ <strong>Pas d'heures</strong> - Seulement minutes</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Interface pleine largeur avec formatage optimal</h2>\n";

echo "<h3>1. ✅ Suppression totale des marges</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Pleine largeur :</strong><br>\n";

// Simulation de l'accordéon mobile sans marges
echo "<div style='max-width:400px;margin:20px auto;padding:0;background:#f8f9fa;border-radius:0;'>\n";
echo "<h3 style='font-size:1.1rem;font-weight:600;color:#374151;margin:0 0 0.8rem 0;padding:0 1rem;'>Choix de la prestation</h3>\n";

// Accordéon sans marges
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:0;margin-bottom:0.5rem;overflow:hidden;width:100%;box-sizing:border-box;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:0.8rem 1rem;cursor:pointer;background:#f1f5f9;'>\n";
echo "<span style='font-size:0.95rem;font-weight:500;color:#374151;'>Coiffure</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;'>\n";

// Services avec prix et durées formatés
$services = [
    ['name' => 'Patine', 'price' => '0', 'duration' => '60'],
    ['name' => 'Balayage', 'price' => '2500', 'duration' => '300'],
    ['name' => 'Coiffure fête sans brushing', 'price' => '1800', 'duration' => '45'],
    ['name' => 'Brushing Polycos', 'price' => '1550', 'duration' => '120'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 3 ? 'border-bottom:1px solid #f3f4f6;' : '';
    
    // Formater le prix
    $formattedPrice = $service['price'] == '0' ? 'Prix sur demande' : $service['price'] . ' DA';
    
    // Formater la durée
    $duration = intval($service['duration']);
    if ($duration >= 60) {
        $hours = floor($duration / 60);
        $minutes = $duration % 60;
        if ($minutes === 0) {
            $formattedDuration = $hours . 'h';
        } else {
            $formattedDuration = $hours . 'h' . $minutes . 'min';
        }
    } else {
        $formattedDuration = $duration . 'min';
    }
    
    echo "<div style='padding:0.8rem 1rem;{$borderBottom}'>\n";
    
    // Informations principales du service
    echo "<div style='margin-bottom:0.8rem;'>\n";
    echo "<h5 style='font-size:0.9rem;font-weight:600;color:#1f2937;margin:0 0 0.4rem 0;line-height:1.4;'>{$service['name']}</h5>\n";
    echo "<p style='font-size:0.8rem;color:#374151;margin:0;font-weight:500;'>{$formattedPrice}</p>\n";
    echo "</div>\n";
    
    // Durée et bouton
    echo "<div style='display:flex;justify-content:space-between;align-items:center;'>\n";
    echo "<span style='font-size:0.8rem;color:#6b7280;font-weight:500;'>{$formattedDuration}</span>\n";
    echo "<button style='background:#1f2937;color:white;border:none;padding:0.5rem 0.8rem;border-radius:6px;font-size:0.8rem;font-weight:500;cursor:pointer;min-width:65px;'>Choisir</button>\n";
    echo "</div>\n";
    
    echo "</div>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "</div>\n";

echo "<ul>\n";
echo "<li>📏 <strong>Marges supprimées</strong> : padding: 0 sur le container</li>\n";
echo "<li>💰 <strong>Prix optimisé</strong> : \"1550 DA\" ou \"Prix sur demande\"</li>\n";
echo "<li>⏱️ <strong>Durées formatées</strong> : \"45min\", \"2h\", \"5h20min\"</li>\n";
echo "<li>📱 <strong>Pleine largeur</strong> : Utilisation maximale de l'écran</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Formatage intelligent des prix et durées</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Logique de formatage :</strong><br>\n";
echo "<ul>\n";
echo "<li>💰 <strong>Prix = 0</strong> → \"Prix sur demande\"</li>\n";
echo "<li>💰 <strong>Prix > 0</strong> → \"1550 DA\" (sans \"à partir de\")</li>\n";
echo "<li>⏱️ <strong>< 60 min</strong> → \"45min\"</li>\n";
echo "<li>⏱️ <strong>= 60 min</strong> → \"1h\"</li>\n";
echo "<li>⏱️ <strong>> 60 min</strong> → \"2h30min\" ou \"5h\"</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Comparaison avant/après</h2>\n";

echo "<h3>Avant - Avec marges et formatage basique</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:#f8f9fa;padding:10px;border-radius:8px;'>\n";
echo "<h4 style='margin:0 0 0.8rem 0.5rem;font-size:1.1rem;'>Choix de la prestation</h4>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:8px;margin:0 0.5rem;'>\n";
echo "<div style='padding:0.8rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>Balayage</h5>\n";
echo "<p style='font-size:0.8rem;margin:0;'>à partir de 2500 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>300</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;text-align:center;'>❌ Marges + formatage basique</p>\n";
echo "</div>\n";

echo "<h3>Après - Sans marges + formatage optimal</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:#f8f9fa;padding:0;border-radius:0;'>\n";
echo "<h4 style='margin:0 0 0.8rem 0;font-size:1.1rem;padding:0 1rem;'>Choix de la prestation</h4>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:0;'>\n";
echo "<div style='padding:0.8rem 1rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>Balayage</h5>\n";
echo "<p style='font-size:0.8rem;margin:0;'>2500 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>5h</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;text-align:center;'>✅ Pleine largeur + formatage optimal</p>\n";
echo "</div>\n";

echo "<h2>📱 Exemples de formatage des durées</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Durée (min)</th><th style='border:1px solid #ddd;padding:8px;'>Affichage</th><th style='border:1px solid #ddd;padding:8px;'>Exemple</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>30</td><td style='border:1px solid #ddd;padding:8px;'>30min</td><td style='border:1px solid #ddd;padding:8px;'>Coupe rapide</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>45</td><td style='border:1px solid #ddd;padding:8px;'>45min</td><td style='border:1px solid #ddd;padding:8px;'>Brushing</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>60</td><td style='border:1px solid #ddd;padding:8px;'>1h</td><td style='border:1px solid #ddd;padding:8px;'>Patine</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>90</td><td style='border:1px solid #ddd;padding:8px;'>1h30min</td><td style='border:1px solid #ddd;padding:8px;'>Couleur</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>120</td><td style='border:1px solid #ddd;padding:8px;'>2h</td><td style='border:1px solid #ddd;padding:8px;'>Brushing Polycos</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>300</td><td style='border:1px solid #ddd;padding:8px;'>5h</td><td style='border:1px solid #ddd;padding:8px;'>Balayage complet</td></tr>\n";
echo "</table>\n";

echo "<h2>📝 Code JavaScript de formatage</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Logique de formatage appliquée :</h3>\n";
echo "<pre style='background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;'>\n";
echo "// Formater le prix\n";
echo "const formattedPrice = service.price ? \n";
echo "  `\${service.price} DA` : \"Prix sur demande\";\n\n";
echo "// Formater la durée avec unités appropriées\n";
echo "let formattedDuration = service.duration || \"30\";\n";
echo "if (formattedDuration) {\n";
echo "  const durationNum = parseInt(formattedDuration);\n";
echo "  if (durationNum >= 60) {\n";
echo "    const hours = Math.floor(durationNum / 60);\n";
echo "    const minutes = durationNum % 60;\n";
echo "    if (minutes === 0) {\n";
echo "      formattedDuration = `\${hours}h`;\n";
echo "    } else {\n";
echo "      formattedDuration = `\${hours}h\${minutes}min`;\n";
echo "    }\n";
echo "  } else {\n";
echo "    formattedDuration = `\${durationNum}min`;\n";
echo "  }\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🧪 Test de l'interface finale</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Tester sur <strong>mobile</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Vérifier l'<strong>absence totale de marges</strong> sur les côtés</li>\n";
echo "<li>✅ Vérifier la <strong>pleine largeur</strong> de l'accordéon</li>\n";
echo "<li>✅ Ouvrir un accordéon et vérifier :</li>\n";
echo "<ul>\n";
echo "<li>💰 <strong>Prix formatés</strong> : \"1550 DA\" ou \"Prix sur demande\"</li>\n";
echo "<li>⏱️ <strong>Durées avec unités</strong> : \"45min\", \"2h\", \"1h30min\"</li>\n";
echo "<li>📱 <strong>Interface pleine largeur</strong></li>\n";
echo "</ul>\n";
echo "<li>✅ Tester différents services avec durées variées</li>\n";
echo "<li>✅ Vérifier la <strong>lisibilité optimale</strong></li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Interface Planity mobile parfaite :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📏 <strong>Pleine largeur</strong> : Aucune marge gauche/droite</li>\n";
echo "<li>💰 <strong>Prix clairs</strong> : \"1550 DA\" ou \"Prix sur demande\"</li>\n";
echo "<li>⏱️ <strong>Durées formatées</strong> : \"45min\", \"2h\", \"1h30min\"</li>\n";
echo "<li>📱 <strong>Utilisation maximale</strong> : Chaque pixel compte</li>\n";
echo "<li>🎯 <strong>Style Planity authentique</strong> : Interface professionnelle</li>\n";
echo "<li>⚡ <strong>UX optimale</strong> : Lisibilité et efficacité parfaites</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📱 Interface Planity mobile pleine largeur avec formatage optimal ! 🎯</p>\n";
?>
