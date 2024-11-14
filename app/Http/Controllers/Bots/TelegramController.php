<?php

namespace App\Http\Controllers\Bots;


use App\Http\Controllers\Controller;
use App\Services\Telegram\TelegramService;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{

    protected TelegramService $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function webhookTrello()
    {
        $botName = env('TELEGRAM_TRELLO_BOT_NAME');

        $bot = Telegram::bot($botName);
        $bot->commandsHandler(true);
        $update = $bot->getWebhookUpdate();

        $this->telegramService->handleUpdate($update, $bot, $botName);
    }
}
