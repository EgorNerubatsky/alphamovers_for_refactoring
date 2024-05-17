<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 *
 * @OA\Post(
 *     path="/api/leads",
 *     summary="Создание",
 *     tags={"Leads"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="company", type="string", example="Some company"),
 *                     @OA\Property(property="fullname", type="string", example="Данило Галицький"),
 *                     @OA\Property(property="phone", type="string", example="+380964545678"),
 *                     @OA\Property(property="email", type="string", example="example@mail.com"),
 *                     @OA\Property(property="comment", type="string", example="Some comment"),
 *                     @OA\Property(property="status", type="string", example="новий"),
 *
 *
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
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="company", type="string", example="Some company"),
 *                 @OA\Property(property="fullname", type="string", example="Данило Галицький"),
 *                 @OA\Property(property="phone", type="string", example="+380964545678"),
 *                 @OA\Property(property="email", type="string", example="example@mail.com"),
 *                 @OA\Property(property="comment", type="string", example="Some comment"),
 *                 @OA\Property(property="status", type="string", example="новий"),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Get(
 *     path="/api/leads",
 *     summary="Список",
 *     tags={"Leads"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="company", type="string", example="Some company"),
 *                 @OA\Property(property="fullname", type="string", example="Данило Галицький"),
 *                 @OA\Property(property="phone", type="string", example="+380964545678"),
 *                 @OA\Property(property="email", type="string", example="example@mail.com"),
 *                 @OA\Property(property="comment", type="string", example="Some comment"),
 *                 @OA\Property(property="status", type="string", example="новий"),
 *              )),
 *          ),
 *     ),
 * ),
 *
 * @OA\Get(
 *        path="/api/leads/{lead}",
 *        summary="Единичная запись",
 *        tags={"Leads"},
 *        security={{ "bearerAuth": {} }},
 *
 *        @OA\Parameter(
 *            description="ID лида",
 *            in="path",
 *            name="lead",
 *            required=true,
 *            example=1,
 *        ),
 *        @OA\Response(
 *            response=200,
 *            description="OK",
 *            @OA\JsonContent(
 *               @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="company", type="string", example="Some company"),
 *                  @OA\Property(property="fullname", type="string", example="Данило Галицький"),
 *                  @OA\Property(property="phone", type="string", example="+380964545678"),
 *                  @OA\Property(property="email", type="string", example="example@mail.com"),
 *                  @OA\Property(property="comment", type="string", example="Some comment"),
 *                  @OA\Property(property="status", type="string", example="новий"),
 *               ),
 *            ),
 *        ),
 *    ),
 *
 *
 * @OA\Patch(
 *         path="/api/leads/{lead}",
 *         summary="Обновление",
 *         tags={"Leads"},
 *         security={{ "bearerAuth": {} }},
 *
 *         @OA\Parameter(
 *             description="ID лида",
 *             in="path",
 *             name="lead",
 *             required=true,
 *             example=2,
 *         ),
 *
 *         @OA\RequestBody(
 *             @OA\JsonContent(
 *                 allOf={
 *                     @OA\Schema(
 *                         @OA\Property(property="company", type="string", example="Some company"),
 *                         @OA\Property(property="fullname", type="string", example="Данило Галицький"),
 *                         @OA\Property(property="phone", type="string", example="+380964545678"),
 *                         @OA\Property(property="email", type="string", example="example@mail.com"),
 *                         @OA\Property(property="comment", type="string", example="Some comment"),
 *                         @OA\Property(property="status", type="string", example="новий"),
 *                     )
 *                 }
 *             )
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="OK",
 *             @OA\JsonContent(
 *                @OA\Property(property="data", type="object",
 *                    @OA\Property(property="id", type="integer", example=1),
 *                    @OA\Property(property="company", type="string", example="Some company"),
 *                    @OA\Property(property="fullname", type="string", example="Данило Галицький"),
 *                    @OA\Property(property="phone", type="string", example="+380964545678"),
 *                    @OA\Property(property="email", type="string", example="example@mail.com"),
 *                    @OA\Property(property="comment", type="string", example="Some comment"),
 *                    @OA\Property(property="status", type="string", example="новий"),
 *                ),
 *             ),
 *         ),
 *     ),
 *
 * @OA\Delete(
 *         path="/api/leads/{lead}",
 *         summary="Удаление",
 *         tags={"Leads"},
 *        security={{ "bearerAuth": {} }},
 *
 *         @OA\Parameter(
 *             description="ID лида",
 *             in="path",
 *             name="lead",
 *             required=true,
 *             example=1,
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="OK",
 *             @OA\JsonContent(
 *                @OA\Property(property="message", type="string",example="done"),
 *             ),
 *         ),
 *     ),
 */
class LeadController extends Controller
{


}
