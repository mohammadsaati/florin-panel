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

<body class="antialiased flex h-full text-base text-gray-700 dark:bg-coal-500">

<style>
    .page-bg {
        background-image: url('{{ asset('assets/media/images/bg-2.png') }}');
    }
    .dark .page-bg {
        background-image: url('{{ asset('assets/media/images/bg-2.png') }}');
    }
</style>

<div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
    <div class="card max-w-[370px] w-full">
        <form action="{{ route('login') }}" class="card-body flex flex-col gap-5 p-10" id="sign_in_form" method="POST">
            @csrf
            <div class="text-center mb-2.5">
                <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
                    ورود به پنل ادمین
                </h3>
            </div>


            <div class="flex flex-col gap-1 items-start">
                <label class="form-label font-normal text-gray-900">
                    شماره
                </label>
                <input class="input" name="phone" placeholder="0914...." type="text" value="{{ old('phone') }}"/>
                @error('phone')
                    <span class="text-sm text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-1">
                    <label class="form-label font-normal text-gray-900">
                        رمز عبور
                    </label>
                </div>
                <div class="input" data-toggle-password="true">
                    <input name="password" placeholder="Enter Password" type="password" value=""/>
                    <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                        </i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                        </i>
                    </button>
                </div>
                @error('password')
                  <span class="text-sm text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button class="btn btn-primary flex justify-center grow">
                ورود
            </button>
        </form>
    </div>
</div>
</body>

<script src="{{ versioned_assets('assets/js/core.bundle.js') }}"></script>
<script src="{{ versioned_assets('assets/js/widgets/general.js') }}"></script>
<script src="{{ versioned_assets('assets/js/layouts/demo1.js') }}"></script>
@stack('scripts')

</html>
