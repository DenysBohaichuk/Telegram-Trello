<?php

namespace App\Services\Telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

interface MessageServiceInterface
{
    public function sendMessage(int $chatId, string $message, Api $bot, Keyboard $replyMarkup = null): void;
}
