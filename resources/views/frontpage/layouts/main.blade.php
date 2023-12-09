<!DOCTYPE html>
<html lang="">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Mochammad Ikhsan Nawawi">
    <meta name="robots" content="index">
    <meta name="keywords" content="webex, smk negeri 1 garut, smea,smknegeri1garut, ekstrakurikuler">
    <meta name="title" content="Webex Smk Negeri 1 Garut">
    <meta name="description"
        content="Webex adalah Web Ekstrakurikuler Smk Negeri 1 Garut untuk mengelola ekstrakurikuler">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/index.html">
    <link rel="preconnect" href="https://fonts.gstatic.com/index.html" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2dec5.css?family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2f511.css?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet%401.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="icon" type="image/x-icon" href="{{ array_key_exists('favicon', $settings) ? img_src($settings['favicon'], 'settings') : '' }}">

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('webex/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('webex/css/vendors.css') }}">

    @stack('css')
    <title>{{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '' }}</title>

</head>

<body class="preloader-visible" data-barba="wrapper">

    <!-- preloader start -->
    <div class="preloader js-preloader">
        <div class="preloader__bg">
            <img src="{{ array_key_exists('logo_app_admin', $settings) ? img_src($settings['logo_app_admin'], 'settings') : '' }}" alt="">
        </div>
    </div>
    <!-- preloader end -->

    <!-- barba container start -->
    <div class="barba-container" data-barba="container">
        <main class="main-content  ">
            @include('frontpage.layouts.header')

            <div class="content-wrapper  js-content-wrapper">

                @yield('content')

            </div>
            @include('frontpage.layouts.footer')
        </main>
    </div>
    <!-- barba container end -->

    <!-- JavaScript -->

</body>

<!-- Mirrored from creativelayers.net/themes/educrat-html/home-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 02 Jul 2022 12:43:55 GMT -->

</html>
<script src="{{ asset('jquery/dist/jquery.js') }}"></script>

<script src="https://unpkg.com/leaflet%401.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    @stack('js')
<script src="{{ asset('webex/js/vendors.js') }}"></script>
<script src="{{ asset('webex/js/main.js') }}"></script>
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

