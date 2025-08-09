/**
 * Script d'administration pour le plugin de réservation
 * Gère les fonctionnalités du back-office
 */

// Gestion des toasts
function initToasts() {
    const toasts = document.querySelectorAll(".ib-toast");
    toasts.forEach(toast => {
        if (toast.style.display === "block") {
            setTimeout(() => {
                toast.style.display = "none";
            }, 3500);
        }
    });
}

// Formatage des dates pour MySQL
window.formatDateToMysql = function(dateStr) {
    if (!dateStr) return "";
    const parts = dateStr.split("/");
    if (parts.length === 3) {
        return `${parts[2]}-${parts[1].padStart(2, "0")}-${parts[0].padStart(2, "0")}`;
    }
    return dateStr;
};

// Gestion des créneaux horaires
function initTimeSlots() {
    window.updateTimeSlots = function() {
        const dateInput = document.querySelector("#ib-booking-date");
        const serviceInput = document.querySelector("#ib-service-select");
        const employeeInput = document.querySelector("#ib-employee-select");
        const slotsContainer = document.querySelector("#ib-time-slots");
        
        if (!dateInput || !serviceInput || !employeeInput || !slotsContainer) {
            console.error("Éléments manquants pour la mise à jour des créneaux");
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
        const ajaxurl = window.ib_admin_vars?.ajaxurl || 
                       (window.IBNotifBell?.ajaxurl || false);
        
        if (!ajaxurl) {
            slotsContainer.innerHTML = 
                '<span style="color:#d32f2f">Erreur critique : ajaxurl non défini.</span>';
            console.error("Erreur: ajaxurl non défini");
            return;
        }
        
        fetch(ajaxurl + "?action=ib_get_time_slots", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                date: date,
                service_id: service,
                employee_id: employee
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                if (data.data.length === 0) {
                    slotsContainer.innerHTML = 
                        '<span style="color:#888">Aucun créneau disponible ce jour.</span>';
                } else {
                    slotsContainer.innerHTML = data.data
                        .map(slot => 
                            `<button type="button" class="ib-slot-btn" data-time="${slot}">${slot}</button>`
                        )
                        .join("");
                }
            } else {
                throw new Error("Format de données invalide");
            }
        })
        .catch(error => {
            console.error("Erreur lors du chargement des créneaux:", error);
            slotsContainer.innerHTML = 
                '<span style="color:#d32f2f">Erreur lors du chargement des créneaux.</span>';
        });
    };

    // Gestion de la sélection d'un créneau
    window.selectTimeSlot = function(btn) {
        document.querySelectorAll(".ib-slot-btn").forEach(b => b.classList.remove("selected"));
        btn.classList.add("selected");
        const timeInput = document.querySelector("#ib-booking-time");
        if (timeInput) timeInput.value = btn.dataset.time;
    };
    
    // Délégation d'événements pour les boutons de créneaux
    document.addEventListener('click', function(e) {
        if (e.target.matches('.ib-slot-btn')) {
            selectTimeSlot(e.target);
        }
    });
}

// Initialisation au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initialisation du script admin...');
    
    // Désactiver l'ancien système de notifications
    if (!window.ibNotificationsInitialized) {
        window.ibNotificationsInitialized = true;
        console.log('🔔 Système de notifications admin-script.js désactivé');
        console.log('✅ ultra-simple-notification.js gère maintenant les notifications');
        
        window.fetchNotifications = function() {
            console.log('🔄 fetchNotifications redirigé vers ultra-simple-notification.js');
            if (typeof window.loadRealNotifications === 'function') {
                window.loadRealNotifications();
            }
        };
    }
    // Initialiser les composants
    initToasts();
    initTimeSlots();
    
    console.log('Script admin initialisé avec succès');
});
