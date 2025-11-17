<script>
  const schedules = @json($schedules);
  const routeBase = "{{ route('admin.classroom.edit', ':id') }}";

  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const formatTime = (timeStr) => {
      const [hour, minute] = timeStr.split(':');
      return `${parseInt(hour)}:${minute}`;
    };

    const eventList = schedules.map(s => {
      console.log('s',s);
      const statusKey = s.status.toLowerCase();
      const isMakeup = s.is_makeup_session === 1;
      return {
        id: s.classroom.id,
        title: s.classroom.name,
        start: `${s.date}T${s.start}`,
        end: `${s.date}T${s.end}`,
        classNames: (isMakeup ? ['makeup-session-status-'+ statusKey] : ['status-' + statusKey]),
        extendedProps: {
          status: s.status,
          startTime: formatTime(s.start),
          endTime: formatTime(s.end),
          teacher: s.classroom.teacher.fullname
        }
      };
    });

    const getViewAndToolbar = () => {
      return {
        view: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
        headerToolbar: {
          left: '',
          center: 'customTitle',
          right: ''
        },
        customButtons: {
          customTitle: { text: 'Lịch học' }
        }
      };
    };

    const { view: initialView, headerToolbar, customButtons } = getViewAndToolbar();

    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: initialView,
      headerToolbar: headerToolbar,
      customButtons: customButtons,
      locale: 'vi',
      allDaySlot: false,
      contentHeight: 'auto',
      editable: false,
      selectable: false,
      events: eventList,

      eventContent: function (arg) {
        const { startTime, endTime, teacher } = arg.event.extendedProps;
        const title = arg.event.title;
        return {
          html: `
            <div>
              <div class="time-range">${startTime} - ${endTime}</div>
              <div><strong>${title}</strong></div>
              <div><span>${teacher}</span></div>
            </div>
          `
        };
      },

      eventClick: function (info) {
        const eventId = info.event.id;
        const targetUrl = routeBase.replace(':id', eventId);
        window.location.href = targetUrl;
      }
    });

    calendar.render();

    // ✅ Thay đổi view và toolbar khi resize
    window.addEventListener('resize', () => {
      const { view: newView, headerToolbar: newToolbar, customButtons: newButtons } = getViewAndToolbar();
      if (calendar.view.type !== newView) {
        calendar.setOption('headerToolbar', newToolbar);
        calendar.setOption('customButtons', newButtons);
        calendar.changeView(newView);
      }
    });
  });
</script>
