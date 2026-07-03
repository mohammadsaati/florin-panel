<?php

return [
    'otp' => [
        'register' => "Sms panel registration code: :otp\nCancel 11",
        'login' => "Sms panel login code: :otp\nAccount :username",
        'forget_password' => "Sms panel reset password code: :otp\nAccount :username\n",
    ],
    'registered' => "Sms panel created successfully\nUsername: :username\nLogin:\n:domain\nCancel 11",
    'kyc' => [
        'accepted' => "Username: :username\nKyc accepted and panel is activated\nCancel 11",
        'rejected' => [
            'national_card' => "Username: :username\nKyc national card rejected, fix it\n:reason\nCancel 11",
            'card_number' => "Username: :username\nKyc card number rejected, fix it\n:reason\nCancel 11",
        ],
    ],

    'sms' => [
        'rejected' => "Dear :username\nYour SMS (ID: :sms_id) has been rejected.\n:description",
    ],

    'wallet' => [
        'low_balance' => "Dear :username\nYour SMS wallet balance has reached the alert threshold.\nPlease recharge your wallet.",
    ],
];
