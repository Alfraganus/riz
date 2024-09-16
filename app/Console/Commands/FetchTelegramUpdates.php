<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class FetchTelegramUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:fetch-updates';
    protected $description = 'Fetch chat IDs of users who interacted with the bot';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');

        $chatIds = Config::get('chat.chat_ids', []);
        foreach ($chatIds as $chat_id) {

            Http::post("https://api.telegram.org/bot$botToken/sendMessage", [
                'chat_id' => $chat_id,
                'text' => "Hello world",
            ]);
        }

        $this->info('Telegram updates fetched and subscribed users updated.');
    }
}
