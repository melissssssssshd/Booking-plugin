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
$closing_time = get_option('ib_closing_time', '17:00');
include_once plugin_dir_path(__FILE__) . '/layout.php';
?>

<div class="ib-calendar-page">
    <div class="ib-calendar-content">
        <div id="beauty-calendar-root">
            <div class="calendar-header">
                <div class="header-left">
                    <button class="add-btn" id="addBtn">+</button>
                    <div class="view-buttons">
                        <button class="view-btn" data-view="day">Jour</button>
                        <button class="view-btn active" data-view="week">Semaine</button>
                        <button class="view-btn" data-view="month">Mois</button>
                        <button class="view-btn" data-view="matrix">Matrice</button>
                    </div>
                </div>
                
                <div class="header-center">
                    <div class="employee-filter">
                        <div class="employee-chips" id="employeeChips">
                            <!-- Employee chips will be dynamically inserted here -->
                        </div>
                    </div>
                    <div class="search-container">
                        <span class="search-icon">🔍</span>
                        <input type="text" placeholder="Rechercher..." class="search-input" id="searchInput" />
                    </div>
                </div>
                
                <div class="header-right">
                    <button class="nav-btn" id="prevBtn">‹</button>
                    <button class="today-btn" id="todayBtn">Aujourd'hui</button>
                    <button class="nav-btn" id="nextBtn">›</button>
                </div>
            </div>
            
            <div class="date-title">
                <h1 id="dateTitle"></h1>
            </div>
            
            <div id="weekView" class="calendar-view active">
              <div id="dayHeaders"></div>
              <div id="daysGrid"></div>
            </div>
            <div id="dayView" class="calendar-view">
              <div id="dayEventsColumn"></div>
            </div>
            <div id="monthView" class="calendar-view">
              <div id="monthGrid"></div>
            </div>
            <div id="matrixView" class="calendar-view">
              <div id="matrixGrid"></div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo plugin_dir_url(__DIR__); ?>assets/apple-calendar/styles.css">
<script src="<?php echo plugin_dir_url(__DIR__); ?>assets/apple-calendar/script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  new InstitutCalendar();
});
</script>
