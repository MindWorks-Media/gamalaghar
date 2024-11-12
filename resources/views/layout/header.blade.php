<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    @yield('metadata')

    <!-- site Favicon -->
    <link rel="icon" href="{{ url('assets/img/gamala-ghar-logo.png') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ url('assets/img/gamala-ghar-logo.png') }}" />
    <meta name="msapplication-TileImage" content="{{ url('assets/img/gamala-ghar-logo.png') }}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{ url('assets/css/ecicons.min.css') }}" />

    <!-- css All Plugins Files -->
    {{-- <link rel="stylesheet" href="{{ url('assets/css/animate.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/swiper-bundle.min.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/jquery-ui.min.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/countdownTimer.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/nouislider.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/slick.min.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/owl.carousel.min.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ url('assets/css/owl.theme.default.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.css') }}" />
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ url('assets/css/demo11.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/responsive.css') }}" />

    <!-- Background css -->
    {{-- <link rel="stylesheet" id="bg-switcher-css" href="{{ url('assets/css/bg-4.css') }}"> --}}

    {{-- <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css"> --}}
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}
    @livewireStyles()

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/layui/2.9.8/css/layui.css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WH6HCNY10L"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-WH6HCNY10L');
</script>

<body>
    @include('home.mycart')
