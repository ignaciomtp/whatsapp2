<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;

class WhatsAppService
{
    private string $token;
    private string $phoneNumberId;
    private string $apiVersion;
    private string $baseUrl;

    private const ALLOWED_MIME_TYPES = [
        // Imágenes
        'image/jpeg',
        'image/png',
        'image/webp',
        // Audio
        'audio/aac',
        'audio/mpeg',
        'audio/ogg',
        // Video
        'video/mp4',
        'video/3gp',
        // Documentos
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain',
    ];

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
                'to'                => $to,
                'type'              => 'text',
                'text'              => ['body' => $message],
            ]);

        return $response->json();
    }

    public function sendTemplate(string $to, string $templateName, string $languageCode = 'es'): array
    {
        $response = Http::withToken($this->token)
            ->post($this->baseUrl, [
                'messaging_product' => 'whatsapp',
                'to'                => $to,
                'type'              => 'template',
                'template'          => [
                    'name'     => $templateName,
                    'language' => ['code' => $languageCode],
                ],
            ]);

        return $response->json();
    }

    /**
     * Sube un archivo multimedia a la API de WhatsApp.
     *
     * @param  string $filePath  Ruta absoluta al archivo local.
     * @param  string $mimeType  MIME type del archivo (e.g. 'image/jpeg').
     * @return array             Respuesta de la API, incluye 'id' del media subido.
     *
     * @throws InvalidArgumentException Si el archivo no existe o el MIME type no está permitido.
     * @throws RuntimeException         Si la subida falla en la API.
     */
    public function uploadMedia(string $filePath, string $mimeType): array
    {
        // — Validaciones previas —————————————————————————————————————————————

        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new InvalidArgumentException("El archivo no existe o no es legible: {$filePath}");
        }

        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            throw new InvalidArgumentException(
                "MIME type no permitido por WhatsApp: {$mimeType}. " .
                "Tipos válidos: " . implode(', ', self::ALLOWED_MIME_TYPES)
            );
        }

        // — Llamada a la API —————————————————————————————————————————————————

        $uploadUrl = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/media";

        $response = Http::withToken($this->token)
            ->attach(
                'file',                      // nombre del campo multipart
                file_get_contents($filePath),// contenido binario
                basename($filePath),         // nombre del archivo
                ['Content-Type' => $mimeType]
            )
            ->post($uploadUrl, [
                'messaging_product' => 'whatsapp',
                'type'              => $mimeType,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                "Error al subir el media: " . $response->body()
            );
        }

        // La respuesta incluye { "id": "MEDIA_ID" }
        return $response->json();
    }


    public function sendUploadedMedia(string $to, string $idMedia): array
    {
        $response = Http::withToken($this->token)->post($this->baseUrl, [
            'messaging_product' => 'whatsapp',
            'to'                => $to,
            'type'              => 'image',
            'image'             => ['id' => $idMedia],
        ]);

        return $response->json();
    }

}