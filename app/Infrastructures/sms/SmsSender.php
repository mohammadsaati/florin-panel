<?php

namespace App\Infrastructures\sms;

use App\Infrastructures\sms\contracts\SmsSenderInterface;
use App\Infrastructures\sms\enums\SendSmsEnum;

class SmsSender
{
    /**
     * @param array<string, mixed> $extra
     */
    public static function send(
        SendSmsEnum $provider,
        string $phone,
        string $pattern,
        string $headNumber,
        array $extra
    ) : void
    {
        $builder = self::getProvider($provider);

        $builder->setConfigs();
        $builder->send(
            phone: $phone,
            pattern: $pattern,
            headNumber: $headNumber,
            extra: $extra
        );
    }


    private static function getProvider(SendSmsEnum $provider): SmsSenderInterface
    {
        return match ($provider) {
            SendSmsEnum::MAX_SMS => new MaxSms()
        };
    }
}
