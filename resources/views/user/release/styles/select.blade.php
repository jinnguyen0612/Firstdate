<style>
    .fd-select {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .375rem .75rem;
        font-size: 1rem;
        background: #fff;
        border: 1px solid #e5e5ea;
        border-radius: 12px;
    }

    .fd-placeholder {
        color: var(--fd-muted);
    }

    .fd-chev {
        color: #b0b0b6;
    }

    /* Backdrop + Sheet (đặt ngoài form) */
    #fdSheetRoot {
        position: relative;
        z-index: 1060;
    }

    /* > Bootstrap modal (1050) nếu cần */
    .fd-sheet-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .32);
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease;
    }

    .fd-sheet-backdrop.open {
        opacity: 1;
        pointer-events: auto;
    }

    .fd-sheet {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        transform: translateY(100%);
        transition: transform .25s ease;
        background: #fff;
        border-top-left-radius: var(--fd-radius);
        border-top-right-radius: var(--fd-radius);
        box-shadow: 0 -8px 24px rgba(0, 0, 0, .18);
    }

    .fd-sheet.open {
        transform: translateY(0);
    }

    .fd-grabber {
        width: 36px;
        height: 4px;
        border-radius: 999px;
        background: #d1d1d6;
        margin: 10px auto 6px;
    }

    .fd-sheet-head {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px 16px 2px;
    }

    .fd-sheet-title {
        font-weight: 700;
        font-size: 18px;
    }

    .fd-sheet-close {
        position: absolute;
        right: 6px;
        top: 0;
        border: 0;
        background: transparent;
        font-size: 24px;
        padding: 8px;
        color: #666;
    }

    .fd-sheet-list {
        list-style: none;
        margin: 8px 0 0;
        padding: 0;
    }

    .fd-sheet-list li {
        border-top: 1px solid var(--fd-divider);
    }

    .fd-sheet-list li:first-child {
        border-top: 0;
    }

    .fd-sheet-list li {
        font-size: 16px;
    }

    .fd-sheet-list li>label,
    .fd-sheet-list li>span,
    .fd-sheet-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0.5rem 0.75rem;
    }

    .fd-sheet-list li:active {
        background: #f2f2f7;
    }

    .fd-has-check input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #ef4444;
        /* đỏ giống mock */
    }

    .fd-sheet-actions {
        display: flex;
        justify-content: space-around;
        gap: 8px;
        padding: 8px 12px 4px;
        border-top: 1px solid var(--fd-divider);
    }

    .fd-safe {
        height: max(16px, env(safe-area-inset-bottom));
    }
</style>
