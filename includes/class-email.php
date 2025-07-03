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
        $placeholders = [
            '{service}' => $context['service'],
            '{date}' => $context['date'],
            '{time}' => $context['time'],
            '{client}' => $context['client'],
            '{employee}' => $context['employee'],
            '{extras}' => isset($context['extras']) ? $context['extras'] : '',
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
        $body_client = strtr($templates['client_' . $type], $placeholders);
        $body_admin = strtr($templates['admin_' . $type], $placeholders);
        $body_reception = strtr($templates['recept_' . $type], $placeholders);
        // Client
        if (!empty($context['client_email'])) wp_mail($context['client_email'], $subject, $body_client);
        // Admin
        $admin_email = get_option('admin_email');
        if ($admin_email) wp_mail($admin_email, $subject, $body_admin);
        // Réceptionniste (tous les users avec le rôle)
        $users = get_users(['role' => 'receptionist']);
        foreach ($users as $user) {
            wp_mail($user->user_email, $subject, $body_reception);
        }
    }
}
