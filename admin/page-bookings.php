<?php
// Forcer le chargement du CSS intl-tel-input depuis le CDN officiel dans l'admin
add_action('admin_head', function() {
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/css/intlTelInput.min.css" />';
}, 1);
?>
<?php include_once plugin_dir_path(__FILE__) . '/layout.php'; ?>
<?php
if (!defined('ABSPATH')) exit;
require_once plugin_dir_path(__FILE__) . '../includes/class-services.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-employees.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-extras.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-bookings.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-service-employees.php';
// Traitement ajout réservation
if (isset($_POST['add_booking'])) {
    $client_name = sanitize_text_field($_POST['client_name'] ?? '');
    $client_email = sanitize_email($_POST['client_email'] ?? '');
    $client_phone = sanitize_text_field($_POST['client_phone'] ?? '');
    $service_id = intval($_POST['service_id'] ?? 0);
    $employee_id = intval($_POST['employee_id'] ?? 0);
    $date = sanitize_text_field($_POST['date'] ?? '');
    $time = sanitize_text_field($_POST['time'] ?? '');
    $start_time = $date && $time ? $date . ' ' . $time . ':00' : '';
    $status = sanitize_text_field($_POST['status'] ?? '');
    $extras = isset($_POST['extras']) ? maybe_serialize($_POST['extras']) : '';
    // Récupérer le prix du service
    $service = IB_Services::get_by_id($service_id);
    $service_price = $service ? $service->price : 0;
    if (!$client_name || !$client_email || !$service_id || !$employee_id || !$date || !$time || !$status) {
        echo '<div class="notice notice-error" style="margin-bottom:1.5em;"><p>Veuillez remplir tous les champs obligatoires.</p></div>';
    } else {
        $result = IB_Bookings::add([
            'client_name' => $client_name,
            'client_email' => $client_email,
            'client_phone' => $client_phone,
            'service_id' => $service_id,
            'employee_id' => $employee_id,
            'date' => $date,
            'start_time' => $start_time,
            'status' => $status,
            'extras' => $extras,
            'price' => $service_price
        ]);
        if ($result) {
            echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Réservation ajoutée avec succès.</p></div>';
        } else {
            echo '<div class="notice notice-error" style="margin-bottom:1.5em;"><p>Erreur lors de l\'ajout de la réservation.</p></div>';
        }
    }
}
// Traitement édition réservation
if (isset($_POST['update_booking'])) {
    $id = intval($_POST['booking_id']);
    $date = sanitize_text_field($_POST['date']);
    $time = sanitize_text_field($_POST['time']);
    $start_time = $date && $time ? $date . ' ' . $time . ':00' : '';
    $data = [
        'client_name' => sanitize_text_field($_POST['client_name']),
        'client_email' => sanitize_email($_POST['client_email']),
        'client_phone' => sanitize_text_field($_POST['client_phone']),
        'service_id' => intval($_POST['service_id']),
        'employee_id' => intval($_POST['employee_id']),
        'date' => $date,
        'start_time' => $start_time,
        'status' => sanitize_text_field($_POST['status']),
        'extras' => isset($_POST['extras']) ? array_map('intval', $_POST['extras']) : [],
    ];
    // Si prix réel envoyé, on l'enregistre
    if (isset($_POST['price']) && $_POST['price'] !== '') {
        $data['price'] = floatval($_POST['price']);
    }
    IB_Bookings::update($id, $data);
    echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Réservation modifiée avec succès.</p></div>';
}
// Traitement suppression réservation
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    IB_Bookings::delete((int)$_GET['id']);
    echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Réservation supprimée avec succès.</p></div>';
}
// Traitement validation réservation
if (isset($_POST['validate_booking_id'])) {
    $id = intval($_POST['validate_booking_id']);
    IB_Bookings::update($id, ['status' => 'confirmee']);
    echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Réservation confirmée avec succès.</p></div>';
}
// Traitement annulation réservation
if (isset($_POST['cancel_booking_id'])) {
    $id = intval($_POST['cancel_booking_id']);
    IB_Bookings::update($id, ['status' => 'annulee']);
    echo '<div class="notice notice-error" style="margin-bottom:1.5em;"><p>Réservation annulée.</p></div>';
}
// Traitement retour en attente réservation
if (isset($_POST['notconfirm_booking_id'])) {
    $id = intval($_POST['notconfirm_booking_id']);
    IB_Bookings::update($id, ['status' => 'en_attente']);
    echo '<div class="notice notice-warning" style="margin-bottom:1.5em;"><p>Réservation remise en attente.</p></div>';
}
// Traitement changement de statut
if (isset($_POST['change_status_booking_id']) && isset($_POST['new_status'])) {
    $id = intval($_POST['change_status_booking_id']);
    $new_status = sanitize_text_field($_POST['new_status']);
    if (in_array($new_status, ['en_attente','confirmee','annulee','complete','no_show'])) {
        IB_Bookings::update($id, ['status' => $new_status]);
        echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Statut de la réservation mis à jour.</p></div>';
    }
}
$bookings = IB_Bookings::get_all();
$services = IB_Services::get_all();
$employees = IB_Employees::get_all();
$extras = IB_Extras::get_all();
$services_by_id = [];
foreach ($services as $srv) {
    $services_by_id[$srv->id] = $srv;
}
$employees_by_id = [];
foreach ($employees as $emp) {
    $employees_by_id[$emp->id] = $emp;
}
$edit_booking = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_booking = IB_Bookings::get_by_id((int)$_GET['id']);
}
// Filtres de statut
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$employee_filter = isset($_GET['employee']) ? $_GET['employee'] : '';
$service_filter = isset($_GET['service']) ? $_GET['service'] : '';
if ($status_filter) {
    $bookings = array_filter($bookings, function($b) use ($status_filter) {
        // Normalisation pour éviter les bugs d'espaces/casse
        $status = strtolower(trim($b->status));
        $filter = strtolower(trim($status_filter));
        // Ajout des nouveaux statuts
        return $status === $filter;
    });
}
if ($employee_filter) {
    $bookings = array_filter($bookings, function($b) use ($employee_filter) {
        return $b->employee_id == $employee_filter;
    });
}
if ($service_filter) {
    $bookings = array_filter($bookings, function($b) use ($service_filter) {
        return $b->service_id == $service_filter;
    });
}
function normalize_role($role) {
    $role = strtolower($role);
    $role = str_replace(
        ['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ç'],
        ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'c'],
        $role
    );
    return $role;
}
// Injection employee_ids dans chaque service (comme côté client)
if (is_array($services)) {
    foreach ($services as &$service) {
        if (is_object($service) && isset($service->id)) {
            $service_id = (int)$service->id;
            $service->employee_ids = IB_Service_Employees::get_employees_for_service($service_id);
        } else {
            $service->employee_ids = [];
        }
    }
    unset($service);
}
// Forcer la structure objets pour JS admin (comme côté client)
$services = array_map(function($s) { return (object)$s; }, $services);
$employees = array_map(function($e) { return (object)$e; }, $employees);
?>
<div class="ib-bookings-page" style="background:#f6f7fa;min-height:100vh;padding:0;margin:0;">
  <div class="ib-bookings-content">
    <div class="ib-admin-header" style="display:flex;align-items:center;justify-content:space-between;">
      <h1 style="color:#e9aebc;font-size:2.2rem;font-weight:800;letter-spacing:-1px;">Réservations</h1>
      <button class="ib-btn accent" id="ib-open-add-booking-modal">+ Ajouter une réservation</button>
    </div>
    <div class="ib-admin-content">
      <!-- MODAL AJOUT RESERVATION -->
      <div id="ib-add-booking-modal-bg" class="ib-modal-bg" style="display:none;"></div>
      <div id="ib-add-booking-modal" class="ib-modal" style="display:none;max-width:600px;">
        <div class="ib-form-title" style="color:#e9aebc;"><i class="dashicons dashicons-calendar-alt"></i> <span>Ajouter une réservation</span></div>
        <form method="post" class="ib-booking-form-admin">
          <label for="add-booking-client-name">Client</label>
          <input id="add-booking-client-name" name="client_name" required>
          <label for="add-booking-client-email">Email</label>
          <input id="add-booking-client-email" name="client_email" type="email" required>
          <div style="width:260px;max-width:100%;margin-bottom:1.2em;">
            <label for="add-booking-client-phone">Téléphone</label>
            <input id="add-booking-client-phone" name="client_phone" type="tel" required placeholder="Téléphone">
          </div>
          <label for="add-booking-service">Service</label>
          <select id="add-booking-service" name="service_id" required>
            <option value="">Choisir</option>
            <?php foreach($services as $s): ?>
              <option value="<?php echo $s->id; ?>"><?php echo esc_html($s->name); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="add-booking-price">Prix (optionnel)</label>
          <input id="add-booking-price" name="price" type="number" min="0" step="0.01" placeholder="Prix (optionnel)">
          <label for="add-booking-employee">Employé</label>
          <select id="add-booking-employee" name="employee_id" required>
            <option value="">Choisir</option>
            <?php foreach($employees as $e):
              $service_ids = class_exists('IB_Service_Employees') ? IB_Service_Employees::get_services_for_employee($e->id) : [];
              $service_ids = array_filter(array_map('intval', $service_ids));
              $service_ids_str = $service_ids ? implode(',', $service_ids) : '';
            ?>
              <option value="<?php echo $e->id; ?>" data-services="<?php echo esc_attr($service_ids_str); ?>">
                <?php echo esc_html($e->name ?: 'Employé #' . $e->id); ?>
                <?php if (current_user_can('manage_options')) echo ' [services: ' . esc_html($service_ids_str) . ']'; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <label for="add-booking-date">Date</label>
          <input id="add-booking-date" name="date" type="date" required>
          <label for="add-booking-time">Heure</label>
          <input id="add-booking-time" name="time" type="time" required>
          <label for="add-booking-status">Statut</label>
          <select id="add-booking-status" name="status" required>
            <option value="en_attente">En attente</option>
            <option value="confirmee">Confirmée</option>
            <option value="annulee">Annulée</option>
            <option value="complete">Complété</option>
            <option value="no_show">No show</option>
          </select>
          <label>Extras</label>
          <?php foreach($extras as $ex): ?>
            <label style="margin-right:1em;"><input type="checkbox" name="extras[]" value="<?php echo $ex->id; ?>"> <?php echo esc_html($ex->name); ?></label>
          <?php endforeach; ?>
          <button class="ib-btn accent" type="submit" name="add_booking">Ajouter</button>
          <button type="button" class="ib-btn cancel" id="ib-close-add-booking-modal">Annuler</button>
        </form>
      </div>
      <!-- FIN MODAL -->
      <?php if ($edit_booking): ?>
        <!-- Modal édition réservation modernisée -->
        <div id="ib-modal-bg-booking" class="ib-modal-bg ib-invisible" style="display:block;"></div>
        <div id="ib-modal-edit-booking" class="ib-modal ib-invisible" style="display:block;">
          <div class="ib-form-title" style="color:#e9aebc;"><i class="dashicons dashicons-calendar-alt"></i> <span>Modifier la réservation</span></div>
          <form method="post" autocomplete="off">
            <input type="hidden" name="booking_id" value="<?php echo $edit_booking->id; ?>">
            <div class="ib-form-grid">
              <div class="ib-form-group">
                <input class="ib-input" id="edit-booking-client-name" name="client_name" value="<?php echo esc_attr($edit_booking->client_name); ?>" placeholder=" " required>
                <label class="ib-label" for="edit-booking-client-name">Client</label>
              </div>
              <div class="ib-form-group">
                <input class="ib-input" id="edit-booking-client-email" name="client_email" type="email" value="<?php echo esc_attr($edit_booking->client_email); ?>" placeholder=" " required>
                <label class="ib-label" for="edit-booking-client-email">Email</label>
              </div>
              <div style="width:260px;max-width:100%;margin-bottom:1.2em;">
                <input id="edit-booking-client-phone" name="client_phone" type="tel" value="<?php echo esc_attr($edit_booking->client_phone); ?>" required placeholder="Téléphone">
              </div>
              <div class="ib-form-group">
                <select class="ib-input" id="edit-booking-service" name="service_id" required>
                  <option value="">Choisir</option>
                  <?php foreach($services as $s): ?>
                    <option value="<?php echo $s->id; ?>" <?php if($edit_booking->service_id == $s->id) echo 'selected'; ?>><?php echo esc_html($s->name); ?></option>
                  <?php endforeach; ?>
                </select>
                <label class="ib-label" for="edit-booking-service">Service</label>
              </div>
              <?php
              // Afficher le champ prix réel pour tous les services (fixe ou variable)
              $val = isset($edit_booking->price) ? floatval($edit_booking->price) : '';
              echo '<div class="ib-form-group">';
              echo '<input class="ib-input" id="edit-booking-real-price" name="price" type="number" min="0" step="0.01" value="'.esc_attr($val).'" placeholder=" ">';
              echo '<label class="ib-label" for="edit-booking-real-price">Prix réel (modifiable)</label>';
              echo '</div>';
              ?>
              <div class="ib-form-group">
                <select class="ib-input" id="edit-booking-employee" name="employee_id" required>
                  <option value="">Choisir</option>
                  <?php foreach($employees as $e):
                    $service_ids = class_exists('IB_Service_Employees') ? IB_Service_Employees::get_services_for_employee($e->id) : [];
                    $service_ids = array_filter(array_map('intval', $service_ids));
                    $service_ids_str = $service_ids ? implode(',', $service_ids) : '';
                  ?>
                    <option value="<?php echo $e->id; ?>" data-services="<?php echo esc_attr($service_ids_str); ?>" <?php if($edit_booking->employee_id == $e->id) echo 'selected'; ?>><?php echo esc_html($e->name); ?></option>
                  <?php endforeach; ?>
                </select>
                <label class="ib-label" for="edit-booking-employee">Employé</label>
              </div>
              <div class="ib-form-group">
                <input class="ib-input" id="edit-booking-date" name="date" type="date" value="<?php echo esc_attr($edit_booking->date); ?>" placeholder=" " required>
                <label class="ib-label" for="edit-booking-date">Date</label>
              </div>
              <div class="ib-form-group">
                <input class="ib-input" id="edit-booking-time" name="time" type="time" value="<?php echo !empty($edit_booking->start_time) ? esc_attr(date('H:i', strtotime($edit_booking->start_time))) : ''; ?>" placeholder=" " required>
                <label class="ib-label" for="edit-booking-time">Heure</label>
              </div>
              <div class="ib-form-group">
                <select class="ib-input" id="edit-booking-status" name="status" required>
                  <option value="en_attente" <?php if($edit_booking->status=='en_attente') echo 'selected'; ?>>En attente</option>
                  <option value="confirmee" <?php if($edit_booking->status=='confirmee') echo 'selected'; ?>>Confirmée</option>
                  <option value="annulee" <?php if($edit_booking->status=='annulee') echo 'selected'; ?>>Annulée</option>
                  <option value="complete" <?php if($edit_booking->status=='complete') echo 'selected'; ?>>Complété</option>
                  <option value="no_show" <?php if($edit_booking->status=='no_show') echo 'selected'; ?>>No show</option>
                </select>
                <label class="ib-label" for="edit-booking-status">Statut</label>
              </div>
              <div class="ib-form-group">
                <label class="ib-label">Extras</label><br>
                <?php foreach($extras as $ex): ?>
                  <label style="margin-right:1em;"><input type="checkbox" name="extras[]" value="<?php echo $ex->id; ?>" <?php if(in_array($ex->id, (array)maybe_unserialize($edit_booking->extras))) echo 'checked'; ?>> <?php echo esc_html($ex->name); ?></label>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="ib-form-separator"></div>
            <div style="margin-top:1em;display:flex;gap:1.5em;justify-content:flex-end;">
              <button class="ib-btn accent" type="submit" name="update_booking">Enregistrer</button>
              <a href="admin.php?page=institut-booking-bookings" class="ib-btn cancel">Annuler</a>
            </div>
          </form>
        </div>
        <script>document.body.style.overflow = 'hidden';document.getElementById('ib-modal-bg-booking').onclick = function(){document.body.style.overflow = '';window.location.href='admin.php?page=institut-booking-bookings';};</script>
      <?php endif; ?>
      <?php if (empty($bookings)): ?>
        <div style="padding:2em;text-align:center;color:#888;">Aucune réservation trouvée.</div>
      <?php else: ?>
      <div style="display:flex;align-items:center;gap:1.2em;margin-bottom:1.2em;flex-wrap:wrap;">
        <input id="ib-booking-search" type="text" placeholder="🔍 Rechercher (nom ou téléphone)" style="border-radius:12px;border:1.5px solid #e9aebc;padding:0.6em 1.2em;font-size:1.07em;outline:none;box-shadow:0 2px 8px #e9aebc11;width:260px;max-width:100%;background:#fbeff3;color:#b95c8a;" />
        <input id="ib-booking-filter-date" type="date" style="border-radius:10px;border:1.5px solid #e9aebc;padding:0.5em 1em;font-size:1.07em;color:#b95c8a;background:#fbeff3;" />
        <button id="ib-booking-reset" type="button" style="background:#fbeff3;color:#b95c8a;border:none;border-radius:10px;padding:0.6em 1.2em;font-size:1.07em;box-shadow:0 2px 8px #e9aebc11;cursor:pointer;">Réinitialiser</button>
        <select id="ib-booking-filter-status" style="border-radius:10px;border:1.5px solid #e9aebc;padding:0.5em 1em;font-size:1.07em;color:#b95c8a;background:#fffbe6;">
          <option value="">Tous statuts</option>
          <option value="en_attente">En attente</option>
          <option value="confirmee">Confirmée</option>
          <option value="annulee">Annulée</option>
          <option value="complete">Complété</option>
          <option value="no_show">No show</option>
        </select>
        <select id="ib-booking-filter-employee" style="border-radius:10px;border:1.5px solid #e9aebc;padding:0.5em 1em;font-size:1.07em;color:#b95c8a;background:#fbeff3;">
          <option value="">Tous employés</option>
          <?php $has_employe = false; foreach($employees as $e): ?>
            <?php
              $role = isset($e->role) ? $e->role : '';
              $role_norm = normalize_role($role);
              if ($role_norm === 'employe' || $role === '' || $role === null) { $has_employe = true; ?>
                <option value="<?php echo $e->id; ?>"><?php echo esc_html($e->name); ?></option>
            <?php } ?>
          <?php endforeach; ?>
          <?php if(!$has_employe): ?><option disabled>Aucun employé disponible</option><?php endif; ?>
        </select>
        <select id="ib-booking-filter-service" style="border-radius:10px;border:1.5px solid #e9aebc;padding:0.5em 1em;font-size:1.07em;color:#b95c8a;background:#fbeff3;">
          <option value="">Tous services</option>
          <?php foreach($services as $s): ?>
            <option value="<?php echo $s->id; ?>"><?php echo esc_html($s->name); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div style="overflow-x:auto;">
        <table class="ib-table-bookings ib-invisible" style="width:100%;background:#fff;border-radius:14px;box-shadow:0 2px 16px #e9aebc22;margin-bottom:2em;">
          <thead style="background:#fbeff2;">
            <tr>
              <th style="color:#e9aebc;cursor:pointer;" data-sort="client">Client <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="email">Email <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="phone">Téléphone <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="service">Service <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="employee">Employé <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="date">Date <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="heure">Heure <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="statut">Statut <span class="sort-arrow"></span></th>
              <th style="cursor:pointer;" data-sort="price">Prix <span class="sort-arrow"></span></th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($bookings as $booking): ?>
            <tr>
              <td data-srv-id="<?php echo $booking->service_id; ?>"><?php echo esc_html($booking->client_name); ?></td>
              <td><?php echo esc_html($booking->client_email); ?></td>
              <td><?php echo esc_html($booking->client_phone); ?></td>
              <td data-srv-id="<?php echo $booking->service_id; ?>">
                <?php echo isset($services_by_id[$booking->service_id]) ? esc_html($services_by_id[$booking->service_id]->name) : '-'; ?>
              </td>
              <td data-emp-id="<?php echo $booking->employee_id; ?>">
                <?php echo isset($employees_by_id[$booking->employee_id]) ? esc_html($employees_by_id[$booking->employee_id]->name) : '-'; ?>
              </td>
              <td data-date="<?php echo esc_attr($booking->date); ?>"><?php echo esc_html($booking->date); ?></td>
              <td><?php 
                $heure = '';
                if (!empty($booking->start_time)) {
                  $heure = date('H:i', strtotime($booking->start_time));
                }
                echo esc_html($heure);
              ?></td>
              <td>
                <form method="post" style="display:inline;">
                  <input type="hidden" name="change_status_booking_id" value="<?php echo $booking->id; ?>">
                  <span class="ib-status-badge ib-status-<?php echo $booking->status; ?>" style="margin-right:0.5em;vertical-align:middle;display:inline-block;width:1.1em;height:1.1em;border-radius:50%;"></span>
                  <select name="new_status" class="ib-input ib-status-select ib-status-<?php echo $booking->status; ?>" style="min-width:110px; background:#fff; color:#b95c8a; font-weight:600; border-radius:10px; border:1.5px solid #e9aebc; box-shadow:0 2px 8px #e9aebc11; padding:0.3em 0.7em;" onchange="this.form.submit()">
                    <option value="en_attente" <?php if($booking->status==='en_attente') echo 'selected'; ?> style="background:#fffbe6;color:#bfa600;">En attente</option>
                    <option value="confirmee" <?php if($booking->status==='confirmee') echo 'selected'; ?> style="background:#e6ffed;color:#1ca97c;">Confirmée</option>
                    <option value="annulee" <?php if($booking->status==='annulee') echo 'selected'; ?> style="background:#ffeaea;color:#e05c5c;">Annulée</option>
                    <option value="complete" <?php if($booking->status==='complete') echo 'selected'; ?> style="background:#e0e7ff;color:#4f46e5;">Complété</option>
                    <option value="no_show" <?php if($booking->status==='no_show') echo 'selected'; ?> style="background:#fbeee6;color:#bfa600;">No show</option>
                  </select>
                </form>
              </td>
              <td style="font-weight:700;color:#7ec6b8;text-align:center;">
                <?php
                  $prix = isset($booking->price) ? $booking->price : 0;
                  echo rtrim(rtrim(number_format($prix, 2, ',', ' '), '0'), ',') . ' DA';
                ?>
              </td>
              <td class="ib-action-btns" style="white-space:nowrap;display:flex;gap:0.5em;align-items:center;">
                <a href="admin.php?page=institut-booking-bookings&action=edit&id=<?php echo $booking->id; ?>" class="ib-icon-btn edit" title="Éditer">
                  <svg width="20" height="20" fill="none" stroke="#e9aebc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>
                </a>
                <a href="admin.php?page=institut-booking-bookings&action=delete&id=<?php echo $booking->id; ?>" class="ib-icon-btn delete" title="Supprimer" onclick="return confirm('Supprimer cette réservation ?')">
                  <svg width="20" height="20" fill="none" stroke="#f8b4b4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<style>
body.ib-hide { display: none !important; opacity: 0; }
body { transition: opacity 0.3s; }
.ib-table-bookings { background: #fff; border-radius: 14px; box-shadow: 0 2px 16px #e9aebc22; color: #b95c8a; font-size: 1.07em; }
.ib-table-bookings th { background: #fbeff2; color: #e9aebc; font-weight: 700; }
.ib-table-bookings td { border-bottom: 1px solid #fbeff3; padding: 0.7em 1em; }
.ib-btn.accent { background: linear-gradient(90deg,#e9aebc 0%,#fbeff3 100%); color: #fff; border: none; border-radius: 16px; font-weight: 700; font-size: 1.13em; padding: 1em 0; box-shadow: 0 2px 12px #e9aebc22; transition: background 0.2s, box-shadow 0.2s; }
.ib-btn.accent:hover { background: linear-gradient(90deg,#fbeff3 0%,#e9aebc 100%); color: #b95c8a; box-shadow: 0 4px 24px #e9aebc33; }
.ib-status-badge { display: inline-block; border-radius: 12px; padding: 0.4em 1.2em; font-weight: 700; font-size: 1em; border: 1.5px solid #e9aebc; background: #fffbe6; color: #bfa600; }
.ib-status-badge.confirmed { background: #e6ffed; color: #1ca97c; border-color: #1ca97c; }
.ib-status-badge.cancelled { background: #ffeaea; color: #e05c5c; border-color: #e05c5c; }
.ib-status-badge.complete { background: #e0e7ff; color: #4f46e5; border-color: #4f46e5; }
.ib-status-badge.no_show { background: #fbeee6; color: #bfa600; border-color: #bfa600; }
.ib-modal { background: #fff; border-radius: 2em; box-shadow: 0 12px 48px #e9aebc44; padding: 2.5em 2em 2em 2em; max-width: 600px; margin: 2em auto; animation: ib-modal-fadein 0.7s cubic-bezier(.4,0,.2,1); }
@keyframes ib-modal-fadein { from { opacity: 0; transform: translateY(60px) scale(0.98); } to { opacity: 1; transform: none; } }
.ib-bookings-content {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 24px #e9aebc33;
  padding: 2.2rem 2.2rem 1.5rem 2.2rem;
  margin: 2.2rem auto 0 auto;
  max-width: 1100px;
}
.ib-bookings-content h1 {
  font-size: 2.2rem;
  font-weight: 800;
  margin-bottom: 1.5rem;
  color: #e9aebc;
  letter-spacing: -1px;
}
.ib-bookings-content .ib-btn.accent {
  background: #e9aebc;
  color: #fff;
  border: none;
  border-radius: 14px;
  padding: 0.7em 1.5em;
  font-size: 1.1em;
  font-weight: 700;
  margin-right: 0.5em;
  margin-bottom: 0.5em;
  box-shadow: 0 2px 8px #e9aebc33;
  transition: background 0.18s, color 0.18s, transform 0.12s;
}
.ib-bookings-content .ib-btn.accent:hover {
  background: #d48ca6;
  color: #fff;
  transform: translateY(-2px) scale(1.04);
}
.ib-bookings-content .ib-btn.cancel {
  background: #f1f5f9;
  color: #e9aebc;
  border: 1.5px solid #e9aebc;
  border-radius: 14px;
  padding: 0.7em 1.5em;
  font-size: 1.1em;
  font-weight: 700;
  transition: background 0.18s, color 0.18s, transform 0.12s;
}
.ib-bookings-content .ib-btn.cancel:hover {
  background: #e9aebc22;
  color: #e9aebc;
  transform: translateY(-2px) scale(1.04);
}
.ib-bookings-content .ib-icon-btn.edit svg {
  stroke: #e9aebc;
}
.ib-bookings-content .ib-icon-btn.delete svg {
  stroke: #f8b4b4;
}
.ib-bookings-content .ib-icon-btn.edit:hover {
  background: #fbeff2;
}
.ib-bookings-content .ib-icon-btn.delete:hover {
  background: #fbeaea;
}
.ib-bookings-content .ib-icon-btn:focus {
  outline: 2px solid #e9aebc;
}
.ib-bookings-content .ib-action-btns {
  display: flex;
  gap: 0.5em;
  align-items: center;
}
.ib-table-bookings th, .ib-table-bookings td {
  padding: 0.7em 0.5em;
  text-align: left;
}
.ib-table-bookings th {
  background: #fbeff2;
  font-weight: 700;
  color: #e9aebc;
  position: sticky;
  top: 0;
  z-index: 2;
}
.ib-table-bookings tr:hover {
  background: #fbeff2;
}
@media (max-width: 900px) {
  .ib-bookings-content {
    padding: 1.2rem 0.5rem;
    max-width: 98vw;
  }
  .ib-table-bookings th, .ib-table-bookings td {
    font-size: 0.98em;
    padding: 0.4em 0.3em;
  }
}
@media (max-width: 600px) {
  .ib-table-bookings, .ib-table-bookings thead, .ib-table-bookings tbody, .ib-table-bookings tr, .ib-table-bookings th, .ib-table-bookings td {
    display: block;
    width: 100%;
  }
  .ib-table-bookings tr {
    margin-bottom: 1.2em;
    border-radius: 10px;
    box-shadow: 0 2px 8px #e9aebc22;
    background: #fff;
  }
}
.ib-form-group {
  position: relative;
  margin-bottom: 1.5em;
}
.ib-label {
  position: absolute;
  left: 1.1em;
  top: 1.1em;
  color: #bfa2c7;
  font-size: 1em;
  pointer-events: none;
  background: transparent;
  transition: 0.18s;
  padding: 0 0.2em;
  z-index: 2;
}
.ib-input:focus + .ib-label,
.ib-input:not(:placeholder-shown) + .ib-label,
select:focus + .ib-label,
select:not([value=""]) + .ib-label {
  top: -0.7em;
  left: 0.9em;
  font-size: 0.92em;
  color: #e9aebc;
  background: #fff;
  padding: 0 0.3em;
}
.ib-input:focus, select:focus {
  border: 2px solid #e9aebc;
  box-shadow: 0 0 0 3px #e9aebc33;
  background: #fff;
}
.ib-status-select {
  border-radius: 10px;
  border: 1.5px solid #e9aebc;
  background: #fff;
  color: #e9aebc;
  font-weight: 600;
  font-size: 1em;
  padding: 0.4em 1em;
  transition: border 0.18s, box-shadow 0.18s;
}
.ib-status-select:focus {
  border: 2px solid #e9aebc;
  box-shadow: 0 0 0 3px #e9aebc33;
  outline: none;
}
.ib-status-en_attente { background:#fffbe6 !important; color:#bfa600 !important; }
.ib-status-confirmee { background:#e6ffed !important; color:#1ca97c !important; }
.ib-status-annulee { background:#ffeaea !important; color:#e05c5c !important; }
.ib-status-complete { background:#e0e7ff !important; color:#4f46e5 !important; }
.ib-status-no_show { background:#fbeee6 !important; color:#bfa600 !important; }
#ib-booking-search:focus { border-color:#b95c8a; background:#fff; color:#b95c8a; box-shadow:0 2px 12px #e9aebc33; }
.ib-modal-bg {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: #22223b55;
  z-index: 1001;
  display: none;
}
.ib-modal {
  position: fixed;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px #e9aebc55;
  padding: 2.2rem 2.2rem 1.5rem 2.2rem;
  z-index: 1002;
  display: none;
  animation: ibModalIn 0.25s;
}
@keyframes ibModalIn {
  from { opacity: 0; transform: translate(-50%, -40%); }
  to { opacity: 1; transform: translate(-50%, -50%); }
}
.ib-status-badge.ib-status-en_attente { background:#fffbe6 !important; border:1.5px solid #ffe066; }
.ib-status-badge.ib-status-confirmee { background:#e6ffed !important; border:1.5px solid #7ee7b7; }
.ib-status-badge.ib-status-annulee { background:#ffeaea !important; border:1.5px solid #f8b4b4; }
.ib-status-badge.ib-status-complete { background:#e0e7ff !important; border:1.5px solid #a5b4fc; }
.ib-status-badge.ib-status-no_show { background:#fbeee6 !important; border:1.5px solid #ffe066; }
/* Limite la largeur du champ téléphone et du sélecteur pays */
#add-booking-client-phone, #edit-booking-client-phone {
  max-width: 260px;
  min-width: 160px;
  width: 100%;
}
.iti {
  width: 100%;
}
.iti--allow-dropdown .iti__country-list {
  max-height: 220px;
  overflow-y: auto;
  z-index: 99999 !important;
  box-shadow: 0 4px 24px #e9aebc33;
  border-radius: 12px;
  font-size: 1em;
}
.iti__country-list {
  background: #fffafd;
  color: #b95c8a;
  border: 1.5px solid #e9aebc;
}
.iti__country.iti__highlight {
  background: #fbeff3;
}
.iti__country {
  padding: 7px 14px;
}
.iti__flag-container {
  border-radius: 8px 0 0 8px;
}
@media (max-width: 600px) {
  #add-booking-client-phone, #edit-booking-client-phone {max-width: 100%;}
  .iti__country-list {font-size: 0.97em;}
}
.ib-booking-form-admin {
  display: block;
  max-width: 420px;
  margin: 0 auto;
  background: #fffafd;
  border-radius: 18px;
  box-shadow: 0 4px 24px #e9aebc33;
  padding: 2.2rem 2.2rem 1.5rem 2.2rem;
}
.ib-booking-form-admin label {
  display: block;
  margin-bottom: 0.4em;
  color: #e9aebc;
  font-weight: 600;
  font-size: 1.07em;
  letter-spacing: 0.01em;
}
.ib-booking-form-admin input,
.ib-booking-form-admin select {
  display: block;
  width: 100%;
  border-radius: 12px;
  border: 1.5px solid #e9aebc;
  background: #fbeff3;
  color: #b95c8a;
  font-size: 1.07em;
  padding: 0.7em 1em;
  margin-bottom: 1.2em;
  box-shadow: 0 2px 8px #e9aebc11;
  outline: none;
  transition: border 0.18s, box-shadow 0.18s;
}
.ib-booking-form-admin input:focus,
.ib-booking-form-admin select:focus {
  border: 1.5px solid #b95c8a;
  box-shadow: 0 4px 16px #e9aebc22;
}
.ib-booking-form-admin .intl-tel-input {
  width: 100%;
}
.ib-booking-form-admin .iti {
  width: 100%;
}
.ib-booking-form-admin .iti__country-list {
  max-height: 220px;
  overflow-y: auto;
  z-index: 99999 !important;
  box-shadow: 0 4px 24px #e9aebc33;
  border-radius: 12px;
  font-size: 1em;
  background: #fffafd;
  color: #b95c8a;
  border: 1.5px solid #e9aebc;
}
.ib-booking-form-admin .iti__country.iti__highlight {
  background: #fbeff3;
}
.ib-booking-form-admin .iti__country {
  padding: 7px 14px;
}
.ib-booking-form-admin .iti__flag-container {
  border-radius: 8px 0 0 8px;
}
.ib-booking-form-admin .ib-btn {
  width: 100%;
  border-radius: 12px;
  background: linear-gradient(90deg, #fbeff3 0%, #e9aebc 100%);
  color: #b95c8a;
  font-weight: 700;
  font-size: 1.1em;
  padding: 0.9em 0;
  margin-bottom: 0.7em;
  border: none;
  box-shadow: 0 2px 12px #e9aebc22;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.1s;
  cursor: pointer;
}
.ib-booking-form-admin .ib-btn.cancel {
  background: #fffafd;
  color: #e9aebc;
  border: 1.5px solid #e9aebc;
}
.ib-booking-form-admin .ib-btn:hover {
  background: linear-gradient(90deg, #e9aebc 0%, #b95c8a 100%);
  color: #fff;
  box-shadow: 0 4px 24px #e9aebc33;
  transform: translateY(-2px) scale(1.04);
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/utils.js"></script>
<script>
jQuery(function($){
  // Ouvre la modal d'ajout
  $('#ib-open-add-booking-modal').on('click', function(){
    $('#ib-add-booking-modal-bg, #ib-add-booking-modal').fadeIn(180);
  });
  // Ferme la modal d'ajout
  $('#ib-close-add-booking-modal, #ib-add-booking-modal-bg').on('click', function(){
    $('#ib-add-booking-modal-bg, #ib-add-booking-modal').fadeOut(120);
  });
  // Masquer la modal après ajout réussi
  if ($('.notice-success:contains("Réservation ajoutée")').length) {
    $('#ib-add-booking-modal-bg, #ib-add-booking-modal').hide();
  }
});
// Filtrage et tri JS du tableau de réservations
const searchInput = document.getElementById('ib-booking-search');
const resetBtn = document.getElementById('ib-booking-reset');
const filterStatus = document.getElementById('ib-booking-filter-status');
const filterEmployee = document.getElementById('ib-booking-filter-employee');
const filterService = document.getElementById('ib-booking-filter-service');
const filterDate = document.getElementById('ib-booking-filter-date');
function filterTable() {
  const value = searchInput.value.toLowerCase();
  const status = filterStatus.value;
  const emp = filterEmployee.value;
  const srv = filterService.value;
  const date = filterDate.value;
  document.querySelectorAll('.ib-table-bookings tbody tr').forEach(row => {
    const nom = row.children[0]?.textContent.toLowerCase() || '';
    const tel = row.children[2]?.textContent.toLowerCase() || '';
    const stat = row.children[7]?.querySelector('select')?.value || '';
    const empId = row.children[4]?.getAttribute('data-emp-id') || '';
    const srvId = row.children[3]?.getAttribute('data-srv-id') || '';
    const rowDate = row.children[5]?.getAttribute('data-date') || '';
    let show = true;
    if (value && !(nom.includes(value) || tel.includes(value))) show = false;
    if (status && stat !== status) show = false;
    if (emp && empId !== emp) show = false;
    if (srv && srvId !== srv) show = false;
    if (date && rowDate !== date) show = false;
    row.style.display = show ? '' : 'none';
  });
}
if (searchInput) searchInput.addEventListener('input', filterTable);
if (resetBtn) resetBtn.addEventListener('click', function(){
  searchInput.value = '';
  filterStatus.value = '';
  filterEmployee.value = '';
  filterService.value = '';
  filterDate.value = '';
  filterTable();
});
if (filterStatus) filterStatus.addEventListener('change', filterTable);
if (filterEmployee) filterEmployee.addEventListener('change', filterTable);
if (filterService) filterService.addEventListener('change', filterTable);
if (filterDate) filterDate.addEventListener('change', filterTable);

// Tri JS
let sortDirection = {};
function sortTable(colIdx, type) {
  const tbody = document.querySelector('.ib-table-bookings tbody');
  const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
  const dir = sortDirection[colIdx] === 'asc' ? 'desc' : 'asc';
  sortDirection[colIdx] = dir;
  rows.sort((a, b) => {
    let va = a.children[colIdx]?.textContent.trim().toLowerCase() || '';
    let vb = b.children[colIdx]?.textContent.trim().toLowerCase() || '';
    if (type === 'date') {
      va = a.children[colIdx]?.getAttribute('data-date') || '';
      vb = b.children[colIdx]?.getAttribute('data-date') || '';
    }
    if (type === 'number') {
      va = parseFloat(va.replace(/\D/g, '')) || 0;
      vb = parseFloat(vb.replace(/\D/g, '')) || 0;
    }
    if (va < vb) return dir === 'asc' ? -1 : 1;
    if (va > vb) return dir === 'asc' ? 1 : -1;
    return 0;
  });
  rows.forEach(r => tbody.appendChild(r));
  // Indicateur visuel
  document.querySelectorAll('.sort-arrow').forEach(e => e.textContent = '');
  const arrow = dir === 'asc' ? '▲' : '▼';
  document.querySelector('.ib-table-bookings th[data-sort]:nth-child('+(colIdx+1)+') .sort-arrow').textContent = arrow;
}
document.querySelectorAll('.ib-table-bookings th[data-sort]').forEach((th, idx) => {
  let type = 'string';
  if (th.dataset.sort === 'date') type = 'date';
  if (th.dataset.sort === 'phone') type = 'number';
  th.addEventListener('click', () => sortTable(idx, type));
});
// Forcer l'affichage du modal édition si présent
if (document.getElementById('ib-modal-edit-booking')) {
  document.getElementById('ib-modal-bg-booking').style.display = 'block';
  document.getElementById('ib-modal-edit-booking').style.display = 'block';
  document.body.style.overflow = 'hidden';
}
document.addEventListener('DOMContentLoaded', function() {
  // Téléphone ajout
  var phoneInput = document.querySelector('#add-booking-client-phone');
  if (phoneInput && window.intlTelInput) {
    window.iti = window.intlTelInput(phoneInput, {
      initialCountry: 'dz',
      preferredCountries: ['dz', 'fr', 'ma', 'tn'],
      utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/utils.js',
      nationalMode: false,
      autoPlaceholder: 'polite',
      formatOnDisplay: true,
      separateDialCode: true,
      showFlags: true
    });
    var form = phoneInput.closest('form');
    if (form) {
      form.addEventListener('submit', function(e) {
        if (window.iti) {
          var intlNumber = window.iti.getNumber();
          if (intlNumber) phoneInput.value = intlNumber;
        }
      });
    }
  }
  // Téléphone édition
  var phoneInputEdit = document.querySelector('#edit-booking-client-phone');
  if (phoneInputEdit && window.intlTelInput) {
    window.itiEdit = window.intlTelInput(phoneInputEdit, {
      initialCountry: 'dz',
      preferredCountries: ['dz', 'fr', 'ma', 'tn'],
      utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/utils.js',
      nationalMode: false,
      autoPlaceholder: 'polite',
      formatOnDisplay: true,
      separateDialCode: true,
      showFlags: true
    });
    var formEdit = phoneInputEdit.closest('form');
    if (formEdit) {
      formEdit.addEventListener('submit', function(e) {
        if (window.itiEdit) {
          var intlNumber = window.itiEdit.getNumber();
          if (intlNumber) phoneInputEdit.value = intlNumber;
        }
      });
    }
  }

  // Filtrage dynamique des employés selon le service sélectionné (logique frontend)
  var serviceSelect = document.getElementById('add-booking-service');
  var employeeSelect = document.getElementById('add-booking-employee');
  var allEmployees = window.adminEmployees || [];
  var allServices = window.adminServices || [];
  if (serviceSelect && employeeSelect) {
    serviceSelect.addEventListener('change', function() {
      var selectedServiceId = parseInt(this.value);
      // Trouver le service sélectionné
      var selectedService = allServices.find(function(s) { return parseInt(s.id) === selectedServiceId; });
      // Filtrer les employés
      var allowedEmployeeIds = selectedService && selectedService.employee_ids ? selectedService.employee_ids.map(Number) : [];
      // Vide le select
      employeeSelect.innerHTML = '<option value="">Choisir</option>';
      allEmployees.forEach(function(emp) {
        if (!allowedEmployeeIds.length || allowedEmployeeIds.includes(Number(emp.id))) {
          var opt = document.createElement('option');
          opt.value = emp.id;
          opt.text = emp.name || ('Employé #' + emp.id);
          employeeSelect.appendChild(opt);
        }
      });
    });
  }
});
window.adminServices = <?php echo json_encode($services); ?>;
window.adminEmployees = <?php echo json_encode($employees); ?>;
console.log('DEBUG adminServices:', window.adminServices);
console.log('DEBUG adminEmployees:', window.adminEmployees);
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  setTimeout(function() {
    console.log('JS FOUC fix exécuté');
    // Afficher le tableau après chargement du style
    var table = document.querySelector('.ib-table-bookings');
    if(table) {
      table.classList.remove('ib-invisible');
      table.classList.add('ib-visible');
      table.style.display = 'table';
    }
    // Afficher le modal d’édition après chargement du style
    var modal = document.getElementById('ib-modal-edit-booking');
    var bg = document.getElementById('ib-modal-bg-booking');
    if(modal) {
      modal.classList.remove('ib-invisible');
      modal.classList.add('ib-visible');
      modal.style.display = 'block';
    }
    if(bg) {
      bg.classList.remove('ib-invisible');
      bg.classList.add('ib-visible');
      bg.style.display = 'block';
    }
  }, 200);
});
</script>
<style>body.ib-hide { display: none !important; } body { transition: opacity 0.3s; } body.ib-hide { opacity: 0; }</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.body.classList.add('ib-hide');
});
window.addEventListener('load', function() {
  document.body.classList.remove('ib-hide');
});
</script>
