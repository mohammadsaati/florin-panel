<?php

return [
    'templates' => [
        // admin announcements
        'admin_notice' => "Please pay attention to the important notice below.",
        'user_verification_completed' => "The user has submitted the documents.",
        'user_new_ticket_created' => "The user submitted ticket :ticketId.",
        'user_new_ticket_message_created' => "The user replied to ticket :ticketId.",
        // user announcements
        'admin_replied_to_ticket' => "A reply has been sent for ticket :ticketId.",
        'sms_rejected' => "SMS :smsId was rejected. Please review and correct it.",
        'identify_verification_accepted' => "Your identity documents have been approved and your panel is now active.",
        'identify_verification_rejected' => "Your identity documents were rejected. Please review and fix the issues.",

        'metadata' => [
            // admin announcements
            'admin_notice' => 'Created by :adminName (:adminId)',
            'user_verification_completed' => 'User: :userName (:userId)',
            'user_new_ticket_created' => 'User: :userName (:userId)',
            'user_new_ticket_message_created' => 'User: :userName (:userId)',
        ],

        // admin announcements
        'Admin Notice' => "Admin Notice",
        'User Verification Completed' => "KYC",
        'User New Ticket Created' => "New Ticket",
        'User New Ticket Message Created' => "Response To Ticket",
        // user announcements
        'Admin Replied To Ticket' => "Support Ticket",
        'SMS Campaign Rejected' => "SMS Rejected",
        'Identity Verification Accepted' => "KYC Accepted",
        'Identity Verification Rejected' => "KYC Rejected",

        'default' => "User activity detected.\nUser ID: :userId",
    ],
];
