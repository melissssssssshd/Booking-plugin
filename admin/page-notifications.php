<?php
if (!defined('ABSPATH')) exit;
// Notifications stockées dans les options
$notify_client_confirm = get_option('ib_notify_client_confirm', '');
$notify_client_cancel = get_option('ib_notify_client_cancel', '');
$notify_admin_confirm = get_option('ib_notify_admin_confirm', '');
$notify_admin_cancel = get_option('ib_notify_admin_cancel', '');
$notify_recept_confirm = get_option('ib_notify_recept_confirm', '');
$notify_recept_cancel = get_option('ib_notify_recept_cancel', '');
$notify_reminder = get_option('ib_notify_reminder', '');
$test_feedback = '';
$test_email = ''; // Initialisation de la variable

// Feedback de sauvegarde
if (isset($_GET['saved']) && $_GET['saved'] == '1') {
    $test_feedback = '<div class="ib-toast success ib-fade-in" style="margin-bottom:2em;"><span class="dashicons dashicons-yes"></span> Notifications enregistrées !</div>';
}

// Envoi de test
if (isset($_POST['send_test'])) {
    $test_email = sanitize_email($_POST['test_email']);
    $type = sanitize_text_field($_POST['test_type']);
    $subject = 'Test notification ' . ucfirst($type);
    $vars = [
        '{client_name}' => 'Jean Dupont',
        '{service}' => 'Massage Relaxant',
        '{date}' => '2024-07-01',
        '{time}' => '14:00',
        '{company}' => 'Institut Booking',
        '{recept_name}' => 'Sophie',
        '{admin_name}' => 'Admin',
    ];
    $body = '';
    if ($type === 'client_confirm') $body = strtr($notify_client_confirm, $vars);
    if ($type === 'client_cancel') $body = strtr($notify_client_cancel, $vars);
    if ($type === 'admin_confirm') $body = strtr($notify_admin_confirm, $vars);
    if ($type === 'admin_cancel') $body = strtr($notify_admin_cancel, $vars);
    if ($type === 'recept_confirm') $body = strtr($notify_recept_confirm, $vars);
    if ($type === 'recept_cancel') $body = strtr($notify_recept_cancel, $vars);
    if ($type === 'reminder') $body = strtr($notify_reminder, $vars);
    if ($body && is_email($test_email)) {
        $sent = wp_mail($test_email, $subject, $body);
        if ($sent) {
            $test_feedback = '<div class="ib-toast success ib-fade-in" style="margin-bottom:2em;"><span class="dashicons dashicons-yes"></span> Email de test envoyé à '.esc_html($test_email).' !</div>';
        } else {
            $test_feedback = '<div class="ib-toast error ib-fade-in" style="margin-bottom:2em;"><span class="dashicons dashicons-warning"></span> Erreur lors de l\'envoi du mail.</div>';
        }
    } else {
        $test_feedback = '<div class="ib-toast error ib-fade-in" style="margin-bottom:2em;"><span class="dashicons dashicons-warning"></span> Adresse email invalide ou contenu vide.</div>';
    }
}
?>
<style>
body, .wrap, .ib-admin-content {
  background: #fbeff3 !important;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.ib-tabs {
  background: none !important;
  box-shadow: none !important;
  padding: 0.2em 0;
  margin-bottom: 2.5em;
  gap: 0.8em;
}
.ib-tab {
  border: 1.5px solid #e9aebc;
  background: #fff;
  color: #e9aebc;
  border-radius: 22px;
  font-size: 1.04em;
  font-weight: 500;
  padding: 0.6em 1.5em;
  margin-right: 0.1em;
  transition: all 0.18s;
  box-shadow: 0 2px 12px #e9aebc22;
  letter-spacing: 0.01em;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
  position: relative;
  z-index: 1;
}
.ib-tab.active {
  border: 2px solid #e9aebc;
  color: #e9aebc;
  background: #fff;
  box-shadow: 0 6px 24px #e9aebc33;
  font-weight: 600;
  z-index: 2;
}
.ib-tab:not(.active):hover {
  background: #fbeff3;
  color: #e9aebc;
  box-shadow: 0 2px 12px #e9aebc22;
}
.ib-notif-section {
  background: rgba(255,255,255,0.85);
  border-radius: 24px;
  box-shadow: 0 8px 32px #e9aebc33, 0 1.5px 6px #bfa2c733;
  border: none;
  padding: 2.5em 2.5em 2em 2.5em;
  margin-bottom: 2.5em;
  backdrop-filter: blur(8px);
  position: relative;
}
.ib-notif-title {
  font-size: 1.13em;
  font-weight: 600;
  color: #e9aebc;
  display: flex;
  align-items: center;
  gap: 0.5em;
  margin-bottom: 1.3em;
  padding-bottom: 0.7em;
  border-bottom: 1px solid #fbeff3;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.ib-notif-title .dashicons {
  font-size: 1.1em;
  opacity: 0.7;
}
.ib-badge {
  background: #fbeff3;
  color: #e9aebc;
  border-radius: 16px;
  padding: 0.25em 1.2em;
  font-size: 0.97em;
  font-weight: 500;
  margin-left: auto;
  box-shadow: none;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.ib-test-row {
  display: flex;
  align-items: center;
  gap: 1em;
  margin: 0 0 2em 0;
}
.ib-test-email {
  border-radius: 16px;
  border: 1.5px solid #e9aebc;
  background: rgba(255,255,255,0.85);
  padding: 1em 1.3em;
  font-size: 1.04em;
  color: #22223b;
  font-weight: 400;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
  box-shadow: 0 2px 8px #e9aebc11;
  transition: all 0.2s;
  height: 48px;
  min-width: 260px;
}
.ib-test-email:focus {
  border-color: #e9aebc;
  box-shadow: 0 0 0 3px #fbeff3;
}
.ib-test-email::placeholder {
  color: #bfa2c7;
  opacity: 1;
  font-style: italic;
}
.ib-btn-test {
  display: flex;
  align-items: center;
  gap: 0.5em;
  background: #e9aebc;
  color: #fff;
  border: none;
  border-radius: 16px;
  padding: 0.9em 2em;
  font-size: 1.04em;
  font-weight: 600;
  box-shadow: 0 4px 16px #e9aebc22;
  cursor: pointer;
  transition: background 0.18s, box-shadow 0.18s, transform 0.12s;
  height: 48px;
}
.ib-btn-test:hover {
  background: #e38ca6;
  box-shadow: 0 8px 24px #e9aebc33;
  transform: translateY(-2px) scale(1.03);
}
.ib-btn-test .dashicons {
  font-size: 1.1em;
  margin-right: 0.2em;
}
.ib-test-help {
  color: #bfa2c7;
  font-size: 0.95em;
  margin-left: 1em;
}
.ib-input, .ib-notif-section textarea {
  border: 2px solid #e9aebc;
  border-radius: 16px;
  padding: 1em 1.2em;
  font-size: 1.04em;
  background: rgba(255,255,255,0.85);
  color: #22223b;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
  font-weight: 400;
  box-shadow: 0 2px 8px #e9aebc11;
  transition: all 0.2s;
}
.ib-input:focus, .ib-notif-section textarea:focus {
  border-color: #e9aebc;
  outline: none;
  box-shadow: 0 0 0 3px #fbeff3;
}
.ib-input::placeholder, .ib-notif-section textarea::placeholder {
  color: #bfa2c7;
  opacity: 1;
  font-style: italic;
}
.ib-btn-save {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.7em;
  background: #e9aebc;
  color: #fff;
  border: none;
  border-radius: 22px;
  padding: 1.1em 2.8em;
  font-size: 1.18em;
  font-weight: 700;
  box-shadow: 0 6px 24px #e9aebc33;
  cursor: pointer;
  transition: background 0.18s, box-shadow 0.18s, transform 0.12s;
  position: absolute;
  right: 2.5em;
  bottom: 2em;
  z-index: 10;
}
.ib-btn-save:hover {
  background: #e38ca6;
  box-shadow: 0 10px 32px #e9aebc44;
  transform: translateY(-2px) scale(1.03);
}
.ib-btn-save .dashicons {
  font-size: 1.2em;
  margin-right: 0.2em;
}
@media (max-width: 900px) {
  .ib-notif-section {
    padding: 1.1em 0.5em 4.5em 0.5em;
    border-radius: 16px;
  }
  .ib-btn-save {
    position: static;
    width: 100%;
    margin: 2em 0 0 0;
    right: auto;
    bottom: auto;
    border-radius: 18px;
    font-size: 1.08em;
    padding: 1em 0;
    justify-content: center;
  }
}
@media (max-width: 700px) {
  .ib-test-row {
    flex-direction: column;
    align-items: stretch;
    gap: 0.7em;
  }
  .ib-test-email, .ib-btn-test {
    width: 100%;
    min-width: 0;
    height: 44px;
  }
}
</style>

<div class="ib-admin-main">
    <div class="ib-admin-header">
        <h1><span class="dashicons dashicons-email"></span> Notifications Email</h1>
        <p style="color: #64748b; margin-top: 0.5em;">Configurez vos modèles d'emails automatiques</p>
    </div>
    <div class="ib-admin-content ib-notif-centered">
        <?php if (!empty($test_feedback)) echo $test_feedback; ?>
        <div class="ib-tabs">
            <button type="button" class="ib-tab" data-tab="client">Client</button>
            <button type="button" class="ib-tab" data-tab="recept">Réceptionniste</button>
            <button type="button" class="ib-tab" data-tab="admin">Admin</button>
            <button type="button" class="ib-tab" data-tab="reminder">Rappel</button>
        </div>
        <form method="post" class="ib-form ib-notif-form" style="max-width:700px;margin:auto;">
            <div class="ib-test-row">
                <input type="email" class="ib-test-email" name="test_email" placeholder="Saisissez l'adresse pour recevoir un test" value="<?php echo esc_attr($test_email); ?>" />
                <button type="submit" name="send_test" class="ib-btn-test"><span class="dashicons dashicons-email"></span> Envoyer un test</button>
            </div>
            <!-- Onglet Client -->
            <div class="ib-notif-section ib-tab-content" data-tab-content="client">
                <div class="ib-notif-title">
                    <span class="dashicons dashicons-admin-users"></span> 
                    Client 
                    <span class="ib-badge">Destinataire</span>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin-bottom:0.5em;"><b>Confirmation</b></label>
                <textarea name="notify_client_confirm" rows="4" class="ib-input" placeholder="Bonjour {client_name}, votre réservation pour {service} le {date} à {time} est confirmée..."><?php echo esc_textarea($notify_client_confirm); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {client_name}, {service}, {date}, {time}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='client_confirm'">Envoyer un test</button>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin:1.5em 0 0.5em 0;"><b>Annulation</b></label>
                <textarea name="notify_client_cancel" rows="4" class="ib-input" placeholder="Bonjour {client_name}, votre réservation pour {service} le {date} à {time} a été annulée..."><?php echo esc_textarea($notify_client_cancel); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {client_name}, {service}, {date}, {time}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='client_cancel'">Envoyer un test</button>
                </div>
            </div>
            <!-- Onglet Réceptionniste -->
            <div class="ib-notif-section ib-tab-content" data-tab-content="recept" style="display:none;">
                <div class="ib-notif-title">
                    <span class="dashicons dashicons-businesswoman"></span> 
                    Réceptionniste 
                    <span class="ib-badge">Destinataire</span>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin-bottom:0.5em;"><b>Confirmation</b></label>
                <textarea name="notify_recept_confirm" rows="4" class="ib-input" placeholder="Bonjour {recept_name}, nouvelle réservation confirmée pour {service} le {date} à {time}..."><?php echo esc_textarea($notify_recept_confirm); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {recept_name}, {service}, {date}, {time}, {client_name}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='recept_confirm'">Envoyer un test</button>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin:1.5em 0 0.5em 0;"><b>Annulation</b></label>
                <textarea name="notify_recept_cancel" rows="4" class="ib-input" placeholder="Bonjour {recept_name}, réservation annulée pour {service} le {date} à {time}..."><?php echo esc_textarea($notify_recept_cancel); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {recept_name}, {service}, {date}, {time}, {client_name}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='recept_cancel'">Envoyer un test</button>
                </div>
            </div>
            <!-- Onglet Admin -->
            <div class="ib-notif-section ib-tab-content" data-tab-content="admin" style="display:none;">
                <div class="ib-notif-title">
                    <span class="dashicons dashicons-shield"></span> 
                    Administrateur 
                    <span class="ib-badge">Destinataire</span>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin-bottom:0.5em;"><b>Confirmation</b></label>
                <textarea name="notify_admin_confirm" rows="4" class="ib-input" placeholder="Bonjour {admin_name}, nouvelle réservation confirmée pour {service} le {date} à {time}..."><?php echo esc_textarea($notify_admin_confirm); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {admin_name}, {service}, {date}, {time}, {client_name}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='admin_confirm'">Envoyer un test</button>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin:1.5em 0 0.5em 0;"><b>Annulation</b></label>
                <textarea name="notify_admin_cancel" rows="4" class="ib-input" placeholder="Bonjour {admin_name}, réservation annulée pour {service} le {date} à {time}..."><?php echo esc_textarea($notify_admin_cancel); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {admin_name}, {service}, {date}, {time}, {client_name}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='admin_cancel'">Envoyer un test</button>
                </div>
            </div>
            <!-- Onglet Rappel -->
            <div class="ib-notif-section ib-tab-content" data-tab-content="reminder" style="display:none;">
                <div class="ib-notif-title">
                    <span class="dashicons dashicons-clock"></span> 
                    Rappel de rendez-vous 
                    <span class="ib-badge">Client</span>
                </div>
                <label style="display:block;font-weight:600;color:#1e293b;margin-bottom:0.5em;"><b>Contenu du mail de rappel</b></label>
                <textarea name="notify_reminder" rows="4" class="ib-input" placeholder="Bonjour {client_name}, rappel pour votre rendez-vous {service} le {date} à {time}..."><?php echo esc_textarea($notify_reminder); ?></textarea>
                <div class="ib-notif-vars">Variables disponibles : {client_name}, {service}, {date}, {time}, {company}</div>
                <div class="ib-notif-actions">
                    <button type="submit" name="send_test" value="1" class="ib-btn-test" onclick="this.form.test_type.value='reminder'">Envoyer un test</button>
                </div>
            </div>
            <input type="hidden" name="test_type" value="">
            <div style="text-align:center;margin-top:2em;">
                <button type="submit" class="ib-btn-save">
                    <span class="dashicons dashicons-yes"></span> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.ib-tab');
    const contents = document.querySelectorAll('.ib-tab-content');
    function activateTab(tabName) {
        tabs.forEach(tab => {
            if(tab.dataset.tab === tabName) tab.classList.add('active');
            else tab.classList.remove('active');
        });
        contents.forEach(content => {
            if(content.dataset.tabContent === tabName) content.style.display = '';
            else content.style.display = 'none';
        });
    }
    // Par défaut, onglet client
    activateTab('client');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            activateTab(this.dataset.tab);
        });
    });
});
</script>
