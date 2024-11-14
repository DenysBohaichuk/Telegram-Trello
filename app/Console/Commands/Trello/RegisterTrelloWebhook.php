<?php

namespace App\Console\Commands\Trello;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RegisterTrelloWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:webhook:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers a webhook with Trello and allows selecting a board';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = env('TRELLO_API_KEY');
        $token = env('TRELLO_TOKEN');
        $webhookUrl = env('TRELLO_WEBHOOK_URL');

        if (!$apiKey || !$token || !$webhookUrl) {
            $this->error('Missing Trello configuration in .env file');
            return 1;
        }

        $boardsResponse = Http::get("https://api.trello.com/1/members/me/boards", [
            'key' => $apiKey,
            'token' => $token,
        ]);

        if (!$boardsResponse->successful()) {
            $this->error('Failed to retrieve Trello boards.');
            $this->error('Trello API response: ' . $boardsResponse->body());
            return 1;
        }

        $boards = $boardsResponse->json();

        if (empty($boards)) {
            $this->info("No boards available.");
            return 0;
        }

        $this->info("Available Trello Boards:");
        foreach ($boards as $index => $board) {
            $this->info("[{$index}] Board Name: {$board['name']}, ID: {$board['id']}");
        }

        $choice = $this->ask("Enter the index of the board to register a webhook for");

        if (!isset($boards[$choice])) {
            $this->error("Invalid choice. Exiting.");
            return 1;
        }

        $boardId = $boards[$choice]['id'];

        $response = Http::post("https://api.trello.com/1/tokens/{$token}/webhooks/", [
            'key' => $apiKey,
            'callbackURL' => $webhookUrl,
            'idModel' => $boardId,
            'description' => 'Track Card Movement',
        ]);

        if ($response->successful()) {
            $this->info("Webhook successfully registered for board '{$boards[$choice]['name']}' with Trello!");
        } else {
            $this->error('Failed to register Webhook.');
            $this->error('Trello API response: ' . $response->body());
        }

        return 0;
    }
}
