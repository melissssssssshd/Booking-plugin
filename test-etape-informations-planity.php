<?php
/**
 * Test étape "Vos informations" style Planity épuré moderne
 * Design ultra-moderne pour desktop et mobile
 */

echo "<h1>📝 Test Étape Informations - Style Planity</h1>\n";

echo "<h2>🎯 Design Planity épuré moderne</h2>\n";
echo "<div style='background:#e8f5e8;padding:15px;border-left:4px solid #4caf50;'>\n";
echo "<h3>Caractéristiques du design :</h3>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Container épuré</strong> : Fond blanc, bordures subtiles</li>\n";
echo "<li>✅ <strong>Inputs modernes</strong> : Fond slate-50, bordures arrondies</li>\n";
echo "<li>✅ <strong>Labels flottants</strong> : Animation fluide, typographie moderne</li>\n";
echo "<li>✅ <strong>Icônes cohérentes</strong> : Couleur slate, taille optimisée</li>\n";
echo "<li>✅ <strong>Champ téléphone</strong> : Design intégré, flag container épuré</li>\n";
echo "<li>✅ <strong>Responsive parfait</strong> : Mobile et desktop optimisés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎨 Palette Planity moderne</h2>\n";
echo "<div style='background:#f8f9fa;padding:15px;border-left:4px solid #6c757d;'>\n";
echo "<h3>Couleurs utilisées :</h3>\n";
echo "<ul>\n";
echo "<li>⚪ <strong>Container</strong> : #ffffff (blanc pur)</li>\n";
echo "<li>🔘 <strong>Inputs fond</strong> : #f8fafc (slate-50)</li>\n";
echo "<li>🔘 <strong>Bordures</strong> : #e2e8f0 (slate-200)</li>\n";
echo "<li>⚫ <strong>Texte principal</strong> : #1e293b (slate-800)</li>\n";
echo "<li>🔘 <strong>Labels</strong> : #64748b (slate-500)</li>\n";
echo "<li>🔘 <strong>Focus</strong> : #64748b avec ombre subtile</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>📱 Simulation desktop et mobile</h2>\n";

// Simulation desktop
echo "<div style='max-width:500px;margin:20px auto;background:#ffffff;border-radius:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05);border:1px solid #f1f5f9;padding:2rem;'>\n";

echo "<h2 style='font-size:24px;font-weight:600;color:#0f172a;margin-bottom:1.5rem;margin-top:0;text-align:center;letter-spacing:-0.025em;'>Vos informations</h2>\n";

// Champ Prénom
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<div style='position:absolute;left:16px;top:16px;color:#64748b;font-size:20px;display:flex;align-items:center;height:20px;z-index:2;'>👤</div>\n";
echo "<input type='text' style='width:100%;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;font-size:16px;color:#1e293b;padding:16px 16px 16px 48px;box-shadow:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);font-weight:500;' ";
echo "placeholder=' ' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#64748b\";this.style.boxShadow=\"0 0 0 3px rgba(100,116,139,0.1)\";this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#475569\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";' ";
echo "onblur='if(!this.value){this.style.background=\"#f8fafc\";this.style.borderColor=\"#e2e8f0\";this.style.boxShadow=\"none\";this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#64748b\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo "oninput='if(this.value){this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#475569\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";}else{this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#64748b\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo ">\n";
echo "<label style='position:absolute;left:48px;top:16px;color:#64748b;font-size:16px;font-weight:500;pointer-events:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);background:transparent;padding:0 4px;'>Prénom</label>\n";
echo "</div>\n";

// Champ Email
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<div style='position:absolute;left:16px;top:16px;color:#64748b;font-size:20px;display:flex;align-items:center;height:20px;z-index:2;'>✉️</div>\n";
echo "<input type='email' style='width:100%;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;font-size:16px;color:#1e293b;padding:16px 16px 16px 48px;box-shadow:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);font-weight:500;' ";
echo "placeholder=' ' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#64748b\";this.style.boxShadow=\"0 0 0 3px rgba(100,116,139,0.1)\";this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#475569\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";' ";
echo "onblur='if(!this.value){this.style.background=\"#f8fafc\";this.style.borderColor=\"#e2e8f0\";this.style.boxShadow=\"none\";this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#64748b\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo "oninput='if(this.value){this.nextElementSibling.style.top=\"-8px\";this.nextElementSibling.style.left=\"44px\";this.nextElementSibling.style.fontSize=\"12px\";this.nextElementSibling.style.color=\"#475569\";this.nextElementSibling.style.background=\"#ffffff\";this.nextElementSibling.style.padding=\"0 6px\";this.nextElementSibling.style.fontWeight=\"600\";}else{this.nextElementSibling.style.top=\"16px\";this.nextElementSibling.style.left=\"48px\";this.nextElementSibling.style.fontSize=\"16px\";this.nextElementSibling.style.color=\"#64748b\";this.nextElementSibling.style.background=\"transparent\";this.nextElementSibling.style.padding=\"0 4px\";this.nextElementSibling.style.fontWeight=\"500\";}' ";
echo ">\n";
echo "<label style='position:absolute;left:48px;top:16px;color:#64748b;font-size:16px;font-weight:500;pointer-events:none;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);background:transparent;padding:0 4px;'>Email (optionnel)</label>\n";
echo "</div>\n";

// Champ téléphone simulé
echo "<div style='position:relative;margin-bottom:1.5rem;'>\n";
echo "<label style='color:#64748b;font-size:14px;font-weight:600;margin-bottom:8px;display:block;letter-spacing:-0.025em;'>Téléphone</label>\n";
echo "<div style='width:100%;border-radius:12px;background:#f8fafc;box-shadow:none;border:1px solid #e2e8f0;padding:0;display:flex;align-items:center;min-height:52px;transition:all 0.2s cubic-bezier(0.4,0,0.2,1);' ";
echo "onfocus='this.style.background=\"#ffffff\";this.style.borderColor=\"#64748b\";this.style.boxShadow=\"0 0 0 3px rgba(100,116,139,0.1)\";' ";
echo "onblur='this.style.background=\"#f8fafc\";this.style.borderColor=\"#e2e8f0\";this.style.boxShadow=\"none\";'>\n";
echo "<div style='min-width:60px;height:auto;display:flex;align-items:center;justify-content:center;background:#e2e8f0;border-radius:12px 0 0 12px;border-right:1px solid #e2e8f0;padding:0 12px;'>🇫🇷 <span style='color:#475569;font-weight:600;font-size:16px;margin-left:8px;'>+33</span></div>\n";
echo "<input type='tel' style='width:100%;border:none;background:transparent;border-radius:0 12px 12px 0;padding:16px;font-size:16px;color:#1e293b;box-shadow:none;outline:none;height:52px;line-height:1.5;font-weight:500;' placeholder='6 12 34 56 78'>\n";
echo "</div>\n";
echo "</div>\n";

// Checkbox
echo "<div style='margin:1.5rem 0;display:flex;align-items:flex-start;gap:12px;'>\n";
echo "<input type='checkbox' style='width:18px;height:18px;border:2px solid #e2e8f0;border-radius:4px;background:#f8fafc;margin:0;cursor:pointer;flex-shrink:0;' ";
echo "onchange='if(this.checked){this.style.background=\"#64748b\";this.style.borderColor=\"#64748b\";}else{this.style.background=\"#f8fafc\";this.style.borderColor=\"#e2e8f0\";}'>\n";
echo "<label style='font-size:14px;color:#475569;line-height:1.5;cursor:pointer;font-weight:500;'>J'ai lu et j'accepte la <a href='#' style='color:#64748b;text-decoration:underline;font-weight:600;' onmouseover='this.style.color=\"#475569\";' onmouseout='this.style.color=\"#64748b\";'>politique de confidentialité</a> et les <a href='#' style='color:#64748b;text-decoration:underline;font-weight:600;' onmouseover='this.style.color=\"#475569\";' onmouseout='this.style.color=\"#64748b\";'>conditions générales</a>.</label>\n";
echo "</div>\n";

echo "</div>\n";

echo "<p style='text-align:center;margin-top:15px;'><em>👆 Testez les champs Planity modernes</em></p>\n";

echo "<h2>📝 CSS Planity moderne</h2>\n";

echo "<div style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>\n";
echo "<h3>Styles épurés modernes :</h3>\n";
echo "<pre style='background:#e3f2fd;padding:10px;border-radius:5px;overflow-x:auto;font-size:0.9rem;border-left:4px solid #2196f3;'>\n";
echo "/* Container Planity épuré */\n";
echo ".booking-step-infos-modern {\n";
echo "  background: #ffffff;\n";
echo "  border-radius: 20px;\n";
echo "  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);\n";
echo "  border: 1px solid #f1f5f9;\n";
echo "  padding: 2rem;\n";
echo "}\n\n";
echo "/* Inputs modernes */\n";
echo ".booking-input-modern {\n";
echo "  background: #f8fafc; /* slate-50 */\n";
echo "  border: 1px solid #e2e8f0; /* slate-200 */\n";
echo "  border-radius: 12px;\n";
echo "  color: #1e293b; /* slate-800 */\n";
echo "  padding: 16px 16px 16px 48px;\n";
echo "  font-weight: 500;\n";
echo "  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);\n";
echo "}\n\n";
echo "/* Focus moderne */\n";
echo ".booking-input-modern:focus {\n";
echo "  background: #ffffff;\n";
echo "  border-color: #64748b; /* slate-500 */\n";
echo "  box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.1);\n";
echo "}\n\n";
echo "/* Labels flottants */\n";
echo ".floating-label-modern {\n";
echo "  color: #64748b; /* slate-500 */\n";
echo "  font-weight: 500;\n";
echo "  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);\n";
echo "}\n";
echo "</pre>\n";
echo "</div>\n";

echo "<h2>🧪 Test de l'étape</h2>\n";

echo "<div style='background:#fff3e0;padding:15px;border-left:4px solid #ff9800;'>\n";
echo "<h3>🧪 Procédure de test :</h3>\n";
echo "<ol>\n";
echo "<li>Aller sur la page de réservation</li>\n";
echo "<li>Naviguer jusqu'à l'étape <strong>Vos informations</strong></li>\n";
echo "<li>Observer le design modernisé :</li>\n";
echo "<ul>\n";
echo "<li>✅ <strong>Container épuré</strong> : Fond blanc, bordures subtiles</li>\n";
echo "<li>✅ <strong>Inputs modernes</strong> : Fond slate-50, animations fluides</li>\n";
echo "<li>✅ <strong>Labels flottants</strong> : Animation Planity moderne</li>\n";
echo "<li>✅ <strong>Champ téléphone</strong> : Design intégré épuré</li>\n";
echo "<li>✅ <strong>Responsive parfait</strong> : Mobile optimisé</li>\n";
echo "</ul>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>📱 Optimisations mobile</h2>\n";

echo "<div style='background:#e3f2fd;padding:15px;border-left:4px solid #2196f3;'>\n";
echo "<h3>Adaptations mobile Planity :</h3>\n";
echo "<ul>\n";
echo "<li>📱 <strong>Container compact</strong> : Padding réduit, bordures arrondies</li>\n";
echo "<li>📝 <strong>Inputs touch-friendly</strong> : 48px min-height, font-size 16px</li>\n";
echo "<li>🔘 <strong>Labels optimisés</strong> : Taille et position adaptées</li>\n";
echo "<li>📞 <strong>Téléphone mobile</strong> : Flag container compact</li>\n";
echo "<li>✅ <strong>Checkbox mobile</strong> : Taille et espacement optimisés</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎯 Comportement attendu</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Étape informations Planity parfaite :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📝 <strong>Design épuré</strong> : Container blanc, bordures subtiles</li>\n";
echo "<li>🎨 <strong>Palette moderne</strong> : Slate neutre cohérente</li>\n";
echo "<li>✨ <strong>Animations fluides</strong> : Labels flottants modernes</li>\n";
echo "<li>📞 <strong>Téléphone intégré</strong> : Design cohérent épuré</li>\n";
echo "<li>📱 <strong>Mobile parfait</strong> : Touch-friendly optimisé</li>\n";
echo "<li>🚀 <strong>UX premium</strong> : Expérience Planity authentique</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<h2>🎉 Résultat final</h2>\n";

echo "<div style='background:#e8f5e8;padding:20px;border-left:4px solid #4caf50;margin:20px 0;'>\n";
echo "<h3>✅ Étape \"Vos informations\" style Planity parfaite :</h3>\n";
echo "<ul style='font-size:16px;line-height:1.6;'>\n";
echo "<li>📝 <strong>Ultra-moderne</strong> : Design Planity authentique</li>\n";
echo "<li>🎨 <strong>Épuré minimaliste</strong> : Palette slate cohérente</li>\n";
echo "<li>✨ <strong>Animations premium</strong> : Micro-interactions fluides</li>\n";
echo "<li>📞 <strong>Téléphone intégré</strong> : Design cohérent moderne</li>\n";
echo "<li>📱 <strong>Responsive parfait</strong> : Mobile et desktop optimisés</li>\n";
echo "<li>🚀 <strong>UX exceptionnelle</strong> : Expérience utilisateur premium</li>\n";
echo "</ul>\n";
echo "</div>\n";

echo "<p style='text-align:center;font-size:18px;color:#4caf50;font-weight:bold;'>📝 Étape \"Vos informations\" style Planity parfaitement modernisée ! 🎯</p>\n";
?>
