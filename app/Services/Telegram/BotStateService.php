<?php

namespace App\Services\Telegram;

use App\Models\Base\TelegramChat;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

class BotStateService implements BotStateServiceInterface
{
    protected MessageService $messageService;
    protected GreetingService $greetingService;

    protected string $startBotButtonName = 'Start';
    protected string $stopBotButtonName = 'Stop';

    public function __construct(MessageService $messageService, GreetingService $greetingService)
    {
        $this->messageService = $messageService;
        $this->greetingService = $greetingService;
    }

    public function startBot(Update $update, Api $bot, string $botName, Keyboard $keyboard = null): void
    {
        $chatId = $this->getChatId($update);
        $keyboard = $keyboard ?? $this->getKeyboardWithButton($this->stopBotButtonName);

        if (!$this->chatExists($chatId, $botName)) {
            $this->greetingService->greetUser($chatId, $bot, $update);
            $this->activateBot($chatId, $botName, $bot, $keyboard);
        } else {
            $this->sendMessage($chatId, 'Бот вже активований!', $bot, $keyboard);
        }
    }

    public function stopBot(Update $update, Api $bot, string $botName): void
    {
        $chatId = $this->getChatId($update);
        $keyboard = $this->getKeyboardWithButton($this->startBotButtonName);

        if ($this->chatExists($chatId, $botName)) {
            $this->deactivateBot($chatId, $botName, $bot, $keyboard);
        } else {
            $this->sendMessage($chatId, 'Бот вже вимкнений.', $bot, $keyboard);
        }
    }

    protected function getKeyboardWithButton(string $buttonName): Keyboard
    {
        return Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(false)
            ->row([Keyboard::button($buttonName)]);
    }

    protected function activateBot($chatId, string $botName, Api $bot, Keyboard $keyboard): void
    {
        $this->saveChat($chatId, $botName);
        $this->messageService->sendMessage($chatId, 'Бот активований!', $bot, $keyboard);
    }

    protected function deactivateBot(int $chatId, string $botName, Api $bot, Keyboard $keyboard): void
    {
        $this->removeChat($chatId, $botName);
        $this->sendMessage($chatId, 'Бот вимкнений!', $bot, $keyboard);
    }

    public function saveChat(int $chatId, string $botName): void
    {
        TelegramChat::create([
            'chat_id' => $chatId,
            'bot_name' => $botName,
        ]);
    }

    public function removeChat(int $chatId, string $botName): void
    {
        TelegramChat::where('chat_id', $chatId)->where('bot_name', $botName)->delete();
    }

    public function chatExists(int $chatId, string $botName): bool
    {
        return TelegramChat::where('chat_id', $chatId)
            ->where('bot_name', $botName)
            ->exists();
    }

    protected function getChatId(Update $update): int
    {
        return $update->getMessage()->getChat()->getId();
    }

    protected function sendMessage(int $chatId, string $text, Api $bot, Keyboard $keyboard = null): void
    {
        $this->messageService->sendMessage($chatId, $text, $bot, $keyboard);
    }


}
