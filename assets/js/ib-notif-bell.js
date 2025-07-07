jQuery(document).ready(function ($) {
  var bell = $("#ib-notif-bell");
  var badge = bell.find(".ib-notif-badge");
  var dropdown = bell.find(".ib-notif-dropdown");
  var notifList = bell.find(".ib-notif-list");
  var emptyMsg = bell.find(".ib-notif-empty");
  var loading = false;

  var modalOverlay = $("#ib-notif-modal-overlay");
  var modalList = modalOverlay.find(".ib-notif-modal-list");
  var modalEmpty = modalOverlay.find(".ib-notif-empty");
  var closeModalBtn = modalOverlay.find(".ib-notif-modal-close");
  var markAllBtn = modalOverlay.find(".ib-notif-mark-all");
  var loadMoreBtn = modalOverlay.find(".ib-notif-load-more");
  var spinner = modalOverlay.find(".ib-notif-modal-spinner");
  var searchInput = modalOverlay.find(".ib-notif-search-input");
  var toast = $("#ib-notif-toast");

  var notifPage = 1;
  var notifLimit = 10;
  var notifHasMore = true;
  var notifLoading = false;
  var notifQuery = "";

  function showToast(message, icon) {
    toast.html(
      (icon ? '<span class="dashicons ' + icon + '"></span>' : "") + message
    );
    toast.fadeIn(200);
    setTimeout(function () {
      toast.fadeOut(400);
    }, 3200);
  }

  function animateBellBadge() {
    var badge = bell.find(".ib-notif-badge");
    badge.addClass("ib-badge-anim");
    setTimeout(function () {
      badge.removeClass("ib-badge-anim");
    }, 800);
  }

  function fetchNotifications() {
    if (loading) return;
    loading = true;
    $.post(
      IBNotifBell.ajaxurl,
      {
        action: "ib_get_notifications",
        nonce: IBNotifBell.nonce,
      },
      function (response) {
        loading = false;
        if (response.success && response.data && response.data.length) {
          notifList.empty();
          response.data.forEach(function (notif) {
            var typeClass = notif.type ? " " + notif.type : "";
            var li = $('<li class="ib-notif-item' + typeClass + '"></li>');
            li.toggleClass("unread", notif.status === "unread");
            // Icône selon le type
            var iconClass = "dashicons-info";
            if (notif.type === "booking_confirmed") iconClass = "dashicons-yes";
            if (notif.type === "booking_cancelled")
              iconClass = "dashicons-dismiss";
            if (notif.type === "booking_pending") iconClass = "dashicons-clock";
            var icon =
              '<span class="ib-notif-icon"><span class="dashicons ' +
              iconClass +
              '"></span></span>';
            // Titre et sous-titre
            var title = "";
            var sub = "";
            if (notif.type === "booking_confirmed") {
              title = "Réservation confirmée";
              sub = notif.message.replace("Réservation confirmée : ", "");
            } else if (notif.type === "booking_cancelled") {
              title = "Réservation annulée";
              sub = notif.message.replace("Réservation annulée : ", "");
            } else if (notif.type === "booking_pending") {
              title = "Réservation en attente";
              sub = notif.message.replace(
                "Réservation remise en attente : ",
                ""
              );
            } else if (notif.type === "booking_new") {
              title = "Nouvelle réservation";
              sub = notif.message.replace("Nouvelle réservation : ", "");
            } else {
              title = "Notification";
              sub = notif.message;
            }
            var badgeNouveau =
              notif.status === "unread"
                ? '<span class="ib-notif-badge-nouveau">Nouveau</span>'
                : "";
            var link = notif.link
              ? '<a href="' +
                notif.link +
                '" class="ib-notif-link" target="_blank">Voir</a>'
              : "";
            var date = '<span class="ib-notif-date">' + notif.date + "</span>";
            // Structure feed social
            var content =
              '<div class="ib-notif-content">' +
              '<div class="ib-notif-title">' +
              title +
              badgeNouveau +
              "</div>" +
              '<div class="ib-notif-sub">' +
              sub +
              "</div>" +
              '<div class="ib-notif-actions">' +
              link +
              date +
              "</div>" +
              "</div>";
            li.html(icon + content);
            li.data("notif-id", notif.id);
            notifList.append(li);
          });
          badge
            .text(response.data.filter((n) => n.status === "unread").length)
            .show();
          emptyMsg.hide();
        } else {
          notifList.empty();
          badge.hide();
          emptyMsg.show();
        }
      }
    );
  }

  function openNotifModal() {
    modalOverlay.show();
    $("body").css("overflow", "hidden");
    notifPage = 1;
    notifHasMore = true;
    notifQuery = searchInput.val();
    fetchNotificationsModal(true);
  }

  function closeNotifModal() {
    modalOverlay.hide();
    $("body").css("overflow", "");
  }

  bell.find(".ib-notif-bell-btn").on("click", function (e) {
    e.stopPropagation();
    openNotifModal();
  });

  closeModalBtn.on("click", function () {
    closeNotifModal();
  });

  modalOverlay.on("click", function (e) {
    if (e.target === this) closeNotifModal();
  });

  // Scroll infini
  modalList.on("scroll", function () {
    if (!notifHasMore || notifLoading) return;
    if (
      modalList[0].scrollHeight -
        modalList.scrollTop() -
        modalList.outerHeight() <
      120
    ) {
      notifPage++;
      fetchNotificationsModal(false);
    }
  });
  loadMoreBtn.on("click", function () {
    notifPage++;
    fetchNotificationsModal(false);
  });
  // Recherche/filtrage
  searchInput.on("input", function () {
    notifPage = 1;
    notifHasMore = true;
    notifQuery = $(this).val();
    fetchNotificationsModal(true);
  });
  // Tout marquer comme lu
  markAllBtn.on("click", function () {
    $.post(
      IBNotifBell.ajaxurl,
      { action: "ib_mark_all_notifications_read", nonce: IBNotifBell.nonce },
      function (resp) {
        if (resp.success) {
          showToast("Toutes les notifications sont lues", "dashicons-yes");
          fetchNotificationsModal(true);
        }
      }
    );
  });
  // Suppression individuelle
  modalList.on("click", ".ib-notif-delete", function (e) {
    e.stopPropagation();
    var notifId = $(this).closest(".ib-notif-item").data("notif-id");
    $.post(
      IBNotifBell.ajaxurl,
      {
        action: "ib_delete_notification",
        nonce: IBNotifBell.nonce,
        id: notifId,
      },
      function (resp) {
        if (resp.success) {
          showToast("Notification supprimée", "dashicons-trash");
          fetchNotificationsModal(true);
        }
      }
    );
  });
  // Marque comme lu au clic sur une notif dans la modal
  modalList.on("click", ".ib-notif-item.unread", function () {
    var notifId = $(this).data("notif-id");
    var item = $(this);
    $.post(
      IBNotifBell.ajaxurl,
      {
        action: "ib_mark_notification_read",
        nonce: IBNotifBell.nonce,
        id: notifId,
      },
      function (resp) {
        if (resp.success) {
          item.removeClass("unread");
          fetchNotificationsModal(true);
        }
      }
    );
  });
  // Charger les notifications dans la modal (scroll infini, recherche, spinner)
  function fetchNotificationsModal(reset) {
    if (notifLoading) return;
    notifLoading = true;
    if (reset) {
      modalList.empty();
      modalEmpty.hide();
      notifPage = 1;
    }
    spinner.show();
    loadMoreBtn.hide();
    $.post(
      IBNotifBell.ajaxurl,
      {
        action: "ib_get_notifications",
        nonce: IBNotifBell.nonce,
        page: notifPage,
        limit: notifLimit,
        query: notifQuery,
      },
      function (response) {
        spinner.hide();
        notifLoading = false;
        if (response.success && response.data && response.data.length) {
          response.data.forEach(function (notif) {
            var typeClass = notif.type ? " " + notif.type : "";
            var li = $('<li class="ib-notif-item' + typeClass + '"></li>');
            li.toggleClass("unread", notif.status === "unread");
            var iconClass = "dashicons-info";
            if (notif.type === "booking_confirmed") iconClass = "dashicons-yes";
            if (notif.type === "booking_cancelled")
              iconClass = "dashicons-dismiss";
            if (notif.type === "booking_pending") iconClass = "dashicons-clock";
            var avatar = notif.avatar
              ? '<img src="' + notif.avatar + '" class="ib-notif-avatar" />'
              : "";
            var icon =
              avatar ||
              '<span class="ib-notif-icon"><span class="dashicons ' +
                iconClass +
                '"></span></span>';
            var title = "";
            var sub = "";
            if (notif.type === "booking_confirmed") {
              title = "Réservation confirmée";
              sub = notif.message.replace("Réservation confirmée : ", "");
            } else if (notif.type === "booking_cancelled") {
              title = "Réservation annulée";
              sub = notif.message.replace("Réservation annulée : ", "");
            } else if (notif.type === "booking_pending") {
              title = "Réservation en attente";
              sub = notif.message.replace(
                "Réservation remise en attente : ",
                ""
              );
            } else if (notif.type === "booking_new") {
              title = "Nouvelle réservation";
              sub = notif.message.replace("Nouvelle réservation : ", "");
            } else {
              title = "Notification";
              sub = notif.message;
            }
            var badgeNouveau =
              notif.status === "unread"
                ? '<span class="ib-notif-badge-nouveau">Nouveau</span>'
                : "";
            var link = notif.link
              ? '<a href="' +
                notif.link +
                '" class="ib-notif-link" target="_blank">Voir</a>'
              : "";
            var date = '<span class="ib-notif-date">' + notif.date + "</span>";
            var del =
              '<button class="ib-notif-delete" title="Supprimer">🗑️</button>';
            var content =
              '<div class="ib-notif-content">' +
              '<div class="ib-notif-title">' +
              title +
              badgeNouveau +
              "</div>" +
              '<div class="ib-notif-sub">' +
              sub +
              "</div>" +
              '<div class="ib-notif-actions">' +
              link +
              date +
              "</div>" +
              "</div>";
            li.html(icon + content + del);
            li.data("notif-id", notif.id);
            modalList.append(li);
          });
          notifHasMore = response.data.length === notifLimit;
          if (notifHasMore) loadMoreBtn.show();
          else loadMoreBtn.hide();
        } else {
          if (notifPage === 1) modalEmpty.show();
          notifHasMore = false;
          loadMoreBtn.hide();
        }
      }
    );
  }
  // Rafraîchissement auto toutes les 30s
  setInterval(function () {
    var oldCount = parseInt(bell.find(".ib-notif-badge").text() || "0", 10);
    $.post(
      IBNotifBell.ajaxurl,
      {
        action: "ib_get_notifications",
        nonce: IBNotifBell.nonce,
        page: 1,
        limit: 1,
      },
      function (resp) {
        if (resp.success && resp.data) {
          var newCount = resp.data.filter((n) => n.status === "unread").length;
          if (newCount > oldCount) animateBellBadge();
        }
      }
    );
    fetchNotificationsModal(true);
  }, 30000);

  // Premier chargement
  fetchNotifications();
});
