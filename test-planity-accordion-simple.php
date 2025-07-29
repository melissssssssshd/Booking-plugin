<?php
/**
 * Test du style Planity mobile avec accordéon et affichage simplifié des services
 * Interface avec services affichés de manière épurée comme Planity mobile
 */

echo "<h1>📱 Style Planity Mobile - Accordéon avec Services Simplifiés</h1>\n";

echo "<h2>🚨 Amélioration de l'affichage des services</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Affichage précédent des services :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Trop d'informations</strong> - Description détaillée</li>\n";
echo "<li>❌ <strong>Layout complexe</strong> - Informations sur plusieurs lignes</li>\n";
echo "<li>❌ <strong>Pas assez épuré</strong> - Interface surchargée</li>\n";
echo "<li>❌ <strong>Pas comme Planity</strong> - Style différent</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Nouveau style simplifié Planity</h2>\n";

echo "<h3>1. ✅ Affichage épuré des services</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Style Planity authentique :</strong><br>\n";

// Simulation de l'accordéon mobile avec style simplifié
echo "<div style='max-width:400px;margin:20px auto;padding:20px;background:#f8f9fa;border-radius:12px;'>\n";
echo "<h3 style='font-size:1.2rem;font-weight:600;color:#374151;margin:0 0 1rem 0;'>Choix de la prestation</h3>\n";

// Accordéon ouvert avec services simplifiés
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:0.5rem;overflow:hidden;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;cursor:pointer;background:#f1f5f9;'>\n";
echo "<span style='font-size:1rem;font-weight:500;color:#374151;'>COIFFURE - COIFFAGE</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;'>\n";

// Services avec le nouveau style simplifié
$services = [
    ['name' => 'BRUSHING COURT / MI-LONGS / LONGS', 'price' => '1200-2000', 'duration' => '45min'],
    ['name' => 'SHAMPOO', 'price' => '300', 'duration' => '10min'],
    ['name' => 'MASQUE', 'price' => '400', 'duration' => '10min'],
    ['name' => 'COUPE', 'price' => '2,200', 'duration' => '30min'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 3 ? 'border-bottom:1px solid #f3f4f6;' : '';
    echo "<div style='padding:1.2rem 1.5rem;{$borderBottom}'>\n";
    
    // Informations principales du service
    echo "<div style='margin-bottom:1rem;'>\n";
    echo "<h5 style='font-size:1rem;font-weight:600;color:#1f2937;margin:0 0 0.5rem 0;line-height:1.4;'>{$service['name']}</h5>\n";
    echo "<p style='font-size:0.9rem;color:#374151;margin:0;font-weight:500;'>à partir de {$service['price']} DA</p>\n";
    echo "</div>\n";
    
    // Durée et bouton
    echo "<div style='display:flex;justify-content:space-between;align-items:center;'>\n";
    echo "<span style='font-size:0.9rem;color:#6b7280;font-weight:500;'>{$service['duration']}</span>\n";
    echo "<button style='background:#1f2937;color:white;border:none;padding:0.6rem 1.2rem;border-radius:6px;font-size:0.9rem;font-weight:500;cursor:pointer;min-width:80px;'>Choisir</button>\n";
    echo "</div>\n";
    
    echo "</div>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "</div>\n";

echo "<ul>\n";
echo "<li>📝 <strong>Nom du service</strong> : Titre principal en gras</li>\n";
echo "<li>💰 <strong>Prix simplifié</strong> : \"à partir de X DA\"</li>\n";
echo "<li>⏱️ <strong>Durée visible</strong> : En bas à gauche</li>\n";
echo "<li>🎯 <strong>Bouton \"Choisir\"</strong> : En bas à droite</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Layout optimisé</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Structure claire :</strong><br>\n";
echo "<ul>\n";
echo "<li>📱 <strong>Mobile-first</strong> : Optimisé pour mobile</li>\n";
echo "<li>📐 <strong>Layout vertical</strong> : Informations empilées</li>\n";
echo "<li>🎯 <strong>Actions en bas</strong> : Durée + bouton alignés</li>\n";
echo "<li>✨ <strong>Espacement optimal</strong> : Padding et margins équilibrés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Comparaison avant/après</h2>\n";

echo "<h3>Avant - Affichage complexe</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:white;padding:1rem;border-radius:6px;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;'>\n";
echo "<div style='flex:1;'>\n";
echo "<h5 style='font-size:0.95rem;font-weight:600;color:#1f2937;margin:0 0 0.3rem 0;'>BRUSHING COURT</h5>\n";
echo "<p style='font-size:0.85rem;color:#6b7280;margin:0 0 0.3rem 0;'>Coiffage uniquement</p>\n";
echo "<p style='font-size:0.85rem;color:#374151;margin:0;font-weight:500;'>à partir de 1200 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;align-items:center;gap:1rem;'>\n";
echo "<span style='font-size:0.85rem;color:#6b7280;'>45min</span>\n";
echo "<button style='background:#1f2937;color:white;border:none;padding:0.5rem 1rem;border-radius:6px;font-size:0.85rem;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;text-align:center;'>❌ Layout horizontal - Informations condensées</p>\n";
echo "</div>\n";

echo "<h3>Après - Affichage simplifié Planity</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;max-width:400px;margin:10px auto;'>\n";
echo "<div style='background:white;padding:1.2rem;border-radius:6px;'>\n";
echo "<div style='margin-bottom:1rem;'>\n";
echo "<h5 style='font-size:1rem;font-weight:600;color:#1f2937;margin:0 0 0.5rem 0;line-height:1.4;'>BRUSHING COURT / MI-LONGS / LONGS</h5>\n";
echo "<p style='font-size:0.9rem;color:#374151;margin:0;font-weight:500;'>à partir de 1200-2000 DA</p>\n";
echo "</div>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;'>\n";
echo "<span style='font-size:0.9rem;color:#6b7280;font-weight:500;'>45min</span>\n";
echo "<button style='background:#1f2937;color:white;border:none;padding:0.6rem 1.2rem;border-radius:6px;font-size:0.9rem;font-weight:500;min-width:80px;'>Choisir</button>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;text-align:center;'>✅ Layout vertical - Style Planity épuré</p>\n";
echo "</div>\n";

echo "<h2>📱 Structure du nouveau layout</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Code HTML généré :</h3>\n";
echo "<pre style='background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;'>\n";
echo "&lt;div class=\"accordion-service-item\"&gt;\n";
echo "  &lt;div class=\"service-content\"&gt;\n";
echo "    &lt;div class=\"service-main-info\"&gt;\n";
echo "      &lt;h5 class=\"service-name\"&gt;BRUSHING COURT...&lt;/h5&gt;\n";
echo "      &lt;p class=\"service-price\"&gt;à partir de 1200 DA&lt;/p&gt;\n";
echo "    &lt;/div&gt;\n";
echo "    &lt;div class=\"service-meta\"&gt;\n";
echo "      &lt;span class=\"service-duration\"&gt;45min&lt;/span&gt;\n";
echo "      &lt;button class=\"service-choose-btn\"&gt;Choisir&lt;/button&gt;\n";
echo "    &lt;/div&gt;\n";
echo "  &lt;/div&gt;\n";
echo "&lt;/div&gt;\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🎯 Avantages du nouveau style</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Aspect</th><th style='border:1px solid #ddd;padding:8px;'>Avant</th><th style='border:1px solid #ddd;padding:8px;'>Après</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Layout</td><td style='border:1px solid #ddd;padding:8px;'>Horizontal condensé</td><td style='border:1px solid #ddd;padding:8px;'>Vertical épuré</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Informations</td><td style='border:1px solid #ddd;padding:8px;'>Nom + description + prix</td><td style='border:1px solid #ddd;padding:8px;'>Nom + prix seulement</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Lisibilité</td><td style='border:1px solid #ddd;padding:8px;'>Informations condensées</td><td style='border:1px solid #ddd;padding:8px;'>Informations claires</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Style</td><td style='border:1px solid #ddd;padding:8px;'>Générique</td><td style='border:1px solid #ddd;padding:8px;'>Planity authentique</td></tr>\n";
echo "</table>\n";

echo "<h2>🧪 Test de la nouvelle interface</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Tester sur <strong>mobile</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Vérifier l'apparition de l'<strong>accordéon</strong></li>\n";
echo "<li>✅ Cliquer sur une <strong>catégorie pour l'ouvrir</strong></li>\n";
echo "<li>✅ Vérifier le <strong>nouveau style des services</strong> :</li>\n";
echo "<ul>\n";
echo "<li>📝 <strong>Nom du service</strong> en gras en haut</li>\n";
echo "<li>💰 <strong>Prix</strong> en dessous du nom</li>\n";
echo "<li>⏱️ <strong>Durée</strong> en bas à gauche</li>\n";
echo "<li>🎯 <strong>Bouton \"Choisir\"</strong> en bas à droite</li>\n";
echo "</ul>\n";
echo "<li>✅ Vérifier l'<strong>espacement et le padding</strong></li>\n";
echo "<li>✅ Tester la <strong>sélection d'un service</strong></li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Interface Planity mobile avec services simplifiés :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📱 <strong>Accordéon mobile</strong> : Catégories expandables</li>\n";
echo "<li>📝 <strong>Services épurés</strong> : Nom + prix + durée + bouton</li>\n";
echo "<li>📐 <strong>Layout vertical</strong> : Informations empilées clairement</li>\n";
echo "<li>🎯 <strong>Style Planity</strong> : Exactement comme l'original</li>\n";
echo "<li>⚡ <strong>UX optimale</strong> : Navigation et sélection fluides</li>\n";
echo "<li>📱 <strong>Mobile-first</strong> : Parfaitement adapté aux petits écrans</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Notes techniques</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Améliorations apportées :</h3>\n";
echo "<ul>\n";
echo "<li><strong>Structure simplifiée</strong> : service-content > service-main-info + service-meta</li>\n";
echo "<li><strong>Layout vertical</strong> : display: block au lieu de flex horizontal</li>\n";
echo "<li><strong>Suppression description</strong> : Plus de service-description</li>\n";
echo "<li><strong>Espacement optimisé</strong> : Padding et margins ajustés</li>\n";
echo "<li><strong>Style Planity</strong> : Couleurs et tailles authentiques</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📱 Services simplifiés style Planity mobile parfait ! 🎯</p>\n";
?>
