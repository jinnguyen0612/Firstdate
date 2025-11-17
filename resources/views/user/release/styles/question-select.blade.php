<style>
    #qaGrid {
        max-height: 50vh;
    }

    /* card tối giản */
    .qa-grid {
        display: grid;
        gap: 10px;
    }

    .qa-card {
        position: relative;
        border: 1px dashed #d9d9de;
        border-radius: 12px;
        background: #fff;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .qa-card .plus {
        font-size: 20px;
        color: #b0b0b6;
    }

    .qa-card .title {
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }

    .qa-card[data-is-required="true"] .title {
        color: #ef4444;
    }

    .qa-card .sub {
        font-size: 12px;
        color: #8e8e93;
        margin-top: 2px;
    }

    .qa-card .chev {
        transform: rotate(90deg);
        color: #b0b0b6;
    }

    .qa-card .remove {
        position: absolute;
        top: 6px;
        right: 6px;
        border: 0;
        background: #f3f4f6;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        font-weight: 700;
        color: #666;
        display: none;
    }

    .qa-card.filled {
        border-style: solid;
    }

    .qa-card.filled .remove {
        display: inline-block;
    }

    /* bottom sheet iOS */
    .fd-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .32);
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease;
        z-index: 1060;
    }

    .fd-backdrop.open {
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
        z-index: 1061;
        border-top-left-radius: 22px;
        border-top-right-radius: 22px;
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

    .fd-head {
        position: relative;
        display: flex;
        justify-content: center;
        padding: 4px 16px 8px;
    }

    .fd-title {
        font-weight: 700;
        font-size: 18px;
    }

    .fd-close {
        position: absolute;
        right: 6px;
        top: 0;
        border: 0;
        background: transparent;
        font-size: 24px;
        padding: 8px;
        color: #666;
        cursor: pointer;
    }

    .fd-list {
        overflow-y: auto;
        list-style: none;
        margin: 8px 0 0;
        padding: 0;
    }

    .fd-list li {
        border-top: 1px solid #e9e9ec;
    }

    .fd-list li:first-child {
        border-top: 0;
    }

    .fd-list li>button {
        width: 100%;
        padding: 14px 16px;
        background: transparent;
        border: 0;
        text-align: left;
        font-size: 16px;
        cursor: pointer;
    }

    .fd-safe {
        height: max(16px, env(safe-area-inset-bottom));
    }
</style>
