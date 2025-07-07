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
      window.ib_ajax && window.ib_ajax.ajaxurl ? window.ib_ajax.ajaxurl : false;
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

document.addEventListener("DOMContentLoaded", function () {
  console.log("Cloche notifications : JS chargé");
  // === Notifications internes back-office ===
  (function () {
    const bell = document.getElementById("ib-notif-bell");
    const badge = document.getElementById("ib-notif-badge");
    const dropdown = document.getElementById("ib-notif-dropdown");
    const notifList = document.getElementById("ib-notif-list");
    const notifEmpty = document.getElementById("ib-notif-empty");
    const markAllBtn = document.getElementById("ib-notif-mark-all");
    let notifOpen = false;
    let notifLoading = false;
    let notifTimer = null;

    function fetchNotifications() {
      notifLoading = true;
      badge.style.display = "none";
      notifList.innerHTML =
        '<div style="text-align:center;padding:1.2em 0;color:#bfa2c7;">Chargement...</div>';
      notifEmpty.style.display = "none";
      console.log(
        "Cloche : fetchNotifications lancé",
        typeof ajaxurl !== "undefined" ? ajaxurl : "ajaxurl non défini"
      );
      fetch(ajaxurl + "?action=ib_get_notifications", {
        credentials: "same-origin",
      })
        .then((r) => r.json())
        .then((res) => {
          notifLoading = false;
          if (!res.success) {
            console.log("Cloche : fetchNotifications erreur", res);
            return;
          }
          const notifs = res.data.recent;
          const unreadCount = res.data.unread_count;
          // Badge
          if (unreadCount > 0) {
            badge.textContent = unreadCount;
            badge.style.display = "block";
            bell.classList.add("ib-notif-bell-anim");
            setTimeout(() => bell.classList.remove("ib-notif-bell-anim"), 600);
          } else {
            badge.style.display = "none";
          }
          // Liste
          if (notifs.length === 0) {
            notifList.innerHTML = "";
            notifEmpty.style.display = "block";
          } else {
            notifEmpty.style.display = "none";
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
                  <div style="color:#bfa2c7;font-size:0.92em;margin-top:0.2em;">${n.created_at
                    .replace("T", " ")
                    .slice(0, 16)}</div>
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
    }

    function markAsRead(id) {
      console.log("Cloche : markAsRead", id);
      fetch(ajaxurl, {
        method: "POST",
        credentials: "same-origin",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=ib_mark_notification_read&id=" + encodeURIComponent(id),
      }).then(() => fetchNotifications());
    }
    function markAllAsRead() {
      console.log("Cloche : markAllAsRead");
      fetch(ajaxurl, {
        method: "POST",
        credentials: "same-origin",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=ib_mark_all_notifications_read",
      }).then(() => fetchNotifications());
    }

    // Dropdown toggle
    bell.addEventListener("click", function (e) {
      e.stopPropagation();
      notifOpen = !notifOpen;
      dropdown.style.display = notifOpen ? "block" : "none";
      if (notifOpen) {
        console.log("Cloche : ouverture dropdown");
        fetchNotifications();
      }
    });
    // Fermer au clic extérieur
    document.addEventListener("click", function (e) {
      if (
        notifOpen &&
        !dropdown.contains(e.target) &&
        !bell.contains(e.target)
      ) {
        dropdown.style.display = "none";
        notifOpen = false;
        console.log("Cloche : fermeture dropdown (clic extérieur)");
      }
    });
    // Marquer tout comme lu
    markAllBtn.addEventListener("click", function (e) {
      e.preventDefault();
      markAllAsRead();
    });
    // Marquer une notif comme lue au clic
    notifList.addEventListener("click", function (e) {
      const item = e.target.closest(".ib-notif-item");
      if (item && item.classList.contains("ib-notif-unread")) {
        markAsRead(item.dataset.id);
      }
    });
    // Rafraîchissement auto
    function startNotifPolling() {
      notifTimer = setInterval(fetchNotifications, 30000);
    }
    function stopNotifPolling() {
      if (notifTimer) clearInterval(notifTimer);
    }
    startNotifPolling();
    // Premier chargement badge
    fetchNotifications();
  })();
});
