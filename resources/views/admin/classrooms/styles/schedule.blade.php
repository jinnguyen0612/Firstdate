<style>
    .fc .fc-col-header-cell-cushion {
        display: block;
        font-weight: bold;
    }

    .fc .fc-day-header span:nth-child(2) {
        display: none;
    }

    .fc-day-today {
        background-color: #fffbcc !important; /* vẫn highlight */
        z-index: auto !important; /* đảm bảo không che mất event */
    }

    .fc-event {
        pointer-events: auto !important;
    }
/* 
    .fc .fc-col-header-cell {
        font-size: 14px;
    } 
*/
</style>
