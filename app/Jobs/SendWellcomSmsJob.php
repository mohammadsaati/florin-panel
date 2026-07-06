<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendWellcomSmsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $fullName,
        public string $referralCode,
        public string $mobile,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        send_sms_with_Max_sms(
            pattern: 'florin-wellcom',
            phone: $this->mobile,
            extra: [
                'full_name' => $this->fullName,
                'referral_code' => $this->referralCode,
            ]
        );
    }
}
