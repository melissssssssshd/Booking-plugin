<?php
/**
 * Test du style Planity mobile avec vrais prix et fourchettes
 * Interface avec affichage des prix réels comme dans Planity
 */

echo "<h1>📱 Style Planity Mobile - Vrais Prix avec Fourchettes</h1>\n";

echo "<h2>🚨 Affichage des vrais prix comme Planity</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Problème précédent :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>\"Prix variable\"</strong> - Pas informatif</li>\n";
echo "<li>❌ <strong>Pas de fourchettes</strong> - Utilisateur dans le flou</li>\n";
echo "<li>❌ <strong>Pas comme Planity</strong> - Style différent</li>\n";
echo "<li>❌ <strong>Manque de transparence</strong> - Prix cachés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Affichage des vrais prix Planity</h2>\n";

echo "<h3>1. ✅ Fourchettes de prix transparentes</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Comme dans Planity :</strong><br>\n";

// Simulation de l'accordéon mobile avec vrais prix
echo "<div style='max-width:400px;margin:20px auto;padding:0;background:#f8f9fa;border-radius:0;'>\n";
echo "<h3 style='font-size:1.1rem;font-weight:600;color:#374151;margin:0 0 0.8rem 0;padding:0 1rem;'>Choix de la prestation</h3>\n";

// Accordéon avec vrais prix
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:0;margin-bottom:0.5rem;overflow:hidden;width:100%;box-sizing:border-box;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:0.8rem 1rem;cursor:pointer;background:#f1f5f9;'>\n";
echo "<span style='font-size:0.95rem;font-weight:500;color:#374151;'>Coiffure</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;'>\n";

// Services avec vrais prix comme Planity
$services = [
    [
        'name' => 'BALAYAGE',
        'description' => 'Service professionnel',
        'min_price' => 12000,
        'max_price' => null,
        'duration' => 300,
        'type' => 'min_only'
    ],
    [
        'name' => 'COIFFURE FÊTE SANS BRUSHING',
        'description' => 'Service professionnel',
        'min_price' => 3000,
        'max_price' => 3500,
        'duration' => 60,
        'type' => 'range'
    ],
    [
        'name' => 'BRUSHING COURT',
        'description' => 'Service professionnel',
        'price' => 1500,
        'duration' => 45,
        'type' => 'fixe'
    ],
    [
        'name' => 'SHAMPOO',
        'description' => 'Service professionnel',
        'min_price' => 800,
        'max_price' => null,
        'duration' => 15,
        'type' => 'min_only'
    ],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 3 ? 'border-bottom:1px solid #f3f4f6;' : '';
    
    // Formater le prix selon le type comme dans Planity
    $formattedPrice = "Prix sur demande";
    
    if ($service['type'] === 'range' && isset($service['min_price']) && isset($service['max_price'])) {
        // Prix avec fourchette : "de X DA à Y DA"
        $formattedPrice = "de " . number_format($service['min_price'], 0, ',', ' ') . " DA à " . number_format($service['max_price'], 0, ',', ' ') . " DA";
    } elseif ($service['type'] === 'min_only' && isset($service['min_price'])) {
        // Prix minimum seulement : "à partir de X DA"
        $formattedPrice = "à partir de " . number_format($service['min_price'], 0, ',', ' ') . " DA";
    } elseif ($service['type'] === 'fixe' && isset($service['price'])) {
        // Prix fixe : "X DA"
        $formattedPrice = number_format($service['price'], 0, ',', ' ') . " DA";
    }
    
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
    if (isset($service['description'])) {
        echo "<p style='font-size:0.75rem;color:#6b7280;margin:0 0 0.3rem 0;'>{$service['description']}</p>\n";
    }
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
echo "<li>💰 <strong>Prix minimum</strong> → \"à partir de 12 000 DA\"</li>\n";
echo "<li>💰 <strong>Fourchette</strong> → \"de 3 000 DA à 3 500 DA\"</li>\n";
echo "<li>💰 <strong>Prix fixe</strong> → \"1 500 DA\"</li>\n";
echo "<li>🎯 <strong>Transparence totale</strong> → Client informé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Types de prix gérés</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Logique Planity authentique :</strong><br>\n";
echo "<ul>\n";
echo "<li>🔢 <strong>Prix fixe</strong> : \"1 500 DA\"</li>\n";
echo "<li>📊 <strong>Prix minimum</strong> : \"à partir de 12 000 DA\"</li>\n";
echo "<li>📈 <strong>Fourchette</strong> : \"de 3 000 DA à 3 500 DA\"</li>\n";
echo "<li>❓ <strong>Sur demande</strong> : \"Prix sur demande\" (si aucun prix)</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Comparaison avant/après</h2>\n";

echo "<h3>Avant - Prix cachés</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:8px;'>\n";
echo "<div style='padding:0.8rem 1rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>BALAYAGE</h5>\n";
echo "<p style='font-size:0.8rem;margin:0;color:#f44336;'>Prix variable</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>5h</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;text-align:center;'>❌ Prix caché - \"Prix variable\"</p>\n";
echo "</div>\n";

echo "<h3>Après - Prix transparent Planity</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:8px;'>\n";
echo "<div style='padding:0.8rem 1rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>BALAYAGE</h5>\n";
echo "<p style='font-size:0.75rem;color:#6b7280;margin:0 0 0.3rem 0;'>Service professionnel</p>\n";
echo "<p style='font-size:0.8rem;margin:0;color:#4caf50;'>à partir de 12 000 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>5h</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;text-align:center;'>✅ Prix transparent - \"à partir de 12 000 DA\"</p>\n";
echo "</div>\n";

echo "<h2>📱 Logique de formatage des prix</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Type</th><th style='border:1px solid #ddd;padding:8px;'>Données</th><th style='border:1px solid #ddd;padding:8px;'>Affichage</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Prix fixe</td><td style='border:1px solid #ddd;padding:8px;'>price: 1500</td><td style='border:1px solid #ddd;padding:8px;'>1 500 DA</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Prix minimum</td><td style='border:1px solid #ddd;padding:8px;'>min_price: 12000</td><td style='border:1px solid #ddd;padding:8px;'>à partir de 12 000 DA</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Fourchette</td><td style='border:1px solid #ddd;padding:8px;'>min: 3000, max: 3500</td><td style='border:1px solid #ddd;padding:8px;'>de 3 000 DA à 3 500 DA</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Sur demande</td><td style='border:1px solid #ddd;padding:8px;'>Aucun prix</td><td style='border:1px solid #ddd;padding:8px;'>Prix sur demande</td></tr>\n";
echo "</table>\n";

echo "<h2>📝 Code JavaScript amélioré</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Nouvelle logique Planity :</h3>\n";
echo "<pre style='background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;'>\n";
echo "// Formater le prix comme dans Planity\n";
echo "let formattedPrice = \"Prix sur demande\";\n\n";
echo "if (service.variable_price == 1) {\n";
echo "  // Prix variable avec min/max\n";
echo "  const min = Number(service.min_price);\n";
echo "  const max = Number(service.max_price);\n";
echo "  if (min > 0 && max > 0 && min !== max) {\n";
echo "    formattedPrice = `de \${min.toLocaleString()} DA à \${max.toLocaleString()} DA`;\n";
echo "  } else if (min > 0) {\n";
echo "    formattedPrice = `à partir de \${min.toLocaleString()} DA`;\n";
echo "  }\n";
echo "} else if (service.price && parseFloat(service.price) > 0) {\n";
echo "  // Prix fixe\n";
echo "  formattedPrice = `\${Number(service.price).toLocaleString()} DA`;\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🧪 Test des vrais prix</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Tester sur <strong>mobile</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Ouvrir une catégorie avec <strong>services à prix variables</strong></li>\n";
echo "<li>✅ Vérifier l'affichage des prix :</li>\n";
echo "<ul>\n";
echo "<li>💰 <strong>Prix minimum</strong> : \"à partir de 12 000 DA\"</li>\n";
echo "<li>💰 <strong>Fourchette</strong> : \"de 3 000 DA à 3 500 DA\"</li>\n";
echo "<li>💰 <strong>Prix fixe</strong> : \"1 500 DA\"</li>\n";
echo "<li>💰 <strong>Formatage</strong> : Espaces dans les milliers</li>\n";
echo "</ul>\n";
echo "<li>✅ Vérifier que les prix sont <strong>informatifs</strong></li>\n";
echo "<li>✅ Tester la <strong>sélection</strong> des services</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Affichage des vrais prix comme Planity :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>💰 <strong>Prix transparents</strong> : Vrais prix affichés</li>\n";
echo "<li>📊 <strong>Fourchettes claires</strong> : \"de X DA à Y DA\"</li>\n";
echo "<li>🔢 <strong>Prix minimum</strong> : \"à partir de X DA\"</li>\n";
echo "<li>📱 <strong>Style Planity</strong> : Exactement comme l'original</li>\n";
echo "<li>👤 <strong>Transparence totale</strong> : Client bien informé</li>\n";
echo "<li>✨ <strong>Interface professionnelle</strong> : Confiance renforcée</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📱 Vrais prix transparents style Planity mobile parfait ! 🎯</p>\n";
?>
