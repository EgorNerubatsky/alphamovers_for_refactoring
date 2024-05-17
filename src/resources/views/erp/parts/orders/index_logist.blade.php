@extends('erp.content')

@section('title') <h2>Замовлення</h2> @endsection

@section('content')

    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-4">
                    <button type="button" data-toggle="collapse" href="#searchForm" aria-expanded="false" aria-controls="searchForm"  class="btn mb-1 btn-outline-dark" style="width: 200px;">  Розширений пошук  </button>
                </div>
                <div class="col-md-6  ml-auto">
                    <form action="{{ route('erp.logist.orders.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control rounded-left" value="{{ Request::get('search') }}"  style="height: 40px;">
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark rounded-0" type="submit" style="height: 40px;">Пошук</button>
                            <a href="{{ route('erp.logist.orders.index') }}" class="btn mb-1 btn-outline-info" style="height: 40px;">Скинути</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="basic-form">
                <div id="searchForm"  class="collapse">
                    <br>
                    <form action="{{ route('erp.logist.orders.index') }}" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="start_date">Період виконання від</label>
                            <input type="date" id="start_execution_date" name="start_execution_date" class="form-control" value="{{ Request::get('start_execution_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date">Виконання до</label>
                            <input type="date" id="end_execution_date" name="end_execution_date" class="form-control" value="{{ Request::get('end_execution_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="manager">Менеджер</label>
                            <select id="manager" name="manager" class="form-control">
                                <option value="">Всі</option>
                                @foreach($managers as $name=>$id)
                                <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="status">Статус</label>
                            <select id="status" name="status" class="form-control">
                                <option value="" {{ request()->input('status') == 'Всі' ? 'selected' : '' }}>Всі</option>
                                <option value="Попереднє замовлення" {{ request()->input('status') == 'Попереднє замовлення' ? 'selected' : '' }}>Попереднє замовлення</option>
                                <option value="В роботі" {{ request()->input('status') == 'В роботі' ? 'selected' : '' }}>В роботі</option>
                                <option value="Виконано" {{ request()->input('status') == 'Виконано' ? 'selected' : '' }}>Виконано</option>
                                <option value="Скасовано" {{ request()->input('status') == 'Скасовано' ? 'selected' : '' }}>Скасовано</option>
                                <option value="Видалено" {{ request()->input('status') == 'Видалено' ? 'selected' : '' }}>Видалено</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="amount_from">Сума від</label>
                            <input type="input" id="amount_from" name="amount_from" class="form-control" value="{{ Request::get('amount_from') }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="amount_to">Сума до</label>
                            <input type="input" id="amount_to" name="amount_to" class="form-control" value="{{ Request::get('amount_to') }}">
                        </div>
                    </div>

                    <div class="form-row justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Показати</button>
                        <a href="{{ route('erp.logist.orders.index') }}" class="btn btn-secondary">Скинути</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>








    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'execution_date', 'order' => Request::input('sort') == 'execution_date' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'execution_date' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"> </i>
                            @elseif(Request::input('sort') == 'execution_date' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"> </i>
                            @else
                                <i class="fas fa-sort"> </i>
                            @endif
                            Виконати до
                            </a>
                        </th>



                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'city', 'order' => Request::input('sort') == 'city' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'city' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'city' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Опис
                            </a>
                        </th>

                        <th style="width: 100px; text-align: center; vertical-align: middle;">
                                Вантажники
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'total_price', 'order' => Request::input('sort') == 'total_price' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'total_price' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'total_price' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Ціна<br>на замовлення

                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'price_to_workers', 'order' => Request::input('sort') == 'price_to_workers' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'price_to_workers' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'price_to_workers' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Виплата<br>робітникам

                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'price_to_customer', 'order' => Request::input('sort') == 'price_to_customer' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'price_to_customer' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'price_to_customer' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Залишок<br> компанії
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'payment_note', 'order' => Request::input('sort') == 'payment_note' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'payment_note' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'payment_note' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Коментар
                            </a>
                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'status', 'order' => Request::input('sort') == 'status' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'status' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'status' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Статус
                            </a>
                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.logist.orders.index', ['sort' => 'manager', 'order' => Request::input('sort') == 'manager' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'manager' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'manager' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Менеджер
                            </a>
                        </th>

                        <th style="width: 150px; text-align: center; vertical-align: middle;">

                        </th>
                    </tr>
                </thead>


                <tbody>
                    @foreach($orders as $order)
                    <tr>

                        <td class="small-font text-center">{{ $order->getKey() }}</td>
                        <td class="small-font">
                            <i class="far fa-calendar-alt"></i> {{ date('d.m.Y', strtotime($order->execution_date)) }}
                            <br>
                            <i class="far fa-clock"></i> {{ date('H:i', strtotime($order->execution_date)) }}
                        </td>

                        <td class="small-font" style ="width:250px;">
                            <strong>{{ $order->city }}</strong>
                            <strong style="color: grey;">{{ $order->street }}</strong>
                            <br>
                            {{ $order->task_description }}
                            <br>
                            @if($order->straps == true)
                            <span class="badge badge-primary">Ремені</span>
                            @endif
                            @if($order->tools == true)
                            <span class="badge badge-primary">Iструменти</span>
                            @endif
                            @if($order->respirators == true)
                            <span class="badge badge-primary">Маски</span>
                            @endif
                            <p style="color: grey;" class ="mt-2">{{ explode(' ', $order->client->clientContactPersonDetails->first()->complete_name)[0] }},
                            {{ $order->client->clientContactPersonDetails->first()->client_phone }}
                            </p>
                        </td>

                        @if($order->status == 'Попереднє замовлення')
                        <td class="small-font" style ="width:300px;">
                                    @if($order->orderDatesMovers->isEmpty())
                                    <span class="badge badge-warning">Потрiбно: {{ $order->number_of_workers }} вантаж.</span>
                                    @else
                                        @php
                                            $totalMovers = $order->orderDatesMovers->count();
                                            $needMovers = $order->number_of_workers - $totalMovers;
                                        @endphp

                                        @foreach($order->orderDatesMovers as $orderDatesMover)

                                            @if($orderDatesMover->is_brigadier == true)
                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#confirmationModal" data-delete-url="{{ route('erp.logist.orders.removeMover', ['id' => $orderDatesMover->getKey()]) }}">x</a>

                                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Пiдтвердження</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Ви впевнені, що бажаєте видалити?
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Вiдмiна</button>
                                                                <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <span class="badge" style="color: red;">{{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }}</span>
                                            <span class="badge badge-primary">Бр.</span>

                                            <br>

                                            @elseif($orderDatesMover->is_empty == true)
                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#confirmationModal" data-delete-url="{{ route('erp.logist.orders.removeMover', ['id' => $orderDatesMover->getKey()]) }}">x</a>

                                            <span class="badge" style="color: grey;">{{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }} (Зайнятий)</span><br>


                                            @else
                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#confirmationModal" data-delete-url="{{ route('erp.logist.orders.removeMover', ['id' => $orderDatesMover->getKey()]) }}">x</a>

                                            <span class="badge" style="color: green;">{{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }}</span><br>

                                            @endif
                                            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Пiдтвердження</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Ви впевнені, що бажаєте видалити?
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Вiдмiна</button>
                                                            <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                        <br>
                                        @if($needMovers > 0)
                                        <span class="badge badge-warning">Потрiбно: {{ $needMovers }} вантаж.</span>
                                        @elseif($needMovers < 0)
                                        <span class="badge badge-danger">Перевищено кiлькiсть вантаж на: {{ abs($needMovers) }}</span>

                                        @endif
                                @endif
                                        <br>
                            <a href="" class="btn mt-2 mr-2" style="background-color: #66CDAA;"
                                data-toggle="modal" data-target="#addMoverModal_{{ $order->getKey() }}">Призначити</a>









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

                                    <form action="{{ route('erp.logist.orders.addMover', ['id' => $order->getKey()]) }}" method="POST">
                                        @csrf


                                        <div class="row">
                                                <div class="col-md-7 ml-2">
                                                    <label for="form-check-input" class="col-form-label">Вантажники:</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="form-check-input" class = "col-form-label">Бригадир:</label>
                                                </div>
                                        </div>
                                        <hr>

                                                @foreach($moversAdds as $mover)
                                        <div class="row ml-4">
                                                <div class="col-md-10 form-group">
                                                    <input type="checkbox" name="user_mover_id[]" value="{{$mover->id}}" class="form-check-input">
                                                    <label class="form-check-label">{{ $mover->name }} {{ $mover->lastname }} </label>
                                                </div>

                                                <div class="col-md-2 form-group">
                                                    <input type="radio" name="is_brigadier_{{ $mover->id }}" value="1" class="form-check-input">
                                                </div>
                                        </div>
                                                @endforeach


                                        <div class="modal-footer">
                                            <button type="submit" class="btn mt-2" style="background-color: #66CDAA;">Добавить</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        @else
                        <td class="small-font" style ="width:200px;">
                            @foreach($order->orderDatesMovers as $orderDatesMover)
                                @if($orderDatesMover->is_brigadier == true)
                                <span class="badge" style="color: red;">{{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }} (Бригадир)</span><br>
                                @else
                                <span class="badge" style="color: green;">{{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }}</span><br>
                                @endif
                            @endforeach
                        </td>
                        @endif

                        @if($order->status == 'Виконано')

                            <td class="small-font text-center" style="color: #B22222; font-weight: bold;">
                                ₴ <strong>{{$order->total_price}}</strong> грн.
                            </td>

                            <td class="small-font text-center" style ="color: #B22222; font-weight: bold;">
                                ₴ <strong>{{$order->price_to_workers}}</strong> грн.
                            </td>

                            <td class="small-font text-center" style ="color: #B22222; font-weight: bold;">
                                ₴ <strong>{{$order->price_to_customer}}</strong> грн.
                            </td>

                        @elseif($order->status == 'В роботі')

                            <td colspan="3">
                                <a href="{{ route('erp.logist.orders.completion', ['id' => $order->getKey(), 'request'=>'Виконано']) }}" class="btn btn-block" style="background-color: #00FA9A; color: black;">Завершити заявку</a>
                            </td>

                        @elseif($order->status == 'Попереднє замовлення')

                            @if(!empty($order->orderDatesMovers->count()))

                            <td colspan="3">
                                <a href="{{ route('erp.logist.orders.completion', ['id' => $order->getKey(), 'request'=>'В роботі']) }}" class="btn btn-block" style="background-color: #00FFFF; color: black;">Взяти у роботу</a>

                                </a>
                            </td>

                            @else
                            <td colspan="3">
                                <a href="" class="btn btn-block" style="background-color: #778899; color: black;">Потрiбно додати вантажникiв</a>

                            </td>

                            @endif

                        @else
                            <td class="small-font text-center">
                            </td>

                            <td class="small-font text-center">
                            </td>

                            <td class="small-font text-center">
                            </td>

                        @endif
                        <td class="small-font">
                            {{ $order->payment_note }}

                        </td>
                        <td class="text-center">
                            @switch($order->status)
                                @case('Попереднє замовлення')
                                <span class="badge badge-primary">{{ $order->status }}</span>
                                @break

                                @case('В роботі')
                                <span class="badge badge-danger">{{ $order->status }}</span>
                                @break
                                @case('Скасовано')
                                <span class="badge badge-secondary">{{ $order->status }}</span>
                                @break
                                @case('Виконано')
                                <span class="badge badge-success">{{ $order->status }}</span>
                                @break
                                @case('Видалено')
                                <span class="badge badge-secondary">{{ $order->status }}</span>
                                @break

                            @endswitch
                        </td>



                        <td class="small-font; text-center" style ="width:200px;">
                            @if(isset($order->user_manager_id))
                            <span style="color: #20B2AA;">
                                {{ $order->user->name }}<br>
                                {{ $order->user->phone }}
                            </span>
                            @endif
                        </td>



                        <td class="text-center">
                            <div class="btn-group-horizontal">
                                <a href="{{ route('erp.logist.orders.edit', ['order' => $order->getKey()]) }}" class="btn btn-warning btn-sm rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
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

@endsection
