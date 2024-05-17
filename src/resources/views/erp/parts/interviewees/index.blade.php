@extends('erp.content')

@section('title')
    <h2>Список прособесідованих</h2>
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
                    <form action="{{ route($roleData['roleData']['interviewees_search']) }}" method="GET">
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
                                <a href="{{ route($roleData['roleData']['interviewees_index']) }}"
                                   class="btn btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <form action="{{ route($roleData['roleData']['interviewees_index']) }}" method="GET">

                        <div class="form-row mt-4">
                            <div class="form-group col-md-3">
                                <label for="start_call_date">Дата дзвінка від</label>
                                <input type="date" id="start_call_date" name="start_call_date" class="form-control"
                                       value="{{ Request::get('start_call_date') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_call_date">Дата дзвінка до</label>
                                <input type="date" id="end_call_date" name="end_call_date" class="form-control"
                                       value="{{ Request::get('end_call_date') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start_interview_date">Дата співбесіди від</label>
                                <input type="date" id="start_interview_date" name="start_interview_date"
                                       class="form-control" value="{{ Request::get('start_interview_date') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_interview_date">Дата співбесіди до</label>
                                <input type="date" id="end_interview_date" name="end_interview_date"
                                       class="form-control" value="{{ Request::get('end_interview_date') }}">
                            </div>
                        </div>


                        <div class="form-row mt-4">
                            <div class="form-group col-md-3">
                                <label for="fullname">ПIБ</label>
                                <select id="fullname" name="fullname" class="form-control">
                                    <option value="" {{ request()->input('fullname') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($intervieweesNames as $intervieweesName)
                                        <option
                                            value="{{ $intervieweesName }}" {{ request()->input('fullname') == $intervieweesName ? 'selected' : '' }}>{{ $intervieweesName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="position">Посада</label>
                                <select id="position" name="position" class="form-control">
                                    <option value="" {{ request()->input('position') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($intervieweesPositions as $intervieweesPosition)
                                        <option
                                            value="{{ $intervieweesPosition }}" {{ request()->input('position') == $intervieweesPosition ? 'selected' : '' }}>{{ $intervieweesPosition }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="start_age">Вік від</label>
                                <input type="text" id="start_age" name="start_age" class="form-control"
                                       value="{{ Request::get('start_age') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="end_age">Вік до</label>
                                <input type="text" id="end_age" name="end_age" class="form-control"
                                       value="{{ Request::get('end_age') }}">
                            </div>
                        </div>

                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['interviewees_index']) }}"
                               class="btn btn-secondary">Скинути</a>
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
                        <a style="font-size: 14px;"
                           href="{{ route($roleData['roleData']['interviewees_index'], ['sort' => 'call_date', 'order' => Request::input('sort') == 'call_date' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'call_date' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'call_date' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Дата дзвінка

                        </a>
                    </th>
                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 14px;"
                           href="{{ route($roleData['roleData']['interviewees_index'], ['sort' => 'interview_date', 'order' => Request::input('sort') == 'interview_date' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'interview_date' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'interview_date' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Дата співбесіди
                        </a>
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['interviewees_index'], ['sort' => 'fullname', 'order' => Request::input('sort') == 'fullname' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'fullname' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'fullname' && Request::input('order') == 'desc')
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
                           href="{{ route($roleData['roleData']['interviewees_index'], ['sort' => 'phone', 'order' => Request::input('sort') == 'phone' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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

                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['interviewees_index'], ['sort' => 'comment', 'order' => Request::input('sort') == 'comment' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'comment' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'comment' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Коментар
                        </a>

                    </th>

                    <th style="width: 100px; text-align: center; vertical-align: middle;">
                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['interviewees_index'], ['sort' => 'position', 'order' => Request::input('sort') == 'position' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'position' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'position' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Посада
                        </a>
                    </th>

                    <th style="width: 150px; text-align: center; vertical-align: middle;">
                        Дії
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach($interviewees as $interviewee)
                    <tr>
                        <td class="small-font text-center">
                            {{ $interviewee->getKey() }}
                        </td>
                        <td class="small-font text-center">
                            <div class="row col-md-10 mt-2">
                                @foreach($interviewee->candidatesFiles as $candidatePhoto)
                                    @if($candidatePhoto->description == 'photos')
                                        <img src="{{ asset($candidatePhoto->path) }}" class="img-circle elevation-2"
                                             alt="User Image" style="width: 50px; height:50px">
                                    @endif
                                @endforeach
                            </div>
                        </td>

                        <td class="small-font text-center">
                            @if(isset($interviewee->call_date))
                                    <?php $callDate = DateTime::createFromFormat('Y-m-d H:i:s', $interviewee->call_date); ?>
                                <i class="far fa-calendar-alt"></i> {{ $callDate->format('d.m.Y H:i') }}
                            @endif
                        </td>

                        <td class="small-font text-center">
                            @if(isset($interviewee->interview_date))
                                    <?php $interviewDate = DateTime::createFromFormat('Y-m-d H:i:s', $interviewee->interview_date); ?>
                                <i class="far fa-calendar-alt"></i> {{ $interviewDate->format('d.m.Y H:i') }}
                            @endif
                        </td>

                        <td class="text-center">
                            @if(Auth::user()->is_hr)
                                <a href="{{ route('erp.hr.interviewees.edit', ['interviewee' => $interviewee->getKey()]) }}"
                                   class="btn mb-1 btn-light">{{ $interviewee->fullname }}</a>
                            @elseif(Auth::user()->is_executive)
                                <span class="badge badge-success"><a
                                        href="{{ route('erp.executive.interviewees.edit', ['interviewee' => $interviewee->getKey()]) }}">
                                        <strong>{{ $interviewee->fullname }}</strong></a></span>

                            @endif
                            <hr>

                            @php
                                $dateOfBirth = $interviewee->birth_date;
                                $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;
                            @endphp
                            <p><strong>{{ $age }} рок.</strong></p>

                        </td>

                        <td class="text-center">
                            @if(isset($interviewee->address))
                                {{ $interviewee->address }}
                            @endif
                        </td>

                        <td class="text-center">
                            {{ $interviewee->phone }}
                        </td>

                        <td class="text-center">
                            {{ $interviewee->comment }}
                        </td>

                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $interviewee->position }}</span>

                        </td>

                        <td class="text-center">
                            <div class="btn-group-horizontal">

                                <a href="{{ route($roleData['roleData']['interviewees_remove_to_employees'], ['id' => $interviewee->getKey()]) }}"
                                   class="btn btn-success btn-sm mb-2 rounded" data-toggle="tooltip"
                                   title="Перевести до працівників">
                                    <i class="fas fa-check-circle"></i>
                                </a>

                                <a href="{{ route($roleData['roleData']['interviewees_edit'], ['interviewee' => $interviewee->getKey()]) }}"
                                   class="btn btn-warning btn-sm mb-2 rounded" data-toggle="tooltip" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm mb-2 rounded" data-toggle="modal"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route($roleData['roleData']['interviewees_delete'], ['id'=>$interviewee->getKey()]) }}"
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
                    {{ $interviewees->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
