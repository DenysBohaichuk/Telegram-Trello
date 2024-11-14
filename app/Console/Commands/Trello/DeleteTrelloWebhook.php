<?php

namespace App\Console\Commands\Trello;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DeleteTrelloWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:webhook:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a registered Trello Webhook';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = env('TRELLO_API_KEY');
        $token = env('TRELLO_TOKEN');

        if (!$apiKey || !$token) {
            $this->error('Missing Trello configuration in .env file');
            return 1;
        }

        $response = Http::get("https://api.trello.com/1/tokens/{$token}/webhooks", [
            'key' => $apiKey,
        ]);

        if (!$response->successful()) {
            $this->error('Failed to retrieve webhooks.');
            $this->error('Trello API response: ' . $response->body());
            return 1;
        }

        $webhooks = $response->json();

        if (empty($webhooks)) {
            $this->info("No webhooks registered.");
            return 0;
        }

        // 2. Виводимо список вебхуків
        $this->info("Registered Trello Webhooks:");
        foreach ($webhooks as $index => $webhook) {
            $this->info("[{$index}] Webhook ID: {$webhook['id']}");
            $this->info("    Description: {$webhook['description']}");
            $this->info("    Callback URL: {$webhook['callbackURL']}");
            $this->info("-------------------------");
        }

        $choice = $this->ask("Enter the index of the webhook to delete");

        if (!isset($webhooks[$choice])) {
            $this->error("Invalid choice. Exiting.");
            return 1;
        }

        $webhookId = $webhooks[$choice]['id'];

        $deleteResponse = Http::delete("https://api.trello.com/1/webhooks/{$webhookId}", [
            'key' => $apiKey,
            'token' => $token,
        ]);

        if ($deleteResponse->successful()) {
            $this->info("Webhook with ID {$webhookId} successfully deleted!");
        } else {
            $this->error("Failed to delete webhook with ID {$webhookId}.");
            $this->error('Trello API response: ' . $deleteResponse->body());
        }

        return 0;
    }
}
