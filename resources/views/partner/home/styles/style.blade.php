<style>
    button:active {
        border: none;
    }

    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }

    [type="radio"]:checked+label,
    [type="radio"]:not(:checked)+label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #000000;
    }

    [type="radio"]:checked+label:before,
    [type="radio"]:not(:checked)+label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }

    [type="radio"]:checked+label:after,
    [type="radio"]:not(:checked)+label:after {
        content: '';
        width: 12px;
        height: 12px;
        background: #F53E3E;
        position: absolute;
        top: 3px;
        left: 3px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    [type="radio"]:not(:checked)+label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    [type="radio"]:checked+label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .nav-item {
        padding: 0px 1px;
    }

    .nav-item.nav-item-first {
        padding-left: 4px;
        padding-right: 1px;
    }

    .nav-item.nav-item-last {
        padding-left: 1px;
        padding-right: 4px;
    }

    .nav-tabs-container {
        display: flex;
        justify-content: center;
    }

    .nav-tabs {
        display: inline-flex;
        justify-content: center;
        border: none;
        background-color: #0000000D;
        border-radius: 14px;
        padding: 4px 0px;
    }

    .nav-tabs .nav-link {
        color: #000000;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 0px;
        width: 40vw;
    }

    .nav-tabs .nav-link.active {
        font-weight: 800;
        color: white;
        background-color: #F53E3E;
        border-bottom: none;
        border-radius: 10px;
    }

    .tab-content {
        padding: 2vh 0px;
    }

    .form-container {
        padding: 0;
        border: none;
    }

    /* input:focus,
    input:focus-visible {
        outline: none;
        border: none;
    } */

    .form-control {
        padding: 0.375rem 0.3rem 0.375rem 0.75rem;
    }

    .input-group .btn {
        padding: 0.35rem 0.75rem 0.35rem 0;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .icon-box {
        padding: 0 0 0 5px
    }

    .btn-outline-warning:hover {
        color: white;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .card.card-deal {
        
    }

    .scroll-x-view {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        margin: 0 0 1rem 0;
    }

    .badge-button {
        background-color: #F8F8F8;
        color: black;
        font-size: 1rem;
        padding: 0.3rem 1rem;
        border-radius: 1.5rem;
        font-weight: 500;
        box-shadow: #0000000D 0px 2px 4px 0px;
        display: inline-block;
        ;
        margin: 2px;
    }

    .badge-button.active {
        background-color: #F53E3E;
        color: white;
    }

    @media (max-height: 800px) {
        .card.card-deal {
            height: 220px;
        }
    }

    @media (min-width: 768px) {
        .nav-item {
            padding: 0px 2px;
        }

        .nav-item.nav-item-first {
            padding-left: 4px;
            padding-right: 2px;
        }

        .nav-item.nav-item-last {
            padding-left: 2px;
            padding-right: 4px;
        }

        .nav-tabs {
            padding: 4px 0px;
        }

        .nav-tabs .nav-link {
            width: 250px;
        }
    }
</style>
