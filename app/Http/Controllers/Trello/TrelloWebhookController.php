<?php

namespace App\Http\Controllers\Trello;


use App\Http\Controllers\Controller;
use App\Services\Trello\ChatService;
use App\Services\Trello\TelegramService;
use App\Services\Trello\TrelloCardService;
use Illuminate\Http\Request;

class TrelloWebhookController extends Controller
{

    protected mixed $botName;
    protected TelegramService $telegramService;
    protected ChatService $chatService;
    protected TrelloCardService $trelloCardService;

    public function __construct(TelegramService $telegramService, ChatService $chatService, TrelloCardService $trelloCardService)
    {
        $this->telegramService = $telegramService;
        $this->chatService = $chatService;
        $this->trelloCardService = $trelloCardService;
        $this->botName = env('TELEGRAM_TRELLO_BOT_NAME');
    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        $message = $this->trelloCardService->checkCardMovement($data);

        if ($message) {
            $chatIds = $this->chatService->getAllChatIdsByBotName($this->botName);

            foreach ($chatIds as $chatId) {
                $this->telegramService->sendMessage($chatId, $message);
            }
        }

    }

}
