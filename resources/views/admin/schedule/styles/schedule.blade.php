<style>
/* Trạng thái */
.fc-event.status-pending {
  background-color: #60a5fa !important;
  border-color: #3b82f6 !important;
}
.fc-event.status-completed {
  background-color: #34d399 !important;
  border-color: #10b981 !important;
}
.fc-event.status-cancelled {
  background-color: #f87171 !important;
  border-color: #ef4444 !important;
}

/* Makeup session with pending status */
.fc-event.makeup-session-status-pending {
  background: linear-gradient(135deg, #60a5fa, #dbeafe) !important;
  border-color: #3b82f6 !important;
  color: #000 !important;
}

/* Makeup session with completed status */
.fc-event.makeup-session-status-completed {
  background: linear-gradient(135deg, #34d399, #d1fae5) !important;
  border-color: #10b981 !important;
  color: #000 !important;
}

/* Makeup session with cancelled status */
.fc-event.makeup-session-status-cancelled {
  background: linear-gradient(135deg, #f87171, #fee2e2) !important;
  border-color: #ef4444 !important;
  color: #000 !important;
}

.fc .fc-list-event-dot{
  display: none;
}

.fc .fc-daygrid-day-frame{
  display: block !important;
}

/* Ngày hiện tại */
.fc-day-today {
  background-color: #fffbcc !important;
  z-index: auto !important;
}

/* Header ngày */
.fc .fc-col-header-cell-cushion {
  display: block;
  font-weight: bold;
  text-transform: capitalize;
}
.fc .fc-day-header span:nth-child(2) {
  display: none;
}

.fc-event {
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.fc-event:hover {
  background-color: #3b82f6; /* màu hover */
  opacity: 0.9;
}

.fc .fc-daygrid-event {
  display: block;
  background: inherit;
  color: white;
  border: none;
  padding: 8px;
  border-radius: 6px;
  margin: 4px 0;
  font-size: 14px;
  white-space: normal;
}

.fc .fc-daygrid-day-frame {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 4px;
}

.fc-theme-standard .fc-scrollgrid {
  border: none;
}

/* ✅ Responsive: Mobile chỉnh nhỏ lại text và padding */
@media (max-width: 768px) {
  .fc .fc-toolbar-title {
    font-size: 16px;
  }

  .fc .fc-daygrid-event {
    font-size: 12px;
    padding: 6px;
  }

  .fc .fc-daygrid-day-frame {
    padding: 2px;
  }

  .fc .fc-event-title,
  .fc .fc-event-time {
    font-size: 12px !important;
  }

  .fc .fc-list-event-title {
    font-size: 14px;
  }

  .fc .fc-list-event-time {
    font-size: 12px;
  }

  .fc .time-range {
    display: none;
  }
}
</style>
