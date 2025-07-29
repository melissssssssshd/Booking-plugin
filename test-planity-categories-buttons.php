<?php
/**
 * Test du style Planity pour les boutons de catégorie
 * Interface avec filtrage par catégorie style authentique
 */

echo "<h1>🏷️ Style Planity pour les Boutons de Catégorie - Interface Authentique</h1>\n";

echo "<h2>🚨 Transformation appliquée</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Passage des boutons basiques aux boutons Planity :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Style générique</strong> - Boutons sans personnalité</li>\n";
echo "<li>❌ <strong>Couleurs ternes</strong> - Pas d'identité visuelle</li>\n";
echo "<li>❌ <strong>Pas d'effet hover</strong> - Interaction basique</li>\n";
echo "<li>❌ <strong>Design incohérent</strong> - Ne correspond pas à Planity</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Nouveau style Planity authentique</h2>\n";

echo "<h3>1. ✅ Titre \"Catégorie\" centré</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Titre professionnel :</strong><br>\n";
echo "<div style='text-align:center;font-size:1.5rem;font-weight:600;color:#374151;margin:2rem 0 1.5rem 0;letter-spacing:-0.025em;'>\n";
echo "Catégorie\n";
echo "</div>\n";
echo "<ul>\n";
echo "<li>📝 <strong>Centré</strong> : Alignement parfait</li>\n";
echo "<li>🎯 <strong>Font-weight 600</strong> : Poids optimal</li>\n";
echo "<li>📏 <strong>Letter-spacing</strong> : Espacement professionnel</li>\n";
echo "<li>🎨 <strong>Couleur grise</strong> : #374151 style Planity</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Boutons style Planity</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Design authentique :</strong><br>\n";
echo "<div style='display:flex;flex-wrap:wrap;justify-content:center;gap:0.75rem;margin:1rem 0;'>\n";

// Bouton ALL actif
echo "<button style='padding:0.75rem 1.5rem;background:#374151;border:1px solid #374151;color:white;border-radius:25px;font-weight:500;font-size:0.9rem;cursor:pointer;white-space:nowrap;box-shadow:0 2px 8px rgba(55, 65, 81, 0.3);'>ALL</button>\n";

// Boutons inactifs
$categories = ['Coiffure', 'Soins lissants', 'Onglerie', 'Soins capillaires', 'Soin visage', 'Massage'];
foreach ($categories as $cat) {
    echo "<button style='padding:0.75rem 1.5rem;background:#f8f9fa;border:1px solid #e5e7eb;color:#6b7280;border-radius:25px;font-weight:500;font-size:0.9rem;cursor:pointer;white-space:nowrap;box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);transition:all 0.2s ease;' onmouseover='this.style.background=\"#f1f5f9\";this.style.borderColor=\"#d1d5db\";this.style.color=\"#374151\";this.style.transform=\"translateY(-1px)\";this.style.boxShadow=\"0 2px 6px rgba(0, 0, 0, 0.15)\";' onmouseout='this.style.background=\"#f8f9fa\";this.style.borderColor=\"#e5e7eb\";this.style.color=\"#6b7280\";this.style.transform=\"translateY(0)\";this.style.boxShadow=\"0 1px 3px rgba(0, 0, 0, 0.1)\";'>{$cat}</button>\n";
}

echo "</div>\n";
echo "<ul>\n";
echo "<li>🎨 <strong>Fond gris clair</strong> : #f8f9fa pour les inactifs</li>\n";
echo "<li>🔵 <strong>Fond gris foncé</strong> : #374151 pour l'actif</li>\n";
echo "<li>🔘 <strong>Border-radius 25px</strong> : Coins arrondis</li>\n";
echo "<li>✨ <strong>Effet hover</strong> : Animation fluide</li>\n";
echo "<li>📱 <strong>Responsive</strong> : Adaptation mobile</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>3. ✅ Effets d'interaction</h3>\n";
echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<strong>Animations fluides :</strong><br>\n";
echo "<ul>\n";
echo "<li>🎯 <strong>Hover</strong> : Changement de couleur + élévation</li>\n";
echo "<li>⬆️ <strong>Transform</strong> : translateY(-1px) au survol</li>\n";
echo "<li>💫 <strong>Box-shadow</strong> : Ombre plus prononcée</li>\n";
echo "<li>⚡ <strong>Transition</strong> : all 0.2s ease</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Aperçu de l'interface complète</h2>\n";

echo "<h3>Interface Planity avec filtrage par catégorie</h3>\n";
echo "<div style='background:#f8f9fa;padding:30px;border-radius:12px;margin:15px 0;'>\n";
echo "<div style='max-width:800px;margin:0 auto;'>\n";

// Titre Catégorie
echo "<div style='text-align:center;font-size:1.5rem;font-weight:600;color:#374151;margin:2rem 0 1.5rem 0;letter-spacing:-0.025em;'>\n";
echo "Catégorie\n";
echo "</div>\n";

// Boutons de catégorie
echo "<div style='display:flex;flex-wrap:wrap;justify-content:center;gap:0.75rem;margin:0 0 2rem 0;'>\n";

// Bouton ALL actif
echo "<button style='padding:0.75rem 1.5rem;background:#374151;border:1px solid #374151;color:white;border-radius:25px;font-weight:500;font-size:0.9rem;cursor:pointer;white-space:nowrap;box-shadow:0 2px 8px rgba(55, 65, 81, 0.3);'>ALL</button>\n";

// Autres boutons
$allCategories = ['Coiffure', 'Soins lissants', 'Onglerie', 'Soins capillaires', 'Soin visage', 'Massage', 'Épilation', 'Maquillage'];
foreach ($allCategories as $cat) {
    echo "<button style='padding:0.75rem 1.5rem;background:#f8f9fa;border:1px solid #e5e7eb;color:#6b7280;border-radius:25px;font-weight:500;font-size:0.9rem;cursor:pointer;white-space:nowrap;box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);'>{$cat}</button>\n";
}

echo "</div>\n";

// Titre "Choisissez votre service"
echo "<div style='text-align:center;font-size:1.5rem;font-weight:600;color:#374151;margin:2rem 0 1.5rem 0;'>\n";
echo "Choisissez votre service\n";
echo "</div>\n";

// Exemple de services filtrés
echo "<div style='background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);'>\n";

// En-tête catégorie
echo "<div style='background:#f8f9fa;padding:1rem 1.5rem;border:1px solid #e5e7eb;border-radius:12px 12px 0 0;'>\n";
echo "<h4 style='margin:0;font-size:1rem;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:0.5px;'>COIFFURE - COIFFAGE</h4>\n";
echo "</div>\n";

// Services
echo "<div style='background:white;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px;'>\n";

$services = [
    ['name' => 'BRUSHING COURT / MI-LONGS / LONGS', 'desc' => 'Coiffage uniquement', 'price' => 'à partir de 1200-2000 DA', 'duration' => '45min'],
    ['name' => 'SHAMPOO', 'desc' => 'Lavage professionnel', 'price' => 'à partir de 300 DA', 'duration' => '10min'],
    ['name' => 'COUPE', 'desc' => 'Coupe personnalisée', 'price' => '2 200 DA', 'duration' => '30min'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 2 ? 'border-bottom:1px solid #e5e7eb;' : '';
    echo "<div style='display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;{$borderBottom}'>\n";
    echo "<div style='flex:1;'>\n";
    echo "<h5 style='font-size:1rem;font-weight:600;color:#1f2937;margin:0 0 0.3rem 0;'>{$service['name']}</h5>\n";
    echo "<p style='font-size:0.9rem;color:#6b7280;margin:0 0 0.3rem 0;'>{$service['desc']}</p>\n";
    echo "<p style='font-size:0.9rem;color:#374151;margin:0;font-weight:500;'>{$service['price']}</p>\n";
    echo "</div>\n";
    echo "<div style='display:flex;align-items:center;gap:1.5rem;'>\n";
    echo "<span style='font-size:0.9rem;color:#6b7280;font-weight:500;min-width:60px;text-align:right;'>{$service['duration']}</span>\n";
    echo "<button style='background:#1f2937;color:white;border:none;padding:0.6rem 1.2rem;border-radius:6px;font-size:0.9rem;font-weight:500;min-width:80px;'>Choisir</button>\n";
    echo "</div>\n";
    echo "</div>\n";
}

echo "</div>\n";
echo "</div>\n";

echo "</div>\n";
echo "</div>\n";

echo "<h2>📊 Comparaison avant/après</h2>\n";

echo "<h3>Avant - Boutons basiques</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;'>\n";
echo "<div style='display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:center;'>\n";
echo "<button style='padding:0.5rem 1rem;background:#f8f8f8;border:1px solid #ddd;color:#666;border-radius:4px;'>ALL</button>\n";
echo "<button style='padding:0.5rem 1rem;background:#f8f8f8;border:1px solid #ddd;color:#666;border-radius:4px;'>Coiffure</button>\n";
echo "<button style='padding:0.5rem 1rem;background:#f8f8f8;border:1px solid #ddd;color:#666;border-radius:4px;'>Soins</button>\n";
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;'>❌ Style générique - Pas d'identité visuelle</p>\n";
echo "</div>\n";

echo "<h3>Après - Boutons style Planity</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;'>\n";
echo "<div style='text-align:center;font-size:1.2rem;font-weight:600;color:#374151;margin-bottom:1rem;'>Catégorie</div>\n";
echo "<div style='display:flex;flex-wrap:wrap;gap:0.75rem;justify-content:center;'>\n";
echo "<button style='padding:0.75rem 1.5rem;background:#374151;border:1px solid #374151;color:white;border-radius:25px;font-weight:500;font-size:0.9rem;box-shadow:0 2px 8px rgba(55, 65, 81, 0.3);'>ALL</button>\n";
echo "<button style='padding:0.75rem 1.5rem;background:#f8f9fa;border:1px solid #e5e7eb;color:#6b7280;border-radius:25px;font-weight:500;font-size:0.9rem;box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);'>Coiffure</button>\n";
echo "<button style='padding:0.75rem 1.5rem;background:#f8f9fa;border:1px solid #e5e7eb;color:#6b7280;border-radius:25px;font-weight:500;font-size:0.9rem;box-shadow:0 1px 3px rgba(0, 0, 0, 0.1);'>Soins lissants</button>\n";
echo "</div>\n";
echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;'>✅ Style Planity authentique - Design professionnel</p>\n";
echo "</div>\n";

echo "<h2>📱 Fonctionnalités techniques</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Élément</th><th style='border:1px solid #ddd;padding:8px;'>Style</th><th style='border:1px solid #ddd;padding:8px;'>Valeur</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Titre</td><td style='border:1px solid #ddd;padding:8px;'>Font-size</td><td style='border:1px solid #ddd;padding:8px;'>1.5rem</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Bouton inactif</td><td style='border:1px solid #ddd;padding:8px;'>Background</td><td style='border:1px solid #ddd;padding:8px;'>#f8f9fa</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Bouton actif</td><td style='border:1px solid #ddd;padding:8px;'>Background</td><td style='border:1px solid #ddd;padding:8px;'>#374151</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Border-radius</td><td style='border:1px solid #ddd;padding:8px;'>Coins arrondis</td><td style='border:1px solid #ddd;padding:8px;'>25px</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Transition</td><td style='border:1px solid #ddd;padding:8px;'>Animation</td><td style='border:1px solid #ddd;padding:8px;'>all 0.2s ease</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Hover</td><td style='border:1px solid #ddd;padding:8px;'>Transform</td><td style='border:1px solid #ddd;padding:8px;'>translateY(-1px)</td></tr>\n";
echo "</table>\n";

echo "<h2>🧪 Test de la nouvelle interface</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Arriver à l'étape de choix du service</li>\n";
echo "<li>✅ Vérifier le <strong>titre \"Catégorie\" centré</strong></li>\n";
echo "<li>✅ Vérifier le <strong>style des boutons</strong> (coins arrondis, couleurs)</li>\n";
echo "<li>✅ Vérifier le <strong>bouton actif</strong> (fond gris foncé)</li>\n";
echo "<li>✅ Tester l'<strong>effet hover</strong> sur les boutons inactifs</li>\n";
echo "<li>✅ Cliquer sur différentes catégories et vérifier le <strong>filtrage</strong></li>\n";
echo "<li>✅ Vérifier l'<strong>animation de transition</strong></li>\n";
echo "<li>Tester sur mobile</li>\n";
echo "<li>✅ Vérifier l'adaptation responsive des boutons</li>\n";
echo "<li>✅ Vérifier la <strong>réduction de taille</strong> sur mobile</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Interface Planity avec filtrage par catégorie :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🏷️ <strong>Titre centré</strong> : \"Catégorie\" style professionnel</li>\n";
echo "<li>🎨 <strong>Boutons authentiques</strong> : Design Planity exact</li>\n";
echo "<li>🔄 <strong>Filtrage fonctionnel</strong> : Services filtrés par catégorie</li>\n";
echo "<li>✨ <strong>Effets d'interaction</strong> : Hover et transitions fluides</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Adaptation mobile optimale</li>\n";
echo "<li>⚡ <strong>UX professionnelle</strong> : Interface intuitive et moderne</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Notes techniques</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Améliorations apportées :</h3>\n";
echo "<ul>\n";
echo "<li><strong>Titre stylé</strong> : .category-title-planity avec centrage</li>\n";
echo "<li><strong>Boutons redessinés</strong> : Style Planity authentique</li>\n";
echo "<li><strong>Effets hover</strong> : Animation translateY + box-shadow</li>\n";
echo "<li><strong>Responsive design</strong> : Adaptation mobile complète</li>\n";
echo "<li><strong>Couleurs cohérentes</strong> : Palette Planity respectée</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>🏷️ Boutons de catégorie style Planity authentique ! 🎯</p>\n";
?>
