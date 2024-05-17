@extends('erp.content')
@section('title')
    <h2>Банківські операції</h2>
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
                    <form action="{{ route($roleData['roleData']['finances_search']) }}" method="GET">
                        <div class="input-group">
                            <label for="search" style="display: none"></label>
                            <input type="text" id="search" name="search" class="form-control rounded-left"
                                   value="{{ Request::get('search') }}" style="height: 40px;">
                            <div class="input-group-append">
                                <button class="btn btn-outline-dark rounded-0" type="submit" style="height: 40px;">
                                    Пошук
                                </button>
                                <a href="{{ route($roleData['roleData']['finances_index']) }}"
                                   class="btn mb-1 btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <br>
                    <form action="{{ route($roleData['roleData']['finances_index']) }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="start_date">Період створення від</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                       value="{{ Request::get('start_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="end_date">Період створення до</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                       value="{{ Request::get('end_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="payer">Платник</label>
                                <select id="payer" name="payer" class="form-control">
                                    <option value="" {{ request()->input('payer') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($payers as $payer)
                                        <option
                                            value="{{ $payer }}" {{ request()->input('payer') == $payer ? 'selected' : '' }}>{{ $payer }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Одержувач</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="" {{ request()->input('beneficiary') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($beneficiarys as $beneficiary)
                                        <option
                                            value="{{ $beneficiary }}" {{ request()->input('beneficiary') == $beneficiary ? 'selected' : '' }}>{{ $beneficiary }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="amount_from">Сума від</label>
                                <input id="amount_from" name="amount_from" class="form-control"
                                       value="{{ Request::get('amount_from') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="amount_to">Сума до</label>
                                <input id="amount_to" name="amount_to" class="form-control"
                                       value="{{ Request::get('amount_to') }}">
                            </div>
                        </div>
                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['finances_index']) }}" class="btn btn-secondary">Скинути</a>
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
                        <a style="font-size: 14px;"
                           href="{{ route($roleData['roleData']['finances_index'], ['sort' => 'created_at', 'order' => Request::input('sort') == 'created_at' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'created_at' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'created_at' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Дата
                        </a>
                    </th>
                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['finances_index'], ['sort' => 'amount', 'order' => Request::input('sort') == 'amount' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'amount' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'amount' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Сума
                        </a>
                    </th>
                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        Платник
                    </th>
                    <th style="width: 100px; text-align: center; vertical-align: middle;">
                        Одержувач платежу
                    </th>
                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        Призначення платежу
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($bankOperations as $bankOperation)
                    <tr>
                        <td class="small-font text-center">
                            {{ $bankOperation->getKey() }}
                        </td>
                        <td class="small-font text-center">
                            <i class="far fa-calendar-alt"></i> {{ $bankOperation->created_at->format('d.m.Y') }}
                        </td>
                        <td class="text-center">
                            ₴ <strong style="color:#008000;">{{ $bankOperation->amount }}</strong> грн.
                        </td>
                        <td class="small-font text-center">
                            <strong>{{ $bankOperation->payer }}</strong>
                        </td>
                        <td class="small-font text-center">
                            {{ $bankOperation->beneficiary }}
                        </td>
                        <td class="small-font text-center">
                            Рахунок № <strong>{{ $bankOperation->document_number }}</strong>
                            <br> {{ $bankOperation->payment_purpose }}
                        </td>
                        <td class="text-center">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-header">
                <div class="card-tools">
                    {{ $bankOperations->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
