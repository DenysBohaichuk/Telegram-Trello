<?php

namespace App\Console\Commands\Telegram\Trello;

use App\Console\Commands\Telegram\AbstractStartCommand;
use App\Services\Telegram\BotStateService;
use App\Services\Telegram\MessageService;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class StartCommand extends AbstractStartCommand
{
    protected string $botName;
    protected string $name = 'start';
    protected string $description = 'Запуск бота';


    public function __construct(BotStateService $botStateService, MessageService $messageService)
    {
        $this->botName = env('TELEGRAM_TRELLO_BOT_NAME');
        parent::__construct($botStateService, $messageService);
    }

    protected function executeCommand(Update $update, Api $bot): void
    {
        $this->botStateService->startBot($update, $bot, $this->botName);
    }
}
