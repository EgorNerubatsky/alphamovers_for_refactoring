<div class="form-row">
    <div class="col-md-6 mb-3">
        <h2 class="card-title">@yield('title') # {{ $order->getKey() }}</h2>
    </div>
</div>
<div class="form-row">
    <div class="col-md-10 mb-5">
        <label class="btn bg-olive active" id="basicInfoLabel">
            <a href="#basicInfoForm" id="basicInfoBtn">Основна Iнформацiя</a>
            <input type="radio" name="options" id="option_b1" autocomplete="on" checked>
        </label>
        <label class="btn bg-olive" id="documentsLabel">
            <a href="#documentsForm" id="documentsBtn">Робітники</a>
            <input type="radio" name="options" id="option_b2" autocomplete="off">
        </label>
        <label class="btn bg-olive" id="historyLabel">
            <a href="#historyForm" id="historyBtn">Iсторiя</a>
            <input type="radio" name="options" id="option_b3" autocomplete="off">
        </label>
    </div>
</div>


<div id="basicInfoForm">
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="status">Статус</label>
                <div class="col-lg-6">
                    <label for="status">{{ $order->status }}</label>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="order_source">Джерело замовлення</label>
                <div class="col-lg-6">
                    <label for="order_source">{{ $order->order_source }}</label>
                </div>
            </div>
            <hr class="w-100">
            <div class="form row">
                <div class="col-md-12 mb-3">
                    <h2 style="color: gray;">Інформація про клієнта</h2>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="payment_form">Форма оплати</label>
                <div class="col-lg-8">
                    <div>
                        <input type="radio" id="payment_form" name="payment_form" value="Фізична особа (на карту)"
                               {{ $order->payment_form == 'Фізична особа (на карту)' ? 'checked' : '' }} disabled>
                        <label for="payment_form" style="font-weight: normal;">Фізична особа (на карту)</label>
                    </div>
                    <div>
                        <input type="radio" id="payment_form" name="payment_form"
                               value="Юридична особа (безготівковий розрахунок)"
                               {{ $order->payment_form == 'Юридична особа (безготівковий розрахунок)' ? 'checked' : '' }} disabled>
                        <label for="payment_form" style="font-weight: normal;">Юридична особа (безготівковий
                            розрахунок)</label>
                    </div>
                    <div>
                        <input type="radio" id="payment_form" name="payment_form"
                               value="Фізична особа (готівковий розрахунок)"
                               {{ $order->payment_form == 'Фізична особа (готівковий розрахунок)' ? 'checked' : '' }} disabled>
                        <label for="payment_form" style="font-weight: normal;">Фізична особа (готівковий
                            розрахунок)</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="client">Клієнт</label>
                <div class="col-lg-6">
                    <label for="client">{{ $order->client->company }}</label>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="fullname">Контактна особа</label>
                <div class="col-lg-6">
                    @if(isset($clientContact))
                        <label for="fullname">{{ $clientContact->complete_name }}</label>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="phone">Контактна особа</label>
                <div class="col-lg-6">
                    @if(isset($clientContact))
                        <label for="phone">{{ $clientContact->client_phone }}</label>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="email">Контактна особа</label>
                <div class="col-lg-6">
                    @if(isset($clientContact))
                        <label for="email" style="color: grey;">{{ $clientContact->email }}</label>
                    @endif
                </div>
            </div>
            <div id="order-details-forms">
                <hr class="w-100">
                <div class="form row">
                    <div class="col-md-12 mb-3">
                        <h2 style="color: gray;">Деталі замовлення заказу # {{$order->getKey()}}
                            ({{ date('d.m.Y', strtotime($order->execution_date)) }})</h2>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="execution_date">Дата виконання замовлення</label>
                    <div class="col-lg-6">
                        <label for="execution_date_date"
                               style="color: grey;">{{ date('d.m.Y', strtotime($order->execution_date)) }}, </label>
                        <label for="execution_date_date"
                               style="color: grey;">{{ date('H:i', strtotime($order->execution_date)) }}</label>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Тип послуг</label>
                    <div class="col-lg-6">
                        <label for="service_type" style="color: grey;">{{ $order->service_type }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Місто</label>
                    <div class="col-lg-6">
                        <label for="city" style="color: grey;">{{ $order->city }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Вулиця</label>
                    <div class="col-lg-6">
                        <label for="street" style="color: grey;">{{ $order->street }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Будинок</label>
                    <div class="col-lg-6">
                        <label for="house" style="color: grey;">{{ $order->house }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Макс. кількість робітників</label>
                    <div class="col-lg-6">
                        <label for="number_of_workers" style="color: grey;">{{ $order->number_of_workers }}</label>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Транспорт</label>
                    <div class="col-lg-6">
                        <label for="transport" style="color: grey;">{{ $order->transport }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="task_description">Примітка до замовлення</label>
                    <div class="col-md-6 mb-4">
                        <label for="task_description" style="color: grey;">{{ $order->task_description }}</label>
                        <br>
                        <input id="straps" name="straps" class="form-check-input ml-1" type="checkbox" value="1"
                               {{ $order->straps ? 'checked' : '' }} disabled>
                        <label for="straps" style="font-weight: normal;" class="ml-4">Ремені</label>

                        <input id="tools" name="tools" class="form-check-input ml-1" type="checkbox" value="1"
                               {{ $order->tools ? 'checked' : '' }} disabled>
                        <label for="tools" style="font-weight: normal;" class="ml-4">Інструменти</label>

                        <input id="respirators" name="respirators" class="form-check-input ml-1" type="checkbox"
                               value="1" {{ $order->respirators ? 'checked' : '' }} disabled>
                        <label for="respirators" style="font-weight: normal;" class="ml-4">Респіратори</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Орієнтовна тривалість замовлення</label>
                    <div class="col-lg-6">
                        <label for="order_hrs" style="color: grey;">{{ $order->order_hrs }} год.</label>
                    </div>
                </div>
                <hr class="w-100">

                <div class="form row">
                    <div class="col-md-12 mb-3">
                        <h2 style="color: gray;">Оплата</h2>
                    </div>
                </div>

                <div class="row col-md-10 mb-9">
                    <div class="col-md-4 mb-2">
                        <label for="">Вартість замовлення</label>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="">Клієнту</label>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="">Робочим</label>
                    </div>
                </div>
                <div class="row col-md-10 mb-9">
                    <div class="col-md-4 mb-2">
                        <label for=""> </label>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <label for="price_to_customer" style="color: grey;">{{ $order->price_to_customer }}
                                    грн.</label>

                            </div>
                            <div class="col-4">
                                <label for="price_to_workers" style="color: grey;">{{ $order->price_to_workers }}
                                    грн.</label>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Сума мінімального замовлення</label>
                    <div class="col-lg-6">
                        <label for="min_order_amount" style="color: grey;">{{ $order->min_order_amount }} грн.</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Мінімальне замовлення</label>
                    <div class="col-lg-6">
                        <label for="min_order_hrs" style="color: grey;">{{ $order->min_order_hrs }} грн.</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Примітка до оплати</label>
                    <div class="col-lg-6">
                        <label for="payment_note" style="color: grey;">{{ $order->payment_note }} грн.</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Логіст</label>
                    <div class="col-lg-6">
                        @foreach($logists as $logist)
                            @if($order->user_logist_id == $logist->id)
                                <label for="logist"
                                       style="color: grey;">{{ $logist->name }} {{ $logist->lastname }}</label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <hr class="w-100">

                <div class="form-group row">
                    <div class="col-lg-3">
                        <a href="{{ route('erp.logist.orders.index') }}" class="btn btn-warning btn-block">До
                            замовлень</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="documentsForm" style="display: none;" class="row col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="form row">
                <div class="col-md-12 mb-3">
                    <h2 style="color: gray;">Замовлення # {{ $order->getKey() }}</h2>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Макс. кількість робітників</label>
                <div class="col-lg-6">
                    <label for="number_of_workers" style="color: grey;">{{ $order->number_of_workers }}</label>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Орієнтовна тривалість замовлення</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        <strong>{{ $order->order_hrs }}</strong> год.<br>
                    </p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Сума мінімального замовлення</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        ₴ <strong>{{ $order->min_order_amount }}</strong> грн.<br>
                    </p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Мінімальне замовлення</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        <strong>{{ $order->min_order_hrs }}</strong> год.<br>
                    </p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Замовлення на суму</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        ₴ <strong>{{$order->total_price}}</strong> грн.<br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="form row">
                <div class="col-md-12 mb-3">
                    <h2 style="color: gray;">Робочі для замовлення</h2>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <a href="" class="btn mr-2" style="background-color: #66CDAA;"
                       data-toggle="modal" data-target="#addMoverModal_{{ $order->getKey() }}">Призначити
                        вантажникiв</a>
                </div>
            </div>


            <div class="modal" id="addMoverModal_{{ $order->getKey() }}" aria-labelledby="addMoverModal">
                <div class="modal-content-my">
                    <!-- Здесь разместите содержимое модального окна -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMoverModal">Призначити вантажникiв</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">

                        <form action="{{ route('erp.logist.orders.addMover', ['id' => $order->getKey()]) }}"
                              method="POST">
                            @csrf


                            <div class="row">
                                <div class="col-md-7 ml-2">
                                    <label for="form-check-input" class="col-form-label">Вантажники:</label>
                                </div>
                                <div class="col-md-4">
                                    <label for="form-check-input" class="col-form-label">Бригадир:</label>
                                </div>
                            </div>
                            <hr>

                            @foreach($moversAdds as $mover)
                                <div class="row ml-4">
                                    <div class="col-md-10 form-group">
                                        <input type="checkbox" name="user_mover_id[]" value="{{$mover->id}}"
                                               class="form-check-input">
                                        <label
                                            class="form-check-label">{{ $mover->name }} {{ $mover->lastname }} </label>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <input type="radio" name="is_brigadier_{{ $mover->id }}" value="1"
                                               class="form-check-input">
                                    </div>
                                </div>
                            @endforeach


                            <div class="modal-footer">
                                <button type="submit" class="btn mt-2" style="background-color: #66CDAA;">Добавить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                №
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            ПІБ робітника

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Адреса

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Телефон

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Категорiя

                        </th>


                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @php
                        $num = 0;
                    @endphp
                    @foreach($order->orderDatesMovers as $orderDatesMover)

                        <tr>

                            <td class="small-font" style="text-align: center; vertical-align: middle;">{{ $num+1 }}</td>
                            @php
                                $num++;
                            @endphp
                            <td class="small-font" style="text-align: center; vertical-align: middle;">
                                {{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }}<br>
                                @php
                                    $dateOfBirth = $orderDatesMover->mover->birth_date;
                                    $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;
                                @endphp
                                <p><strong>{{ $age }} рок., {{ $orderDatesMover->mover->gender }}.</strong></p>
                            </td>

                            <td style="text-align: center; vertical-align: middle;">
                                {{ $orderDatesMover->mover->address }}
                            </td>

                            <td style="text-align: center; vertical-align: middle;">
                                {{ $orderDatesMover->mover->phone }}
                            </td>

                            <td class="small-font" style="text-align: center; vertical-align: middle;">
                                {{ $orderDatesMover->mover->note }}
                            </td>

                            <td class="small-font" style="text-align: center; vertical-align: middle;">
                                <a href="#" class="badge badge-danger" data-toggle="modal"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route('erp.logist.orders.removeMover', ['id' => $orderDatesMover->getKey()]) }}">Видалити</a>

                                <div id="confirmationModal" class="modal" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Пiдтвердження</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Ви впевненi у видаленнi?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Вiдмiна
                                                </button>
                                                <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div id="historyForm" style="display: none;" class="row col-md-12">
    <div class="form-row ml-4">
        <div class="col-md-6 mb-3">
            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal2{{ $order->id }}">Додати
                коментар</a>
            @include('erp.parts.orders.modal')
        </div>
    </div>


    @foreach($changesHistorys as $changesHistory)
        @if($changesHistory->reason != 'updated_at')

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="bootstrap-media">
                            <div class="media">

                                <img class="mr-3 img-fluid"
                                     src="{{ asset($users->where('id', $changesHistory->user_id)->value('photo_path')) }}"
                                     alt="Generic placeholder image" style="max-width: 50px; max-height: 50px;">
                                <div class="media-body">
                                    @switch($changesHistory->reason)
                                        @case('order_source')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Джерело замовлення
                                            @break

                                        @case('status')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Статус

                                            @break

                                        @case('payment_method')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Форма оплати
                                            @break

                                        @case('client')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Клієнт
                                            @break

                                        @case('complete_name')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Контактна особа
                                            @break

                                        @case('client_phone')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Телефон
                                            @break

                                        @case('email')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна:E-mail
                                            @break

                                        @case('execution_date')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Дата виконання замовлення
                                            @break

                                        @case('service_type')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Тип послуг
                                            @break

                                        @case('city')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Місто
                                            @break

                                        @case('street')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Вулиця
                                            @break

                                        @case('house')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Будинок
                                            @break

                                        @case('number_of_workers')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Кількість робітників
                                            @break

                                        @case('transport')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Транспорт
                                            @break

                                        @case('task_description')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Примітка до замовлення
                                            @break

                                        @case('order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Орієнтовна тривалість замовлення
                                            @break

                                        @case('price_to_customer')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Вартість замовлення Робітнику
                                            @break

                                        @case('price_to_workers')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Причина зміни: Вартість замовлення Робітнику
                                            @break

                                        @case('total_price')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Загальна вартість замовлення
                                            @break

                                        @case('min_order_amount')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Сума мінімального замовлення
                                            @break

                                        @case('min_order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Мінімальне замовлення (годин)
                                            @break

                                        @case('payment_note')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Примітка до оплати
                                            @break

                                        @case('user_logist_id')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Призначити логіста
                                            @break

                                        @case('deleted Рахунок')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Видалення рахунку
                                            @break

                                        @case('deleted Договiр')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Видалення Договiра
                                            @break

                                        @case('deleted Акт')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна:Видалення Акту
                                            @break

                                        @case('deed')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Завантаження Договiра
                                            @break

                                        @case('invoice')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Завантаження Рахунку
                                            @break

                                        @case('act')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Завантаження Акту
                                            @break

                                        @case('newcomment')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Новий Коментар
                                            @break

                                        @case('newCommentWithScr')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Новий Коментар
                                            @break


                                        @case('straps')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Ремені
                                            <h5>
                                                @if($changesHistory->old_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif <i class="fas fa-arrow-right ml-3 mr-3"></i>
                                                @if($changesHistory->new_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif
                                            </h5>
                                            @break

                                        @case('tools')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Інструменти
                                            <h5>
                                                @if($changesHistory->old_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif <i class="fas fa-arrow-right ml-3 mr-3"></i>
                                                @if($changesHistory->new_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif
                                            </h5>
                                            @break

                                        @case('respirators')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Респіратори
                                            <h5>
                                                @if($changesHistory->old_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif <i class="fas fa-arrow-right ml-3 mr-3"></i>
                                                @if($changesHistory->new_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif
                                            </h5>
                                            @break
                                            @endswitch
                                            <div class="small-font">
                                                <i class="far fa-calendar-alt"></i> {{ $changesHistory->created_at->format('d.m.Y') }}
                                                <i class="ml-4 far fa-clock"></i> {{ $changesHistory->created_at->format('H:i') }}
                                            </div>
                                            @if($changesHistory->reason != 'respirators' && $changesHistory->reason != 'tools' && $changesHistory->reason != 'straps' && $changesHistory->reason != 'newCommentWithScr' && $changesHistory->reason != 'user_logist_id')
                                                <h5>{{ $changesHistory->old_value }} <i
                                                        class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesHistory->new_value }}
                                                </h5>
                                            @endif

                                            @if($changesHistory->reason == 'newCommentWithScr')
                                                <h5>{{ $changesHistory->old_value }} <i
                                                        class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesHistory->new_value }}
                                                </h5>
                                                <a href="#" data-toggle="modal" data-target="#previewModal">
                                                    @if(isset($orderDocument->path))

                                                        <img src="{{ asset($orderDocument->path) }}"
                                                             alt="Screenshot Preview"
                                                             data-updated="{{ $changesHistory->updated_at }}"
                                                             style="max-width: 300px; height: auto;">
                                                    @endif

                                                </a>
                                            @endif

                                            @if($changesHistory->reason == 'user_logist_id')
                                                @php
                                                    $oldUser = App\Models\User::find($changesHistory->old_value);
                                                    $newUser = App\Models\User::find($changesHistory->new_value);
                                                @endphp
                                                <h5>{{ $oldUser->name ?? '' }} {{ $oldUser->lastname ?? '' }} <i
                                                        class="fas fa-arrow-right ml-3 mr-3"></i> {{ $newUser->name ?? '' }} {{ $newUser->lastname ?? '' }}
                                                </h5>
                                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Screenshot Preview</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(isset($orderDocument->path))
                                <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview" class="img-fluid"
                                     data-updated="{{ $changesHistory->updated_at }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    @foreach($changesClientHistorys as $changesClientHistory)
        @if($changesClientHistory->reason != 'updated_at')
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="bootstrap-media">
                            <div class="media">
                                <img class="mr-3 img-fluid"
                                     src="{{ asset($users->where('id', $changesClientHistory->user_id)->value('photo_path')) }}"
                                     alt="Generic placeholder image" style="max-width: 50px; max-height: 50px;">
                                <div class="media-body">

                                    <h5 class="bold">
                                        @switch($changesClientHistory->reason)

                                            @case('complete_name')
                                                <strong>{{ $users->where('id', $changesClientHistory->user_id)->value('name') . ' ' . $users->where('id', $changesClientHistory->user_id)->value('lastname') }}
                                                    .</strong>
                                                <hr> Зміна: Контактна особа
                                                @break

                                            @case('client_phone')
                                                <strong>{{ $users->where('id', $changesClientHistory->user_id)->value('name') . ' ' . $users->where('id', $changesClientHistory->user_id)->value('lastname') }}
                                                    .</strong>
                                                <hr> Зміна: Телефон
                                                @break

                                            @case('email')
                                                <strong>{{ $users->where('id', $changesClientHistory->user_id)->value('name') . ' ' . $users->where('id', $changesClientHistory->user_id)->value('lastname') }}
                                                    .</strong>
                                                <hr> Зміна:E-mail
                                                @break
                                        @endswitch
                                    </h5>

                                    <div class="small-font">
                                        <i class="far fa-calendar-alt"></i> {{ $changesClientHistory->created_at->format('d.m.Y') }}
                                        <i class="ml-4 far fa-clock"></i> {{ $changesClientHistory->created_at->format('H:i') }}
                                    </div>
                                    <h5>{{ $changesClientHistory->old_value }} <i
                                            class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesClientHistory->new_value }}
                                    </h5>
                                    @if($changesClientHistory->reason == 'newCommentWithScr')
                                        <h5>{{ $changesClientHistory->old_value }} <i
                                                class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesClientHistory->new_value }}
                                        </h5>
                                        <a href="#" data-toggle="modal" data-target="#previewModal">
                                            <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview"
                                                 data-updated="{{ $changesHistory->updated_at }}"
                                                 style="max-width: 300px; height: auto;">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Screenshot Preview</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(isset($orderDocument->path))
                                <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview" class="img-fluid"
                                     data-updated="{{ $changesHistory->updated_at }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr class="w-100">
        @endif
    @endforeach
</div>

