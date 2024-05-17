<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 *
 * @OA\Post(
 *     path="/api/orders",
 *     summary="Создание",
 *     tags={"Orders"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="client", type="integer", example=3),
 *                     @OA\Property(property="execution_date_date", type="dateTime", example="2024-05-20"),
 *                     @OA\Property(property="execution_date_time", type="dateTime", example="03:29:47"),
 *                     @OA\Property(property="review", type="text", example="Ratione commodi repellendus quibusdam "),
 *                     @OA\Property(property="order_source", type="string", example="ОЛХ"),
 *                     @OA\Property(property="payment_form", type="string", example="Юридична особа (безготівковий розрахунок)"),
 *                     @OA\Property(property="number_of_workers", type="integer", example=11),
 *                     @OA\Property(property="city", type="string", example="Львів"),
 *                     @OA\Property(property="street", type="string", example="Вулиця 3"),
 *                     @OA\Property(property="house", type="string", example="23г"),
 *                     @OA\Property(property="service_type", type="string", example="Прибирання будівельного сміття"),
 *                     @OA\Property(property="task_description", type="text", example="Термiнове виконання"),
 *                     @OA\Property(property="straps", type="boolean", example=false),
 *                     @OA\Property(property="tools", type="boolean", example=false),
 *                     @OA\Property(property="respirators", type="boolean", example=true),
 *                     @OA\Property(property="transport", type="string", example="Легкова 1"),
 *                     @OA\Property(property="order_hrs", type="decimal", example=200.50),
 *                     @OA\Property(property="price_to_customer", type="decimal", example=200.50),
 *                     @OA\Property(property="price_to_workers", type="decimal", example=200.50),
 *                     @OA\Property(property="min_order_amount", type="decimal", example=200.50),
 *                     @OA\Property(property="min_order_hrs", type="decimal", example=200.50),
 *                     @OA\Property(property="total_price", type="decimal", example=200.50),
 *                     @OA\Property(property="payment_note", type="string", example="Предоплату внесено"),
 *                     @OA\Property(property="user_manager_id", type="integer", example=4),
 *                     @OA\Property(property="user_logist_id", type="integer", example=5),
 *                     @OA\Property(property="user_brigadier_id", type="integer", example=6),
 *                     @OA\Property(property="status", type="string", example="Попереднє замовлення"),
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
 *                 @OA\Property(property="client_id", type="integer", example=3),
 *                 @OA\Property(property="execution_date", type="dateTime", example="2024-05-20 03:29:47"),
 *                 @OA\Property(property="review", type="text", example="Ratione commodi repellendus quibusdam "),
 *                 @OA\Property(property="order_source", type="string", example="ОЛХ"),
 *                 @OA\Property(property="payment_form", type="string", example="Юридична особа (безготівковий розрахунок)"),
 *                 @OA\Property(property="number_of_workers", type="integer", example=11),
 *                 @OA\Property(property="city", type="string", example="Львів"),
 *                 @OA\Property(property="street", type="string", example="Вулиця 3"),
 *                 @OA\Property(property="house", type="string", example="23г"),
 *                 @OA\Property(property="service_type", type="string", example="Прибирання будівельного сміття"),
 *                 @OA\Property(property="task_description", type="text", example="Термiнове виконання"),
 *                 @OA\Property(property="straps", type="boolean", example=false),
 *                 @OA\Property(property="tools", type="boolean", example=false),
 *                 @OA\Property(property="respirators", type="boolean", example=true),
 *                 @OA\Property(property="transport", type="string", example="Легкова 1"),
 *                 @OA\Property(property="order_hrs", type="decimal", example=200.50),
 *                 @OA\Property(property="price_to_customer", type="decimal", example=200.50),
 *                 @OA\Property(property="price_to_workers", type="decimal", example=200.50),
 *                 @OA\Property(property="min_order_amount", type="decimal", example=200.50),
 *                 @OA\Property(property="min_order_hrs", type="decimal", example=200.50),
 *                 @OA\Property(property="total_price", type="decimal", example=200.50),
 *                 @OA\Property(property="payment_note", type="string", example="Предоплату внесено"),
 *                 @OA\Property(property="user_manager_id", type="integer", example=4),
 *                 @OA\Property(property="user_logist_id", type="integer", example=5),
 *                 @OA\Property(property="user_brigadier_id", type="integer", example=6),
 *                 @OA\Property(property="status", type="string", example="Попереднє замовлення"),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Get(
 *     path="/api/orders",
 *     summary="Список",
 *     tags={"Orders"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="client_id", type="integer", example=3),
 *                 @OA\Property(property="execution_date", type="dateTime", example="2024-05-20 03:29:47"),
 *                 @OA\Property(property="review", type="text", example="Ratione commodi repellendus quibusdam "),
 *                 @OA\Property(property="order_source", type="string", example="ОЛХ"),
 *                 @OA\Property(property="payment_form", type="string", example="Юридична особа (безготівковий розрахунок)"),
 *                 @OA\Property(property="number_of_workers", type="integer", example=11),
 *                 @OA\Property(property="city", type="string", example="Львів"),
 *                 @OA\Property(property="street", type="string", example="Вулиця 3"),
 *                 @OA\Property(property="house", type="string", example="23г"),
 *                 @OA\Property(property="service_type", type="string", example="Прибирання будівельного сміття"),
 *                 @OA\Property(property="task_description", type="text", example="Термiнове виконання"),
 *                 @OA\Property(property="straps", type="boolean", example=false),
 *                 @OA\Property(property="tools", type="boolean", example=false),
 *                 @OA\Property(property="respirators", type="boolean", example=true),
 *                 @OA\Property(property="transport", type="string", example="Легкова 1"),
 *                 @OA\Property(property="order_hrs", type="decimal", example=200.50),
 *                 @OA\Property(property="price_to_customer", type="decimal", example=200.50),
 *                 @OA\Property(property="price_to_workers", type="decimal", example=200.50),
 *                 @OA\Property(property="min_order_amount", type="decimal", example=200.50),
 *                 @OA\Property(property="min_order_hrs", type="decimal", example=200.50),
 *                 @OA\Property(property="total_price", type="decimal", example=200.50),
 *                 @OA\Property(property="payment_note", type="string", example="Предоплату внесено"),
 *                 @OA\Property(property="user_manager_id", type="integer", example=4),
 *                 @OA\Property(property="user_logist_id", type="integer", example=5),
 *                 @OA\Property(property="user_brigadier_id", type="integer", example=6),
 *                 @OA\Property(property="status", type="string", example="Попереднє замовлення"),
 *              )),
 *          ),
 *     ),
 * ),
 *
 * @OA\Get(
 *        path="/api/orders/{order}",
 *        summary="Единичная запись",
 *        tags={"Orders"},
 *        security={{ "bearerAuth": {} }},
 *
 *        @OA\Parameter(
 *            description="ID лида",
 *            in="path",
 *            name="order",
 *            required=true,
 *            example=1,
 *        ),
 *        @OA\Response(
 *            response=200,
 *            description="OK",
 *            @OA\JsonContent(
 *               @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="client_id", type="integer", example=3),
 *                  @OA\Property(property="execution_date", type="dateTime", example="2024-05-20 03:29:47"),
 *                  @OA\Property(property="review", type="text", example="Ratione commodi repellendus quibusdam "),
 *                  @OA\Property(property="order_source", type="string", example="ОЛХ"),
 *                  @OA\Property(property="payment_form", type="string", example="Юридична особа (безготівковий розрахунок)"),
 *                  @OA\Property(property="number_of_workers", type="integer", example=11),
 *                  @OA\Property(property="city", type="string", example="Львів"),
 *                  @OA\Property(property="street", type="string", example="Вулиця 3"),
 *                  @OA\Property(property="house", type="string", example="23г"),
 *                  @OA\Property(property="service_type", type="string", example="Прибирання будівельного сміття"),
 *                  @OA\Property(property="task_description", type="text", example="Термiнове виконання"),
 *                  @OA\Property(property="straps", type="boolean", example=false),
 *                  @OA\Property(property="tools", type="boolean", example=false),
 *                  @OA\Property(property="respirators", type="boolean", example=true),
 *                  @OA\Property(property="transport", type="string", example="Легкова 1"),
 *                  @OA\Property(property="order_hrs", type="decimal", example=200.50),
 *                  @OA\Property(property="price_to_customer", type="decimal", example=200.50),
 *                  @OA\Property(property="price_to_workers", type="decimal", example=200.50),
 *                  @OA\Property(property="min_order_amount", type="decimal", example=200.50),
 *                  @OA\Property(property="min_order_hrs", type="decimal", example=200.50),
 *                  @OA\Property(property="total_price", type="decimal", example=200.50),
 *                  @OA\Property(property="payment_note", type="string", example="Предоплату внесено"),
 *                  @OA\Property(property="user_manager_id", type="integer", example=4),
 *                  @OA\Property(property="user_logist_id", type="integer", example=5),
 *                  @OA\Property(property="user_brigadier_id", type="integer", example=6),
 *                  @OA\Property(property="status", type="string", example="Попереднє замовлення"),
 *               ),
 *            ),
 *        ),
 *    ),
 *
 *
 * @OA\Patch(
 *         path="/api/orders/{order}",
 *         summary="Обновление",
 *         tags={"Orders"},
 *         security={{ "bearerAuth": {} }},
 *
 *         @OA\Parameter(
 *             description="ID замовлення",
 *             in="path",
 *             name="order",
 *             required=true,
 *             example=2,
 *         ),
 *
 *         @OA\RequestBody(
 *             @OA\JsonContent(
 *                 allOf={
 *                     @OA\Schema(
 *                          @OA\Property(property="execution_date", type="dateTime", example="2024-05-20 03:29:47"),
 *                          @OA\Property(property="review", type="text", example="Ratione commodi repellendus quibusdam "),
 *                          @OA\Property(property="order_source", type="string", example="ОЛХ"),
 *                          @OA\Property(property="payment_form", type="string", example="Юридична особа (безготівковий розрахунок)"),
 *                          @OA\Property(property="number_of_workers", type="integer", example=11),
 *                          @OA\Property(property="city", type="string", example="Львів"),
 *                          @OA\Property(property="street", type="string", example="Вулиця 3"),
 *                          @OA\Property(property="house", type="string", example="23г"),
 *                          @OA\Property(property="service_type", type="string", example="Прибирання будівельного сміття"),
 *                          @OA\Property(property="task_description", type="text", example="Термiнове виконання"),
 *                          @OA\Property(property="straps", type="boolean", example=false),
 *                          @OA\Property(property="tools", type="boolean", example=false),
 *                          @OA\Property(property="respirators", type="boolean", example=true),
 *                          @OA\Property(property="transport", type="string", example="Легкова 1"),
 *                          @OA\Property(property="order_hrs", type="decimal", example=200.50),
 *                          @OA\Property(property="price_to_customer", type="decimal", example=200.50),
 *                          @OA\Property(property="price_to_workers", type="decimal", example=200.50),
 *                          @OA\Property(property="min_order_amount", type="decimal", example=200.50),
 *                          @OA\Property(property="min_order_hrs", type="decimal", example=200.50),
 *                          @OA\Property(property="total_price", type="decimal", example=200.50),
 *                          @OA\Property(property="payment_note", type="string", example="Предоплату внесено"),
 *                          @OA\Property(property="user_manager_id", type="integer", example=4),
 *                          @OA\Property(property="user_logist_id", type="integer", example=5),
 *                          @OA\Property(property="user_brigadier_id", type="integer", example=6),
 *                          @OA\Property(property="status", type="string", example="Попереднє замовлення"),
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
 *                    @OA\Property(property="client_id", type="integer", example=3),
 *                    @OA\Property(property="execution_date", type="dateTime", example="2024-05-20 03:29:47"),
 *                    @OA\Property(property="review", type="text", example="Ratione commodi repellendus quibusdam "),
 *                    @OA\Property(property="order_source", type="string", example="ОЛХ"),
 *                    @OA\Property(property="payment_form", type="string", example="Юридична особа (безготівковий розрахунок)"),
 *                    @OA\Property(property="number_of_workers", type="integer", example=11),
 *                    @OA\Property(property="city", type="string", example="Львів"),
 *                    @OA\Property(property="street", type="string", example="Вулиця 3"),
 *                    @OA\Property(property="house", type="string", example="23г"),
 *                    @OA\Property(property="service_type", type="string", example="Прибирання будівельного сміття"),
 *                    @OA\Property(property="task_description", type="text", example="Термiнове виконання"),
 *                    @OA\Property(property="straps", type="boolean", example=false),
 *                    @OA\Property(property="tools", type="boolean", example=false),
 *                    @OA\Property(property="respirators", type="boolean", example=true),
 *                    @OA\Property(property="transport", type="string", example="Легкова 1"),
 *                    @OA\Property(property="order_hrs", type="decimal", example=200.50),
 *                    @OA\Property(property="price_to_customer", type="decimal", example=200.50),
 *                    @OA\Property(property="price_to_workers", type="decimal", example=200.50),
 *                    @OA\Property(property="min_order_amount", type="decimal", example=200.50),
 *                    @OA\Property(property="min_order_hrs", type="decimal", example=200.50),
 *                    @OA\Property(property="total_price", type="decimal", example=200.50),
 *                    @OA\Property(property="payment_note", type="string", example="Предоплату внесено"),
 *                    @OA\Property(property="user_manager_id", type="integer", example=4),
 *                    @OA\Property(property="user_logist_id", type="integer", example=5),
 *                    @OA\Property(property="user_brigadier_id", type="integer", example=6),
 *                    @OA\Property(property="status", type="string", example="Попереднє замовлення"),
 *                ),
 *             ),
 *         ),
 *     ),
 *
 * @OA\Delete(
 *         path="/api/orders/{order}",
 *         summary="Удаление",
 *         tags={"Orders"},
 *        security={{ "bearerAuth": {} }},
 *
 *         @OA\Parameter(
 *             description="ID замовлення",
 *             in="path",
 *             name="order",
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
 *
 *
 * @OA\Post(
 *          path="/api/orders/edit/addFiles/{id}",
 *          summary="Добавить файлы к заказу",
 *          tags={"Orders"},
 *          security={{ "bearerAuth": {} }},
 *
 *          @OA\Parameter(
 *              description="ID заказа",
 *              in="path",
 *              name="id",
 *              required=true,
 *              example=1,
 *          ),
 *          @OA\RequestBody(
 *              description="Файлы, которые нужно добавить",
 *              required=true,
 *              @OA\MediaType(
 *                  mediaType="multipart/form-data",
 *                  @OA\Schema(
 *                      @OA\Property(
 *                          property="deed_file",
 *                          type="file",
 *                          format="binary",
 *                      ),
 *                      required={"deed_file"},
 *
 *                  )
 *              )
 *          ),
 *          @OA\Response(
 *              response=200,
 *              description="OK",
 *              @OA\JsonContent(
 *                  type="object",
 *                  @OA\Property(property="message", type="string", example="Файлы успешно добавлены."),
 *                  @OA\Property(property="order_id", type="integer", example=1),
 *                  @OA\Property(property="client_id", type="integer", example=2),
 *                  @OA\Property(property="path", type="string", example="/path/files"),
 *                  @OA\Property(property="description", type="string", example="Договiр"),
 *                  @OA\Property(property="status", type="string", example="Завантажено"),
 *              )
 *          ),
 *          @OA\Response(
 *              response=400,
 *              description="Bad Request",
 *              @OA\JsonContent(
 *                  type="object",
 *                  @OA\Property(property="error", type="string", example="Произошла ошибка при добавлении файлов.")
 *              )
 *          )
 *      )
 *
 */
class OrderController extends Controller
{


}
