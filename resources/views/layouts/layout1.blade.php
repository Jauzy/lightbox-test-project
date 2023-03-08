<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title') | Admin Panel Humantechno</title>
    <link rel="apple-touch-icon" href="{{asset('themes/vuexy/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('themes/vuexy/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600;900;1" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/extensions/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/forms/select/select2.min.css')}}">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css" integrity="sha512-NXUhxhkDgZYOMjaIgd89zF2w51Mub53Ru3zCNp5LTlEzMbNNAjTjDbpURYGS5Mop2cU4b7re1nOIucsVlrx9fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/vuexy/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/pages/app-email.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/vuexy/css/plugins/forms/form-validation.css') }}">
    <!-- END: Page CSS-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.quilljs.com/1.1.6/quill.snow.css" rel="stylesheet">
    <script src="{{ asset('themes/vuexy/vendors/js/editors/quill/katex.min.js')}}"></script>
    <script src="{{ asset('themes/vuexy/vendors/js/editors/quill/highlight.min.js')}}"></script>
    <script src="https://cdn.quilljs.com/1.1.6/quill.js"></script>

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('styles.css')}}">
    <!-- END: Custom CSS-->
    <style>
        .menu-expanded .brand-logo {
            visibility: hidden
        }
        .menu-collapsed .main-menu:hover .brand-logo {
            visibility: hidden
        }
        select[readonly].select2-hidden-accessible + .select2-container {
            pointer-events: none;
            touch-action: none;
        }

        select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
            background: #eee;
            box-shadow: none;
        }

        select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
            display: none;
        }
        .sorting:before {
            right: 1em !important;
            content: "" !important;
        }
        .sorting:after {
            right: 1em !important;
            content: "" !important;
        }
        .sorting_asc:before {
            right: 1em !important;
            content: "" !important;
        }
        .sorting_asc:after {
            right: 1em !important;
            content: "" !important;
        }
        .sorting_desc:before {
            right: 1em !important;
            content: "" !important;
        }
        .sorting_desc:after {
            right: 1em !important;
            content: "" !important;
        }

        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value='poppins']::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value='poppins']::before
        {
            content: 'Poppins';
            font-family: 'Poppins', sans-serif;
        }

        .ql-font-poppins{
            font-family: 'Poppins', sans-serif;
        }

        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value='inter']::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value='inter']::before
        {
            content: 'Inter';
            font-family: 'Inter', sans-serif;
        }

        .ql-font-inter{
            font-family: 'Inter', sans-serif;
        }

        div.dataTables_wrapper div.dataTables_filter label, div.dataTables_wrapper div.dataTables_length label {
            margin-top : unset !important;
            margin-bottom: unset !important;
        }

    </style>
    @include('layouts.overide-color-css')
    @yield('css_section')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static menu-@yield('sidebar-size')" data-open="click" data-menu="vertical-menu-modern" data-col="">
    <div id="overlay">
        <div class="d-flex h-100">
            <div class="m-auto bg-white rounded-circle p-1" style="box-shadow: 50px 50px 113px #defeec inset,-50px -50px 110px #defeec inset;">
                <div class="wheel-and-hamster bg-light rounded-circle" role="img" aria-label="Orange and tan hamster running in a metal wheel">
                    <div class="wheel"></div>
                    <div class="hamster">
                        <div class="hamster__body">
                            <div class="hamster__head">
                                <div class="hamster__ear"></div>
                                <div class="hamster__eye"></div>
                                <div class="hamster__nose"></div>
                            </div>
                            <div class="hamster__limb hamster__limb--fr"></div>
                            <div class="hamster__limb hamster__limb--fl"></div>
                            <div class="hamster__limb hamster__limb--br"></div>
                            <div class="hamster__limb hamster__limb--bl"></div>
                            <div class="hamster__tail"></div>
                        </div>
                    </div>
                    <div class="spoke"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: Header-->
    @include('layouts.header')
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    @include('layouts.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row mb-0">

            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->

    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('themes/vuexy/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('themes/vuexy/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/forms/select/select2.full.min.js')}}"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/jszip.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/forms/cleave/cleave.min.js')}}"></script>
    <script src="{{asset('themes/vuexy/vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('themes/vuexy/js/core/app-menu.js')}}"></script>
    <script src="{{asset('themes/vuexy/js/core/app.js')}}"></script>

    <!-- END: Theme JS-->
    <script src="{{asset('setting.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- BEGIN: Page JS-->
    <script src{{asset('themes/vuexy/js/scripts/forms/form-select2.js')}}"></script>
    {{-- <script src="{{ asset('themes/vuexy/js/scripts/pages/app-email.js') }}"></script> --}}
    {{-- <script src="{{asset('themes/vuexy/js/scripts/pages/dashboard-ecommerce.js')}}"></script> --}}
    <!-- END: Page JS-->

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>

    <script>
        let Font = Quill.import('formats/font');
        // We do not add Sans Serif since it is the default
        Font.whitelist = ["sans-serif", "serif", "monospace", 'poppins', 'inter'];
        Quill.register(Font, true);
    </script>

    @yield('js_section')

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
        select.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent()
            });
        });
    </script>
</body>
<!-- END: Body-->

</html>
