<?php

namespace App\Services\Telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class GreetingService
{
    protected MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function greetUser(int $chatId, Api $bot, Update $update): void
    {
        $firstName = $this->getUserFirstName($update);
        $message = $this->createGreetingMessage($firstName);
        $this->messageService->sendMessage($chatId, $message, $bot);
    }

    protected function createGreetingMessage(string $firstName): string
    {
        return "Привіт, $firstName! Дякую, що активували бота!";
    }

    protected function getUserFirstName(Update $update): string
    {
        return $update->getMessage()->getFrom()->getFirstName() ?? 'користувач';
    }
}
