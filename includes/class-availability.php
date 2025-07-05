<?php
if (!defined('ABSPATH')) exit;

class IB_Availability {
    private static $opening_hours = [
        'monday' => ['start' => '09:00', 'end' => '17:00'],
        'tuesday' => ['start' => '09:00', 'end' => '17:00'],
        'wednesday' => ['start' => '09:00', 'end' => '17:00'],
        'thursday' => ['start' => '09:00', 'end' => '17:00'],
        'friday' => ['start' => '09:00', 'end' => '17:00'],
        'saturday' => ['start' => '09:00', 'end' => '17:00'],
        'sunday' => ['start' => '09:00', 'end' => '17:00']
    ];

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
        
        // Vérifier si le jour est dans les heures d'ouverture
        if (!isset(self::$opening_hours[$day])) {
            return [];
        }

        // Calculer les heures d'ouverture pour ce jour
        $start_time = strtotime($date . ' ' . self::$opening_hours[$day]['start']);
        $end_time = strtotime($date . ' ' . self::$opening_hours[$day]['end']);

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
            if (!IB_Bookings::has_conflict($employee_id, $date, $slot, $duration)) {
                $available_slots[] = $slot;
            }
        }

        return $available_slots;
    }

    public static function get_opening_hours($day) {
        $day = strtolower($day);
        return isset(self::$opening_hours[$day]) ? self::$opening_hours[$day] : null;
    }

    public static function is_day_open($day) {
        $day = strtolower($day);
        return isset(self::$opening_hours[$day]);
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
