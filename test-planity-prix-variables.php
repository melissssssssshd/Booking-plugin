<?php
/**
 * Test du style Planity mobile avec gestion des prix variables
 * Interface avec affichage correct des prix fixes, variables et sur demande
 */

echo "<h1>📱 Style Planity Mobile - Gestion des Prix Variables CORRIGÉE</h1>\n";

echo "<h2>🚨 Problème des prix variables résolu</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Problème précédent :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Prix \"0.00 DA\"</strong> - Affiché au lieu de \"Prix variable\"</li>\n";
echo "<li>❌ <strong>Logique incorrecte</strong> - Ne détecte pas les prix variables</li>\n";
echo "<li>❌ <strong>Affichage confus</strong> - \"0.00 DA\" n'est pas informatif</li>\n";
echo "<li>❌ <strong>Pas de distinction</strong> - Entre prix fixe et variable</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Gestion intelligente des prix</h2>\n";

echo "<h3>1. ✅ Logique de prix améliorée</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Détection intelligente des prix :</strong><br>\n";

// Simulation de l'accordéon mobile avec différents types de prix
echo "<div style='max-width:400px;margin:20px auto;padding:0;background:#f8f9fa;border-radius:0;'>\n";
echo "<h3 style='font-size:1.1rem;font-weight:600;color:#374151;margin:0 0 0.8rem 0;padding:0 1rem;'>Choix de la prestation</h3>\n";

// Accordéon avec différents types de prix
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:0;margin-bottom:0.5rem;overflow:hidden;width:100%;box-sizing:border-box;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:0.8rem 1rem;cursor:pointer;background:#f1f5f9;'>\n";
echo "<span style='font-size:0.95rem;font-weight:500;color:#374151;'>Soins lissants</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;'>\n";

// Services avec différents types de prix
$services = [
    ['name' => 'Protéine', 'price' => '0.00', 'duration' => '300', 'type' => 'variable'],
    ['name' => 'Botox', 'price' => '0.00', 'duration' => '300', 'type' => 'variable'],
    ['name' => 'Kératine', 'price' => '0.00', 'duration' => '360', 'type' => 'variable'],
    ['name' => 'Coupe classique', 'price' => '1500', 'duration' => '30', 'type' => 'fixe'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 3 ? 'border-bottom:1px solid #f3f4f6;' : '';
    
    // Formater le prix selon le type
    if ($service['type'] === 'variable' || ($service['price'] && floatval($service['price']) <= 0)) {
        $formattedPrice = 'Prix variable';
    } elseif ($service['price'] && floatval($service['price']) > 0) {
        $formattedPrice = $service['price'] . ' DA';
    } else {
        $formattedPrice = 'Prix sur demande';
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
echo "<li>💰 <strong>Prix = 0 ou 0.00</strong> → \"Prix variable\"</li>\n";
echo "<li>💰 <strong>Prix > 0</strong> → \"1500 DA\"</li>\n";
echo "<li>💰 <strong>Pas de prix</strong> → \"Prix sur demande\"</li>\n";
echo "<li>🎯 <strong>Affichage clair</strong> : Plus de confusion</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Types de prix supportés</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Gestion complète des prix :</strong><br>\n";
echo "<ul>\n";
echo "<li>💰 <strong>Prix fixe</strong> : \"1500 DA\" (prix > 0)</li>\n";
echo "<li>🔄 <strong>Prix variable</strong> : \"Prix variable\" (prix = 0 ou 0.00)</li>\n";
echo "<li>📞 <strong>Prix sur demande</strong> : \"Prix sur demande\" (pas de prix)</li>\n";
echo "<li>📊 <strong>Fourchette de prix</strong> : \"1000-2000 DA\" (si disponible)</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Comparaison avant/après</h2>\n";

echo "<h3>Avant - Affichage incorrect</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:0;'>\n";
echo "<div style='padding:0.8rem 1rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>Protéine</h5>\n";
echo "<p style='font-size:0.8rem;margin:0;color:#f44336;'>0.00 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>5h</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;text-align:center;'>❌ \"0.00 DA\" - Confus et non informatif</p>\n";
echo "</div>\n";

echo "<h3>Après - Affichage correct</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:0;'>\n";
echo "<div style='padding:0.8rem 1rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>Protéine</h5>\n";
echo "<p style='font-size:0.8rem;margin:0;color:#4caf50;'>Prix variable</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>5h</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;text-align:center;'>✅ \"Prix variable\" - Clair et informatif</p>\n";
echo "</div>\n";

echo "<h2>📱 Logique de détection des prix</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Valeur prix</th><th style='border:1px solid #ddd;padding:8px;'>Condition</th><th style='border:1px solid #ddd;padding:8px;'>Affichage</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>\"1500\"</td><td style='border:1px solid #ddd;padding:8px;'>parseFloat(price) > 0</td><td style='border:1px solid #ddd;padding:8px;'>\"1500 DA\"</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>\"0\"</td><td style='border:1px solid #ddd;padding:8px;'>parseFloat(price) <= 0</td><td style='border:1px solid #ddd;padding:8px;'>\"Prix variable\"</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>\"0.00\"</td><td style='border:1px solid #ddd;padding:8px;'>parseFloat(price) <= 0</td><td style='border:1px solid #ddd;padding:8px;'>\"Prix variable\"</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>null/undefined</td><td style='border:1px solid #ddd;padding:8px;'>!price</td><td style='border:1px solid #ddd;padding:8px;'>\"Prix sur demande\"</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>\"1000-2000\"</td><td style='border:1px solid #ddd;padding:8px;'>price_range existe</td><td style='border:1px solid #ddd;padding:8px;'>\"1000-2000 DA\"</td></tr>\n";
echo "</table>\n";

echo "<h2>📝 Code JavaScript amélioré</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Nouvelle logique de formatage :</h3>\n";
echo "<pre style='background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;'>\n";
echo "// Formater le prix\n";
echo "let formattedPrice = \"Prix sur demande\";\n";
echo "if (service.price && parseFloat(service.price) > 0) {\n";
echo "  formattedPrice = `\${service.price} DA`;\n";
echo "} else if (service.price_range) {\n";
echo "  formattedPrice = `\${service.price_range} DA`;\n";
echo "} else if (service.variable_price) {\n";
echo "  formattedPrice = \"Prix variable\";\n";
echo "} else if (service.price && parseFloat(service.price) <= 0) {\n";
echo "  formattedPrice = \"Prix variable\";\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🧪 Test des prix variables</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Tester sur <strong>mobile</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Ouvrir la catégorie <strong>\"Soins lissants\"</strong></li>\n";
echo "<li>✅ Vérifier l'affichage des prix :</li>\n";
echo "<ul>\n";
echo "<li>💰 <strong>Protéine</strong> : \"Prix variable\" (au lieu de \"0.00 DA\")</li>\n";
echo "<li>💰 <strong>Botox</strong> : \"Prix variable\" (au lieu de \"0.00 DA\")</li>\n";
echo "<li>💰 <strong>Kératine</strong> : \"Prix variable\" (au lieu de \"0.00 DA\")</li>\n";
echo "</ul>\n";
echo "<li>✅ Tester d'autres catégories avec prix fixes</li>\n";
echo "<li>✅ Vérifier la <strong>cohérence</strong> de l'affichage</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Gestion parfaite des prix variables :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>💰 <strong>Prix fixes</strong> : \"1500 DA\" (clair et précis)</li>\n";
echo "<li>🔄 <strong>Prix variables</strong> : \"Prix variable\" (informatif)</li>\n";
echo "<li>📞 <strong>Prix sur demande</strong> : \"Prix sur demande\" (explicite)</li>\n";
echo "<li>📊 <strong>Fourchettes</strong> : \"1000-2000 DA\" (si disponible)</li>\n";
echo "<li>🎯 <strong>Plus de confusion</strong> : Fini les \"0.00 DA\"</li>\n";
echo "<li>⚡ <strong>UX claire</strong> : Utilisateur bien informé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📋 Cas d'usage couverts</h2>\n";

echo "<div style='background:#f0f8ff;padding:15px;border-left:4px solid #0066cc;'>\n";
echo "<h3>Types de prestations :</h3>\n";
echo "<ul>\n";
echo "<li>🔧 <strong>Services techniques</strong> : Prix variables selon complexité</li>\n";
echo "<li>💇 <strong>Coupes classiques</strong> : Prix fixes</li>\n";
echo "<li>🎨 <strong>Colorations</strong> : Prix variables selon longueur</li>\n";
echo "<li>💆 <strong>Soins spéciaux</strong> : Prix sur demande</li>\n";
echo "<li>📦 <strong>Forfaits</strong> : Fourchettes de prix</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>💰 Gestion intelligente des prix variables parfaite ! 🎯</p>\n";
?>
