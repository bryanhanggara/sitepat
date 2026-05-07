<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function sendText(string $phone, string $message): void
    {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');
        if (!$token || !$phoneId || !$phone) {
            return; // gracefully no-op in local/dev
        }

        Http::withToken($token)->post("https://graph.facebook.com/v21.0/{$phoneId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'text',
            'text' => ['body' => $message],
        ])->throw();
    }
}


