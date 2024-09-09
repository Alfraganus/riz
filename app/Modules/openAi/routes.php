<?php

use App\Modules\openAi\controllers\OpenAIController;
use Illuminate\Support\Facades\Route;


Route::post('/get-gpt-advice', [OpenAiController::class, 'gptAdvice']);
