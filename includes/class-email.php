<?php
// Gestion des emails de notification
if (!defined('ABSPATH')) exit;

class IB_Email {
    public static function send_confirmation($to, $subject, $message) {
        wp_mail($to, $subject, $message);
    }

    public static function send_update($to, $subject, $message) {
        wp_mail($to, $subject, $message);
    }

    public static function send_auto($type, $context) {
        $company = get_bloginfo('name');
        $placeholders = [
            '{service}' => $context['service'],
            '{service_name}' => $context['service'], // Support both formats
            '{date}' => $context['date'],
            '{time}' => $context['time'],
            '{client}' => $context['client'],
            '{client_name}' => $context['client'], // Support both formats
            '{employee}' => $context['employee'],
            '{employee_name}' => $context['employee'], // Support both formats
            '{company}' => $company,
            '{extras}' => isset($context['extras']) ? $context['extras'] : '',
            '{recept_name}' => 'Réceptionniste',
            '{admin_name}' => 'Admin',
        ];
        $templates = [
            'client_confirm' => get_option('ib_notify_client_confirm'),
            'client_cancel' => get_option('ib_notify_client_cancel'),
            'admin_confirm' => get_option('ib_notify_admin_confirm'),
            'admin_cancel' => get_option('ib_notify_admin_cancel'),
            'recept_confirm' => get_option('ib_notify_recept_confirm'),
            'recept_cancel' => get_option('ib_notify_recept_cancel'),
        ];
        $subject = ($type === 'confirm') ? 'Confirmation de réservation' : 'Annulation de réservation';
        
        // Add HTML headers
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Client
        if (!empty($context['client_email']) && !empty($templates['client_' . $type])) {
            $body_client = strtr($templates['client_' . $type], $placeholders);
            wp_mail($context['client_email'], $subject, $body_client, $headers);
        }
        
        // Admin
        $admin_email = get_option('admin_email');
        if ($admin_email && !empty($templates['admin_' . $type])) {
            $body_admin = strtr($templates['admin_' . $type], $placeholders);
            wp_mail($admin_email, $subject, $body_admin, $headers);
        }
        
        // Réceptionniste (tous les users avec le rôle)
        if (!empty($templates['recept_' . $type])) {
            $body_reception = strtr($templates['recept_' . $type], $placeholders);
            $users = get_users(['role' => 'receptionist']);
            foreach ($users as $user) {
                wp_mail($user->user_email, $subject, $body_reception, $headers);
            }
        }
    }
}
