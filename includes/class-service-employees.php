<?php
// Table de liaison services-employés
if (!defined('ABSPATH')) exit;

class IB_Service_Employees {
    public static function add($service_id, $employee_id) {
        global $wpdb;
        $wpdb->insert("{$wpdb->prefix}ib_service_employees", [
            'service_id' => intval($service_id),
            'employee_id' => intval($employee_id),
        ]);
    }
    public static function get_employees_for_service($service_id) {
        global $wpdb;
        return $wpdb->get_col($wpdb->prepare("SELECT employee_id FROM {$wpdb->prefix}ib_service_employees WHERE service_id = %d", $service_id));
    }
    public static function set_employees_for_service($service_id, $employee_ids) {
        global $wpdb;
        $wpdb->delete("{$wpdb->prefix}ib_service_employees", ['service_id' => intval($service_id)]);
        foreach ($employee_ids as $eid) {
            $wpdb->insert("{$wpdb->prefix}ib_service_employees", [
                'service_id' => intval($service_id),
                'employee_id' => intval($eid),
            ]);
        }
    }
}
