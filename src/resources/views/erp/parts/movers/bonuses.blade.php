<div class="form-row mb-3 mt-3">
    <div class="col-md-4">
        <h3 class="card-title">@yield('title')</h3>
    </div>
    <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
        <a href="{{ route($roleData['roleData']['movers_create']) }}" class="btn mb-1 btn-outline-dark">Додати
            робочого</a>
    </div>

    <div class="input-group">
        <div class="input-group-append">
            <a href="{{ route($roleData['roleData']['movers_index']) }}" class="btn btn-outline-dark" type="submit"
               style="height: 40px;">Список робочих</a>
            <a href="{{ route($roleData['roleData']['movers_planning']) }}" class="btn btn-outline-dark" type="submit"
               style="height: 40px;">Планування/Фінанси</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-4">
                <button type="button" data-toggle="collapse" href="#searchForm" aria-expanded="false"
                        aria-controls="searchForm" class="btn mb-1 btn-outline-dark" style="width: 200px;"> Розширений
                    пошук
                </button>
            </div>
            <div class="col-md-6  ml-auto">
                <form action="{{ route($roleData['roleData']['movers_planning_search']) }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control rounded-left"
                               value="{{ Request::get('search') }}" style="height: 40px;">
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark rounded-0" type="submit" style="height: 40px;">Пошук
                            </button>
                            <a href="{{ route($roleData['roleData']['movers_planning']) }}"
                               class="btn mb-1 btn-outline-info" style="height: 40px;">Скинути</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="basic-form">
            <div id="searchForm" class="collapse">
                <form action="{{ route($roleData['roleData']['movers_planning']) }}" method="GET">
                    <div class="form-row mt-4">
                        <div class="form-group col-md-4">
                            <label for="start_date">Період виконання від</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                   value="{{ Request::get('start_date') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="end_date">Період виконання до</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                   value="{{ Request::get('end_date') }}">
                        </div>
                    </div>
                    <div class="form-row justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Показати</button>
                        <a href="{{ route($roleData['roleData']['movers_planning']) }}" class="btn btn-secondary">Скинути</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>Замовлення</th>
                    <th>Ціна на замовлення</th>
                    <th>Виплата робітникам</th>
                    <th>Залишок компанії</th>
                    <th>Вантажники</th>
                    <th>Оплата</th>
                    <th>Премія</th>

                    <th>Примітка</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    @if($order->status == 'Виконано')
                        <tr>
                            <td>{{ $order->getKey() }}</td>

                            <td>
                                <i class="far fa-calendar-alt"></i> {{ date('d.m.Y', strtotime($order->execution_date)) }}
                                <br>
                                <i class="far fa-clock"></i> {{ date('H:i', strtotime($order->execution_date)) }}
                                <br>
                                <strong style="color: #2F4F4F;">{{ $order->client->company }}</strong><br>

                                <strong>{{ $order->city }},</strong><br>
                                <strong style="color: grey;">{{ $order->street }}</strong><br>

                                <br>
                            </td>

                            <td class="small-font text-center" style="color: #B22222;">
                                ₴ <strong>{{$order->total_price}}</strong> грн.
                            </td>

                            <td class="small-font text-center" style="color: #B22222;">
                                ₴ <strong>{{$order->price_to_workers}}</strong> грн.
                            </td>

                            <td class="small-font text-center" style="color: #B22222;">
                                ₴ <strong>{{$order->price_to_customer}}</strong> грн.
                            </td>

                            <td>
                                @foreach($order->orderDatesMovers as $orderDatesMover)
                                    <span class="badge"
                                          style="color: #4682B4; font-size: 16px;">{{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }}</span>
                                    <br>
                                @endforeach
                            </td>

                            <td>
                                @foreach($order->orderDatesMovers as $orderDatesMover)
                                    @if($orderDatesMover->paid == true)
                                        <span class="badge badge-success">Оплачено</span><br>
                                    @else
                                        <span class="badge badge-danger"><a href="#" data-toggle="modal"
                                                                            data-target="#editModal2{{ $orderDatesMover->id }}"
                                                                            style="color:white;">Оплатити</a></span><br>
                                        @include('erp.parts.movers.pay_modal')
                                    @endif
                                @endforeach

                            </td>

                            <td>
                                @foreach($order->orderDatesMovers as $orderDatesMover)
                                    @if($orderDatesMover->bonus != 0)
                                        <span
                                            class="badge badge-success">Премія: {{ $orderDatesMover->bonus }} грн.</span>
                                        <br>

                                    @else
                                        <span class="badge badge-primary"><a href="#" data-toggle="modal"
                                                                             data-target="#editModal3{{ $orderDatesMover->id }}"
                                                                             style="color:white;">+ премія</a></span>
                                        <br>
                                        @include('erp.parts.movers.modal')

                                    @endif
                                @endforeach
                            </td>

                            <td>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="card-header">
                <div class="card-tools">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>


