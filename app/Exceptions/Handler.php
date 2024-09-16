<?php

namespace App\Exceptions;

use App\Services\TelegramService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);

        try {
            if (env('TELEGRAM_BOT_TOKEN')) {
                $telegramService = app(TelegramService::class);

                $title = 'Riz project';
                $content = sprintf(
                    "Exception: %s\nFile: %s\nLine: %d\nMessage: %s",
                    get_class($exception),
                    $exception->getFile(),
                    $exception->getLine(),
                    $exception->getMessage()
                );

                // Try sending the error message to Telegram
                $telegramService->sendErrorMessage($title, $content);
            } else {
                Log::warning('TELEGRAM_BOT_TOKEN not set in .env');
            }
        } catch (Throwable $telegramException) {
            Log::error('Failed to send error message to Telegram: ' . $telegramException->getMessage());
        }
    }

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
