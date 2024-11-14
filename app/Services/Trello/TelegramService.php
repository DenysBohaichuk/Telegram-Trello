<?php

namespace App\Services\Trello;

use Telegram\Bot\Api;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_TRELLO_BOT_TOKEN'));
    }

    public function sendMessage($chatId, $message): void
    {
        try {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } catch (\Exception $e) {
            Log::error("Помилка відправки повідомлення в чат {$chatId}: " . $e->getMessage());
        }
    }
}
