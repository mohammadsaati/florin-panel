@php
    use App\Enums\AlertMessageTypeEnum;
@endphp

@if($errors->any())
    <x-alert
        :type="AlertMessageTypeEnum::WARNING->value"
        title="لطفا هنگام تکمیل فرم دقت کنید!"
        icon="ki-filled ki-cross-square"
        :dismissible="true"
    >
        @foreach($errors->all() as $error)
            {{ $error }}
            <br/>
        @endforeach
    </x-alert>
@endif

@php
    $sessionAlerts = [
        AlertMessageTypeEnum::WARNING->value => ['title' => 'هشدار', 'icon' => 'ki-filled ki-cross-square'],
        AlertMessageTypeEnum::SUCCESS->value => ['title' => 'موفق', 'icon' => 'ki-filled ki-check-circle']
    ]
@endphp

@foreach($sessionAlerts as $sessionAlertKey =>  $sessionAlertValue)
    @if(session()->has($sessionAlertKey))
        <x-alert
            :type="$sessionAlertKey"
            :title="$sessionAlertValue['title']"
            :icon="$sessionAlertValue['icon']"
            :dismissible="true"
        >
           {{ session()->get($sessionAlertKey) }}
        </x-alert>
    @endif
@endforeach
