<?php

namespace App\Services\Trello;

use App\Models\Base\TelegramChat;

class ChatService
{
    public function getAllChatIdsByBotName($botName)
    {
        return TelegramChat::where('bot_name', $botName)->pluck('chat_id')->all();
    }
}
