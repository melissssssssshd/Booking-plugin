// Toast auto-hide
window.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".ib-toast").forEach(function (toast) {
    if (toast.style.display === "block") {
      setTimeout(function () {
        toast.style.display = "none";
      }, 3500);
    }
  });
});

// Fonctions critiques globales pour le formulaire de réservation
window.formatDateToMysql = function (dateStr) {
  // Format attendu : DD/MM/YYYY ou selon flatpickr, à adapter si besoin
  if (!dateStr) return "";
  const parts = dateStr.split("/");
  if (parts.length === 3) {
    // DD/MM/YYYY => YYYY-MM-DD
    return `${parts[2]}-${parts[1].padStart(2, "0")}-${parts[0].padStart(
      2,
      "0"
    )}`;
  }
  // Si déjà au format YYYY-MM-DD
  return dateStr;
};

if (typeof window.wp === "undefined" || !window.wp || !window.wp.data) {
  // Pas dans l'admin
  window.updateTimeSlots = function () {
    // Désactivé côté front pour éviter les conflits avec le formulaire moderne
    return;
  };
} else {
  window.updateTimeSlots = function () {
    // Sélection des éléments DOM
    const dateInput = document.querySelector("#ib-booking-date");
    const serviceInput = document.querySelector("#ib-service-select");
    const employeeInput = document.querySelector("#ib-employee-select");
    const slotsContainer = document.querySelector("#ib-time-slots");
    if (!dateInput || !serviceInput || !employeeInput || !slotsContainer) {
      console.error(
        "Un des éléments requis pour updateTimeSlots est manquant."
      );
      return;
    }
    const date = window.formatDateToMysql(dateInput.value);
    const service = serviceInput.value;
    const employee = employeeInput.value;
    if (!date || !service || !employee) {
      slotsContainer.innerHTML =
        '<span style="color:#888">Veuillez sélectionner un service, un employé et une date.</span>';
      return;
    }
    slotsContainer.innerHTML = "Chargement des créneaux...";
    // Utilisation de la variable ajaxurl injectée
    const ajaxurl =
      window.ib_admin_vars && window.ib_admin_vars.ajaxurl
        ? window.ib_admin_vars.ajaxurl
        : window.IBNotifBell && window.IBNotifBell.ajaxurl
        ? window.IBNotifBell.ajaxurl
        : false;
    if (!ajaxurl) {
      slotsContainer.innerHTML =
        '<span style="color:#d32f2f">Erreur critique : ajaxurl non défini.</span>';
      console.error("ajaxurl non défini");
      return;
    }
    fetch(ajaxurl + "?action=ib_get_time_slots", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `date=${encodeURIComponent(date)}&service_id=${encodeURIComponent(
        service
      )}&employee_id=${encodeURIComponent(employee)}`,
    })
      .then((r) => r.json())
      .then((data) => {
        if (data.success && Array.isArray(data.data)) {
          if (data.data.length === 0) {
            slotsContainer.innerHTML =
              '<span style="color:#888">Aucun créneau disponible ce jour.</span>';
          } else {
            slotsContainer.innerHTML = data.data
              .map(
                (slot) =>
                  `<button type="button" class="ib-slot-btn" data-time="${slot}" onclick="selectTimeSlot(this)">${slot}</button>`
              )
              .join(" ");
          }
        } else {
          slotsContainer.innerHTML =
            '<span style="color:#d32f2f">Erreur lors du chargement des créneaux.</span>';
          console.error("Erreur AJAX:", data);
        }
      })
      .catch((e) => {
        slotsContainer.innerHTML =
          '<span style="color:#d32f2f">Erreur AJAX.</span>';
        console.error("Erreur AJAX:", e);
      });
  };
}

window.selectTimeSlot = function (btn) {
  document
    .querySelectorAll(".ib-slot-btn")
    .forEach((b) => b.classList.remove("selected"));
  btn.classList.add("selected");
  const timeInput = document.querySelector("#ib-booking-time");
  if (timeInput) timeInput.value = btn.dataset.time;
};

// TODO: Ajout dynamique des créneaux horaires selon le service et l'employé

// Prevent multiple initialization
if (!window.ibNotificationsInitialized) {
  window.ibNotificationsInitialized = true;
  document.addEventListener("DOMContentLoaded", function () {
    // === Notifications internes back-office ===
    // DÉSACTIVÉ : Le système de notifications est maintenant géré par ultra-simple-notification.js
    // Ce système est plus moderne et évite les conflits

    console.log('🔔 Système de notifications admin-script.js désactivé');
    console.log('✅ ultra-simple-notification.js gère maintenant les notifications');

    // Exposer une fonction vide pour la compatibilité
    window.fetchNotifications = function() {
      console.log('🔄 fetchNotifications redirigé vers ultra-simple-notification.js');
      if (typeof window.loadRealNotifications === 'function') {
        window.loadRealNotifications();
      }
    };

    return; // Arrêter l'exécution du reste du code

    // === CODE DÉSACTIVÉ ===
    /*
    // Attendre que ultra-simple-notification.js crée la cloche
    setTimeout(() => {
      const bell = document.querySelector(".notification-bell");
      const badge = document.querySelector(".notification-badge");
      const modal = document.getElementById("simple-notification-modal");
      const notifList = document.getElementById("notification-content");
      const markAllBtn = document.querySelector("button[onclick*='clearAllNotifications']");

      console.log('🔍 Éléments trouvés:', {
        bell: !!bell,
        badge: !!badge,
        modal: !!modal,
        notifList: !!notifList,
        markAllBtn: !!markAllBtn
      });

      let notifOpen = false;
      let notifLoading = false;
      let notifTimer = null;

      // Fonction pour obtenir l'URL AJAX en priorisant les différentes sources
      const getAjaxUrl = () => {
        // 1. Essayer avec ib_notif_vars (nouvelle méthode)
        if (typeof ib_notif_vars !== 'undefined' && ib_notif_vars.ajaxurl) {
          return ib_notif_vars.ajaxurl;
        }
        // 2. Essayer avec IBNotifBell (ancienne méthode)
        if (typeof IBNotifBell !== 'undefined' && IBNotifBell.ajaxurl) {
          return IBNotifBell.ajaxurl;
        }
        // 3. URL par défaut
        return "/wp-admin/admin-ajax.php";
      };

      // Fonction pour obtenir le nonce en priorisant les différentes sources
      const getNonce = () => {
        // 1. Essayer avec ib_notif_vars (nouvelle méthode)
        if (typeof ib_notif_vars !== 'undefined' && ib_notif_vars.nonce) {
          return ib_notif_vars.nonce;
        }
        // 2. Essayer avec IBNotifBell (ancienne méthode)
        if (typeof IBNotifBell !== 'undefined' && IBNotifBell.nonce) {
          return IBNotifBell.nonce;
        }
        // 3. Aucun nonce trouvé
        console.error('Aucun nonce trouvé pour les notifications');
        return null;
      };

      // Exposer la fonction globalement pour le script de fix
      window.fetchNotifications = function fetchNotifications() {
        notifLoading = true;
        if (notifList)
          notifList.innerHTML =
            '<div style="text-align:center;padding:1.2em 0;color:#bfa2c7;">Chargement...</div>';
        if (notifEmpty) notifEmpty.style.display = "none";
        console.log("Cloche : fetchNotifications lancé", getAjaxUrl());

        var nonce = getNonce();
        if (!nonce) {
          if (notifList)
            notifList.innerHTML =
              '<div style="color:#d32f2f;padding:1em;">Erreur critique : IBNotifBell.nonce non défini.<br>Impossible de charger les notifications.</div>';
          console.error("Cloche : IBNotifBell.nonce non défini");
          notifLoading = false;
          return;
        }

      const ajaxUrl = getAjaxUrl();
      const requestBody = new URLSearchParams({
        action: 'ib_get_notifications',
        nonce: nonce,
        _ajax_nonce: nonce // Ajout pour compatibilité
      });

      fetch(ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: requestBody
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Erreur HTTP: ${response.status}`);
        }
        return response.json();
      })
      .then((res) => {
        notifLoading = false;
        console.log('Réponse complète des notifications:', JSON.stringify(res, null, 2));
        console.log('Données brutes des notifications:', res.data);
        console.log('Notifications récentes:', res.data && res.data.recent ? res.data.recent : 'Aucune notification récente');
        console.log('Nombre de notifications non lues:', res.data && res.data.unread_count ? res.data.unread_count : 0);
        
        if (!res || res.success === false) {
          const errorMsg = res && res.data && res.data.message 
            ? res.data.message 
            : 'Réponse invalide du serveur';
          
          console.error('Erreur lors du chargement des notifications:', errorMsg);
          
          if (notifList) {
            notifList.innerHTML = `
              <div style="color:#d32f2f;padding:1em;">
                Erreur lors du chargement des notifications: ${errorMsg}
              </div>`;
          }
          return;
        }

        // Traitement des notifications reçues
        console.log('Type de res.data:', typeof res.data);
        console.log('res.data.recent existe?', res.data && res.data.recent);
        console.log('Type de res.data.recent:', res.data && typeof res.data.recent);
        console.log('res.data.recent est un tableau?', res.data && Array.isArray(res.data.recent));
        console.log('Contenu de res.data.recent:', res.data && res.data.recent);

        const notifs = res.data && Array.isArray(res.data.recent) ? res.data.recent : [];
        const unreadCount = res.data && typeof res.data.unread_count === 'number'
          ? res.data.unread_count
          : 0;

        console.log('Notifications récupérées:', notifs);
        console.log('Nombre de notifications:', notifs.length);

        // Mise à jour du badge
        if (badge) {
          if (unreadCount > 0) {
            badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
            badge.style.display = 'block';
            if (bell) bell.classList.add('ib-notif-bell-anim');
            setTimeout(() => {
              if (bell) bell.classList.remove('ib-notif-bell-anim');
            }, 600);
          } else {
            badge.style.display = 'none';
          }
        }

        // Mise à jour de la liste des notifications
        if (!notifs.length) {
          if (notifList) notifList.innerHTML = '';
          if (notifEmpty) notifEmpty.style.display = 'block';
          return;
        }

        if (notifEmpty) notifEmpty.style.display = 'none';
        if (notifList) {
          notifList.innerHTML = notifs.map(notif => `
            <div class="ib-notif-item${notif.status === 'unread' ? ' ib-notif-unread' : ''}"
                 data-id="${notif.id}"
                 style="padding:0.7em 0.5em 0.7em 0.7em;border-radius:12px;margin-bottom:0.5em;display:flex;align-items:flex-start;gap:0.7em;cursor:pointer;transition:background 0.15s;${notif.status === 'unread' ? 'background:#fbeff3;' : ''}">
              <div style="flex:1;">
                <div style="font-weight:600;color:#e9aebc;font-size:1em;">
                  ${notif.type === 'reservation' || notif.type === 'booking_new' ? 'Nouvelle réservation' : notif.type}
                </div>
                <div style="color:#22223b;font-size:0.98em;">
                  ${notif.message || 'Aucun message'}
                </div>
                <div style="color:#bfa2c7;font-size:0.92em;margin-top:0.2em;">
                  ${notif.created_at ? notif.created_at.replace('T', ' ').slice(0, 16) : ''}
                </div>
              </div>
              ${notif.link ? `<a href="${notif.link}" target="_blank" style="margin-left:0.5em;color:#bfa2c7;font-size:1.2em;">→</a>` : ''}
            </div>
          `).join('');

          // Ajout des gestionnaires d'événements
          notifList.querySelectorAll('.ib-notif-item').forEach(item => {
            const id = item.getAttribute('data-id');
            if (id) {
              item.addEventListener('click', () => markAsRead(id));
            }
          });
        }
          // Badge
          if (unreadCount > 0) {
            if (badge) badge.textContent = unreadCount;
            if (badge) badge.style.display = "block";
            if (bell) bell.classList.add("ib-notif-bell-anim");
            setTimeout(() => {
              if (bell) bell.classList.remove("ib-notif-bell-anim");
            }, 600);
          } else {
            if (badge) badge.style.display = "none";
          }
          // Liste
          if (!Array.isArray(notifs) || notifs.length === 0) {
            if (notifList) notifList.innerHTML = "";
            if (notifEmpty) notifEmpty.style.display = "block";
          } else {
            if (notifEmpty) notifEmpty.style.display = "none";
            if (notifList)
              notifList.innerHTML = notifs
                .map(
                  (n) =>
                    `<div class="ib-notif-item${
                      n.status === "unread" ? " ib-notif-unread" : ""
                    }" data-id="${
                      n.id
                    }" style="padding:0.7em 0.5em 0.7em 0.7em;border-radius:12px;margin-bottom:0.5em;display:flex;align-items:flex-start;gap:0.7em;cursor:pointer;transition:background 0.15s;${
                      n.status === "unread" ? "background:#fbeff3;" : ""
                    }">
                <div style="flex:1;">
                  <div style="font-weight:600;color:#e9aebc;font-size:1em;">${
                    n.type === "reservation" ? "Nouvelle réservation" : n.type
                  }</div>
                  <div style="color:#22223b;font-size:0.98em;">${
                    n.message
                  }</div>
                  <div style="color:#bfa2c7;font-size:0.92em;margin-top:0.2em;">${
                    n.created_at && typeof n.created_at === "string"
                      ? n.created_at.replace("T", " ").slice(0, 16)
                      : ""
                  }</div>
                </div>
                ${
                  n.link
                    ? `<a href="${n.link}" target="_blank" style="margin-left:0.5em;color:#bfa2c7;font-size:1.2em;">→</a>`
                    : ""
                }
              </div>`
                )
                .join("");
          }
          console.log("Cloche : notifications reçues", notifs);
        })
        .catch((e) => {
          console.log("Cloche : fetchNotifications AJAX error", e);
        });
      };

      function markAsRead(id) {
        console.log("Cloche : markAsRead", id);
        var nonce = getNonce();
        fetch(getAjaxUrl(), {
          method: "POST",
          credentials: "same-origin",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body:
          "action=ib_mark_notification_read&id=" +
          encodeURIComponent(id) +
          "&nonce=" +
          encodeURIComponent(nonce),
      }).then(() => fetchNotifications());
    }
      function markAllAsRead() {
        console.log("Cloche : markAllAsRead");
        var nonce = getNonce();
        fetch(getAjaxUrl(), {
          method: "POST",
          credentials: "same-origin",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body:
            "action=ib_mark_all_notifications_read&nonce=" +
            encodeURIComponent(nonce),
        }).then(() => fetchNotifications());
      }

      // Dropdown toggle - DÉSACTIVÉ : géré par notification-bell-fix.js
      // Note: La gestion de la cloche est maintenant dans notification-bell-fix.js
      // pour éviter les conflits d'événements

      /*
      if (bell) {
        const bellBtn = bell.querySelector(".ib-notif-bell-btn");
        if (bellBtn) {
          bellBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notifOpen = !notifOpen;
            if (dropdown) {
              if (notifOpen) {
                dropdown.style.display = "block";
                dropdown.classList.add("show");
                console.log("Cloche : ouverture dropdown");
                fetchNotifications();
              } else {
                dropdown.classList.remove("show");
                setTimeout(() => {
                  dropdown.style.display = "none";
                }, 300); // Délai pour l'animation
              }
            }
          });
        }
      }
      // Fermer au clic extérieur
      document.addEventListener("click", function (e) {
        if (
          notifOpen &&
          dropdown &&
          !dropdown.contains(e.target) &&
          bell &&
          !bell.contains(e.target)
        ) {
          dropdown.classList.remove("show");
          setTimeout(() => {
            dropdown.style.display = "none";
          }, 300);
          notifOpen = false;
          console.log("Cloche : fermeture dropdown (clic extérieur)");
        }
      });
      */
      // Marquer tout comme lu
      if (markAllBtn) {
        markAllBtn.addEventListener("click", function (e) {
          e.preventDefault();
          markAllAsRead();
        });
      }
      // Marquer une notif comme lue au clic
      if (notifList) {
        notifList.addEventListener("click", function (e) {
          const item = e.target.closest(".ib-notif-item");
          if (item && item.classList.contains("ib-notif-unread")) {
            markAsRead(item.dataset.id);
          }
        });
      }
      // Rafraîchissement auto
      function startNotifPolling() {
        notifTimer = setInterval(window.fetchNotifications, 30000);
      }
      function stopNotifPolling() {
        if (notifTimer) clearInterval(notifTimer);
      }
      startNotifPolling();
      // Premier chargement badge
      fetchNotifications();
    }, 1000); // Attendre 1 seconde que ultra-simple-notification.js crée la cloche
    
    // === FIN CODE DÉSACTIVÉ ===
  }
