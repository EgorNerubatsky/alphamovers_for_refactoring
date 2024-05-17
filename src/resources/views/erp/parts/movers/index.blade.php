@extends('erp.content')

@section('title')
    <h2>Список робочих</h2>
@endsection

@section('content')
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
                <a href="{{ route($roleData['roleData']['movers_planning']) }}" class="btn btn-outline-dark"
                   type="submit" style="height: 40px;">Планування/Фінанси</a>
            </div>
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
                    <form action="{{ route($roleData['roleData']['movers_search']) }}" method="GET">
                        <div class="input-group">
                            <label style="display: none" for="search"></label>
                            <input type="text" id="search" name="search" class="form-control rounded-left"
                                                               value="{{ Request::get('search') }}" style="height: 40px;">
                            <div class="append">
                                <button class="btn btn-outline-dark rounded-1" type="submit" style="height: 40px;">
                                    Пошук
                                </button>
                                <a href="{{ route($roleData['roleData']['movers_index']) }}"
                                   class="btn btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <form action="{{ route($roleData['roleData']['movers_index']) }}" method="GET">
                        <div class="form-row mt-4">
                            <div class="form-group col-md-4">
                                <label for="mover">ПIБ робітника</label>
                                <select id="mover" name="mover" class="form-control">
                                    <option value="">Всі</option>
                                    @foreach($moversDatas as $moversData)
                                        <option
                                            value="{{ $moversData->id }}" {{ request()->input('mover') == $moversData->id ? 'selected' : '' }}>{{ $moversData->name }} {{ $moversData->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone">Телефон</label>
                                <select id="phone" name="phone" class="form-control">
                                    <option value="">Всі</option>
                                    @foreach($moversDatas as $moversData)
                                        <option
                                            value="{{ $moversData->phone }}" {{ request()->input('phone') == $moversData->phone ? 'selected' : '' }}>{{ $moversData->phone }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-4">
                                <label for="note">Категорiя</label>
                                <select id="note" name="note" class="form-control">
                                    <option value="">Всі</option>
                                    @foreach($moversCategorys as $moversCategory)
                                        <option
                                            value="{{ $moversCategory }}" {{ request()->input('note') == $moversCategory ? 'selected' : '' }}>{{ $moversCategory }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-4">

                            <div class="form-group col-md-4">
                                <label for="advantages">Переваги</label>
                                <select id="advantages" name="advantages" class="form-control">
                                    <option value="">Всі</option>
                                    @foreach($moversAdvantages as $moversAdvantage)
                                        <option
                                            value="{{ $moversAdvantage }}" {{ request()->input('advantages') == $moversAdvantage ? 'selected' : '' }}>{{ $moversAdvantage }}</option>
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
                            <a href="{{ route($roleData['roleData']['movers_index']) }}" class="btn btn-secondary">Скинути</a>
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
                           href="{{ route($roleData['roleData']['movers_index'], ['sort' => 'lastname', 'order' => Request::input('sort') == 'lastname' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            ПIБ робітника
                            @if(Request::input('sort') == 'lastname' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'lastname' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </a>
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        Адреса
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['movers_index'], ['sort' => 'phone', 'order' => Request::input('sort') == 'phone' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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
                           href="{{ route($roleData['roleData']['movers_index'], ['sort' => 'created_at', 'order' => Request::input('sort') == 'created_at' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'created_at' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'created_at' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Дата початку роботи
                        </a>
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['movers_index'], ['sort' => 'note', 'order' => Request::input('sort') == 'note' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'note' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'note' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Категорiя
                        </a>
                    </th>

                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['movers_index'], ['sort' => 'advantages', 'order' => Request::input('sort') == 'advantages' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'advantages' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'advantages' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Переваги
                        </a>
                    </th>

                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Дiя
                    </th>
                </tr>
                </thead>


                <tbody>
                @foreach($movers as $mover)
                    <tr>
                        <td class="small-font text-center">{{ $mover->getKey() }}</td>
                        <td class="small-font text-center">
                            <div class="row col-md-10 mt-2">
                                @if(isset($mover->photo_path))

                                    <img src="{{ asset($mover->photo_path) }}" class="img-circle elevation-2"
                                         alt="User Image" style="width: 50px; height:50px">
                                @endif
                            </div>
                        </td>

                        <td class="small-font text-center">
                            <span style="color: #20B2AA;">
                                {{ $mover->lastname }} {{ $mover->name }}
                            </span><br>

                            @php
                                $dateOfBirth = $mover->birth_date;
                                $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;
                            @endphp
                            <p><strong>{{ $age }} рок., {{ $mover->gender }}.</strong></p>
                        </td>

                        <td class="small-font text-center">
                            {{ $mover->address }}
                        </td>

                        <td class="small-font text-center">
                            {{ $mover->phone }}
                        </td>

                        <td class="small-font text-center">
                            Працює з <br>
                            <i class="far fa-calendar-alt"></i> {{ date('d.m.Y', strtotime($mover->created_at)) }}

                        </td>

                        <td class="text-center">
                            @switch($mover->note)
                                @case('кат. 1')
                                    <span class="badge badge-secondary">{{ $mover->note }}</span>
                                    @break
                                @case('кат. 2')
                                    <span class="badge badge-warning">{{ $mover->note }}</span>
                                    @break
                                @case('кат. 3')
                                    <span class="badge badge-success">{{ $mover->note }}</span>
                                    @break
                                @case('кат. 4')
                                    <span class="badge badge-primary">{{ $mover->note }}</span>
                                    @break
                                @case('кат. 5')
                                    <span class="badge badge-danger">{{ $mover->note }}</span>
                                    @break
                            @endswitch
                        </td>

                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $mover->advantages }}</span>
                        </td>

                        <td class="text-center">
                            <div class="btn-group-horizontal">
                                <a href="{{ route($roleData['roleData']['movers_edit'], ['id' => $mover->getKey()]) }}"
                                   class="btn btn-warning btn-sm mb-2 rounded" data-toggle="tooltip" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="#" data-toggle="modal" class="btn btn-danger btn-sm mb-2 rounded"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route($roleData['roleData']['movers_delete'], ['id'=>$mover->getKey()]) }}"
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
                    {{ $movers->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
