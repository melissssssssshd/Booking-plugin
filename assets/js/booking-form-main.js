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
const savedState = localStorage.getItem("bookingState");
if (savedState) {
  Object.assign(bookingState, JSON.parse(savedState));
}

// Fonction pour naviguer entre les étapes
function goToStep(step) {
  bookingState.step = step;
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

  switch (bookingState.step) {
    case 1:
      content.innerHTML = `
        <div class="categories">
          <h2>Catégorie</h2>
          <div class="buttons" id="category-buttons"></div>
        </div>
        <div class="services">
          <h2>Service</h2>
          <div class="grid" id="services-grid"></div>
        </div>
      `;
      renderCategoryButtons();
      renderServicesGrid();
      break;
    case 2:
      content.innerHTML = `<h2>Choisissez votre employé</h2><div class="grid" id="employees-grid"></div>`;
      renderEmployeesGrid();
      break;
    case 3:
      content.innerHTML = `
        <div style='display:flex;gap:2.5rem;flex-wrap:wrap;'>
          <div style='min-width:320px;max-width:350px;'>
            <h2 style='margin-bottom:1em;'>Date & Time</h2>
            <div id='calendar-header' style='display:flex;align-items:center;gap:1em;margin-bottom:0.5em;'></div>
            <div id='calendar-days'></div>
          </div>
          <div style='flex:1;min-width:260px;'>
            <h3 style='margin-bottom:1em;'>Time Slot</h3>
            <div id='slots-list'></div>
          </div>
        </div>
      `;
      renderModernCalendar();
      renderModernSlotsList();
      break;
    case 4:
      content.innerHTML = `<h2>Vos informations</h2><form class='booking-form-fields' id='booking-client-form' style='max-width:400px;'><input class='booking-input' type='text' placeholder='Prénom' id='client-firstname' required value='${
        bookingState.client.firstname || ""
      }' /><input class='booking-input' type='text' placeholder='Nom' id='client-lastname' required value='${
        bookingState.client.lastname || ""
      }' /><input class='booking-input' type='email' placeholder='Email' id='client-email' required value='${
        bookingState.client.email || ""
      }' /><input class='booking-input' type='tel' placeholder='Téléphone' id='client-phone' required value='${
        bookingState.client.phone || ""
      }' /><button type='submit' class='next' style='margin-top:1em;'>Valider la réservation</button></form>`;
      // Ajout du submit handler
      setTimeout(() => {
        const form = document.getElementById("booking-client-form");
        if (form) {
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
            if (!firstname || !lastname || !email || !phone) {
              alert("Merci de remplir tous les champs.");
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
                  alert(
                    "Erreur lors de la réservation : " +
                      (response.data && response.data.message
                        ? response.data.message
                        : "Erreur inconnue")
                  );
                }
              },
              error: function (xhr, status, error) {
                alert("Erreur AJAX lors de la réservation : " + error);
              },
            });
            return false;
          };
        }
      }, 100);
      break;
    case 5:
      content.innerHTML = `<h2>Votre ticket de réservation</h2><div class='booking-summary'><b>Service :</b> ${
        bookingState.selectedService?.name || ""
      }<br><b>Employé :</b> ${
        bookingState.selectedEmployee?.name || ""
      }<br><b>Date :</b> ${bookingState.selectedDate || ""}<br><b>Heure :</b> ${
        bookingState.selectedSlot || ""
      }<br><b>Client :</b> ${bookingState.client.firstname} ${
        bookingState.client.lastname
      }<br><b>Email :</b> ${bookingState.client.email}<br><b>Téléphone :</b> ${
        bookingState.client.phone
      }<br><b>Prix :</b> ${
        bookingState.selectedService?.price
          ? bookingState.selectedService.price.toLocaleString()
          : ""
      } DA<br><br><span style='color:green;font-weight:600;'>Réservation enregistrée avec succès !</span></div>`;
      break;
  }
}

// Fonction pour rendre les actions (boutons)
function renderActions() {
  const actions = document.getElementById("booking-actions");
  actions.innerHTML = "";

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
      if (bookingState.step === 1 && !bookingState.selectedService)
        return alert("Sélectionnez un service.");
      if (bookingState.step === 2 && !bookingState.selectedEmployee)
        return alert("Sélectionnez un employé.");
      if (
        bookingState.step === 3 &&
        (!bookingState.selectedDate || !bookingState.selectedSlot)
      )
        return alert("Sélectionnez une date et un créneau.");
      if (
        bookingState.step === 4 &&
        (!bookingState.client.firstname ||
          !bookingState.client.lastname ||
          !bookingState.client.email ||
          !bookingState.client.phone)
      )
        return alert("Merci de remplir tous les champs.");
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
  document.querySelectorAll("#sidebar-steps li").forEach((li, idx) => {
    li.onclick = () => {
      if (idx + 1 <= bookingState.step) goToStep(idx + 1);
    };
  });
});

function renderSidebar() {
  document.querySelectorAll("#sidebar-steps li").forEach((li, idx) => {
    li.classList.toggle("active", idx === bookingState.step - 1);
  });
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
      "card" +
      (bookingState.selectedEmployee &&
      bookingState.selectedEmployee.id === emp.id
        ? " selected"
        : "");
    card.onclick = () => {
      bookingState.selectedEmployee = emp;
      console.log("Employé sélectionné:", emp); // DEBUG
      goToStep(3);
    };
    let imgHtml = emp.image
      ? `<img src="${emp.image}" alt="${emp.name}">`
      : `<div class='avatar-placeholder'>👤</div>`;
    card.innerHTML = `
            ${imgHtml}
            <div>
                <h3>${emp.name}</h3>
                <p>${emp.specialty || ""}</p>
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
  const weekDays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
  if (!window.calendarState)
    window.calendarState = {
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
    };
  header.innerHTML = `
        <button id='prev-month'>&lt;</button>
        <span style='font-weight:600;font-size:1.1em;'>${
          monthNames[window.calendarState.month]
        } ${window.calendarState.year}</span>
        <button id='next-month'>&gt;</button>
    `;
  document.getElementById("prev-month").onclick = () => {
    window.calendarState.month--;
    if (window.calendarState.month < 0) {
      window.calendarState.month = 11;
      window.calendarState.year--;
    }
    renderModernCalendar();
    renderModernSlotsList();
  };
  document.getElementById("next-month").onclick = () => {
    window.calendarState.month++;
    if (window.calendarState.month > 11) {
      window.calendarState.month = 0;
      window.calendarState.year++;
    }
    renderModernCalendar();
    renderModernSlotsList();
  };
  const year = window.calendarState.year;
  const month = window.calendarState.month;
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const firstDay = (new Date(year, month, 1).getDay() + 6) % 7;
  let html = `<div class='calendar-weekdays'>`;
  weekDays.forEach((d) => (html += `<div>${d}</div>`));
  html += '</div><div class="calendar-grid">';
  for (let i = 0; i < firstDay; i++) html += "<div></div>";
  for (let d = 1; d <= daysInMonth; d++) {
    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(
      d
    ).padStart(2, "0")}`;
    const isPast =
      new Date(year, month, d) <
      new Date(
        new Date().getFullYear(),
        new Date().getMonth(),
        new Date().getDate()
      );
    let btnClass = "calendly-day";
    if (bookingState.selectedDate === dateStr) btnClass += " selected";
    html += `<button class='${btnClass}' data-date='${dateStr}' ${
      isPast ? "disabled" : ""
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
}

function renderModernSlotsList() {
  const slotsList = document.getElementById("slots-list");
  slotsList.innerHTML = '<div class="loading">Loading...</div>';
  if (
    !bookingState.selectedDate ||
    !bookingState.selectedEmployee ||
    !bookingState.selectedService
  ) {
    slotsList.innerHTML =
      '<div class="no-slots">Please select a service, employee, and date first</div>';
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
            '<div style="margin-bottom:1em;"><b>Créneaux disponibles</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
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
