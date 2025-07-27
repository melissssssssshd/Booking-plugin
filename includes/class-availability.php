<?php
if (!defined('ABSPATH')) exit;

class IB_Availability {
    public static function get_available_slots($employee_id, $service_id, $date) {
        global $wpdb;

        error_log("🔍 get_available_slots: employee_id=$employee_id, service_id=$service_id, date=$date");

        // Récupérer la durée du service
        $service = IB_Services::get_by_id($service_id);
        if (!$service || !isset($service->duration)) {
            error_log("❌ Service non trouvé ou durée manquante pour service_id=$service_id");
            return [];
        }
        $duration = intval($service->duration);
        error_log("✅ Service trouvé: durée=$duration minutes");

        // Récupérer le jour de la semaine
        $day = strtolower(date('l', strtotime($date)));
        error_log("🔍 Jour de la semaine: $day");

        // Récupérer les horaires d'ouverture dynamiques
        $opening = get_option('ib_opening_time', '09:00');
        $closing = get_option('ib_closing_time', '17:00');
        $opening_hours = [
            'start' => $opening,
            'end' => $closing
        ];
        error_log("🔍 Horaires d'ouverture: " . print_r($opening_hours, true));

        // Vérifier si le jour est ouvert (optionnel : ajouter gestion jours off/specials ici)
        // Si tu as une logique de jours off, ajoute-la ici !
        if (!$opening_hours['start'] || !$opening_hours['end']) {
            error_log("❌ Horaires d'ouverture manquants");
            return [];
        }

        // Calculer les heures d'ouverture pour ce jour
        $start_time = strtotime($date . ' ' . $opening_hours['start']);
        $end_time = strtotime($date . ' ' . $opening_hours['end']);

        error_log("🔍 Heures calculées: start_time=" . date('Y-m-d H:i', $start_time) . ", end_time=" . date('Y-m-d H:i', $end_time));

        // Créer un tableau des créneaux possibles
        $slots = [];
        $current_time = $start_time;

        while ($current_time + ($duration * 60) <= $end_time) {
            $time = date('H:i', $current_time);
            $slots[] = $time;
            $current_time += 30 * 60; // Créneaux de 30 minutes
        }

        error_log("🔍 Créneaux générés avant filtrage: " . print_r($slots, true));

        // Filtrage strict des créneaux passés si la date est aujourd'hui
        if ($date === date('Y-m-d')) {
            $now = strtotime(current_time('H:i'));
            $filtered = [];
            foreach ($slots as $slot) {
                // $slot est une chaîne de caractères (ex: "09:00")
                if (preg_match('/^\d{2}:\d{2}$/', $slot)) {
                    $slot_time = strtotime($date . ' ' . $slot);
                    if ($slot_time > $now) {
                        $filtered[] = $slot;
                    }
                }
            }
            $slots = $filtered;
            error_log("🔍 Créneaux après filtrage (aujourd'hui): " . print_r($slots, true));
        }

        // FILTRAGE CRITIQUE : Éliminer les créneaux en conflit pour cet employé
        require_once plugin_dir_path(__FILE__) . '/class-bookings.php';
        $available_slots = [];
        foreach ($slots as $slot) {
            $conflict = IB_Bookings::has_conflict($employee_id, $date, $slot);
            if (!$conflict) {
                $available_slots[] = $slot;
            } else {
                error_log("🔍 Créneau $slot exclu (conflit pour employee_id=$employee_id)");
            }
        }

        error_log("✅ Créneaux finaux retournés (après filtrage conflits): " . print_r($available_slots, true));
        return $available_slots;
    }

    public static function get_opening_hours($day) {
        // Retourne les horaires dynamiques pour n'importe quel jour
        $opening = get_option('ib_opening_time', '09:00');
        $closing = get_option('ib_closing_time', '17:00');
        return [
            'start' => $opening,
            'end' => $closing
        ];
    }

    public static function is_day_open($day) {
        // Ici tu peux ajouter la logique pour jours off/specials si besoin
        $opening = get_option('ib_opening_time', '09:00');
        $closing = get_option('ib_closing_time', '17:00');
        return !empty($opening) && !empty($closing);
    }

    public static function get_next_available_date($employee_id, $service_id, $start_date = null) {
        if (!$start_date) {
            $start_date = current_time('Y-m-d');
        }

        $date = strtotime($start_date);
        $max_days = 30; // Limite à 30 jours maximum
        
        for ($i = 0; $i < $max_days; $i++) {
            $current_date = date('Y-m-d', $date);
            $day = strtolower(date('l', $date));
            
            if (self::is_day_open($day)) {
                $slots = self::get_available_slots($employee_id, $service_id, $current_date);
                if (!empty($slots)) {
                    return $current_date;
                }
            }
            $date = strtotime('+1 day', $date);
        }
        return false;
    }
}
