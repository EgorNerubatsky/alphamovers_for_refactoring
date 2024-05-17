@extends('erp.content')

@section('title')
    <h2>Заборгованість</h2>
@endsection

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
                    <button type="button" data-toggle="collapse" href="#searchForm" aria-expanded="false"
                            aria-controls="searchForm" class="btn mb-1 btn-outline-dark" style="width: 200px;">
                        Розширений пошук
                    </button>
                </div>
                <div class="col-md-6  ml-auto">
                    <form action="{{ route($roleData['roleData']['arrears_search']) }}" method="GET">
                        <div class="input-group">
                            <label for="search" style="display: none"></label><input type="text" id="search"
                                                                                     name="search"
                                                                                     class="form-control rounded-left"
                                                                                     value="{{ Request::get('search') }}"
                                                                                     style="height: 40px;">
                            <div class="append">
                                <button class="btn btn-outline-dark rounded-1" type="submit" style="height: 40px;">
                                    Пошук
                                </button>
                                <a href="{{ route($roleData['roleData']['arrears_index']) }}"
                                   class="btn btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <br>
                    <form action="{{ route($roleData['roleData']['arrears_index']) }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="start_date" style="font-size: 14px;">Дата договору від</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                       value="{{ Request::get('start_date') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="end_date" style="font-size: 14px;">Дата договору до</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                       value="{{ Request::get('end_date') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="type" style="font-size: 14px;">Тип клієнта</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="" {{ request()->input('type') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($clientTypes as $clientType)
                                        <option
                                            value="{{ $clientType }}" {{ request()->input('type') ==  $clientType ? 'selected' : '' }}>{{ $clientType }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="company" style="font-size: 14px;">Назва компанії</label>
                                <select id="company" name="company" class="form-control">
                                    <option value="" {{ request()->input('company') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($companys as $company)
                                        <option
                                            value="{{ $company }}" {{ request()->input('company') ==  $company ? 'selected' : '' }}>{{ $company }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="amount_from">Сума від</label>
                                <input id="amount_from" name="amount_from" class="form-control"
                                       value="{{ Request::get('amount_from') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="amount_to">Сума до</label>
                                <input id="amount_to" name="amount_to" class="form-control"
                                       value="{{ Request::get('amount_to') }}">
                            </div>

                        </div>

                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['arrears_index']) }}" class="btn btn-secondary">Скинути</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-content">
                        <div class="stat-text">Усьго компанії</div>
                        <div class="stat-digit gradient-3-text">{{ $companys->count() }}</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-content">
                        <div class="stat-text">Компаній боржників</div>
                        <div class="stat-digit gradient-4-text">{{ $arrears->unique('client_id')->count() }}</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-content">
                        <div class="stat-text">Заборгованість на користь компанії</div>
                        <div class="stat-digit gradient-5-text"><i
                                class="fa fa-usd"></i>{{ $arrears->sum('total_revenue') }} грн.
                        </div>
                    </div>
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
                        <a style="font-size: 12px;">
                            ID
                        </a>
                    </th>

                    <th style="width: 50px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;">
                            ID Замовлення
                        </a>
                    </th>


                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['arrears_index'], ['sort' => 'company', 'order' => Request::input('sort') == 'company' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            Компанія
                            @if(Request::input('sort') == 'company' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'company' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>


                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['arrears_index'], ['sort' => 'work_debt', 'order' => Request::input('sort') == 'work_debt' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            Борг з робіт
                            @if(Request::input('sort') == 'work_debt' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'work_debt' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>


                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['arrears_index'], ['sort' => 'days_from_order', 'order' => Request::input('sort') == 'days_from_order' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            Днів після виконаного замовлення
                            @if(Request::input('sort') == 'days_from_order' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'days_from_order' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>


                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['arrears_index'], ['sort' => 'current_year_revenue', 'order' => Request::input('sort') == 'current_year_revenue' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            Виручка за поточний рік
                            @if(Request::input('sort') == 'current_year_revenue' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'current_year_revenue' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['arrears_index'], ['sort' => 'total_revenue', 'order' => Request::input('sort') == 'total_revenue' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            Виручка загальна
                            @if(Request::input('sort') == 'total_revenue' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'total_revenue' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>

                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 14px;"
                           href="{{ route($roleData['roleData']['arrears_index'], ['sort' => 'contract_date', 'order' => Request::input('sort') == 'contract_date' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            Дата контракту
                            @if(Request::input('sort') == 'contract_date' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'contract_date' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>

                    <th style="width: 50px; text-align: center; vertical-align: middle;">
                        Коментар
                    </th>

                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Дія
                    </th>
                </tr>
                </thead>


                <tbody>
                @foreach($arrears as $arrear)
                    <tr>

                        <td class="small-font text-center">
                            {{ $arrear->getKey() }}
                        </td>

                        <td class="small-font text-center">
                            {{ $arrear->order->getKey() }}
                        </td>

                        <td class="text-center">
                            <strong>{{ $arrear->client->company }}</strong>
                        </td>

                        <td class="text-center">
                            ₴ <strong style="color:#B22222">{{ $arrear->work_debt }}</strong> грн.
                        </td>

                        @php
                            $now = now();
                            $execution = $arrear->created_at;
                            $daysDifference = $now->diffInDays($execution);
                        @endphp
                        <td class="text-center">
                            <strong>{{ $daysDifference }}</strong>
                        </td>

                        <td class="text-center">
                            ₴ <strong style="color:#B22222">{{ $arrear->current_year_revenue }}</strong> грн.
                        </td>
                        <td class="text-center">
                            ₴ <strong style="color:#B22222">{{ $arrear->total_revenue }}</strong> грн.
                        </td>

                        <td class="small-font text-center">
                            <i class="far fa-calendar-alt"></i> {{ optional($arrear->order->documentsPaths->where('description', 'Договiр')->first())->created_at ? $arrear->order->documentsPaths->where('description', 'Договiр')->first()->created_at->format('d.m.Y') : '' }}
                            <br>
                            <i class="far fa-clock"></i> {{ optional($arrear->order->documentsPaths->where('description', 'Договiр')->first())->created_at ? $arrear->order->documentsPaths->where('description', 'Договiр')->first()->created_at->format('H:i') : '' }}

                        </td>

                        <td class="text-center">
                            {{ $arrear->comment }}
                        </td>

                        <td class="text-center">
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-header">
                <div class="card-tools">
                    {{ $arrears->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

