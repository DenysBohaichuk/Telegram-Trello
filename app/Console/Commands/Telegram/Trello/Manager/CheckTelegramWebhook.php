<?php

namespace App\Console\Commands\Telegram\Trello\Manager;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class CheckTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:check-trello-webhook';

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

        if (is_object($info) && !empty($info->url)) {
            $this->info("Webhook URL: " . ($info['url'] ?? 'URL not set'));
            $this->info("Pending updates: " . ($info['pending_update_count'] ?? 'N/A'));
            $this->info("Last error date: " . ($info['last_error_date'] ?? 'No errors'));
            $this->info("Last error message: " . ($info['last_error_message'] ?? 'No errors'));
        } else {
            $this->error("Помилка при отриманні інформації про вебхук");
            $this->error("Відповідь: " . json_encode($info));
        }

        return 0;
    }
}
