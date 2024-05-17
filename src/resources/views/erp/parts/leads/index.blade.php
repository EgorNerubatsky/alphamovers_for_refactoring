@extends('erp.content')

@section('title')
    <h2>Ліди PROD</h2>
@endsection

@section('content')

    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>
        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">


            <a href="#" class="btn mb-1 btn-outline-dark" data-toggle="modal"
               data-target="#createLeadModal" title="Створити">
                Новий лiд
            </a>
        </div>
    </div>

    @include('erp.parts.leads.modal_create')


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

                    <form action="{{ route($roleData['roleData']['leads_search']) }}" method="GET">

                        <div class="input-group">
                            <label for="search" style="display: none"></label>
                            <input type="text" id="search" name="search" class="form-control rounded"
                                   value="{{ Request::get('search') }}" style="height: 40px;" maxlength="50">
                            <div class="append">
                                <button class="btn btn-outline-dark rounded-1" type="submit" style="height: 40px;">
                                    Пошук
                                </button>

                                <a href="{{ route($roleData['roleData']['leads_index']) }}" class="btn btn-outline-info"
                                   style="height: 40px;">Скинути</a>


                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <br>
                    <form action="{{ route($roleData['roleData']['leads_index']) }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="start_date">Період створення від</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                       value="{{ Request::get('start_date') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="end_date">Період створення до</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                       value="{{ Request::get('end_date') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status">Статус</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Всі</option>
                                    <option value="новый" {{ request()->input('status') == 'новый' ? 'selected' : '' }}>
                                        Новий
                                    </option>
                                    <option
                                        value="в работе" {{ request()->input('status') == 'в работе' ? 'selected' : '' }}>
                                        В роботі
                                    </option>
                                    <option value="отказ" {{ request()->input('status') == 'отказ' ? 'selected' : '' }}>
                                        Відмова
                                    </option>
                                    <option
                                        value="удален" {{ request()->input('status') == 'удален' ? 'selected' : '' }}>
                                        Видалено
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>

                            <a href="{{ route($roleData['roleData']['leads_index']) }}" class="btn btn-secondary">Скинути</a>


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
                    <th>
                        ID
                    </th>
                    <th style="width: 220px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'created_at', 'order' => Request::input('sort') == 'created_at' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                    <th style="width: 250px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'company', 'order' => Request::input('sort') == 'company' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'fullname', 'order' => Request::input('sort') == 'fullname' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'fullname' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'fullname' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            ПІБ

                        </a>
                    </th>
                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'phone', 'order' => Request::input('sort') == 'phone' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'phone' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'phone' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Телефон
                        </a>

                    </th>
                    <th style="width: 100px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'email', 'order' => Request::input('sort') == 'email' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'email' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'email' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            E-mail
                        </a>
                    </th>

                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px; display: block; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'comment', 'order' => Request::input('sort') == 'comment' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'comment' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'comment' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Опис
                        </a>
                    </th>


                    <th style="width: 100px; font-size: 12px;">Документи</th>
                    <th>
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['leads_index'], ['sort' => 'status', 'order' => Request::input('sort') == 'status' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                    <th>
                    </th>

                </tr>
                </thead>
                <tbody>

                @foreach($leads as $lead)

                    <tr>
                        <td class="small-font text-center">{{ $lead->getKey() }}</td>

                        <td class="small-font text-center">
                            <i class="far fa-calendar-alt"></i> {{ $lead->created_at->format('d.m.Y') }}
                            <br>
                            <i class="far fa-clock"></i> {{ $lead->created_at->format('H:i') }}
                        </td>
                        <td class="small-font text-center"><strong>{{ $lead->company }}</strong></td>
                        <td class="small-font">{{ $lead->fullname }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td class="small-font">{{ $lead->email }}</td>
                        <td class="small-font">{{ $lead->comment }}</td>
                        <td>
                            @foreach ($lead->documentsPaths as $documentsPath)

                                <a href="{{ asset($documentsPath->path) }}" target="_blank" data-toggle="tooltip"
                                   title="Завантажити"><span class="badge badge-success"><i
                                            class="fas fa-download"></i> {{ pathinfo(str_replace('\\','/',$documentsPath->path), PATHINFO_FILENAME) }}</span>
                                </a>



                            @endforeach
                        </td>
                        <td>
                            @switch($lead->status)
                                @case('новый')
                                    <span class="badge badge-success">{{ $lead->status }}</span>
                                    @break

                                @case('в работе')
                                    <span class="badge badge-danger">{{ $lead->status }}</span>
                                    @break

                                @case('отказ')
                                    <span class="badge badge-warning">{{ $lead->status }}</span>
                                    @break

                                @case('удален')
                                    <span class="badge badge-secondary">{{ $lead->status }}</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <div class="btn-group-horizontal">
                                <a href="#" class="btn btn-warning btn-sm mb-2 rounded" data-toggle="modal"
                                   data-target="#editLeadModal{{ $lead->id }}" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="#" class="btn btn-danger btn-sm mb-2 rounded" data-toggle="modal"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route($roleData['roleData']['leads_delete'], ['lead'=> $lead->getKey()]) }}"
                                   title="Видалити">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <a href="{{ route($roleData['roleData']['leads_to_order'], ['id'=> $lead->getKey()]) }}"
                                   class="btn btn-sm mb-2 rounded"
                                   style="background-color: #0099FF; color: white;" data-toggle="tooltip"
                                   title="До замовлень">
                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                </a>
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                     aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">
                                                    Пiдтвердження</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">

                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Ви впевнені, що бажаєте видалити?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Вiдмiна
                                                </button>
                                                <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    @include('erp.parts.leads.modal')

                @endforeach
                </tbody>
            </table>

            <div class="card-header">
                <div class="card-tools">
                    {{ $leads->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
