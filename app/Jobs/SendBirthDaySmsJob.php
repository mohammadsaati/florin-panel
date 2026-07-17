<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendBirthDaySmsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $fullName,
        public string $phone,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        send_sms_with_Max_sms(
            pattern: 'florin-birthday',
            phone: $this->phone,
            extra: [
                'name' => $this->fullName,
            ],
            headNumber: '10001'
        );
    }
}
