/**
 * Sélecteur de téléphone custom Planity
 * Remplace complètement intl-tel-input par un composant sur mesure
 */

document.addEventListener("DOMContentLoaded", function () {
  // Pays avec codes et drapeaux
  const countries = [
    { code: "FR", name: "France", dial: "+33", flag: "🇫🇷" },
    { code: "DZ", name: "Algérie", dial: "+213", flag: "🇩🇿" },
    { code: "MA", name: "Maroc", dial: "+212", flag: "🇲🇦" },
    { code: "TN", name: "Tunisie", dial: "+216", flag: "🇹🇳" },
    { code: "DE", name: "Allemagne", dial: "+49", flag: "🇩🇪" },
    { code: "ES", name: "Espagne", dial: "+34", flag: "🇪🇸" },
    { code: "IT", name: "Italie", dial: "+39", flag: "🇮🇹" },
    { code: "GB", name: "Royaume-Uni", dial: "+44", flag: "🇬🇧" },
    { code: "US", name: "États-Unis", dial: "+1", flag: "🇺🇸" },
    { code: "CA", name: "Canada", dial: "+1", flag: "🇨🇦" },
    { code: "BE", name: "Belgique", dial: "+32", flag: "🇧🇪" },
    { code: "CH", name: "Suisse", dial: "+41", flag: "🇨🇭" },
    { code: "LU", name: "Luxembourg", dial: "+352", flag: "🇱🇺" },
  ];

  let selectedCountry = countries[1]; // Algérie par défaut

  function createPlanityPhoneField(container, phoneInput) {
    // Vérifier si déjà remplacé
    if (container.classList.contains("planity-phone-replaced")) {
      return;
    }

    // Marquer comme remplacé
    container.classList.add("planity-phone-replaced");

    console.log("🔧 Création du champ téléphone Planity pour:", phoneInput);

    // Créer le nouveau container Planity
    const planityContainer = document.createElement("div");
    planityContainer.className = "planity-phone-container";
    planityContainer.style.cssText = `
            width: 100%;
            border-radius: 12px;
            background: #f9fafb;
            border: 1px solid #d1d5db;
            padding: 0;
            display: flex;
            align-items: center;
            min-height: 52px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        `;

    // Créer le sélecteur de pays
    const countrySelector = document.createElement("div");
    countrySelector.className = "planity-country-selector";
    countrySelector.style.cssText = `
            min-width: 80px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e5e7eb;
            border-radius: 12px 0 0 12px;
            border-right: 1px solid #d1d5db;
            padding: 0 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        `;

    // Contenu du sélecteur
    countrySelector.innerHTML = `
            <span class="planity-flag" style="font-size: 16px; margin-right: 6px;">${selectedCountry.flag}</span>
            <span class="planity-dial" style="color: #374151; font-weight: 600; font-size: 14px; margin-right: 4px;">${selectedCountry.dial}</span>
            <span class="planity-arrow" style="border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 4px solid #6b7280; border-bottom: none; transition: transform 0.2s ease;"></span>
        `;

    // Créer le dropdown
    const dropdown = document.createElement("div");
    dropdown.className = "planity-country-dropdown";
    dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            margin-top: 4px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 9999;
            display: none;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        `;

    // Ajouter les pays au dropdown
    countries.forEach(function (country) {
      const countryItem = document.createElement("div");
      countryItem.className = "planity-country-item";
      countryItem.style.cssText = `
                padding: 10px 16px;
                background: #ffffff;
                color: #374151;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                gap: 12px;
                margin: 0;
                line-height: 1.4;
            `;

      countryItem.innerHTML = `
                <span style="font-size: 16px; width: 20px; height: 15px; display: flex; align-items: center; justify-content: center; border-radius: 2px; border: 1px solid #e5e7eb; margin-right: 8px; flex-shrink: 0;">${country.flag}</span>
                <span style="color: #374151; font-weight: 500; font-size: 14px; flex: 1;">${country.name}</span>
                <span style="color: #6b7280; font-weight: 600; font-size: 13px; background: #f9fafb; padding: 2px 6px; border-radius: 4px;">${country.dial}</span>
            `;

      // Événements hover
      countryItem.addEventListener("mouseenter", function () {
        this.style.background = "#f9fafb";
        this.style.color = "#111827";
      });

      countryItem.addEventListener("mouseleave", function () {
        this.style.background = "#ffffff";
        this.style.color = "#374151";
      });

      // Sélection du pays - Support mobile amélioré
      function selectCountry() {
        selectedCountry = country;

        // Mettre à jour l'affichage
        countrySelector.querySelector(".planity-flag").textContent =
          country.flag;
        countrySelector.querySelector(".planity-dial").textContent =
          country.dial;

        // Fermer le dropdown
        dropdown.style.display = "none";
        countrySelector.querySelector(".planity-arrow").style.transform =
          "rotate(0deg)";

        // Focus sur l'input (avec délai pour mobile)
        setTimeout(() => {
          newPhoneInput.focus();
        }, 100);

        console.log("🌍 Pays sélectionné:", country.name, country.dial);
      }

      // Événements pour desktop et mobile
      countryItem.addEventListener("click", selectCountry);
      countryItem.addEventListener("touchend", function (e) {
        e.preventDefault();
        selectCountry();
      });

      dropdown.appendChild(countryItem);
    });

    // Créer le nouvel input
    const newPhoneInput = document.createElement("input");
    newPhoneInput.type = "tel";
    newPhoneInput.placeholder = phoneInput.placeholder || "Numéro de téléphone";
    newPhoneInput.value = phoneInput.value || "";
    newPhoneInput.name = phoneInput.name || "phone";
    newPhoneInput.id = phoneInput.id || "client-phone";
    newPhoneInput.style.cssText = `
            width: 100%;
            border: none;
            background: transparent;
            border-radius: 0 12px 12px 0;
            padding: 16px;
            font-size: 16px;
            color: #111827;
            box-shadow: none;
            outline: none;
            height: 52px;
            line-height: 1.5;
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        `;

    // Événements du sélecteur - Support mobile amélioré
    function toggleDropdown() {
      const isOpen = dropdown.style.display === "block";
      dropdown.style.display = isOpen ? "none" : "block";
      countrySelector.querySelector(".planity-arrow").style.transform = isOpen
        ? "rotate(0deg)"
        : "rotate(180deg)";

      // Améliorer la visibilité sur mobile
      if (!isOpen && window.innerWidth <= 768) {
        dropdown.style.zIndex = "99999";
        // Scroll vers le sélecteur sur mobile
        setTimeout(() => {
          planityContainer.scrollIntoView({
            behavior: "smooth",
            block: "center",
          });
        }, 100);
      }
    }

    countrySelector.addEventListener("click", toggleDropdown);
    countrySelector.addEventListener("touchend", function (e) {
      e.preventDefault();
      toggleDropdown();
    });

    // Hover du sélecteur
    countrySelector.addEventListener("mouseenter", function () {
      this.style.background = "#d1d5db";
    });

    countrySelector.addEventListener("mouseleave", function () {
      this.style.background = "#e5e7eb";
    });

    // Focus du container
    newPhoneInput.addEventListener("focus", function () {
      planityContainer.style.background = "#ffffff";
      planityContainer.style.borderColor = "#374151";
      planityContainer.style.boxShadow = "0 0 0 3px rgba(55, 65, 81, 0.1)";
    });

    newPhoneInput.addEventListener("blur", function () {
      planityContainer.style.background = "#f9fafb";
      planityContainer.style.borderColor = "#d1d5db";
      planityContainer.style.boxShadow = "none";
    });

    // Fermer le dropdown en cliquant ailleurs
    document.addEventListener("click", function (e) {
      if (!planityContainer.contains(e.target)) {
        dropdown.style.display = "none";
        countrySelector.querySelector(".planity-arrow").style.transform =
          "rotate(0deg)";
      }
    });

    // Assembler le composant
    planityContainer.appendChild(countrySelector);
    planityContainer.appendChild(newPhoneInput);
    planityContainer.appendChild(dropdown);

    // Remplacer l'ancien container
    container.parentNode.insertBefore(planityContainer, container);
    container.style.display = "none";

    // Fonctions globales pour récupérer les valeurs
    window.getPlanityPhoneNumber = function () {
      return (
        selectedCountry.dial +
        " " +
        newPhoneInput.value.replace(/^\+?[\d\s-]+/, "").trim()
      );
    };

    window.getPlanityPhoneNumberOnly = function () {
      return newPhoneInput.value;
    };

    window.getPlanityCountryCode = function () {
      return selectedCountry.dial;
    };

    console.log("✅ Sélecteur téléphone Planity créé pour:", phoneInput);
  }

  function createCustomPhoneSelector() {
    // Trouver tous les champs téléphone
    const phoneContainers = document.querySelectorAll(
      '.phone-field-modern, .iti, [id*="phone"], input[type="tel"]'
    );

    // Si aucun container trouvé, chercher directement l'input téléphone
    if (phoneContainers.length === 0) {
      const phoneInput = document.querySelector(
        '#client-phone, input[type="tel"]'
      );
      if (phoneInput && !phoneInput.closest(".planity-phone-replaced")) {
        console.log("📞 Input téléphone trouvé directement:", phoneInput);
        createPlanityPhoneField(phoneInput.parentNode, phoneInput);
        return;
      }
    }

    phoneContainers.forEach(function (container) {
      // Si c'est directement un input, utiliser son parent
      if (container.tagName === "INPUT") {
        createPlanityPhoneField(container.parentNode, container);
        return;
      }

      // Trouver l'input téléphone dans le container
      let phoneInput = container.querySelector('input[type="tel"]');
      if (!phoneInput) {
        phoneInput = container.querySelector("input");
      }

      if (!phoneInput) {
        return;
      }

      createPlanityPhoneField(container, phoneInput);
    });
  }

  // Créer le sélecteur custom
  createCustomPhoneSelector();

  // Observer les changements DOM pour les nouveaux éléments
  const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      if (mutation.addedNodes.length > 0) {
        setTimeout(createCustomPhoneSelector, 100);
      }
    });
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });

  // Réessayer après un délai
  setTimeout(createCustomPhoneSelector, 500);
  setTimeout(createCustomPhoneSelector, 1000);
  setTimeout(createCustomPhoneSelector, 2000);

  console.log("🎨 Planity Phone Selector: Script chargé et actif");
});
