<?php

namespace App\Modules\openAi\service;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


class OpenAiImageDetectionService extends OpenAiService
{
    public function detectObject($url)
    {
        $client = new Client();
        $openaiUrl = self::GPT4_URL;
        $language = 'en';

        $response = $client->post($openaiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('OPEN_AI_KEY'),
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
                                'text' => 'You are an advanced assistant for recognizing objects in a photo. You recognize the main object in the photo and write what it is... detailed instructions ...',
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => ['url' => $url],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $format = [
            'label' => 'label name',
            'didYouKnow' => " didYouKnow name",
            'price' => "price name",
            'description' => "description name",
            'facts' => "facts name",
            'specifications' => "specifications name",
            'performance' => "performance name",
            'interior' => "interior name",
            'exterior' => "exterior name",
        ];
        $format = json_encode($format);
        $responseBody = json_decode($response->getBody(), true);
        $recognizedObject = $responseBody['choices'][0]['message']['content'];
        $secondResponse = $client->post($openaiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('OPEN_AI_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Provide information about $recognizedObject and give me the format in following array: $format, use 2-3 centences for didyounkow, description,  specifications, for facts format should be following, if it is macboomk air: facts:Display: 13.3 inches,Resolution: 2560 x 1600,Processor: apple m1 chip and so on and show currency for price make it so that it should be easy to json_Decode in php, do for example lavel:bugatti, did you know: fact and price:300, return only array and no more words",
                    ],
                ],
            ],
        ]);

        $secondResponseBody = json_decode($secondResponse->getBody(), true);
        $results = $secondResponseBody['choices'][0]['message']['content'];


        $cleanJsonString = str_replace(['```json', '```'], '', $results);

        $payload = json_decode($cleanJsonString,true);
//        unset($payload);
        return $payload;
    }

}
