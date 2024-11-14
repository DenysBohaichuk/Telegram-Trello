<?php

namespace App\Services\Telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class MessageService implements MessageServiceInterface
{
    public function sendMessage(int $chatId, string $message, Api $bot, Keyboard $replyMarkup = null): void
    {
        $bot->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
            'reply_markup' => $replyMarkup,
        ]);
    }
}
