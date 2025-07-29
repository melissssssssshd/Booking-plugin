<?php
/**
 * Test du style Planity mobile avec accordéon et espacement optimisé
 * Interface avec réduction des marges et padding pour un affichage optimal
 */

echo "<h1>📱 Style Planity Mobile - Accordéon avec Espacement Optimisé</h1>\n";

echo "<h2>🚨 Problème d'espacement résolu</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Problème d'affichage précédent :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Trop d'espace sur les côtés</strong> - Marges excessives</li>\n";
echo "<li>❌ <strong>Padding trop important</strong> - Interface pas optimale</li>\n";
echo "<li>❌ <strong>Largeur mal utilisée</strong> - Espace perdu</li>\n";
echo "<li>❌ <strong>Pas assez compact</strong> - Style mobile non optimal</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Espacement optimisé Planity mobile</h2>\n";

echo "<h3>1. ✅ Réduction des marges</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Optimisation de l'espace :</strong><br>\n";

// Simulation de l'accordéon mobile avec espacement optimisé
echo "<div style='max-width:400px;margin:20px auto;padding:10px;background:#f8f9fa;border-radius:12px;'>\n";
echo "<h3 style='font-size:1.1rem;font-weight:600;color:#374151;margin:0 0 0.8rem 0.5rem;'>Choix de la prestation</h3>\n";

// Accordéon avec espacement réduit
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:0.5rem;overflow:hidden;width:100%;box-sizing:border-box;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:0.8rem;cursor:pointer;background:#f1f5f9;'>\n";
echo "<span style='font-size:0.95rem;font-weight:500;color:#374151;'>Coiffure</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;'>\n";

// Services avec espacement optimisé
$services = [
    ['name' => 'Patine', 'price' => '0.00', 'duration' => '60'],
    ['name' => 'Balayage', 'price' => '0.00', 'duration' => '300'],
    ['name' => 'coiffure fête sans brushing', 'price' => '0.00', 'duration' => '60'],
    ['name' => 'Brushing Polycos', 'price' => '1550.00', 'duration' => '40'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 3 ? 'border-bottom:1px solid #f3f4f6;' : '';
    echo "<div style='padding:0.8rem;{$borderBottom}'>\n";
    
    // Informations principales du service
    echo "<div style='margin-bottom:0.8rem;'>\n";
    echo "<h5 style='font-size:0.9rem;font-weight:600;color:#1f2937;margin:0 0 0.4rem 0;line-height:1.4;'>{$service['name']}</h5>\n";
    echo "<p style='font-size:0.8rem;color:#374151;margin:0;font-weight:500;'>à partir de {$service['price']} DA</p>\n";
    echo "</div>\n";
    
    // Durée et bouton
    echo "<div style='display:flex;justify-content:space-between;align-items:center;'>\n";
    echo "<span style='font-size:0.8rem;color:#6b7280;font-weight:500;'>{$service['duration']}</span>\n";
    echo "<button style='background:#1f2937;color:white;border:none;padding:0.5rem 0.8rem;border-radius:6px;font-size:0.8rem;font-weight:500;cursor:pointer;min-width:65px;'>Choisir</button>\n";
    echo "</div>\n";
    
    echo "</div>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "</div>\n";

echo "<ul>\n";
echo "<li>📏 <strong>Padding réduit</strong> : 0.8rem au lieu de 1.2rem</li>\n";
echo "<li>📐 <strong>Marges optimisées</strong> : 0.25rem sur les côtés</li>\n";
echo "<li>📱 <strong>Largeur maximale</strong> : 100% de l'espace disponible</li>\n";
echo "<li>🎯 <strong>Compact et lisible</strong> : Équilibre parfait</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Responsive mobile optimisé</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Adaptation mobile parfaite :</strong><br>\n";
echo "<ul>\n";
echo "<li>📱 <strong>Mobile (< 480px)</strong> : Padding encore plus réduit</li>\n";
echo "<li>📏 <strong>Espacement intelligent</strong> : Adaptation selon la taille d'écran</li>\n";
echo "<li>🎯 <strong>Utilisation optimale</strong> : Chaque pixel compte</li>\n";
echo "<li>⚡ <strong>Performance visuelle</strong> : Plus de contenu visible</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Comparaison avant/après espacement</h2>\n";

echo "<h3>Avant - Espacement excessif</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:#f8f9fa;padding:20px;border-radius:8px;'>\n";
echo "<h4 style='margin:0 0 1rem 0;padding:0 1rem;'>Choix de la prestation</h4>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:8px;'>\n";
echo "<div style='padding:1.5rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:1rem;'>\n";
echo "<h5 style='font-size:1rem;margin:0 0 0.5rem 0;'>Service exemple</h5>\n";
echo "<p style='font-size:0.9rem;margin:0;'>à partir de 1000 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.9rem;'>30min</span>\n";
echo "<button style='padding:0.6rem 1.2rem;font-size:0.9rem;background:#1f2937;color:white;border:none;border-radius:6px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;text-align:center;'>❌ Trop d'espace - Padding excessif</p>\n";
echo "</div>\n";

echo "<h3>Après - Espacement optimisé</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:#f8f9fa;padding:10px;border-radius:8px;'>\n";
echo "<h4 style='margin:0 0 0.8rem 0.5rem;font-size:1.1rem;'>Choix de la prestation</h4>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:8px;'>\n";
echo "<div style='padding:0.8rem;border-bottom:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.8rem;'>\n";
echo "<h5 style='font-size:0.9rem;margin:0 0 0.4rem 0;'>Service exemple</h5>\n";
echo "<p style='font-size:0.8rem;margin:0;'>à partir de 1000 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;'>\n";
echo "<span style='font-size:0.8rem;'>30min</span>\n";
echo "<button style='padding:0.5rem 0.8rem;font-size:0.8rem;background:#1f2937;color:white;border:none;border-radius:6px;min-width:65px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;text-align:center;'>✅ Espacement optimal - Compact et lisible</p>\n";
echo "</div>\n";

echo "<h2>📱 Valeurs d'espacement appliquées</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Élément</th><th style='border:1px solid #ddd;padding:8px;'>Avant</th><th style='border:1px solid #ddd;padding:8px;'>Après</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Container padding</td><td style='border:1px solid #ddd;padding:8px;'>1rem (16px)</td><td style='border:1px solid #ddd;padding:8px;'>0.5rem (8px)</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Header padding</td><td style='border:1px solid #ddd;padding:8px;'>1rem 1.5rem</td><td style='border:1px solid #ddd;padding:8px;'>1rem 1rem</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Service padding</td><td style='border:1px solid #ddd;padding:8px;'>1.2rem 1.5rem</td><td style='border:1px solid #ddd;padding:8px;'>1rem 1rem</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Mobile (< 480px)</td><td style='border:1px solid #ddd;padding:8px;'>-</td><td style='border:1px solid #ddd;padding:8px;'>0.8rem 0.8rem</td></tr>\n";
echo "</table>\n";

echo "<h2>📝 Améliorations CSS appliquées</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Modifications apportées :</h3>\n";
echo "<pre style='background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;'>\n";
echo "/* Container principal */\n";
echo ".category-accordion-mobile {\n";
echo "  padding: 0 0.5rem; /* Réduit de 1rem */\n";
echo "  width: 100%;\n";
echo "  box-sizing: border-box;\n";
echo "}\n\n";
echo "/* En-tête accordéon */\n";
echo ".accordion-header {\n";
echo "  padding: 1rem 1rem; /* Réduit de 1.5rem */\n";
echo "}\n\n";
echo "/* Services */\n";
echo ".accordion-service-item {\n";
echo "  padding: 1rem 1rem; /* Réduit de 1.5rem */\n";
echo "}\n\n";
echo "/* Mobile responsive */\n";
echo "@media (max-width: 480px) {\n";
echo "  .category-accordion-mobile {\n";
echo "    padding: 0 0.25rem; /* Encore plus réduit */\n";
echo "  }\n";
echo "  .accordion-service-item {\n";
echo "    padding: 0.8rem 0.8rem;\n";
echo "  }\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🧪 Test de l'espacement optimisé</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Tester sur <strong>mobile</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Vérifier la <strong>réduction des marges</strong> sur les côtés</li>\n";
echo "<li>✅ Vérifier l'<strong>utilisation optimale de la largeur</strong></li>\n";
echo "<li>✅ Ouvrir un accordéon et vérifier :</li>\n";
echo "<ul>\n";
echo "<li>📏 <strong>Padding réduit</strong> dans les services</li>\n";
echo "<li>📱 <strong>Plus de contenu visible</strong></li>\n";
echo "<li>🎯 <strong>Interface plus compacte</strong></li>\n";
echo "</ul>\n";
echo "<li>✅ Tester sur <strong>très petit écran (< 480px)</strong> :</li>\n";
echo "<ul>\n";
echo "<li>📐 <strong>Espacement encore plus réduit</strong></li>\n";
echo "<li>⚡ <strong>Optimisation maximale</strong></li>\n";
echo "</ul>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Interface Planity mobile avec espacement optimisé :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📏 <strong>Marges réduites</strong> : Utilisation maximale de la largeur</li>\n";
echo "<li>📱 <strong>Padding optimisé</strong> : Compact mais lisible</li>\n";
echo "<li>🎯 <strong>Plus de contenu visible</strong> : Meilleure utilisation de l'espace</li>\n";
echo "<li>📐 <strong>Responsive parfait</strong> : Adaptation selon la taille d'écran</li>\n";
echo "<li>⚡ <strong>UX mobile optimale</strong> : Interface fluide et compacte</li>\n";
echo "<li>✨ <strong>Style Planity authentique</strong> : Espacement professionnel</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📱 Espacement mobile Planity parfaitement optimisé ! 🎯</p>\n";
?>
