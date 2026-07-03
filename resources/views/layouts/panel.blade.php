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
    <meta content="assets/media/app/og-image.png" property="og:image"/>

    <link href="{{ versioned_assets('assets/fonts/iransans/font.css') }}" rel="stylesheet"/>

    @vite(['resources/js/theme.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ versioned_assets('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet"/>
    <link href="{{ versioned_assets('assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet"/>
</head>
<body
    class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:var(--tw-coal-300)] [--tw-content-bg:var(--tw-light)] [--tw-content-bg-dark:var(--tw-coal-500)] [--tw-content-scrollbar-color:#e8e8e8] [--tw-header-height:60px] [--tw-sidebar-width:270px] bg-[--tw-page-bg] lg:overflow-hidden">
<div class="flex grow">
    @include('partials.layouts.header-mobile')

    <div class="flex flex-col lg:flex-row grow pt-[--tw-header-height] lg:pt-0">
        @include('partials.layouts.side-bar')

        <!-- Main -->
        <div class="flex flex-col grow lg:rounded-l-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border border-gray-300 dark:border-gray-200 lg:ms-[--tw-sidebar-width]">
            <div class="flex flex-col grow lg:scrollable-y-auto lg:[scrollbar-width:auto] lg:light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] pt-5" id="scrollable_content">

                @yield('content', '')

               @include('partials.layouts.footer')
            </div>
        </div>
        <!-- End of Main d--->
    </div>

</div>


</body>

<script src="{{ versioned_assets('assets/js/core.bundle.js') }}"></script>
<script src="{{ versioned_assets('assets/js/widgets/general.js') }}"></script>
<script src="{{ versioned_assets('assets/js/layouts/demo1.js') }}"></script>
@stack('scripts')

</html>
