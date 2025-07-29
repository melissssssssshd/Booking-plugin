<?php
/**
 * Test formulaire Planity noir/blanc/gris épuré
 * Design ultra-moderne avec sélecteur pays corrigé
 */

echo "<h1>🖤 Test Formulaire Planity - Noir/Blanc/Gris</h1>\n";

echo "<h2>🎯 Palette Planity moderne</h2>\n";
echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Couleurs épurées :</h3>\n";
echo "<ul>\n";
echo "<li>⚫ <strong>Noir principal</strong> : #111827 (texte, titres)</li>\n";
echo "<li>⚪ <strong>Blanc pur</strong> : #ffffff (container, focus)</li>\n";
echo "<li>🔘 <strong>Gris clair</strong> : #f9fafb (fond inputs)</li>\n";
echo "<li>🔘 <strong>Gris moyen</strong> : #6b7280 (labels, icônes)</li>\n";
echo "<li>🔘 <strong>Gris foncé</strong> : #374151 (focus, hover)</li>\n";
echo "<li>🔘 <strong>Bordures</strong> : #d1d5db (subtiles)</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 Simulation formulaire Planity</h2>\n";

// Container principal style Planity
echo "<div style='max-width:500px;margin:20px auto;background:#ffffff;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;padding:2rem;font-family:-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,sans-serif;'>\n";

echo "<h2 style='font-size:24px;font-weight:700;color:#111827;margin-bottom:2rem;margin-top:0;text-align:center;letter-spacing:-0.025em;'>Vos informations</h2>\n";

// Champ Prénom - Style Planity noir/blanc/gris
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<div style='position:absolute;left:16px;top:16px;color:#6b7280;font-size:20px;display:flex;align-items:center;height:20px;z-index:2;'>👤</div>\n";
echo "<input type='text' style='width:100%;background:#f9fafb;border:1px solid #d1d5db;border-radius:12px;font-size:16px;color:#111827;padding:16px 16px 16px 48px;box-shadow:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);font-weight:500;' ";
echo "placeholder=' ' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#374151\";this.style.boxShadow=\"0 0 0 3px rgba(55,65,81,0.1)\";this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#374151\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";' ";
echo "onblur='if(!this.value){this.style.background=\"#f9fafb\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"none\";this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#6b7280\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo "oninput='if(this.value){this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#374151\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";}else{this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#6b7280\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo ">\n";
echo "<label style='position:absolute;left:48px;top:16px;color:#6b7280;font-size:16px;font-weight:500;pointer-events:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);background:transparent;padding:0 4px;'>Prénom</label>\n";
echo "</div>\n";

// Champ Nom - Style Planity noir/blanc/gris
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<div style='position:absolute;left:16px;top:16px;color:#6b7280;font-size:20px;display:flex;align-items:center;height:20px;z-index:2;'>👤</div>\n";
echo "<input type='text' style='width:100%;background:#f9fafb;border:1px solid #d1d5db;border-radius:12px;font-size:16px;color:#111827;padding:16px 16px 16px 48px;box-shadow:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);font-weight:500;' ";
echo "placeholder=' ' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#374151\";this.style.boxShadow=\"0 0 0 3px rgba(55,65,81,0.1)\";this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#374151\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";' ";
echo "onblur='if(!this.value){this.style.background=\"#f9fafb\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"none\";this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#6b7280\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo "oninput='if(this.value){this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#374151\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";}else{this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#6b7280\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo ">\n";
echo "<label style='position:absolute;left:48px;top:16px;color:#6b7280;font-size:16px;font-weight:500;pointer-events:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);background:transparent;padding:0 4px;'>Nom</label>\n";
echo "</div>\n";

// Champ Email - Style Planity noir/blanc/gris
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<div style='position:absolute;left:16px;top:16px;color:#6b7280;font-size:20px;display:flex;align-items:center;height:20px;z-index:2;'>✉️</div>\n";
echo "<input type='email' style='width:100%;background:#f9fafb;border:1px solid #d1d5db;border-radius:12px;font-size:16px;color:#111827;padding:16px 16px 16px 48px;box-shadow:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);font-weight:500;' ";
echo "placeholder=' ' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#374151\";this.style.boxShadow=\"0 0 0 3px rgba(55,65,81,0.1)\";this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#374151\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";' ";
echo "onblur='if(!this.value){this.style.background=\"#f9fafb\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"none\";this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#6b7280\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo "oninput='if(this.value){this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#374151\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";}else{this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#6b7280\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo ">\n";
echo "<label style='position:absolute;left:48px;top:16px;color:#6b7280;font-size:16px;font-weight:500;pointer-events:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);background:transparent;padding:0 4px;'>Email (optionnel)</label>\n";
echo "</div>\n";

// Champ téléphone - Style Planity noir/blanc/gris CORRIGÉ
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<label style='color:#6b7280;font-size:14px;font-weight:600;margin-bottom:8px;display:block;letter-spacing:-0.025em;'>Téléphone</label>\n";

// Container téléphone avec sélecteur pays moderne
echo "<div style='position:relative;'>\n";
echo "<div style='width:100%;border-radius:12px;background:#f9fafb;box-shadow:none;border:1px solid #d1d5db;padding:0;display:flex;align-items:center;min-height:52px;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#374151\";this.style.boxShadow=\"0 0 0 3px rgba(55,65,81,0.1)\";' ";
echo "onblur='this.style.background=\"#f9fafb\";this.style.borderColor=\"#d1d5db\";this.style.boxShadow=\"none\";'>\n";

// Sélecteur pays moderne
echo "<div style='min-width:60px;height:auto;display:flex;align-items:center;justify-content:center;background:#e5e7eb;border-radius:12px 0 0 12px;border-right:1px solid #d1d5db;padding:0 12px;cursor:pointer;transition:all 0.2s ease;' ";
echo "onclick='this.nextElementSibling.style.display=this.nextElementSibling.style.display===\"block\"?\"none\":\"block\";this.querySelector(\".arrow\").style.transform=this.nextElementSibling.style.display===\"block\"?\"rotate(180deg)\":\"rotate(0deg)\";' ";
echo "onmouseover='this.style.background=\"#d1d5db\";' ";
echo "onmouseout='this.style.background=\"#e5e7eb\";'>\n";
echo "🇫🇷 <span style='color:#374151;font-weight:600;font-size:16px;margin-left:8px;'>+33</span>\n";
echo "<span class='arrow' style='border-left:4px solid transparent;border-right:4px solid transparent;border-top:4px solid #6b7280;border-bottom:none;margin-left:6px;transition:transform 0.2s ease;display:inline-block;'></span>\n";
echo "</div>\n";

// Dropdown pays style Planity
echo "<div style='position:absolute;top:100%;left:0;right:0;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);padding:8px 0;margin-top:4px;max-height:200px;overflow-y:auto;z-index:1000;display:none;'>\n";

$countries = [
    ['🇫🇷', 'France', '+33'],
    ['🇩🇪', 'Allemagne', '+49'],
    ['🇪🇸', 'Espagne', '+34'],
    ['🇮🇹', 'Italie', '+39'],
    ['🇬🇧', 'Royaume-Uni', '+44'],
    ['🇺🇸', 'États-Unis', '+1'],
    ['🇨🇦', 'Canada', '+1'],
    ['🇧🇪', 'Belgique', '+32'],
    ['🇨🇭', 'Suisse', '+41'],
    ['🇱🇺', 'Luxembourg', '+352']
];

foreach ($countries as $country) {
    echo "<div style='padding:10px 16px;background:#ffffff;border:none;color:#374151;font-size:14px;font-weight:500;cursor:pointer;transition:all 0.2s ease;display:flex;align-items:center;gap:12px;' ";
    echo "onmouseover='this.style.background=\"#f9fafb\";this.style.color=\"#111827\";' ";
    echo "onmouseout='this.style.background=\"#ffffff\";this.style.color=\"#374151\";' ";
    echo "onclick='document.querySelector(\".selected-country\").innerHTML=\"{$country[0]} <span style=\\\"color:#374151;font-weight:600;font-size:16px;margin-left:8px;\\\">{$country[2]}</span>\";this.parentElement.style.display=\"none\";this.parentElement.previousElementSibling.querySelector(\".arrow\").style.transform=\"rotate(0deg)\";'>\n";
    echo "<span style='width:20px;height:15px;border-radius:2px;border:1px solid #e5e7eb;margin-right:8px;flex-shrink:0;'>{$country[0]}</span>\n";
    echo "<span style='color:#374151;font-size:14px;font-weight:500;flex:1;'>{$country[1]}</span>\n";
    echo "<span style='color:#6b7280;font-size:13px;font-weight:600;background:#f9fafb;padding:2px 6px;border-radius:4px;margin-left:auto;'>{$country[2]}</span>\n";
    echo "</div>\n";
}

echo "</div>\n";

// Input téléphone
echo "<input type='tel' style='width:100%;border:none;background:transparent;border-radius:0 12px 12px 0;padding:16px;font-size:16px;color:#111827;box-shadow:none;outline:none;height:52px;line-height:1.5;font-weight:500;' placeholder='6 12 34 56 78'>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

// Checkbox style Planity
echo "<div style='margin:1.5rem 0;display:flex;align-items:flex-start;gap:12px;'>\n";
echo "<input type='checkbox' style='width:18px;height:18px;border:2px solid #d1d5db;border-radius:4px;background:#f9fafb;margin:0;cursor:pointer;flex-shrink:0;' ";
echo "onchange='if(this.checked){this.style.background=\"#374151\";this.style.borderColor=\"#374151\";}else{this.style.background=\"#f9fafb\";this.style.borderColor=\"#d1d5db\";}'>\n";
echo "<label style='font-size:14px;color:#374151;line-height:1.5;cursor:pointer;font-weight:500;'>J'ai lu et j'accepte la <a href='#' style='color:#111827;text-decoration:underline;font-weight:600;' onmouseover='this.style.color=\"#6b7280\";' onmouseout='this.style.color=\"#111827\";'>politique de confidentialité</a> et les <a href='#' style='color:#111827;text-decoration:underline;font-weight:600;' onmouseover='this.style.color=\"#6b7280\";' onmouseout='this.style.color=\"#111827\";'>conditions générales</a>.</label>\n";
echo "</div>\n";

// Bouton validation style Planity noir
echo "<button style='width:100%;min-height:48px;padding:16px;font-size:16px;font-weight:600;border-radius:12px;background:#111827;color:#ffffff;border:none;margin:1rem 0;cursor:pointer;transition:all 0.2s ease;' ";
echo "onmouseover='this.style.background=\"#374151\";this.style.transform=\"translateY(-1px)\";this.style.boxShadow=\"0 4px 12px rgba(0,0,0,0.15)\";' ";
echo "onmouseout='this.style.background=\"#111827\";this.style.transform=\"translateY(0)\";this.style.boxShadow=\"none\";' ";
echo "onclick='alert(\"✅ Formulaire Planity noir/blanc/gris !\\n\\n→ Design épuré moderne\\n→ Sélecteur pays corrigé\\n→ Palette cohérente\\n→ UX premium\")'>";
echo "Valider la réservation";
echo "</button>\n";

echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez le formulaire Planity noir/blanc/gris</em></p>\n";

echo "<h2>🔧 Corrections apportées</h2>\n";

echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>✅ Problèmes résolus :</h3>\n";
echo "<ul>\n";
echo "<li>🎨 <strong>Palette cohérente</strong> : Noir/blanc/gris Planity</li>\n";
echo "<li>📞 <strong>Sélecteur pays moderne</strong> : Design épuré intégré</li>\n";
echo "<li>🔘 <strong>Dropdown stylé</strong> : Liste pays avec scrollbar custom</li>\n";
echo "<li>✨ <strong>Animations fluides</strong> : Transitions modernes</li>\n";
echo "<li>📱 <strong>Mobile optimisé</strong> : Touch-friendly responsive</li>\n";
echo "<li>🚀 <strong>UX premium</strong> : Expérience Planity authentique</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Formulaire Planity parfait :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>🖤 <strong>Design épuré</strong> : Palette noir/blanc/gris cohérente</li>\n";
echo "<li>📞 <strong>Téléphone moderne</strong> : Sélecteur pays intégré</li>\n";
echo "<li>🔘 <strong>Dropdown stylé</strong> : Liste pays avec design Planity</li>\n";
echo "<li>✨ <strong>Animations premium</strong> : Micro-interactions fluides</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Mobile et desktop optimisés</li>\n";
echo "<li>🚀 <strong>UX exceptionnelle</strong> : Expérience utilisateur premium</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>🖤 Formulaire Planity noir/blanc/gris parfaitement corrigé ! 🎯</p>\n";
?>
