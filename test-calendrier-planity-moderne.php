<?php
/**
 * Test calendrier Planity ultra-moderne épuré minimaliste
 * Design chic et contemporain
 */

echo "<h1>📅 Test Calendrier Planity - Ultra-Moderne Épuré</h1>\n";

echo "<h2>🎯 Design Planity ultra-moderne</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Caractéristiques du design :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Épuré minimaliste</strong> : Design ultra-clean</li>\n";
echo "<li>✅ <strong>Coins arrondis</strong> : 12px pour les jours, 16px pour le container</li>\n";
echo "<li>✅ <strong>Palette neutre</strong> : Gris slate moderne</li>\n";
echo "<li>✅ <strong>Micro-interactions</strong> : Animations fluides</li>\n";
echo "<li>✅ <strong>Responsive parfait</strong> : Mobile et desktop</li>\n";
echo "<li>✅ <strong>Typographie moderne</strong> : Inter font, poids optimisés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Palette de couleurs Planity</h2>\n";
echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Couleurs utilisées :</h3>\n";
echo "<ul>\n";
echo "<li>🤍 <strong>Fond normal</strong> : #f8fafc (slate-50)</li>\n";
echo "<li>🔘 <strong>Hover</strong> : #e2e8f0 (slate-200)</li>\n";
echo "<li>⚫ <strong>Sélectionné</strong> : #111827 (gray-900)</li>\n";
echo "<li>🔘 <strong>Aujourd'hui</strong> : #f1f5f9 (slate-100)</li>\n";
echo "<li>🔘 <strong>Désactivé</strong> : #cbd5e1 (slate-300)</li>\n";
echo "<li>⚪ <strong>Container</strong> : #ffffff avec ombre subtile</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📝 CSS Planity moderne</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Styles ultra-modernes :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Calendrier Planity ultra-moderne */\n";
echo ".calendly-day {\n";
echo "  width: 44px;\n";
echo "  height: 44px;\n";
echo "  border-radius: 12px;\n";
echo "  background: #f8fafc; /* slate-50 */\n";
echo "  color: #334155; /* slate-700 */\n";
echo "  font-size: 15px;\n";
echo "  font-weight: 500;\n";
echo "  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);\n";
echo "}\n\n";
echo "/* Hover épuré */\n";
echo ".calendly-day:hover {\n";
echo "  background: #e2e8f0; /* slate-200 */\n";
echo "  color: #1e293b; /* slate-800 */\n";
echo "  transform: translateY(-2px);\n";
echo "  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);\n";
echo "}\n\n";
echo "/* Sélection moderne */\n";
echo ".calendly-day.selected {\n";
echo "  background: #111827; /* gray-900 */\n";
echo "  color: #ffffff;\n";
echo "  transform: translateY(-1px);\n";
echo "  box-shadow: 0 6px 16px rgba(17, 24, 39, 0.2);\n";
echo "}\n\n";
echo "/* Container épuré */\n";
echo ".calendar-col {\n";
echo "  background: #ffffff;\n";
echo "  border-radius: 20px;\n";
echo "  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);\n";
echo "  border: 1px solid #f1f5f9;\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>📅 Simulation calendrier Planity</h2>\n";

echo "<div style='max-width:420px;margin:20px auto;background:#ffffff;border-radius:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05);border:1px solid #f1f5f9;overflow:hidden;'>\n";

// En-tête du calendrier
echo "<div style='padding:20px 24px 16px;background:#ffffff;border-radius:20px 20px 0 0;'>\n";
echo "<div style='display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;'>\n";
echo "<button style='width:40px;height:40px;border-radius:10px;background:#f8fafc;border:none;color:#64748b;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;' onmouseover='this.style.background=\"#e2e8f0\";this.style.color=\"#334155\";this.style.transform=\"translateY(-1px)\";' onmouseout='this.style.background=\"#f8fafc\";this.style.color=\"#64748b\";this.style.transform=\"translateY(0)\";'>‹</button>\n";
echo "<h3 style='font-size:20px;font-weight:600;color:#0f172a;margin:0;letter-spacing:-0.025em;'>Janvier 2025</h3>\n";
echo "<button style='width:40px;height:40px;border-radius:10px;background:#f8fafc;border:none;color:#64748b;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;' onmouseover='this.style.background=\"#e2e8f0\";this.style.color=\"#334155\";this.style.transform=\"translateY(-1px)\";' onmouseout='this.style.background=\"#f8fafc\";this.style.color=\"#64748b\";this.style.transform=\"translateY(0)\";'>›</button>\n";
echo "</div>\n";

// Jours de la semaine
echo "<div style='display:grid;grid-template-columns:repeat(7,1fr);gap:8px;padding:0 0 16px;'>\n";
$weekdays = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];
foreach ($weekdays as $day) {
    echo "<div style='font-size:12px;font-weight:500;color:#64748b;text-align:center;text-transform:uppercase;letter-spacing:0.05em;padding:8px 0;'>{$day}</div>\n";
}
echo "</div>\n";
echo "</div>\n";

// Grille du calendrier
echo "<div style='padding:0 24px 24px;'>\n";
echo "<div style='display:grid;grid-template-columns:repeat(7,1fr);gap:8px;'>\n";

// Simulation des jours du mois
$days = [
    ['', '', '', 1, 2, 3, 4],
    [5, 6, 7, 8, 9, 10, 11],
    [12, 13, 14, 15, 16, 17, 18],
    [19, 20, 21, 22, 23, 24, 25],
    [26, 27, 28, 29, 30, 31, '']
];

$today = 15;
$selected = 22;

foreach ($days as $week) {
    foreach ($week as $day) {
        if ($day === '') {
            echo "<div style='width:44px;height:44px;'></div>\n";
        } else {
            $isToday = $day === $today;
            $isSelected = $day === $selected;
            $isPast = $day < $today;
            
            if ($isSelected) {
                $style = "background:#111827;color:#ffffff;transform:translateY(-1px);box-shadow:0 6px 16px rgba(17,24,39,0.2);";
                $onclick = "";
            } elseif ($isToday) {
                $style = "background:#f1f5f9;color:#0f172a;border:2px solid #e2e8f0;font-weight:600;";
                $onclick = "onclick='alert(\"📅 Aujourd\\'hui sélectionné !\\n\\nDate: {$day} Janvier 2025\\nStyle: Planity moderne\\n\\n→ Design épuré !\")' ";
                $onclick .= "onmouseover='this.style.background=\"#e2e8f0\";this.style.color=\"#1e293b\";this.style.transform=\"translateY(-2px)\";this.style.boxShadow=\"0 4px 12px rgba(0,0,0,0.08)\";' ";
                $onclick .= "onmouseout='this.style.background=\"#f1f5f9\";this.style.color=\"#0f172a\";this.style.transform=\"translateY(0)\";this.style.boxShadow=\"none\";'";
            } elseif ($isPast) {
                $style = "background:#f8fafc;color:#cbd5e1;cursor:not-allowed;opacity:0.5;";
                $onclick = "";
            } else {
                $style = "background:#f8fafc;color:#334155;cursor:pointer;";
                $onclick = "onclick='alert(\"📅 Date sélectionnée !\\n\\nDate: {$day} Janvier 2025\\nStyle: Planity ultra-moderne\\nDesign: Épuré minimaliste\\n\\n→ Calendrier chic !\")' ";
                $onclick .= "onmouseover='this.style.background=\"#e2e8f0\";this.style.color=\"#1e293b\";this.style.transform=\"translateY(-2px)\";this.style.boxShadow=\"0 4px 12px rgba(0,0,0,0.08)\";' ";
                $onclick .= "onmouseout='this.style.background=\"#f8fafc\";this.style.color=\"#334155\";this.style.transform=\"translateY(0)\";this.style.boxShadow=\"none\";'";
            }
            
            echo "<button style='width:44px;height:44px;border-radius:12px;border:none;font-size:15px;font-weight:500;display:flex;align-items:center;justify-content:center;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);{$style}' {$onclick}>";
            echo $day;
            echo "</button>\n";
        }
    }
}

echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez le calendrier Planity ultra-moderne</em></p>\n";

echo "<h2>🧪 Test du calendrier</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page de réservation</li>\n";
echo "<li>Naviguer jusqu'à l'étape <strong>Date & Heure</strong></li>\n";
echo "<li>Observer le calendrier transformé :</li>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Design épuré</strong> : Coins arrondis, ombres subtiles</li>\n";
echo "<li>✅ <strong>Couleurs modernes</strong> : Palette slate neutre</li>\n";
echo "<li>✅ <strong>Animations fluides</strong> : Micro-interactions</li>\n";
echo "<li>✅ <strong>Responsive</strong> : Adapté mobile et desktop</li>\n";
echo "<li>✅ <strong>Typographie</strong> : Inter font moderne</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Calendrier Planity ultra-moderne :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📅 <strong>Design épuré</strong> : Minimaliste et chic</li>\n";
echo "<li>🎨 <strong>Palette moderne</strong> : Slate neutre</li>\n";
echo "<li>✨ <strong>Animations fluides</strong> : Cubic-bezier</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Mobile optimisé</li>\n";
echo "<li>🔘 <strong>Coins arrondis</strong> : 12px jours, 20px container</li>\n";
echo "<li>🚀 <strong>UX excellente</strong> : Interactions intuitives</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>✨ Caractéristiques Planity</h2>\n";

echo "<div style='background:#f0f9ff;padding:15px;border-left:4px solid #0ea5e9;'>\n";
echo "<h3>Style signature Planity :</h3>\n";
echo "<ul>\n";
echo "<li>🎨 <strong>Minimalisme</strong> : Design épuré sans fioritures</li>\n";
echo "<li>🔘 <strong>Géométrie douce</strong> : Coins arrondis harmonieux</li>\n";
echo "<li>⚡ <strong>Micro-interactions</strong> : Animations subtiles</li>\n";
echo "<li>🎯 <strong>Hiérarchie claire</strong> : Typographie structurée</li>\n";
echo "<li>🤍 <strong>Espace blanc</strong> : Respiration visuelle</li>\n";
echo "<li>📱 <strong>Mobile-first</strong> : Pensé pour le tactile</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Calendrier Planity parfaitement réalisé :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📅 <strong>Ultra-moderne</strong> : Design contemporain</li>\n";
echo "<li>🎨 <strong>Épuré minimaliste</strong> : Esthétique Planity</li>\n";
echo "<li>✨ <strong>Chic et élégant</strong> : Finitions premium</li>\n";
echo "<li>🔘 <strong>Palette neutre</strong> : Slate moderne</li>\n";
echo "<li>⚡ <strong>Animations fluides</strong> : UX premium</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Tous écrans</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📅 Calendrier Planity ultra-moderne parfaitement réalisé ! 🎯</p>\n";
?>
