<?php
namespace App\swagger;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is a sample API documentation.",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Post(
 *     path="/api/google-lens/get-results",
 *     summary="Send image to Google Lens",
 *     description="Uploads an image file to be processed by Google Lens.",
 *     tags={"Google Lens"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="image",
 *                     description="The image file to be processed",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response with results from Google Lens",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="result", type="string", description="Result of the Google Lens analysis")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request, e.g., if the file is missing or invalid"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server Error, if something goes wrong on the server side"
 *     )
 * )
 */
class GoogleLensSwagger {}

