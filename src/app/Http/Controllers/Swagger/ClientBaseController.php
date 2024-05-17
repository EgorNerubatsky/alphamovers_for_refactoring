<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\ClientCommentRequest;
use App\Http\Requests\OrderFilesRequest;
use App\Models\ClientBase;
use App\Services\ClientBaseControllerService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClientCreateFormRequest;
use App\Http\Requests\ClientUpdateFormRequest;


/**
 *
 * @OA\Post(
 *     path="/api/clientBases",
 *     summary="Создание",
 *     tags={"Clients"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Олександр"),
 *                     @OA\Property(property="last_name", type="string", example="Сердюк"),
 *                     @OA\Property(property="full_name", type="string", example="Стефанович"),
 *                     @OA\Property(property="client_phone", type="string", example="+380953455678"),
 *                     @OA\Property(property="position", type="string", example="Менеджер"),
 *                     @OA\Property(property="company", type="string", example="АТ 'DFF'"),
 *                     @OA\Property(property="type", type="string", example="Фізична особа"),
 *                     @OA\Property(property="debt_ceiling", type="string", example="4567.78"),
 *                     @OA\Property(property="identification_number", type="string", example="UA793991114209"),
 *                     @OA\Property(property="code_of_the_reason_for_registration", type="string", example="UA4977230"),
 *                     @OA\Property(property="main_state_registration_number", type="string", example="UA468312256126"),
 *                     @OA\Property(property="director_name", type="string", example="Brielle Schuster"),
 *                     @OA\Property(property="contact_person_position", type="string", example="Голова правлiння"),
 *                     @OA\Property(property="acting_on_the_basis_of", type="string", example="Договiр № 86028"),
 *                     @OA\Property(property="registered_address", type="string", example="Харкiв, вул.4"),
 *                     @OA\Property(property="zip_code", type="string", example="61171"),
 *                     @OA\Property(property="postal_address", type="string", example="4367 Харкiв"),
 *                     @OA\Property(property="payment_account", type="string", example="UA827498498555"),
 *                     @OA\Property(property="bank_name", type="string", example="АТ Спец Банк"),
 *                     @OA\Property(property="bank_identification_code", type="string", example="UA308371"),
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
 *                 @OA\Property(property="id", type="integer", example=3),
 *                 @OA\Property(property="company", type="string", example="АТ 'DFF'"),
 *                 @OA\Property(property="type", type="string", example="Фізична особа"),
 *                 @OA\Property(property="debt_ceiling", type="string", example="4567.78"),
 *                 @OA\Property(property="identification_number", type="string", example="UA793991114209"),
 *                 @OA\Property(property="code_of_the_reason_for_registration", type="string", example="UA4977230"),
 *                 @OA\Property(property="main_state_registration_number", type="string", example="UA468312256126"),
 *                 @OA\Property(property="director_name", type="string", example="Brielle Schuster"),
 *                 @OA\Property(property="contact_person_position", type="string", example="Голова правлiння"),
 *                 @OA\Property(property="acting_on_the_basis_of", type="string", example="Договiр № 86028"),
 *                 @OA\Property(property="registered_address", type="string", example="Харкiв, вул.4"),
 *                 @OA\Property(property="zip_code", type="string", example="61171"),
 *                 @OA\Property(property="postal_address", type="string", example="4367 Харкiв"),
 *                 @OA\Property(property="payment_account", type="string", example="UA827498498555"),
 *                 @OA\Property(property="bank_name", type="string", example="АТ Спец Банк"),
 *                 @OA\Property(property="bank_identification_code", type="string", example="UA308371"),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Get(
 *      path="/api/clientBases",
 *      summary="Список",
 *      tags={"Clients"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Response(
 *          response=200,
 *          description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="company", type="string", example="АТ 'DFF'"),
 *                  @OA\Property(property="type", type="string", example="Фізична особа"),
 *                  @OA\Property(property="debt_ceiling", type="string", example="4567.78"),
 *                  @OA\Property(property="identification_number", type="string", example="UA793991114209"),
 *                  @OA\Property(property="code_of_the_reason_for_registration", type="string", example="UA4977230"),
 *                  @OA\Property(property="main_state_registration_number", type="string", example="UA468312256126"),
 *                  @OA\Property(property="director_name", type="string", example="Brielle Schuster"),
 *                  @OA\Property(property="contact_person_position", type="string", example="Голова правлiння"),
 *                  @OA\Property(property="acting_on_the_basis_of", type="string", example="Договiр № 86028"),
 *                  @OA\Property(property="registered_address", type="string", example="Харкiв, вул.4"),
 *                  @OA\Property(property="zip_code", type="integer", example=61171),
 *                  @OA\Property(property="postal_address", type="string", example="4367 Харкiв"),
 *                  @OA\Property(property="payment_account", type="string", example="UA827498498555"),
 *                  @OA\Property(property="bank_name", type="string", example="АТ Спец Банк"),
 *                  @OA\Property(property="bank_identification_code", type="string", example="UA308371"),
 *               )),
 *           ),
 *      ),
 *  ),
 *
 * @OA\Get(
 *         path="/api/clientBases/{clientBase}",
 *         summary="Единичная запись",
 *         tags={"Clients"},
 *         security={{ "bearerAuth": {} }},
 *
 *         @OA\Parameter(
 *             description="ID лида",
 *             in="path",
 *             name="clientBase",
 *             required=true,
 *             example=1,
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="OK",
 *             @OA\JsonContent(
 *                @OA\Property(property="data", type="object",
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="company", type="string", example="АТ 'DFF'"),
 *                   @OA\Property(property="type", type="string", example="Фізична особа"),
 *                   @OA\Property(property="debt_ceiling", type="string", example="4567.78"),
 *                   @OA\Property(property="identification_number", type="string", example="UA793991114209"),
 *                   @OA\Property(property="code_of_the_reason_for_registration", type="string", example="UA4977230"),
 *                   @OA\Property(property="main_state_registration_number", type="string", example="UA468312256126"),
 *                   @OA\Property(property="director_name", type="string", example="Brielle Schuster"),
 *                   @OA\Property(property="contact_person_position", type="string", example="Голова правлiння"),
 *                   @OA\Property(property="acting_on_the_basis_of", type="string", example="Договiр № 86028"),
 *                   @OA\Property(property="registered_address", type="string", example="Харкiв, вул.4"),
 *                   @OA\Property(property="zip_code", type="integer", example=61171),
 *                   @OA\Property(property="postal_address", type="string", example="4367 Харкiв"),
 *                   @OA\Property(property="payment_account", type="string", example="UA827498498555"),
 *                   @OA\Property(property="bank_name", type="string", example="АТ Спец Банк"),
 *                   @OA\Property(property="bank_identification_code", type="string", example="UA308371"),
 *                ),
 *             ),
 *         ),
 *     ),
 *
 * @OA\Patch(
 *          path="/api/clientBases/{clientBase}",
 *          summary="Обновление",
 *          tags={"Clients"},
 *          security={{ "bearerAuth": {} }},
 *
 *          @OA\Parameter(
 *              description="ID клиента",
 *              in="path",
 *              name="clientBase",
 *              required=true,
 *              example=2,
 *          ),
 *
 *          @OA\RequestBody(
 *              @OA\JsonContent(
 *                  allOf={
 *                      @OA\Schema(
 *                          @OA\Property(property="position", type="string", example="Менеджер"),
 *                          @OA\Property(property="company", type="string", example="АТ 'DFF'"),
 *                          @OA\Property(property="type", type="string", example="Фізична особа"),
 *                          @OA\Property(property="debt_ceiling", type="string", example="4567.78"),
 *                          @OA\Property(property="identification_number", type="string", example="UA793991114209"),
 *                          @OA\Property(property="code_of_the_reason_for_registration", type="string", example="UA4977230"),
 *                          @OA\Property(property="main_state_registration_number", type="string", example="UA468312256126"),
 *                          @OA\Property(property="director_name", type="string", example="Brielle Schuster"),
 *                          @OA\Property(property="contact_person_position", type="string", example="Голова правлiння"),
 *                          @OA\Property(property="acting_on_the_basis_of", type="string", example="Договiр № 86028"),
 *                          @OA\Property(property="registered_address", type="string", example="Харкiв, вул.4"),
 *                          @OA\Property(property="zip_code", type="string", example="61171"),
 *                          @OA\Property(property="postal_address", type="string", example="4367 Харкiв"),
 *                          @OA\Property(property="payment_account", type="string", example="UA827498498555"),
 *                          @OA\Property(property="bank_name", type="string", example="АТ Спец Банк"),
 *                          @OA\Property(property="bank_identification_code", type="string", example="UA308371"),
 *                          @OA\Property(
 *                              property="client_contacts",
 *                              type="array",
 *                              @OA\Items(
 *                                  type="object",
 *                                  @OA\Property(property="client_base_id", type="string", example="30"),
 *                                  @OA\Property(property="complete_name", type="string", example="Олександр Сердюк Стефанович"),
 *                                  @OA\Property(property="position", type="string", example="Менеджер"),
 *                                  @OA\Property(property="client_phone", type="string", example="+380953455678"),
 *                                  @OA\Property(property="email", type="string", example=null),
 *                              )
 *                          ),
 *                      )
 *                  }
 *              )
 *          ),
 *          @OA\Response(
 *              response=200,
 *              description="OK",
 *              @OA\JsonContent(
 *                 @OA\Property(property="data", type="object",
 *                     @OA\Property(property="id", type="integer", example=3),
 *                     @OA\Property(property="company", type="string", example="АТ 'DFF'"),
 *                     @OA\Property(property="type", type="string", example="Фізична особа"),
 *                     @OA\Property(property="debt_ceiling", type="string", example="4567.78"),
 *                     @OA\Property(property="identification_number", type="string", example="UA793991114209"),
 *                     @OA\Property(property="code_of_the_reason_for_registration", type="string", example="UA4977230"),
 *                     @OA\Property(property="main_state_registration_number", type="string", example="UA468312256126"),
 *                     @OA\Property(property="director_name", type="string", example="Brielle Schuster"),
 *                     @OA\Property(property="contact_person_position", type="string", example="Голова правлiння"),
 *                     @OA\Property(property="acting_on_the_basis_of", type="string", example="Договiр № 86028"),
 *                     @OA\Property(property="registered_address", type="string", example="Харкiв, вул.4"),
 *                     @OA\Property(property="zip_code", type="string", example="61171"),
 *                     @OA\Property(property="postal_address", type="string", example="4367 Харкiв"),
 *                     @OA\Property(property="payment_account", type="string", example="UA827498498555"),
 *                     @OA\Property(property="bank_name", type="string", example="АТ Спец Банк"),
 *                     @OA\Property(property="bank_identification_code", type="string", example="UA308371"),
 *                 ),
 *              ),
 *          ),
 *      ),
 * @OA\Post(
 *           path="/api/clientBases/edit/addComment/{id}",
 *           summary="Добавить комментарий в историю заказа",
 *           tags={"Clients"},
 *           security={{ "bearerAuth": {} }},
 *
 *           @OA\Parameter(
 *               description="ID замовлення",
 *               in="path",
 *               name="id",
 *               required=true,
 *               example=1,
 *           ),
 *           @OA\RequestBody(
 *               @OA\JsonContent(
 *                   allOf={
 *                       @OA\Schema(
 *                           @OA\Property(property="comment", type="string", example="Тестовый комментарий"),
 *                       )
 *                   }
 *               )
 *           ),
 *           @OA\Response(
 *               response=200,
 *               description="OK",
 *               @OA\JsonContent(
 *                   type="object",
 *                   @OA\Property(property="client_id", type="integer", example=1),
 *                   @OA\Property(property="new_value", type="integer", example="Тестовый комментарий"),
 *                   @OA\Property(property="user_id", type="integer", example=4),
 *                   @OA\Property(property="reason", type="string", example="comment"),
 *
 *               )
 *           ),
 *           @OA\Response(
 *               response=400,
 *               description="Bad Request",
 *               @OA\JsonContent(
 *                   type="object",
 *                   @OA\Property(property="error", type="string", example="Произошла ошибка при добавлении файлов.")
 *               )
 *           )
 *       )
 * @OA\Delete(
 *          path="/api/clientBases/{clientBase}",
 *          summary="Удаление",
 *          tags={"Clients"},
 *         security={{ "bearerAuth": {} }},
 *
 *          @OA\Parameter(
 *              description="ID замовлення",
 *              in="path",
 *              name="clientBase",
 *              required=true,
 *              example=1,
 *          ),
 *          @OA\Response(
 *              response=200,
 *              description="OK",
 *              @OA\JsonContent(
 *                 @OA\Property(property="message", type="string",example="done"),
 *              ),
 *          ),
 *      ),
 *
 */
class ClientBaseController extends Controller
{

}
