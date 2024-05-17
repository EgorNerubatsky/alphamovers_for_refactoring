<script>
    const logistsData = @json($logists);
</script>

<div class="row col-md-12 mb-9">
    <div class="col-md-6 mb-4">
        <h2 class="card-title">@yield('title')</h2>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="form-row">

            <div class="col-md-12">

                {{--                {{ Form::open(['route' => $roleData['roleData']['order_create'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'form1']) }}--}}
                {{--                @method('GET')--}}

                <form class="mt-4" action="{{ route($roleData['roleData']['order_store']) }}"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="order_source">Джерело замовлення</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <select id="order_source" name="order_source" class="form-control">
                                <option value="" disabled selected></option>
                                <option
                                    value="Рекомендація знайомих" {{ request()->input('order_source') == 'Рекомендація знайомих' ? 'selected' : '' }}>
                                    Рекомендація знайомих
                                </option>
                                <option value="ОЛХ" {{ request()->input('order_source') == 'ОЛХ' ? 'selected' : '' }}>
                                    ОЛХ
                                </option>
                                <option value="Сайт" {{ request()->input('order_source') == 'Сайт' ? 'selected' : '' }}>
                                    Сайт
                                </option>
                                <option
                                    value="Повторне замовлення" {{ request()->input('order_source') == 'Повторне замовлення' ? 'selected' : '' }}>
                                    Повторне замовлення
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="status">Статус</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <select id="status" name="status" class="form-control" required>
                                <option value="" disabled selected></option>
                                <option
                                    value="Попереднє замовлення" {{ request()->input('order_source') == 'Попереднє замовлення' ? 'selected' : '' }}>
                                    Попереднє замовлення
                                </option>
                                <option
                                    value="В роботі" {{ request()->input('order_source') == 'В роботі' ? 'selected' : '' }}>
                                    В роботі
                                </option>
                            </select>
                        </div>
                    </div>

                    <hr class="w-100">

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-6 mb-4">
                            <h2 style="color: gray;">Інформація про клієнта</h2>
                        </div>

                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="payment_form">Форма оплати</label>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div>
                                <input type="radio" id="payment_form" name="payment_form"
                                       value="Фізична особа (на карту)" {{ request()->input('payment_form') == 'Фізична особа (на карту)' ? 'checked' : '' }}>
                                <label for="payment_form" style="font-weight: normal;">Фізична особа (на карту)</label>
                            </div>
                            <div>
                                <input type="radio" id="payment_form" name="payment_form"
                                       value="Юридична особа (безготівковий розрахунок)" {{ request()->input('payment_form') == 'Юридична особа (безготівковий розрахунок)' ? 'checked' : '' }}>
                                <label for="payment_form" style="font-weight: normal;">Юридична особа (безготівковий
                                    розрахунок)</label>
                            </div>
                            <div>
                                <input type="radio" id="payment_form" name="payment_form"
                                       value="Фізична особа (готівковий розрахунок)" {{ request()->input('payment_form') == 'Фізична особа (готівковий розрахунок)' ? 'checked' : '' }}>
                                <label for="payment_form" style="font-weight: normal;">Фізична особа (готівковий
                                    розрахунок)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9">
                        <div class="col-md-4 mb-4">
                            <label for="">Клієнт</label>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="client" style="display: none"></label>
                            <select id="client" name="client" class="form-control" required>
                                <option value="" disabled selected></option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="{{ route($roleData['roleData']['client_create']) }}" class="btn mr-2"
                               style="background-color: #66CDAA;">Новий кліент</a>
                        </div>
                    </div>

                    <hr class="w-100">

                    <div id="order-details-forms">
                        <div class="row col-md-12 mb-9">
                            <div class="col-md-12 mb-4">
                                <h2 style="color: gray;">Деталі замовлення заказу</h2>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="execution_date">Дата виконання замовлення</label>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="execution_date_date" style="display: none"></label>

                                <input type="date" id="execution_date_date" name="execution_date_date"
                                       class="form-control"
                                       value="" required>

                            </div>
                            @error('execution_date_date')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <div class="col-md-3 mb-4">
                                <label for="execution_date_time" style="display: none"></label>
                                <input type="time" id="execution_date_time" name="execution_date_time"
                                       class="form-control"
                                       value="" required>
                            </div>
                            @error('execution_date_time')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Тип послуг</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="service_type" style="display: none"></label>

                                <select id="service_type" name="service_type" class="form-control" required>
                                    <option value="" disabled selected></option>
                                    <option
                                        value="Прибирання будівельного сміття" {{ request()->input('service_type') == 'Прибирання будівельного сміття' ? 'selected' : '' }}>
                                        Прибирання будівельного сміття
                                    </option>
                                    <option
                                        value="Перевезення великогабаритних об'єктів" {{ request()->input('service_type') == "Перевезення великогабаритних об'єктів" ? 'selected' : '' }}>
                                        Перевезення великогабаритних об'єктів
                                    </option>
                                    <option
                                        value="Розвантаження-завантаження" {{ request()->input('service_type') == 'Розвантаження-завантаження' ? 'selected' : '' }}>
                                        Розвантаження-завантаження
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Місто</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="city" style="display: none"></label>
                                <select id="city" name="city" class="form-control" required>
                                    <option value="" disabled selected></option>
                                    <option value="Днепр" {{ request()->input('city')  == 'Днепр' ? 'selected' : '' }}>
                                        Днепр
                                    </option>
                                    <option
                                        value="Харкiв" {{ request()->input('city')  == 'Харкiв' ? 'selected' : '' }}>
                                        Харкiв
                                    </option>
                                    <option value="Львів" {{ request()->input('city')  == 'Львів' ? 'selected' : '' }}>
                                        Львів
                                    </option>
                                    <option value="Київ" {{ request()->input('city')  == 'Київ' ? 'selected' : '' }}>
                                        Київ
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Вулиця</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="street" style="display: none"></label>
                                <select id="street" name="street" class="form-control" required>
                                    <option value="" disabled selected></option>
                                    <option
                                        value="Вулиця 1" {{ request()->input('street') == 'Вулиця 1' ? 'selected' : '' }}>
                                        Вулиця 1
                                    </option>
                                    <option
                                        value="Вулиця 2" {{ request()->input('street') == "Вулиця 2" ? 'selected' : '' }}>
                                        Вулиця 2
                                    </option>
                                    <option
                                        value="Вулиця 3" {{ request()->input('street') == 'Вулиця 3' ? 'selected' : '' }}>
                                        Вулиця 3
                                    </option>
                                    <option
                                        value="Вулиця 4" {{ request()->input('street') == 'Вулиця 4' ? 'selected' : '' }}>
                                        Вулиця 4
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Будинок</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="house" style="display: none"></label>
                                <select id="house" name="house" class="form-control" required>
                                    <option value="" disabled selected></option>
                                    <option value="34а" {{ request()->input('house') == '34а' ? 'selected' : '' }}>34а
                                    </option>
                                    <option value="56б" {{ request()->input('house') == "56б" ? 'selected' : '' }}>56б
                                    </option>
                                    <option value="23г" {{ request()->input('house') == '23г' ? 'selected' : '' }}>23г
                                    </option>
                                    <option value="17" {{ request()->input('house') == '17' ? 'selected' : '' }}>17
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Кількість робітників</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="number_of_workers" style="display: none"></label>
                                <select id="number_of_workers" name="number_of_workers" class="form-control">
                                    <option value="" disabled selected></option>
                                    <option value="" disabled selected></option>
                                    <option
                                        value="1" {{ request()->input('number_of_workers') == '1' ? 'selected' : '' }}>
                                        1
                                    </option>
                                    <option
                                        value="2" {{ request()->input('number_of_workers') == "2" ? 'selected' : '' }}>
                                        2
                                    </option>
                                    <option
                                        value="3" {{ request()->input('number_of_workers') == '3' ? 'selected' : '' }}>
                                        3
                                    </option>
                                    <option
                                        value="3" {{ request()->input('number_of_workers') == '3' ? 'selected' : '' }}>
                                        3
                                    </option>
                                    <option
                                        value="4" {{ request()->input('number_of_workers') == '4' ? 'selected' : '' }}>
                                        4
                                    </option>
                                    <option
                                        value="5" {{ request()->input('number_of_workers') == "5" ? 'selected' : '' }}>
                                        5
                                    </option>
                                    <option
                                        value="6" {{ request()->input('number_of_workers') == '6' ? 'selected' : '' }}>
                                        6
                                    </option>
                                    <option
                                        value="7" {{ request()->input('number_of_workers') == '7' ? 'selected' : '' }}>
                                        7
                                    </option>
                                    <option
                                        value="8" {{ request()->input('number_of_workers') == '8' ? 'selected' : '' }}>
                                        8
                                    </option>
                                    <option
                                        value="9" {{ request()->input('number_of_workers') == "9" ? 'selected' : '' }}>
                                        9
                                    </option>
                                    <option
                                        value="10" {{ request()->input('number_of_workers') == '10' ? 'selected' : '' }}>
                                        10
                                    </option>
                                    <option
                                        value="11" {{ request()->input('number_of_workers') == '11' ? 'selected' : '' }}>
                                        11
                                    </option>
                                    <option
                                        value="12" {{ request()->input('number_of_workers') == '12' ? 'selected' : '' }}>
                                        12
                                    </option>


                                </select>
                            </div>
                        </div>


                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Транспорт</label>
                            </div>


                            <div class="col-md-3 mb-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                <label for="exe" style="display: none"></label>
                                <input type="checkbox" {{ request()->input('transport') ? 'checked' : '' }} id="exe">
                                </span>
                                    </div>
                                    <label for="transport" style="display: none"></label>
                                    <select id="transport" name="transport" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option
                                            value="Легкова 1" {{ request()->input('transport') == 'Легкова 1' ? 'selected' : '' }}>
                                            Легкова 1
                                        </option>
                                        <option
                                            value="Легкова 2" {{ request()->input('transport') == 'Легкова 2' ? 'selected' : '' }}>
                                            Легкова 2
                                        </option>
                                        <option
                                            value="Грузова 1" {{ request()->input('transport') == 'Грузова 1' ? 'selected' : '' }}>
                                            Грузова 1
                                        </option>
                                        <option
                                            value="Грузова 2" {{ request()->input('transport') == 'Грузова 2' ? 'selected' : '' }}>
                                            Грузова 2
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="review">Примітка до замовлення</label>
                            </div>
                            <div class="col-md-6 mb-4">
                            <textarea id="review" name="review" class=" mb-3 form-control" rows="3"
                                      placeholder="">{{ request()->input('review')}}</textarea>
                                <input id="straps" name="straps" class="form-check-input ml-1" type="checkbox"
                                       value="1" {{ request()->input('straps') ? 'checked' : '' }}>
                                <label for="straps" style="font-weight: normal;" class="ml-4">Ремені</label>
                                <input id="tools" name="tools" class="form-check-input ml-1" type="checkbox"
                                       value="1" {{ request()->input('tools') ? 'checked' : '' }}>
                                <label for="tools" style="font-weight: normal;" class="ml-4">Інструменти</label>
                                <input id="respirators" name="respirators" class="form-check-input ml-1" type="checkbox"
                                       value="1" {{ request()->input('respirators') ? 'checked' : '' }}>
                                <label for="respirators" style="font-weight: normal;" class="ml-4">Респіратори</label>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Орієнтовна тривалість замовлення</label>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label for="min_order_hrs" style="display: none"></label>
                                <select id="min_order_hrs" name="min_order_hrs" class="form-control">
                                    <option value="" disabled selected></option>
                                    <option
                                        value="1" {{ request()->input('min_order_hrs') == '1.00' ? 'selected' : '' }}>
                                        1
                                    </option>
                                    <option
                                        value="2" {{ request()->input('min_order_hrs') == "2.00" ? 'selected' : '' }}>
                                        2
                                    </option>
                                    <option
                                        value="3" {{ request()->input('min_order_hrs') == '3.00' ? 'selected' : '' }}>
                                        3
                                    </option>
                                    <option
                                        value="4" {{ request()->input('min_order_hrs') == '4.00' ? 'selected' : '' }}>
                                        4
                                    </option>
                                    <option
                                        value="5" {{ request()->input('min_order_hrs') == '5.00' ? 'selected' : '' }}>
                                        5
                                    </option>
                                    <option
                                        value="6" {{ request()->input('min_order_hrs') == '6.00' ? 'selected' : '' }}>
                                        6
                                    </option>
                                    <option
                                        value="7" {{ request()->input('min_order_hrs') == '7.00' ? 'selected' : '' }}>
                                        7
                                    </option>
                                    <option
                                        value="8" {{ request()->input('min_order_hrs') == '8.00' ? 'selected' : '' }}>
                                        8
                                    </option>
                                    <option
                                        value="9" {{ request()->input('min_order_hrs') == '9.00' ? 'selected' : '' }}>
                                        9
                                    </option>
                                    <option
                                        value="10" {{ request()->input('min_order_hrs') == '10.00' ? 'selected' : '' }}>
                                        10
                                    </option>
                                    <option
                                        value="11" {{ request()->input('min_order_hrs') == '11.00' ? 'selected' : '' }}>
                                        11
                                    </option>
                                    <option
                                        value="12" {{ request()->input('min_order_hrs') == '12.00' ? 'selected' : '' }}>
                                        12
                                    </option>
                                </select>
                            </div>
                        </div>
                        <hr class="w-100">

                        <div class="row col-md-12 mb-9">
                            <div class="col-md-12 mb-4">
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
                                    <div class="col-3">
                                        <label for="price_to_customer" style="display: none"></label>
                                        <input type="text" id="price_to_customer" name="price_to_customer"
                                               class="form-control" value="{{ request()->input('price_to_customer') }}">

                                    </div>
                                    <div class="col-4">
                                        <label for="price_to_workers" style="display: none"></label>
                                        <input type="text" id="price_to_workers" name="price_to_workers"
                                               class="form-control" value="{{ request()->input('price_to_workers') }}">
                                    </div>
                                    <div class="col-5">
                                        <label for="rate" style="display: none"></label>
                                        <select id="rate" name="rate" class="form-control">
                                            <option value="200/100">200/100</option>
                                            <option value="300/400">300/400</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Сума мінімального замовлення</label>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label for="min_order_amount" style="display: none"></label>
                                <input type="text" id="min_order_amount" name="min_order_amount" class="form-control"
                                       value="{{ request()->input('min_order_amount') }}" required>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label for="">грн.</label>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="phone">Мінімальне замовлення</label>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label for="order_hrs" style="display: none"></label>
                                <select id="order_hrs" name="order_hrs" class="form-control">
                                    <option value="" disabled selected></option>
                                    <option value="1" {{ request()->input('order_hrs') == '1.00' ? 'selected' : '' }}>1
                                    </option>
                                    <option value="2" {{ request()->input('order_hrs') == "2.00" ? 'selected' : '' }}>2
                                    </option>
                                    <option value="3" {{ request()->input('order_hrs') == '3.00' ? 'selected' : '' }}>3
                                    </option>
                                    <option value="4" {{ request()->input('order_hrs') == '4.00' ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5" {{ request()->input('order_hrs') == '5.00' ? 'selected' : '' }}>5
                                    </option>
                                    <option value="6" {{ request()->input('order_hrs') == '6.00' ? 'selected' : '' }}>6
                                    </option>
                                    <option value="7" {{ request()->input('order_hrs') == '7.00' ? 'selected' : '' }}>7
                                    </option>
                                    <option value="8" {{ request()->input('order_hrs') == '8.00' ? 'selected' : '' }}>8
                                    </option>
                                    <option value="9" {{ request()->input('order_hrs') == '9.00' ? 'selected' : '' }}>9
                                    </option>
                                    <option value="10" {{ request()->input('order_hrs') == '10.00' ? 'selected' : '' }}>
                                        10
                                    </option>
                                    <option value="11" {{ request()->input('order_hrs') == '11.00' ? 'selected' : '' }}>
                                        11
                                    </option>
                                    <option value="12" {{ request()->input('order_hrs') == '12.00' ? 'selected' : '' }}>
                                        12
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label for="">годин</label>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="">Примітка до оплати</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="payment_note" style="display: none"></label>
                                <textarea id="payment_note" name="payment_note" class=" mb-3 form-control" rows="3"
                                          placeholder="">{{ request()->input('payment_note') }}</textarea>
                            </div>
                        </div>

                        <div class="row col-md-10 mb-9">
                            <div class="col-md-4 mb-4">
                                <label for="logist">Призначити логіста</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="user_logist_id" style="display: none"></label>
                                <select id="user_logist_id" name="user_logist_id" class="form-control">
                                    <option value="" disabled selected></option>
                                    @foreach($logists as $logist)
                                        <option
                                            value="{{ $logist->id }}" {{ request()->input('user_logist_id') == $logist->id ? 'selected' : '' }}>{{ $logist->name }} {{ $logist->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="w-100">
                    <div class="row col-md-10 mb-14">
                        <div class="col-md-4 mb-4">
                            <button type="submit" class="btn btn-primary px-3 mr-2">Зберегти</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

