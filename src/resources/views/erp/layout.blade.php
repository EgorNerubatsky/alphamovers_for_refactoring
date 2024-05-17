<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- theme meta -->
    <meta name="theme-name" content="quixlab" />

    <title>AlphaMovers | {{ auth()->user()->name }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

    <link href="{{ asset('plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">


    <link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet" />


    <!-- Chartist -->
    <link rel="stylesheet" href="{{ asset('plugins/chartist/css/chartist.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}" >
    <link href="{{ asset('assets/fullcalendar/css/style.css') }}" rel='stylesheet' />
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="{{ asset('plugins/summernote/dist/summernote.css') }}" rel="stylesheet">


    <link href="{{ asset('adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-style.css') }}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <style>
        body {
            background-color: #DCDCDC;
        }
    </style>
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <div class="nav-header">
            <div class="brand-logo">
            <a href="#">
                <b class="logo-abbr"><img src="{{ asset('img/logo_2.png') }}" alt=""> </b>
                <span class="logo-compact"><img src="{{ asset('img/logo-compact.png') }}" alt=""></span>
                <span class="brand-title">
                    <img src="{{ asset('img/logo-compact.png') }}" alt="">
                </span>
            </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">
                @include('erp.navigation')
            </div>
        </div>

        @include('erp.menu')

        <div class="content-body">
            <div class="container-fluid mt-3">
        @yield('content')
            </div>
        </div>

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by Nerybatkyi Y. 2023</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    @if(Auth::user()->is_executive)
<script>
    var getMailsRoute = "{{ route('erp.executive.emails.getMails') }}";
</script>
    @elseif(Auth::user()->is_manager)
<script>
    var getMailsRoute = "{{ route('erp.manager.emails.getMails') }}";
</script>
    @elseif(Auth::user()->is_logist)
<script>
    var getMailsRoute = "{{ route('erp.logist.emails.getMails') }}";
</script>
    @elseif(Auth::user()->is_accountant)
<script>
    var getMailsRoute = "{{ route('erp.accountant.emails.getMails') }}";
</script>
    @elseif(Auth::user()->is_hr)
<script>
    var getMailsRoute = "{{ route('erp.hr.emails.getMails') }}";
</script>
    @endif
    <script src="{{ asset('js/http_code.jquery.com_jquery-3.6.0.js') }}"></script>
{{--    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>--}}




{{--    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>--}}
    <script src="{{ asset('js/http_code.jquery.com_ui_1.13.2_jquery-ui.js') }}"></script>



{{--    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
    <script src="{{ asset('js/http_cdn.jsdelivr.net_npm_chart.js.js') }}"></script>






{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.1/Sortable.min.js"></script>--}}


    <script src="{{ asset('js/app-scrypt_kanban.js') }}"></script>
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}


    <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_select_user.js') }}"></script>


    <script src="{{ asset('js/app-scrypt_new_email_refresh.js') }}"></script>


    <script src="{{ asset('js/app-scrypt_add_user_button.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_client.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_forms_order.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_add_user_message.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_add_user_button.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_calendar.js') }}"></script>




    <script src="{{ asset('js/app-scrypt_submit_form.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_forms_order_accountant.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_forms_client.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_modal_delete.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_radiobuttons.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_add_client_contact.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_canvas.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_updating_messages.js') }}"></script>


    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>--}}
    <script src="{{ asset('js/adminlte.min.js') }}"></script>


    <script src="{{ asset('js/calendar-scrypt.js') }}"></script>
    <script src="{{ asset('js/app-scrypt.js') }}"></script>


    <script src="{{ asset('assets/fullcalendar/dist/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/fullcalendar/packages/core/locales/ru.global.js') }}"></script>
    <script src="{{ asset('assets/fullcalendar/packages/core/locales-all.global.js') }}"></script>


    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>









    <!-- Chartjs -->
    <script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Circle progress -->
    <script src="{{ asset('plugins/circle-progress/circle-progress.min.js') }}"></script>
    <!-- Datamap -->
    <script src="{{ asset('plugins/d3v3/index.js') }}"></script>
    <script src="{{ asset('plugins/topojson/topojson.min.js') }}"></script>
    <script src="{{ asset('plugins/datamaps/datamaps.world.min.js') }}"></script>
    <!-- Morrisjs -->
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/morris-init.js') }}"></script>

    <!-- Pignose Calender -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <!-- ChartistJS -->
    <script src="{{ asset('plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>

    <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('plugins/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/dist/summernote-init.js') }}"></script>
    <script src="{{ asset('js/app-scrypt_check_company.js') }}"></script>


</body>

</html>
