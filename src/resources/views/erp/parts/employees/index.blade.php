@extends('erp.content')

@section('title')
    <h2>Список працiвникiв</h2>
@endsection

@section('content')

    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>
        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
            <a href="{{ route($roleData['roleData']['employee_create']) }}" class="btn mb-1 btn-outline-dark">Додати
                спiвробiтника</a>

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
                    <form action="{{ route($roleData['roleData']['employee_search']) }}" method="GET">


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
                                <a href="{{ route($roleData['roleData']['employee_index']) }}"
                                   class="btn btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <form action="{{ route($roleData['roleData']['employee_index']) }}" method="GET">
                        <div class="form-row mt-4">
                            <div class="form-group col-md-2">
                                <label for="start_date">Період створення від</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                       value="{{ Request::get('start_date') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="end_date">Період створення до</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                       value="{{ Request::get('end_date') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="position">Посада</label>
                                <select id="position" name="position" class="form-control">
                                    <option value="">Всі</option>
                                    @foreach($employeesPositions as $key=>$employeesPosition)
                                        <option
                                            value="{{ $employeesPosition }}" {{ request()->input('position') == $employeesPosition ? 'selected' : '' }}>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="age_from">Вік від</label>
                                <input id="age_from" name="age_from" class="form-control"
                                       value="{{ Request::get('age_from') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="age_to">Вік до</label>
                                <input id="age_to" name="age_to" class="form-control"
                                       value="{{ Request::get('age_to') }}">
                            </div>
                        </div>
                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['employee_index']) }}" class="btn btn-secondary">Скинути</a>


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
                    <th style="width: 30px;">
                        Фото
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['employee_index'], ['sort' => 'lastname', 'order' => Request::input('sort') == 'lastname' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'lastname' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'lastname' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            ПIБ
                        </a>
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        Адреса
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['employee_index'], ['sort' => 'phone', 'order' => Request::input('sort') == 'phone' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                           href="{{ route($roleData['roleData']['employee_index'], ['sort' => 'created_at', 'order' => Request::input('sort') == 'created_at' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'created_at' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'created_at' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Працює з
                        </a>
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Посада
                    </th>
                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Дiя
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($employees as $employee)

                    <tr>
                        <td class="small-font text-center">{{ $employee->getKey() }}</td>
                        <td class="small-font text-center">
                            <div class="row col-md-10 mt-2">
                                @foreach($employee->usersFiles as $userPhoto)
                                    @if($userPhoto->description == 'photos')
                                        <img src="{{ asset($userPhoto->path) }}" class="img-circle elevation-2"
                                             alt="User Image" style="width: 50px; height:50px">
                                    @endif
                                @endforeach
                            </div>
                        </td>

                        <td class="text-center">
                            <span style="color: #20B2AA;">
                                {{ $employee->lastname }} {{ $employee->name }}
                            </span><br>

                            @php
                                $dateOfBirth = $employee->birth_date;
                                $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;
                            @endphp
                            <p><strong>{{ $age }} рок., {{ $employee->gender }}.</strong></p>
                        </td>

                        <td class="text-center">
                            {{ $employee->address }}
                        </td>

                        <td class="text-center">
                            {{ $employee->phone }}
                        </td>

                        <td class="text-center">
                            {{ date('d.m.Y', strtotime($employee->created_at)) }}

                        </td>

                        <td class="text-center">
                            @if($employee->is_manager == 1)
                                <span class="badge badge-success">Менеджер</span>
                            @elseif($employee->is_admin == 1)
                                <span class="badge badge-success">Адмiнiстратор</span>
                            @elseif($employee->is_hr == 1)
                                <span class="badge badge-secondary">HR</span>
                            @elseif($employee->is_accountant == 1)
                                <span class="badge badge-primary">Бухгалтер</span>
                            @elseif($employee->is_logist == 1)
                                <span class="badge badge-warning">Логiст</span>
                            @elseif($employee->is_executive == 1)
                                <span class="badge badge-danger">Директор</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="btn-group-horizontal">
                                <a href="{{ route($roleData['roleData']['employee_edit'], ['id' => $employee->getKey()]) }}"
                                   class="btn btn-warning btn-sm mb-2 rounded" data-toggle="tooltip" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm mb-2 rounded" data-toggle="modal"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route($roleData['roleData']['employee_delete'], ['id'=>$employee->getKey()]) }}"
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
            <div class="card-header">
                <div class="card-tools">
                    {{ $employees->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
