<?php

use App\Commons\Types\KeyValueType;
use App\Infrastructures\sms\enums\SendSmsEnum;
use App\Infrastructures\sms\SmsSender;
use Carbon\Carbon;

if (!function_exists('versioned_assets')) {
    function versioned_assets(string $file): string
    {
        $filePath = public_path($file);
        $version = file_exists($filePath) ? filemtime($filePath) : '';

        return asset($file) . '?v=' . $version;
    }
}

if (! function_exists('key_value_type_object')) {
    function key_value_type_object(
        mixed $title,
        mixed $value,
        mixed $other = null,
    ): KeyValueType {
        return new KeyValueType(
            title: $title,
            value: $value,
            other: $other
        );
    }
}

if (!function_exists('convert_carbon_to_jalali')) {
    function convert_carbon_to_jalali(Carbon $date, string $timeZone = 'Asia/Tehran'): string
    {
        return (new \Hekmatinasser\Verta\Verta($date))
            ->setTimezone(new DateTimeZone($timeZone))
            ->format('Y/m/d');
    }
}

if (!function_exists('send_sms_with_Max_sms'))
{
    /**
     * @param array<string, mixed> $extra
     */
    function send_sms_with_Max_sms(string $pattern, string $phone, array $extra, string $headNumber = '10002'): void
    {
        SmsSender::send(
            provider: SendSmsEnum::MAX_SMS,
            phone: $phone,
            pattern: $pattern,
            headNumber: $headNumber,
            extra: $extra
        );
    }
}
