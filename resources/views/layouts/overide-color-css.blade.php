<style>
    .text-primary {
        color:#2A4C6B !important;
    }
    .nav-tabs .nav-link.active {
        color:#2A4C6B !important;
    }
    .nav-tabs .nav-link {
        color:#666666 !important;
    }

    .nav-tabs .nav-link:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: #cccccc !important;
        transition: transform 0.3s;
        transform: translate3d(0, 150%, 0);
    }
    .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: #2A4C6B !important;
        transition: transform 0.3s;
        transform: translate3d(0, 0, 0);
    }
    .nav-tabs .nav-link:after {
        transform: translate3d(0, 0, 0);
    }

    .btn-primary {
        background: #2A4C6B !important;
    }

    .btn-outline-primary {
        border-color: #2A4C6B !important;
        color:#2A4C6B !important;
    }

    .form-check-primary .form-check-input:checked {
        background-color: #2A4C6B !important
    }

    ::-webkit-scrollbar {
        width: 10px;
        height: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #163485;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
