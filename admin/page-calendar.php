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
                        <option value="<?php echo $e->id; ?>" data-color="<?php echo $employee_colors[$e->id]; ?>"><?php echo esc_html($e->name); ?></option>
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
                <div class="ib-employee-chip" data-employee="<?php echo $e->id; ?>">
                    <span class="ib-employee-avatar" style="background:<?php echo $employee_colors[$e->id]; ?>;color:#fff;">
                        <?php echo strtoupper(mb_substr($e->name,0,1)); ?>
                    </span>
                    <span class="ib-employee-name"><?php echo esc_html($e->name); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="ib-calendar-wrapper">
            <div id="booking-calendar"></div>
            <div id="ib-calendar-no-results" style="display:none;text-align:center;color:#888;margin-top:2em;font-size:1.2em;">Aucun résultat pour ces filtres.</div>
        </div>
        <div id="ib-calendar-modal" class="ib-modal-bg" style="display:none;align-items:center;justify-content:center;">
            <div class="ib-modal">
                <button id="ib-calendar-modal-close" class="ib-modal-close" type="button">&times;</button>
                <div id="ib-calendar-modal-content"></div>
            </div>
        </div>
    </div>
</div>
<style>
.ib-calendar-filters .ib-form-group {
    position: relative;
    margin-bottom: 0;
    flex: 1 1 170px;
    min-width: 170px;
}
.ib-calendar-filters .ib-label {
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
.ib-calendar-filters .ib-input:focus + .ib-label,
.ib-calendar-filters .ib-input:not([value=""]) + .ib-label,
.ib-calendar-filters .ib-input:valid + .ib-label,
.ib-calendar-filters select:focus + .ib-label,
.ib-calendar-filters select:not([value=""]) + .ib-label {
    top: -0.7em;
    left: 0.9em;
    font-size: 0.92em;
    color: #e9aebc;
    background: #fff;
    padding: 0 0.3em;
}
.ib-calendar-filters .ib-input:focus {
    border: 2px solid #e9aebc;
    box-shadow: 0 0 0 3px #e9aebc33;
    background: #fff;
}
.ib-calendar-filters .ib-btn.accent {
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
    display: flex;
    align-items: center;
    gap: 0.5em;
}
.ib-calendar-filters .ib-btn.accent:hover {
    background: #d48ca6;
    color: #fff;
    transform: translateY(-2px) scale(1.04);
}
</style>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Palette de couleurs employé (récupérée du PHP)
    const employeeColors = <?php echo json_encode($employee_colors); ?>;
    // Contraste automatique (noir ou blanc selon la couleur de fond)
    function getContrastYIQ(hexcolor){
        hexcolor = hexcolor.replace('#','');
        if(hexcolor.length === 3) hexcolor = hexcolor.split('').map(x=>x+x).join('');
        var r = parseInt(hexcolor.substr(0,2),16);
        var g = parseInt(hexcolor.substr(2,2),16);
        var b = parseInt(hexcolor.substr(4,2),16);
        var yiq = ((r*299)+(g*587)+(b*114))/1000;
        return (yiq >= 180) ? '#22223b' : '#fff';
    }
    // Générer un badge employé
    function getEmployeeBadge(name, color) {
        if (!name) return '';
        const initials = name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase();
        return `<span class=\"ib-emp-badge\" style=\"background:${color};color:${getContrastYIQ(color)}\">${initials}</span>`;
    }
    // Filtrer uniquement les réservations confirmées
    var allEvents = <?php echo json_encode(array_map(function($b) use ($services, $employees, $employee_colors) {
        $service = array_filter($services, function($s) use ($b) { return $s->id == $b->service_id; });
        $service = reset($service);
        $employee = array_filter($employees, function($e) use ($b) { return $e->id == $b->employee_id; });
        $employee = reset($employee);
        
        // Vérification que service et employee existent
        $service_name = $service ? $service->name : 'Service inconnu';
        $employee_name = $employee ? $employee->name : 'Employé inconnu';
        
        return [
            'id' => $b->id,
            'title' => $service_name,
            'start' => $b->date . 'T' . $b->time,
            'end' => $b->date . 'T' . $b->time,
            'color' => $employee_colors[$b->employee_id] ?? '#e9aebc',
            'extendedProps' => [
                'employee' => $employee_name,
                'employee_color' => $employee_colors[$b->employee_id] ?? '#e9aebc',
                'service' => $service_name,
                'client' => $b->client_name,
                'status' => $b->status,
                'notes' => $b->notes,
                'date' => $b->date,
                'time' => $b->time,
                'employee_id' => $b->employee_id
            ]
        ];
    }, $bookings)); ?>;
    allEvents = allEvents.filter(ev => (ev.extendedProps.status === 'confirmé' || ev.extendedProps.status === 'confirme' || ev.extendedProps.status === 'confirmee'));
    // Configuration du calendrier
    var calendarEl = document.getElementById("booking-calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridWeek",
        slotMinTime: '<?php echo $opening_time; ?>',
        slotMaxTime: '<?php echo $closing_time; ?>',
        allDaySlot: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotDuration: '00:30:00',
        slotLabelFormat: { hour: 'numeric', minute: '2-digit', omitZeroMinute: false },
        slotLabelInterval: '01:00',
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: false },
        locale: 'fr',
        firstDay: 1,
        editable: false,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        events: allEvents,
        eventDidMount: function(info) {
            const event = info.event;
            const eventEl = info.el;
            const color = event.extendedProps.employee_color || event.color || '#e9aebc';
            // Affichage ultra-minimaliste : ligne simple
            eventEl.innerHTML = `
                <div class=\"ib-event-miniline\">
                    <span class=\"ib-event-minidot\" style=\"background:${color};\"></span>
                    <span class=\"ib-event-minititle\">${event.title}</span>
                    <span class=\"ib-event-minimeta\">${event.start.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })} · ${event.extendedProps.client}</span>
                </div>
            `;
            eventEl.setAttribute('tabindex', '0');
            eventEl.setAttribute('aria-label', `${event.title} avec ${event.extendedProps.employee} pour ${event.extendedProps.client}`);
        },
        eventClick: function(info) {
            showEventModal(info.event);
        },
        select: function(selectionInfo) {}
    });
    calendar.render();
    // Modale moderne (infos détaillées)
    function showEventModal(event) {
        var modal = document.getElementById('ib-calendar-modal');
        var modalContent = document.getElementById('ib-calendar-modal-content');
        const color = event.extendedProps.employee_color || event.color || '#4f8cff';
        const textColor = getContrastYIQ(color);
        modalContent.innerHTML = `
            <div class=\"ib-modal-header\">
                <h2 style=\"font-weight:700;color:${color};\">${event.title}</h2>
                <div class=\"ib-event-meta\" style=\"font-size:1em;color:#888;\">
                    <span class=\"ib-event-time\">${event.start.toLocaleString('fr-FR', { hour: '2-digit', minute: '2-digit' })}</span>
                    <span class=\"ib-event-employee\">${getEmployeeBadge(event.extendedProps.employee, color)} ${event.extendedProps.employee}</span>
                </div>
            </div>
            <div class=\"ib-modal-body\">
                <div class=\"ib-event-modern\" style=\"background:${color};color:${textColor};padding:1.2em 1.5em;\">
                    <div><strong>Client :</strong> ${event.extendedProps.client}</div>
                    <div><strong>Service :</strong> ${event.extendedProps.service}</div>
                    <div><strong>Date :</strong> ${event.extendedProps.date}</div>
                    <div><strong>Heure :</strong> ${event.extendedProps.time}</div>
                    ${event.extendedProps.notes ? `<div><strong>Notes :</strong> ${event.extendedProps.notes}</div>` : ''}
                </div>
            </div>
        `;
        modal.style.display = 'flex';
    }
    document.getElementById('ib-calendar-modal-close').addEventListener('click', function() {
        document.getElementById('ib-calendar-modal').style.display = 'none';
    });
    document.getElementById('ib-calendar-export').addEventListener('click', function() {
        exportToCSV();
    });
    function exportToCSV() {
        var data = allEvents.map(event => [
            event.title,
            event.extendedProps.employee,
            event.extendedProps.client,
            event.start,
            event.end,
            event.extendedProps.service,
            event.extendedProps.notes
        ]);
        var csvContent = "data:text/csv;charset=utf-8,";
        var headers = ["Service", "Employé", "Client", "Début", "Fin", "Service", "Notes"];
        csvContent += headers.join(",") + "\n";
        data.forEach(function(rowArray) {
            var row = rowArray.join(",");
            csvContent += row + "\n";
        });
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "planning.csv");
        document.body.appendChild(link);
        link.click();
    }
    // Barre employés : filtrage
    document.querySelectorAll('.ib-employee-chip').forEach(function(chip){
        chip.addEventListener('click', function(){
            document.querySelectorAll('.ib-employee-chip').forEach(c=>c.classList.remove('active'));
            chip.classList.add('active');
            var empId = chip.getAttribute('data-employee');
            var filteredEvents = allEvents.filter(function(ev){
                return !empId || ev.extendedProps.employee_id == empId;
            });
            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        });
    });
});
</script>
