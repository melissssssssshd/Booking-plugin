<?php
/**
 * Test du style Planity mobile avec accordéon pour les catégories
 * Interface responsive avec accordéon expandable comme Planity mobile
 */

echo "<h1>🪗 Style Planity Mobile avec Accordéon - Interface Expandable</h1>\n";

echo "<h2>🚨 Évolution de l'interface mobile</h2>\n";
echo "<div style='background:#ffebee;padding:15px;border-left:4px solid #f44336;'>\n";
echo "<h3>Du dropdown simple à l'accordéon interactif :</h3>\n";
echo "<ul>\n";
echo "<li>❌ <strong>Dropdown basique</strong> - Pas assez interactif</li>\n";
echo "<li>❌ <strong>Pas de prévisualisation</strong> - Services cachés</li>\n";
echo "<li>❌ <strong>Navigation limitée</strong> - Sélection aveugle</li>\n";
echo "<li>❌ <strong>UX mobile basique</strong> - Pas optimale</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>💡 Solution accordéon Planity mobile</h2>\n";

echo "<h3>1. ✅ Accordéon interactif</h3>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<strong>Interface expandable :</strong><br>\n";

// Simulation de l'accordéon mobile
echo "<div style='max-width:400px;margin:20px auto;padding:20px;background:#f8f9fa;border-radius:12px;'>\n";
echo "<h3 style='font-size:1.2rem;font-weight:600;color:#374151;margin:0 0 1rem 0;'>Choix de la prestation</h3>\n";

// Accordéon fermé
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:0.5rem;overflow:hidden;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;cursor:pointer;background:#f8f9fa;' onclick='toggleAccordion(this)'>\n";
echo "<span style='font-size:1rem;font-weight:500;color:#374151;'>COIFFURE - COIFFAGE</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;'>▼</span>\n";
echo "</div>\n";
echo "</div>\n";

// Accordéon ouvert avec services
echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:0.5rem;overflow:hidden;'>\n";
echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;cursor:pointer;background:#f1f5f9;'>\n";
echo "<span style='font-size:1rem;font-weight:500;color:#374151;'>COIFFURE - COLORATION</span>\n";
echo "<span style='font-size:0.8rem;color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;'>\n";

// Services dans l'accordéon ouvert
$services = [
    ['name' => 'BRUSHING COURT / MI-LONGS / LONGS', 'desc' => 'Coiffage uniquement', 'price' => '1200-2000', 'duration' => '45min'],
    ['name' => 'SHAMPOO', 'desc' => 'Lavage professionnel', 'price' => '300', 'duration' => '10min'],
];

foreach ($services as $index => $service) {
    $borderBottom = $index < 1 ? 'border-bottom:1px solid #f3f4f6;' : '';
    echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;{$borderBottom}'>\n";
    echo "<div style='flex:1;'>\n";
    echo "<h5 style='font-size:0.95rem;font-weight:600;color:#1f2937;margin:0 0 0.3rem 0;'>{$service['name']}</h5>\n";
    echo "<p style='font-size:0.85rem;color:#6b7280;margin:0 0 0.3rem 0;'>{$service['desc']}</p>\n";
    echo "<p style='font-size:0.85rem;color:#374151;margin:0;font-weight:500;'>à partir de {$service['price']} DA</p>\n";
    echo "</div>\n";
    echo "<div style='display:flex;align-items:center;gap:1rem;'>\n";
    echo "<span style='font-size:0.85rem;color:#6b7280;font-weight:500;min-width:50px;text-align:right;'>{$service['duration']}</span>\n";
    echo "<button style='background:#1f2937;color:white;border:none;padding:0.5rem 1rem;border-radius:6px;font-size:0.85rem;font-weight:500;cursor:pointer;'>Choisir</button>\n";
    echo "</div>\n";
    echo "</div>\n";
}

echo "</div>\n";
echo "</div>\n";

// Autres accordéons fermés
$categories = ['COIFFURE - VERNIS / GLOSS', 'COIFFURE - PLACEMENT DE LUMIÈRE', 'COIFFURE - SOIN LISSANT'];
foreach ($categories as $cat) {
    echo "<div style='background:#f8f9fa;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:0.5rem;overflow:hidden;'>\n";
    echo "<div style='display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;cursor:pointer;background:#f8f9fa;'>\n";
    echo "<span style='font-size:1rem;font-weight:500;color:#374151;'>{$cat}</span>\n";
    echo "<span style='font-size:0.8rem;color:#6b7280;'>▼</span>\n";
    echo "</div>\n";
    echo "</div>\n";
}

echo "</div>\n";

echo "<ul>\n";
echo "<li>🪗 <strong>Accordéon expandable</strong> : Clic pour ouvrir/fermer</li>\n";
echo "<li>👁️ <strong>Prévisualisation services</strong> : Services visibles dans l'accordéon</li>\n";
echo "<li>🎯 <strong>Sélection directe</strong> : Bouton \"Choisir\" dans l'accordéon</li>\n";
echo "<li>🔄 <strong>Animation fluide</strong> : Transition smooth d'ouverture</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h3>2. ✅ Fonctionnalité complète</h3>\n";
echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<strong>Toutes les fonctionnalités intégrées :</strong><br>\n";
echo "<ul>\n";
echo "<li>📱 <strong>Mobile-first</strong> : Interface optimisée mobile</li>\n";
echo "<li>🪗 <strong>Accordéon par catégorie</strong> : Une catégorie = un accordéon</li>\n";
echo "<li>🔄 <strong>Ouverture exclusive</strong> : Un seul accordéon ouvert à la fois</li>\n";
echo "<li>⚡ <strong>Sélection rapide</strong> : Choix direct du service</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Comparaison Desktop vs Mobile</h2>\n";

echo "<h3>Desktop - Boutons + Grille de services</h3>\n";
echo "<div style='background:#f8f9fa;padding:20px;border-radius:12px;margin:15px 0;'>\n";
echo "<div style='text-align:center;font-size:1.5rem;font-weight:600;color:#374151;margin-bottom:1.5rem;'>Catégorie</div>\n";
echo "<div style='display:flex;flex-wrap:wrap;justify-content:center;gap:0.75rem;margin-bottom:2rem;'>\n";
echo "<button style='padding:0.75rem 1.5rem;background:#374151;border:1px solid #374151;color:white;border-radius:25px;font-weight:500;font-size:0.9rem;'>ALL</button>\n";
echo "<button style='padding:0.75rem 1.5rem;background:#f8f9fa;border:1px solid #e5e7eb;color:#6b7280;border-radius:25px;font-weight:500;font-size:0.9rem;'>Coiffure</button>\n";
echo "</div>\n";
echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:8px;padding:1rem;'>\n";
echo "<h4 style='margin:0 0 1rem 0;color:#374151;'>COIFFURE - COIFFAGE</h4>\n";
echo "<div style='padding:0.5rem 0;border-bottom:1px solid #f3f4f6;'>BRUSHING COURT... [Choisir]</div>\n";
echo "<div style='padding:0.5rem 0;'>SHAMPOO... [Choisir]</div>\n";
echo "</div>\n";
echo "<p style='text-align:center;color:#4caf50;font-size:14px;margin-top:15px;'>✅ Desktop - Boutons + Grille séparée</p>\n";
echo "</div>\n";

echo "<h3>Mobile - Accordéon intégré</h3>\n";
echo "<div style='background:#f8f9fa;padding:20px;border-radius:12px;margin:15px 0;max-width:400px;margin:15px auto;'>\n";
echo "<h3 style='font-size:1.2rem;font-weight:600;color:#374151;margin:0 0 1rem 0;'>Choix de la prestation</h3>\n";
echo "<div style='background:#f1f5f9;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:0.5rem;'>\n";
echo "<div style='padding:1rem 1.5rem;display:flex;justify-content:space-between;align-items:center;'>\n";
echo "<span style='font-weight:500;color:#374151;'>COIFFURE - COIFFAGE</span>\n";
echo "<span style='color:#6b7280;transform:rotate(180deg);display:inline-block;'>▼</span>\n";
echo "</div>\n";
echo "<div style='background:white;padding:1rem 1.5rem;border-top:1px solid #f3f4f6;'>\n";
echo "<div style='margin-bottom:0.5rem;'>BRUSHING COURT... <button style='background:#1f2937;color:white;border:none;padding:0.3rem 0.6rem;border-radius:4px;font-size:0.8rem;'>Choisir</button></div>\n";
echo "<div>SHAMPOO... <button style='background:#1f2937;color:white;border:none;padding:0.3rem 0.6rem;border-radius:4px;font-size:0.8rem;'>Choisir</button></div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<p style='text-align:center;color:#4caf50;font-size:14px;margin-top:15px;'>✅ Mobile - Accordéon tout-en-un</p>\n";
echo "</div>\n";

echo "<h2>📱 Fonctionnalités techniques</h2>\n";

echo "<table style='border-collapse:collapse;width:100%;margin:10px 0;'>\n";
echo "<tr style='background:#f5f5f5;'><th style='border:1px solid #ddd;padding:8px;'>Fonctionnalité</th><th style='border:1px solid #ddd;padding:8px;'>Desktop</th><th style='border:1px solid #ddd;padding:8px;'>Mobile</th></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Navigation catégories</td><td style='border:1px solid #ddd;padding:8px;'>Boutons horizontaux</td><td style='border:1px solid #ddd;padding:8px;'>Accordéon expandable</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Affichage services</td><td style='border:1px solid #ddd;padding:8px;'>Grille séparée</td><td style='border:1px solid #ddd;padding:8px;'>Intégré dans accordéon</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>Sélection service</td><td style='border:1px solid #ddd;padding:8px;'>Bouton dans grille</td><td style='border:1px solid #ddd;padding:8px;'>Bouton dans accordéon</td></tr>\n";
echo "<tr><td style='border:1px solid #ddd;padding:8px;'>UX</td><td style='border:1px solid #ddd;padding:8px;'>Filtrage + sélection</td><td style='border:1px solid #ddd;padding:8px;'>Navigation + sélection</td></tr>\n";
echo "</table>\n";

echo "<h2>🧪 Test de l'interface accordéon</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page avec le formulaire de réservation</li>\n";
echo "<li>Tester sur <strong>desktop</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Vérifier les <strong>boutons de catégorie</strong></li>\n";
echo "<li>✅ Vérifier la <strong>grille de services séparée</strong></li>\n";
echo "</ul>\n";
echo "<li>Réduire la fenêtre ou tester sur <strong>mobile</strong> :</li>\n";
echo "<ul>\n";
echo "<li>✅ Vérifier l'apparition de l'<strong>accordéon</strong></li>\n";
echo "<li>✅ Vérifier la <strong>disparition des boutons et grille</strong></li>\n";
echo "<li>✅ Cliquer sur une <strong>catégorie pour l'ouvrir</strong></li>\n";
echo "<li>✅ Vérifier l'<strong>animation d'ouverture</strong></li>\n";
echo "<li>✅ Vérifier que les <strong>services apparaissent</strong></li>\n";
echo "<li>✅ Cliquer sur <strong>\"Choisir\"</strong> pour sélectionner un service</li>\n";
echo "<li>✅ Cliquer sur une <strong>autre catégorie</strong></li>\n";
echo "<li>✅ Vérifier que la <strong>première se ferme</strong></li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Résultat attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Interface Planity mobile avec accordéon :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🖥️ <strong>Desktop</strong> : Boutons + grille de services (inchangé)</li>\n";
echo "<li>📱 <strong>Mobile</strong> : Accordéon expandable par catégorie</li>\n";
echo "<li>🪗 <strong>Interaction fluide</strong> : Clic pour ouvrir/fermer</li>\n";
echo "<li>👁️ <strong>Prévisualisation</strong> : Services visibles dans l'accordéon</li>\n";
echo "<li>🎯 <strong>Sélection directe</strong> : Bouton \"Choisir\" intégré</li>\n";
echo "<li>⚡ <strong>UX mobile optimale</strong> : Navigation et sélection en un</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Notes techniques</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Améliorations apportées :</h3>\n";
echo "<ul>\n";
echo "<li><strong>Accordéon JavaScript</strong> : Gestion ouverture/fermeture</li>\n";
echo "<li><strong>Services intégrés</strong> : Affichage dans l'accordéon mobile</li>\n";
echo "<li><strong>Sélection directe</strong> : Bouton \"Choisir\" dans l'accordéon</li>\n";
echo "<li><strong>Animation CSS</strong> : Transition max-height pour l'ouverture</li>\n";
echo "<li><strong>Responsive parfait</strong> : Desktop inchangé, mobile optimisé</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<script>\n";
echo "function toggleAccordion(header) {\n";
echo "  const item = header.parentElement;\n";
echo "  const arrow = header.querySelector('span:last-child');\n";
echo "  const isOpen = item.classList.contains('open');\n";
echo "  \n";
echo "  // Fermer tous les autres\n";
echo "  document.querySelectorAll('.accordion-item').forEach(i => {\n";
echo "    i.classList.remove('open');\n";
echo "    i.querySelector('span:last-child').style.transform = 'rotate(0deg)';\n";
echo "  });\n";
echo "  \n";
echo "  // Ouvrir/fermer celui cliqué\n";
echo "  if (!isOpen) {\n";
echo "    item.classList.add('open');\n";
echo "    arrow.style.transform = 'rotate(180deg)';\n";
echo "  }\n";
echo "}\n";
echo "</script>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>🪗 Interface mobile Planity avec accordéon parfaite ! 🎯</p>\n";
?>
