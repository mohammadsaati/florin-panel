@extends('layouts.panel')

@section('content')
    <main class="grow" role="content">
        <!-- Toolbar -->
        <div class="pb-5">
            <!-- Container -->
            <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
                <div class="flex flex-col flex-wrap gap-1">
                    <h1 class="font-medium text-lg text-gray-900">
                        {{ $title }}
                    </h1>
                    <div class="flex items-center gap-1 text-sm font-normal">
                        <a class="text-gray-700 hover:text-primary" href="html/demo10.html">
                            {{ $subTitle }}
                        </a>
                    </div>
                </div>
                @if (isset($actions))
                    <div class="flex items-center gap-2">
                        {{ $actions }}
                    </div>
                @endif
            </div>
            <!-- End of Container -->
        </div>
        <!-- End of Toolbar -->
        <!-- Container -->
        <div class="container-fixed">
            <div class="my-2">
                <x-alert-manager />
            </div>
            <div class="grid gap-5 lg:gap-7.5">
                {{ $slot }}
            </div>
        </div>
        <!-- End of Container -->
    </main>
@endsection
