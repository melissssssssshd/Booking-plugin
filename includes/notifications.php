<?php
if (!defined('ABSPATH')) exit;

/**
 * Gestion des notifications
 */
class IB_Notifications {
    /**
     * Remplace les variables dans un template d'email
     */
    private static function replace_vars($template, $vars) {
        // Supporte {client_name}, {company}, {service}, {service_name}, {date}, {time}, {employee_name}, etc.
        foreach ($vars as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }
        // Compatibilité : remplace aussi {client} par {client_name} et {service} par {service_name}
        if (isset($vars['client_name'])) {
            $template = str_replace('{client}', $vars['client_name'], $template);
        }
        if (isset($vars['service_name'])) {
            $template = str_replace('{service}', $vars['service_name'], $template);
        }
        return $template;
    }
    /**
     * Envoie un email de remerciement après réservation
     */
    public static function send_thank_you($booking_id) {
        global $wpdb;
        $booking = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}ib_bookings WHERE id = %d", $booking_id));
        if (!$booking) return false;
        require_once plugin_dir_path(__FILE__) . '/class-services.php';
        $service = IB_Services::get_by_id($booking->service_id);
        $company = get_bloginfo('name');
        $client_name = isset($booking->client_name) && trim($booking->client_name) ? $booking->client_name : 'Client';
        $service_name = $service && isset($service->name) ? $service->name : 'Service';
        $client_email = isset($booking->client_email) && is_email($booking->client_email) ? $booking->client_email : '';
        if (!empty($client_email)) {
            $subject = 'Confirmation de réception de votre réservation';
            $template = get_option('ib_notify_client_thankyou', "Bonjour {client_name},<br><br>Nous avons bien reçu votre demande de réservation pour le service {service_name}.<br>Vous recevrez une confirmation définitive très prochainement de la part de {company}.<br><br>Cordialement,<br>L'équipe {company}");
            $vars = [
                'client_name' => $client_name,
                'service_name' => $service_name,
                'service' => $service_name,
                'company' => $company
            ];
            $message = self::replace_vars($template, $vars);
            $sent = self::send_email($client_email, $subject, $message);
            if (!$sent) {
                // Prévenir l'admin si l'envoi échoue
                $admin_email = get_option('admin_email');
                $admin_subject = '[IB Booking] Erreur envoi mail de remerciement';
                $admin_message = 'Le mail de remerciement n\'a pas pu être envoyé au client (ID réservation : ' . intval($booking_id) . ', email : ' . esc_html($client_email) . ').';
                self::send_email($admin_email, $admin_subject, $admin_message);
            }
        } else {
            // Email client absent, prévenir l'admin
            $admin_email = get_option('admin_email');
            $admin_subject = '[IB Booking] Erreur : pas d\'email client pour le remerciement';
            $admin_message = 'Impossible d\'envoyer le mail de remerciement au client (ID réservation : ' . intval($booking_id) . ').';
            self::send_email($admin_email, $admin_subject, $admin_message);
        }
    }
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

        // Email au client (si email présent)
        if (!empty($client->email) && is_email($client->email)) {
            $subject = sprintf(__('Rappel : Rendez-vous %s', 'institut-booking'), $service->name);
            $template = "Bonjour {client_name},<br><br>Ceci est un rappel pour votre rendez-vous :<br><br>Service : {service_name}<br>Date : {date}<br>Heure : {time}<br>Praticienne : {employee_name}<br><br>Cordialement,<br>{company}";
            $vars = [
                'client_name' => $client->name,
                'service_name' => $service->name,
                'date' => date_i18n(get_option('date_format'), strtotime($booking->start_time)),
                'time' => date_i18n(get_option('time_format'), strtotime($booking->start_time)),
                'employee_name' => $employee->name,
                'company' => get_bloginfo('name')
            ];
            $message = self::replace_vars($template, $vars);
            self::send_email($client->email, $subject, $message);
        } else {
            // Fallback : prévenir l'admin si pas d'email client
            $admin_email = get_option('admin_email');
            $subject = __('Erreur : Pas d\'email client pour le rappel', 'institut-booking');
            $message = 'Impossible d\'envoyer le rappel au client (ID réservation : ' . intval($booking_id) . ').';
            self::send_email($admin_email, $subject, $message);
        }

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

        // Try to get client from booking data first, then from clients table
        $client_email = isset($booking->client_email) && is_email($booking->client_email) ? $booking->client_email : '';
        $client_name = isset($booking->client_name) ? $booking->client_name : '';
        
        // If not found in booking, try clients table
        if (empty($client_email) || empty($client_name)) {
            $client = IB_Clients::get_by_id($booking->client_id);
            if ($client) {
                $client_email = $client_email ?: $client->email;
                $client_name = $client_name ?: $client->name;
            }
        }
        
        $service = IB_Services::get_by_id($booking->service_id);
        $employee = IB_Employees::get_by_id($booking->employee_id);

        // Email au client (si email présent)
        if (!empty($client_email) && is_email($client_email)) {
            $subject = sprintf(__('Confirmation : Rendez-vous %s', 'institut-booking'), $service ? $service->name : 'Service');
            
            // Use custom template if available
            $template = get_option('ib_notify_client_confirm', "Bonjour {client_name},<br><br>Nous avons le plaisir de vous confirmer votre réservation pour le service {service_name} le {date} à {time} au sein de {company}.<br><br>N'hésitez pas à nous contacter si vous avez des questions ou des demandes particulières.<br><br>Cordialement,<br>{company}");
            
            $vars = [
                'client_name' => $client_name ?: 'Client',
                'service_name' => $service ? $service->name : 'Service',
                'service' => $service ? $service->name : 'Service', // Support both formats
                'date' => date_i18n(get_option('date_format'), strtotime($booking->start_time)),
                'time' => date_i18n(get_option('time_format'), strtotime($booking->start_time)),
                'company' => get_bloginfo('name')
            ];
            $message = self::replace_vars($template, $vars);
            self::send_email($client_email, $subject, $message);
        } else {
            // Fallback : prévenir l'admin si pas d'email client
            $admin_email = get_option('admin_email');
            $subject = __('Erreur : Pas d\'email client pour la confirmation', 'institut-booking');
            $message = 'Impossible d\'envoyer la confirmation au client (ID réservation : ' . intval($booking_id) . ').';
            self::send_email($admin_email, $subject, $message);
        }

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

        // Email au client (si email présent)
        if (!empty($client->email) && is_email($client->email)) {
            $subject = sprintf(__('Annulation : Rendez-vous %s', 'institut-booking'), $service->name);
            $template = "Bonjour {client_name},<br><br>Votre rendez-vous pour le service {service_name} le {date} à {time} a été annulé.<br><br>Cordialement,<br>L'équipe de {company}";
            $vars = [
                'client_name' => $client->name,
                'service_name' => $service->name,
                'date' => date_i18n(get_option('date_format'), strtotime($booking->start_time)),
                'time' => date_i18n(get_option('time_format'), strtotime($booking->start_time)),
                'company' => get_bloginfo('name')
            ];
            $message = self::replace_vars($template, $vars);
            self::send_email($client->email, $subject, $message);
        } else {
            // Fallback : prévenir l'admin si pas d'email client
            $admin_email = get_option('admin_email');
            $subject = __('Erreur : Pas d\'email client pour l\'annulation', 'institut-booking');
            $message = 'Impossible d\'envoyer l\'annulation au client (ID réservation : ' . intval($booking_id) . ').';
            self::send_email($admin_email, $subject, $message);
        }

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

    // Ajouter une notification
    public static function add($type, $message, $target = 'admin', $link = null) {
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'ib_notifications', [
            'type' => sanitize_text_field($type),
            'message' => sanitize_textarea_field($message),
            'target' => sanitize_text_field($target),
            'status' => 'unread',
            'link' => $link ? esc_url_raw($link) : null,
            'created_at' => current_time('mysql'),
        ]);
    }

    // Récupérer les notifications non lues (pour la cloche)
    public static function get_unread($target = 'admin', $limit = 10) {
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ib_notifications WHERE target = %s AND status = 'unread' ORDER BY created_at DESC LIMIT %d",
            $target, $limit
        ));
    }

    // Récupérer les notifications récentes (lues + non lues)
    public static function get_recent($target = 'admin', $limit = 15, $search = '') {
        global $wpdb;
        $sql = "SELECT * FROM {$wpdb->prefix}ib_notifications WHERE target = %s";
        $params = [$target];
        if (!empty($search)) {
            $sql .= " AND (type LIKE %s OR message LIKE %s OR status LIKE %s OR created_at LIKE %s)";
            $like = '%' . $wpdb->esc_like($search) . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }
        $sql .= " ORDER BY created_at DESC LIMIT %d";
        $params[] = $limit;
        return $wpdb->get_results($wpdb->prepare($sql, ...$params));
    }

    // Marquer une notification comme lue
    public static function mark_as_read($id) {
        global $wpdb;
        $wpdb->update($wpdb->prefix . 'ib_notifications', ['status' => 'read'], ['id' => intval($id)]);
    }

    // Marquer toutes les notifications comme lues pour un utilisateur
    public static function mark_all_as_read($target = 'admin') {
        global $wpdb;
        $wpdb->update($wpdb->prefix . 'ib_notifications', ['status' => 'read'], ['target' => $target, 'status' => 'unread']);
    }
} 