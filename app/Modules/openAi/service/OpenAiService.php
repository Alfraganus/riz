<?php

namespace App\Modules\openAi\service;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OpenAiService
{
    const GPT4_URL = 'https://api.openai.com/v1/chat/completions';

    public function recognizeObject(Request $request)
    {
        /* $request->validate([ w
             'url' => 'required|url',
             'language' => 'nullable|string', // If language needs to be passed, you can extend this
         ]);*/

        $file = $request->file('image');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension(); // Generate a random filename

        $imagePath = $file->storeAs('images', $filename, 'public');
        $imageFullPath = storage_path('app/public/' . $imagePath);

        if (!File::exists($imageFullPath)) {
            return response()->json(['error' => 'Failed to save the uploaded image'], 500);
        }
        $imageUrl = asset('storage/' . $imagePath);

        $apiKey = getenv('OPEN_AI_KEY');
        $client = new Client();

        try {
            $response = $client->post(self::GPT4_URL, [
                'headers' => [
                    'Authorization' => "Bearer {$apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => "You are an advanced assistant for recognizing objects in a photo. You recognize the text in the image and analyze the text and you advise me what to respond to chat, you advice me the next message based on context of the text, and your responce should only contain with advice without your own addition, your advice should contain from 3-5 sentences",
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => $imageUrl,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            $apiResponse = json_decode($response->getBody(), true);

            $recognizedObject = $apiResponse['choices'][0]['message']['content'] ?? 'Unknown object';
            Storage::disk('public')->delete($imagePath);
            return response()->json([
                'result' => $recognizedObject
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to recognize object',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}
