<?php

namespace App\Infrastructures\sms;

use App\Infrastructures\sms\contracts\SmsSenderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MaxSms implements SmsSenderInterface
{
    private string $apiKey;

    private string $baseUrl;

    /**
     * @inheritDoc
     */
    public function setConfigs(): void
    {
        $this->apiKey = config('sms.max-sms.api-key');
        $this->baseUrl = config('sms.max-sms.baseUrl');
    }


    /**
     * @inheritDoc
     */
    public function send(string $phone, string $pattern, string $headNumber, array $extra): void
    {
        try {
            $response = Http::async()
                ->timeout(600)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "bearer " . $this->apiKey,
                ])
                ->post(
                    url: $this->baseUrl . '/api/v1/sms/pattern',
                    data: [
                        'pattern' => $pattern,
                        'variables' => $extra,
                        'recipient' => $phone,
                        'sourceNumber' => $headNumber,
                    ]
                )->wait();

            $response->throw();


        } catch (\Throwable $th) {
            Log::error(
                message: 'can not send max sms',
                context: [
                    'message' => $th->getMessage(),
                ]
            );
        }
    }
}
