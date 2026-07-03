<?php

namespace App\Infrastructures\sms\contracts;

interface SmsSenderInterface
{
    /**
     * Set config
     */
    public function setConfigs(): void;

    /**
     * Send simple sms
     *
     * @param array<string, mixed> $extra
     */
    public function send(string $phone,string $pattern, string $headNumber, array $extra): void;
}
