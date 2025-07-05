jQuery(document).ready(function ($) {
  // Gestion des formulaires
  $(".ib-admin-form").on("submit", function (e) {
    e.preventDefault();
    var $form = $(this);
    var $submit = $form.find('button[type="submit"]');
    var originalText = $submit.text();

    $submit.prop("disabled", true).text("Enregistrement...");

    $.ajax({
      url: window.ajaxurl,
      type: "POST",
      data: $form.serialize(),
      success: function (response) {
        if (response.success) {
          alert("Enregistré avec succès !");
          if (response.redirect) {
            window.location.href = response.redirect;
          }
        } else {
          alert("Erreur : " + response.data);
        }
      },
      error: function () {
        alert("Erreur de communication avec le serveur");
      },
      complete: function () {
        $submit.prop("disabled", false).text(originalText);
      },
    });
  });

  // Gestion des suppressions
  $(".ib-delete").on("click", function (e) {
    e.preventDefault();
    if (!confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
      return;
    }

    var $link = $(this);
    var id = $link.data("id");
    var type = $link.data("type");

    $.ajax({
      url: window.ajaxurl,
      type: "POST",
      data: {
        action: "ib_delete_" + type,
        id: id,
        nonce: ib_admin.nonce,
      },
      success: function (response) {
        if (response.success) {
          $link.closest("tr").fadeOut(function () {
            $(this).remove();
          });
        } else {
          alert("Erreur : " + response.data);
        }
      },
    });
  });

  // Gestion des statuts de réservation
  $(".ib-booking-status").on("change", function () {
    var $select = $(this);
    var id = $select.data("id");
    var status = $select.val();

    $.ajax({
      url: window.ajaxurl,
      type: "POST",
      data: {
        action: "ib_update_booking_status",
        id: id,
        status: status,
        nonce: ib_admin.nonce,
      },
      success: function (response) {
        if (!response.success) {
          alert("Erreur : " + response.data);
          $select.val($select.data("original"));
        }
      },
    });
  });

  // Gestion des filtres
  $(".ib-filter").on("change", function () {
    var $form = $(this).closest("form");
    $form.submit();
  });

  // Gestion des dates
  $(".ib-datepicker").datepicker({
    dateFormat: "dd/mm/yy",
    firstDay: 1,
  });

  // Gestion des timepickers
  $(".ib-timepicker").timepicker({
    timeFormat: "HH:mm",
    interval: 15,
    minTime: "08:00",
    maxTime: "20:00",
    defaultTime: "09:00",
    startTime: "08:00",
    dynamic: false,
    dropdown: true,
    scrollbar: true,
  });

  // Gestion des sélecteurs de couleur
  $(".ib-colorpicker").wpColorPicker();

  // Gestion des uploads d'images
  $(".ib-upload-image").on("click", function (e) {
    e.preventDefault();
    var $button = $(this);
    var $input = $button.siblings('input[type="hidden"]');
    var $preview = $button.siblings(".ib-image-preview");

    var frame = wp.media({
      title: "Sélectionner une image",
      multiple: false,
    });

    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();
      $input.val(attachment.id);
      $preview.html('<img src="' + attachment.url + '" alt="">');
    });

    frame.open();
  });

  // Gestion des sélecteurs de service
  $(".ib-service-select").on("change", function () {
    var $select = $(this);
    var serviceId = $select.val();
    var $extras = $select.closest("form").find(".ib-extras");

    if (serviceId) {
      $.ajax({
        url: window.ajaxurl,
        type: "POST",
        data: {
          action: "ib_get_service_extras",
          service_id: serviceId,
          nonce: ib_admin.nonce,
        },
        success: function (response) {
          if (response.success) {
            $extras.html(response.data);
          }
        },
      });
    } else {
      $extras.empty();
    }
  });

  // Gestion des sélecteurs d'employé
  $(".ib-employee-select").on("change", function () {
    var $select = $(this);
    var employeeId = $select.val();
    var $calendar = $select.closest("form").find(".ib-calendar");

    if (employeeId) {
      $.ajax({
        url: window.ajaxurl,
        type: "POST",
        data: {
          action: "ib_get_employee_calendar",
          employee_id: employeeId,
          nonce: ib_admin.nonce,
        },
        success: function (response) {
          if (response.success) {
            $calendar.html(response.data);
          }
        },
      });
    } else {
      $calendar.empty();
    }
  });
});
