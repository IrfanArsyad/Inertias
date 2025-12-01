<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template" id="html-root">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- DNS Prefetch for external resources -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://unpkg.com">

    <!-- Preconnect to critical origins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts - Load first for proper sizing -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap">

    <!-- Icons - Load synchronously for immediate availability -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/materialdesignicons.css" />

    <!-- Critical CSS - Load synchronously -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Load Module CSS if exists --}}
    @if(file_exists(base_path('modules/Auth/resources/assets/css/auth.css')))
        @vite(['modules/Auth/resources/assets/css/auth.css'])
    @endif

    @inertiaHead

    <!-- Non-critical CSS - Load with media print trick for async loading -->
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" media="print" onload="this.media='all'" />

    <!-- Fallback for browsers that don't support media onload -->
    <noscript>
        <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    </noscript>
</head>
<body>
    @inertia

    <!-- Ziggy Routes - Inline for faster access -->
    @routes

    <!-- Initialize template variables before loading scripts -->
    <script>
        // Define template variables to prevent errors
        window.templateName = 'materialize';
        window.rtlSupport = false;
        window.assetsPath = '/assets/';
        window.baseUrl = '{{ url('/') }}';
    </script>

    <!-- Materialize Core JS - Load in correct order without defer for compatibility -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="/assets/vendor/js/helpers.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>
    <script src="/assets/js/main.js"></script>
</body>
</html>