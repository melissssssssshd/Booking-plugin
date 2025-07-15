<?php
// Page de vue calendrier
require_once plugin_dir_path(__FILE__) . '../includes/class-services.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-employees.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-categories.php';
require_once plugin_dir_path(__FILE__) . '../includes/class-bookings.php';
$bookings = IB_Bookings::get_all();
$services = IB_Services::get_all();
$employees = IB_Employees::get_all();
$categories = IB_Categories::get_all();
// Couleur unique par employé
$employee_colors = [];
$employee_palette = ['#4f8cff','#00c48c','#ffb300','#ff4f64','#7c3aed','#ff6f00','#00bcd4','#8bc34a','#e67e22','#e84393','#00b894','#636e72','#fdcb6e','#0984e3','#d35400','#6c5ce7'];
foreach ($employees as $i => $emp) {
    $employee_colors[$emp->id] = $employee_palette[$i % count($employee_palette)];
}
$opening_time = get_option('ib_opening_time', '09:00');
$closing_time = get_option('ib_closing_time', '19:00');
include_once plugin_dir_path(__FILE__) . '/layout.php';
?>

<div class="ib-calendar-page">
    <div class="ib-calendar-content">
        <h1>Agenda</h1>
        <form id="ib-calendar-filters-form" class="ib-calendar-filters" style="gap:2em;">
            <span class="ib-calendar-filters-title"><svg width="18" height="18" fill="none" stroke="#2b7cff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg> Filtres</span>
            <div class="ib-form-group" style="min-width:170px;">
                <select id="ib-calendar-employee" class="ib-input" name="employee">
                    <option value="">👤 Tous employés</option>
                    <?php foreach($employees as $e): ?>
                        <?php if (isset($e->role) && mb_strtolower(trim($e->role), 'UTF-8') === 'employé'): ?>
                        <option value="<?php echo $e->id; ?>" data-color="<?php echo $employee_colors[$e->id]; ?>"><?php echo esc_html($e->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <label class="ib-label" for="ib-calendar-employee">Employé</label>
            </div>
            <div class="ib-form-group" style="min-width:170px;">
                <select id="ib-calendar-service" class="ib-input" name="service">
                    <option value="">💼 Tous services</option>
                    <?php foreach($services as $s): ?>
                        <option value="<?php echo $s->id; ?>"><?php echo esc_html($s->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="ib-label" for="ib-calendar-service">Service</label>
            </div>
            <div class="ib-form-group" style="min-width:170px;">
                <select id="ib-calendar-category" class="ib-input" name="category">
                    <option value="">📂 Toutes catégories</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat->id; ?>"><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="ib-label" for="ib-calendar-category">Catégorie</label>
            </div>
            <button id="ib-calendar-export" type="button" class="ib-btn accent ib-btn-export"><svg width="18" height="18" fill="none" stroke="#e9aebc" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg> Export CSV</button>
        </form>
        <div class="ib-employee-bar">
            <div class="ib-employee-chip ib-employee-chip-all active" data-employee="">
                <span class="ib-employee-avatar ib-employee-avatar-all"><svg width="24" height="24" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></span>
                <span class="ib-employee-name">Tous employés</span>
            </div>
            <?php foreach($employees as $e): ?>
                <?php if (isset($e->role) && mb_strtolower(trim($e->role), 'UTF-8') === 'employé'): ?>
                <div class="ib-employee-chip" data-employee="<?php echo $e->id; ?>">
                    <span class="ib-employee-avatar" style="background:<?php echo $employee_colors[$e->id]; ?>;color:#fff;">
                        <?php echo strtoupper(mb_substr($e->name,0,1)); ?>
                    </span>
                    <span class="ib-employee-name"><?php echo esc_html($e->name); ?></span>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div id="apple-calendar-container" style="width:100%;max-width:100%;margin-top:2em;"></div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo plugin_dir_url(__DIR__); ?>assets/apple-calendar/styles.css">
<script src="<?php echo plugin_dir_url(__DIR__); ?>assets/apple-calendar/script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const container = document.getElementById('apple-calendar-container');
  if (container) {
    // Injecte le HTML complet attendu par le calendrier Apple-like
    container.innerHTML = `
      <div id="beauty-calendar-root">
        <div class="calendar-header">
          <button id="addBtn" class="add-btn">+</button>
          <div class="view-switch">
            <button class="view-btn active" data-view="day">Jour</button>
            <button class="view-btn" data-view="week">Semaine</button>
            <button class="view-btn" data-view="month">Mois</button>
          </div>
          <input type="text" id="searchInput" placeholder="🔍 Rechercher..." />
          <div class="calendar-nav">
            <button id="prevBtn">&lt;</button>
            <button id="todayBtn">Aujourd'hui</button>
            <button id="nextBtn">&gt;</button>
                </div>
            </div>
        <div id="dateTitle" class="calendar-date-title"></div>
        <div id="weekView" class="calendar-view">
          <div id="dayHeaders"></div>
          <div id="daysGrid"></div>
        </div>
        <div id="dayView" class="calendar-view" style="display:none;">
          <div id="allDaySection" style="display:none;">
            <div class="all-day-label">Toute la journée</div>
            <div id="allDayEvents"></div>
          </div>
          <div id="dayEventsColumn" class="day-events-column"></div>
        </div>
        <div id="monthView" class="calendar-view" style="display:none;">
          <div id="monthGrid"></div>
        </div>
        <div id="addEventModal" class="modal" style="display:none;">
          <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>
            <form id="eventForm">
              <input type="text" id="eventTitle" placeholder="Titre" required />
              <input type="date" id="eventDate" required />
              <input type="time" id="eventStartTime" required />
              <input type="time" id="eventEndTime" required />
              <input type="text" id="eventClient" placeholder="Client" />
              <input type="text" id="eventService" placeholder="Service" />
              <button type="submit" id="saveEventBtn">Enregistrer</button>
              <button type="button" id="cancelBtn">Annuler</button>
            </form>
          </div>
                </div>
            </div>
        `;
    new BeautyCalendar();
  }
});
</script>
