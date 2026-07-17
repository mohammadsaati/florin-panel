<?php

namespace App\Jobs\schedules;

use App\Services\Contracts\UserServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UserBirthdayScheduleJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(UserServiceInterface $userService): void
    {
        $userService->checkUsersBirthday();
    }
}
