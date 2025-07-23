// Check jQuery availability
if (typeof jQuery === 'undefined') {
  console.warn('jQuery is not available - some features may not work');
}

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
  renderSidebar();

  // --- Synchronise le stepper mobile ---
  if (window.innerWidth <= 700) {
    updateMobileStepper(bookingState.step, 5);

    // Scroll automatique en haut du formulaire sur mobile
    const container = document.querySelector(".container");
    if (container) {
      container.scrollIntoView({ behavior: "smooth", block: "start" });
    } else {
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  }
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
          <div class="services" id="services-part">
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
      inner = `<div class='booking-main-content'><h2 class='text-center mb-6'>Choisissez votre praticienne</h2><div class="grid" id="employees-grid"></div></div>`;
      content.innerHTML = inner;
      renderEmployeesGrid();
      break;
    case 3:
      inner = `<div class='booking-main-content'>
        <div class="booking-step-date-modern">
          <div class="calendar-col">
            <div class="calendar-inner-card">
              <h2 class="text-2xl font-bold text-pink-400 mb-4 text-center">Date & Heure</h2>
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
              <label for="client-firstname" class="booking-label-modern" style="display:flex;align-items:center;gap:0.5em;margin-bottom:0.3em;font-size:1em;">
                <span style="display:inline-block;width:1.2em;height:1.2em;vertical-align:middle;">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#7B6F5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="6.5" r="3.5"/><path d="M3 17c0-2.5 3.5-4 7-4s7 1.5 7 4"/></svg>
                </span> Prénom
              </label>
              <input id="client-firstname" class="booking-input-modern" type="text" placeholder="Votre prénom" required value="${
                bookingState.client.firstname || ""
              }" />
            </div>
            <div class="input-group-modern">
              <label for="client-lastname" class="booking-label-modern" style="display:flex;align-items:center;gap:0.5em;margin-bottom:0.3em;font-size:1em;">
                <span style="display:inline-block;width:1.2em;height:1.2em;vertical-align:middle;">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#7B6F5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="6.5" r="3.5"/><path d="M3 17c0-2.5 3.5-4 7-4s7 1.5 7 4"/></svg>
                </span> Nom
              </label>
              <input id="client-lastname" class="booking-input-modern" type="text" placeholder="Votre nom" required value="${
                bookingState.client.lastname || ""
              }" />
            </div>
            <div class="input-group-modern">
              <label for="client-email" class="booking-label-modern" style="display:flex;align-items:center;gap:0.5em;margin-bottom:0.3em;font-size:1em;">
                <span style="display:inline-block;width:1.2em;height:1.2em;vertical-align:middle;">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#7B6F5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="14" height="10" rx="2"/><path d="M3 5l7 6l7-6"/></svg>
                </span> Email (optionnel)
              </label>
              <input id="client-email" class="booking-input-modern" type="email" placeholder="Votre email (optionnel)" value="${
                bookingState.client.email || ""
              }" />
            </div>
            <div class="phone-field-modern" style="margin-bottom:2.1em;">
              <label for="client-phone" style="color:#606060 !important ;font-size:1.04em;margin-bottom:0.4em;display:block;">Téléphone</label>
              <input id="client-phone" type="tel" required value="${
                bookingState.client.phone || ""
              }" placeholder="Numéro de téléphone"   style="color: #606060 !important;""/>
            </div>
            <!-- NOUVELLE CASE À COCHER RGPD, liens à jour -->
            <div class="ib-legal-checkbox" style="margin:1em 0;">
              <label style="font-size:0.97em; color:#606060;">
                <input id="client-privacy" type="checkbox" required style="accent-color:#606060;width:1.1em;height:1.1em;" />
                J’ai lu et j’accepte la
                <a href="https://linstitutbykm.com/privacy-policy/" target="_blank" rel="noopener" style="color:#606060; text-decoration:underline;">
                  politique de confidentialité
                </a>
                et les
                <a href="https://linstitutbykm.com/refund_returns" target="_blank" rel="noopener" style="color:#606060; text-decoration:underline;">
                  conditions générales
                </a>.
              </label>
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
          // --- Réinitialisation intl-tel-input à CHAQUE affichage ---
          // Dans le setTimeout et DOMContentLoaded, ne plus appeler intl-tel-input ni window.iti
          // --- SUPPRIMER toute initialisation intl-tel-input ---
          // Modal Conditions Générales
          if (!document.getElementById("terms-modal")) {
            const modal = document.createElement("div");
            modal.id = "terms-modal";
            modal.style =
              "display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);align-items:center;justify-content:center;";
            modal.innerHTML = `<div style='background:#fff;max-width:480px;width:90vw;padding:2em 1.5em;border-radius:1.2em;box-shadow:0 8px 32px #606060;position:relative;'>
              <button id='close-terms-modal' style='position:absolute;top:0.7em;right:1em;font-size:1.5em;background:none;border:none;cursor:pointer;'>&times;</button>
              <h3 style='color:#606060;font-size:1.2em;margin-bottom:1em;'>✅ Conditions Générales de Réservation</h3>
              <div style='font-size:0.97em;line-height:1.6;color:#555;text-align:left;max-height:60vh;overflow-y:auto;'>
                En validant votre rendez-vous, vous acceptez les conditions suivantes :<br><br>
                Vos informations personnelles sont utilisées uniquement pour organiser et confirmer votre réservation.<br><br>
                Vous pouvez modifier ou annuler votre rendez-vous à tout moment en nous contactant directement.<br><br>
                Toute utilisation de ce service implique le respect de nos modalités de réservation.<br>
              </div>
            </div>`;
            document.body.appendChild(modal);
            const showTermsBtn = document.getElementById("show-terms");
            if (showTermsBtn) {
              showTermsBtn.onclick = function (e) {
                e.preventDefault();
                modal.style.display = "flex";
              };
            }
            const closeTermsModalBtn =
              document.getElementById("close-terms-modal");
            if (closeTermsModalBtn) {
              closeTermsModalBtn.onclick = function () {
                modal.style.display = "none";
              };
            }
          }
          // Modal Politique de Confidentialité
          if (!document.getElementById("privacy-modal")) {
            const modal = document.createElement("div");
            modal.id = "privacy-modal";
            modal.style =
              "display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);align-items:center;justify-content:center;";
            modal.innerHTML = `<div style='background:#fff;max-width:480px;width:90vw;padding:2em 1.5em;border-radius:1.2em;box-shadow:0 8px 32px #e9aebc55;position:relative;'>
              <button id='close-privacy-modal' style='position:absolute;top:0.7em;right:1em;font-size:1.5em;background:none;border:none;cursor:pointer;'>&times;</button>
              <h3 style='606060 !important;font-size:1.2em;margin-bottom:1em;'>🔐 Politique de Confidentialité</h3>
              <div style='font-size:0.97em;line-height:1.6;color:#555;text-align:left;max-height:60vh;overflow-y:auto;'>
                Dans le respect de la législation en vigueur, nous nous engageons à protéger vos données personnelles :<br><br>
                Les données que vous fournissez (nom, prénom, téléphone, email) sont traitées de manière sécurisée, dans le seul objectif de gérer votre rendez-vous.<br><br>
                Elles ne seront jamais partagées, vendues ni utilisées à des fins commerciales sans votre consentement explicite.<br><br>
                Vous disposez à tout moment d'un droit d'accès, de rectification et de suppression de vos données, sur simple demande.<br>
              </div>
            </div>`;
            document.body.appendChild(modal);
            const showPrivacyBtn = document.getElementById("show-privacy");
            if (showPrivacyBtn) {
              showPrivacyBtn.onclick = function (e) {
                e.preventDefault();
                modal.style.display = "flex";
              };
            }
            const closePrivacyModalBtn = document.getElementById(
              "close-privacy-modal"
            );
            if (closePrivacyModalBtn) {
              closePrivacyModalBtn.onclick = function () {
                modal.style.display = "none";
              };
            }
          }
          // Réactive intl-tel-input sur #client-phone
          setTimeout(() => {
            const phoneInputForm = form.querySelector("#client-phone");
            if (window.intlTelInput && phoneInputForm) {
              setTimeout(() => {
                if (window.iti && typeof window.iti.destroy === "function")
                  window.iti.destroy();
                window.iti = window.intlTelInput(phoneInputForm, {
                  initialCountry: "dz",
                  nationalMode: false,
                  preferredCountries: ["dz", "fr"],
                  utilsScript:
                    "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                  separateDialCode: true,
                  autoPlaceholder: "polite",
                  formatOnDisplay: true,
                  showFlags: true,
                  dropdownContainer: document.body, // Force le dropdown à s'ouvrir en bas, aligné à gauche
                });
              }, 100);
            }
            // Appliquer la validation moderne
            setupModernValidation(form);
          }, 100);
        }
      }, 100);
      break;
    case 5:
      let prixHtml = "-";
      if (bookingState.selectedService) {
        if (bookingState.selectedService.variable_price == 1) {
          const min = Number(bookingState.selectedService.min_price);
          const max = Number(bookingState.selectedService.max_price);
          if (min > 0 && max > 0 && min !== max) {
            prixHtml = `de ${min.toLocaleString()} DA à ${max.toLocaleString()} DA`;
          } else if (min > 0) {
            prixHtml = `à partir de ${min.toLocaleString()} DA`;
          } else {
            prixHtml = "-";
          }
        } else if (typeof bookingState.selectedService.price !== "undefined") {
          prixHtml =
            Number(bookingState.selectedService.price).toLocaleString() + " DA";
        }
      }
      inner = `<div class="booking-ticket-modern">
          <div class="ticket-success-icon">
            <svg viewBox="0 0 48 48"><circle cx="24" cy="24" r="22" stroke="#606060 !important" stroke-width="3" fill="#fff"/><path d="M15 25l7 7 12-14" stroke="#606060 !important" stroke-width="3.2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="ticket-success-badge">Réservation Confirmée</div>
          <div class="ticket-success-message">Merci pour votre réservation !<br>Un email de confirmation vous a été envoyé.</div>
          <div class="ticket-details">
            <div><span class="ticket-label">Service :</span> <span class="ticket-value">${
              bookingState.selectedService?.name || "-"
            }</span></div>
            <div><span class="ticket-label">Praticienne :</span> <span class="ticket-value">${
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
            <div><span class="ticket-label">Prix :</span> <span class="ticket-value">${prixHtml}</span></div>
          </div>
          <div class="flex justify-center mt-4">
            <button id="download-ticket-btn" class="btn-modern" type="button">Télécharger le ticket</button>
        </div>
      </div>`;
      content.innerHTML = inner;
      setTimeout(() => {
        const btn = document.getElementById("download-ticket-btn");
        if (btn) {
          btn.onclick = () => {
            const ticket = document.querySelector(".booking-ticket-modern");
            if (ticket && window.html2pdf) {
              // Masquer le bouton avant export
              btn.style.display = "none";
              window.scrollTo(0, 0);
              setTimeout(() => {
                const opt = {
                  margin: 0,
                  filename: "ticket-reservation.pdf",
                  image: { type: "jpeg", quality: 0.98 },
                  html2canvas: {
                    scale: 2,
                    backgroundColor:
                      getComputedStyle(ticket).backgroundColor || "#f8f8f8",
                  },
                  jsPDF: { unit: "pt", format: "a4", orientation: "portrait" },
                  pagebreak: { mode: ["css", "legacy"] },
                };
                html2pdf()
                  .set(opt)
                  .from(ticket)
                  .save()
                  .then(() => {
                    // Réafficher le bouton après export
                    btn.style.display = "block";
                  })
                  .catch(() => {
                    btn.style.display = "block";
                  });
              }, 400);
            }
          };
        }
      }, 100);
      break;
  }
}

// Fonction pour rendre les actions (boutons)
function renderActions() {
  const actions = document.getElementById("booking-actions");
  actions.innerHTML = "";
  actions.className = "actions";

  // Affiche le bouton retour uniquement si ce n'est pas l'étape 5
  if (bookingState.step > 1 && bookingState.step < 5) {
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
      ["Praticienne", "Date & Heure", "Infos", "Ticket"][
        bookingState.step - 1
      ] +
      " →</strong>";
    next.onclick = () => {
      if (bookingState.step === 1 && !bookingState.selectedService) {
        showBookingNotification("Sélectionnez un service.");
        return;
      }
      if (bookingState.step === 2 && !bookingState.selectedEmployee) {
        showBookingNotification("Sélectionnez une praticienne.");
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
  console.log("Praticiennes:", bookingState.employees);
  renderSidebar();
  renderStepContent();
  renderActions();
  if (window.innerWidth <= 700) {
    updateMobileStepper(bookingState.step, 5);
  }
});

function renderSidebar() {
  const sidebarSteps = document.getElementById("sidebar-steps");
  if (!sidebarSteps) return;
  sidebarSteps.querySelectorAll("li").forEach((li, idx) => {
    // Active l'étape courante
    li.classList.toggle("active", idx === bookingState.step - 1);
    // Les étapes précédentes sont cliquables
    if (idx < bookingState.step - 1) {
      li.classList.remove("disabled");
      li.style.pointerEvents = "auto";
      li.style.opacity = "1";
      li.style.cursor = "pointer";
      li.onclick = () => goToStep(idx + 1);
    } else if (idx === bookingState.step - 1) {
      // Étape courante : surbrillance, non cliquable
      li.classList.remove("disabled");
      li.style.pointerEvents = "none";
      li.style.opacity = "1";
      li.style.cursor = "default";
      li.onclick = null;
    } else {
      // Étapes futures : grisées, non cliquables
      li.classList.add("disabled");
      li.style.pointerEvents = "none";
      li.style.opacity = "0.6";
      li.style.cursor = "not-allowed";
      li.onclick = null;
    }
  });
}

function renderCategoryButtons() {
  const btns = document.getElementById("category-buttons");
  // Ajout de la classe pour le scroll horizontal responsive
  btns.className = "booking-categories";
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
    // Ajout de la classe pour le style responsive
    btn.className =
      "booking-category-btn" +
      (cat === bookingState.selectedCategory ? " active" : "");
    btn.onclick = () => {
      bookingState.selectedCategory = cat;
      renderServicesGrid();
      renderCategoryButtons();
      const servicesSection = document.getElementById("services-part");
      if (servicesSection) {
        servicesSection.scrollIntoView({ behavior: "smooth" });
      }
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
      "<div style='padding:2em;text-align:center;color:#A48D78;'>Aucun service disponible</div>";
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
    // Correction affichage prix
    let priceText = "";
    if (srv.variable_price == 1) {
      const min = Number(srv.min_price);
      const max = Number(srv.max_price);
      if (min > 0 && max > 0 && min !== max) {
        priceText = `De ${min.toLocaleString()} DA à ${max.toLocaleString()} DA`;
      } else if (min > 0) {
        priceText = `À partir de ${min.toLocaleString()} DA`;
      } else {
        priceText = "Variable";
      }
    } else if (typeof srv.price === "number" && !isNaN(srv.price)) {
      priceText = srv.price.toLocaleString() + " DA";
    } else if (typeof srv.price === "string" && srv.price.trim() !== "") {
      priceText = srv.price + " DA";
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
      '<div style="padding:2em;text-align:center;color:#bfa2c7;">Aucune praticienne pour ce service</div>';
    return;
  }
  filtered.forEach((emp) => {
    const card = document.createElement("div");
    card.className =
      "employee-card-modern flex flex-col items-center justify-center bg-white rounded-xl shadow-md p-5 m-2 transition-all duration-150 cursor-pointer" +
      (bookingState.selectedEmployee &&
      bookingState.selectedEmployee.id === emp.id
        ? " border-2 border-brown-300 ring-2 ring-brown-100"
        : " hover:shadow-xl hover:bg-pink-50");
    card.onclick = () => {
      bookingState.selectedEmployee = emp;
      renderEmployeesGrid();
      goToStep(3); // Passe automatiquement à l'étape suivante après sélection
    };
    let imgHtml = emp.photo
      ? `<span style='display:flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#F4F4F4;box-shadow:0 2px 12px #F4F4F4;'><img src="${emp.photo}" alt="${emp.name}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;"></span>`
      : `<span style='display:flex;align-items:center;justify-content:center;width:80px;height:80px;border-radius:50%;background:#f8f8f8;color:#606060;font-size:2.1rem;box-shadow:0 2px 12px #f8f8f8;'><svg width="40" height="40" fill="none" stroke="#606060" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg></span>`;
    card.innerHTML = `
      ${imgHtml}
      <div class="mt-3 text-center">
        <div class="font-bold text-brown-400 text-base mb-1">${emp.name}</div>
       
      </div>
    `;
    grid.appendChild(card);
  });
}

// Ajoute cette fonction pour charger les jours disponibles dynamiquement
function loadAvailableDays(year, month, cb) {
  if (!bookingState.selectedService || !bookingState.selectedEmployee) {
    window.availableDays = {};
    if (cb) cb();
    return;
  }
  
  // Check if jQuery is available
  if (typeof jQuery === 'undefined') {
    console.warn('jQuery not available for AJAX call');
    window.availableDays = {};
    if (cb) cb();
    return;
  }
  
  jQuery.ajax({
    url: window.ajaxurl,
    type: "POST",
    data: {
      action: "get_available_days",
      employee_id: bookingState.selectedEmployee.id,
      service_id: bookingState.selectedService.id,
      year: year,
      month: month + 1, // JS: 0-11, PHP: 1-12
      nonce: window.ib_nonce,
    },
    success: function (response) {
      if (response.success && response.data) {
        window.availableDays = response.data;
      } else {
        window.availableDays = {};
      }
      if (cb) cb();
    },
    error: function () {
      window.availableDays = {};
      if (cb) cb();
    },
  });
}
// Modifie renderModernCalendar pour charger les jours avant d'afficher le calendrier
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
  // Charge les jours disponibles avant d'afficher le calendrier
  loadAvailableDays(
    window.calendarState.year,
    window.calendarState.month,
    () => {
      header.innerHTML = `
    <button id='prev-month'>&lt;</button>
    <span style='font-weight:600;font-size:1.1em;display:inline-block;min-width:120px;text-align:center;'>${monthNames[
      window.calendarState.month
    ].toUpperCase()} ${window.calendarState.year}</span>
    <button id='next-month'>&gt;</button>
  `;
      const prevMonthBtn = document.getElementById("prev-month");
      if (prevMonthBtn) {
        prevMonthBtn.onclick = () => {
          window.calendarState.month--;
          if (window.calendarState.month < 0) {
            window.calendarState.month = 11;
            window.calendarState.year--;
          }
          renderModernCalendar();
          document.getElementById("slots-list").innerHTML =
            '<div class="no-slots">Sélectionnez une date</div>';
        };
      }
      const nextMonthBtn = document.getElementById("next-month");
      if (nextMonthBtn) {
        nextMonthBtn.onclick = () => {
          window.calendarState.month++;
          if (window.calendarState.month > 11) {
            window.calendarState.month = 0;
            window.calendarState.year++;
          }
          renderModernCalendar();
          document.getElementById("slots-list").innerHTML =
            '<div class="no-slots">Sélectionnez une date</div>';
        };
      }
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
        let hasSlot = false;
        if (window.availableDays && window.availableDays[dateStr])
          hasSlot = true;
        let btnClass = "calendly-day";
        if (!hasSlot || isPast || isSunday) btnClass += " disabled";
        if (bookingState.selectedDate === dateStr) btnClass += " selected";
        html += `<button class='${btnClass}' data-date='${dateStr}' ${
          !hasSlot || isPast || isSunday ? "disabled" : ""
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
          // Scroll automatique vers les créneaux sur mobile
          if (window.innerWidth <= 700) {
            setTimeout(() => {
              const slots = document.getElementById("slots-list");
              if (slots)
                slots.scrollIntoView({ behavior: "smooth", block: "start" });
            }, 100);
          }
        };
      });
      document.querySelectorAll(".calendly-day").forEach((btn) => {
        if (bookingState.selectedDate === btn.getAttribute("data-date")) {
          btn.classList.add("selected");
        } else {
          btn.classList.remove("selected");
        }
      });
      if (!bookingState.selectedDate) {
        document.getElementById("slots-list").innerHTML =
          '<div class="no-slots">Sélectionnez une date</div>';
      }
    }
  );
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
      '<div class="no-slots">Veuillez sélectionner un service et une praticienne</div>';
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
          if (response.data.length === 0) {
            html =
              '<div class="no-slots" style="text-align:center;padding:2em 0;color:#606060;font-size:1.1em;font-weight:500;">Aucun créneau disponible pour cette date.<br><span style="font-size:0.97em;color:#bfa2c7;">Essayez une autre date ou une autre praticienne.</span></div>';
          } else {
            html +=
              '<div style="margin-bottom:1em;"><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #f8f8f8 !important;background:#f8f8f8 !important;color:#606060 !important;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
                bookingState.selectedSlot === slot ? "disabled" : ""
              } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#606060 !important;font-weight:400;'>Disponible</span></button>`;
            });
            html += "</div></div>";
          }
        } else {
          // Ancien format : morning, afternoon, evening
          if (response.data.morning && response.data.morning.length) {
            html +=
              '<div style="margin-bottom:1em;"><b>Morning</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.morning.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #f8f8f8;background:#f8f8f8;color:#606060;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
                bookingState.selectedSlot === slot ? "disabled" : ""
              } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
            });
            html += "</div></div>";
          }
          if (response.data.afternoon && response.data.afternoon.length) {
            html +=
              '<div style="margin-bottom:1em;"><b>Afternoon</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.afternoon.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #f8f8f8;background:#f8f8f8;color:#606060;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
                bookingState.selectedSlot === slot ? "disabled" : ""
              } onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
            });
            html += "</div></div>";
          }
          if (response.data.evening && response.data.evening.length) {
            html +=
              '<div style="margin-bottom:1em;"><b>Evening</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
            response.data.evening.forEach((slot) => {
              html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #f8f8f8;background:#f8f8f8;color:#606060;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${
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
    "position:fixed;z-index:99999;left:0;top:0;width:100vw;height:100vh;background: rgba(96, 96, 96, 0.33);display:flex;align-items:center;justify-content:center;";
  modal.innerHTML = `<div style='background:linear-gradient(120deg,#fff 80%,#fbeff3 100%);border-radius:1.5em;box-shadow:0 8px 40px #60606055
;padding:2.2em 1.5em;max-width:350px;width:90vw;text-align:center;position:relative;'>
    <div style='margin-bottom:1.1em;'><span style='display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:50%;background:linear-gradient(120deg, #606060 60%, #f8f8f8 100%)
;box-shadow:0 2px 12px #606060;'><svg width="32" height="32" fill="none" stroke="#f8f8f8" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></span></div>
    <div style='font-family:"Playfair Display",Inter,serif;font-size:1.13em;font-weight:700;color:#06060;margin-bottom:0.7em;'>Action requise</div>
    <div style='color:#606060;font-size:1.05em;margin-bottom:1.2em;'>${message}</div>
    <button style='background:linear-gradient(90deg, #606060 0%, #d3d3d3 100%);color:#fff;font-weight:700;border:none;border-radius:1.2em;padding:0.7em 2.2em;font-size:1.05em;box-shadow:0 2px 12px #e9aebc22;cursor:pointer;' onclick='document.getElementById("booking-notif-modal").remove()'>OK</button>
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

// --- INTL-TEL-INPUT ---
// Dans le setTimeout et DOMContentLoaded, ne plus appeler intl-tel-input ni window.iti
// --- SUPPRIMER toute initialisation intl-tel-input ---

function showError(input, message) {
  let error = input.parentNode.querySelector(".ib-error-msg");
  if (!error) {
    error = document.createElement("span");
    error.className = "ib-error-msg";
    error.style.color = "#e05c5c";
    error.style.fontSize = "0.97em";
    error.style.display = "block";
    error.style.marginTop = "0.3em";
    error.style.fontWeight = "500";
    input.parentNode.appendChild(error);
  }
  error.textContent = message;
  input.classList.add("ib-error");
}
function clearError(input) {
  let error = input.parentNode.querySelector(".ib-error-msg");
  if (error) error.remove();
  input.classList.remove("ib-error");
}
function isValidName(str) {
  // Noms/prénoms : lettres, espaces, tirets, apostrophes, pas de chiffres
  return /^[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{2,}$/.test(str.trim());
}
function isValidEmail(str) {
  // Email standard (plus large)
  return /^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/.test(str.trim());
}
function isValidPhoneNumber(str) {
  const cleaned = str.replace(/\D/g, "");
  let country = "";
  if (window.iti && window.iti.getSelectedCountryData) {
    country = window.iti.getSelectedCountryData().dialCode;
  }
  // France : +33, 9 chiffres, commence par 6 ou 7 (mobile), avec ou sans 0 initial
  if (country === "33") {
    // 06xxxxxxxx ou 07xxxxxxxx ou 6xxxxxxxx ou 7xxxxxxxx
    return /^0[67][0-9]{8}$/.test(cleaned) || /^[67][0-9]{8}$/.test(cleaned);
  }
  // Algérie : +213, 9 chiffres, commence par 5, 6 ou 7 (mobile), avec ou sans 0 initial
  if (country === "213") {
    return /^0[5-7][0-9]{8}$/.test(cleaned) || /^[5-7][0-9]{8}$/.test(cleaned);
  }
  // Autres pays : 6 à 15 chiffres
  return /^\d{6,15}$/.test(cleaned);
}

// --- Validation UX moderne ---
function setupModernValidation(form) {
  const firstnameInput = form.querySelector("#client-firstname");
  const lastnameInput = form.querySelector("#client-lastname");
  const emailInput = form.querySelector("#client-email");
  const phoneInput = form.querySelector("#client-phone");
  const submitBtn = form.querySelector('button[type="submit"]');

  // Pour suivre si le champ a été touché
  const touched = {
    firstname: false,
    lastname: false,
    email: false,
    phone: false,
  };

  function validateField(input, type) {
    let valid = true;
    let value = input.value;
    if (type === "firstname" || type === "lastname") {
      valid = isValidName(value);
      if (!valid && touched[type]) {
        showError(
          input,
          (type === "firstname" ? "Prénom" : "Nom") +
            " invalide (lettres uniquement)"
        );
      } else {
        clearError(input);
      }
    } else if (type === "email") {
      if (value.trim() === "") {
        valid = true;
        clearError(input);
      } else {
        valid = isValidEmail(value);
        if (!valid && touched.email) {
          showError(input, "Email invalide");
        } else {
          clearError(input);
        }
      }
    } else if (type === "phone") {
      let validIntl = window.iti && window.iti.isValidNumber();
      let validCustom = isValidPhoneNumber(value);
      let country =
        window.iti && window.iti.getSelectedCountryData
          ? window.iti.getSelectedCountryData().dialCode
          : "";
      console.log("[PHONE VALIDATION]", {
        value,
        country,
        validIntl,
        validCustom,
      });
      valid = validIntl && validCustom;
      if (!valid && touched.phone) {
        showError(
          input,
          "Numéro de téléphone invalide (format mobile, chiffres uniquement)"
        );
      } else {
        clearError(input);
      }
    }
    return valid;
  }

  function validateAll() {
    let valid = true;
    if (!validateField(firstnameInput, "firstname")) valid = false;
    if (!validateField(lastnameInput, "lastname")) valid = false;
    // Email : optionnel, donc valide si vide ou bien format email
    if (!validateField(emailInput, "email")) valid = false;
    if (!validateField(phoneInput, "phone")) valid = false;
    submitBtn.disabled = !valid;
    return valid;
  }

  // Gestion du "touched" et validation champ par champ
  [
    { input: firstnameInput, type: "firstname" },
    { input: lastnameInput, type: "lastname" },
    { input: emailInput, type: "email" },
    { input: phoneInput, type: "phone" },
  ].forEach(({ input, type }) => {
    input.addEventListener("blur", function () {
      touched[type] = true;
      validateField(input, type);
      validateAll();
    });
    input.addEventListener("input", function () {
      if (touched[type]) validateField(input, type);
      validateAll();
    });
  });

  // Empêche la saisie de chiffres dans nom/prénom
  [firstnameInput, lastnameInput].forEach((input) => {
    input.addEventListener("keypress", function (e) {
      if (/[0-9]/.test(e.key)) e.preventDefault();
    });
  });
  // Empêche la saisie de lettres dans téléphone
  phoneInput.addEventListener("keypress", function (e) {
    if (/[^0-9\s\-\.]/.test(e.key)) e.preventDefault();
  });

  // Validation au submit
  form.onsubmit = function (e) {
    console.log("[ONSUBMIT] submit triggered");
    e.preventDefault(); // Toujours empêcher le submit natif
    touched.firstname = true;
    touched.lastname = true;
    touched.email = true;
    touched.phone = true;
    if (!validateAll()) {
      console.log("[ONSUBMIT] Validation échouée");
      return false;
    }
    // Mettre à jour toutes les infos client dans bookingState avant d'afficher le ticket
    bookingState.client.firstname = firstnameInput.value;
    bookingState.client.lastname = lastnameInput.value;
    bookingState.client.email = emailInput.value;
    bookingState.client.phone = window.iti.getNumber();
    updateBookingState();
    submitBtn.disabled = true;
    jQuery.ajax({
      url: window.ajaxurl,
      type: "POST",
      data: {
        action: "add_booking",
        service_id: bookingState.selectedService.id,
        employee_id: bookingState.selectedEmployee.id,
        date: bookingState.selectedDate,
        slot: bookingState.selectedSlot,
        firstname: firstnameInput.value,
        lastname: lastnameInput.value,
        email: emailInput.value ? emailInput.value : "",
        phone: bookingState.client.phone,
        nonce: window.ib_nonce,
      },
      success: function (response) {
        console.log("Réponse AJAX réservation:", response);
        if (typeof response === "string") {
          try {
            response = JSON.parse(response);
          } catch (e) {
            console.error("Erreur parsing JSON:", e, response);
          }
        }
        console.log(
          "Test response.success:",
          response.success,
          "Type:",
          typeof response.success
        );
        if (response.success) {
          console.log("Ticket: goToStep(5)");
          goToStep(5); // Afficher le ticket
        } else {
          console.warn(
            "Réservation échouée, message:",
            response.data && response.data.message
          );
          showBookingNotification(
            "Erreur lors de la réservation : " +
              (response.data && response.data.message
                ? response.data.message
                : "Erreur inconnue")
          );
          if (submitBtn) submitBtn.disabled = false; // Réactive le bouton si erreur
        }
      },
      error: function (xhr, status, error) {
        console.error("[AJAX ERROR]", status, error, xhr);
        showBookingNotification(
          "Erreur AJAX lors de la réservation : " + error
        );
        if (submitBtn) submitBtn.disabled = false; // Réactive le bouton si erreur
      },
    });
    return false;
  };
}

// --- Appliquer la validation moderne à l'étape 4 ---
setTimeout(() => {
  const form = document.getElementById("booking-client-form");
  if (form) {
    setTimeout(() => {
      const phoneInputForm = form.querySelector("#client-phone");
      if (window.intlTelInput && phoneInputForm) {
        if (window.iti && typeof window.iti.destroy === "function")
          window.iti.destroy();
        window.iti = window.intlTelInput(phoneInputForm, {
          initialCountry: "dz",
          nationalMode: false,
          preferredCountries: ["dz", "fr"],
          utilsScript:
            "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
          separateDialCode: true,
          autoPlaceholder: "polite",
          formatOnDisplay: true,
          showFlags: true,
          dropdownContainer: null, // <--- null pour garder le code pays à gauche du champ
        });
      }
      setupModernValidation(form);
    }, 100);
  }
}, 100);

// Stepper mobile : met à jour l'étape active et la barre de progression
function updateMobileStepper(currentStep, totalSteps) {
  const steps = document.querySelectorAll(".ib-stepper-mobile .ib-step");
  steps.forEach((el, idx) => {
    el.classList.remove("active", "completed");
    if (idx + 1 < currentStep) el.classList.add("completed");
    else if (idx + 1 === currentStep) el.classList.add("active");
  });
  // Progress bar
  let progressBar = document.querySelector(".ib-stepper-progress-bar");
  if (!progressBar) {
    const bar = document.createElement("div");
    bar.className = "ib-stepper-progress-bar";
    document.querySelector(".ib-stepper-progress").appendChild(bar);
    progressBar = bar;
  }
  const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
  progressBar.style.width = percent + "%";
}

// Appelle updateMobileStepper à chaque changement d'étape
// Exemple d'appel (à adapter selon ta logique de navigation) :
// updateMobileStepper(bookingState.step, 5);
