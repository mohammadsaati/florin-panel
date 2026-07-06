<?php

namespace App\Console\Commands;

use App\Services\Contracts\UserServiceInterface;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[Signature('user:birthday-sms')]
#[Description('Command description')]
#[AsCommand('user:birthday-sms')]
class UserBirthDaySmsCommand extends Command
{
    protected $signature = 'user:birthday-sms';
    /**
     * Execute the console command.
     */
    public function handle(UserServiceInterface $userService): void
    {
        $userService->checkUsersBirthday();
    }
}
