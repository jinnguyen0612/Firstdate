<style>
    .container {
        margin-top: 1.6rem;
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
        padding: 2px 0px;
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


    .avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .partner-info .infor .partner-name {
        font-size: 1rem;
        font-weight: bold;
        text-align: center;
    }

    .partner-info .infor .partner-type {
        font-size: 0.8rem;
        text-align: center;
    }

    .group-tab {
        margin-top: 1.2rem;
    }

    /* Wallet */
    /* Wallet Card Styles */
    .card.card-wallet {
        background-color: #F53E3E;
        width: 100%;
        border-radius: 20px;
        padding: 5px;
        overflow: hidden;
        box-shadow: rgba(100, 100, 111, 0.2) 0 7px 20px;
    }

    .top-section {
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        /* background: linear-gradient(45deg, rgb(4, 159, 187), rgb(80, 246, 255)); */
        position: relative;
        padding: 10px 20px 0px 20px;
    }

    .modal .border {
        border-bottom-right-radius: 10px;
        background: var(--background);
        transform: skew(-40deg);
        box-shadow: -10px -10px 0 0 var(--background);
        position: relative;
        height: 30px;
        width: 140px;
    }

    .modal .border::before {
        content: "";
        position: absolute;
        top: 0;
        right: -15px;
        width: 15px;
        height: 15px;
        background: transparent;
        border-top-left-radius: 10px;
        box-shadow: -5px -5px 0 2px var(--background), -3px -5px 0 2px var(--background);
    }

    .top-section::before {
        content: "";
        position: absolute;
        top: 30px;
        left: 0;
        width: 15px;
        height: 15px;
        background: transparent;
        border-top-left-radius: 15px;
        box-shadow: -5px -5px 0 2px var(--background);
    }

    .card .top-section .wallet {
        font-size: 2rem;
        color: white;
        font-weight: 600;
    }

    .icons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        padding: 0 15px;
    }

    .logo .logo-text {
        font-size: 1.2rem;
        font-weight: 400;
    }

    .social-media {
        display: flex;
        gap: 10px;
        padding: 0 15px;
        align-items: center;
    }

    .social-media .svg {
        fill: var(--background);
    }

    .social-media .svg:hover {
        fill: white;
    }

    /* Bottom Section */
    .bottom-section {
        padding: 0px 5px;
        margin-bottom: 10px;
    }

    .bottom-section .title {
        font-size: 17px;
        color: white;
        text-align: center;
        letter-spacing: 2px;
    }

    .bottom-section .row {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
    }

    .bottom-section .item {
        flex: 1;
        text-align: center;
        padding: 5px;
        /* color: rgba(170, 222, 243, 0.721); */
        color: white;
    }

    .bottom-section .item .big-text {
        font-size: 1rem;
        display: block;
    }

    .bottom-section .item .regular-text {
        font-size: 9px;
    }

    .bottom-section .item:nth-child(2) {
        border-left: 1px solid rgba(255, 255, 255, 0.126);
        border-right: 1px solid rgba(255, 255, 255, 0.126);
    }

    /* End Wallet */

    .btn-logout {
        background: #f2f2f2;
        border-radius: 10px;
    }

    .btn-logout:hover {
        background: #e2e2e2;
        color: #F53E3E;
    }

    /* Modal */
    .group-wallet {
        position: relative;
    }

    .group-wallet .icon-wallet {
        position: absolute;
        bottom: 5px;
        right: 10px;
        font-size: 1.2rem;
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

    /* End Modal */

    .container-image {
        display: flex;
        justify-content: center;
    }

    .form-item {
        position: relative;
        margin-bottom: 15px
    }

    .form-item input {
        display: block;
        width: 100%;
        height: 50px;
        border-radius: 5px;
        font-size: 1.2rem;
        background: transparent;
        border: solid 1px #ccc;
        transition: all .3s ease;
        padding: 0 15px;
    }

    .form-item input:focus {
        border-color: #F53E3E;
    }

    .form-item label {
        position: absolute;
        cursor: text;
        z-index: 2;
        top: 13px;
        left: 10px;
        font-size: 12px;
        font-weight: bold;
        background: #fff;
        padding: 0 10px;
        color: #999;
        transition: all .3s ease
    }

    label[for="district"],
    .form-item textarea:focus+label,
    .form-item textarea:valid+label,
    .form-item input:disabled+label,
    .form-item input:focus+label,
    .form-item input:valid+label {
        font-size: 11px;
        top: -5px
    }

    .form-item input:focus+label {
        color: #F53E3E;
    }

    #picture__input {
        display: none;
    }

    .picture {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        aspect-ratio: 16/9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        border: 2px solid currentcolor;
        cursor: pointer;
        font-family: sans-serif;
        transition: color 300ms ease-in-out, background 300ms ease-in-out;
        outline: none;
        overflow: hidden;
    }

    .picture:hover {
        color: #777;
        background: #ccc;
    }

    .picture:active {
        border-color: turquoise;
        color: turquoise;
        background: #eee;
    }

    .picture:focus {
        color: #777;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .picture__img {
        max-width: 100%;
    }

    #account.fade,
    #gallery.fade {
        transition: opacity 0.1s linear;
    }

    .select2-container--bootstrap-5 .select2-selection {
        height: 50px;
        font-size: 1.2rem;
    }

    .select2-container--bootstrap-5 .select2-selection--single {
        display: flex;
        align-items: center;
    }

    #photos {
        margin-bottom: 40px;
        line-height: 0;
        -webkit-column-count: 5;
        -webkit-column-gap: 0px;
        -moz-column-count: 5;
        -moz-column-gap: 0px;
        column-count: 5;
        column-gap: 0px;
    }

    #photos img {
        width: 100% !important;
        height: auto !important;
        padding: 5px;
        border-radius: 15px;
    }

    .image-previews {
        width: 100px;
        height: 100px;
        border: 2px dashed #dcdee3;
        margin: 3px;
        position: relative;
    }

    .image-upload-container {
        display: inline-block;
        text-align: center;
        padding: 5px;
    }

    .image-upload-container input {
        width: 0.1px;
    }

    .image-upload-container .image-previews {
        align-self: center;
    }

    .image-upload-container .image {
        width: 100%;
        height: 100%;
        z-index: 3;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        user-select: none;
        opacity: 0.3;
        cursor: pointer;
    }

    .image-upload-container .image:hover {
        background-color: lightgray;
    }

    .mail-box {
        border-collapse: collapse;
        border-spacing: 0;
        display: table;
        table-layout: fixed;
        width: 100%;
    }

    .mail-box aside {
        display: table-cell;
        float: none;
        height: 100%;
        padding: 0;
        vertical-align: top;
    }

    .mail-box .sm-side {
        background: none repeat scroll 0 0 #ffffff;
        box-shadow: #0000006e 1px 1px 4px -1px;
        width: 20%;
        height: inherit;
    }

    .mail-box .lg-side {
        background: none repeat scroll 0 0 #fff;
        border-radius: 0 4px 4px 0;
        width: 100%;
    }

    .mail-box .sm-side .user-head {
        background: none repeat scroll 0 0 #00a8b3;
        border-radius: 4px 0 0;
        color: #fff;
        min-height: 120px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-head .inbox-avatar {
        float: left;
        width: 65px;
    }

    .user-head .inbox-avatar img {
        border-radius: 4px;
    }

    .user-head .user-name {
        display: inline-block;
        margin: 0 0 0 10px;
    }

    .user-head .user-name h5 {
        font-size: 14px;
        font-weight: 300;
        margin-bottom: 0;
        margin-top: 15px;
    }

    .user-head .user-name h5 a {
        color: #fff;
    }

    .user-head .user-name span a {
        color: #87e2e7;
        font-size: 12px;
    }

    a.mail-dropdown {
        background: none repeat scroll 0 0 #80d3d9;
        border-radius: 2px;
        color: #01a7b3;
        font-size: 10px;
    }

    .btn-update-profile{
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #btnUpdateGallery,
    #btnUpdateProfile{
        display: block;
        width: 100%;
        height: 40px;
    }

    .inbox-body {
        padding: 20px;
        height: 560px;
        border: none;
    }

    #btn-read-all:hover,
    #btn-delete-read:hover,
    #btn-read-all:focus,
    #btn-delete-read:focus,
    #btn-read-all:focus-visible,
    #btn-delete-read:focus-visible {
        color: #ff6c60;
        cursor: pointer;
    }

    .btn-compose {
        background: none repeat scroll 0 0 #0d6efd;
        color: #fff;
        padding: 12px 0;
        text-align: center;
        width: 100%;
    }

    .btn-compose:hover {
        background: none repeat scroll 0 0 #0d6efd;
        color: #fff;
    }

    ul.inbox-nav {
        display: inline-block;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .inbox-divider {
        border-bottom: 1px solid #d5d8df;
    }

    ul.inbox-nav li {
        display: inline-block;
        line-height: 45px;
        width: 100%;
    }

    ul.inbox-nav li a {
        color: #6a6a6a;
        display: inline-block;
        line-height: 45px;
        padding: 0 20px;
        width: 100%;
    }

    ul.inbox-nav li a:hover,
    ul.inbox-nav li.active a,
    ul.inbox-nav li a:focus {
        background: none repeat scroll 0 0 #d5d7de;
        color: #6a6a6a;
    }

    ul.inbox-nav li a i {
        color: #6a6a6a;
        font-size: 16px;
        padding-right: 10px;
    }

    ul.inbox-nav li a span.label {
        margin-top: 13px;
    }

    ul.labels-info li h4 {
        color: #5c5c5e;
        font-size: 13px;
        padding-left: 15px;
        padding-right: 15px;
        padding-top: 5px;
        text-transform: uppercase;
    }

    ul.labels-info li {
        margin: 0;
    }

    ul.labels-info li a {
        border-radius: 0;
        color: #6a6a6a;
    }

    ul.labels-info li a:hover,
    ul.labels-info li a:focus {
        background: none repeat scroll 0 0 #d5d7de;
        color: #6a6a6a;
    }

    ul.labels-info li a i {
        padding-right: 10px;
    }

    .nav.nav-pills.nav-stacked.labels-info p {
        color: #9d9f9e;
        font-size: 11px;
        margin-bottom: 0;
        padding: 0 22px;
    }

    .inbox-head {
        background: none repeat scroll 0 0 #41cac0;
        border-radius: 0 4px 0 0;
        color: #fff;
        min-height: 120px;
        padding: 20px;
    }

    .inbox-head h3 {
        display: inline-block;
        font-weight: 300;
        margin: 0;
        padding-top: 6px;
    }

    .inbox-head .sr-input {
        border: medium none;
        border-radius: 4px 0 0 4px;
        box-shadow: none;
        color: #8a8a8a;
        float: left;
        height: 40px;
        padding: 0 10px;
    }

    .inbox-head .sr-btn {
        background: none repeat scroll 0 0 #00a6b2;
        border: medium none;
        border-radius: 0 4px 4px 0;
        color: #fff;
        height: 40px;
        padding: 0 20px;
    }

    .table-inbox {
        border: 1px solid #d3d3d3;
        margin-bottom: 0;
    }

    .table-inbox tr td {
        padding: 12px !important;
    }

    .table-inbox tr td:hover {
        cursor: pointer;
    }

    .table-inbox tr td .fa-star.inbox-started,
    .table-inbox tr td .fa-star:hover {
        color: #f78a09;
    }

    .table-inbox tr td .fa-star {
        color: #d5d5d5;
    }

    .table-inbox tr.unread td {
        background: none repeat scroll 0 0 #f7f7f7;
        font-weight: 600;
    }

    ul.inbox-pagination {
        float: right;
    }

    ul.inbox-pagination li {
        float: left;
    }

    .mail-option {
        display: inline-block;
        margin-bottom: 10px;
        width: 100%;
    }

    .mail-option .chk-all,
    .mail-option .btn-group {
        margin-right: 5px;
    }

    .mail-option .chk-all,
    .mail-option .btn-group a.btn {
        border: 1px solid #e7e7e7;
        border-radius: 3px !important;
        display: inline-block;
        padding: 5px 10px;
    }

    .inbox-pagination a.np-btn {
        background: none repeat scroll 0 0 #fcfcfc;
        border: 1px solid #e7e7e7;
        border-radius: 3px !important;
        color: #afafaf;
        display: inline-block;
        padding: 5px 15px;
    }

    .mail-option .chk-all input[type="checkbox"] {
        margin-top: 0;
    }

    .mail-option .btn-group a.all {
        border: medium none;
        padding: 0;
    }

    .inbox-pagination a.np-btn {
        margin-left: 5px;
    }

    .inbox-pagination li span {
        display: inline-block;
        margin-right: 5px;
        margin-top: 7px;
    }

    .fileinput-button {
        background: none repeat scroll 0 0 #eeeeee;
        border: 1px solid #e6e6e6;
    }

    .inbox-body .modal .modal-body input,
    .inbox-body .modal .modal-body textarea {
        border: 1px solid #000000;
        box-shadow: none;
    }

    .text-gray {
        color: gray;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .divider-container {
        height: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .divider {
        width: 2px;
        height: 40%;
        background-color: rgba(0, 0, 0, 0.3);
        content: "";
    }

    .divider-container.title-deposit {
        height: inherit;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 40%;
    }

    .title-mobile-deposit .divider {
        width: 25%;
        height: 2px;
        background-color: rgba(0, 0, 0, 0.3);
        content: "";
    }

    .title-mobile-deposit {
        display: none;
        text-align: center;
    }

    .content-wrap {
        white-space: normal;
        word-break: break-word;
    }

    .bg-gray {
        background-color: gray;
    }

    @media (max-width: 1000px) {
        #photos {
            -moz-column-count: 4;
            -webkit-column-count: 4;
            column-count: 4;
        }
    }

    @media (max-width: 800px) {
        #photos {
            -moz-column-count: 2;
            -webkit-column-count: 2;
            column-count: 2;
        }
    }

    @media (min-width: 500px) {
        .partner-info {
            margin-top: 2.4rem;
        }

        .avatar-wrapper {
            width: 200px;
            height: 200px;
        }

        .partner-info .infor .partner-name {
            font-size: 1.2rem;
        }

        .partner-info .infor .partner-type {
            font-size: 1rem;
        }

        .group-tab {
            margin-top: 2rem;
        }
    }

    @media (max-width: 499px) {
        .mobile-view {
            display: block;
        }

        .laptop-view {
            display: none;
        }
    }

    /*Laptop and tablet*/
    @media (min-width: 500px) {
        #btnUpdateGallery{
            width: 50%;
        }

        .laptop-view {
            display: block;
        }

        .mobile-view {
            display: none;
        }

        .picture__img {
            width: 100%;
        }

        .picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            border: 2px solid currentcolor;
            cursor: pointer;
            font-family: sans-serif;
            transition: color 300ms ease-in-out, background 300ms ease-in-out;
            outline: none;
            overflow: hidden;
        }

        .picture:hover {
            color: #777;
            background: #ccc;
        }

        .picture:active {
            border-color: turquoise;
            color: turquoise;
            background: #eee;
        }

        .picture:focus {
            color: #777;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .picture__img {
            max-width: 100%;
        }
    }

    @media (max-width: 767px) {
        .divider-container {
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .divider {
            width: 45%;
            height: 2px;
        }

        .title-deposit {
            display: none;
        }

        .title-mobile-deposit {
            display: flex;
        }
    }

    @media (min-width: 590px) {
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
