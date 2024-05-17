@extends('erp.content')

@section('title') <h2>Звіт</h2> @endsection

@section('content')
<div class="form-row mb-3 mt-3">
    <div class="col-md-4">
        <h3 class="card-title">@yield('title')</h3>
    </div>    
</div>
<script>
    window.chartData = {
        labels: @json($labels),
        data: @json($data),
        balance: @json($balance)
    };
</script>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            @if(Auth::user()->is_manager)
            <form action="{{ route('erp.manager.report') }}" method="GET">
            @elseif(Auth::user()->is_executive)
            <form action="{{ route('erp.executive.report') }}" method="GET">
            @elseif(Auth::user()->is_accountant)
            <form action="{{ route('erp.accountant.report') }}" method="GET">
            @endif
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="start_date">Період створення від</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ Request::get('start_date') }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="end_date">Період створення до</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ Request::get('end_date') }}">
                </div>

                
            </div>

            <div class="form-row justify-content-end">
                <button type="submit" class="btn btn-primary mr-2">Показати</button>
                @if(Auth::user()->is_manager)
                <a href="{{ route('erp.manager.report') }}" class="btn btn-secondary">Скинути</a>
                @elseif(Auth::user()->is_executive)
                <a href="{{ route('erp.executive.report') }}" class="btn btn-secondary">Скинути</a>
                @elseif(Auth::user()->is_accountant)
                <a href="{{ route('erp.accountant.report') }}" class="btn btn-secondary">Скинути</a>
                @endif
            </div>
            </form>
        </div>
        
    </div>
</div>







<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Графік за вибраний період</h4>
                    <canvas id="myChart3"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Графік за вибраний період</h4>
                    <canvas id="myChart4"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">

    <div class="card">
            <div class="card-header">
                <h3 class="card-title">Транзакції за вибраний період</h3>
            </div>
        <!-- /.card-header -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr >
                            <th style="width: 50px; text-align: center; vertical-align: middle;">
                                <a style="font-size: 14px;">
                                Дата транзакції
                                </a>
                            </th>

                            <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Виконано робіт
                            </th>

                            <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Прибуток
                            </th>

                            <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Залишок компанії (на дату транзакції)
                            </th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($labels as $index=>$label)
                <tr>

                    <td class="small-font text-center">{{ $label }}</td>

                    <td class="small-font text-center">{{ $groupedData[$label]->count() }}</td>

                    <td class="text-center">
                    ₴  <strong style="color:rgba(75, 192, 192, 1)">{{ $data[$index] }}</strong> грн.
                    </td>

                    <td class="text-center">
                        ₴  <strong style="color:rgba(255, 99, 132, 1)">{{ $balance[$index] }}</strong> грн.
                    </td>

                </tr>
                @endforeach
            </tbody>
            </table>
            </div>
        </div>
    </div>
     
@endsection