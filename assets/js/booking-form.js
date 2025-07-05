jQuery(document).ready(function ($) {
  // Initialisation des variables globales depuis le PHP
  var ajaxurl = window.ajaxurl || "";
  window.bookingState = window.bookingState || {
    step: 1,
    selectedService: null,
    selectedEmployee: null,
    selectedDate: null,
    selectedSlot: null,
    services: window.bookingServices || [],
    employees: window.bookingEmployees || [],
  };

  function updateBookingState() {
    localStorage.setItem("bookingState", JSON.stringify(window.bookingState));
  }
  const savedState = localStorage.getItem("bookingState");
  if (savedState) {
    Object.assign(window.bookingState, JSON.parse(savedState));
  }

  // Gestion des créneaux disponibles
  function loadAvailableSlots(date) {
    if (!bookingState.selectedService || !bookingState.selectedEmployee) {
      return;
    }

    const serviceId = bookingState.selectedService.id;
    const employeeId = bookingState.selectedEmployee.id;
    const selectedDate = date || bookingState.selectedDate;

    jQuery.ajax({
      url: window.ajaxurl,
      type: "POST",
      data: {
        action: "get_available_slots",
        employee_id: employeeId,
        service_id: serviceId,
        date: selectedDate,
      },
      success: function (response) {
        if (response.success) {
          displayAvailableSlots(response.data);
        } else {
          console.error(
            "Erreur lors du chargement des créneaux :",
            response.data
          );
          displayAvailableSlots([]);
        }
      },
      error: function (xhr, status, error) {
        console.error("Erreur AJAX :", error);
        displayAvailableSlots([]);
      },
    });
  }

  function displayAvailableSlots(slots) {
    const slotsList = $("#slots-list");
    slotsList.empty();

    if (slots.length === 0) {
      slotsList.html(
        '<div class="no-slots">Aucun créneau disponible pour cette date</div>'
      );
      return;
    }

    const grid = $('<div class="slots-grid"></div>');
    slots.forEach((slot) => {
      const button = $("<button>")
        .addClass("slot-btn")
        .text(`${slot.start} - ${slot.end}`)
        .data("slot", slot)
        .on("click", function () {
          selectSlot($(this).data("slot"));
        });

      if (slot.is_booked) {
        button.prop("disabled", true).addClass("booked");
      }

      grid.append(button);
    });

    slotsList.append(grid);
  }

  function selectSlot(slot) {
    bookingState.selectedSlot = slot;
    updateBookingState();
    // Passer à l'étape suivante
    bookingState.step++;
    renderStepContent();
    renderActions();
  }

  // Écouteur pour le changement de date
  $(document).on("change", "#booking-date", function () {
    const date = $(this).val();
    bookingState.selectedDate = date;
    loadAvailableSlots(date);
  });

  // Initialiser le chargement des créneaux si une date est déjà sélectionnée
  if (bookingState.selectedDate) {
    loadAvailableSlots(bookingState.selectedDate);
  }
});
