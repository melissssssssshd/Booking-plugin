<?php
if (!defined('ABSPATH')) exit;

class IB_Availability {
    public static function get_available_slots($employee_id, $service_id, $date) {
        global $wpdb;
        
        // Récupérer la durée du service
        $service = IB_Services::get_by_id($service_id);
        if (!$service || !isset($service->duration)) {
            return [];
        }
        $duration = intval($service->duration);

        // Récupérer le jour de la semaine
        $day = strtolower(date('l', strtotime($date)));
        
        // Récupérer les horaires d'ouverture dynamiques
        $opening = get_option('ib_opening_time', '09:00');
        $closing = get_option('ib_closing_time', '17:00');
        $opening_hours = [
            'start' => $opening,
            'end' => $closing
        ];

        // Vérifier si le jour est ouvert (optionnel : ajouter gestion jours off/specials ici)
        // Si tu as une logique de jours off, ajoute-la ici !
        if (!$opening_hours['start'] || !$opening_hours['end']) {
            return [];
        }

        // Calculer les heures d'ouverture pour ce jour
        $start_time = strtotime($date . ' ' . $opening_hours['start']);
        $end_time = strtotime($date . ' ' . $opening_hours['end']);

        // Créer un tableau des créneaux possibles
        $slots = [];
        $current_time = $start_time;
        
        while ($current_time + ($duration * 60) <= $end_time) {
            $time = date('H:i', $current_time);
            $slots[] = $time;
            $current_time += 30 * 60; // Créneaux de 30 minutes
        }

        // Vérifier les conflits pour chaque créneau
        $available_slots = [];
        foreach ($slots as $slot) {
            // On passe explicitement la durée du service
            if (!IB_Bookings::has_conflict($employee_id, $date, $slot, $duration)) {
                $available_slots[] = $slot;
            }
        }

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
