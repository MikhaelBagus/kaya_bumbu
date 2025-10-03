<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>Kaya Bumbu</title>
    <meta name="keywords" content="Keywords" />
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600'>

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/font-awesome/css/fontawesome-all.min.css')}}">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('theme/app/assets/skin/default_skin/css/theme.css')}}">

    <!-- Ladda -->
    <link rel="stylesheet" type="text/css" href="{{asset('theme/app/vendor/plugins/ladda/ladda.min.css')}}">

    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('theme/app/assets/admin-tools/admin-forms/css/admin-forms.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/back.style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/layout/header/base/light.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/layout/header/menu/light.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/layout/brand/dark.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/layout/aside/dark.css')}}" />


@stack('css')

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('logo_kaya_bumbu_web.png')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{asset('theme/app/vendor/jquery/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('theme/app/vendor/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

    {{--  SweetAlert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Embed browser icon -->
    <link rel="icon" href="{!! asset('logo_kaya_bumbu_web.png') !!}"/>

    <style>
        .form-group {
            margin-bottom: 2px;
        !important;
        }
        .modalLoading {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('https://emoji.slack-edge.com/T018G0QR25T/loading/33dcfd2fa2ab5f14.gif')
            50% 50%
            no-repeat;
        }
        body.loading {
            overflow: hidden;
        }
        body.loading .modalLoading {
            display: block;
        }

        body {
            background-color: #6666FF;
        }

        /* Sticky Sidebar with Scrollable Content */
        #sidebar_left {
            position: fixed !important;
            top: 0;
            left: 0;
            height: 100vh !important;
            width: 240px;
            z-index: 1000;
            overflow: hidden;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-left-content {
            height: 100vh !important;
            overflow-y: auto !important;
            overflow-x: hidden;
        }

        .sidebar-left-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-left-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .sidebar-left-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .sidebar-left-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Adjust main content to account for fixed sidebar */
        #content_wrapper {
            margin-left: 240px !important;
            transition: margin-left 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sidebar_left {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            #sidebar_left.active {
                transform: translateX(0);
            }
            
            #content_wrapper {
                margin-left: 0 !important;
            }
        }

        /* Ensure sidebar menu items are properly spaced */
        .sidebar-menu {
            padding-bottom: 20px;
        }

        .sidebar-menu li {
            margin-bottom: 2px;
        }

    </style>

</head>

<body class="dashboard-page sb-l-o sb-r-c">

<!-- Start: Main -->
<div id="main">

    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top bg-info">
        <div class="navbar-branding">
            <a class="navbar-brand" href="{{url('/')}}">
                {{config('app.name')}}
            </a>
            <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle fw600" data-toggle="dropdown"> Hi, {{Sentinel::getUser()->name}}
                    <span class="caret caret-tp hidden-xs"></span>
                </a>
                <ul class="dropdown-menu list-group dropdown-persist w150" role="menu">
                    <li class="list-group-item">
                        <a href="{{route('auth.change.password.form')}}" class="animated animated-short fadeInUp">
                            <span class="fa fa-lock"></span> Change Password </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{route('logout')}}" class="animated animated-short fadeInUp">
                            <span class="fa fa-power-off pr5"></span> @lang('auth.logout_heading') </a>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- End: Header -->

    <!-- Start: Sidebar Left -->
    <aside id="sidebar_left" class="nano nano-primary">

        <!-- Start: Sidebar Left Content -->
        <div class="sidebar-left-content nano-content">

            <!-- Start: Sidebar Left Menu -->
            <ul class="nav sidebar-menu">
                <li class="sidebar-label pt20">Menu</li>
                <li class="{{ request()->path() == '/' ? 'active' : '' }}">
                    <a href="{{url('/')}}">
                        <span class="fa fa-dashboard"></span>
                        <span class="sidebar-title">DASHBOARD</span>
                    </a>
                </li>

                @if(Sentinel::getUser()->type !== 'member')
                    @include('backend.menus.auth')
                    @include('backend.menus.log')
                    @include('backend.menus.source')
                    @include('backend.menus.bank')
                    @include('backend.menus.customer')
                    @include('backend.menus.driver')
                    @include('backend.menus.product_category')
                    @include('backend.menus.product')
                    @include('backend.menus.product_ranking')
                    @include('backend.menus.calendar')
                    @include('backend.menus.transaction')
                    @include('backend.menus.transaction_download')
                    @include('backend.menus.others')
                @endif
            </ul>
            <!-- End: Sidebar Menu -->
        </div>
        <!-- End: Sidebar Left Content -->

    </aside>
    <!-- End: Sidebar Left -->

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

    <!-- Start: Topbar -->
    @yield('topbar')
    <!-- End: Topbar -->

        <!-- Begin: Content -->
    @yield('content')
    <!-- End: Content -->
    </section>
    <!-- End: Content-Wrapper -->

    <!-- Begin: Page Footer -->
    <footer id="content-footer">
        <div class="row">
            <div class="col-md-6">
                <span class="footer-legal">{{config('app.name')}} <b>Version</b> 1.0.0 <b>Build</b> 1</span> || <a href="mailto:info@kayabumbu.com">Contact Support</a>
            </div>
            <div class="col-md-6 text-right">
                <strong style="margin-right: 40px">Copyright &copy; 2023 Limited.</strong>
                <a href="#content" class="footer-return-top">
                    <span class="fa fa-arrow-up"></span>
                </a>
            </div>
        </div>
    </footer>
    <!-- End: Page Footer -->
</div>
<!-- End: Main -->

<!-- BEGIN: PAGE SCRIPTS -->

<!-- Remove Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn-sm" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title custom_align text-danger" id="titles"><i class="fa fa-warning"></i> Attention</h4>
            </div>
            <form action="" method="post" id="remove-form">
                {!! csrf_field() !!}

                <input name="_method" type="hidden" id="method" value="DELETE">

                <div class="remove-form-list"></div>

                <div class="modal-body">
                    <div class="alert alert-micro alert-border-left alert-danger alert-dismissable">
                        <i class="fa fa-info pr10"></i>
                        <span id="message"></span>
                    </div>
                </div>

                <div class="modal-footer ">
                    <button type="submit" class="btn ladda-button btn-success btn-sm send-request" data-style="zoom-in">
                        <span class="ladda-label"><span class="fa fa-check"></span> @lang('global.yes')</span>
                        <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span></button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> @lang('global.no')</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Alert Modal -->
<div class="modal fade" id="alertModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="padding-top: 2%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-danger" id="myModalLabel"><i class="fa fa-warning"></i> Attention</h4>
            </div>
            <div class="modal-body">
                <p id="modal-text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-danger btn-sm btn-flat pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    (function () {
        window.alert = function () {
            $("#alertModal #modal-text").text(arguments[0]);
            $("#alertModal").modal('show');
        };
    })();
</script>

<script>
    @if(Route::currentRouteName() !== "recommendation.form_custom")
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @endif
</script>


<!-- Theme Javascript -->
<script src="{{asset('theme/app/assets/js/utility/utility.js')}}"></script>
<script src="{{asset('theme/app/assets/js/demo/demo.js')}}"></script>
<script src="{{asset('theme/app/assets/js/main.js')}}"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Init Admin Panels on widgets inside the ".admin-panels" container
        $('.admin-panels').adminpanel({
            grid        : '.admin-grid',
            draggable   : true,
            preserveGrid: true,
            mobile      : false,
            onStart     : function () {
                // Do something before AdminPanels runs
            },
            onFinish    : function () {
                $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');
            },
            onSave      : function () {
                $(window).trigger('resize');
            }
        });

    });

    $('#delete').on('show.bs.modal', function (e) {
        var removedLinkFull = $(e.relatedTarget).data('href');
        var message         = $(e.relatedTarget).data('message');
        var title           = $(e.relatedTarget).data('title');
        var method          = $(e.relatedTarget).data('method');

        $('#title').text(title);
        $('#message').text(message);
        //console.log(message);

        if(typeof method != 'undefined'){
            $('#method').val(method);
        }

        $('#remove-form').attr('action', removedLinkFull);
    });

    // Handle mobile sidebar toggle
    $('#toggle_sidemenu_l').on('click', function() {
        if ($(window).width() <= 768) {
            $('#sidebar_left').toggleClass('active');
        }
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#sidebar_left, #toggle_sidemenu_l').length) {
                $('#sidebar_left').removeClass('active');
            }
        }
    });

    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('#sidebar_left').removeClass('active');
        }
    });

</script>

<!-- Loading Button -->
<script src="{{asset('theme/app/vendor/plugins/ladda/ladda.min.js')}}"></script>
<script>
    // Init Ladda Plugin on buttons
    Ladda.bind('.ladda-button', {
        timeout: 2000
    });

    // Bind progress buttons and simulate loading progress. Note: Button still requires ".ladda-button" class.
    Ladda.bind('.progress-button', {
        callback: function (instance) {

            $(function () {
                $('form select').select2({
                    theme            : "bootstrap",
                    placeholder      : "Select",
                    containerCssClass: ':all:',
                });
            });

            var progress = 0;
            var interval = setInterval(function () {
                progress = Math.min(progress + Math.random() * 0.1, 1);
                instance.setProgress(progress);

                if (progress === 1) {
                    instance.stop();
                    clearInterval(interval);
                }
            }, 200);
        }
    });
</script>

@stack('scripts')

<!-- END: PAGE SCRIPTS -->

</body>

</html>
