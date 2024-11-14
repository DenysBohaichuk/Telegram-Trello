<?php

namespace App\Services\Telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

interface BotStateServiceInterface
{
    public function startBot(Update $update, Api $bot, string $botName, Keyboard $keyboard): void;

    public function stopBot(Update $update, Api $bot, string $botName): void;

    public function saveChat(int $chatId, string $botName): void;

    public function removeChat(int $chatId, string $botName): void;

    public function chatExists(int $chatId, string $botName): bool;
}
