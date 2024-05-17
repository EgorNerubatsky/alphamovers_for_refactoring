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
            <a href="#documentsForm" id="documentsBtn">Документи</a>
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
            {{ Form::model($order, ['route' => $order->getKey() ? [$roleData['roleData']['update'], $order->getKey()] : $roleData['roleData']['update'], 'method' => $order->getKey() ? 'put' : 'get', 'id' => 'form1']) }}
            @method('PUT')
            @csrf

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="status">Статус</label>
                <div class="col-lg-6">
                    <select id="status" name="status" class="form-control">
                        <option
                            value="Попереднє замовлення" {{ $order->status == 'Попереднє замовлення' ? 'selected' : '' }}>
                            Попереднє замовлення
                        </option>
                        <option value="В роботі" {{ $order->status == 'В роботі' ? 'selected' : '' }}>В роботі</option>
                        <option value="Виконано" {{ $order->status == 'Виконано' ? 'selected' : '' }}>Виконано</option>
                        <option value="Скасовано" {{ $order->status == 'Скасовано' ? 'selected' : '' }}>Скасовано
                        </option>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="order_source">Джерело замовлення</label>
                <div class="col-lg-6">
                    <select id="order_source" name="order_source" class="form-control">
                        <option
                            value="Рекомендація знайомих" {{ $order->order_source == 'Рекомендація знайомих' ? 'selected' : '' }}>
                            Рекомендація знайомих
                        </option>
                        <option value="ОЛХ" {{ $order->order_source == 'ОЛХ' ? 'selected' : '' }}>ОЛХ</option>
                        <option value="Сайт" {{ $order->order_source == 'Сайт' ? 'selected' : '' }}>Сайт</option>
                        <option
                            value="Повторне замовлення" {{ $order->order_source == 'Повторне замовлення' ? 'selected' : '' }}>
                            Повторне замовлення
                        </option>
                    </select>
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
                        <input type="radio" id="payment_form" name="payment_form"
                               value="Фізична особа (на карту)" {{ $order->payment_form == 'Фізична особа (на карту)' ? 'checked' : '' }}>
                        <label for="payment_form" style="font-weight: normal;">Фізична особа (на карту)</label>
                    </div>
                    <div>
                        <input type="radio" id="payment_form" name="payment_form"
                               value="Юридична особа (безготівковий розрахунок)" {{ $order->payment_form == 'Юридична особа (безготівковий розрахунок)' ? 'checked' : '' }}>
                        <label for="payment_form" style="font-weight: normal;">Юридична особа (безготівковий
                            розрахунок)</label>
                    </div>
                    <div>
                        <input type="radio" id="payment_form" name="payment_form"
                               value="Фізична особа (готівковий розрахунок)" {{ $order->payment_form == 'Фізична особа (готівковий розрахунок)' ? 'checked' : '' }}>
                        <label for="payment_form" style="font-weight: normal;">Фізична особа (готівковий
                            розрахунок)</label>
                    </div>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="client">Клієнт</label>
                <div class="col-lg-6">
                    <select id="client" name="client" class="form-control">
                        @foreach($clients as $client)
                            <option
                                value="{{ $client->id }}" {{ $order->client_id == $client->id ? 'selected' : '' }}>{{ $client->company }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="fullname">Контактна особа</label>
                <div class="col-lg-6">
                    @if(isset($clientContact))
                        <input id="fullname" name="fullname" class="form-control"
                               value="{{ $clientContact->complete_name }}">
                    @else
                        <input id="fullname" name="fullname" class="form-control"
                               value="" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                    @endif
                </div>
            </div>


            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                <div class="col-lg-6">
                    @if(isset($clientContact))
                        <input type="text" id="phone" name="phone" class="form-control" pattern="\+380\d{9}"
                               value="{{ $clientContact->client_phone }}" required>
                    @else
                        <input type="text" id="phone" name="phone" class="form-control" pattern="\+380\d{9}"
                               value="{{ $order->phone }}"
                               {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }} required>
                    @endif
                    <small>Введіть номер телефону у форматі +380 та ще 9 цифр</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="email">Email</label>
                <div class="col-lg-6">
                    @if(isset($clientContact))
                        <input type="email" id="email" name="email" class="form-control"
                               value="{{ $clientContact->email }}" required>
                    @else
                        <input type="email" id="email" name="email" class="form-control" value="{{ $order->email }}"
                               required>
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
                <!-- Остальные поля формы -->

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="execution_date_date">Дата виконання
                        замовлення</label>
                    <div class="col-lg-3">
                        <input type="date" id="execution_date_date" name="execution_date_date" class="form-control"
                               value="{{ date('Y-m-d', strtotime($order->execution_date)) }}"
                               {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                    </div>
                    <div class="col-lg-3">
                        <label for="execution_date_time" style="display: none"></label>
                        <input type="time" id="execution_date_time" name="execution_date_time" class="form-control"
                               value="{{ date('H:i:s', strtotime($order->execution_date)) }}"
                               {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="service_type">Тип послуг</label>
                    <div class="col-lg-6">
                        <select id="service_type" name="service_type" class="form-control"
                                {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                            <option value="" disabled {{ $order->service_type == null ? 'selected' : '' }}>Оберiть тип
                                послуг
                            </option>
                            <option
                                value="Прибирання будівельного сміття" {{ $order->service_type == 'Прибирання будівельного сміття' ? 'selected' : '' }}>
                                Прибирання будівельного сміття
                            </option>
                            <option
                                value="Перевезення великогабаритних об'єктів" {{ $order->service_type == "Перевезення великогабаритних об'єктів" ? 'selected' : '' }}>
                                Перевезення великогабаритних об'єктів
                            </option>
                            <option
                                value="Розвантаження-завантаження" {{ $order->service_type == 'Розвантаження-завантаження' ? 'selected' : '' }}>
                                Розвантаження-завантаження
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="city">Місто</label>
                    <input type="hidden" name="city" value="{{ $order->city }}">

                    <div class="col-lg-6">
                        <select id="city" name="city" class="form-control"
                                {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                            <option value="" disabled {{ $order->city == null ? 'selected' : '' }}>Оберiть город
                            </option>
                            <option value="Днепр" {{ $order->city == 'Днепр' ? 'selected' : '' }}>Днепр</option>
                            <option value="Харкiв" {{ $order->city == 'Харкiв' ? 'selected' : '' }}>Харкiв</option>
                            <option value="Львів" {{ $order->city == 'Львів' ? 'selected' : '' }}>Львів</option>
                            <option value="Київ" {{ $order->city == 'Київ' ? 'selected' : '' }}>Київ</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="street">Вулиця</label>
                    <input type="hidden" name="street" value="{{ $order->street }}">

                    <div class="col-lg-6">
                        <select id="street" name="street" class="form-control"
                                {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                            <option value="" disabled {{ $order->street == null ? 'selected' : '' }}>Оберiть вулицю
                            </option>

                            <option value="Вулиця 1" {{ $order->street == 'Вулиця 1' ? 'selected' : '' }}>Вулиця 1
                            </option>
                            <option value="Вулиця 2" {{ $order->street == "Вулиця 2" ? 'selected' : '' }}>Вулиця 2
                            </option>
                            <option value="Вулиця 3" {{ $order->street == 'Вулиця 3' ? 'selected' : '' }}>Вулиця 3
                            </option>
                            <option value="Вулиця 4" {{ $order->street == 'Вулиця 4' ? 'selected' : '' }}>Вулиця 4
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="house">Будинок</label>
                    <input type="hidden" name="house" value="{{ $order->house }}">
                    <div class="col-lg-6">
                        <select id="house" name="house" class="form-control"
                                {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>

                            <option value="" disabled {{ $order->house == null ? 'selected' : '' }}>Оберiть будинок
                            </option>
                            <option value="34а" {{ $order->house == '34а' ? 'selected' : '' }}>34а</option>
                            <option value="56б" {{ $order->house == "56б" ? 'selected' : '' }}>56б</option>
                            <option value="23г" {{ $order->house == '23г' ? 'selected' : '' }}>23г</option>
                            <option value="17" {{ $order->house == '17' ? 'selected' : '' }}>17</option>

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="number_of_workers">Макс. кількість
                        робітників</label>
                    <div class="col-lg-6">
                        <select id="number_of_workers" name="number_of_workers"
                                class="form-control" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                            <option value="" disabled {{ $order->number_of_workers == null ? 'selected' : '' }}>Оберiть
                                макс. кількість робітників
                            </option>

                            <option value="1" {{ $order->number_of_workers == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $order->number_of_workers == "2" ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $order->number_of_workers == '3' ? 'selected' : '' }}>3</option>
                            <option value="3" {{ $order->number_of_workers == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $order->number_of_workers == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $order->number_of_workers == "5" ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $order->number_of_workers == '6' ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $order->number_of_workers == '7' ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $order->number_of_workers == '8' ? 'selected' : '' }}>8</option>
                            <option value="9" {{ $order->number_of_workers == "9" ? 'selected' : '' }}>9</option>
                            <option value="10" {{ $order->number_of_workers == '10' ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $order->number_of_workers == '11' ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $order->number_of_workers == '12' ? 'selected' : '' }}>12</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="transport">Транспорт</label>
                    <div class="col-lg-6">
                        <select id="transport" name="transport"
                                class="form-control" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                            <option value="" disabled {{ $order->transport == null ? 'selected' : '' }}>Оберiть
                                транспорт
                            </option>

                            <option value="Легкова 1" {{ $order->transport == 'Легкова 1' ? 'selected' : '' }}>Легкова
                                1
                            </option>
                            <option value="Легкова 2" {{ $order->transport == 'Легкова 2' ? 'selected' : '' }}>Легкова
                                2
                            </option>
                            <option value="Грузова 1" {{ $order->transport == 'Грузова 1' ? 'selected' : '' }}>Грузова
                                1
                            </option>
                            <option value="Грузова 2" {{ $order->transport == 'Грузова 2' ? 'selected' : '' }}>Грузова
                                2
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="task_description">Примітка до замовлення</label>
                    <div class="col-lg-6">
                        <textarea id="task_description" name="task_description" class=" mb-3 form-control" rows="3"
                                  placeholder="" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>{{ $order->task_description }}</textarea>
                        <input id="straps" name="straps" class="form-check-input ml-1 mr-2" type="checkbox"
                               value="1" {{ $order->straps ? 'checked' : '' }} {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                        <label for="straps" style="font-weight: normal;" class="ml-4">Ремені</label>
                        <br>
                        <input id="tools" name="tools" class="form-check-input ml-1 mr-2" type="checkbox"
                               value="1" {{ $order->tools ? 'checked' : '' }} {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                        <label for="tools" style="font-weight: normal;" class="ml-4">Інструменти</label>
                        <br>
                        <input id="respirators" name="respirators" class="form-check-input ml-1 mr-2" type="checkbox"
                               value="1" {{ $order->respirators ? 'checked' : '' }} {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                        <label for="respirators" style="font-weight: normal;" class="ml-4">Респіратори</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="order_hrs">Орієнтовна тривалість замовлення</label>
                    <div class="col-lg-6">
                        <select id="order_hrs" name="order_hrs"
                                class="form-control" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                            <option value="" disabled {{ $order->order_hrs == null ? 'selected' : '' }}>Оберiть
                                орієнтовну тривалість замовлення
                            </option>
                            <option value="1" {{ $order->order_hrs == '1.00' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $order->order_hrs == "2.00" ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $order->order_hrs == '3.00' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $order->order_hrs == '4.00' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $order->order_hrs == '5.00' ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $order->order_hrs == '6.00' ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $order->order_hrs == '7.00' ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $order->order_hrs == '8.00' ? 'selected' : '' }}>8</option>
                            <option value="9" {{ $order->order_hrs == '9.00' ? 'selected' : '' }}>9</option>
                            <option value="10" {{ $order->order_hrs == '10.00' ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $order->order_hrs == '11.00' ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $order->order_hrs == '12.00' ? 'selected' : '' }}>12</option>
                        </select>
                    </div>
                </div>

                <hr class="w-100">

                <div class="form row">
                    <div class="col-md-12 mb-3">
                        <h2 style="color: gray;">Оплата</h2>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Вартість замовлення</label>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="m-t-20" for="price_to_customer">Клієнту</label>
                                <input type="text" id="price_to_customer" name="price_to_customer" class="form-control"
                                       value="{{ $order->price_to_customer }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                            </div>
                            <div class="col-lg-4">
                                <label class="m-t-40" for="price_to_workers">Робочим</label>
                                <input type="text" id="price_to_workers" name="price_to_workers" class="form-control"
                                       value="{{ $order->price_to_workers }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                            </div>
                            <div class="col-lg-4">
                                <label class="m-t-40" for="rate">Тариф</label>
                                <select id="rate" name="rate"
                                        class="form-control" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                                    <option value="200/100">200/100</option>
                                    <option value="300/400">300/400</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="min_order_amount">Сума мінімального замовлення
                        (грн.)</label>
                    <input type="hidden" name="min_order_amount" value="{{ $order->min_order_amount }}">

                    <div class="col-lg-3">
                        <input type="text" id="min_order_amount" name="min_order_amount" class="form-control"
                               value="{{ $order->min_order_amount }}"
                               {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="min_order_hrs">Мінімальне замовлення (год.)</label>
                    <div class="col-lg-3">
                        <input type="text" id="min_order_hrs" name="min_order_hrs" class="form-control"
                               value="{{ $order->min_order_hrs }}"
                               {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }} required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="payment_note">Примітка до оплати</label>
                    <div class="col-lg-6">
                        <textarea id="payment_note" name="payment_note" class=" mb-3 form-control" rows="3"
                                  placeholder="" {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>{{ $order->payment_note }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="user_logist_id">Призначити логіста</label>
                    <div class="col-lg-6">
                        <select id="user_logist_id" name="user_logist_id" class="form-control"
                                {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>
                            <option value="" disabled {{ $order->user_logist_id == null ? 'selected' : '' }}>Оберiть
                                логіста
                            </option>
                            @foreach($logists as $logist)
                                <option
                                    value="{{ $logist->id }}" {{ $order->user_logist_id == $logist->id ? 'selected' : '' }} {{ $order->status !== 'Попереднє замовлення' ? 'disabled readonly' : '' }}>{{ $logist->name }} {{ $logist->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="w-100">
                {{ Form::close() }}


                <div class="row col-md-10 mb-14">
                    <div class="col-md-4 mb-4">
                        {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'form' => 'form1']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="documentsForm" style="display: none;" class="row col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <h2 style="color: gray;">Замовлення # {{ $order->getKey() }}</h2>
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="fullname">Контактна особа</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        @if($clientContact->client_contact_id == $order->client_id)
                            <p style="color: gray;">{{ $clientContact->complete_name }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Номер телефону</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        @if($clientContact->client_contact_id == $order->client_id)
                            <p style="color: gray;">{{ $clientContact->client_phone }}</p>
                        @endif
                    @endforeach
                </div>
            </div>


            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">E-mail</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        @if($clientContact->client_contact_id == $order->client_id)
                            <p style="color: gray;">{{ $clientContact->email }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Клієнт</label>
                <div class="col-lg-6">
                    @foreach($clients as $client)
                        @if($client->id == $order->client_id)
                            <strong><p style="color: gray;">{{ $client->company }}</p></strong>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Замовлення на суму</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        ₴ {{$order->total_price}} грн.<br>
                    </p>
                </div>
            </div>


            <form class="mt-4" action="{{ route($roleData['roleData']['orders_addFiles'], ['id' => $order->id]) }}"
                  method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <label class="col-lg-3 ml-4 col-form-label mb-3" for="">Завантажити договiр</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="deed_file" id="deed_file"
                                   onchange="updateFileName(this, 'fileNameLabel1'); toggleExecutionDateRequired('deed_file');">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel1">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <label class="col-lg-3 ml-4 col-form-label mb-3" for="">Завантажити рахунок</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="invoice_file" id="invoice_file"
                                   onchange="updateFileName(this, 'fileNameLabel2'); toggleExecutionDateRequired('invoice_file');">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel2">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <label class="col-lg-3 ml-4 col-form-label mb-5" for="">Завантажити акт</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="act_file" id="act_file"
                                   onchange="updateFileName(this, 'fileNameLabel3'); toggleExecutionDateRequired('act_file');">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel3">Choose file</label>
                        </div>
                    </div>
                </div>

                <hr class="w-100">

                <button type="submit" class="btn btn-primary">Завантажити</button>

            </form>

            <div class="form-row">
                <div class="col-md-6 mb-3 mt-4">
                    <h2 style="color: gray;">Документи по замовленню: Договір</h2>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead style="background-color: #AFEEEE">
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <input type="checkbox" id="">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID документа
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Дата

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Тип документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Номер документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Послуга

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Статус


                        </th>


                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Документ надіслано замовнику

                        </th>
                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Отриман скан вiд замовника

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @foreach($orderDocuments as $orderDocument)
                        @if($orderDocument->description == 'Договiр')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="ord_id" style="display: none"></label>
                                    <input type="checkbox" id="ord_id" value="{{ $orderDocument->id }}">
                                </td>
                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $orderDocument->getKey() }}</td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $orderDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $orderDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $orderDocument->description }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $orderDocument->getKey() }} / {{ $orderDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    {{ $order->service_type }}<br>
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($orderDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $orderDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break

                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Вiдправлено' || $orderDocument->status == 'Отримано скан')
                                        <label for="scan_recieved_date_date" style="display: none"></label>
                                        <input type="date" id="scan_recieved_date_date" name="scan_recieved_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <label for="scan_recieved_date_time" style="display: none"></label>
                                        <input type="time" id="scan_recieved_date_time" name="scan_recieved_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif

                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Отримано скан')
                                        <label for="scan_send_date_date" style="display: none"></label>

                                        <input type="date" id="scan_send_date_date" name="scan_send_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <label for="scan_send_date_time" style="display: none"></label>
                                        <input type="time" id="scan_send_date_time" name="scan_send_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif

                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($orderDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <form
                                        action="{{ route($roleData['roleData']['orders_deleteFile'], ['id' => $orderDocument->getKey()]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-block">Видалити</button>
                                    </form>
                                </td>

                            </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>


            <hr class="w-20">
            <div class="form-row">
                <div class="col-md-6 mb-3 mt-4">
                    <h2 style="color: gray;">Документи по замовленню: Рахунки</h2>
                </div>
            </div>


            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead style="background-color: #AFEEEE">
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <label for="select-all-invoices" style="display: none"></label>
                            <input type="checkbox" id="select-all-invoices">
                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID документа
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Дата

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Тип документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Номер документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Сума

                        </th>


                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Статус


                        </th>


                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @foreach($orderDocuments as $orderDocument)

                        @if($orderDocument->description == 'Рахунок')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_invoices[]" style="display: none"></label>
                                    <input type="checkbox" id="selected_invoices[]" name="selected_invoices[]"
                                           value="{{ $orderDocument->order_execution_date }}">
                                </td>

                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $orderDocument->getKey() }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $orderDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $orderDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $orderDocument->description }}
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $orderDocument->getKey() }} / {{ $orderDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <p style="color: gray;">
                                        ₴ {{ $order->total_price }} грн.
                                    </p>
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @switch($orderDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Рахунок сплачено')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($orderDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Рахунок сплачено')
                                        <button type="button" class="btn btn-secondary">Рахунок сплачено</button>
                                    @else
                                        <form id="toBankOperations_{{ $orderDocument->getKey() }}"
                                              action="{{ route($roleData['roleData']['orders_to_bank_operations'], ['id' => $orderDocument->getKey()]) }}"
                                              method="POST">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-success">Рахунок сплачено</button>
                                        </form>
                                    @endif
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                            data-target="#confirmDeleteModal">Видалити
                                    </button>
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Подтвердите
                                                        удаление</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Вы уверены, что хотите удалить этот файл?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Отмена
                                                    </button>
                                                    <form
                                                        action="{{ route($roleData['roleData']['orders_deleteFile'], ['id' => $orderDocument->getKey()]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Да, удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

            <hr class="w-20">
            <div class="form-row">
                <div class="col-md-6 mb-3 mt-4">
                    <h2 style="color: gray;">Документи по замовленню: Акти</h2>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead style="background-color: #AFEEEE">
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <label for="select-all-leads" style="display: none"></label>
                            <input type="checkbox" id="select-all-leads">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID документа
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Дата

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Тип документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Номер документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Послуга

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Статус


                        </th>


                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Документ надіслано замовнику

                        </th>
                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Отриман скан вiд замовника

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @foreach($orderDocuments as $orderDocument)
                        @if($orderDocument->description == 'Акт')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_documents[]" style="display: none"></label>
                                    <input type="checkbox" id="selected_documents[]" name="selected_documents[]"
                                           value="{{ $orderDocument->id }}">
                                </td>
                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $orderDocument->getKey() }}</td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $orderDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $orderDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $orderDocument->description }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $orderDocument->getKey() }} / {{ $orderDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">

                                    {{ $order->service_type }}<br>


                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($orderDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break
                                            @break
                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Вiдправлено' || $orderDocument->status == 'Отримано скан')

                                        <input type="date" id="scan_recieved_date_date" name="scan_recieved_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <input type="time" id="scan_recieved_date_time" name="scan_recieved_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'orderDocument скан')

                                        <input type="date" id="scan_send_date_date" name="scan_send_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <input type="time" id="scan_send_date_time" name="scan_send_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($orderDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <form
                                        action="{{ route($roleData['roleData']['orders_deleteFile'], ['id' => $orderDocument->getKey()]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-block">Видалити</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="historyForm" style="display: none;" class="row col-md-12">
    <div class="form-row">
        <div class="col-md-6 mb-3 ml-3">
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
                                                </strong>
                                            <hr> Зміна: Джерело замовлення
                                            @break

                                        @case('status')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Статус

                                            @break

                                        @case('payment_method')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Форма оплати
                                            @break

                                        @case('client')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Клієнт
                                            @break

                                        @case('complete_name')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Контактна особа
                                            @break

                                        @case('client_phone')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Телефон
                                            @break

                                        @case('email')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна:E-mail
                                            @break

                                        @case('execution_date')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Дата виконання замовлення
                                            @break

                                        @case('service_type')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Тип послуг
                                            @break

                                        @case('city')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Місто
                                            @break

                                        @case('street')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Вулиця
                                            @break

                                        @case('house')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Будинок
                                            @break
                                        @case('number_of_workers')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Кількість робітників
                                            @break
                                        @case('transport')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Транспорт
                                            @break
                                        @case('task_description')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Примітка до замовлення
                                            @break

                                        @case('order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Орієнтовна тривалість замовлення
                                            @break

                                        @case('price_to_customer')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Вартість замовлення Робітнику
                                            @break

                                        @case('price_to_workers')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Причина зміни: Вартість замовлення Робітнику
                                            @break

                                        @case('total_price')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Загальна вартість замовлення
                                            @break

                                        @case('min_order_amount')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Сума мінімального замовлення
                                            @break

                                        @case('min_order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Мінімальне замовлення (годин)
                                            @break

                                        @case('payment_note')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Примітка до оплати
                                            @break

                                        @case('user_logist_id')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Призначити логіста
                                            @break

                                        @case('deleted Рахунок')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Видалення рахунку
                                            @break

                                        @case('deleted Договiр')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Видалення Договiра
                                            @break

                                        @case('deleted Акт')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна:Видалення Акту
                                            @break

                                        @case('deed')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Завантаження Договiра
                                            @break

                                        @case('invoice')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Завантаження Рахунку
                                            @break

                                        @case('act')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Завантаження Акту
                                            @break

                                        @case('newcomment')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Новий Коментар
                                            @break

                                        @case('newCommentWithScr')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
                                            <hr> Зміна: Новий Коментар
                                            @break


                                        @case('straps')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                </strong>
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
                                                </strong> Зміна: Інструменти
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
                                                </strong> Зміна: Респіратори
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

                                                <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview"
                                                     data-updated="{{ $changesHistory->updated_at }}"
                                                     style="max-width: 300px; height: auto;">
                                            @endif

                                        </a>
                                    @endif

                                    @if($changesHistory->reason == 'user_logist_id')
                                        @php
                                        $newUser = $users->where('id', $changesHistory->new_value)->first();
                                        @endphp
                                        <h5><i class="fas fa-arrow-right ml-3 mr-3"></i> {{ $newUser->name ?? '' }} {{ $newUser->lastname ?? '' }}
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="bootstrap-media">
                            <div class="media">

                                <img class="mr-3 img-fluid"
                                     src="{{ $users->where('id', $changesClientHistory->user_id)->value('photo_path') }}"
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

