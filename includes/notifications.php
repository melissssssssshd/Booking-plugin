<?php
if (!defined('ABSPATH')) exit;

/**
 * Gestion des notifications
 */
class IB_Notifications {
    /**
     * Envoie une notification par email
     */
    public static function send_email($to, $subject, $message) {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        return wp_mail($to, $subject, $message, $headers);
    }

    /**
     * Envoie une notification SMS
     */
    public static function send_sms($to, $message) {
        // À implémenter avec un service SMS
        return false;
    }

    /**
     * Envoie une notification push
     */
    public static function send_push($user_id, $title, $message) {
        // À implémenter avec un service push
        return false;
    }

    /**
     * Envoie une notification WhatsApp
     */
    public static function send_whatsapp($to, $message) {
        // À implémenter avec l'API WhatsApp
        return false;
    }

    /**
     * Envoie une notification de rappel
     */
    public static function send_reminder($booking_id) {
        $booking = IB_Bookings::get_by_id($booking_id);
        if (!$booking) return false;

        $client = IB_Clients::get_by_id($booking->client_id);
        $service = IB_Services::get_by_id($booking->service_id);
        $employee = IB_Employees::get_by_id($booking->employee_id);

        // Email
        $subject = sprintf(__('Rappel : Rendez-vous %s', 'institut-booking'), $service->name);
        $message = sprintf(
            __('Bonjour %s,<br><br>Ceci est un rappel pour votre rendez-vous :<br><br>Service : %s<br>Date : %s<br>Heure : %s<br>Employé : %s<br><br>Cordialement,<br>%s', 'institut-booking'),
            $client->name,
            $service->name,
            date_i18n(get_option('date_format'), strtotime($booking->start_time)),
            date_i18n(get_option('time_format'), strtotime($booking->start_time)),
            $employee->name,
            get_bloginfo('name')
        );
        self::send_email($client->email, $subject, $message);

        // SMS
        if ($client->phone) {
            $sms_message = sprintf(
                __('Rappel RDV : %s le %s à %s avec %s', 'institut-booking'),
                $service->name,
                date_i18n(get_option('date_format'), strtotime($booking->start_time)),
                date_i18n(get_option('time_format'), strtotime($booking->start_time)),
                $employee->name
            );
            self::send_sms($client->phone, $sms_message);
        }

        // Push
        if ($client->push_token) {
            self::send_push($client->id, $subject, $message);
        }

        // WhatsApp
        if ($client->whatsapp) {
            self::send_whatsapp($client->whatsapp, $message);
        }

        return true;
    }

    /**
     * Envoie une notification de confirmation
     */
    public static function send_confirmation($booking_id) {
        $booking = IB_Bookings::get_by_id($booking_id);
        if (!$booking) return false;

        $client = IB_Clients::get_by_id($booking->client_id);
        $service = IB_Services::get_by_id($booking->service_id);
        $employee = IB_Employees::get_by_id($booking->employee_id);

        // Email
        $subject = sprintf(__('Confirmation : Rendez-vous %s', 'institut-booking'), $service->name);
        $message = sprintf(
            __('Bonjour %s,<br><br>Votre rendez-vous a été confirmé :<br><br>Service : %s<br>Date : %s<br>Heure : %s<br>Employé : %s<br><br>Cordialement,<br>%s', 'institut-booking'),
            $client->name,
            $service->name,
            date_i18n(get_option('date_format'), strtotime($booking->start_time)),
            date_i18n(get_option('time_format'), strtotime($booking->start_time)),
            $employee->name,
            get_bloginfo('name')
        );
        self::send_email($client->email, $subject, $message);

        // SMS
        if ($client->phone) {
            $sms_message = sprintf(
                __('RDV confirmé : %s le %s à %s avec %s', 'institut-booking'),
                $service->name,
                date_i18n(get_option('date_format'), strtotime($booking->start_time)),
                date_i18n(get_option('time_format'), strtotime($booking->start_time)),
                $employee->name
            );
            self::send_sms($client->phone, $sms_message);
        }

        // Push
        if ($client->push_token) {
            self::send_push($client->id, $subject, $message);
        }

        // WhatsApp
        if ($client->whatsapp) {
            self::send_whatsapp($client->whatsapp, $message);
        }

        return true;
    }

    /**
     * Envoie une notification d'annulation
     */
    public static function send_cancellation($booking_id) {
        $booking = IB_Bookings::get_by_id($booking_id);
        if (!$booking) return false;

        $client = IB_Clients::get_by_id($booking->client_id);
        $service = IB_Services::get_by_id($booking->service_id);
        $employee = IB_Employees::get_by_id($booking->employee_id);

        // Email
        $subject = sprintf(__('Annulation : Rendez-vous %s', 'institut-booking'), $service->name);
        $message = sprintf(
            __('Bonjour %s,<br><br>Votre rendez-vous a été annulé :<br><br>Service : %s<br>Date : %s<br>Heure : %s<br>Employé : %s<br><br>Cordialement,<br>%s', 'institut-booking'),
            $client->name,
            $service->name,
            date_i18n(get_option('date_format'), strtotime($booking->start_time)),
            date_i18n(get_option('time_format'), strtotime($booking->start_time)),
            $employee->name,
            get_bloginfo('name')
        );
        self::send_email($client->email, $subject, $message);

        // SMS
        if ($client->phone) {
            $sms_message = sprintf(
                __('RDV annulé : %s le %s à %s avec %s', 'institut-booking'),
                $service->name,
                date_i18n(get_option('date_format'), strtotime($booking->start_time)),
                date_i18n(get_option('time_format'), strtotime($booking->start_time)),
                $employee->name
            );
            self::send_sms($client->phone, $sms_message);
        }

        // Push
        if ($client->push_token) {
            self::send_push($client->id, $subject, $message);
        }

        // WhatsApp
        if ($client->whatsapp) {
            self::send_whatsapp($client->whatsapp, $message);
        }

        return true;
    }
} 