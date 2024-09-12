<?php
// app/Services/TelegramService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\SubscribedUser;

class TelegramService
{
    protected $signature = 'telegram:fetch-updates';
    protected $description = 'Fetch chat IDs of users who interacted with the bot';

    protected $botToken;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
    }

    public function sendMessage($message)
    {
        $subscribedUsers = SubscribedUser::all();

        foreach ($subscribedUsers as $user) {
            Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $user->chat_id,
                'text' => $message,
            ]);
        }
    }
}
