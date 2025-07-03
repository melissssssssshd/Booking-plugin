<?php
require_once plugin_dir_path(__FILE__) . '/../includes/class-services.php';
require_once plugin_dir_path(__FILE__) . '/../includes/class-employees.php';
require_once plugin_dir_path(__FILE__) . '/../includes/class-service-employees.php';
$services = IB_Services::get_all();
$employees = IB_Employees::get_all();
// Ajout du champ employee_ids à chaque service
foreach ($services as &$service) {
    $service->employee_ids = IB_Service_Employees::get_employees_for_service($service->id);
}
unset($service);
// Exemple de créneaux (à remplacer par ta logique réelle)
function get_available_slots($employee_id, $service_id, $date) {
    // Ici tu branches ta vraie logique de disponibilité !
    $slots = [
        '09:00','10:00','11:00','14:00','15:00','16:00'
    ];
    // Ex: return [] si indisponible
    return $slots;
}
?>
<script>var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";</script>
<style>
* {
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
  margin: 0;
  padding: 0;
}
body {
  background: #fbeff3;
  color: #4b3f3f;
}
.container {
  display: flex;
  min-height: 100vh;
  max-width: 1200px;
  margin: auto;
  padding: 2rem;
}
.sidebar {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(233,174,188,0.08);
  padding: 1.5rem;
  width: 230px;
  margin-right: 2rem;
}
.sidebar ul {
  list-style: none;
}
.sidebar li {
  margin: 1rem 0;
  padding: 0.75rem 1rem;
  border-radius: 10px;
  display: flex;
  align-items: center;
  font-weight: 500;
  cursor: pointer;
  color: #5e4d4d;
  transition: background 0.2s;
}
.sidebar li.active, .sidebar li:hover {
  background: #fdeae6;
  color: #e9aebc;
}
.sidebar .icon {
  margin-right: 0.8rem;
}
.content {
  flex: 1;
}
.categories h2,
.services h2 {
  margin-bottom: 1rem;
}
.buttons {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 2rem;
}
.buttons button {
  padding: 0.4rem 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background: #fff;
  cursor: pointer;
  font-weight: 500;
}
.buttons .active {
  background: #e9aebc;
  color: white;
  border: none;
}
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
  gap: 1.5rem;
  max-height: 400px;
  overflow-y: auto;
  padding-right: 8px;
}
.card {
  display: flex;
  gap: 1rem;
  background: #fff;
  padding: 1rem;
  border-radius: 12px;
  border: 2px solid transparent;
  transition: 0.2s ease;
  align-items: center;
}
.card:hover {
  border-color: #e9aebc;
}
.card.selected {
  border-color: #e9aebc;
}
.card img, .card .avatar-placeholder {
  width: 64px;
  height: 64px;
  border-radius: 100%;
  object-fit: cover;
  display: block;
  background: #f1f1f1;
  font-size: 2.1rem;
  color: #bfa2c7;
  text-align: center;
  line-height: 64px;
}
.card h3 {
  font-size: 1.1rem;
  margin-bottom: 0.25rem;
}
.card p {
  font-size: 0.95rem;
}
.card .price {
  background: #e9aebc;
  color: white;
  padding: 0.2rem 0.6rem;
  border-radius: 6px;
  font-weight: 600;
  display: inline-block;
  margin-top: 0.25rem;
}
.actions {
  display: flex;
  justify-content: space-between;
  margin-top: 2rem;
}
.actions .back,
.actions .next {
  padding: 0.8rem 1.5rem;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  font-size: 1rem;
}
.actions .back {
  background: #f1f1f1;
}
.actions .next {
  background: #e9aebc;
  color: white;
}
.booking-chip.active, .booking-chip:focus {
  background: #e9aebc;
  color: #fff;
}
.calendly-day {
  border: none;
  border-radius: 8px;
  padding: 0.7em 0;
  font-size: 1.1em;
  cursor: pointer;
  transition: background 0.2s, color 0.2s, border 0.2s;
  margin-bottom: 0.1em;
}
.calendly-day:disabled {
  cursor: not-allowed;
}
.calendly-day.selected {
  background: #e9aebc !important;
  color: #fff !important;
  border: 2px solid #e9aebc !important;
}
.slot-btn[disabled] {
  background: #e9aebc !important;
  color: #fff !important;
  border: 2px solid #e9aebc !important;
  opacity: 0.7;
}
</style>
<style>
/* Modern agenda simple & aligned */
#calendar-header, #calendar-days {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(233,174,188,0.10);
  padding: 1.2em 1.5em 1.5em 1.5em;
  margin-bottom: 1.2em;
}
#calendar-header {
  box-shadow: none;
  padding: 0.7em 1.5em 0.2em 1.5em;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 2em;
  font-size: 1.25em;
  font-weight: 700;
  color: #bfa2c7;
}
#calendar-header button {
  background: #fbeff3;
  border: none;
  border-radius: 50%;
  width: 2.3em;
  height: 2.3em;
  font-size: 1.2em;
  color: #e9aebc;
  cursor: pointer;
  transition: background 0.2s, color 0.2s, transform 0.18s;
  box-shadow: 0 1px 4px rgba(233,174,188,0.08);
  display: flex;
  align-items: center;
  justify-content: center;
}
#calendar-header button:hover {
  background: #e9aebc;
  color: #fff;
  transform: scale(1.10);
}
#calendar-days {
  box-shadow: none;
  padding: 0 1.5em 1.5em 1.5em;
}
#calendar-days .calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 2.7em);
  gap: 0.35em;
  justify-content: center;
  margin-bottom: 0.2em;
}
#calendar-days .calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 2.7em);
  gap: 0.35em;
  justify-content: center;
  margin-bottom: 0.5em;
}
#calendar-days .calendar-weekdays div {
  text-align: center;
  font-size: 1em;
  color: #bfa2c7;
  font-weight: 500;
  letter-spacing: 0.01em;
}
#calendar-days .calendly-day {
  background: #fff;
  border: none;
  border-radius: 50%;
  width: 2.7em;
  height: 2.7em;
  font-size: 1.08em;
  color: #bfa2c7;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.18s, color 0.18s, border 0.18s, transform 0.13s;
  box-shadow: 0 1px 4px rgba(233,174,188,0.07);
  cursor: pointer;
  outline: none;
  font-weight: 600;
}
#calendar-days .calendly-day.selected,
#calendar-days .calendly-day:active {
  background: #e9aebc !important;
  color: #fff !important;
  border: 2.5px solid #e9aebc !important;
  box-shadow: 0 4px 16px rgba(233,174,188,0.18);
  transform: scale(1.10);
  z-index: 2;
}
#calendar-days .calendly-day:hover:not(:disabled):not(.selected) {
  background: #fdeae6;
  color: #e9aebc;
  transform: scale(1.05);
}
#calendar-days .calendly-day:disabled {
  background: #f3f3f3 !important;
  color: #ccc !important;
  cursor: not-allowed;
  opacity: 1;
  border: none;
}
#calendar-days .calendly-day {
  border: 1.5px solid #f3f3f3;
}
#slots-list {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(233,174,188,0.10);
  padding: 1.2em 1.5em 1.5em 1.5em;
  min-height: 120px;
}
.slot-btn {
  padding: 0.7em 1.2em;
  border-radius: 18px;
  border: 1.5px solid #e9aebc;
  background: #fbeff3;
  color: #e9aebc;
  font-weight: 600;
  font-size: 1.05em;
  cursor: pointer;
  margin-bottom: 0.3em;
  margin-right: 0.3em;
  transition: background 0.18s, color 0.18s, border 0.18s, transform 0.13s;
  box-shadow: 0 1px 4px rgba(233,174,188,0.07);
}
.slot-btn:hover:not([disabled]) {
  background: #e9aebc;
  color: #fff;
  border: 1.5px solid #e9aebc;
  transform: scale(1.07);
}
.slot-btn[disabled] {
  background: #e9aebc !important;
  color: #fff !important;
  border: 2px solid #e9aebc !important;
  opacity: 0.7;
  transform: scale(1.01);
}
@media (max-width: 900px) {
  #calendar-header, #calendar-days, #slots-list {
    padding: 1em 0.5em 1em 0.5em;
  }
  #calendar-days .calendar-grid, #calendar-days .calendar-weekdays {
    grid-template-columns: repeat(7, 2.2em);
  }
}
@media (max-width: 700px) {
  .container > div, .container > aside, .container > main {
    flex-direction: column !important;
    min-width: 0 !important;
    max-width: 100% !important;
  }
  #calendar-header, #calendar-days, #slots-list {
    padding: 0.7em 0.2em 0.7em 0.2em;
    border-radius: 12px;
  }
  #calendar-days .calendar-grid, #calendar-days .calendar-weekdays {
    grid-template-columns: repeat(7, 1.7em);
  }
}
</style>
<div class="container">
  <aside class="sidebar">
    <ul id="sidebar-steps">
      <li data-step="1" class="active"><span class="icon">🧾</span> Service</li>
      <li data-step="2"><span class="icon">👤</span> Employé</li>
      <li data-step="3"><span class="icon">📅</span> Date & Heure</li>
      <li data-step="4"><span class="icon">📝</span> Infos</li>
      <li data-step="5"><span class="icon">✅</span> Ticket</li>
    </ul>
  </aside>
  <main class="content">
    <div id="booking-step-content"></div>
    <div class="actions" id="booking-actions"></div>
  </main>
</div>
<script>
window.bookingData = {
  services: <?php echo json_encode($services); ?>,
  employees: <?php echo json_encode($employees); ?>
};
let bookingState = {
  step: 1,
  selectedCategory: 'ALL',
  selectedService: null,
  selectedEmployee: null,
  selectedDate: null,
  selectedSlot: null,
  client: { firstname:'', lastname:'', email:'', phone:'' }
};
const categories = ['ALL', ...Array.from(new Set(window.bookingData.services.map(s=>s.category)))];

// Ajoute l'état du calendrier (mois/année affichés)
if (!window.calendarState) window.calendarState = { month: (new Date()).getMonth(), year: (new Date()).getFullYear() };

function renderSidebar() {
  document.querySelectorAll('#sidebar-steps li').forEach((li, idx) => {
    li.classList.toggle('active', idx === bookingState.step-1);
  });
}

function goToStep(step) {
  bookingState.step = step;
  renderSidebar();
  renderStepContent();
  renderActions();
}

function renderStepContent() {
  const content = document.getElementById('booking-step-content');
  if (bookingState.step === 1) {
    content.innerHTML = `
      <div class="categories">
        <h2>Catégorie</h2>
        <div class="buttons" id="category-buttons"></div>
      </div>
      <div class="services">
        <h2>Service</h2>
        <div class="grid" id="services-grid"></div>
      </div>
    `;
    renderCategoryButtons();
    renderServicesGrid();
  } else if (bookingState.step === 2) {
    content.innerHTML = `<h2>Choisissez votre employé</h2><div class="grid" id="employees-grid"></div>`;
    renderEmployeesGrid();
  } else if (bookingState.step === 3) {
    content.innerHTML = `
      <div style='display:flex;gap:2.5rem;flex-wrap:wrap;'>
        <div style='min-width:320px;max-width:350px;'>
          <h2 style='margin-bottom:1em;'>Date & Time</h2>
          <div id='calendar-header' style='display:flex;align-items:center;gap:1em;margin-bottom:0.5em;'></div>
          <div id='calendar-days'></div>
        </div>
        <div style='flex:1;min-width:260px;'>
          <h3 style='margin-bottom:1em;'>Time Slot</h3>
          <div id='slots-list'></div>
        </div>
      </div>
    `;
    renderModernCalendar();
    renderModernSlotsList();
  } else if (bookingState.step === 4) {
    content.innerHTML = `<h2>Vos informations</h2><form class='booking-form-fields' id='booking-client-form' style='max-width:400px;'><input class='booking-input' type='text' placeholder='Prénom' id='client-firstname' required value='${bookingState.client.firstname}' /><input class='booking-input' type='text' placeholder='Nom' id='client-lastname' required value='${bookingState.client.lastname}' /><input class='booking-input' type='email' placeholder='Email' id='client-email' required value='${bookingState.client.email}' /><input class='booking-input' type='tel' placeholder='Téléphone' id='client-phone' required value='${bookingState.client.phone}' /></form>`;
  } else if (bookingState.step === 5) {
    content.innerHTML = `<h2>Votre ticket de réservation</h2><div class='booking-summary'><b>Service :</b> ${bookingState.selectedService?.name || ''}<br><b>Employé :</b> ${bookingState.selectedEmployee?.name || ''}<br><b>Date :</b> ${bookingState.selectedDate || ''}<br><b>Heure :</b> ${bookingState.selectedSlot || ''}<br><b>Client :</b> ${bookingState.client.firstname} ${bookingState.client.lastname}<br><b>Email :</b> ${bookingState.client.email}<br><b>Téléphone :</b> ${bookingState.client.phone}<br><b>Prix :</b> ${bookingState.selectedService?.price ? bookingState.selectedService.price.toLocaleString() : ''} DA</div>`;
  }
}

function renderCategoryButtons() {
  const btns = document.getElementById('category-buttons');
  btns.innerHTML = '';
  const cats = ['ALL', ...Array.from(new Set(window.bookingData.services.map(s=>s.category_name).filter(Boolean)))];
  cats.forEach(cat => {
    const btn = document.createElement('button');
    btn.textContent = cat;
    btn.className = (cat === bookingState.selectedCategory ? 'active' : '');
    btn.onclick = () => { bookingState.selectedCategory = cat; renderServicesGrid(); renderCategoryButtons(); };
    btns.appendChild(btn);
  });
}

function renderServicesGrid() {
  const grid = document.getElementById('services-grid');
  grid.innerHTML = '';
  let filtered = bookingState.selectedCategory==='ALL' ? window.bookingData.services : window.bookingData.services.filter(s=>s.category_name===bookingState.selectedCategory);
  if(filtered.length===0) {
    grid.innerHTML = '<div style="padding:2em;text-align:center;color:#bfa2c7;">Aucun service disponible</div>';
    return;
  }
  filtered.forEach(srv => {
    const card = document.createElement('div');
    card.className = 'card' + (bookingState.selectedService && bookingState.selectedService.id===srv.id ? ' selected' : '');
    card.onclick = () => { bookingState.selectedService = srv; renderServicesGrid(); };
    let imgHtml = srv.image ? `<img src="${srv.image}" alt="${srv.name}">` : `<div class='avatar-placeholder'>🛠️</div>`;
    let priceText = '';
    if (srv.variable_price == 1) {
      if (srv.min_price && srv.min_price > 0) priceText = 'À partir de ' + Number(srv.min_price).toLocaleString() + ' DA';
      else priceText = 'Variable';
    } else if (typeof srv.price === 'number' && !isNaN(srv.price)) {
      priceText = srv.price.toLocaleString() + ' DA';
    } else if (typeof srv.price === 'string' && srv.price.trim() !== '') {
      priceText = srv.price;
    } else {
      priceText = 'Variable';
    }
    card.innerHTML = `
      ${imgHtml}
      <div>
        <h3>${srv.name}</h3>
        <p>Durée : <strong>${srv.duration} min</strong></p>
        <p class="price">${priceText}</p>
      </div>
    `;
    grid.appendChild(card);
  });
}

function renderEmployeesGrid() {
  const grid = document.getElementById('employees-grid');
  grid.innerHTML = '';
  if (!bookingState.selectedService) return;
  const employeeIds = (bookingState.selectedService.employee_ids || []).map(Number);
  const filtered = window.bookingData.employees.filter(e => employeeIds.includes(Number(e.id)));
  if(filtered.length===0) {
    grid.innerHTML = '<div style="padding:2em;text-align:center;color:#bfa2c7;">Aucun employé pour ce service</div>';
    return;
  }
  filtered.forEach(emp => {
    const card = document.createElement('div');
    card.className = 'card' + (bookingState.selectedEmployee && bookingState.selectedEmployee.id===emp.id ? ' selected' : '');
    card.onclick = () => { bookingState.selectedEmployee = emp; renderEmployeesGrid(); };
    let imgHtml = emp.image ? `<img src="${emp.image}" alt="${emp.name}">` : `<div class='avatar-placeholder'>👤</div>`;
    card.innerHTML = `
      ${imgHtml}
      <div>
        <h3>${emp.name}</h3>
        <p>${emp.specialty||''}</p>
      </div>
    `;
    grid.appendChild(card);
  });
}

function renderModernCalendar() {
  const cal = document.getElementById('calendar-days');
  const header = document.getElementById('calendar-header');
  const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  const weekDays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
  header.innerHTML = `
    <button id='prev-month'>&lt;</button>
    <span style='font-weight:600;font-size:1.1em;'>${monthNames[window.calendarState.month]} ${window.calendarState.year}</span>
    <button id='next-month'>&gt;</button>
  `;
  document.getElementById('prev-month').onclick = () => {
    window.calendarState.month--;
    if(window.calendarState.month<0) { window.calendarState.month=11; window.calendarState.year--; }
    renderModernCalendar();
    renderModernSlotsList();
  };
  document.getElementById('next-month').onclick = () => {
    window.calendarState.month++;
    if(window.calendarState.month>11) { window.calendarState.month=0; window.calendarState.year++; }
    renderModernCalendar();
    renderModernSlotsList();
  };
  const year = window.calendarState.year;
  const month = window.calendarState.month;
  const daysInMonth = new Date(year, month+1, 0).getDate();
  const firstDay = (new Date(year, month, 1).getDay()+6)%7;
  let html = `<div class='calendar-weekdays'>`;
  weekDays.forEach(d => html += `<div>${d}</div>`);
  html += '</div><div class="calendar-grid">';
  for(let i=0; i<firstDay; i++) html += '<div></div>';
  for(let d=1; d<=daysInMonth; d++) {
    const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
    const isPast = new Date(year, month, d) < new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    let btnClass = 'calendly-day';
    if (bookingState.selectedDate === dateStr) btnClass += ' selected';
    html += `<button class='${btnClass}' data-date='${dateStr}' ${isPast?'disabled':''}>${d}</button>`;
  }
  html += '</div>';
  cal.innerHTML = html;
  document.querySelectorAll('.calendly-day').forEach(btn => {
    if(btn.disabled) return;
    btn.onclick = () => {
      bookingState.selectedDate = btn.getAttribute('data-date');
      bookingState.selectedSlot = null;
      renderModernCalendar();
      renderModernSlotsList();
    };
  });
  // Applique le style sélectionné après le render
  document.querySelectorAll('.calendly-day').forEach(btn => {
    if(bookingState.selectedDate === btn.getAttribute('data-date')) {
      btn.classList.add('selected');
    } else {
      btn.classList.remove('selected');
    }
  });
}

function renderModernSlotsList() {
  const slotsList = document.getElementById('slots-list');
  slotsList.innerHTML = '<div style="padding:1em;color:#bfa2c7;text-align:center;">Select a date</div>';
  if(!bookingState.selectedDate || !bookingState.selectedEmployee || !bookingState.selectedService) return;
  slotsList.innerHTML = '<div style="padding:1em;color:#bfa2c7;text-align:center;">Loading...</div>';
  // Debug : log les paramètres envoyés
  console.log('[AJAX] Get slots', {
    employee_id: bookingState.selectedEmployee.id,
    service_id: bookingState.selectedService.id,
    date: bookingState.selectedDate
  });
  if(!bookingState.selectedEmployee.id || !bookingState.selectedService.id || !bookingState.selectedDate) {
    slotsList.innerHTML = '<div style="padding:1em;color:#ff6b6b;text-align:center;">Sélectionnez un service et un employé</div>';
    return;
  }
  fetch(ajaxurl, {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'ib_get_slots',
      employee_id: bookingState.selectedEmployee.id,
      service_id: bookingState.selectedService.id,
      date: bookingState.selectedDate
    })
  })
  .then(r => r.json())
  .then(res => {
    slotsList.innerHTML = '';
    if(!res.success || !res.data || res.data.length === 0) {
      slotsList.innerHTML = '<div style="padding:1em;color:#bfa2c7;text-align:center;">No slots available</div>';
      return;
    }
    // Regrouper matin/après-midi
    const morning = res.data.filter(t => parseInt(t.split(':')[0],10)<12);
    const afternoon = res.data.filter(t => parseInt(t.split(':')[0],10)>=12);
    let html = '';
    if(morning.length) {
      html += '<div style="margin-bottom:1em;"><b>Morning</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
      morning.forEach(slot => {
        html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #e9aebc;background:#fff;color:#e9aebc;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${bookingState.selectedSlot===slot?'disabled':''} onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
      });
      html += '</div></div>';
    }
    if(afternoon.length) {
      html += '<div style="margin-bottom:1em;"><b>Afternoon</b><div style="margin-top:0.5em;display:flex;flex-wrap:wrap;gap:0.5em;">';
      afternoon.forEach(slot => {
        html += `<button class='slot-btn' style='padding:0.7em 1.2em;border-radius:18px;border:1.5px solid #e9aebc;background:#fff;color:#e9aebc;font-weight:600;cursor:pointer;transition:transform 0.13s;' ${bookingState.selectedSlot===slot?'disabled':''} onclick='window.selectSlot("${slot}")'>${slot} <span style='font-size:0.9em;color:#bbb;font-weight:400;'>Disponible</span></button>`;
      });
      html += '</div></div>';
    }
    slotsList.innerHTML = html;
  })
  .catch(error => {
    slotsList.innerHTML = '<div style="padding:1em;color:#ff6b6b;text-align:center;">Error loading slots</div>';
  });
}

window.selectSlot = function(slot) {
  bookingState.selectedSlot = slot;
  renderModernSlotsList();
};

function renderActions() {
  const actions = document.getElementById('booking-actions');
  actions.innerHTML = '';
  if (bookingState.step > 1) {
    const back = document.createElement('button');
    back.className = 'back';
    back.textContent = '← Retour';
    back.onclick = () => goToStep(bookingState.step-1);
    actions.appendChild(back);
  }
  if (bookingState.step < 5) {
    const next = document.createElement('button');
    next.className = 'next';
    next.innerHTML = 'Suivant <strong>' + (['Employé','Date & Heure','Infos','Ticket'][bookingState.step-1]) + ' →</strong>';
    next.onclick = () => {
      if(bookingState.step===1 && !bookingState.selectedService) return alert('Sélectionnez un service.');
      if(bookingState.step===2 && !bookingState.selectedEmployee) return alert('Sélectionnez un employé.');
      if(bookingState.step===3 && (!bookingState.selectedDate || !bookingState.selectedSlot)) return alert('Sélectionnez une date et un créneau.');
      if(bookingState.step===4 && (!bookingState.client.firstname || !bookingState.client.lastname || !bookingState.client.email || !bookingState.client.phone)) return alert('Merci de remplir tous les champs.');
      goToStep(bookingState.step+1);
    };
    actions.appendChild(next);
  } else if (bookingState.step === 5) {
    const restart = document.createElement('button');
    restart.className = 'next';
    restart.textContent = 'Nouvelle réservation';
    restart.onclick = () => { bookingState = {step:1,selectedCategory:'ALL',selectedService:null,selectedEmployee:null,selectedDate:null,selectedSlot:null,client:{firstname:'',lastname:'',email:'',phone:''}}; goToStep(1); };
    actions.appendChild(restart);
  }
}

document.addEventListener('DOMContentLoaded', function() {
  console.log('Services:', window.bookingData.services);
  console.log('Employés:', window.bookingData.employees);
  document.querySelectorAll('#sidebar-steps li').forEach((li, idx) => {
    if(idx === 1) li.innerHTML = '<span class="icon">👤</span> Employé';
  });
  renderSidebar();
  renderStepContent();
  renderActions();
  document.querySelectorAll('#sidebar-steps li').forEach((li, idx) => {
    li.onclick = () => {
      if(idx+1 <= bookingState.step) goToStep(idx+1);
    };
  });
});
</script>
