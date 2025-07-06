console.log("typeof jQuery:", typeof jQuery);
console.log(
  "typeof jQuery.ajax:",
  typeof jQuery !== "undefined" ? typeof jQuery.ajax : "undefined"
);

var bookingState = {
  step: 1,
  selectedCategory: "ALL",
  selectedService: null,
  selectedEmployee: null,
  selectedDate: null,
  selectedSlot: null,
  services: window.bookingServices || [],
  employees: window.bookingEmployees || [],
  client: {
    firstname: "",
    lastname: "",
    email: "",
    phone: "",
  },
};

// Fonction pour mettre à jour l'état
function updateBookingState() {
  // Sauvegarde l'état dans le localStorage pour la persistance
  localStorage.setItem("bookingState", JSON.stringify(bookingState));
}

// Récupération de l'état sauvegardé si il existe
localStorage.removeItem("bookingState"); // Reset du localStorage à chaque chargement
const savedState = localStorage.getItem("bookingState");
if (savedState) {
  Object.assign(bookingState, JSON.parse(savedState));
}

// Fonction pour naviguer entre les étapes
function goToStep(step) {
  bookingState.step = step;
  // Reset complet si retour à l'étape 1
  if (step === 1) {
    bookingState.selectedService = null;
    bookingState.selectedEmployee = null;
    bookingState.selectedDate = null;
    bookingState.selectedSlot = null;
    bookingState.client = { firstname: "", lastname: "", email: "", phone: "" };
    localStorage.removeItem("bookingState");
  }
  updateBookingState();
  renderStepContent();
  renderActions();
}

// Fonction pour rendre le contenu de l'étape actuelle
function renderStepContent() {
  const content = document.getElementById("booking-step-content");
  console.log(
    "renderStepContent appelé, content existe?",
    !!content,
    "step:",
    bookingState.step
  );
  if (!content) return;
  content.innerHTML = "";
  let inner = "";
  switch (bookingState.step) {
    case 1:
      inner = `
        <div class='booking-main-content'>
          <div class="categories">
            <h2>Catégorie</h2>
            <div class="buttons" id="category-buttons"></div>
          </div>
          <div class="services">
            <h2>Service</h2>
            <div class="grid" id="services-grid"></div>
          </div>
        </div>
      `;
      content.innerHTML = inner;
      renderCategoryButtons();
      renderServicesGrid();
      break;
    case 2:
      inner = `<div class='booking-main-content'><h2 class='text-center mb-6'>Choisissez votre employé</h2><div class="grid" id="employees-grid"></div></div>`;
      content.innerHTML = inner;
      renderEmployeesGrid();
      break;
    case 3:
      inner = `<div class='booking-main-content'>
        <div class="booking-step-date-modern">
          <div class="calendar-col">
            <div class="calendar-inner-card">
              <h2 class="text-2xl font-bold text-pink-400 mb-4 text-center">Date & Time</h2>
              <div id="calendar-header" class="mb-2"></div>
              <div id="calendar-days"></div>
            </div>
          </div>
          <div class="slots-col">
            <h3>Créneaux disponibles</h3>
            <div id="slots-list"></div>
          </div>
        </div>
      </div>`;
      content.innerHTML = inner;
      renderModernCalendar();
      renderModernSlotsList();
      break;
    case 4:
      inner = `<div class='booking-main-content'>
        <div class="booking-step-infos-modern bg-white rounded-2xl shadow-xl p-8 max-w-lg mx-auto">
          <h2 class="text-2xl font-bold text-pink-400 mb-6 text-center">Vos informations</h2>
          <form id="booking-client-form">
            <div class="input-group-modern">
              <input id="client-firstname" class="booking-input-modern peer" type="text" placeholder=" " required value="${
                bookingState.client.firstname || ""
              }" />
              <label for="client-firstname" class="floating-label-modern">Prénom</label>
              <span class="input-icon-modern" aria-hidden="true">
                <svg width="20" height="20" fill="none" stroke="#e9aebc" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
              </span>
            </div>
            <div class="input-group-modern">
              <input id="client-lastname" class="booking-input-modern peer" type="text" placeholder=" " required value="${
                bookingState.client.lastname || ""
              }" />
              <label for="client-lastname" class="floating-label-modern">Nom</label>
              <span class="input-icon-modern" aria-hidden="true">
                <svg width="20" height="20" fill="none" stroke="#e9aebc" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
              </span>
            </div>
            <div class="input-group-modern">
              <input id="client-email" class="booking-input-modern peer" type="email" placeholder=" " required value="${
                bookingState.client.email || ""
              }" />
              <label for="client-email" class="floating-label-modern">Email</label>
              <span class="input-icon-modern" aria-hidden="true">
                <svg width="20" height="20" fill="none" stroke="#e9aebc" stroke-width="1.7" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="3"/><path d="M2 6l10 7l10-7"/></svg>
              </span>
            </div>
            <div class="input-group-modern">
              <input id="client-phone" class="booking-input-modern peer" type="tel" placeholder=" " required value="${
                bookingState.client.phone || ""
              }" />
              <label for="client-phone" class="floating-label-modern">Téléphone</label>
              <span class="input-icon-modern" aria-hidden="true">
                <svg width="20" height="20" fill="none" stroke="#e9aebc" stroke-width="1.7" viewBox="0 0 24 24"><path d="M2 5.5A2.5 2.5 0 0 1 4.5 3h2A2.5 2.5 0 0 1 9 5.5v1A2.5 2.5 0 0 1 6.5 9h-2A2.5 2.5 0 0 1 2 6.5v-1z"/><path d="M15 19h2a2.5 2.5 0 0 0 2.5-2.5v-1A2.5 2.5 0 0 0 17 13h-2a2.5 2.5 0 0 0-2.5 2.5v1A2.5 2.5 0 0 0 15 19z"/><path d="M7 7l10 10"/></svg>
              </span>
            </div>
            <div class="flex items-center gap-2 mt-4 mb-4">
              <input id="client-privacy" type="checkbox" required style="accent-color:#e9aebc;width:1.1em;height:1.1em;" />
              <label for="client-privacy" class="text-[11px] text-gray-600 select-none">J'accepte les <a href="#" id="show-terms" class="underline text-pink-400 hover:text-pink-600">conditions générales</a> et la <a href="#" id="show-privacy" class="underline text-pink-400 hover:text-pink-600">politique de confidentialité</a>.</label>
            </div>
            <div class="flex justify-center mt-4">
              <button type="submit" class="btn-modern">Valider la réservation</button>
            </div>
          </form>
        </div>
      </div>`;
      content.innerHTML = inner;
      setTimeout(() => {
        const form = document.getElementById("booking-client-form");
        if (form) {
          // Modal Conditions Générales
          if (!document.getElementById("terms-modal")) {
            const modal = document.createElement("div");
            modal.id = "terms-modal";
            modal.style =
              "display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);align-items:center;justify-content:center;";
            modal.innerHTML = `<div style='background:#fff;max-width:480px;width:90vw;padding:2em 1.5em;border-radius:1.2em;box-shadow:0 8px 32px #e9aebc55;position:relative;'>
              <button id='close-terms-modal' style='position:absolute;top:0.7em;right:1em;font-size:1.5em;background:none;border:none;cursor:pointer;'>&times;</button>
              <h3 style='color:#e9aebc;font-size:1.2em;margin-bottom:1em;'>✅ Conditions Générales de Réservation</h3>
              <div style='font-size:0.97em;line-height:1.6;color:#555;text-align:left;max-height:60vh;overflow-y:auto;'>
                En validant votre rendez-vous, vous acceptez les conditions suivantes :<br><br>
                Vos informations personnelles sont utilisées uniquement pour organiser et confirmer votre réservation.<br><br>
                Vous pouvez modifier ou annuler votre rendez-vous à tout moment en nous contactant directement.<br><br>
                Toute utilisation de ce service implique le respect de nos modalités de réservation.<br>
              </div>
            </div>`;
            document.body.appendChild(modal);
            document.getElementById("show-terms").onclick = function (e) {
              e.preventDefault();
              modal.style.display = "flex";
            };
            document.getElementById("close-terms-modal").onclick = function () {
              modal.style.display = "none";
            };
          }
          // Modal Politique de Confidentialité
          if (!document.getElementById("privacy-modal")) {
            const modal = document.createElement("div");
            modal.id = "privacy-modal";
            modal.style =
              "display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);align-items:center;justify-content:center;";
            modal.innerHTML = `<div style='background:#fff;max-width:480px;width:90vw;padding:2em 1.5em;border-radius:1.2em;box-shadow:0 8px 32px #e9aebc55;position:relative;'>
              <button id='close-privacy-modal' style='position:absolute;top:0.7em;right:1em;font-size:1.5em;background:none;border:none;cursor:pointer;'>&times;</button>
              <h3 style='color:#e9aebc;font-size:1.2em;margin-bottom:1em;'>🔐 Politique de Confidentialité</h3>
              <div style='font-size:0.97em;line-height:1.6;color:#555;text-align:left;max-height:60vh;overflow-y:auto;'>
                Dans le respect de la législation en vigueur, nous nous engageons à protéger vos données personnelles :<br><br>
                Les données que vous fournissez (nom, prénom, téléphone, email) sont traitées de manière sécurisée, dans le seul objectif de gérer votre rendez-vous.<br><br>
                Elles ne seront jamais partagées, vendues ni utilisées à des fins commerciales sans votre consentement explicite.<br><br>
                Vous disposez à tout moment d'un droit d'accès, de rectification et de suppression de vos données, sur simple demande.<br>
              </div>
            </div>`;
            document.body.appendChild(modal);
            document.getElementById("show-privacy").onclick = function (e) {
              e.preventDefault();
              modal.style.display = "flex";
            };
            document.getElementById("close-privacy-modal").onclick =
              function () {
                modal.style.display = "none";
              };
          }
          form.onsubmit = function (e) {
            e.preventDefault();
            const firstname = document
              .getElementById("client-firstname")
              .value.trim();
            const lastname = document
              .getElementById("client-lastname")
              .value.trim();
            const email = document.getElementById("client-email").value.trim();
            const phone = document.getElementById("client-phone").value.trim();
            const privacy = document.getElementById("client-privacy").checked;
            if (!firstname || !lastname || !email || !phone) {
              showBookingNotification("Merci de remplir tous les champs.");
              return false;
            }
            if (!privacy) {
              showBookingNotification(
                "Vous devez accepter les conditions générales et la politique de confidentialité pour continuer."
              );
              return false;
            }
            bookingState.client = { firstname, lastname, email, phone };
            updateBookingState();
            // Envoi AJAX pour enregistrer la réservation
            jQuery.ajax({
              url: window.ajaxurl,
              type: "POST",
              data: {
                action: "add_booking",
                service_id: bookingState.selectedService.id,
                employee_id: bookingState.selectedEmployee.id,
                date: bookingState.selectedDate,
                slot: bookingState.selectedSlot,
                firstname,
                lastname,
                email,
                phone,
                nonce: window.ib_nonce,
              },
              success: function (response) {
                if (response.success) {
                  goToStep(5); // Afficher le ticket
                } else {
                  showBookingNotification(
                    "Erreur lors de la réservation : " +
                      (response.data && response.data.message
                        ? response.data.message
                        : "Erreur inconnue")
                  );
                }
              },
              error: function (xhr, status, error) {
                showBookingNotification(
                  "Erreur AJAX lors de la réservation : " + error
                );
              },
            });
            return false;
          };
        }
      }, 100);
      break;
    case 5:
      inner = `<div class='booking-main-content'>
        <div class="booking-ticket-modern">
          <div class="ticket-success-icon">
            <svg viewBox="0 0 48 48"><circle cx="24" cy="24" r="22" stroke="#e9aebc" stroke-width="3" fill="#fff"/><path d="M15 25l7 7 12-14" stroke="#b95c8a" stroke-width="3.2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="ticket-success-badge">Réservation Confirmée</div>
          <div class="ticket-success-message">Merci pour votre réservation !<br>Un email de confirmation vous a été envoyé.</div>
          <div class="ticket-details">
            <div><span class="ticket-label">Service :</span> <span class="ticket-value">${
              bookingState.selectedService?.name || "-"
            }</span></div>
            <div><span class="ticket-label">Employé :</span> <span class="ticket-value">${
              bookingState.selectedEmployee?.name || "-"
            }</span></div>
            <div><span class="ticket-label">Date :</span> <span class="ticket-value">${
              bookingState.selectedDate || "-"
            }</span></div>
            <div><span class="ticket-label">Créneau :</span> <span class="ticket-value">${
              bookingState.selectedSlot || "-"
            }</span></div>
            <div><span class="ticket-label">Client :</span> <span class="ticket-value">${
              bookingState.client?.firstname || "-"
            } ${bookingState.client?.lastname || "-"}</span></div>
            <div><span class="ticket-label">Email :</span> <span class="ticket-value">${
              bookingState.client?.email || "-"
            }</span></div>
            <div><span class="ticket-label">Téléphone :</span> <span class="ticket-value">${
              bookingState.client?.phone || "-"
            }</span></div>
          </div>
        </div>
      </div>`;
      content.innerHTML = inner;
      break;
  }
}

// Fonction pour rendre les actions (boutons)
function renderActions() {
  const actions = document.getElementById("booking-actions");
  actions.innerHTML = "";
  actions.className = "actions";

  if (bookingState.step > 1) {
    const back = document.createElement("button");
    back.className = "back";
    back.textContent = "← Retour";
    back.onclick = () => goToStep(bookingState.step - 1);
    actions.appendChild(back);
  }

  if (bookingState.step < 5) {
    const next = document.createElement("button");
    next.className = "next";
    next.innerHTML =
      "Suivant <strong>" +
      ["Employé", "Date & Heure", "Infos", "Ticket"][bookingState.step - 1] +
      " →</strong>";
    next.onclick = () => {
      if (bookingState.step === 1 && !bookingState.selectedService) {
        showBookingNotification("Sélectionnez un service.");
        return;
      }
      if (bookingState.step === 2 && !bookingState.selectedEmployee) {
        showBookingNotification("Sélectionnez un employé.");
        return;
      }
      if (
        bookingState.step === 3 &&
        (!bookingState.selectedDate || !bookingState.selectedSlot)
      ) {
        showBookingNotification("Sélectionnez une date et un créneau.");
        return;
      }
      if (
        bookingState.step === 4 &&
        (!bookingState.client.firstname ||
          !bookingState.client.lastname ||
          !bookingState.client.email ||
          !bookingState.client.phone)
      ) {
        showBookingNotification("Merci de remplir tous les champs.");
        return;
      }
      goToStep(bookingState.step + 1);
    };
    actions.appendChild(next);
  } else if (bookingState.step === 5) {
    const restart = document.createElement("button");
    restart.className = "next";
    restart.textContent = "Nouvelle réservation";
    restart.onclick = () => {
      bookingState = {
        step: 1,
        selectedCategory: "ALL",
        selectedService: null,
        selectedEmployee: null,
        selectedDate: null,
        selectedSlot: null,
        services: window.bookingServices || [],
        employees: window.bookingEmployees || [],
        client: {
          firstname: "",
          lastname: "",
          email: "",
          phone: "",
        },
      };
      goToStep(1);
    };
    actions.appendChild(restart);
  }
}

// Fonction pour rendre la grille de services
document.addEventListener("DOMContentLoaded", function () {
  console.log(
    "DOMContentLoaded: booking-step-content existe?",
    !!document.getElementById("booking-step-content")
  );
  console.log("Services:", bookingState.services);
  console.log("Employés:", bookingState.employees);
  document.querySelectorAll("#sidebar-steps li").forEach((li, idx) => {
    if (idx === 1) li.innerHTML = '<span class="icon">👤</span> Employé';
  });
  renderSidebar();
  renderStepContent();
  renderActions();
});

function renderSidebar() {
  document.querySelectorAll("#sidebar-steps li").forEach((li, idx) => {
    li.classList.toggle("active", idx === bookingState.step - 1);
  });
  // Toujours réappliquer la protection après chaque render
  setupSidebarStepProtection();
}

function renderCategoryButtons() {
  const btns = document.getElementById("category-buttons");
  btns.innerHTML = "";
  // Utilise la bonne propriété pour les catégories
  const cats = [
    "ALL",
    ...Array.from(
      new Set(bookingState.services.map((s) => s.category_name).filter(Boolean))
    ),
  ];
  console.log("Catégories générées:", cats);
  cats.forEach((cat) => {
    const btn = document.createElement("button");
    btn.textContent = cat;
    btn.title = cat;
    btn.className = cat === bookingState.selectedCategory ? "active" : "";
    btn.onclick = () => {
      bookingState.selectedCategory = cat;
      renderServicesGrid();
      renderCategoryButtons();
    };
    btns.appendChild(btn);
  });
}

function renderServicesGrid() {
  const grid = document.getElementById("services-grid");
  if (!grid) return;
  grid.innerHTML = "";
  console.log("Valeur de selectedCategory:", bookingState.selectedCategory);
  console.log(
    "Exemple de category_name:",
    bookingState.services[0]?.category_name
  );
  let filtered =
    bookingState.selectedCategory === "ALL"
      ? bookingState.services
      : bookingState.services.filter(
          (s) =>
            (s.category_name || "").trim() ===
            (bookingState.selectedCategory || "").trim()
        );
  console.log("Services à afficher:", filtered);
  if (filtered.length === 0) {
    grid.innerHTML =
      "<div style='padding:2em;text-align:center;color:#bfa2c7;'>Aucun service disponible</div>";
    return;
  }
  filtered.forEach((srv) => {
    const card = document.createElement("div");
    card.className =
      "card" +
      (bookingState.selectedService &&
      bookingState.selectedService.id === srv.id
        ? " selected"
        : "");
    card.onclick = () => {
      bookingState.selectedService = srv;
      console.log("Service sélectionné:", srv); // DEBUG
      goToStep(2);
    };
    let imgHtml = srv.image
      ? `<img src="${srv.image}" alt="${srv.name}">`
      : `<div class='avatar-placeholder'>🛠️</div>`;
    let priceText = "";
    if (srv.variable_price == 1) {
      if (srv.min_price && srv.min_price > 0)
        priceText =
          "À partir de " + Number(srv.min_price).toLocaleString() + " DA";
      else priceText = "Variable";
    } else if (typeof srv.price === "number" && !isNaN(srv.price)) {
      priceText = srv.price.toLocaleString() + " DA";
    } else if (typeof srv.price === "string" && srv.price.trim() !== "") {
      priceText = srv.price;
    } else {
      priceText = "Variable";
    }
    card.innerHTML = `
        ${imgHtml}
        <div>
            <h3>${srv.name}</h3>
            <p>Durée : <strong>${srv.duration} min</strong></p>
            <p class="price">${priceText}</p>
        </div>
    `;
    grid.appendChild(card);
  });
}

function renderEmployeesGrid() {
  const grid = document.getElementById("employees-grid");
  grid.innerHTML = "";
  if (!bookingState.selectedService) return;
  const employeeIds = (bookingState.selectedService.employee_ids || []).map(
    Number
  );
  const filtered = bookingState.employees.filter((e) =>
    employeeIds.includes(Number(e.id))
  );
  if (filtered.length === 0) {
    grid.innerHTML =
      '<div style="padding:2em;text-align:center;color:#bfa2c7;">Aucun employé pour ce service</div>';
    return;
  }
  filtered.forEach((emp) => {
    const card = document.createElement("div");
    card.className =
      "employee-card-modern flex flex-col items-center justify-center bg-white rounded-xl shadow-md p-5 m-2 transition-all duration-150 cursor-pointer" +
      (bookingState.selectedEmployee &&
      bookingState.selectedEmployee.id === emp.id
        ? " border-2 border-pink-300 ring-2 ring-pink-100"
        : " hover:shadow-xl hover:bg-pink-50");
    card.onclick = () => {
      bookingState.selectedEmployee = emp;
      renderEmployeesGrid();
    };
    let imgHtml = emp.photo
      ? `<span style='display:flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#fbeff3;box-shadow:0 2px 12px #e9aebc33;'><img src="${emp.photo}" alt="${emp.name}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;"></span>`
      : `<span style='display:flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#fbeff3;color:#bfa2c7;font-size:2.1rem;box-shadow:0 2px 12px #e9aebc33;'><svg width="40" height="40" fill="none" stroke="#e9aebc" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg></span>`;
    card.innerHTML = `
      ${imgHtml}
      <div class="mt-3 text-center">
        <div class="font-bold text-pink-400 text-base mb-1">${emp.name}</div>
        <div class="text-xs text-gray-500">${emp.specialty || "Employé"}</div>
      </div>
    `;
    grid.appendChild(card);
  });
}

function renderModernCalendar() {
  const cal = document.getElementById("calendar-days");
  const header = document.getElementById("calendar-header");
  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const weekDays = ["L", "M", "M", "J", "V", "S", "D"];
  if (!window.calendarState)
    window.calendarState = {
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
    };
  header.innerHTML = `
    <button id='prev-month'>&lt;</button>
    <span style='font-weight:600;font-size:1.1em;display:inline-block;min-width:120px;text-align:center;'>${monthNames[
      window.calendarState.month
    ].toUpperCase()} ${window.calendarState.year}</span>
    <button id='next-month'>&gt;</button>
  `;
  document.getElementById("prev-month").onclick = () => {
    window.calendarState.month--;
    if (window.calendarState.month < 0) {
      window.calendarState.month = 11;
      window.calendarState.year--;
    }
    renderModernCalendar();
    // On n'affiche pas les créneaux par défaut
    document.getElementById("slots-list").innerHTML =
      '<div class="no-slots">Sélectionnez une date</div>';
  };
  document.getElementById("next-month").onclick = () => {
    window.calendarState.month++;
    if (window.calendarState.month > 11) {
      window.calendarState.month = 0;
      window.calendarState.year++;
    }
    renderModernCalendar();
    document.getElementById("slots-list").innerHTML =
      '<div class="no-slots">Sélectionnez une date</div>';
  };
  const year = window.calendarState.year;
  const month = window.calendarState.month;
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  let firstDay = new Date(year, month, 1).getDay();
  firstDay = firstDay === 0 ? 6 : firstDay - 1;
  let html = `<div class='calendar-weekdays'>`;
  weekDays.forEach((d) => (html += `<div>${d}</div>`));
  html += '</div><div class="calendar-grid">';
  for (let i = 0; i < firstDay; i++) html += "<div></div>";
  for (let d = 1; d <= daysInMonth; d++) {
    const dateObj = new Date(year, month, d);
    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(
      d
    ).padStart(2, "0")}`;
    const isPast =
      dateObj <
      new Date(
        new Date().getFullYear(),
        new Date().getMonth(),
        new Date().getDate()
      );
    const isSunday = dateObj.getDay() === 0;
    let btnClass = "calendly-day";
    if (isSunday) btnClass += " disabled";
    if (bookingState.selectedDate === dateStr) btnClass += " selected";
    html += `<button class='${btnClass}' data-date='${dateStr}' ${
      isPast || isSunday ? "disabled" : ""
    }>${d}</button>`;
  }
  html += "</div>";
  cal.innerHTML = html;
  document.querySelectorAll(".calendly-day").forEach((btn) => {
    if (btn.disabled) return;
    btn.onclick = () => {
      bookingState.selectedDate = btn.getAttribute("data-date");
      bookingState.selectedSlot = null;
      renderModernCalendar();
      renderModernSlotsList();
    };
  });
  // Applique le style sélectionné après le render
  document.querySelectorAll(".calendly-day").forEach((btn) => {
    if (bookingState.selectedDate === btn.getAttribute("data-date")) {
      btn.classList.add("selected");
    } else {
      btn.classList.remove("selected");
    }
  });
  // Par défaut, masquer les créneaux si aucune date sélectionnée
  if (!bookingState.selectedDate) {
    document.getElementById("slots-list").innerHTML =
      '<div class="no-slots">Sélectionnez une date</div>';
  }
}

function renderModernSlotsList() {
  const slotsList = document.getElementById("slots-list");
  // Afficher un message si aucune date sélectionnée
  if (!bookingState.selectedDate) {
    slotsList.innerHTML = '<div class="no-slots">Sélectionnez une date</div>';
    return;
  }
  if (!bookingState.selectedEmployee || !bookingState.selectedService) {
    slotsList.innerHTML =
      '<div class="no-slots">Veuillez sélectionner un service et un employé</div>';
    return;
  }
  console.log("Déclenchement AJAX get_available_slots", bookingState); // DEBUG
  let html = "";
  jQuery.ajax({
    url: window.ajaxurl,
    type: "POST",
    data: {
      action: "get_available_slots",
      employee_id: bookingState.selectedEmployee.id,
      service_id: bookingState.selectedService.id,
      date: bookingState.selectedDate,
      nonce: window.ib_nonce,
    },
    success: function (response) {
      if (response.success && response.data) {
        html = "";
        // Si data est un tableau simple (array), on affiche tous les créneaux à la suite
        if (Array.isArray(response.data)) {
          html +=
            '<div style="margin-bottom:1em;"><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
          response.data.forEach((slot) => {
            html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #e9aebc;background:#fff;color:#e9aebc;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
              bookingState.selectedSlot === slot ? "disabled" : ""
            } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
          });
          html += "</div></div>";
        } else {
          // Ancien format : morning, afternoon, evening
          if (response.data.morning && response.data.morning.length) {
            html +=
              '<div style="margin-bottom:1em;"><b>Morning</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.morning.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #e9aebc;background:#fff;color:#e9aebc;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
                bookingState.selectedSlot === slot ? "disabled" : ""
              } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
            });
            html += "</div></div>";
          }
          if (response.data.afternoon && response.data.afternoon.length) {
            html +=
              '<div style="margin-bottom:1em;"><b>Afternoon</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.afternoon.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #e9aebc;background:#fff;color:#e9aebc;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
                bookingState.selectedSlot === slot ? "disabled" : ""
              } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
            });
            html += "</div></div>";
          }
          if (response.data.evening && response.data.evening.length) {
            html +=
              '<div style="margin-bottom:1em;"><b>Evening</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.evening.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #e9aebc;background:#fff;color:#e9aebc;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
                bookingState.selectedSlot === slot ? "disabled" : ""
              } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
            });
            html += "</div></div>";
          }
        }
        slotsList.innerHTML = html;
      }
    },
    error: function (xhr, status, error) {
      console.error("Erreur AJAX get_available_slots:", status, error, xhr);
    },
  });
  window.selectSlot = function (slot) {
    bookingState.selectedSlot = slot;
    updateBookingState();
    goToStep(4); // Aller à l'étape Infos
  };
}

function showBookingNotification(message) {
  if (document.getElementById("booking-notif-modal")) return;
  const modal = document.createElement("div");
  modal.id = "booking-notif-modal";
  modal.style =
    "position:fixed;z-index:99999;left:0;top:0;width:100vw;height:100vh;background:rgba(249,234,242,0.55);display:flex;align-items:center;justify-content:center;";
  modal.innerHTML = `<div style='background:linear-gradient(120deg,#fff 80%,#fbeff3 100%);border-radius:1.5em;box-shadow:0 8px 40px #e9aebc55;padding:2.2em 1.5em;max-width:350px;width:90vw;text-align:center;position:relative;'>
    <div style='margin-bottom:1.1em;'><span style='display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:50%;background:linear-gradient(120deg,#fbeff3 60%,#e9aebc 100%);box-shadow:0 2px 12px #e9aebc33;'><svg width="32" height="32" fill="none" stroke="#b95c8a" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></span></div>
    <div style='font-family:"Playfair Display",Inter,serif;font-size:1.13em;font-weight:700;color:#b95c8a;margin-bottom:0.7em;'>Action requise</div>
    <div style='color:#a05c7b;font-size:1.05em;margin-bottom:1.2em;'>${message}</div>
    <button style='background:linear-gradient(90deg,#e9aebc 0%,#fbeff3 100%);color:#fff;font-weight:700;border:none;border-radius:1.2em;padding:0.7em 2.2em;font-size:1.05em;box-shadow:0 2px 12px #e9aebc22;cursor:pointer;' onclick='document.getElementById("booking-notif-modal").remove()'>OK</button>
  </div>`;
  document.body.appendChild(modal);
}

// Protection navigation sidebar (renforcée)
function setupSidebarStepProtection() {
  const sidebar = document.getElementById("sidebar-steps");
  if (!sidebar) return;
  const currentStep = bookingState.step - 1;
  sidebar.querySelectorAll("li").forEach((li, idx) => {
    // Désactive les étapes futures
    if (idx > currentStep) {
      li.classList.add("disabled");
      li.style.pointerEvents = "none";
      li.style.opacity = "0.5";
      li.style.cursor = "not-allowed";
    } else {
      li.classList.remove("disabled");
      li.style.pointerEvents = "auto";
      li.style.opacity = "1";
      li.style.cursor = "pointer";
    }
    // Navigation autorisée uniquement sur les étapes courantes ou précédentes
    li.onclick = (e) => {
      if (idx > currentStep) {
        e.preventDefault();
        return;
      }
      goToStep(idx + 1);
    };
  });
}

// Appeler la protection sidebar après chaque render
setTimeout(setupSidebarStepProtection, 50);
