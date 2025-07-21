<?php
require_once plugin_dir_path(__FILE__) . '/../includes/class-services.php';
require_once plugin_dir_path(__FILE__) . '/../includes/class-employees.php';
require_once plugin_dir_path(__FILE__) . '/../includes/class-service-employees.php';
require_once plugin_dir_path(__FILE__) . '/../includes/class-availability.php';

$services = IB_Services::get_all();
$employees = IB_Employees::get_all();

// Ajout du champ employee_ids à chaque service
foreach ($services as &$service) {
    $service->employee_ids = IB_Service_Employees::get_employees_for_service($service->id);
    if ($service->image === "NULL" || $service->image === NULL) {
        $service->image = null;
    }
}
unset($service);

// Fonction de récupération des créneaux disponibles
function get_available_slots($employee_id, $service_id, $date) {
    return IB_Availability::get_available_slots($employee_id, $service_id, $date);
}

// Fonction pour vérifier si une date est valide (jour ouvré)
function is_valid_date($date) {
    $day = strtolower(date('l', strtotime($date)));
    return IB_Availability::is_day_open($day);
}

// Fonction pour obtenir la prochaine date disponible
function get_next_available_date($employee_id, $service_id, $start_date = null) {
    return IB_Availability::get_next_available_date($employee_id, $service_id, $start_date);
}
?>
<!-- Définition de window.ajaxurl pour tous les scripts JS -->
<script>
window.ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
window.ib_nonce = "<?php echo wp_create_nonce('ib_nonce'); ?>";
</script>
<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css" />
<!-- intl-tel-input JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>../assets/css/booking-form.css">
<?php include plugin_dir_path(__FILE__) . '/../templates/booking-form.html'; ?>
<script>
window.bookingServices = <?php echo json_encode($services); ?>;
window.bookingEmployees = <?php echo json_encode($employees); ?>;
</script>
<script src="<?php echo plugin_dir_url(__FILE__); ?>../assets/js/booking-form-main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<!-- À placer juste avant le bouton de validation du formulaire, à l'étape "Infos" ou à la fin du formulaire -->
<div class="ib-legal-checkbox" style="margin:1em 0;">
  <label style="font-size:0.97em; color:#606060;">
    <input type="checkbox" required>
    J’ai lu et j’accepte la
    <a href="https://linstitutbykm.com/privacy-policy/" target="_blank" rel="noopener" style="color:#606060; text-decoration:underline;">
      politique de confidentialité
    </a>
    et les
    <a href="https://linstitutbykm.com/refund_returns" target="_blank" rel="noopener" style="color:#606060; text-decoration:underline;">
      conditions générales
    </a>.
  </label>
</div>
