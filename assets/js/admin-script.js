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
