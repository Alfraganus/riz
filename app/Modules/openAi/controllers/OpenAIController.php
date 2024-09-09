<?php

namespace App\Modules\openAi\controllers;

use App\Modules\openAi\service\OpenAiService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class OpenAIController extends BaseController
{

    public function __construct(OpenAiService $openAiService)
    {
        $this->openAiService = $openAiService;
    }

    public function gptAdvice(Request $request)
    {
        return $this->openAiService->recognizeObject($request);
    }
}
