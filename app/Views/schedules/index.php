<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Schedule - Kawanmasa Atelier</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            background: #f6f6fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }
        .main-layout {
            display: flex;
            gap: 2.5rem;
            align-items: flex-start;
        }
        .side-card {
            background: #232136;
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px 0 rgb(0 0 0 / 0.10);
            padding: 2rem 2rem 2rem 2rem;
            width: 320px;
            min-width: 260px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .side-card h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .side-card .session-title {
            font-size: 1rem;
            font-weight: 200;
            margin-bottom: 1.5rem;
        }
        .legend {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .legend-dot {
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }
        .legend-booked { background: #a78bfa; }
        .legend-available { background: #fff; border: 2px solid #a78bfa; }
        .side-card .side-btn {
            background: #a78bfa;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 0;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 2rem;
            transition: background 0.2s, transform 0.1s;
        }
        .side-card .side-btn:hover {
            background: #7c3aed;
            transform: scale(1.03);
        }
        .calendar-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px 0 rgb(0 0 0 / 0.10);
            padding: 2rem 2.5rem;
            min-width: 420px;
        }
        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .calendar-title {
            font-size: 2rem;
            font-weight: 700;
            color: #232136;
        }
        .calendar-selector {
            background: #a78bfa;
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .calendar-section {
            margin-bottom: 1.5rem;
        }
        .calendar-labels {
            font-size: 1.1rem;
            font-weight: 600;
            color: #232136;
            margin-bottom: 1rem;
        }
        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #a78bfa;
            font-size: 1rem;
            text-align: center;
        }
        #calendar {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.5rem;
        }
        .calendar-cell {
            padding: 1rem 0.5rem;
            text-align: center;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            background: #fff;
            color: #232136;
            transition: box-shadow 0.2s, background 0.2s, color 0.2s;
            position: relative;
        }
        .calendar-cell.booked {
            background: #a78bfa;
            color: #fff;
            font-weight: 700;
            border: 2px solid #a78bfa;
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
        .calendar-cell.booked:hover {
            background: #a78bfa;
            color: #fff;
        }
        .calendar-cell.selected {
            box-shadow: 0 0 0 3px #a78bfa;
            background: #ede9fe;
            color: #7c3aed;
            border: 2px solid #a78bfa;
            z-index: 1;
        }
        .calendar-cell.disabled {
            background: #f3f4f6 !important;
            color: #c7d2fe !important;
            cursor: not-allowed;
            opacity: 0.7;
            pointer-events: none;
        }
        .calendar-cell:hover:not(.disabled):not(.booked) {
            background: #ede9fe;
            color: #7c3aed;
        }
        #monthSelect, #yearSelect {
            background: transparent;
            border: none;
            border-bottom: 2px solid #a78bfa;
            border-radius: 0;
            padding: 0.5rem 0.25rem;
            font-size: 1.1rem;
            font-family: inherit;
            color: #7c3aed;
            font-weight: 600;
            outline: none;
            transition: border-color 0.2s;
            box-shadow: none;
            appearance: none;
        }
        #monthSelect:focus, #yearSelect:focus {
            border-bottom: 2px solid #7c3aed;
        }
        #bookButton {
            background: #a78bfa;
            color: #fff;
            padding: 1rem 0;
            border-radius: 0.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            border: none;
            margin-top: 1.5rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        #bookButton:disabled {
            background: #e5e7eb;
            color: #c7d2fe;
            cursor: not-allowed;
        }
        #bookButton.enabled:hover {
            background: #7c3aed;
            transform: scale(1.03);
        }
        /* Modal styles */
        #timeSlotModal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        #timeSlotModal.active {
            display: flex;
        }
        .modal-content {
            background: #232136;
            color: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgb(0 0 0 / 0.10);
            width: 100%;
            max-width: 24rem;
            position: relative;
        }
        .modal-content h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
        }
        #timeSlots {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        .slot-btn {
            background: #a78bfa;
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.1s;
        }
        .slot-btn.selected, .slot-btn:hover:not([disabled]) {
            background: #7c3aed;
            color: #fff;
            transform: scale(1.04);
        }
        .slot-btn[disabled] {
            background: #e5e7eb;
            color: #c7d2fe;
            cursor: not-allowed;
            opacity: 0.7;
        }
        #modalBookBtn {
            width: 48%;
            height: 2.5rem;
            font-size: 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s, transform 0.1s;
        }
        #modalBookBtn {
            background: #a78bfa;
            color: #fff;
        }
        #modalBookBtn:disabled {
            background: #e5e7eb;
            color: #c7d2fe;
            cursor: not-allowed;
        }
        #modalBookBtn:hover:not(:disabled) {
            background: #7c3aed;
            transform: scale(1.03);
        }
        #modalBookBtn:active:not(:disabled) {
            background: #7c3aed;
            transform: scale(0.97);
        }
        .close-modal-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #a78bfa;
            cursor: pointer;
            transition: color 0.2s;
            z-index: 2;
        }
        .close-modal-btn:hover {
            color: #7c3aed;
        }
        /* Custom alert */
        #customAlert {
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: #5ac97fff;
            color: #fff;
            border-radius: 0.5rem;
            padding: 1rem 2rem;
            font-weight: 600;
            box-shadow: 0 2px 8px 0 rgb(0 0 0 / 0.10);
            z-index: 100;
            text-align: center;
            display: none;
        }
        #customAlert.show {
            display: block;
        }
        .topbar {
            position: absolute;
            top: 2rem;
            left: 2rem;
            right: 2rem;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .home-btn {
            background: #a78bfa;
            color: #fff;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, transform 0.1s;
            margin-right: 1rem;
        }
        .home-btn:hover {
            background: #7c3aed;
            transform: scale(1.05);
        }
        .home-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
        .logout-btn {
            background: #a78bfa;
            color: #fff;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, transform 0.1s;
        }
        .logout-btn:hover {
            background: #7c3aed;
            transform: scale(1.05);
        }
        .logout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div id="customAlert"></div>
    <div class="topbar">
        <button class="home-btn" onclick="window.location.href='/schedules'">Kawanmasa | Atelier</button>
        <button class="logout-btn" title="Logout" onclick="window.location.href='/logout'">Logout</button>
    </div>
    <div class="main-layout">
        <!-- Side Card -->
        <div class="side-card">
            <h2>Kawanmasa Atelier</h2>
            <div class="session-title">Book a session with us by selecting the date and time from the calender on the right!</div>
            <div class="legend">
                <span><span class="legend-dot legend-booked"></span>Booked</span>
                <span><span class="legend-dot legend-available"></span>Available</span>
            </div>
            <button class="side-btn" onclick="window.location.href='/index.php/appointments'">My Appointments</button>
        </div>
        <!-- Calendar Card -->
        <div class="calendar-card">
            <div class="calendar-header">
                <div class="calendar-title">Schedule</div>
                <div class="calendar-selector">
                    <div class="flex gap-2 mb-4 items-center">
                        <select id="monthSelect" class="border rounded px-2 py-1 font-medium">
                        </select>
                        |
                        <select id="yearSelect" class="border rounded px-2 py-1 font-medium">
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="calendar-section">
                <div class="calendar-weekdays">
                    <span>Sun</span>
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                </div>
                <div id="calendar"></div>
                <button id="bookButton" disabled>Book</button>
            </div>
        </div>
        <!-- Modal for time slot selection -->
        <div id="timeSlotModal">
            <div class="modal-content time-slot-modal-card">
                <button id="closeModal" class="close-modal-btn" aria-label="Close">&times;</button>
                <h2>Select Time Slot</h2>
                <div id="timeSlots"></div>
                <button id="modalBookBtn" disabled class="confirm-btn">Book</button>
            </div>
        </div>
    </div>
    <script>
        const monthSelect = document.getElementById("monthSelect");
        const yearSelect = document.getElementById("yearSelect");

        // Fill months
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        monthNames.forEach((name, idx) => {
            const opt = document.createElement("option");
            opt.value = idx + 1;
            opt.textContent = name;
            monthSelect.appendChild(opt);
        });

        // Fill years (from current year to +2 years)
        const currentYear = new Date().getFullYear();
        for (let y = currentYear; y <= currentYear + 2; y++) {
            const opt = document.createElement("option");
            opt.value = y;
            opt.textContent = y;
            yearSelect.appendChild(opt);
        }

        const calendar = document.getElementById("calendar");
        const bookButton = document.getElementById("bookButton");
        const timeSlotModal = document.getElementById("timeSlotModal");
        const timeSlotsContainer = document.getElementById("timeSlots");
        const modalBookBtn = document.getElementById("modalBookBtn");
        const customAlert = document.getElementById("customAlert");

        // Set default selected
        monthSelect.value = (new Date().getMonth() + 1);
        yearSelect.value = currentYear;

        let year = parseInt(yearSelect.value);
        let month = parseInt(monthSelect.value);

        let selectedDate = null;
        let selectedCell = null;
        let selectedSlotBtn = null;
        let selectedSlot = null;

        function getBookingStatus() {
            axios.get(`/index.php/api/schedules/calendar-data?year=${year}&month=${month}`)
                .then(res => {
                    const schedules = res.data;
                    generateCalendar(schedules);
                })
                .catch(error => {
                    console.error('Error fetching schedules:', error);
                })
        }

        function generateCalendar(data) {
            calendar.innerHTML = "";
            selectedCell = null;
            selectedDate = null;
            bookButton.disabled = true;
            bookButton.classList.remove("enabled");
            
            const firstDay = new Date(year, month - 1, 1).getDay();
            const daysInMonth = new Date(year, month, 0).getDate();

            // Add empty cell
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement("div");
                emptyCell.className = "calendar-cell";
                emptyCell.style.visibility = "hidden";
                calendar.appendChild(emptyCell);
            }
            for (let day = 1; day <= daysInMonth; day++) {
                const paddedMonth = month.toString().padStart(2, "0");
                const paddedDay = day.toString().padStart(2, "0");
                const dateStr = `${year}-${paddedMonth}-${paddedDay}`;
                const slotInfo = data.find(d => d.date === dateStr);

                let cellClass = "calendar-cell";
                if (!slotInfo) {
                    cellClass += " disabled";
                } else if (slotInfo.total_slots == 0) {
                    cellClass += " booked";
                } else if (slotInfo.total_slots > 0) {
                    cellClass += "";
                }

                const cell = document.createElement("div");
                cell.className = cellClass;
                cell.textContent = day;

                if (slotInfo && slotInfo.total_slots > 0) {
                    cell.onclick = () => {
                        selectedDate = dateStr;
                        bookButton.disabled = false;
                        bookButton.classList.add("enabled");
                        if (selectedCell) selectedCell.classList.remove("selected");
                        cell.classList.add("selected");
                        selectedCell = cell;
                    };
                }

                calendar.appendChild(cell);
            }
        }

        monthSelect.addEventListener("change", () => {
            year = parseInt(yearSelect.value);
            month = parseInt(monthSelect.value);
            getBookingStatus();
        });

        yearSelect.addEventListener("change", () => {
            year = parseInt(yearSelect.value);
            month = parseInt(monthSelect.value);
            getBookingStatus();
        });

        bookButton.addEventListener("click", () => {
            if (!selectedDate) return;

            axios.get(`/index.php/api/schedules/time-slots?date=${selectedDate}`)
                .then(res => {
                    const slots = res.data;
                    timeSlotsContainer.innerHTML = "";
                    selectedSlotBtn = null;
                    selectedSlot = null;
                    modalBookBtn.disabled = true;
                    slots.forEach(slot => {
                        const btn = document.createElement("button");
                        btn.className = "slot-btn";
                        btn.textContent = slot.time_slot;
                        btn.disabled = slot.is_available == 0;
                        if (slot.is_available != 0) {
                            btn.onclick = () => {
                                if (selectedSlotBtn) selectedSlotBtn.classList.remove("selected");
                                btn.classList.add("selected");
                                selectedSlotBtn = btn;
                                selectedSlot = slot;
                                modalBookBtn.disabled = false;
                            };
                        }
                        timeSlotsContainer.appendChild(btn);
                    });
                    timeSlotModal.classList.add("active");
                });
        });

        modalBookBtn.addEventListener("click", () => {
            if (!selectedSlot || !selectedDate) return;
            modalBookBtn.disabled = true;

            axios.post(`/index.php/api/schedules/book`, {
                date: selectedDate,
                time_slot: selectedSlot.time_slot,
                schedule_id: selectedSlot.schedule_id
            }).then(res => {
                timeSlotModal.classList.remove("active");
                bookButton.disabled = true;
                bookButton.classList.remove("enabled");
                customAlert.textContent = `Booking Successful!`;
                customAlert.classList.add("show");

                setTimeout(() => {
                    window.location.reload();
                }, 800);
            }).catch(() => {
                timeSlotModal.classList.remove("active");
                customAlert.textContent = "Booking failed. Please try again.";
                customAlert.classList.add("show");
                customAlert.style.background = "#ef4444";
                setTimeout(() => {
                    customAlert.classList.remove("show");
                    customAlert.style.background = "#a78bfa";
                    modalBookBtn.disabled = false;
                }, 2000);
            });
        });

        document.getElementById("closeModal").addEventListener("click", () => {
            timeSlotModal.classList.remove("active");
        });

        // Disable logout button when modal is open
       const logoutBtn = document.querySelector('.logout-btn');
       const homeBtn = document.querySelector('.home-btn');

        document.getElementById("bookButton").addEventListener("click", () => {
            logoutBtn.disabled = true;
            homeBtn.disabled = true;
        });

        document.getElementById("closeModal").addEventListener("click", () => {
            logoutBtn.disabled = false;
            homeBtn.disabled = false;
        });

        getBookingStatus();
    </script>
</body>
</html>