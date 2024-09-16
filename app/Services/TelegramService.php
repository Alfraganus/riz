<?php
namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $signature = 'telegram:fetch-updates';
    protected $description = 'Fetch chat IDs of users who interacted with the bot';

    protected $botToken;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
    }

    public function sendErrorMessage($title, $content)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $message = "🚨 *{$title}*\n\n{$content}";
        $chatIds = Config::get('chat.chat_ids', []);
        foreach ($chatIds as $chat_id) {

            Http::post("https://api.telegram.org/bot$botToken/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        }

    }
}
