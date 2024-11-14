<?php

namespace App\Console\Commands\Telegram\Trello\Manager;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class DeleteTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:delete-trello-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $telegram = new Api(env('TELEGRAM_TRELLO_BOT_TOKEN'));

        $info = $telegram->deleteWebhook();

        if ($info) {
            $this->info("Webhook успішно видаленний");
        } else {
            $this->error("Помилка при видаленні вебхука");
        }

        return 0;
    }
}
