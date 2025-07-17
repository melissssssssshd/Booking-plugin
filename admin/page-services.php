<?php
if (!defined('ABSPATH')) exit;
require_once plugin_dir_path(__FILE__) . '../includes/class-services.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-categories.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-service-employees.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-employees.php';
$categories = IB_Categories::get_all();
$employees = IB_Employees::get_all();
// Traitement ajout service
if (isset($_POST['add_service'])) {
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $duration = isset($_POST['duration']) ? intval($_POST['duration']) : null;
    $price_type = isset($_POST['price_type']) ? $_POST['price_type'] : 'fixed';
    $variable_price = ($price_type === 'variable') ? 1 : 0;
    $price = ($price_type === 'fixed' && isset($_POST['price'])) ? floatval($_POST['price']) : null;
    if ($price !== null) $price = (fmod($price, 1) == 0) ? intval($price) : round($price, 2);
    $min_price = ($price_type === 'variable' && isset($_POST['min_price'])) ? floatval(str_replace(',', '.', $_POST['min_price'])) : null;
    if ($min_price !== null) $min_price = (fmod($min_price, 1) == 0) ? intval($min_price) : round($min_price, 2);
    $max_price = ($price_type === 'variable' && isset($_POST['max_price'])) ? floatval(str_replace(',', '.', $_POST['max_price'])) : null;
    if ($max_price !== null) $max_price = (fmod($max_price, 1) == 0) ? intval($max_price) : round($max_price, 2);
    if ($variable_price) $price = null;
    // Debug temporaire
    // error_log('DEBUG min_price: ' . print_r($min_price, true));
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $employee_ids = isset($_POST['employee_ids']) ? array_map('intval', $_POST['employee_ids']) : [];
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded = wp_handle_upload($_FILES['image'], ['test_form' => false]);
        if (!isset($uploaded['error']) && isset($uploaded['url'])) {
            $image = $uploaded['url'];
        }
    }
    if (!$name || !$duration || ($price_type === 'fixed' && ($price === null || $price === '')) || ($price_type === 'variable' && ($min_price === null || $min_price === ''))) {
        echo '<div class="notice notice-error" style="margin-bottom:1.5em;"><p>Veuillez remplir tous les champs obligatoires.</p></div>';
    } else {
        $service_id = IB_Services::add($name, $duration, $price, $image, $category_id, $variable_price, $min_price, $max_price);
        if ($service_id && !empty($employee_ids)) {
            IB_Service_Employees::set_employees_for_service($service_id, $employee_ids);
        }
        echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Service ajouté avec succès.</p></div>';
    }
}
// Traitement édition service
if (isset($_POST['update_service'])) {
    $id = intval($_POST['service_id']);
    $name = sanitize_text_field($_POST['name']);
    $duration = intval($_POST['duration']);
    $price_type = isset($_POST['price_type']) ? $_POST['price_type'] : 'fixed';
    $variable_price = ($price_type === 'variable') ? 1 : 0;
    $price = ($variable_price === 0 && isset($_POST['price'])) ? round(floatval($_POST['price']), 2) : null;
    $min_price = ($variable_price === 1 && isset($_POST['min_price'])) ? round(floatval($_POST['min_price']), 2) : null;
    $max_price = ($variable_price === 1 && isset($_POST['max_price'])) ? round(floatval($_POST['max_price']), 2) : null;
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $employee_ids = isset($_POST['employee_ids']) ? array_map('intval', $_POST['employee_ids']) : [];
    // Gestion image :
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded = wp_handle_upload($_FILES['image'], ['test_form' => false]);
        if (!isset($uploaded['error']) && isset($uploaded['url'])) {
            $image = $uploaded['url'];
        }
    } else if (!empty($_POST['image_old'])) {
        $image = esc_url_raw($_POST['image_old']);
    } else {
        $edit_service = IB_Services::get_by_id($id);
        $image = $edit_service && !empty($edit_service->image) ? esc_url_raw($edit_service->image) : null;
    }
    IB_Services::update($id, $name, $duration, $price, $image, $category_id, $variable_price, $min_price, $max_price);
    IB_Service_Employees::set_employees_for_service($id, $employee_ids);
    echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Service modifié avec succès.</p></div>';
}
// Traitement suppression service
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    IB_Services::delete((int)$_GET['id']);
    echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Service supprimé avec succès.</p></div>';
}
// Traitement ajout catégorie
if (isset($_POST['add_category'])) {
    $cat_name = sanitize_text_field($_POST['cat_name']);
    $cat_color = sanitize_hex_color($_POST['cat_color']);
    $cat_icon = sanitize_text_field($_POST['cat_icon']);
    IB_Categories::add($cat_name, $cat_color, $cat_icon);
    echo '<div class="notice notice-success" style="margin-bottom:1.5em;"><p>Catégorie ajoutée avec succès.</p></div>';
    $categories = IB_Categories::get_all(); // refresh
}
$services = IB_Services::get_all();
$edit_service = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_service = IB_Services::get_by_id((int)$_GET['id']);
    if (!$edit_service || !is_object($edit_service) || !isset($edit_service->id)) {
        echo '<div class="notice notice-error" style="margin:2em auto;max-width:600px;"><b>Erreur :</b> Service introuvable ou supprimé.</div>';
        $edit_service = null;
    }
}
?>
<div class="ib-services-page">
  <div class="ib-services-content">
    <div class="ib-admin-section-header" style="display:flex;align-items:center;gap:1.2rem;justify-content:flex-start;">
      <div style="font-size:1.18rem;font-weight:700;letter-spacing:-0.5px;color:#222;padding-bottom:0.7rem;">Gérer les services</div>
      <button class="ib-btn accent" id="btn-add-service" type="button">+ Ajouter un service</button>
      <button class="ib-btn" id="btn-add-category" type="button">+ Ajouter une catégorie</button>
    </div>
    <form method="get" class="ib-filters-bar">
      <input type="hidden" name="page" value="institut-booking-services">
      <div class="ib-form-group">
        <input class="ib-input" type="text" name="service_name" id="service_name" placeholder=" " value="<?php echo isset($_GET['service_name']) ? esc_attr($_GET['service_name']) : ''; ?>">
        <label for="service_name">Nom du service</label>
      </div>
      <div class="ib-form-group">
        <select class="ib-input" name="service_category" id="service_category">
          <option value="">Sélectionner une catégorie</option>
          <?php foreach($categories as $cat): ?>
            <option value="<?php echo $cat->id; ?>" <?php if(isset($_GET['service_category']) && $_GET['service_category'] == $cat->id) echo 'selected'; ?>><?php echo esc_html($cat->name); ?></option>
          <?php endforeach; ?>
        </select>
        <label for="service_category">Catégorie de service</label>
      </div>
      <button class="ib-btn" type="submit" name="reset" value="1" style="background:#f1f5f9;color:#64748b;border:1px solid #e5e7eb;">Réinitialiser</button>
      <button class="ib-btn accent" type="submit">Appliquer</button>
    </form>
    <table class="ib-admin-table" style="width:100%;max-width:none;margin:0;">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Catégorie</th>
          <th>Durée</th>
          <th>Prix</th>
          <th>Employés</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Logique de filtrage PHP
        if (isset($_GET['reset']) && $_GET['reset'] == '1') {
            $_GET['service_name'] = '';
            $_GET['service_category'] = '';
        }
        $filtered_services = $services;
        if (!empty($_GET['service_name']) || !empty($_GET['service_category'])) {
            $filtered_services = array_filter($services, function($srv) {
                $ok = true;
                if (!empty($_GET['service_name'])) {
                    $ok = $ok && (stripos($srv->name, $_GET['service_name']) !== false);
                }
                if (!empty($_GET['service_category'])) {
                    $ok = $ok && ($srv->category_id == $_GET['service_category']);
                }
                return $ok;
            });
        }
        foreach($filtered_services as $service): ?>
          <tr>
            <td>
              <?php if (!empty($service->image)): ?>
                <img src="<?php echo esc_url($service->image); ?>" alt="" style="width:32px;height:32px;object-fit:cover;border-radius:6px;margin-right:0.7em;vertical-align:middle;">
              <?php endif; ?>
              <?php echo esc_html($service->name); ?>
            </td>
            <td><?php 
              $cat = null;
              foreach($categories as $c) if($c->id == $service->category_id) $cat = $c;
              echo $cat ? esc_html($cat->name) : '-';
            ?></td>
            <td><?php echo esc_html($service->duration); ?> min</td>
            <td>
    <?php
    $min = round(floatval($service->min_price), 2);
    $max = round(floatval($service->max_price), 2);
    if ($service->variable_price) {
        if ($min > 0 && $max > 0) {
            echo 'De ' . ((fmod($min, 1) == 0) ? number_format($min, 0, ',', ' ') : number_format($min, 2, ',', ' '))
               . ' à ' . ((fmod($max, 1) == 0) ? number_format($max, 0, ',', ' ') : number_format($max, 2, ',', ' '))
               . ' DA';
        } elseif ($min > 0) {
            echo 'À partir de ' . ((fmod($min, 1) == 0) ? number_format($min, 0, ',', ' ') : number_format($min, 2, ',', ' '))
               . ' DA';
        } else {
            echo 'Variable';
        }
    } else {
        $prix = round($service->price, 2);
        echo (fmod($prix, 1) == 0) ? number_format($prix, 0, ',', ' ') . ' DA' : number_format($prix, 2, ',', ' ') . ' DA';
    }
    ?>
            </td>
            <td><?php 
              $service_emps = IB_Service_Employees::get_employees_for_service($service->id);
              $names = array();
              foreach($service_emps as $emp_id) {
                $emp = IB_Employees::get_by_id($emp_id);
                if ($emp && isset($emp->name)) $names[] = esc_html($emp->name);
              }
              echo $names ? implode(', ', $names) : '-';
            ?></td>
            <td>
              <div class="ib-action-btns">
                <a href="admin.php?page=institut-booking-services&action=edit&id=<?php echo $service->id; ?>" class="ib-icon-btn edit" title="Éditer">
                  <svg width="22" height="22" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>
                </a>
                <a href="admin.php?page=institut-booking-services&action=delete&id=<?php echo $service->id; ?>" class="ib-icon-btn delete" title="Supprimer" onclick="return confirm('Supprimer ce service ?')">
                  <svg width="22" height="22" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL AJOUT SERVICE -->
<div id="ib-modal-bg-add-service" class="ib-modal-bg" style="display:none;"></div>
<div id="ib-add-service-form" class="ib-modal" style="display:none;">
  <button class="ib-modal-close" type="button" onclick="closeAddServiceModal()">&times;</button>
  <div class="ib-form-title">Ajouter un service</div>
  <form method="post" enctype="multipart/form-data">
    <div class="ib-service-img-preview">
      <img src="<?php echo isset($edit_service->image) && $edit_service->image ? esc_url($edit_service->image) : 'https://ui-avatars.com/api/?name=Service&background=e9aebc&color=fff&rounded=true'; ?>" alt="Image du service" id="ib-service-img-add">
      <label for="ib-service-img-input-add" class="ib-upload-label">Changer l'image</label>
      <input type="file" id="ib-service-img-input-add" name="image" accept="image/*" onchange="ibPreviewServiceImgAdd(event)">
    </div>
    <div class="ib-form-group">
      <input class="ib-input" name="name" id="add_service_name" placeholder=" " required>
      <label for="add_service_name">Nom</label>
    </div>
    <div class="ib-form-group">
      <input class="ib-input" name="duration" id="add_service_duration" type="number" placeholder=" " required>
      <label for="add_service_duration">Durée (min)</label>
    </div>
    <div class="ib-form-radio-group" style="display:flex;gap:1.5em;align-items:center;margin-bottom:1.2em;">
      <span style="font-weight:600;color:#e9aebc;">Type de prix :</span>
      <label style="display:flex;align-items:center;gap:0.4em;font-weight:500;">
        <input type="radio" name="price_type" value="fixed" checked onchange="togglePriceFields('add', 'fixed')"> Prix fixe
      </label>
      <label style="display:flex;align-items:center;gap:0.4em;font-weight:500;">
        <input type="radio" name="price_type" value="variable" onchange="togglePriceFields('add', 'variable')"> Prix variable
      </label>
    </div>
    <div class="ib-form-group" id="add-fixed-price-group">
      <input class="ib-input" name="price" id="add_service_price" type="number" step="0.01" placeholder=" ">
      <label for="add_service_price">Prix</label>
    </div>
    <div id="add-variable-price-group" style="display:none;">
      <div class="ib-form-group">
        <input class="ib-input" name="min_price" id="add_service_min_price" type="number" step="0.01" placeholder=" ">
        <label for="add_service_min_price">Prix min</label>
      </div>
      <div class="ib-form-group">
        <input class="ib-input" name="max_price" id="add_service_max_price" type="number" step="0.01" placeholder=" ">
        <label for="add_service_max_price">Prix max</label>
      </div>
    </div>
    <div class="ib-form-group">
      <select class="ib-input" name="category_id" id="add_service_category">
        <option value="">Aucune</option>
        <?php foreach($categories as $cat): ?>
          <option value="<?php echo $cat->id; ?>"><?php echo esc_html($cat->name); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="add_service_category">Catégorie</label>
    </div>
    <div class="ib-form-group">
      <select class="ib-input" name="employee_ids[]" id="add_service_employees" multiple size="3">
        <?php foreach($employees as $emp): ?>
          <option value="<?php echo $emp->id; ?>"><?php echo esc_html($emp->name); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="add_service_employees">Employés concernés</label>
    </div>
    <div class="ib-form-group" style="margin-top:1.2em;display:flex;gap:1em;">
      <button class="ib-btn accent" type="submit" name="add_service">Ajouter</button>
      <button type="button" class="ib-btn cancel" onclick="closeAddServiceModal()">Annuler</button>
    </div>
  </form>
</div>

<!-- MODAL ÉDITION SERVICE -->
<div id="ib-modal-bg-edit-service" class="ib-modal-bg" style="display:none;"></div>
<div id="ib-edit-service-form" class="ib-modal" style="display:none;">
  <button class="ib-modal-close" type="button" onclick="closeEditServiceModal()">&times;</button>
  <div class="ib-form-title">Modifier le service</div>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="service_id" value="<?php echo esc_attr($edit_service->id); ?>">
    <input type="hidden" name="image_old" value="<?php echo isset($edit_service->image) ? esc_url($edit_service->image) : ''; ?>">
    <div class="ib-service-img-preview">
      <img src="<?php echo $edit_service->image ? esc_url($edit_service->image) : 'https://ui-avatars.com/api/?name=Service&background=e9aebc&color=fff&rounded=true'; ?>" alt="Image du service" id="ib-service-img-edit">
      <label for="ib-service-img-input-edit" class="ib-upload-label">Changer l'image</label>
      <input type="file" id="ib-service-img-input-edit" name="image" accept="image/*" onchange="ibPreviewServiceImgEdit(event)">
    </div>
    <div class="ib-form-group">
      <input class="ib-input" name="name" id="edit_service_name" value="<?php echo esc_attr($edit_service->name); ?>" placeholder=" " required>
      <label for="edit_service_name">Nom</label>
    </div>
    <div class="ib-form-group">
      <input class="ib-input" name="duration" id="edit_service_duration" type="number" value="<?php echo esc_attr($edit_service->duration); ?>" placeholder=" " required>
      <label for="edit_service_duration">Durée (min)</label>
    </div>
    <div class="ib-form-radio-group" style="display:flex;gap:1.5em;align-items:center;margin-bottom:1.2em;">
      <span style="font-weight:600;color:#e9aebc;">Type de prix :</span>
      <label style="display:flex;align-items:center;gap:0.4em;font-weight:500;">
        <input type="radio" name="price_type" value="fixed" <?php echo empty($edit_service->variable_price) ? 'checked' : ''; ?> onchange="togglePriceFields('edit', 'fixed')"> Prix fixe
      </label>
      <label style="display:flex;align-items:center;gap:0.4em;font-weight:500;">
        <input type="radio" name="price_type" value="variable" <?php echo !empty($edit_service->variable_price) ? 'checked' : ''; ?> onchange="togglePriceFields('edit', 'variable')"> Prix variable
      </label>
    </div>
    <div class="ib-form-group" id="edit-fixed-price-group" style="<?php echo empty($edit_service->variable_price) ? '' : 'display:none;'; ?>">
      <input class="ib-input" name="price" id="edit_service_price" type="number" step="0.01" value="<?php echo esc_attr($edit_service->price); ?>" placeholder=" ">
      <label for="edit_service_price">Prix</label>
    </div>
    <div id="edit-variable-price-group" style="<?php echo !empty($edit_service->variable_price) ? '' : 'display:none;'; ?>">
      <div class="ib-form-group">
        <input class="ib-input" name="min_price" id="edit_service_min_price" type="number" step="0.01" value="<?php echo esc_attr($edit_service->min_price); ?>" placeholder=" ">
        <label for="edit_service_min_price">Prix min</label>
      </div>
      <div class="ib-form-group">
        <input class="ib-input" name="max_price" id="edit_service_max_price" type="number" step="0.01" value="<?php echo esc_attr($edit_service->max_price); ?>" placeholder=" ">
        <label for="edit_service_max_price">Prix max</label>
      </div>
    </div>
    <div class="ib-form-group">
      <select class="ib-input" name="category_id" id="edit_service_category">
        <option value="">Aucune</option>
        <?php foreach($categories as $cat): ?>
          <option value="<?php echo $cat->id; ?>" <?php if($edit_service->category_id == $cat->id) echo 'selected'; ?>><?php echo esc_html($cat->name); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="edit_service_category">Catégorie</label>
    </div>
    <div class="ib-form-group">
      <select class="ib-input" name="employee_ids[]" id="edit_service_employees" multiple size="3">
        <?php $service_emps = IB_Service_Employees::get_employees_for_service($edit_service->id); ?>
        <?php foreach($employees as $emp): ?>
          <option value="<?php echo $emp->id; ?>" <?php if(in_array($emp->id, $service_emps)) echo 'selected'; ?>><?php echo esc_html($emp->name); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="edit_service_employees">Employés concernés</label>
    </div>
    <div class="ib-form-group" style="margin-top:1.2em;display:flex;gap:1em;">
      <button class="ib-btn accent" type="submit" name="update_service">Enregistrer</button>
      <button type="button" class="ib-btn cancel" onclick="closeEditServiceModal()">Annuler</button>
    </div>
  </form>
</div>

<!-- MODAL AJOUT CATÉGORIE -->
<div id="ib-modal-bg-add-category" class="ib-modal-bg" style="display:none;"></div>
<div id="ib-add-category-form" class="ib-modal" style="display:none;">
  <button class="ib-modal-close" type="button" onclick="closeAddCategoryModal()">&times;</button>
  <div class="ib-form-title">Ajouter une catégorie</div>
  <form method="post">
    <div class="ib-form-group">
      <label>Nom</label>
      <input class="ib-input" name="cat_name" required>
    </div>
    <div class="ib-form-group">
      <label>Couleur</label>
      <input class="ib-input" name="cat_color" type="color" value="#3a7afe">
    </div>
    <div class="ib-form-group">
      <label>Icône</label>
      <input class="ib-input" name="cat_icon" type="text">
    </div>
    <div class="ib-form-group" style="margin-top:1.2em;display:flex;gap:1em;">
      <button class="ib-btn accent" type="submit" name="add_category">Ajouter</button>
      <button type="button" class="ib-btn cancel" onclick="closeAddCategoryModal()">Annuler</button>
    </div>
  </form>
</div>

<!-- Ajout Choices.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
// MODAL AJOUT SERVICE
function openAddServiceModal() {
  document.getElementById('ib-modal-bg-add-service').style.display = 'block';
  document.getElementById('ib-add-service-form').style.display = 'block';
}
function closeAddServiceModal() {
  document.getElementById('ib-modal-bg-add-service').style.display = 'none';
  document.getElementById('ib-add-service-form').style.display = 'none';
}
document.getElementById('btn-add-service').onclick = openAddServiceModal;
document.getElementById('ib-modal-bg-add-service').onclick = function(e) {
  if (e.target === this) closeAddServiceModal();
};

// MODAL ÉDITION SERVICE
function openEditServiceModal() {
  document.getElementById('ib-modal-bg-edit-service').style.display = 'block';
  document.getElementById('ib-edit-service-form').style.display = 'block';
}
function closeEditServiceModal() {
  document.getElementById('ib-modal-bg-edit-service').style.display = 'none';
  document.getElementById('ib-edit-service-form').style.display = 'none';
}
document.getElementById('ib-modal-bg-edit-service').onclick = function(e) {
  if (e.target === this) closeEditServiceModal();
};

document.addEventListener('DOMContentLoaded', function() {
  var hasSuccess = document.querySelector('.notice-success, .notice-error');
  var isPost = window.location.search.includes('action=edit') && (window.location.href.indexOf('add_service') !== -1 || window.location.href.indexOf('update_service') !== -1);
  if (window.location.search.includes('action=edit') && !hasSuccess && !isPost) {
    openEditServiceModal();
  }
  if (document.getElementById('add_service_employees')) {
    new Choices('#add_service_employees', { removeItemButton: true, searchResultLimit: 10, placeholder: true, placeholderValue: 'Sélectionner un ou plusieurs employés' });
  }
  if (document.getElementById('edit_service_employees')) {
    new Choices('#edit_service_employees', { removeItemButton: true, searchResultLimit: 10, placeholder: true, placeholderValue: 'Sélectionner un ou plusieurs employés' });
  }
});

// MODAL AJOUT CATÉGORIE
function openAddCategoryModal() {
  document.getElementById('ib-modal-bg-add-category').style.display = 'block';
  document.getElementById('ib-add-category-form').style.display = 'block';
}
function closeAddCategoryModal() {
  document.getElementById('ib-modal-bg-add-category').style.display = 'none';
  document.getElementById('ib-add-category-form').style.display = 'none';
}
document.getElementById('btn-add-category').onclick = openAddCategoryModal;
document.getElementById('ib-modal-bg-add-category').onclick = closeAddCategoryModal;

// Preview image service (ajout)
function ibPreviewServiceImgAdd(event) {
  const [file] = event.target.files;
  if (file) {
    document.getElementById('ib-service-img-add').src = URL.createObjectURL(file);
  }
}
// Preview image service (édition)
function ibPreviewServiceImgEdit(event) {
  const [file] = event.target.files;
  if (file) {
    document.getElementById('ib-service-img-edit').src = URL.createObjectURL(file);
  }
}

function togglePriceFields(context, type) {
  if(type === 'fixed') {
    document.getElementById(context+'-fixed-price-group').style.display = '';
    document.getElementById(context+'-variable-price-group').style.display = 'none';
  } else {
    document.getElementById(context+'-fixed-price-group').style.display = 'none';
    document.getElementById(context+'-variable-price-group').style.display = '';
  }
}
</script>
