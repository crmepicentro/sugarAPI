<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>{{ $title_tdata ?? 'Titulo de postventas' }}</title>

  <meta name="description" content="{{ $descripcion_tdata ?? 'descripcion de postventas' }}">
  <meta name="author" content="wcadena@outlook.com">
  <meta name="robots" content="noindex, nofollow">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ mix('css/dashmix.css') }}">

  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
   <link rel="stylesheet" id="css-theme" href="{{ mix('css/themes/xplay.css') }}">
  @yield('css_after')

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>
</head>

<body>
<!-- Page Container -->
<!--
  Available classes for #page-container:

  GENERIC

    'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                - Theme helper buttons [data-toggle="theme"],
                                                - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                - ..and/or Dashmix.layout('dark_mode_[on/off/toggle]')

  SIDEBAR & SIDE OVERLAY

    'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
    'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
    'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
    'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
    'sidebar-dark'                              Dark themed sidebar

    'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
    'side-overlay-o'                            Visible Side Overlay by default

    'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

    'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

  HEADER

    ''                                          Static Header if no class is added
    'page-header-fixed'                         Fixed Header


  FOOTER

    ''                                          Static Footer if no class is added
    'page-footer-fixed'                         Fixed Footer (please have in mind that the footer has a specific height when is fixed)

  HEADER STYLE

    ''                                          Classic Header style if no class is added
    'page-header-dark'                          Dark themed Header
    'page-header-glass'                         Light themed Header with transparency by default
                                                (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
    'page-header-glass page-header-dark'         Dark themed Header with transparency by default
                                                (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

  MAIN CONTENT LAYOUT

    ''                                          Full width Main Content if no class is added
    'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
    'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

  DARK MODE

    'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
-->
<div id="page-container" class="page-header-dark main-content-boxed">

    <!-- Header -->

    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
    <!-- Navigation -->
        @section('menu_sidebar')
            <div class="bg-sidebar-dark">
                <div class="content">
                    <!-- Toggle Main Navigation -->
                    <div class="d-lg-none push">
                        <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
                        <button type="button" class="btn w-100 btn-primary d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                            Menu
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- END Toggle Main Navigation -->

                    <!-- Main Navigation -->
                    <div id="main-navigation" class="d-none d-lg-block push">
                        <ul class="nav-main nav-main-horizontal nav-main-hover nav-main-dark">
                            <li class="nav-main-item">
                                <a class="nav-main-link active" href="db_analytics.html">
                                    <i class="nav-main-link-icon fa fa-chart-pie"></i>
                                    <span class="nav-main-link-name">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-main-heading">Manage</li>
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fa fa-globe"></i>
                                    <span class="nav-main-link-name">Websites</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                            <span class="nav-main-link-name">example-website1.com</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-coffee"></i>
                                                    <span class="nav-main-link-name">Overview</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-users"></i>
                                                    <span class="nav-main-link-name">Visitors</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-file-alt"></i>
                                                    <span class="nav-main-link-name">Content</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-rocket"></i>
                                                    <span class="nav-main-link-name">Technology</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-share-alt"></i>
                                                    <span class="nav-main-link-name">Social</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                            <span class="nav-main-link-name">example-website2.com</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-coffee"></i>
                                                    <span class="nav-main-link-name">Overview</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-users"></i>
                                                    <span class="nav-main-link-name">Visitors</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-file-alt"></i>
                                                    <span class="nav-main-link-name">Content</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-rocket"></i>
                                                    <span class="nav-main-link-name">Technology</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-share-alt"></i>
                                                    <span class="nav-main-link-name">Social</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                            <span class="nav-main-link-name">example-website3.com</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-coffee"></i>
                                                    <span class="nav-main-link-name">Overview</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-users"></i>
                                                    <span class="nav-main-link-name">Visitors</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-file-alt"></i>
                                                    <span class="nav-main-link-name">Content</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-rocket"></i>
                                                    <span class="nav-main-link-name">Technology</span>
                                                </a>
                                            </li>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="">
                                                    <i class="nav-main-link-icon fa fa-share-alt"></i>
                                                    <span class="nav-main-link-name">Social</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fa fa-sync-alt"></i>
                                    <span class="nav-main-link-name">Subscriptions</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Active</span>
                                            <span class="nav-main-link-badge badge rounded-pill bg-success">1</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Manage</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-main-heading">Account</li>
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fa fa-user-circle"></i>
                                    <span class="nav-main-link-name">Billing &amp; Account</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Manage</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Privacy Settings</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Make Payment</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">View Invoices</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Security</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Statistics</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fa fa-life-ring"></i>
                                    <span class="nav-main-link-name">Support</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Contact Support</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="">
                                            <span class="nav-main-link-name">Knowledge Base</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-main-item ms-lg-auto">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fa fa-brush"></i>
                                    <span class="nav-main-link-name">Themes</span>
                                </a>
                                <ul class="nav-main-submenu nav-main-submenu-right">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="default" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-default"></i>
                                            <span class="nav-main-link-name">Default</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xwork.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xwork"></i>
                                            <span class="nav-main-link-name">xWork</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xmodern.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xmodern"></i>
                                            <span class="nav-main-link-name">xModern</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xeco.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xeco"></i>
                                            <span class="nav-main-link-name">xEco</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xsmooth.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xsmooth"></i>
                                            <span class="nav-main-link-name">xSmooth</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xinspire.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xinspire"></i>
                                            <span class="nav-main-link-name">xInspire</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xdream.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xdream"></i>
                                            <span class="nav-main-link-name">xDream</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xpro.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xpro"></i>
                                            <span class="nav-main-link-name">xPro</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" data-toggle="theme" data-theme="assets/css/themes/xplay.min.css" href="#">
                                            <i class="nav-main-link-icon fa fa-circle text-xplay"></i>
                                            <span class="nav-main-link-name">xPlay</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- END Main Navigation -->
                </div>
            </div>
        @show

        <!-- END Navigation -->

        <!-- Page Content -->
        <div class="content content-full">
            @yield('content')
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="footer-static bg-body-extra-light">

    </footer>
    <!-- END Footer -->
</div>
<!-- END Page Container -->

<!-- Dashmix Core JS -->
<script src="{{ mix('js/dashmix.app.js') }}"></script>

<!-- Laravel Original JS -->
<!-- <script src="{{ mix('/js/dash_laravel.app.js') }}"></script> -->

@yield('js_after')
</body>

</html>
