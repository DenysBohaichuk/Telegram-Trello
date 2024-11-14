<?php

namespace App\Services\Telegram;

use Telegram\Bot\Objects\Update;
use Telegram\Bot\Api;

class TelegramService
{
    protected BotStateService $botStateService;
    protected MessageService $messageService;

    public function __construct(BotStateService $botStateService, MessageService $messageService)
    {
        $this->botStateService = $botStateService;
        $this->messageService = $messageService;
    }

    public function handleUpdate(Update $update, Api $bot, string $botName): void
    {

        if ($update->getMessage() && $update->getMessage()->has('text')) {
            $message = $update->getMessage();
            $text = $message->getText();
            $chatId = $message->getChat()->getId();

            if ($text === 'Start') {
                $this->botStateService->startBot($update, $bot, $botName);
            } elseif ($text === 'Stop') {
                $this->botStateService->stopBot($update, $bot, $botName);
            } elseif ($text !== '/start' && $text !== '/stop') {
                $this->messageService->sendMessage($chatId, 'Будь ласка, використовуйте кнопки для активації або вимкнення бота.', $bot);
            }
        }
    }
}
