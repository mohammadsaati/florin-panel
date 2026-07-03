<!DOCTYPE html>
<html class="h-full"
      data-theme="true"
      data-theme-mode="{{ config('theme.mode') }}"
      dir="{{ config('theme.direction') }}"
      lang="{{ config('theme.language') }}"
>
<head>
    <title>{{ config('theme.title') }}</title>

    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ versioned_assets('assets/fonts/iransans/font.css') }}" rel="stylesheet"/>

    @vite(['resources/js/theme.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ versioned_assets('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet"/>
</head>
<body class="antialiased flex h-full items-center justify-center text-base text-gray-700
             [--tw-page-bg:var(--tw-coal-300)] bg-[--tw-page-bg]">

    <div class="w-full max-w-[420px] px-4 py-10">
        @yield('content')
    </div>

    <script src="{{ versioned_assets('assets/js/core.bundle.js') }}"></script>
</body>
</html>
