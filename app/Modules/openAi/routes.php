<?php

use App\Modules\openAi\controllers\OpenAIController;
use Illuminate\Support\Facades\Route;


Route::post('/upload-chat-screenshot', [\App\Modules\openAi\controllers\OpenAIController::class, 'processScreenshot']);
Route::post('/recognize-object', [OpenAiController::class, 'recognizeObject']);
