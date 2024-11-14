<?php

namespace App\Console\Commands\Telegram\Trello;


use App\Console\Commands\Telegram\AbstractStopCommand;
use App\Services\Telegram\BotStateService;
use App\Services\Telegram\MessageService;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class StopCommand extends AbstractStopCommand
{
    protected string $botName;

    protected string $name = 'stop';
    protected string $description = 'Зупинка бота';

    public function __construct(BotStateService $botStateService, MessageService $messageService)
    {
        $this->botName = env('TELEGRAM_TRELLO_BOT_NAME');
        parent::__construct($botStateService, $messageService);
    }

    protected function executeCommand(Update $update, Api $bot): void
    {
        $this->botStateService->stopBot($update, $bot, $this->botName);
    }
}
