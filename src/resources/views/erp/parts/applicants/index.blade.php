@extends('erp.content')

@section('title')
    <h2>Список претендентів</h2>
@endsection

@section('content')
    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>
        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
            <a href="{{ route($roleData['roleData']['applicants_create']) }}" class="btn mb-1 btn-outline-dark">Додати
                претендента</a>
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
                    <form action="{{ route($roleData['roleData']['applicants_search']) }}" method="GET">
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
                                <a href="{{ route($roleData['roleData']['applicants_index']) }}"
                                   class="btn btn-outline-info" style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <form action="{{ route($roleData['roleData']['applicants_index']) }}" method="GET">
                        <div class="form-row mt-4">
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
                                <label for="desired_position">Бажана посада</label>
                                <select id="desired_position" name="desired_position" class="form-control">
                                    <option value="" {{ request()->input('desired_position') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($applicantsPositions as $applicantsPosition)
                                        <option
                                            value="{{ $applicantsPosition }}" {{ request()->input('desired_position') == $applicantsPosition ? 'selected' : '' }}>{{ $applicantsPosition }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fullname">ПIБ</label>
                                <select id="fullname" name="fullname" class="form-control">
                                    <option value="" {{ request()->input('fullname') == 'Всі' ? 'selected' : '' }}>Всі
                                    </option>
                                    @foreach($applicantsNames as $applicantsName)
                                        <option
                                            value="{{ $applicantsName }}" {{ request()->input('fullname') == $applicantsName ? 'selected' : '' }}>{{ $applicantsName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['applicants_index']) }}" class="btn btn-secondary">Скинути</a>
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

                    <th style="width: 50px; text-align: center; vertical-align: middle;">
                            Фото
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">

                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['applicants_index'], ['sort' => 'created_at', 'order' => Request::input('sort') == 'created_at' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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

                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['applicants_index'], ['sort' => 'fullname', 'order' => Request::input('sort') == 'fullname' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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

                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['applicants_index'], ['sort' => 'phone', 'order' => Request::input('sort') == 'phone' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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

                    <th style="width: 150px; text-align: center; vertical-align: middle;">

                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['applicants_index'], ['sort' => 'desired_position', 'order' => Request::input('sort') == 'desired_position' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
                            @if(Request::input('sort') == 'desired_position' && Request::input('order') == 'asc')
                                <i class="fas fa-sort-down"></i>
                            @elseif(Request::input('sort') == 'desired_position' && Request::input('order') == 'desc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                            Бажана посада
                        </a>
                    </th>

                    <th style="width: 200px; text-align: center; vertical-align: middle;">

                        <a style="font-size: 12px;"
                           href="{{ route($roleData['roleData']['applicants_index'], ['sort' => 'comment', 'order' => Request::input('sort') == 'comment' && Request::input('order') == 'asc' ? 'desc' : 'asc']) }}">
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


                    <th style="width: 150px; text-align: center; vertical-align: middle;">

                    </th>
                </tr>
                </thead>


                <tbody>
                @foreach($applicants as $applicant)
                    <tr>
                        <td class="small-font text-center">
                            {{ $applicant->getKey() }}
                        </td>
                        <td class="small-font text-center">
                            <div class="row col-md-10 mt-2">
                                @foreach($applicant->candidatesFiles as $candidatePhoto)
                                @if($candidatePhoto->description == 'photos')
                                    <img src="{{ asset($candidatePhoto->path) }}" class="img-circle elevation-2"
                                         alt="User Image" style="width: 50px; height:50px">
                                @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="small-font text-center">
                            <i class="far fa-calendar-alt"></i> {{ $applicant->created_at->format('d.m.Y') }}
                        </td>
                        <td class="text-center">

                            <a href="{{ route($roleData['roleData']['applicants_edit'], ['applicant' => $applicant->getKey()]) }}"><span class="badge badge-success"><strong>{{ $applicant->fullname }}</strong></span></a>

                        </td>

                        <td class="text-center">
                            {{ $applicant->phone }}
                        </td>

                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $applicant->desired_position }}</span>
                        </td>

                        <td class="text-center">
                            {{ $applicant->comment }}
                        </td>

                        <td class="text-center">
                            <div class="btn-group-horizontal">
                                <a href="{{ route($roleData['roleData']['applicants_remove_to_interviewee'], ['id' => $applicant->getKey()]) }}"
                                   class="btn btn-success btn-sm mb-2 rounded" data-toggle="tooltip"
                                   title="Пройшов співбесіду">
                                    <i class="fas fa-check-circle"></i>
                                </a>

                                <a href="{{ route($roleData['roleData']['applicants_edit'], ['applicant' => $applicant->getKey()]) }}"
                                   class="btn btn-warning btn-sm mb-2 rounded" data-toggle="tooltip"
                                   title="Переглянути">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm mb-2 rounded" data-toggle="modal"
                                   data-target="#confirmationModal"
                                   data-delete-url="{{ route($roleData['roleData']['applicants_delete'], ['applicant'=>$applicant->getKey()]) }}"
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
                    {{ $applicants->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
