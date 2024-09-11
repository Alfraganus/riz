<?php
namespace App\swagger;

/**
 * @OA\Post(
 *     path="/api/get-detect-object",
 *     summary="Detect and recognize an object from an image using GPT-4",
 *     tags={"Google Lens"},
 *     description="This endpoint accepts an image URL and language as input, uses GPT-4 to recognize objects in the image, and returns detailed information about the object.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="url",
 *                 type="string",
 *                 description="The URL of the image to analyze",
 *                 example="https://example.com/image.jpg"
 *             ),
 *             @OA\Property(
 *                 property="language",
 *                 type="string",
 *                 description="The language in which the response should be returned",
 *                 example="en"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Object details retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="labels",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *                 description="The recognized object labels"
 *             ),
 *             @OA\Property(
 *                 property="did_you_know",
 *                 type="string",
 *                 description="Interesting facts about the recognized object"
 *             ),
 *             @OA\Property(
 *                 property="price",
 *                 type="string",
 *                 description="Price of the recognized object, if applicable"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 description="Description of the recognized object"
 *             ),
 *             @OA\Property(
 *                 property="facts",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *                 description="Additional facts about the recognized object"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

class OpenAIImageDetectionSwagger {}

