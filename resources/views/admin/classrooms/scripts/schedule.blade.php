<script>
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const modal = document.getElementById('eventModal');
  const modalWeekday = document.getElementById('modalWeekday');
  const startTimeInput = document.getElementById('startTime');
  const endTimeInput = document.getElementById('endTime');
  const cancelBtn = document.getElementById('cancelBtn');
  const saveBtn = document.getElementById('storeBtn');
  const deleteBtn = document.getElementById('deleteBtn');
  const eventInput = document.getElementById('eventDataInput');

  let selectedDate = null;
  let selectedEvent = null;
  let eventList = [];

  try {
    const inputVal = eventInput?.value;
    if (inputVal) {
      const parsed = JSON.parse(inputVal);
      if (Array.isArray(parsed)) {
        eventList = parsed;
      }
    }
  } catch (e) {
    console.error('Không thể phân tích event_data:', e);
    eventList = [];
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'timeGridWeek',
    locale: 'vi',
    allDaySlot: false,
    slotMinTime: '07:00:00',
    slotMaxTime: '22:00:00',
    contentHeight: 'auto',
    headerToolbar: {
      left: '',
      center: 'customTitle',
      right: ''
    },
    customButtons: {
      customTitle: { text: 'Lịch học' }
    },
    dayHeaderFormat: { weekday: 'long' },
    selectable: true,

    dateClick: function (info) {
      selectedDate = new Date(info.dateStr);
      selectedEvent = null;

      const weekdayMap = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
      modalWeekday.textContent = weekdayMap[selectedDate.getDay()];
      startTimeInput.value = '';
      endTimeInput.value = '';
      deleteBtn.style.display = 'none';
      modal.style.display = 'block';
    },

    eventClick: function (info) {
      info.jsEvent.preventDefault();
      selectedEvent = info.event;
      selectedDate = new Date(selectedEvent.start);

      const weekdayMap = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
      modalWeekday.textContent = weekdayMap[selectedDate.getDay()];
      startTimeInput.value = selectedEvent.extendedProps.start;
      endTimeInput.value = selectedEvent.extendedProps.end;

      // Ghi nhớ giá trị cũ để cập nhật đúng trong eventList
      selectedEvent.oldStart = selectedEvent.extendedProps.start;
      selectedEvent.oldEnd = selectedEvent.extendedProps.end;
      selectedEvent.oldWeekday = selectedDate.getDay();

      deleteBtn.style.display = 'inline-block';
      modal.style.display = 'block';
    }
  });

  calendar.render();

  // Hiển thị các sự kiện có sẵn
  eventList.forEach(event => {
    const weekday = event.weekday;
    const [startHour, startMinute] = event.start.split(':').map(Number);
    const [endHour, endMinute] = event.end.split(':').map(Number);

    const today = new Date();
    const diff = weekday - today.getDay();
    const eventDate = new Date(today);
    eventDate.setDate(today.getDate() + diff);

    const start = new Date(eventDate);
    start.setHours(startHour, startMinute);
    const end = new Date(eventDate);
    end.setHours(endHour, endMinute);

    calendar.addEvent({
      title: 'Lịch học',
      start: start,
      end: end,
      allDay: false,
      extendedProps: {
        start: event.start,
        end: event.end
      }
    });
  });

  saveBtn.onclick = () => {
    const startVal = startTimeInput.value;
    const endVal = endTimeInput.value;

    if (!startVal || !endVal) {
      alert('Vui lòng nhập đầy đủ thời gian');
      return;
    }

    if (startVal >= endVal) {
      alert('Giờ bắt đầu phải trước giờ kết thúc.');
      return;
    }

    const [startHour, startMinute] = startVal.split(':').map(Number);
    const [endHour, endMinute] = endVal.split(':').map(Number);

    if (
      startHour < 7 || startHour >= 22 ||
      endHour < 7 || endHour > 22 ||
      (endHour === 22 && endMinute > 0)
    ) {
      alert('Thời gian phải nằm trong khoảng từ 07:00 đến 22:00.');
      return;
    }

    const start = new Date(selectedDate);
    start.setHours(startHour, startMinute);
    const end = new Date(selectedDate);
    end.setHours(endHour, endMinute);

    const weekday = start.getDay();

    if (!selectedEvent) {
      const existingEvent = eventList.find(e => e.weekday === weekday);
      if (existingEvent) {
        alert('Ngày này đã có lịch học. Mỗi ngày chỉ được một lịch.');
        return;
      }

      calendar.addEvent({
        title: 'Lịch học',
        start: start,
        end: end,
        allDay: false,
        extendedProps: {
          start: startVal,
          end: endVal
        }
      });

      eventList.push({
        weekday,
        start: startVal,
        end: endVal
      });

    } else {
      selectedEvent.setStart(start);
      selectedEvent.setEnd(end);
      selectedEvent.setExtendedProp('start', startVal);
      selectedEvent.setExtendedProp('end', endVal);

      const index = eventList.findIndex(e =>
        e.weekday === selectedEvent.oldWeekday &&
        e.start === selectedEvent.oldStart &&
        e.end === selectedEvent.oldEnd
      );

      if (index !== -1) {
        eventList[index] = {
          weekday,
          start: startVal,
          end: endVal
        };
      }
    }

    syncEventListToInput();
    modal.style.display = 'none';
    selectedEvent = null;
    console.log('eventList',eventList);
    console.log('html input',eventInput.value);
  };

  deleteBtn.onclick = () => {
    if (!selectedEvent) return;

    const index = eventList.findIndex(e =>
      e.weekday === selectedEvent.oldWeekday &&
      e.start === selectedEvent.oldStart &&
      e.end === selectedEvent.oldEnd
    );

    if (index !== -1) {
      eventList.splice(index, 1);
    }

    selectedEvent.remove();
    syncEventListToInput();
    modal.style.display = 'none';
    selectedEvent = null;
  };

  cancelBtn.onclick = () => {
    modal.style.display = 'none';
    selectedEvent = null;
    deleteBtn.style.display = 'none';
  };

  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
      selectedEvent = null;
      deleteBtn.style.display = 'none';
    }
  };

  function syncEventListToInput() {
    if (eventInput) {
      eventInput.value = JSON.stringify(eventList);
    }
  }
});
</script>
