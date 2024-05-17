@extends('erp.content')

@section('title') Замовлення @endsection

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
                    <form action="{{ route('erp.accountant.orders.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control rounded-left" value="{{ Request::get('search') }}"  style="height: 40px;">
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark rounded-0" type="submit" style="height: 40px;">Пошук</button>
                                <a href="{{ route('erp.accountant.orders.index') }}" class="btn mb-1 btn-outline-info" style="height: 40px;">Скинути</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>


            <div class="basic-form">
                <div id="searchForm"  class="collapse">
                    <br>
                    <form action="{{ route('erp.accountant.orders.index') }}" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="start_date">Період створення від</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ Request::get('start_date') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="end_date">Період створення до</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ Request::get('end_date') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="start_date">Період виконання від</label>
                            <input type="date" id="start_execution_date" name="start_execution_date" class="form-control" value="{{ Request::get('start_execution_date') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="end_date">Виконання до</label>
                            <input type="date" id="end_execution_date" name="end_execution_date" class="form-control" value="{{ Request::get('end_execution_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="brigadier">Бригадир</label>
                            <select id="brigadier" name="brigadier" class="form-control">
                                <option value="">Всі</option>
                                @foreach($brigadiers as $brigadier)
                                <option value="{{ $brigadier->user_mover_id }}" {{ request()->input('brigadier') == $brigadier->id ? 'selected' : '' }}>{{ $brigadier->mover->name }} {{ $brigadier->mover->lastname }}</option>
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
                        <a href="{{ route('erp.accountant.orders.index') }}" class="btn btn-secondary">Скинути</a>
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
                            <a style="font-size: 12px;" href="{{ route('erp.accountant.orders.index', ['sort' => 'created_at', 'order' => Request::input('sort') == 'created_at' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'created_at' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'created_at' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Створено
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;" href="{{ route('erp.accountant.orders.index', ['sort' => 'execution_date', 'order' => Request::input('sort') == 'execution_date' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                        <a style="font-size: 12px;" href="{{ route('erp.accountant.orders.index', ['sort' => 'brigadier', 'order' => Request::input('sort') == 'brigadier' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'brigadier' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"> </i>
                                @elseif(Request::input('sort') == 'brigadier' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"> </i>
                                @else
                                    <i class="fas fa-sort"> </i>
                                @endif
                                Бригадир
                            </a>
                        </th>

                        <th style="width: 100px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.accountant.orders.index', ['sort' => 'company', 'order' => Request::input('sort') == 'company' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'company' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'company' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Клієнт
                            </a>
                        </th>

                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.accountant.orders.index', ['sort' => 'total_price', 'order' => Request::input('sort') == 'total_price' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                                @if(Request::input('sort') == 'total_price' && Request::input('order') == 'asc')
                                    <i class="fas fa-sort-down"></i>
                                @elseif(Request::input('sort') == 'total_price' && Request::input('order') == 'desc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                                Сума
                            </a>
                        </th>



                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Документи
                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 12px;" href="{{ route('erp.accountant.orders.index', ['sort' => 'status', 'order' => Request::input('sort') == 'status' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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

                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                        </th>
                    </tr>
                </thead>


                <tbody>
                @foreach($orders->where('status', '!=', 'Попереднє замовлення') as $order)
                <tr>

                <td class="small-font text-center">{{ $order->getKey() }}</td>
                <td class="small-font text-center">
                    <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d.m.Y') }}
                    <br>
                    <i class="far fa-clock"></i> {{ $order->created_at->format('H:i') }}
                </td>

                <td class="small-font text-center">
                    <i class="far fa-calendar-alt"></i> {{ date('d.m.Y', strtotime($order->execution_date)) }}
                    <br>
                    <i class="far fa-clock"></i> {{ date('H:i', strtotime($order->execution_date)) }}
                    <br>
                </td>

                <td class="small-font text-center">
                    <br>
                    @foreach($order->orderDatesMovers as $orderDatesMover)
                        @if($orderDatesMover->is_brigadier == true)
                        <span style="color: #20B2AA;">
                            {{ $orderDatesMover->mover->name }} {{ $orderDatesMover->mover->lastname }}<br>
                            (Бригадир)
                        </span>
                        @endif
                        @endforeach
                    <br>
                    {{ $order->number_of_workers.' вантаж.' }}
                </td>

                <td class="small-font text-center">
                    @if(isset($order->client->company))
                    <strong>{{ $order->client->company }}</strong>
                    @endif
                    <hr>
                    <span style="color: #20B2AA;">
                        @if(isset($order->client->clientContacts))
                        {{ explode(' ',
                        $order->client->clientContacts->clientContactPersonDetails->first()->complete_name)[0] }}
                        @endif
                        @if(isset($order->client->clientContacts))
                        {{ $order->client->clientContacts->clientContactPersonDetails->first()->client_phone }}
                        @endif
                    </span>
                </td>

                <td class="text-center">
                    ₴ <strong style="color: #006400;">{{ $order->total_price }}</strong> грн.
                </td>

                <td>
                    @if(count($order->documentsPaths)>0)
                        @if(count($order->documentsPaths->where('description', 'Акт')) > 0)
                            @foreach($order->documentsPaths->where('description', 'Акт') as $documentPath)
                                <a href="{{ asset($documentPath->path) }}" target="_blank">
                                    <i class="fas fa-download"></i> <span class="badge badge-success mb-1">Скачати Акт № {{
                                        pathinfo($documentPath->path, PATHINFO_FILENAME) }}</span> <br>
                                </a>
                            @endforeach
                        @else
                            <a href="{{ route('erp.accountant.orders.edit', ['order' => $order->getKey()]) }}"
                                class="btn btn-block mt-2" style="background-color: #20B2AA; color: black;">Акт</a>
                        @endif

                        @if(count($order->documentsPaths->where('description', 'Рахунок')) > 0)
                            @foreach($order->documentsPaths->where('description', 'Рахунок') as $documentPath)
                            <a href="{{ asset($documentPath->path) }}" target="_blank">
                                <i class="fas fa-download"></i> <span class="badge badge-success mb-1">Скачати Рахунок № {{
                                    pathinfo($documentPath->path, PATHINFO_FILENAME) }}</span> <br>
                            </a>
                            @endforeach

                        @else

                                <a href="{{ route('erp.accountant.orders.edit', ['order' => $order->getKey()]) }}" class="btn mb-1 btn-outline-info" style="height: 40px;">Рахунок</a>

                            @endif

                    @elseif(count($order->documentsPaths->where('description', 'Акт')) == 0)
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('erp.accountant.orders.edit', ['order' => $order->getKey()]) }}"><span class="badge badge-secondary">Рахунок</span></a>

                        </div>
                        <div class="col-md-6">

                            <a href="{{ route('erp.accountant.orders.edit', ['order' => $order->getKey()]) }}"><span class="badge badge-success">Акт</span></a>

                        </div>
                    </div>
                    @endif
                </td>

                <td class="text-center">
                    @switch($order->status)
                    @case('Попереднє замовлення')
                    <span class="badge badge-primary">{{ $order->status }}</span>

                    @if(isset($order->user_manager_id))
                    <span style="color: #5F9EA0;">
                        Менеджер: {{ $order->user->name }}
                    </span>
                    @endif

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

                <td class="text-center">
                    <div class="btn-group-horizontal">
                        <a href="{{ route('erp.accountant.orders.edit', ['order' => $order->getKey()]) }}"
                            class="btn btn-warning btn-sm mb-2 rounded" data-toggle="tooltip" title="Редагувати">
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

@endsection
