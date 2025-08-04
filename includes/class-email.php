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
        
        // Client - Template moderne Planity
        if (!empty($context['client_email'])) {
            if (!empty($templates['client_' . $type])) {
                $body_client = strtr($templates['client_' . $type], $placeholders);
            } else {
                // Template par défaut moderne style Planity
                $body_client = self::get_modern_template($type, $placeholders);
            }
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

    /**
     * Template d'email moderne style Planity
     */
    public static function get_modern_template($type, $placeholders) {
        $company = $placeholders['{company}'];
        $client = $placeholders['{client}'];
        $service = $placeholders['{service}'];
        $date = $placeholders['{date}'];
        $time = $placeholders['{time}'];
        $employee = $placeholders['{employee}'];

        if ($type === 'confirm') {
            return "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Confirmation de réservation</title>
</head>
<body style='margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; background-color: #f8f9fa;'>
    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);'>

        <!-- Header -->
        <div style='background: linear-gradient(135deg, #111827 0%, #374151 100%); padding: 2rem; text-align: center;'>
            <div style='background: #ffffff; width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;'>
                <svg width='32' height='32' fill='none' stroke='#111827' stroke-width='2' viewBox='0 0 24 24'>
                    <path d='M20 6L9 17l-5-5'/>
                </svg>
            </div>
            <h1 style='color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;'>Réservation confirmée</h1>
            <p style='color: #e5e7eb; margin: 0.5rem 0 0; font-size: 16px;'>Merci pour votre confiance !</p>
        </div>

        <!-- Content -->
        <div style='padding: 2rem;'>
            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 1.5rem;'>
                Bonjour <strong>{$client}</strong>,
            </p>

            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 2rem;'>
                Nous avons le plaisir de vous confirmer votre réservation. Voici les détails :
            </p>

            <!-- Booking Details Card -->
            <div style='background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem; margin: 1.5rem 0;'>
                <div style='display: flex; align-items: center; margin-bottom: 1rem;'>
                    <div style='background: #1f2937; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;'>
                        <svg width='20' height='20' fill='none' stroke='#ffffff' stroke-width='2' viewBox='0 0 24 24'>
                            <path d='M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'/>
                        </svg>
                    </div>
                    <div>
                        <h3 style='color: #1f2937; margin: 0; font-size: 18px; font-weight: 600;'>{$service}</h3>
                        <p style='color: #6b7280; margin: 0; font-size: 14px;'>avec {$employee}</p>
                    </div>
                </div>

                <div style='display: flex; align-items: center; margin-bottom: 0.5rem;'>
                    <svg width='16' height='16' fill='none' stroke='#6b7280' stroke-width='2' viewBox='0 0 24 24' style='margin-right: 0.5rem;'>
                        <rect x='3' y='4' width='18' height='18' rx='2' ry='2'/>
                        <line x1='16' y1='2' x2='16' y2='6'/>
                        <line x1='8' y1='2' x2='8' y2='6'/>
                        <line x1='3' y1='10' x2='21' y2='10'/>
                    </svg>
                    <span style='color: #374151; font-size: 14px; font-weight: 500;'>{$date}</span>
                </div>

                <div style='display: flex; align-items: center;'>
                    <svg width='16' height='16' fill='none' stroke='#6b7280' stroke-width='2' viewBox='0 0 24 24' style='margin-right: 0.5rem;'>
                        <circle cx='12' cy='12' r='10'/>
                        <polyline points='12,6 12,12 16,14'/>
                    </svg>
                    <span style='color: #374151; font-size: 14px; font-weight: 500;'>{$time}</span>
                </div>
            </div>

            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 2rem 0 1rem;'>
                N'hésitez pas à nous contacter si vous avez des questions ou des demandes particulières.
            </p>

            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 0;'>
                À très bientôt,<br>
                <strong>{$company}</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style='background: #f9fafb; padding: 1.5rem; text-align: center; border-top: 1px solid #e5e7eb;'>
            <p style='color: #6b7280; font-size: 14px; margin: 0;'>
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.
            </p>
        </div>
    </div>
</body>
</html>";
        } else {
            // Template d'annulation
            return "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Annulation de réservation</title>
</head>
<body style='margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; background-color: #f8f9fa;'>
    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);'>

        <!-- Header -->
        <div style='background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); padding: 2rem; text-align: center;'>
            <div style='background: #ffffff; width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;'>
                <svg width='32' height='32' fill='none' stroke='#dc2626' stroke-width='2' viewBox='0 0 24 24'>
                    <circle cx='12' cy='12' r='10'/>
                    <line x1='15' y1='9' x2='9' y2='15'/>
                    <line x1='9' y1='9' x2='15' y2='15'/>
                </svg>
            </div>
            <h1 style='color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;'>Réservation annulée</h1>
        </div>

        <!-- Content -->
        <div style='padding: 2rem;'>
            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 1.5rem;'>
                Bonjour <strong>{$client}</strong>,
            </p>

            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 2rem;'>
                Votre réservation pour <strong>{$service}</strong> le <strong>{$date}</strong> à <strong>{$time}</strong> a été annulée.
            </p>

            <p style='color: #374151; font-size: 16px; line-height: 1.6; margin: 0;'>
                Cordialement,<br>
                <strong>{$company}</strong>
            </p>
        </div>
    </div>
</body>
</html>";
        }
    }
}
