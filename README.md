# Institut Booking – Plugin WordPress de Réservation

Un plugin WordPress complet pour la gestion de réservations avec employés, services, clients, calendrier, notifications, coupons, et bien plus.  
Idéal pour instituts de beauté, salons, cabinets, ou toute activité nécessitant la prise de rendez-vous en ligne.

---

## 🚀 Fonctionnalités principales

- **Formulaire de réservation moderne** (shortcode) : choix du service, de l’employé, date/heure, validation, confirmation.
- **Gestion des employés** : disponibilité, affectation aux services, couleurs personnalisées.
- **Gestion des services** : durée, prix, catégories, extras.
- **Gestion des clients** : historique, recherche, édition.
- **Calendrier interactif** : vue admin, synchronisation Google/Outlook.
- **Notifications** : emails, cloche admin, SMS, WhatsApp (optionnel).
- **Coupons & promotions** : codes de réduction, gestion des usages.
- **Statistiques & analytics** : tableaux de bord, exports.
- **Interface d’administration moderne** : responsive, intuitive, personnalisable.
- **Internationalisation** : prêt pour la traduction (français inclus).
- **Sécurité** : validation, nonce, contrôle des rôles.

---

## 📦 Installation

1. **Téléversez** le dossier du plugin dans `wp-content/plugins/`.
2. **Activez** le plugin dans l’admin WordPress.
3. Rendez-vous dans le menu **Institut Booking** pour la configuration.

---

## 📝 Utilisation

### **Formulaire de réservation côté client**

Ajoutez le shortcode suivant dans une page ou un article :

`[institut_booking_form]`

Le formulaire s’affichera automatiquement, avec gestion dynamique des créneaux et validation.

---

### **Administration**

- Accédez à l’interface via le menu **Institut Booking** dans l’admin WordPress.
- Gérez : services, employés, réservations, clients, extras, coupons, notifications, paramètres, etc.
- Visualisez et filtrez les réservations dans le calendrier ou la liste.
- Recevez des notifications en temps réel (cloche, email, SMS, WhatsApp).

---

## 🛠️ Structure du projet

```
mon-plugin-booking/
│
├── institut-booking.php           # Fichier principal du plugin (point d’entrée)
├── includes/                      # Classes métier (réservations, clients, employés, etc.)
├── admin/                         # Pages et composants de l’interface d’administration
├── assets/                        # CSS, JS, images
├── partials/                      # Fragments HTML/PHP pour l’UI
├── templates/                     # Templates pour le front
├── languages/                     # Fichiers de traduction
└── ...                            # Fichiers utilitaires et scripts divers
```
