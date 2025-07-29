<?php
/**
 * Test du style Planity avec fonctionnalité "Voir plus"
 * Interface avec limitation d'affichage et expansion esthétique
 */

echo "<h1>👁️ Style Planity avec \"Voir Plus\" - Interface Optimisée</h1>\n";

echo "<h2>🚨 Problème résolu</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Catégories surchargées :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Trop de services affichés</strong> - Interface surchargée</li>\n";
echo "<li>❌ <strong>Scroll infini</strong> - Difficile de naviguer</li>\n";
echo "<li>❌ <strong>Perte d'attention</strong> - Trop d'options visibles</li>\n";
echo "<li>❌ <strong>UX dégradée</strong> - Interface confuse</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Solution avec \"Voir plus\" esthétique</h2>\n";

echo "<h3>1. ✅ Limitation intelligente</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Affichage optimisé :</strong><br>\n";
echo "<ul>\n";
echo "<li>📊 <strong>Maximum 5 services</strong> : Affichage initial limité</li>\n";
echo "<li>🎯 <strong>Services prioritaires</strong> : Les plus importants en premier</li>\n";
echo "<li>📱 <strong>Interface claire</strong> : Pas de surcharge visuelle</li>\n";
echo "<li>⚡ <strong>Navigation fluide</strong> : Scroll réduit</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Lien \"Voir plus\" esthétique</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Design Planity authentique :</strong><br>\n";
echo "<div style='background:#f8f9fa;padding:1rem 1.5rem;border:1px solid #e5e7eb;margin:10px 0;display:flex;align-items:center;justify-content:center;color:#3b82f6;font-weight:500;cursor:pointer;'>\n";
echo "<span style='margin-right:0.5rem;'>Voir les 8 autres prestations</span><span style='font-size:1rem;'>→</span>\n";
echo "</div>\n";
echo "<ul>\n";
echo "<li>🎨 <strong>Fond gris clair</strong> : Distinction visuelle</li>\n";
echo "<li>🔵 <strong>Couleur bleue</strong> : Lien interactif</li>\n";
echo "<li>➡️ <strong>Flèche directionnelle</strong> : Indication claire</li>\n";
echo "<li>✨ <strong>Effet hover</strong> : Animation fluide</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>3. ✅ Fonctionnalité \"Voir moins\"</h3>\n";
echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<strong>Retour à l'état initial :</strong><br>\n";
echo "<div style='background:#f8f9fa;padding:1rem 1.5rem;border:1px solid #e5e7eb;margin:10px 0;display:flex;align-items:center;justify-content:center;color:#3b82f6;font-weight:500;cursor:pointer;'>\n";
echo "<span style='margin-right:0.5rem;'>Voir moins de prestations</span><span style='font-size:1rem;'>↑</span>\n";
echo "</div>\n";
echo "<ul>\n";
echo "<li>🔄 <strong>Réversible</strong> : Retour à l'affichage limité</li>\n";
echo "<li>⬆️ <strong>Flèche vers le haut</strong> : Indication de réduction</li>\n";
echo "<li>🎯 <strong>UX optimale</strong> : Contrôle total de l'affichage</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Aperçu de l'interface avec \"Voir plus\"</h2>\n";

echo "<h3>Exemple avec catégorie surchargée</h3>\n";
echo "<div style='background:#f8f9fa;padding:20px;border-radius:12px;margin:15px 0;'>\n";
echo "<div style='max-width:700px;'>\n";

// Catégorie avec beaucoup de services
echo "<div style='margin-bottom:1.5rem;'>\n";
echo "<div style='background:#f8f9fa;padding:1rem 1.5rem;border:1px solid #e5e7eb;'>\n";
echo "<h4 style='margin:0;font-size:1rem;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:0.5px;'>COIFFURE - SOIN LISSANT</h4>\n";
echo "</div>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-top:none;'>\n";

// Services visibles (5 premiers)
$services = [
    ['name' => 'LISSAGE ENZYMOTHERAPY', 'desc' => 'Lissage professionnel longue durée', 'price' => '30 000 DA', 'duration' => '3h 30min'],
    ['name' => 'LISSAGE TANINO THERAPY', 'desc' => 'Traitement lissant premium', 'price' => '30000 DA', 'duration' => '3h'],
    ['name' => 'LISSAGE DISCOVERY YBERA', 'desc' => 'Enfants & Femme Enceinte', 'price' => '25 000 DA', 'duration' => '3h'],
    ['name' => 'LISSAGE INDIEN', 'desc' => 'Lissage naturel aux huiles', 'price' => '22 000 DA', 'duration' => '3h'],
    ['name' => 'LISSAGE HIGH LISS', 'desc' => 'Lissage haute performance', 'price' => '28 000 DA', 'duration' => '2h'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 4 ? 'border-bottom:1px solid #e5e7eb;' : '';
    echo "<div style='display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;{$borderBottom}'>\n";
    echo "<div style='flex:1;'>\n";
    echo "<h5 style='font-size:1rem;font-weight:600;color:#1f2937;margin:0 0 0.3rem 0;'>{$service['name']}</h5>\n";
    echo "<p style='font-size:0.9rem;color:#6b7280;margin:0 0 0.3rem 0;'>{$service['desc']}</p>\n";
    echo "<p style='font-size:0.9rem;color:#374151;margin:0;font-weight:500;'>à partir de {$service['price']}</p>\n";
    echo "</div>\n";
    echo "<div style='display:flex;align-items:center;gap:1.5rem;'>\n";
    echo "<span style='font-size:0.9rem;color:#6b7280;font-weight:500;min-width:60px;text-align:right;'>{$service['duration']}</span>\n";
    echo "<button style='background:#1f2937;color:white;border:none;padding:0.6rem 1.2rem;border-radius:6px;font-size:0.9rem;font-weight:500;min-width:80px;'>Choisir</button>\n";
    echo "</div>\n";
    echo "</div>\n";
}

// Lien "Voir plus" esthétique
echo "<div style='display:flex;align-items:center;justify-content:center;padding:1rem 1.5rem;background:#f8f9fa;border-top:1px solid #e5e7eb;cursor:pointer;color:#3b82f6;font-weight:500;transition:all 0.2s ease;' onmouseover='this.style.background=\"#f1f5f9\";this.style.color=\"#2563eb\";' onmouseout='this.style.background=\"#f8f9fa\";this.style.color=\"#3b82f6\";'>\n";
echo "<div style='display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;'>\n";
echo "<span>Voir les 8 autres prestations</span>\n";
echo "<span style='font-size:1rem;transition:transform 0.2s ease;'>→</span>\n";
echo "</div>\n";
echo "</div>\n";

echo "</div>\n";
echo "</div>\n";

echo "</div>\n";
echo "</div>\n";

echo "<h2>📊 Comparaison avant/après</h2>\n";

echo "<h3>Avant - Tous les services affichés</h3>\n";
echo "<div style='background:#ffebee;padding:15px;border:1px solid #f44336;border-radius:8px;margin:10px 0;'>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;max-height:300px;overflow-y:auto;'>\n";
for ($i = 1; $i <= 13; $i++) {
    $borderBottom = $i < 13 ? 'border-bottom:1px solid #e5e7eb;' : '';
    echo "<div style='padding:1rem;{$borderBottom}'>LISSAGE SERVICE {$i}</div>\n";
}
echo "</div>\n";
echo "<p style='color:#f44336;font-size:12px;margin-top:10px;'>❌ Interface surchargée - Trop de services visibles</p>\n";
echo "</div>\n";

echo "<h3>Après - Affichage limité avec \"Voir plus\"</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border:1px solid #4caf50;border-radius:8px;margin:10px 0;'>\n";

echo "<div style='background:white;border:1px solid #e5e7eb;'>\n";
for ($i = 1; $i <= 5; $i++) {
    $borderBottom = $i < 5 ? 'border-bottom:1px solid #e5e7eb;' : '';
    echo "<div style='padding:1rem;{$borderBottom}'>LISSAGE SERVICE {$i}</div>\n";
}
echo "<div style='background:#f8f9fa;padding:1rem;border-top:1px solid #e5e7eb;text-align:center;color:#3b82f6;font-weight:500;'>Voir les 8 autres prestations →</div>\n";
echo "</div>\n";

echo "<p style='color:#4caf50;font-size:12px;margin-top:10px;'>✅ Interface claire - Affichage optimisé avec expansion</p>\n";
echo "</div>\n";

echo "<h2>📱 Fonctionnalités techniques</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Fonctionnalité</th><th style='border:1px solid #ddd;padding:8px;'>Description</th><th style='border:1px solid #ddd;padding:8px;'>Avantage</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Limite d'affichage</td><td style='border:1px solid #ddd;padding:8px;'>Maximum 5 services par catégorie</td><td style='border:1px solid #ddd;padding:8px;'>Interface claire</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Lien \"Voir plus\"</td><td style='border:1px solid #ddd;padding:8px;'>Expansion dynamique</td><td style='border:1px solid #ddd;padding:8px;'>Navigation optimale</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Lien \"Voir moins\"</td><td style='border:1px solid #ddd;padding:8px;'>Retour à l'état initial</td><td style='border:1px solid #ddd;padding:8px;'>Contrôle utilisateur</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Style Planity</td><td style='border:1px solid #ddd;padding:8px;'>Design authentique</td><td style='border:1px solid #ddd;padding:8px;'>UX professionnelle</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Responsive</td><td style='border:1px solid #ddd;padding:8px;'>Adaptation mobile</td><td style='border:1px solid #ddd;padding:8px;'>Compatibilité totale</td></tr>\n";
echo "</table>\n";

echo "<h2>🎯 Paramètres configurables</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Configuration JavaScript :</h3>\n";
echo "<ul>\n";
echo "<li><strong>maxServicesShown = 5</strong> : Nombre de services affichés initialement</li>\n";
echo "<li><strong>Texte dynamique</strong> : \"Voir les X autres prestations\"</li>\n";
echo "<li><strong>Animation fluide</strong> : Transition CSS 0.2s ease</li>\n";
echo "<li><strong>Gestion d'état</strong> : Affichage/masquage intelligent</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🧪 Test de la nouvelle fonctionnalité</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Arriver à l'étape de choix du service</li>\n";
echo "<li>✅ Vérifier que seuls <strong>5 services maximum</strong> sont affichés par catégorie</li>\n";
echo "<li>✅ Vérifier la présence du lien <strong>\"Voir les X autres prestations\"</strong></li>\n";
echo "<li>✅ Cliquer sur \"Voir plus\" et vérifier l'<strong>expansion</strong></li>\n";
echo "<li>✅ Vérifier l'apparition du lien <strong>\"Voir moins\"</strong></li>\n";
echo "<li>✅ Cliquer sur \"Voir moins\" et vérifier le <strong>retour à l'état initial</strong></li>\n";
echo "<li>✅ Vérifier le <strong>style esthétique</strong> (fond gris, couleur bleue, flèche)</li>\n";
echo "<li>✅ Tester l'<strong>effet hover</strong> sur les liens</li>\n";
echo "<li>Tester sur mobile</li>\n";
echo "<li>✅ Vérifier l'adaptation responsive des liens</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Interface Planity optimisée :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📊 <strong>Affichage limité</strong> : Maximum 5 services par catégorie</li>\n";
echo "<li>👁️ <strong>Expansion esthétique</strong> : Lien \"Voir plus\" style Planity</li>\n";
echo "<li>🔄 <strong>Réversible</strong> : Lien \"Voir moins\" pour revenir</li>\n";
echo "<li>🎨 <strong>Design cohérent</strong> : Style authentique Planity</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Adaptation mobile optimale</li>\n";
echo "<li>⚡ <strong>UX optimale</strong> : Navigation fluide et intuitive</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Notes techniques</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Améliorations apportées :</h3>\n";
echo "<ul>\n";
echo "<li><strong>Limitation intelligente</strong> : maxServicesShown = 5</li>\n";
echo "<li><strong>Calcul dynamique</strong> : remainingServices = total - affichés</li>\n";
echo "<li><strong>Expansion fluide</strong> : Ajout/suppression DOM</li>\n";
echo "<li><strong>Style esthétique</strong> : CSS Planity authentique</li>\n";
echo "<li><strong>Gestion d'état</strong> : Affichage/masquage intelligent</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>👁️ Interface optimisée avec \"Voir plus\" style Planity ! 🎯</p>\n";
?>
