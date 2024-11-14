<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\BotStateService;
use App\Services\Telegram\MessageService;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

abstract class AbstractStartCommand extends Command
{
    protected string $botName;


    protected BotStateService $botStateService;
    protected MessageService $messageService;

    public function __construct(BotStateService $botStateService, MessageService $messageService)
    {
        $this->botStateService = $botStateService;
        $this->messageService = $messageService;
    }

    abstract protected function executeCommand(Update $update, Api $bot): void;

    protected function buildKeyboard(): ?Keyboard
    {
        // Можна використовувати клавіатуру тільки якщо метод перевизначений
        return null;  // За замовчуванням клавіатура відсутня
    }
    public function handle()
    {
        $bot = Telegram::bot($this->botName);
        $update = $bot->getWebhookUpdate();

        $this->executeCommand($update, $bot);
    }
}
