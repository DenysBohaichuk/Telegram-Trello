<?php

namespace App\Console\Commands\Telegram\Trello\Manager;

use Illuminate\Console\Command;

class SetTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:set-trello-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the Telegram webhook URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $telegram = new \Telegram\Bot\Api(env('TELEGRAM_TRELLO_BOT_TOKEN'));

        $webhookUrl = env('TELEGRAM_TRELLO_WEBHOOK_URL');

        $response = $telegram->setWebhook(['url' => $webhookUrl]);

        if ($response) {
            $this->info("Webhook встановлено успішно на $webhookUrl");
        } else {
            $this->error("Помилка при встановленні вебхука");
        }

        return 0;
    }
}
