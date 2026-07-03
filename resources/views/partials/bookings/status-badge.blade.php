@php
    $map = [
        'pending'   => ['variant' => 'warning', 'label' => 'در انتظار'],
        'confirmed' => ['variant' => 'success', 'label' => 'تأیید شده'],
        'cancelled' => ['variant' => 'danger',  'label' => 'لغو شده'],
        'completed' => ['variant' => 'info',    'label' => 'انجام شده'],
        'rejected'  => ['variant' => 'dark',    'label' => 'رد شده'],
    ];
    $cfg = $map[$status->value ?? $status] ?? ['variant' => 'light', 'label' => $status];
@endphp
<x-badge :variant="$cfg['variant']" size="sm">{{ $cfg['label'] }}</x-badge>
