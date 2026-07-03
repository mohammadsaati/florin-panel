<?php

declare(strict_types=1);

return [
    'page_title' => 'Error',

    'code_label' => 'Error :code',

    'back_to_panel' => 'Back to panel',

    'go_to_login' => 'Sign in',

    '401' => [
        'title' => 'Sign-in required',
        'message' => 'You need to be signed in to view this page. If you were already signed in, your session may have expired.',
    ],

    '403' => [
        'title' => 'Access denied',
        'message' => 'You do not have permission to open this page. If you believe this is a mistake, contact support.',
    ],

    '404' => [
        'title' => 'Page not found',
        'message' => 'The address you opened does not exist or has moved. Check the link or use your panel menu to go where you need.',
    ],

    '405' => [
        'title' => 'Method not allowed',
        'message' => 'This address does not accept the kind of request you sent. Use the buttons and links inside the panel, or return to the dashboard.',
    ],

    '419' => [
        'title' => 'Session expired',
        'message' => 'For your security, this form is no longer valid. Return to the panel and try again.',
    ],

    '429' => [
        'title' => 'Too many requests',
        'message' => 'Too many actions were sent in a short time. Please wait a moment and try again.',
    ],

    '500' => [
        'title' => 'Something went wrong',
        'message' => 'The service is not responding correctly right now. Please try again in a few minutes. If it keeps happening, contact support.',
    ],

    '503' => [
        'title' => 'Service unavailable',
        'message' => 'We are temporarily unavailable for maintenance or updates. Please check back shortly.',
    ],

    'fallback' => [
        'title' => 'Unexpected error',
        'message' => 'Something did not go as expected. Return to the panel and try again; contact support if it continues.',
    ],
];
