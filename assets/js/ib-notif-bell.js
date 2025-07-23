// Check if jQuery is available and prevent conflicts
if (typeof jQuery !== 'undefined' && !window.ibBellNotificationsInitialized) {
  window.ibBellNotificationsInitialized = true;
  
  jQuery(document).ready(function ($) {
    // Vérifier que les variables globales sont définies
    if (typeof IBNotifBellVars === "undefined") {
      console.error("IBNotifBellVars variables not defined");
      return;
    }

  // Fonction pour obtenir l'URL AJAX de manière sécurisée
  function getAjaxUrl() {
    return IBNotifBellVars.ajaxurl || ajaxurl || "/wp-admin/admin-ajax.php";
  }

  // Fonction pour obtenir le nonce de manière sécurisée
  function getNonce() {
    return IBNotifBellVars.nonce || "";
  }

  // Sélecteurs
  var bell = $(".ib-notif-bell");
  var bellBtn = bell.find(".ib-notif-bell-btn");
  var badge = bell.find(".ib-notif-badge");
  var dropdown = $("#ib-notif-dropdown");
  var notifList = $("#ib-notif-list");
  var emptyMsg = $("#ib-notif-empty");
  var markAllBtn = $("#ib-notif-mark-all");

  // Modal elements
  var modalOverlay = $(".ib-notif-modal-overlay");
  var modalList = $(".ib-notif-modal-list");
  var modalEmpty = $(".ib-notif-modal-empty");
  var closeModalBtn = $(".ib-notif-modal-close");
  var searchInput = $(".ib-notif-search");
  var spinner = $(".ib-notif-spinner");
  var loadMoreBtn = $(".ib-notif-load-more");

  // Variables pour pagination et état
  var notifPage = 1;
  var notifLimit = 10;
  var notifHasMore = true;
  var notifLoading = false;
  var notifQuery = "";

  // Fonction pour charger les notifications (dropdown)
  function fetchNotifications() {
    $.post(
      getAjaxUrl(),
      {
        action: "ib_get_notifications",
        nonce: getNonce(),
        page: 1,
        limit: 5
      },
      function (response) {
        if (response.success && response.data && response.data.length) {
          notifList.empty();
          response.data.forEach(function (notif) {
            var typeClass = notif.type ? " " + notif.type : "";
            var li = $('<li class="ib-notif-item' + typeClass + '"></li>');
            li.toggleClass("unread", notif.status === "unread");
            // Icône selon le type
            var iconClass = "dashicons-info";
            if (notif.type === "booking_confirmed") iconClass = "dashicons-yes";
            if (notif.type === "booking_cancelled") iconClass = "dashicons-dismiss";
            if (notif.type === "booking_pending") iconClass = "dashicons-clock";
            if (notif.type === "booking_new") iconClass = "dashicons-plus";
            
            var icon = '<span class="ib-notif-icon"><span class="dashicons ' + iconClass + '"></span></span>';
            
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
              sub = notif.message.replace("Réservation remise en attente : ", "");
            } else if (notif.type === "booking_new") {
              title = "Nouvelle réservation";
              sub = notif.message.replace("Nouvelle réservation : ", "");
            } else {
              title = "Notification";
              sub = notif.message;
            }
            
            var badgeNouveau = notif.status === "unread" ? '<span class="ib-notif-badge-nouveau">Nouveau</span>' : "";
            var link = notif.link ? '<a href="' + notif.link + '" class="ib-notif-link" target="_blank">Voir</a>' : "";
            var date = '<span class="ib-notif-date">' + (notif.created_at || notif.date || "") + "</span>";
            
            // Structure feed social
            var content = '<div class="ib-notif-content">' +
              '<div class="ib-notif-title">' + title + badgeNouveau + "</div>" +
              '<div class="ib-notif-sub">' + sub + "</div>" +
              '<div class="ib-notif-actions">' + link + date + "</div>" +
              "</div>";
            
            li.html(icon + content);
            li.data("notif-id", notif.id);
            if (notifList.length) notifList.append(li);
          });
          
          var unreadCount = response.data.filter((n) => n.status === "unread").length;
          if (badge.length) {
            if (unreadCount > 0) {
              badge.text(unreadCount).show();
            } else {
              badge.hide();
            }
          }
          if (emptyMsg.length) emptyMsg.hide();
        } else {
          console.log("fetchNotifications: No data or empty response", response);
          if (notifList.length) notifList.empty();
          if (badge.length) badge.hide();
          if (emptyMsg.length) emptyMsg.show();
        }
      }
    ).fail(function(jqXHR, textStatus, errorThrown) {
      console.error("fetchNotifications AJAX error:", textStatus, errorThrown, jqXHR.responseText);
      if (notifList.length) notifList.empty();
      if (badge.length) badge.hide();
      if (emptyMsg.length) emptyMsg.show();
    });
  }

  // Animation du badge
  function animateBellBadge() {
    if (badge.length) {
      badge.addClass("ib-pulse");
      setTimeout(function() {
        badge.removeClass("ib-pulse");
      }, 1000);
    }
  }

  // Fonction pour afficher un toast
  function showToast(message, icon) {
    var toast = $('<div class="ib-toast"><span class="dashicons ' + icon + '"></span> ' + message + '</div>');
    $("body").append(toast);
    toast.addClass("show");
    setTimeout(function() {
      toast.removeClass("show");
      setTimeout(function() {
        toast.remove();
      }, 300);
    }, 3000);
  }

  // Fonction pour ouvrir la modal
  function openNotifModal() {
    if (modalOverlay.length) {
      modalOverlay.show();
      $("body").css("overflow", "hidden");
      notifPage = 1;
      notifHasMore = true;
      fetchNotificationsModal(true);
    }
  }

  // Fonction pour fermer la modal
  function closeNotifModal() {
    if (modalOverlay.length) {
      modalOverlay.hide();
      $("body").css("overflow", "");
    }
  }

  // Event listeners
  bellBtn.on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (dropdown.length && dropdown.is(":visible")) {
      dropdown.hide();
    } else if (dropdown.length) {
      dropdown.show();
      fetchNotifications();
    } else {
      // Si pas de dropdown, ouvrir la modal
      openNotifModal();
    }
  });

  // Fermer le dropdown en cliquant ailleurs
  $(document).on("click", function (e) {
    if (!bell.is(e.target) && bell.has(e.target).length === 0) {
      if (dropdown.length) dropdown.hide();
    }
  });

  // Marquer une notification comme lue au clic
  notifList.on("click", ".ib-notif-item.unread", function () {
    var notifId = $(this).data("notif-id");
    var item = $(this);
    $.post(
      getAjaxUrl(),
      {
        action: "ib_mark_notification_read",
        nonce: getNonce(),
        id: notifId,
      },
      function (resp) {
        if (resp.success) {
          item.removeClass("unread");
          fetchNotifications();
        }
      }
    );
  });

  // Marquer toutes les notifications comme lues
  markAllBtn.on("click", function () {
    $.post(
      getAjaxUrl(),
      {
        action: "ib_mark_all_notifications_read",
        nonce: getNonce(),
      },
      function (resp) {
        if (resp.success) {
          showToast("Toutes les notifications sont lues", "dashicons-yes");
          fetchNotifications();
        }
      }
    );
  });

  // Modal event listeners
  if (closeModalBtn.length) {
    closeModalBtn.on("click", function () {
      closeNotifModal();
    });
  }

  if (modalOverlay.length) {
    modalOverlay.on("click", function (e) {
      if (e.target === this) closeNotifModal();
    });
  }

  // Scroll infini dans la modal
  if (modalList.length) {
    modalList.on("scroll", function () {
      if (!notifHasMore || notifLoading) return;
      var scrollElement = modalList[0];
      if (scrollElement && scrollElement.scrollHeight) {
        if (scrollElement.scrollHeight - modalList.scrollTop() - modalList.outerHeight() < 120) {
          notifPage++;
          fetchNotificationsModal(false);
        }
      }
    });
  }

  // Bouton charger plus
  if (loadMoreBtn.length) {
    loadMoreBtn.on("click", function () {
      notifPage++;
      fetchNotificationsModal(false);
    });
  }

  // Recherche/filtrage
  if (searchInput.length) {
    searchInput.on("input", function () {
      notifPage = 1;
      notifHasMore = true;
      notifQuery = $(this).val();
      fetchNotificationsModal(true);
    });
  }

  // Charger les notifications dans la modal
  function fetchNotificationsModal(reset) {
    if (notifLoading) return;
    notifLoading = true;
    
    if (reset) {
      if (modalList.length) modalList.empty();
      if (modalEmpty.length) modalEmpty.hide();
      notifPage = 1;
    }
    
    if (spinner.length) spinner.show();
    if (loadMoreBtn.length) loadMoreBtn.hide();
    
    $.post(
      getAjaxUrl(),
      {
        action: "ib_get_notifications",
        nonce: getNonce(),
        page: notifPage,
        limit: notifLimit,
        query: notifQuery,
      },
      function (response) {
        if (spinner.length) spinner.hide();
        notifLoading = false;
        
        if (response.success && response.data && response.data.length) {
          response.data.forEach(function (notif) {
            var typeClass = notif.type ? " " + notif.type : "";
            var li = $('<li class="ib-notif-item' + typeClass + '"></li>');
            li.toggleClass("unread", notif.status === "unread");
            
            var iconClass = "dashicons-info";
            if (notif.type === "booking_confirmed") iconClass = "dashicons-yes";
            if (notif.type === "booking_cancelled") iconClass = "dashicons-dismiss";
            if (notif.type === "booking_pending") iconClass = "dashicons-clock";
            if (notif.type === "booking_new") iconClass = "dashicons-plus";
            
            var avatar = notif.avatar ? '<img src="' + notif.avatar + '" class="ib-notif-avatar" />' : "";
            var icon = avatar || '<span class="ib-notif-icon"><span class="dashicons ' + iconClass + '"></span></span>';
            
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
              sub = notif.message.replace("Réservation remise en attente : ", "");
            } else if (notif.type === "booking_new") {
              title = "Nouvelle réservation";
              sub = notif.message.replace("Nouvelle réservation : ", "");
            } else {
              title = "Notification";
              sub = notif.message;
            }
            
            var badgeNouveau = notif.status === "unread" ? '<span class="ib-notif-badge-nouveau">Nouveau</span>' : "";
            var link = notif.link ? '<a href="' + notif.link + '" class="ib-notif-link" target="_blank">Voir</a>' : "";
            var date = '<span class="ib-notif-date">' + (notif.created_at || notif.date || "") + "</span>";
            var del = '<button class="ib-notif-delete" title="Supprimer">🗑️</button>';
            
            var content = '<div class="ib-notif-content">' +
              '<div class="ib-notif-title">' + title + badgeNouveau + "</div>" +
              '<div class="ib-notif-sub">' + sub + "</div>" +
              '<div class="ib-notif-actions">' + link + date + "</div>" +
              "</div>";
            
            li.html(icon + content + del);
            li.data("notif-id", notif.id);
            if (modalList.length) modalList.append(li);
          });
          
          notifHasMore = response.data.length === notifLimit;
          if (notifHasMore && loadMoreBtn.length) loadMoreBtn.show();
          else if (loadMoreBtn.length) loadMoreBtn.hide();
        } else {
          console.log("fetchNotificationsModal: No data or empty response", response);
          if (notifPage === 1 && modalEmpty.length) modalEmpty.show();
          notifHasMore = false;
          if (loadMoreBtn.length) loadMoreBtn.hide();
        }
      }
    ).fail(function(jqXHR, textStatus, errorThrown) {
      console.error("fetchNotificationsModal AJAX error:", textStatus, errorThrown, jqXHR.responseText);
      if (spinner.length) spinner.hide();
      notifLoading = false;
      if (notifPage === 1 && modalEmpty.length) modalEmpty.show();
      notifHasMore = false;
      if (loadMoreBtn.length) loadMoreBtn.hide();
    });
  }

  // Event listeners pour la modal
  if (modalList.length) {
    // Suppression individuelle
    modalList.on("click", ".ib-notif-delete", function (e) {
      e.stopPropagation();
      var notifId = $(this).closest(".ib-notif-item").data("notif-id");
      $.post(
        getAjaxUrl(),
        {
          action: "ib_delete_notification",
          nonce: getNonce(),
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

    // Marquer comme lu au clic sur une notif dans la modal
    modalList.on("click", ".ib-notif-item.unread", function () {
      var notifId = $(this).data("notif-id");
      var item = $(this);
      $.post(
        getAjaxUrl(),
        {
          action: "ib_mark_notification_read",
          nonce: getNonce(),
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
  }

  // Auto-refresh toutes les 30 secondes
  setInterval(function () {
    var oldCount = parseInt(badge.text() || "0", 10);
    $.post(
      getAjaxUrl(),
      {
        action: "ib_get_notifications",
        nonce: getNonce(),
        page: 1,
        limit: notifLimit,
      },
      function (resp) {
        if (resp.success && resp.data) {
          var newCount = resp.data.filter((n) => n.status === "unread").length;
          if (newCount > oldCount) animateBellBadge();
          fetchNotifications();
        }
      }
    );
    
    // Ne pas rafraîchir la modal si elle n'est pas ouverte
    if (modalOverlay.length && modalOverlay.is(":visible")) {
      fetchNotificationsModal(true);
    }
  }, 30000);

  // Premier chargement
  fetchNotifications();
  });
} else {
  console.warn('jQuery not available or notifications already initialized');
}
