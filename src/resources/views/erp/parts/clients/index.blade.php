@php use Carbon\Carbon; @endphp
@extends('erp.content')

@section('title')
    <h2>База клієнтів</h2>
@endsection

@section('content')

    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>
        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
            <a href="{{ route($roleData['roleData']['clients_create']) }}" class="btn mb-1 btn-outline-dark">Новий
                кліент</a>
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
                    <form action="{{ route($roleData['roleData']['clients_search']) }}" method="GET">
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
                                <a href="{{ route($roleData['roleData']['clients_index']) }}"
                                   class="btn btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <br>
                    <form action="{{ route($roleData['roleData']['clients_index']) }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="start_date" style="font-size: 14px;">Дата договору від</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                       value="{{ Request::get('start_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="end_date" style="font-size: 14px;">Дата договору до</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                       value="{{ Request::get('end_date') }}">
                            </div>
                            <div class="form-group col-md-3">
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
                            <div class="form-group col-md-3">
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
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="director_name" style="font-size: 14px;">Керівник</label>
                                <select id="director_name" name="director_name" class="form-control">
                                    <option value="" {{ request()->input('director_name') == 'Всі' ? 'selected' : '' }}>
                                        Всі
                                    </option>
                                    @foreach($contactPersons as $person)
                                        <option
                                            value="{{ $person }}" {{ request()->input('director_name') ==  $person ? 'selected' : '' }}>{{ $person }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="contact_person_position" style="font-size: 14px;">Посада</label>
                                <select id="contact_person_position" name="contact_person_position"
                                        class="form-control">
                                    <option
                                        value="" {{ request()->input('contact_person_position') == 'Всі' ? 'selected' : '' }}>
                                        Всі
                                    </option>
                                    @foreach($contactPersonPositions as $position)
                                        <option
                                            value="{{ $position }}" {{ request()->input('contact_person_position') ==  $position ? 'selected' : '' }}>{{ $position }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['clients_index']) }}" class="btn btn-secondary">Скинути</a>
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
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 14px;"
                           href="{{ route($roleData['roleData']['clients_index'], ['sort' => 'date_of_contract', 'order' => Request::input('sort') == 'date_of_contract' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'date_of_contract' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'date_of_contract' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Контракт вiд
                        </a>
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 14px;"
                           href="{{ route($roleData['roleData']['clients_index'], ['sort' => 'company', 'order' => Request::input('sort') == 'company' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'company' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'company' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Компанія
                        </a>
                    </th>
                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        Тип
                    </th>
                    <th style="width: 100px; text-align: center; vertical-align: middle;">
                        Адреса
                    </th>
                    <th style="width: 250px; text-align: center; vertical-align: middle;">
                        Контактна особа
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Телефон
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['clients_index'], ['sort' => 'debt_ceiling', 'order' => Request::input('sort') == 'debt_ceiling' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'debt_ceiling' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'debt_ceiling' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Ліміт
                        </a>
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Дія
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td class="small-font text-center">{{ $client->getKey() }}</td>
                        <td class="small-font text-center">
                            <i class="far fa-calendar-alt"></i> {{ Carbon::parse($client->date_of_contract)->format('d.m.Y') }}
                            <br>
                            <i class="far fa-clock"></i> {{ Carbon::parse($client->date_of_contract)->format('H:i') }}
                        </td>
                        <td class="text-center">
                            <strong>{{ $client->company }}</strong>
                        </td>
                        <td class="text-center">
                            {{ $client->type }}
                        </td>
                        <td class="text-center">
                            {{ $client->postal_address }}
                        </td>
                        <td class="text-center">
                            @foreach($client->clientContactPersonDetails as $key=> $clientContact)
                                {{ $clientContact->complete_name }}<br>
                                <span class="badge" style="color:#008080">{{ $clientContact->position }}</span><br>
                                @if ($key !== $client->clientContactPersonDetails->count() - 1)
                                @endif
                                <hr>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @foreach($client->clientContactPersonDetails as $key=> $clientContact)
                                {{ $clientContact->client_phone }}
                                <hr>
                                @if ($key !== $client->clientContactPersonDetails->count() - 1)
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            ₴ {{ $client->debt_ceiling }} грн.
                        </td>
                        <td class="text-center">
                            <div class="btn-group-horizontal">
                                <a href="{{ route($roleData['roleData']['clients_edit'], ['clientBase' => $client->getKey()]) }}"
                                   class="btn btn-warning btn-sm mb-2 rounded" data-toggle="tooltip"
                                   title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" data-toggle="modal" class="btn btn-danger btn-sm mb-2 rounded"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route($roleData['roleData']['clients_delete'], ['clientBase'=>$client->getKey()]) }}"
                                   title="Видалити">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                     aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Пiдтвердження</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Ви впевнені, що бажаєте видалити?
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
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-header">
            <div class="card-tools">
                {{ $clients->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
