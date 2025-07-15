// Définition globale des noms de jours en français
const dayNamesFr = [
  "Dimanche",
  "Lundi",
  "Mardi",
  "Mercredi",
  "Jeudi",
  "Vendredi",
  "Samedi",
];
const dayNamesShortFr = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];

class BeautyCalendar {
  constructor() {
    this.currentDate = new Date(); // Date du jour par défaut
    this.currentView = "week";
    this.events = [];

    this.filteredEvents = [...this.events];
    this.init();
  }

  bindEvents() {
    const addBtn = document.getElementById("addBtn");
    if (addBtn) addBtn.addEventListener("click", () => this.openModal());

    const closeModal = document.getElementById("closeModal");
    if (closeModal)
      closeModal.addEventListener("click", () => this.closeModal());

    const cancelBtn = document.getElementById("cancelBtn");
    if (cancelBtn) cancelBtn.addEventListener("click", () => this.closeModal());

    const eventForm = document.getElementById("eventForm");
    if (eventForm)
      eventForm.addEventListener("submit", (e) => this.handleFormSubmit(e));

    const searchInput = document.getElementById("searchInput");
    if (searchInput)
      searchInput.addEventListener("input", (e) =>
        this.handleSearch(e.target.value)
      );

    document.querySelectorAll(".view-btn").forEach((btn) => {
      btn.addEventListener("click", (e) =>
        this.changeView(e.target.dataset.view)
      );
    });
    document
      .getElementById("prevBtn")
      ?.addEventListener("click", () => this.navigateDate(-1));
    document
      .getElementById("nextBtn")
      ?.addEventListener("click", () => this.navigateDate(1));
    document
      .getElementById("todayBtn")
      ?.addEventListener("click", () => this.goToToday());
  }

  async init() {
    this.bindEvents();
    this.updateDateTitle();
    this.renderCurrentView();
    this.updateCurrentTimeLine();
    setInterval(() => this.updateCurrentTimeLine(), 60000);
    this.events = [];
    await this.fetchEvents();
  }

  async fetchEvents() {
    try {
      const response = await fetch(
        "/wp-json/institut-booking/v1/calendar-events"
      );
      if (!response.ok) throw new Error("Erreur API");
      const apiEvents = await response.json();
      // Mapping sécurisé : calcul endTime avec duration, fallback 60min, log les événements
      this.events = apiEvents
        .filter((ev) => {
          if (!ev.start) return false;
          const d = new Date(ev.start.replace(" ", "T"));
          if (isNaN(d.getTime())) {
            console.warn("Événement ignoré (date invalide):", ev);
            return false;
          }
          return true;
        })
        .map((ev) => {
          const startDate = new Date(ev.start.replace(" ", "T"));
          const duration = parseInt(ev.duration) || 60;
          const endDate = new Date(startDate.getTime() + duration * 60000);
          return {
            id: ev.id,
            title: ev.title || ev.service_name || "Réservation",
            employee: ev.employee_name || ev.employee || "",
            client: ev.client_name || ev.client || "",
            service: ev.service_name || "",
            color:
              ev.color ||
              ev.employee_color ||
              getEmployeeColor(ev.employee_name || ev.employee || ""),
            start: startDate,
            end: endDate,
            startTime: startDate.toTimeString().slice(0, 5),
            endTime: endDate.toTimeString().slice(0, 5),
            date: startDate.toISOString().slice(0, 10),
            raw: ev,
          };
        });
      console.log("Événements chargés pour le calendrier :", this.events);
      this.renderCurrentView();
    } catch (e) {
      console.error("Erreur chargement événements", e);
      this.events = [];
      this.renderCurrentView();
    }
  }

  changeView(view) {
    this.currentView = view;
    document
      .querySelectorAll(".view-btn")
      .forEach((btn) => btn.classList.remove("active"));
    document.querySelector(`[data-view="${view}"]`).classList.add("active");
    document.getElementById("weekView").style.display = "none";
    document.getElementById("dayView").style.display = "none";
    document.getElementById("monthView").style.display = "none";
    document.getElementById(`${view}View`).style.display = "block";
    this.updateDateTitle();
    this.renderCurrentView();
    this.updateCurrentTimeLine();
  }

  navigateDate(direction) {
    const newDate = new Date(this.currentDate);
    switch (this.currentView) {
      case "day":
        newDate.setDate(newDate.getDate() + direction);
        break;
      case "week":
        newDate.setDate(newDate.getDate() + direction * 7);
        break;
      case "month":
        newDate.setMonth(newDate.getMonth() + direction);
        break;
    }
    this.currentDate = newDate;
    this.updateDateTitle();
    this.renderCurrentView();
    this.updateCurrentTimeLine();
  }

  goToToday() {
    this.currentDate = new Date();
    this.updateDateTitle();
    this.renderCurrentView();
    this.updateCurrentTimeLine();
  }

  updateDateTitle() {
    let title = "";
    switch (this.currentView) {
      case "day":
        const dayOptions = {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        };
        title = this.currentDate.toLocaleDateString("fr-FR", dayOptions);
        title = title.charAt(0).toUpperCase() + title.slice(1);
        break;
      case "week":
        const monthOptions = { month: "long", year: "numeric" };
        title = this.currentDate.toLocaleDateString("fr-FR", monthOptions);
        title = title.charAt(0).toUpperCase() + title.slice(1);
        break;
      case "month":
        const monthYearOptions = { month: "long", year: "numeric" };
        title = this.currentDate.toLocaleDateString("fr-FR", monthYearOptions);
        title = title.charAt(0).toUpperCase() + title.slice(1);
        break;
    }
    const dateTitleEl = document.getElementById("dateTitle");
    if (dateTitleEl) dateTitleEl.textContent = title;
  }

  renderCurrentView() {
    switch (this.currentView) {
      case "day":
        this.renderDayView();
        break;
      case "week":
        this.renderWeekView();
        break;
      case "month":
        this.renderMonthView();
        break;
    }
  }

  renderWeekView() {
    const dayHeaders = document.getElementById("dayHeaders");
    const daysGrid = document.getElementById("daysGrid");
    if (!dayHeaders || !daysGrid) return;
    dayHeaders.innerHTML = "";
    daysGrid.innerHTML = "";
    daysGrid.style.minHeight = "900px";
    daysGrid.style.position = "relative";

    // Générer les jours de la semaine (Dim -> Sam)
    const weekDays = this.getWeekDays();
    // Header : 1ère colonne vide (pour les heures), puis jours
    const emptyHeader = document.createElement("div");
    emptyHeader.className = "day-header";
    dayHeaders.appendChild(emptyHeader);
    weekDays.forEach((day, i) => {
      const dayHeader = document.createElement("div");
      dayHeader.className = "day-header";
      dayHeader.innerHTML = `<div style='font-size:1.1em;font-weight:600;'>${
        dayNamesShortFr[day.getDay()]
      }</div><div style='font-size:1.2em;'>${day.getDate()}</div>`;
      if (this.isToday(day)) dayHeader.style.background = "#e5f0ff";
      dayHeaders.appendChild(dayHeader);
    });

    // All-day events (affichés en haut)
    const allDayRow = document.createElement("div");
    allDayRow.className = "all-day-row";
    // 1ère colonne label
    const allDayLabel = document.createElement("div");
    allDayLabel.className = "all-day-label";
    allDayLabel.textContent = "all-day";
    allDayRow.appendChild(allDayLabel);
    weekDays.forEach((day, i) => {
      const allDayCell = document.createElement("div");
      allDayCell.className = "all-day-cell";
      // Events all-day pour ce jour
      const allDayEvents = this.events.filter(
        (ev) =>
          ev.date === day.toISOString().slice(0, 10) &&
          ev.startTime === "00:00" &&
          ev.endTime === "23:59"
      );
      allDayEvents.forEach((ev) => {
        const evBlock = document.createElement("div");
        evBlock.className = "event-block";
        evBlock.style.position = "relative";
        evBlock.style.top = "2px";
        evBlock.style.height = "28px";
        evBlock.style.background = "#fff";
        evBlock.style.borderLeftColor = ev.color || "#007aff";
        evBlock.innerHTML = `<div class=\"event-title\">${ev.title}</div><div class=\"event-client\">${ev.client}</div>`;
        evBlock.onclick = () => openCalendarModal("Détail réservation", [ev]);
        allDayCell.appendChild(evBlock);
      });
      allDayRow.appendChild(allDayCell);
    });
    daysGrid.appendChild(allDayRow);

    // Grille horaire : colonnes = 1 (heures) + 7 (jours), lignes = heures (9h-17h, demi-heures pointillées)
    const hours = [];
    for (let h = 9; h <= 17; h++) {
      hours.push(h.toString().padStart(2, "0") + ":00");
    }
    for (let i = 0; i < hours.length; i++) {
      // Colonne heure
      const hourCell = document.createElement("div");
      hourCell.className = "hour-cell";
      hourCell.textContent = hours[i];
      hourCell.style.borderRight = "1px solid #e5e5ea";
      daysGrid.appendChild(hourCell);
      // Colonnes jours
      for (let d = 0; d < 7; d++) {
        const dayCol = document.createElement("div");
        dayCol.className = "day-col";
        dayCol.style.position = "relative";
        dayCol.style.borderBottom = "1px solid #e5e5ea";
        dayCol.style.minHeight = "48px";
        // Demi-heure pointillée
        const halfHour = document.createElement("div");
        halfHour.className = "half-hour";
        dayCol.appendChild(halfHour);
        dayCol.dataset.day = weekDays[d].toISOString().slice(0, 10);
        daysGrid.appendChild(dayCol);
      }
    }
    // Positionner les events (hors all-day) dans la bonne colonne/jour
    this.events.forEach((ev) => {
      if (ev.startTime === "00:00" && ev.endTime === "23:59") return; // déjà affiché en all-day
      const evDate = ev.date;
      const dayIdx = weekDays.findIndex(
        (d) => d.toISOString().slice(0, 10) === evDate
      );
      if (dayIdx === -1) return;
      // Calculer la position top/height selon l'heure
      const startHour = parseInt(ev.startTime.split(":")[0]);
      const startMin = parseInt(ev.startTime.split(":")[1]);
      const endHour = parseInt(ev.endTime.split(":")[0]);
      const endMin = parseInt(ev.endTime.split(":")[1]);
      // Correction du calcul top/height (base = 9h)
      const hourHeight = 48; // px, doit matcher le CSS
      const gridStart =
        (startHour - 9) * hourHeight + (startMin / 60) * hourHeight + 32; // +32 pour all-day
      const gridEnd =
        (endHour - 9) * hourHeight + (endMin / 60) * hourHeight + 32;
      const top = gridStart;
      const height = Math.max(gridEnd - gridStart, 24); // min 24px
      // Sélecteur colonne : (i * 8) + 1 + dayIdx + 8 (pour all-day)
      const colIdx = (startHour - 7) * 8 + 1 + dayIdx + 8; // +8 pour la ligne all-day
      const dayCol = daysGrid.children[colIdx];
      if (!dayCol) return;
      // Empilement si overlap (simple)
      let overlapCount = 0;
      for (let c = 0; c < dayCol.children.length; c++) {
        const child = dayCol.children[c];
        if (child.className === "event-block") overlapCount++;
      }
      // Créer le bloc event
      const eventBlock = document.createElement("div");
      eventBlock.className = "event-block";
      eventBlock.style.top = top + "px";
      eventBlock.style.height = height + "px";
      eventBlock.style.background = "#f7faff";
      eventBlock.style.borderLeftColor = ev.color || "#007aff";
      eventBlock.style.left = overlapCount * 8 + "px";
      eventBlock.style.width = `calc(100% - ${overlapCount * 8 + 8}px)`;
      eventBlock.innerHTML = `<div class=\"event-title\">${ev.title}</div><div class=\"event-client\">${ev.client}</div><div class=\"event-time\">${ev.startTime} - ${ev.endTime}</div>`;
      eventBlock.setAttribute("data-color", ev.color || "#007aff");
      eventBlock.style.position = "absolute";
      eventBlock.onclick = () => openCalendarModal("Détail réservation", [ev]);
      dayCol.appendChild(eventBlock);
    });
    // Ligne rouge "now"
    const now = new Date();
    if (weekDays.some((d) => d.toDateString() === now.toDateString())) {
      const nowHour = now.getHours();
      const nowMin = now.getMinutes();
      if (nowHour >= 7 && nowHour <= 21) {
        const nowLine = document.createElement("div");
        nowLine.className = "now-line";
        nowLine.style.top = (nowHour - 7) * 48 + (nowMin / 60) * 48 + 32 + "px";
        daysGrid.appendChild(nowLine);
      }
    }
  }

  renderDayView() {
    const dayEventsColumn = document.getElementById("dayEventsColumn");
    if (!dayEventsColumn) return;
    dayEventsColumn.innerHTML = "";
    dayEventsColumn.style.minHeight = "900px";
    dayEventsColumn.style.position = "relative";

    // Header sticky (date)
    const date = this.currentDate;
    const dayName = dayNamesFr[date.getDay()];
    const header = document.createElement("div");
    header.className = "day-header";
    header.style.position = "sticky";
    header.style.top = "0";
    header.style.background = "#fff";
    header.style.zIndex = "10";
    header.innerHTML = `<div style='font-size:1.5em;font-weight:700;'>${date.toLocaleDateString(
      "en-US",
      { month: "long", day: "numeric", year: "numeric" }
    )}</div><div style='font-size:1.1em;color:#6e6e73;'>${dayName}</div>`;
    dayEventsColumn.appendChild(header);

    // All-day events
    const allDayRow = document.createElement("div");
    allDayRow.className = "all-day-row";
    const allDayLabel = document.createElement("div");
    allDayLabel.className = "all-day-label";
    allDayLabel.textContent = "all-day";
    allDayRow.appendChild(allDayLabel);
    const allDayCell = document.createElement("div");
    allDayCell.className = "all-day-cell";
    allDayCell.style.width = "100%";
    const allDayEvents = this.events.filter(
      (ev) =>
        ev.date === date.toISOString().slice(0, 10) &&
        ev.startTime === "00:00" &&
        ev.endTime === "23:59"
    );
    allDayEvents.forEach((ev) => {
      const evBlock = document.createElement("div");
      evBlock.className = "event-block";
      evBlock.style.position = "relative";
      evBlock.style.top = "2px";
      evBlock.style.height = "28px";
      evBlock.style.background = "#fff";
      evBlock.style.borderLeftColor = ev.color || "#007aff";
      evBlock.innerHTML = `<div class=\"event-title\">${ev.title}</div><div class=\"event-client\">${ev.client}</div>`;
      evBlock.onclick = () => openCalendarModal("Détail réservation", [ev]);
      allDayCell.appendChild(evBlock);
    });
    allDayRow.appendChild(allDayCell);
    dayEventsColumn.appendChild(allDayRow);

    // Grille horaire (9h-17h, demi-heures pointillées)
    const hours = [];
    for (let h = 9; h <= 17; h++) {
      hours.push(h.toString().padStart(2, "0") + ":00");
    }
    for (let i = 0; i < hours.length; i++) {
      // Heure
      const hourCell = document.createElement("div");
      hourCell.className = "hour-cell";
      hourCell.textContent = hours[i];
      hourCell.style.borderRight = "1px solid #e5e5ea";
      hourCell.style.width = "60px";
      hourCell.style.display = "inline-block";
      hourCell.style.verticalAlign = "top";
      hourCell.style.height = "48px";
      dayEventsColumn.appendChild(hourCell);
      // Colonne events
      const dayCol = document.createElement("div");
      dayCol.className = "day-col";
      dayCol.style.position = "relative";
      dayCol.style.display = "inline-block";
      dayCol.style.width = "calc(100% - 60px)";
      dayCol.style.height = "48px";
      dayCol.style.borderBottom = "1px solid #e5e5ea";
      // Demi-heure pointillée
      const halfHour = document.createElement("div");
      halfHour.className = "half-hour";
      dayCol.appendChild(halfHour);
      dayEventsColumn.appendChild(dayCol);
    }
    // Positionner les events (hors all-day)
    this.events.forEach((ev) => {
      if (ev.date !== date.toISOString().slice(0, 10)) return;
      if (ev.startTime === "00:00" && ev.endTime === "23:59") return;
      // Calculer la position top/height selon l'heure
      const startHour = parseInt(ev.startTime.split(":")[0]);
      const startMin = parseInt(ev.startTime.split(":")[1]);
      const endHour = parseInt(ev.endTime.split(":")[0]);
      const endMin = parseInt(ev.endTime.split(":")[1]);
      // Correction du calcul top/height (base = 9h)
      const hourHeight = 48;
      const gridStart =
        (startHour - 9) * hourHeight + (startMin / 60) * hourHeight + 32;
      const gridEnd =
        (endHour - 9) * hourHeight + (endMin / 60) * hourHeight + 32;
      const top = gridStart;
      const height = Math.max(gridEnd - gridStart, 24);
      // Empilement si overlap (simple)
      let overlapCount = 0;
      for (let c = 0; c < dayEventsColumn.children.length; c++) {
        const child = dayEventsColumn.children[c];
        if (child.className === "event-block") overlapCount++;
      }
      // Créer le bloc event
      const eventBlock = document.createElement("div");
      eventBlock.className = "event-block";
      eventBlock.style.top = top + "px";
      eventBlock.style.height = height + "px";
      eventBlock.style.background = "#f7faff";
      eventBlock.style.borderLeftColor = ev.color || "#007aff";
      eventBlock.style.left = overlapCount * 8 + 60 + "px";
      eventBlock.style.width = `calc(100% - ${overlapCount * 8 + 68}px)`;
      eventBlock.innerHTML = `<div class=\"event-title\">${ev.title}</div><div class=\"event-client\">${ev.client}</div><div class=\"event-time\">${ev.startTime} - ${ev.endTime}</div>`;
      eventBlock.setAttribute("data-color", ev.color || "#007aff");
      eventBlock.style.position = "absolute";
      eventBlock.onclick = () => openCalendarModal("Détail réservation", [ev]);
      dayEventsColumn.appendChild(eventBlock);
    });
    // Ligne rouge "now"
    const now = new Date();
    if (date.toDateString() === now.toDateString()) {
      const nowHour = now.getHours();
      const nowMin = now.getMinutes();
      if (nowHour >= 7 && nowHour <= 21) {
        const nowLine = document.createElement("div");
        nowLine.className = "now-line";
        nowLine.style.top = (nowHour - 7) * 48 + (nowMin / 60) * 48 + 32 + "px";
        dayEventsColumn.appendChild(nowLine);
      }
    }
  }

  renderMonthView() {
    const monthGrid = document.getElementById("monthGrid");
    if (!monthGrid) return;
    monthGrid.innerHTML = "";
    monthGrid.style.display = "grid";
    monthGrid.style.gridTemplateColumns = "repeat(7, 1fr)";
    monthGrid.style.background = "#fff";
    monthGrid.style.borderRadius = "0 0 16px 16px";
    monthGrid.style.overflow = "hidden";
    monthGrid.style.minHeight = "600px";
    // Sticky header (mois/année)
    const date = this.currentDate;
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    const startDay = firstDay.getDay();
    const daysInMonth = lastDay.getDate();
    // Jours de la semaine
    const dayNames = dayNamesShortFr;
    const headerRow = document.createElement("div");
    headerRow.style.display = "contents";
    for (let i = 0; i < 7; i++) {
      const dayHeader = document.createElement("div");
      dayHeader.className = "day-header";
      dayHeader.textContent = dayNames[i];
      headerRow.appendChild(dayHeader);
    }
    monthGrid.appendChild(headerRow);
    // Cases du mois
    let dayNum = 1;
    const totalCells = Math.ceil((startDay + daysInMonth) / 7) * 7;
    for (let i = 0; i < totalCells; i++) {
      const dayCell = document.createElement("div");
      dayCell.className = "day-col";
      dayCell.style.minHeight = "90px";
      dayCell.style.borderBottom = "1px solid #e5e5ea";
      dayCell.style.borderRight = "1px solid #e5e5ea";
      dayCell.style.position = "relative";
      if (i % 7 === 6) dayCell.style.borderRight = "none";
      if (i >= startDay && dayNum <= daysInMonth) {
        dayCell.innerHTML = `<div style='font-weight:600;font-size:1.1em;color:#222;'>${dayNum}</div>`;
        const cellDate = new Date(date.getFullYear(), date.getMonth(), dayNum);
        // Events du jour
        const cellEvents = this.events.filter(
          (ev) => ev.date === cellDate.toISOString().slice(0, 10)
        );
        const maxToShow = 3;
        cellEvents.slice(0, maxToShow).forEach((ev) => {
          const evDot = document.createElement("div");
          evDot.className = "event-block";
          evDot.style.position = "relative";
          evDot.style.height = "22px";
          evDot.style.margin = "2px 0";
          evDot.style.background = "#f7faff";
          evDot.style.borderLeftColor = ev.color || "#007aff";
          evDot.innerHTML = `<span class=\"event-title\">${ev.title}</span>`;
          evDot.setAttribute("data-color", ev.color || "#007aff");
          evDot.onclick = () => openCalendarModal("Détail réservation", [ev]);
          dayCell.appendChild(evDot);
        });
        if (cellEvents.length > maxToShow) {
          const moreBtn = document.createElement("div");
          moreBtn.style.color = "#007aff";
          moreBtn.style.fontSize = "0.95em";
          moreBtn.style.cursor = "pointer";
          moreBtn.style.marginTop = "2px";
          moreBtn.textContent = `+${cellEvents.length - maxToShow} autres`;
          moreBtn.onclick = () =>
            openCalendarModal(
              `Événements du ${dayNum} ${dayNames[cellDate.getDay()]}`,
              cellEvents
            );
          dayCell.appendChild(moreBtn);
        }
        dayNum++;
      } else {
        dayCell.style.background = "#f7f7fa";
      }
      monthGrid.appendChild(dayCell);
    }
  }

  getWeekDays() {
    const startOfWeek = new Date(this.currentDate);
    const day = startOfWeek.getDay();
    const diff = startOfWeek.getDate() - day;
    startOfWeek.setDate(diff);
    const days = [];
    for (let i = 0; i < 7; i++) {
      const date = new Date(startOfWeek);
      date.setDate(startOfWeek.getDate() + i);
      days.push(date);
    }
    return days;
  }

  getMonthDays() {
    const year = this.currentDate.getFullYear();
    const month = this.currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(firstDay.getDate() - firstDay.getDay());
    const days = [];
    const current = new Date(startDate);
    for (let i = 0; i < 42; i++) {
      days.push(new Date(current));
      current.setDate(current.getDate() + 1);
    }
    return days;
  }

  getEventsForDate(date) {
    const dateStr = date.toISOString().split("T")[0];
    return this.filteredEvents.filter((event) => event.date === dateStr);
  }

  isToday(date) {
    const today = new Date();
    return date.toDateString() === today.toDateString();
  }

  createEventElement(event, detailed = false) {
    const eventEl = document.createElement("div");
    eventEl.className = `event ${event.color}`;
    const position = this.calculateEventPosition(event, detailed);
    eventEl.style.top = position.top;
    eventEl.style.height = position.height;
    eventEl.style.left = event.left || "4px";
    eventEl.style.width = event.width || "calc(100% - 8px)";
    if (detailed) {
      eventEl.innerHTML = `
        <div class="event-title"><span class="event-icon">${event.icon}</span>${
        event.title
      }</div>
        <div class="event-time">${event.startTime} - ${event.endTime}</div>
        <div class="event-client">${event.client || ""}</div>
        <div class="event-service">${event.service || ""}</div>
      `;
    } else {
      eventEl.innerHTML = `
        <div class="event-title"><span class="event-icon">${event.icon}</span>${
        event.title
      }</div>
        <div class="event-time">${event.startTime} - ${event.endTime}</div>
        ${event.client ? `<div class="event-client">${event.client}</div>` : ""}
      `;
    }
    return eventEl;
  }

  calculateEventPosition(event, detailedView = false) {
    const [startHour, startMinute] = event.startTime.split(":").map(Number);
    const [endHour, endMinute] = event.endTime.split(":").map(Number);
    const startMinutesFromNine = (startHour - 9) * 60 + startMinute;
    const endMinutesFromNine = (endHour - 9) * 60 + endMinute;
    const durationMinutes = endMinutesFromNine - startMinutesFromNine;
    const hourHeight = detailedView ? 100 : 80;
    const pixelsPerMinute = hourHeight / 60;
    return {
      top: `${startMinutesFromNine * pixelsPerMinute}px`,
      height: `${durationMinutes * pixelsPerMinute}px`,
    };
  }

  processOverlappingEvents(events, detailed = false) {
    events.sort((a, b) => {
      const timeA = parseInt(a.startTime.replace(":", ""));
      const timeB = parseInt(b.startTime.replace(":", ""));
      return timeA - timeB;
    });
    const processedEvents = [];
    const columns = [];
    events.forEach((event) => {
      const eventStart = parseInt(event.startTime.replace(":", ""));
      const eventEnd = parseInt(event.endTime.replace(":", ""));
      let placed = false;
      for (let i = 0; i < columns.length; i++) {
        let overlaps = false;
        for (const colEvent of columns[i]) {
          const colEventStart = parseInt(colEvent.startTime.replace(":", ""));
          const colEventEnd = parseInt(colEvent.endTime.replace(":", ""));
          if (!(eventEnd <= colEventStart || eventStart >= colEventEnd)) {
            overlaps = true;
            break;
          }
        }
        if (!overlaps) {
          columns[i].push(event);
          event.column = i;
          placed = true;
          break;
        }
      }
      if (!placed) {
        columns.push([event]);
        event.column = columns.length - 1;
      }
      processedEvents.push(event);
    });
    processedEvents.forEach((event) => {
      const totalColumns = columns.length;
      if (totalColumns > 1) {
        event.width = `calc(${100 / totalColumns}% - 8px)`;
        event.left = `calc(${event.column * (100 / totalColumns)}% + 4px)`;
      } else {
        event.width = "calc(100% - 8px)";
        event.left = "4px";
      }
    });
    return processedEvents;
  }

  updateCurrentTimeLine() {
    const currentTimeLine = document.getElementById("currentTimeLine");
    if (!currentTimeLine) return;
    const now = new Date();
    const today = new Date();
    if (
      this.currentDate.toDateString() !== today.toDateString() ||
      (this.currentView !== "day" && this.currentView !== "week")
    ) {
      currentTimeLine.style.display = "none";
      return;
    }
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();
    if (currentHour < 9 || currentHour >= 17) {
      currentTimeLine.style.display = "none";
      return;
    }
    this.updateCurrentTimeLinePosition(currentTimeLine);
  }

  updateCurrentTimeLinePosition(timeLineEl) {
    const now = new Date();
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();
    if (currentHour < 9 || currentHour >= 17) {
      timeLineEl.style.display = "none";
      return;
    }
    const hourHeight = this.currentView === "day" ? 100 : 80;
    const pixelsPerMinute = hourHeight / 60;
    const minutesFromNine = (currentHour - 9) * 60 + currentMinute;
    const position = minutesFromNine * pixelsPerMinute;
    timeLineEl.style.top = `${position}px`;
    timeLineEl.style.display = "flex";
  }

  openModal() {
    const modal = document.getElementById("addEventModal");
    const today = new Date().toISOString().split("T")[0];
    document.getElementById("eventDate").value = today;
    document.getElementById("startTime").value = "09:00";
    document.getElementById("endTime").value = "10:00";
    modal.classList.add("show");
  }

  closeModal() {
    const modal = document.getElementById("addEventModal");
    modal.classList.remove("show");
    document.getElementById("eventForm").reset();
  }

  handleFormSubmit(e) {
    e.preventDefault();
    const clientName = document.getElementById("clientName").value;
    const serviceName = document.getElementById("serviceName").value;
    const eventTitle = document.getElementById("eventTitle").value;
    const eventDate = document.getElementById("eventDate").value;
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;
    const serviceType = document.getElementById("serviceType").value;
    const eventColor = document.getElementById("eventColor").value;
    const serviceIcons = {
      facial: "🧴",
      manicure: "💅",
      massage: "💆",
      hair: "✂️",
      consultation: "💬",
      other: "✨",
    };
    const newEvent = {
      id: Date.now(),
      title: eventTitle || `${serviceName} - ${clientName}`,
      client: clientName,
      service: serviceName,
      date: eventDate,
      startTime: startTime,
      endTime: endTime,
      type: serviceType,
      color: eventColor,
      icon: serviceIcons[serviceType],
    };
    this.events.push(newEvent);
    this.filteredEvents = [...this.events];
    this.renderCurrentView();
    this.closeModal();
  }

  handleSearch(query) {
    if (!query.trim()) {
      this.filteredEvents = [...this.events];
    } else {
      this.filteredEvents = this.events.filter(
        (event) =>
          event.title.toLowerCase().includes(query.toLowerCase()) ||
          event.client.toLowerCase().includes(query.toLowerCase()) ||
          event.service.toLowerCase().includes(query.toLowerCase())
      );
    }
    this.renderCurrentView();
  }
}

// Ajout d'une modale globale pour afficher les événements masqués
if (!document.getElementById("beauty-calendar-modal")) {
  const modal = document.createElement("div");
  modal.id = "beauty-calendar-modal";
  modal.innerHTML = `<div class="modal-content"><button class="close-modal" onclick="document.getElementById('beauty-calendar-modal').style.display='none'">&times;</button><div class="modal-title"></div><div class="modal-events"></div></div>`;
  document.body.appendChild(modal);
}

// Palette pastel par employé (exemple, à adapter dynamiquement si besoin)
const employeeColors = [
  "#F8BBD0", // rose
  "#B2DFDB", // turquoise
  "#C5CAE9", // bleu
  "#FFE0B2", // orange
  "#D1C4E9", // violet
  "#B3E5FC", // bleu clair
  "#FFCCBC", // pêche
  "#DCEDC8", // vert
  "#FFD6E0", // rose pâle
  "#E1BEE7", // mauve
];
function getEmployeeColor(employee) {
  if (!employee) return "#B2DFDB";
  let hash = 0;
  for (let i = 0; i < employee.length; i++) hash += employee.charCodeAt(i);
  return employeeColors[hash % employeeColors.length];
}

// Helper pour ouvrir la modale détaillée d'un ou plusieurs events (triés chrono)
function openCalendarModal(title, events) {
  const modal = document.getElementById("beauty-calendar-modal");
  modal.querySelector(".modal-title").textContent = title;
  const eventsContainer = modal.querySelector(".modal-events");
  eventsContainer.innerHTML = "";
  // Trier chronologiquement
  events.sort((a, b) => (a.start > b.start ? 1 : -1));
  events.forEach((ev) => {
    const evBlock = document.createElement("div");
    evBlock.className = "event-block";
    evBlock.style.background = "#f7faff";
    evBlock.style.borderLeftColor = getEmployeeColor(ev.employee);
    evBlock.innerHTML = `<div class=\"event-title\">${
      ev.title
    }</div><div class=\"event-client\"><b>Employé :</b> <span style='color:${getEmployeeColor(
      ev.employee
    )}'>${ev.employee}</span></div><div class=\"event-time\"><b>Heure :</b> ${
      ev.startTime
    } - ${ev.endTime}</div><div class=\"event-client\"><b>Client :</b> ${
      ev.client
    }</div><div class=\"event-service\"><b>Service :</b> ${ev.service}</div>`;
    eventsContainer.appendChild(evBlock);
  });
  modal.style.display = "flex";
  // Fermer la modale au clic extérieur
  modal.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
  };
}

// Empilement côte à côte (overlap horizontal) pour la vue semaine/jour
function groupOverlappingEvents(events) {
  // Trie les events par heure de début
  events = [...events].sort((a, b) => (a.start > b.start ? 1 : -1));
  const groups = [];
  events.forEach((ev) => {
    let placed = false;
    for (const group of groups) {
      if (group.every((e) => e.end <= ev.start || e.start >= ev.end)) {
        group.push(ev);
        placed = true;
        break;
      }
    }
    if (!placed) groups.push([ev]);
  });
  return groups;
}

// --- Correction dans renderWeekView ---
// Remplacer la boucle d'affichage des events par :
// Supposons dayCol est la colonne du jour, weekDays[d] le jour courant
const dayEvents = this.events.filter(
  (ev) =>
    ev.date === weekDays[d].toISOString().slice(0, 10) &&
    !(ev.startTime === "00:00" && ev.endTime === "23:59")
);
const groups = groupOverlappingEvents(dayEvents);
groups.forEach((group) => {
  if (group.length <= 3) {
    const width = 100 / group.length;
    group.forEach((ev, idx) => {
      // Calcul top/height
      const startHour = parseInt(ev.startTime.split(":")[0]);
      const startMin = parseInt(ev.startTime.split(":")[1]);
      const endHour = parseInt(ev.endTime.split(":")[0]);
      const endMin = parseInt(ev.endTime.split(":")[1]);
      // Correction du calcul top/height (base = 9h)
      const hourHeight = 48;
      const gridStart =
        (startHour - 9) * hourHeight + (startMin / 60) * hourHeight + 32;
      const gridEnd =
        (endHour - 9) * hourHeight + (endMin / 60) * hourHeight + 32;
      const top = gridStart;
      const height = Math.max(gridEnd - gridStart, 24);
      const eventBlock = document.createElement("div");
      eventBlock.className = "event-block";
      eventBlock.style.top = top + "px";
      eventBlock.style.height = height + "px";
      eventBlock.style.left = `calc(${idx * width}% + 4px)`;
      eventBlock.style.width = `calc(${width}% - 8px)`;
      eventBlock.style.background = "#f7faff";
      eventBlock.style.borderLeftColor = getEmployeeColor(ev.employee);
      eventBlock.innerHTML = `<div class=\"event-title\">${
        ev.title
      }</div><div class=\"event-client\"><span style='color:${getEmployeeColor(
        ev.employee
      )}'>${ev.employee}</span></div>`;
      eventBlock.onclick = () => openCalendarModal("Détail réservation", [ev]);
      dayCol.appendChild(eventBlock);
    });
  } else {
    // Trop d'overlaps, afficher un bloc '+X'
    const pileBlock = document.createElement("div");
    pileBlock.className = "event-block";
    pileBlock.style.background = "#f7faff";
    pileBlock.style.borderLeftColor = getEmployeeColor(group[0].employee);
    pileBlock.innerHTML = `<div class=\"event-title\">+${
      group.length
    } réservations</div><div class=\"event-client\">${group
      .map((e) => e.employee)
      .join(", ")}</div>`;
    pileBlock.onclick = () =>
      openCalendarModal("Réservations en conflit", group);
    dayCol.appendChild(pileBlock);
  }
});
// --- Même logique à appliquer dans renderDayView ---
// (Utiliser groupOverlappingEvents sur les events du jour, même affichage côte à côte)

document.addEventListener("DOMContentLoaded", () => {
  const calendar = new BeautyCalendar();
  document.querySelectorAll(".view-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      const view = this.dataset.view;
      calendar.changeView(view);
    });
  });
});
