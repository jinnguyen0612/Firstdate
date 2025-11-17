<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const sessionDataInput = document.getElementById('sessionDataInput');

    const classroom = @json($instance);
    const sessions = @json($sessions);
    let editableSessions = sessions.map(s => ({ ...s }));
    let selectedEventId = null;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        initialDate: sessions.length > 0 ? sessions[0].date : new Date(),
        locale: 'vi',
        allDaySlot: false,
        slotMinTime: '07:00:00',
        slotMaxTime: '21:00:00',
        contentHeight: 'auto',
        dayHeaderFormat: { weekday: 'long' },
        selectable: false,
        eventClick: function (info) {
            const eventId = info.event.id;
            const session = editableSessions.find(s => s.id == eventId);

            if (!session || session.status !== 'pending') return;

            selectedEventId = eventId;

            const date = info.event.start;
            const weekday = date.toLocaleDateString('vi-VN', { weekday: 'long' });
            const fullDate = date.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });

            document.getElementById('modalWeekday').innerText = `${weekday}, ${fullDate}`;
            document.getElementById('startTime').value = session.start;
            document.getElementById('endTime').value = session.end;
            document.getElementById('eventContent').value = session.content || '';

            document.getElementById('eventModal').style.display = 'block';
        },
        eventContent: function(arg) {
            const titleEl = document.createElement('div');
            titleEl.innerText = arg.event.title;

            const start = arg.event.start;
            const end = arg.event.end;

            const timeRange = start && end
                ? `${start.getHours().toString().padStart(2, '0')}:${start.getMinutes().toString().padStart(2, '0')} - ${end.getHours().toString().padStart(2, '0')}:${end.getMinutes().toString().padStart(2, '0')}`
                : '';

            const timeEl = document.createElement('div');
            timeEl.innerText = timeRange;
            timeEl.style.fontSize = '0.8em';
            timeEl.style.fontWeight = 'bold';

            const content = arg.event.extendedProps.content || 'Không có nội dung';
            const contentEl = document.createElement('div');
            contentEl.innerText = content;
            contentEl.style.fontSize = '0.75em';
            contentEl.style.color = '#fff';

            const containerEl = document.createElement('div');
            containerEl.appendChild(timeEl);
            containerEl.appendChild(titleEl);
            containerEl.appendChild(contentEl);

            return { domNodes: [containerEl] };
        }
    });

    // Thêm sự kiện vào lịch
    editableSessions.forEach(event => {
        const startDateTime = `${event.date}T${event.start}`;
        const endDateTime = `${event.date}T${event.end}`;

        const isMakeup = event.is_makeup_session == 1;
        const status = event.status;

        // Gán class theo điều kiện
        let classNames = [];
        if (isMakeup) {
            classNames.push(`makeup-session-status-${status}`);
        } else {
            classNames.push(`status-${status}`);
        }

        const shortContent = event.content
            ? event.content.length > 20 ? event.content.substring(0, 20) + '...' : event.content
            : 'Chưa điền nội dung';

        calendar.addEvent({
            id: event.id,
            title: classroom.name || 'Lịch học',
            start: startDateTime,
            end: endDateTime,
            allDay: false,
            classNames: classNames,
            extendedProps: {
                start: event.start,
                end: event.end,
                content: event.content,
                status: event.status,
                is_makeup_session: event.is_makeup_session
            }
        });
    });

    calendar.render();

    // Nút Lưu trong modal
    document.getElementById('storeBtn').addEventListener('click', function () {
        const content = document.getElementById('eventContent').value.trim();
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;

        const index = editableSessions.findIndex(s => s.id == selectedEventId);
        if (index !== -1) {
            editableSessions[index].content = content;
            editableSessions[index].start = startTime;
            editableSessions[index].end = endTime;
            sessionDataInput.value = JSON.stringify(editableSessions);

            const event = calendar.getEventById(selectedEventId);
            if (event) {
                const eventDate = event.start.toISOString().split('T')[0];
                event.setStart(`${eventDate}T${startTime}`);
                event.setEnd(`${eventDate}T${endTime}`);
                const shortContent = content
                    ? (content.length > 20 ? content.substring(0, 20) + '...' : content)
                    : 'Chưa điền nội dung';
                event.setExtendedProp('content', shortContent);
                calendar.refetchEvents();
            }
        }

        document.getElementById('eventModal').style.display = 'none';
        console.log('Updated sessions:', editableSessions);
    });

    // Nút Hủy modal
    document.getElementById('cancelBtn').addEventListener('click', function () {
        document.getElementById('eventModal').style.display = 'none';
    });
});
</script>
