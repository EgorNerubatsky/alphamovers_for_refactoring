<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 *
 * @OA\Post(
 *     path="/api/auth/login",
 *     summary="Создание Токена",
 *     tags={"1_Get_Token"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", example="executive@local.com"),
 *                     @OA\Property(property="password", type="integer", example=12345678),
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0Ojg4ODYvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MTQxNDE4MjcsImV4cCI6MTcxNDE0NTQyNywibmJmIjoxNzE0MTQxODI3LCJqdGkiOiJVSEUzVUFiUGx0c2RXbVF1Iiwic3ViIjoiNiIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.KUNH_5IrYpzzBVdo23Qsv7jo_-y7yd59N4v3VW_5psU"),
 *                 @OA\Property(property="token_type", type="string", example="bearer"),
 *                 @OA\Property(property="expires_in", type="integer", example=3600),
 *             ),
 *         ),
 *     ),
 * ),
 *
 *
 */

class AuthController extends Controller
{

}
