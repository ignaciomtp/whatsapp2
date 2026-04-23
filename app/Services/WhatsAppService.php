<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private string $token;
    private string $phoneNumberId;
    private string $apiVersion;
    private string $baseUrl;

    public function __construct()
    {
        $this->token = config('services.meta.whatsapp_token');
        $this->phoneNumberId = config('services.meta.phone_number_id');
        $this->apiVersion = config('services.meta.api_version', 'v21.0');
        $this->baseUrl = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages";

    }

    public function sendTextMessage(string $to, string $message): array
    {
        $response = Http::withToken($this->token)
            ->post($this->baseUrl, [
                'messaging_product' => 'whatsapp',
                'to' => $to, // Formato: 34612345678
                'type' => 'text',
                'text' => ['body' => $message],
            ]);


        return $response->json();
    }

    public function sendTemplate(string $to, string $templateName, string $languageCode = 'es'): array
    {
        $response = Http::withToken($this->token)
            ->post($this->baseUrl, [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => ['code' => $languageCode],
                ],
            ]);

        return $response->json();
    }
}