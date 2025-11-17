<style>
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



    .inbox-body {
        padding: 20px;
        height: 560px;
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

    .btn-send,
    .btn-send:hover {
        background: none repeat scroll 0 0 #00a8b3;
        color: #fff;
    }

    .btn-send:hover {
        background: none repeat scroll 0 0 #009da7;
    }

    .modal-header h4.modal-title {
        font-family: "Open Sans", sans-serif;
        font-weight: 300;
    }

    .modal-body label {
        font-family: "Open Sans", sans-serif;
        font-weight: 400;
    }

    .heading-inbox h4 {
        border-bottom: 1px solid #ddd;
        color: #444;
        font-size: 18px;
        margin-top: 20px;
        padding-bottom: 10px;
    }

    .sender-info {
        margin-bottom: 20px;
    }

    .sender-info img {
        height: 30px;
        width: 30px;
    }

    .sender-dropdown {
        background: none repeat scroll 0 0 #eaeaea;
        color: #777;
        font-size: 10px;
        padding: 0 3px;
    }

    .view-mail a {
        color: #ff6c60;
    }

    .attachment-mail {
        margin-top: 30px;
    }

    .attachment-mail ul {
        display: inline-block;
        margin-bottom: 30px;
        width: 100%;
    }

    .attachment-mail ul li {
        float: left;
        margin-bottom: 10px;
        margin-right: 10px;
        width: 150px;
    }

    .attachment-mail ul li img {
        width: 100%;
    }

    .attachment-mail ul li span {
        float: right;
    }

    .attachment-mail .file-name {
        float: left;
    }

    .attachment-mail .links {
        display: inline-block;
        width: 100%;
    }

    .fileinput-button {
        float: left;
        margin-right: 4px;
        overflow: hidden;
        position: relative;
    }

    .fileinput-button input {
        cursor: pointer;
        direction: ltr;
        font-size: 23px;
        margin: 0;
        opacity: 0;
        position: absolute;
        right: 0;
        top: 0;
        transform: translate(-300px, 0px) scale(4);
    }

    .fileupload-buttonbar .btn,
    .fileupload-buttonbar .toggle {
        margin-bottom: 5px;
    }

    .files .progress {
        width: 200px;
    }

    .fileupload-processing .fileupload-loading {
        display: block;
    }

    * html .fileinput-button {
        line-height: 24px;
        margin: 1px -3px 0 0;
    }

    *+html .fileinput-button {
        margin: 1px 0 0;
        padding: 2px 15px;
    }

    ul {
        list-style-type: none;
        padding: 0px;
        margin: 0px;
    }

    .button {
        display: block;
        background-color: #007bff;
        width: 300px;
        min-height: 50px;
        line-height: 50px;
        margin: auto;
        color: #fff;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        border-radius: 5px;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.3);
        transition: all 0.25s cubic-bezier(0.310, -0.105, 0.430, 1.400);
    }

    .button span,
    .button .icon {
        display: block;
        height: 100%;
        text-align: center;
        position: absolute;
        top: 0;
        line-height: 50px
    }

    .button span {
        width: 72%;
        line-height: inherit;
        font-size: 22px;
        text-transform: uppercase;
        left: 0;
        transition: all 0.25s cubic-bezier(0.310, -0.105, 0.430, 1.400);
    }

    .button span:after {
        content: '';
        background-color: #ffffff;
        width: 2px;
        height: 70%;
        position: absolute;
        top: 15%;
        right: -1px;
    }

    .button .icon {
        width: 28%;
        right: 0;
        transition: all 0.25s cubic-bezier(0.310, -0.105, 0.430, 1.400);
    }

    .button .icon .ti {
        font-size: 30px;
        vertical-align: middle;
        transition: all 0.25s cubic-bezier(0.310, -0.105, 0.430, 1.400), height 0.25s ease;
    }

    .button .icon .ti-mail-opened {
        height: 36px;
    }

    .button:hover span {
        left: -72%;
        opacity: 0;
    }

    .button:hover .icon {
        width: 100%;
    }

    .button:hover {
        opacity: 0.9;
    }

    .button:hover .icon .ti-mail-opened {
        height: 46px;
    }

    .close:hover {
        color: #000;
    }

    .modal {
        color: #000;
    }

    .dropdown-menu.action-dropdown.show {
        width: 100px !important;
        min-width: auto !important;
        text-align: center;
        overflow: hidden;
    }

    .dropdown-menu.action-dropdown.show .dropdown-item {
        padding: 5px !important;
    }

    .table-content-wrapper {
        overflow-y: auto;
        height: 492px;
    }

    .laptop-view {
        display: none;
    }

    /* mobile view */
    .mobile-notification-container {
        padding: 0 10px;
    }

    .notification-card {
        padding: 10px;
        border-radius: 5%;
    }

    .notification-card.unread {
        background-color: #f53e3e25;
    }

    .notification-card .icon-group {
        position: relative;
        margin-right: 5px;
    }

    .mobile-card-content {
        margin-left: 5px;
    }

    .notification-card .icon-group .red-dot {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #f53e3e;
    }

    .notification-card .icon-group i {
        font-size: 2rem;
        color: black;
    }

    .notification-card .mobile-card-content .mobile-notification-title {
        font-size: 1rem;
        margin-bottom: 5px;
        font-weight: bolder;
        color: black;
    }

    .notification-card .mobile-card-content .mobile-notification-content {
        font-size: 1rem;
        margin-bottom: 5px;
        font-weight: 500;
        color: black;
    }

    .notification-card .mobile-card-content .mobile-notification-time {
        font-size: 0.8rem;
        margin-bottom: 5px;
        font-weight: 400;
        color: black;
    }


    .cs-blog {
        margin-bottom: 30px;
    }

    .cs-blog h2 {
        font-size: 20px;
        letter-spacing: -1px;
        line-height: 29px;
        margin: 0 0 11px;
        position: relative;
        text-transform: uppercase;
    }

    .cs-blog::after {
        clear: both;
        content: "";
        display: block;
    }

    ul.blog-list {
        list-style: outside none none;
        margin: -30px 0 0;
        padding: 0;
        position: relative;
        width: 100%;
    }

    .blog-list.blog-slide {
        margin: 0;
    }

    .blog-list.blog-slider {
        margin: 0;
    }

    ul.blog-list li {
        float: left;
        list-style: outside none none;
        margin: 30px 0 0;
    }

    .blog-slide .slick-list {
        margin: 0 -15px;
    }

    ul.blog-list.blog-slide li {
        margin-bottom: 10px;
        margin-top: 0;
    }

    ul.blog-list li:first-child {
        border: 0 none;
    }

    ul.blog-list li figure {
        overflow: hidden;
        position: relative;
    }

    ul.blog-list li figure img {
        width: 100%;
    }

    ul.blog-list li .cs-text {
        border: 1px solid #f0f0f0;
        overflow: hidden;
        padding: 15px 20px;
    }


    .cs-blog-detail .cs-text .post-option {
        border-top: 1px solid #f0f0f0;
        float: left;
        padding-top: 10px;
        width: 100%;
    }

    .cs-blog-detail .cs-text .post-option span a {
        color: #777;
    }

    .widget ul.blog-list li .cs-text {
        height: auto;
        margin: 0;
        min-height: inherit;
        padding: 9px 0 13px;
    }

    ul.blog-list li .cs-text span {
        color: #8b919e;
        display: inline-block;
        font-size: 12px;
        line-height: 19px;
    }

    ul.blog-list li .cs-text p {
        margin-bottom: 12px;
    }

    ul.blog-list li .cs-text h5 {
        border-bottom: 1px solid #fff;
        font-size: 15px;
        margin: 0;
        min-height: 56px;
        padding: 0 0 5px;
    }

    ul.blog-list li .cs-text h5 a {
        color: #292c33;
    }

    ul.blog-list li .cs-text .readmore {
        float: right;
        font-size: 11px;
        line-height: 20px;
        padding-top: 6px;
        position: relative;
        text-transform: uppercase;
    }

    ul.blog-list .slick-list.draggable {
        overflow: hidden;
    }

    .cs-auther-name a {
        color: #999;
    }

    .blog-list .slick-arrow {
        background-color: #f9f9f9;
        float: left;
        height: 29px;
        margin: 5px 0 0 5px;
        text-align: center;
        width: 29px;
    }

    .blog-list .slick-arrow a {
        color: #999;
        font-size: 18px;
        line-height: 32px;
    }

    .cs-blog.classic {
        margin: 0 0 30px;
    }

    .cs-blog.classic ul {
        margin: 0;
    }

    .cs-blog.classic li {
        border-top: 2px solid #eceef0;
        float: left;
        list-style: outside none none;
        padding: 16px 0;
        width: 100%;
    }

    .cs-blog.classic p {
        display: inline-block;
        font-size: 16px;
        font-weight: 500;
        margin: 0 -4px 0 0;
        vertical-align: middle;
        width: 100%;
    }

    .cs-blog.classic p i {
        color: #c4c6c8;
        margin: 0 10px 0 0;
        vertical-align: middle;
    }

    .cs-blog.classic span {
        display: inline-block;
        float: right;
        font-size: 12px;
        text-align: right;
        vertical-align: middle;
    }

    .cs-blog.classic span i {
        color: #e2e5e8;
        float: right;
        font-size: 24px;
        margin: 2px 0 0 10px;
    }

    .cs-pagination-blog {
        margin-bottom: 30px;
    }

    .cs-blog.blog-medium {
        border-bottom: 0 none;
        margin: 0;
        padding-bottom: 30px;
    }

    .cs-blog.blog-medium::after {
        clear: both;
        content: "";
        display: block;
    }

    .cs-blog.blog-medium .blog-text .cs-post-title {
        clear: both;
    }

    .cs-blog .cs-media figure {
        position: relative;
    }

    .cs-blog .cs-media figure figcaption {
        background-color: rgba(0, 0, 0, 0.5);
        height: 100%;
        left: 0;
        opacity: 0;
        position: absolute;
        top: 0;
        transition: all 0.3s ease-in-out 0s;
        visibility: hidden;
        width: 100%;
    }

    .cs-blog .cs-media:hover figure figcaption {
        opacity: 1;
        visibility: visible;
    }

    .cs-blog.blog-medium .post-title h3 {
        margin-bottom: 0;
    }

    .cs-blog .post-title {
        margin-bottom: 10px;
    }

    .cs-blog.blog-medium .cs-media figure figcaption .cs-readmore a {
        color: #fff;
        font-size: 24px;
        left: 50%;
        margin: -10px 0 0 -65px;
        position: absolute;
        top: 50%;
        transform: scale(0.7);
    }

    .cs-blog.blog-medium .cs-media:hover figure figcaption .cs-readmore a {
        transform: scale(1);
    }

    .cs-blog.blog-medium:last-child {
        border-bottom: medium none;
        padding-bottom: 40px;
    }

    .blog-medium .cs-media {
        display: inline-block;
        margin-right: 30px;
        vertical-align: middle;
        width: 37%;
    }

    .blog-modern .cs-media {
        display: inline-block;
        margin-right: -4px;
        vertical-align: middle;
        width: 48.6%;
    }

    .blog-medium .cs-media figure img,
    .blog-modern .cs-media img {
        width: 100%;
    }

    .blog-medium .cs-media~.blog-text {
        display: inline-block;
        float: none;
        margin-right: 0;
        vertical-align: middle;
        width: 58%;
    }

    .blog-modern .blog-text {
        display: inline-block;
        margin-right: -4px;
        padding-left: 30px;
        vertical-align: middle;
        width: 51.4%;
    }

    .blog-modern .blog-text .cs-post-title {
        margin-bottom: 5px;
        padding-bottom: 1px;
        position: relative;
    }

    .blog-modern .blog-text .cs-post-title::after {
        bottom: 1px;
        content: "";
        height: 1px;
        left: 0;
        position: absolute;
        width: 27px;
    }

    .blog-modern .blog-text .blog-separator {
        margin: 0 0 10px;
    }

    .blog-modern .blog-text .blog-separator::before {
        display: none;
    }

    .blog-medium .blog-text {
        width: 99.1%;
    }

    .blog-medium .blog-text p {
        display: inline;
        margin: 0 0 15px;
    }

    .blog-medium .blog-separator {
        margin: 0 0 10px;
    }

    .cs-blog .cs-categories,
    .cs-blog-detail .cs-categories {
        display: block;
        margin: 0 0 12px;
    }

    .cs-blog .cs-categories a,
    .cs-blog-detail .cs-categories a {
        border-bottom: 2px solid #ededed;
        color: #55a747;
        display: inline-block;
        font-size: 10px;
        margin-right: 5px;
        padding-bottom: 2px;
        text-transform: uppercase;
    }

    .cs-blog-detail .post-option {
        float: right;
    }

    .cs-blog .post-option span a,
    .cs-blog-detail .post-option span a {
        color: #999 !important;
        display: inline-block;
        font-size: 12px;
        margin-right: 18px;
        vertical-align: middle;
    }

    .cs-blog .post-option span i,
    .cs-blog-detail .post-option span i {
        display: inline-block;
        font-size: 14px;
        margin-right: 10px;
        vertical-align: middle;
    }

    .cs-blog-detail .post-option span.post-category i {
        margin: 0;
    }

    .cs-blog-detail .post-option .post-category a {
        margin-left: 10px;
        margin-right: 0;
    }

    .cs-blog-detail .post-option .post-date {
        margin-left: 18px;
    }

    .cs-blog-detail .cs-text .post-option span i {
        float: left;
        margin: 3px 8px 0 0;
    }

    .cs-blog.blog-grid figure img {
        width: 100%;
    }

    .cs-blog.blog-grid .cs-media~.blog-text {
        margin: -30px 0 0;
        padding: 0 10px;
        position: relative;
        z-index: 1;
    }

    .cs-blog.blog-grid .cs-inner-bolg {
        background-color: #fff;
        display: inline-block;
        padding: 20px 25px;
        width: 100%;
    }

    .cs-blog.blog-grid .blog-text p {
        margin: 0 0 5px;
    }

    .cs-blog.blog-grid .post-option {
        line-height: normal;
        margin: 0 0 10px;
    }

    .cs-blog.blog-grid .post-option span {
        color: #8b919e;
        font-size: 10px;
        margin: 0 15px 0 0;
        position: relative;
        text-transform: uppercase;
    }

    .cs-blog.blog-grid .post-option span::before {
        background-color: #8b919e;
        border-radius: 100%;
        content: "";
        height: 3px;
        left: -10px;
        position: absolute;
        top: 5px;
        width: 3px;
    }

    .cs-blog.blog-grid .post-option span:last-child {
        margin: 0;
    }

    .cs-blog.blog-grid .post-option span:first-child::before {
        display: none;
    }

    .cs-blog.blog-grid .read-more {
        display: inline-block;
        font-size: 12px;
        position: relative;
    }

    .cs-blog.blog-grid .read-more::before {
        content: "";
        font-family: "icomoon";
        font-size: 14px;
        position: absolute;
        right: -15px;
        top: 0;
    }

    .blog-large .cs-media img {
        width: 100%;
    }

    .blog-large .cs-text {
        margin: 0 0 20px;
        position: relative;
        z-index: 1;
    }

    .blog-large .cs-media~.cs-text {
        background-color: #fff;
        margin: 0 auto;
        padding: 30px 0 0;
        width: 100%;
    }

    .cs-blog .cs-author,
    .cs-blog-detail .cs-author {
        float: left;
        margin: 0 0 10px;
    }

    .cs-blog .cs-author figure,
    .cs-blog-detail .cs-author figure {
        display: inline-block;
        height: 32px;
        margin: 0 10px 0 0;
        vertical-align: middle;
        width: 32px;
    }

    .cs-blog .cs-author figure img,
    .cs-blog-detail .cs-author figure img {
        border-radius: 100%;
    }

    .cs-blog .cs-author .cs-text,
    .cs-blog-detail .cs-author .cs-text {
        display: inline-block;
        margin: 0;
        padding: 0;
        vertical-align: middle;
    }

    .cs-blog .cs-author .cs-text a,
    .cs-blog-detail .cs-author .cs-text a {
        color: #555;
        font-size: 13px;
    }

    .blog-large .post-option,
    .cs-blog.blog-medium .post-option {
        float: right;
    }

    .cs-blog.blog-large .post-option span i,
    .cs-blog.blog-medium .post-option span i {
        color: #cfcfcf;
    }

    .post-option span i {
        margin-right: 5px;
        transition: all 0.3s ease-in-out 0s;
    }

    .blog-separator {
        border-bottom: 1px solid #f1f1f1;
        display: inline-block;
        margin: 20px 0 25px;
        position: relative;
        width: 100%;
    }

    .blog-large .cs-text p {
        margin: 0 0 25px;
    }

    .blog-large .read-more {
        border: 1px solid;
        border-radius: 20px;
        display: inline-block;
        font-size: 12px;
        padding: 4px 20px;
        text-transform: uppercase;
    }

    .blog-large .cs-post-title {
        margin: 0 0 15px;
    }

    .blog-large .cs-post-title h3 {
        margin: 0;
    }

    .cs-blog-detail .cs-post-title h1 {
        margin: 0 0 10px;
    }

    .cs-blog-detail .cs-post-title::after {
        clear: both;
        content: "";
        display: block;
    }

    .cs-blog-detail .cs-main-post img {
        width: 100%;
        height: 30vh;
        object-fit: cover;
        object-position: center;
    }

    .cs-blog-detail .cs-main-post {
        margin-bottom: 25px;
    }

    .cs-blog-detail .cs-admin-post .cs-media figure,
    .cs-blog-detail .cs-admin-post .cs-media figure img {
        border-radius: 100%;
    }

    .cs-blog-detail .cs-admin-post .cs-text {
        overflow: hidden;
    }

    .cs-blog-detail .cs-admin-post {
        float: left;
        width: 40%;
    }

    .cs-blog-detail .cs-admin-post .cs-media {
        float: left;
        height: 46px;
        margin-right: 14px;
        width: 46px;
    }

    .cs-blog-detail .cs-author-name {
        color: #ccc;
        display: inline-block;
        font-size: 14px;
        margin-right: 20px;
        padding-top: 6px;
        vertical-align: middle;
    }

    .cs-blog-detail .cs-author-name strong {
        color: #55a747;
        display: block;
        line-height: 26px;
    }

    .cs-blog-detail .cs-more-post {
        border: 1px solid #e4e4e4;
        border-radius: 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        color: #ccc;
        font-size: 11px;
        padding: 6px 8px;
    }

    .cs-blog-detail .cs-social-share {
        float: right;
    }

    .cs-blog-detail .cs-social-media {
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    .cs-blog-detail .cs-social-media li {
        display: inline-block;
        list-style: outside none none;
        margin: 0;
        vertical-align: top;
    }

    .cs-blog-detail .cs-social-media li a {
        background-color: #fc6d4c;
        border-radius: 50%;
        color: #fff;
        display: block;
        font-size: 13px;
        height: 28px;
        line-height: 30px;
        margin: 0 5px 5px 0;
        text-align: center;
        width: 28px;
    }

    .cs-blog-detail .cs-social-media li a.cs-more {
        line-height: 33px;
        padding: 0;
    }

    .cs-blog-detail .cs-social-media li a::before {
        display: none;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="facebook"] {
        background-color: #2b4a8b;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="Facebook"] {
        background-color: #2b4a8b;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="Tumblr"] {
        background-color: #32506d;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="tumblr"] {
        background-color: #32506d;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="Dribbble"] {
        background-color: #ea4c89;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="dribbble"] {
        background-color: #ea4c89;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="stumbleupon"] {
        background-color: #eb4823;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="Stumbleupon"] {
        background-color: #eb4823;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="rss"] {
        background-color: #f06c19;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="twitter"] {
        background-color: #1f94d9;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="linkedin"] {
        background-color: #10598c;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="google"] {
        background-color: #d83936;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="youtube"] {
        background-color: #b00;
    }

    .cs-blog-detail .cs-social-media li a[data-original-title="Youtube"] {
        background-color: #b00;
    }

    .cs-blog-detail .cs-social-media li a.cs-more .at4-icon {
        border-radius: 10px;
        margin: 5px 0 0 -2px;
    }

    .cs-blog-detail .cs-share {
        float: none;
        left: 0;
        margin: 0 15px 0 0;
        position: absolute;
        top: 0;
    }

    .cs-blog-detail .cs-share a {
        color: #333;
        font-size: 18px;
        font-weight: 700;
    }

    .cs-blog-detail .cs-share-detail::after {
        clear: both;
        content: "";
        display: block;
    }

    .cs-blog-detail .cs-share-detail {
        display: inline-block;
        margin-bottom: 0;
        padding-bottom: 0;
        position: relative;
        vertical-align: middle;
        width: 49%;
    }

    .cs-blog-detail .cs-post-option-panel {
        float: left;
        padding-top: 20px;
        width: 100%;
    }

    .cs-blog-detail .rich-editor-text p {
        margin-bottom: 30px;
    }

    blockquote,
    .rich-text-editor blockquote {
        border-left: 4px solid;
        margin: 0 0 40px;
        padding: 20px 0 0;
        position: relative;
        width: 95%;
    }

    blockquote {
        background-color: #fcfcfc;
        font-style: italic;
        padding: 15px 40px 20px 50px !important;
    }

    blockquote,
    blockquote span,
    blockquote p {
        color: #777;
        display: block;
        font-size: 16px;
        line-height: 24px;
        margin-bottom: 15px;
    }

    blockquote .author-name a {
        color: #999;
        font-size: 11px;
    }

    blockquote.text-left-align {
        text-align: left;
    }

    blockquote.text-right-align {
        text-align: right;
    }

    blockquote.text-center-align {
        text-align: center;
    }

    blockquote::before,
    .rich-text-editor blockquote::before {
        color: #eaeaea;
        content: "";
        font-family: "icomoon";
        font-size: 22px;
        font-style: normal;
        left: 24px;
        position: absolute;
        top: 15px;
        transform: scale(-1);
    }

    .rich-text-editor blockquote {
        background-color: #fcfcfc;
        font-style: italic;
        padding: 15px 40px 20px 50px;
    }

    .rich-text-editor blockquote p {
        margin: 0;
    }

    blockquote>span {
        margin: 0;
        position: relative;
    }

    blockquote>span.author-name::after {
        display: none;
    }

    blockquote>span::after {
        color: #eaeaea;
        content: "";
        display: inline-block;
        font-family: "icomoon";
        font-size: 22px;
        font-style: normal;
        margin: 0 0 0 8px;
        position: relative;
        top: 3px;
    }

    .cs-blog-detail .tags {
        display: inline-block;
        margin: 0 -4px 0 0;
        vertical-align: middle;
        width: 50%;
    }

    .cs-blog-detail .cs-tags {
        display: block;
        margin: 0 0 40px;
    }

    .cs-blog-detail .cs-tags .tags span {
        color: #333;
        display: inline-block;
        font-size: 18px;
        margin: 0 10px 5px 0;
    }

    .cs-blog-detail .cs-tags .tags ul {
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    .cs-tags ul li {
        display: inline-block;
        list-style: outside none none;
        margin: 0 0 6px;
    }

    .cs-tags ul li a {
        display: block;
        font-size: 12px;
        margin: 0 8px 0 0;
    }

    .cs-tags .tags ul li a {
        background-color: #f5f5f5;
        border-radius: 20px;
        color: #777;
        padding: 2px 18px 3px;
    }

    .comment-respond {
        margin-bottom: 30px;
    }

    .comment-form ul {
        list-style: outside none none;
    }

    .comment-form ul li {
        margin-bottom: 30px;
    }

    .comment-form .cs-element-title h3 {
        margin: 0;
    }

    .comment-form form .input-holder {
        position: relative;
    }

    .comment-form form .input-holder i {
        color: #cecece;
        font-size: 18px;
        position: absolute;
        right: 20px;
        top: 15px;
    }

    .comment-form form .input-holder input[type="text"],
    .comment-form form .input-holder textarea {
        border: 1px solid #e4e4e4;
        color: #999;
        font-size: 14px;
        height: 50px;
        margin-bottom: -1px;
        padding: 10px 20px;
        width: 100%;
    }

    .comment-form form .input-holder textarea {
        height: 214px;
        margin: 0 0 20px;
    }

    .comment-form form input[type="submit"] {
        background-color: #55a747;
        color: #fff;
        display: inline-block;
        font-size: 16px;
        padding: 10px 30px;
        text-transform: uppercase;
    }

    .blog-detail {
        box-shadow: none;
    }

    .blog-detail .blog-list {
        float: left;
        margin-bottom: 30px;
        position: relative;
        width: 100%;
    }

    .blog-slider-next {
        display: inline-block;
        position: absolute;
        right: 0;
        top: 10px;
    }

    .blog-slider-prev {
        display: inline-block;
        position: absolute;
        right: 20px;
        top: 10px;
    }

    .blog-detail::after,
    .author-detail::after,
    #comment ul li::after,
    .blog-detail .blog-list::after,
    .cs-packeges::after {
        clear: both;
        content: "";
        display: block;
    }

    .blog-title {
        margin-bottom: 25px;
    }

    .blog-title h3 {
        color: #282828;
        letter-spacing: -1px;
        line-height: 34px;
        margin: 0 0 10px;
    }

    .blog-detail .main-post {
        margin: 0 0 25px;
    }

    .blog-detail .main-post img {
        width: 100%;
    }

    .author-detail {
        border-bottom: 1px solid #f5f5f5;
        margin-bottom: 10px;
        padding-bottom: 22px;
    }

    .cs-admin figure {
        float: left;
        margin-right: 15px;
    }

    .cs-admin .cs-text {
        display: inline-block;
        overflow: hidden;
        padding-top: 8px;
    }

    .cs-admin .cs-text span {
        color: #ccc;
        display: block;
        font-size: 13px;
        line-height: 16px;
    }

    .cs-admin .cs-text strong {
        color: #282828;
        font-size: 14px;
        line-height: 18px;
    }

    .blog-detail h2 {
        line-height: 29px;
        margin: 0 0 11px;
        position: relative;
        width: 91%;
    }

    .rich-editor-text p {
        clear: both;
        line-height: 24px;
        margin-bottom: 20px;
    }

    @media (max-width: 499px) {
        .mobile-view {
            display: block;
        }

        .laptop-view {
            display: none;
        }
        .cs-blog-detail .cs-main-post img {
            border-radius: 8%;
        }
    }

    /*Laptop and tablet*/
    @media (min-width: 500px) {
        .laptop-view {
            display: flex;
        }

        .mobile-view {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .table {
            overflow-x: auto;
        }

        .table tbody tr {
            display: flex;
            margin-bottom: 10px;
        }

        .table tbody td {
            display: inline-block;
            text-align: left;
            border-bottom: 1px solid #ddd;
            position: relative;
            padding-left: 50%;
        }

        .table tbody td:last-child {
            text-align: right;
        }

        .table tbody td.inbox-small-cells {
            flex: 1;
        }

        .table tbody td.inbox-title {
            flex: 3;
        }

        .table tbody td.inbox-message {
            flex: 5;
        }

        .table tbody td.inbox-datetime {
            flex: 2;
        }
    }

    @media (max-width: 767px) {
        .files .btn span {
            display: none;
        }

        .files .preview * {
            width: 40px;
        }

        .files .name * {
            display: inline-block;
            width: 80px;
            word-wrap: break-word;
        }

        .files .progress {
            width: 20px;
        }

        .files .delete {
            width: 60px;
        }
    }
</style>
