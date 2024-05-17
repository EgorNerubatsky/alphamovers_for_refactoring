<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row col-md-12 mb-9">
                        <div class="row col-md-10 mb-9 mt-4">
                            <h3 class="ml-4">{{ $interviewee->fullname }}</h3>
                        </div>
                    </div>

                    <div class="row col-md-10 mb-9 mt-4">
                        @foreach($interviewee->candidatesFiles as $file)
                            @if(!empty($file->path))
                                @php
                                    $extension = pathinfo($file->path, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array($extension, ['jpeg', 'jpg', 'png', 'bmp']))
                                    <label class="col-lg-3 ml-4 col-form-label" for="lastname">
                                        <div style="position: relative; display: inline-block;">
                                            <img src="{{ asset($file->path) }}"
                                                 class="img-circle elevation-2" alt="User Image">
                                            <a href="#" class="btn btn-danger btn-rounded btn-sm"
                                               style="position: absolute; top: 5px; right: 5px;"
                                               data-toggle="modal" data-target="#confirmationModal"
                                               data-delete-url="{{ route($roleData['roleData']['interviewees_delete_file'], ['id'=> $file->getKey()]) }}"
                                               title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </label>
                                @endif

                                <div class="col-lg-8">
                                    @if(in_array($extension, ['pdf','doc', 'docx']))
                                        <a href="{{ asset($file->path) }}" target="_blank"
                                           class="btn mb-1 btn-rounded btn-warning">
                                                <span class="btn-icon-left">
                                                    <i class="fas fa-eye"></i>
                                                </span>Переглянути резюме
                                        </a>

                                        <a href="#" data-toggle="modal" data-target="#confirmationModal"
                                           data-delete-url="{{ route($roleData['roleData']['interviewees_delete_file'], ['id'=> $file->getKey()]) }}"
                                           title="Delete" class="btn btn-danger btn-rounded btn-sm">
                                                <span>
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                        </a>
                                    @endif
                                </div>

                            @endif
                        @endforeach
                    </div>

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

                    <hr>
                    {{ Form::model($interviewee, ['route' => [$roleData['roleData']['interviewees_update'], $interviewee->getKey()], 'method' => 'put','enctype' => 'multipart/form-data', 'id' => 'form1']) }}
                    @method('PUT')
                    @csrf

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="call_date">Дата дзвінка</label>
                        <div class="col-lg-6">
                            <input type="datetime-local" id="call_date" name="call_date" class="form-control"
                                   value="{{ $interviewee->call_date }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="interview_date">Дата співбесіди</label>
                        <div class="col-lg-6">
                            <input type="datetime-local" id="interview_date" name="interview_date" class="form-control"
                                   value="{{ $interviewee->interview_date }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="address">Адреса</label>
                        <div class="col-lg-6">
                            <input id="address" name="address" class="form-control" value="{{ $interviewee->address }}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="">Бажана посада</label>
                        <div class="col-lg-6">
                            <label for="position" style="display: none"></label><select id="position" name="position"
                                                                                        class="form-control" required>
                                <option value="{{ $interviewee->position }}">{{ $interviewee->position }}</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position }}">{{ $position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_surname">Прізвище</label>
                        <div class="col-lg-6">
                            <input id="fullname_surname" name="fullname_surname" class="form-control"
                                   value="{{ $fullnameSurname }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_name">Ім'я</label>
                        <div class="col-lg-6">
                            <input id="fullname_name" name="fullname_name" class="form-control"
                                   value="{{ $fullnameName }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_patronymic">По-батькові</label>
                        <div class="col-lg-6">
                            <input id="fullname_patronymic" name="fullname_patronymic" class="form-control"
                                   value="{{ $fullnamePatronymic }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="birth_date">Дата народження</label>
                        <div class="col-lg-6">
                            <input type="date" id="birth_date" name="birth_date" class="form-control"
                                   value="{{ $interviewee->birth_date }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="gender">Стать</label>
                        <div class="col-md-2 mb-4">
                            <input type="radio" id="male" name="gender" class="form-control custom-checkbox" value="чол"
                                   @if ($interviewee->gender === 'чол') checked @endif>
                            <label for="male">чол</label>
                        </div>
                        <div class="col-md-2 mb-4">
                            <input type="radio" id="female" name="gender" class="form-control custom-checkbox"
                                   value="жін" @if ($interviewee->gender === 'жін') checked @endif>
                            <label for="female">жін</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                        <div class="col-lg-6">
                            <input id="phone" name="phone" class="form-control" value="{{ $interviewee->phone }}"
                                   pattern="(\+)?380[0-9]{9}" title="Необхідно ввести +380 та 9 цифр номера телефону">
                            <small class="text-danger">Введіть +380 та 9 цифр номера телефону</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="email">E-mail</label>
                        <div class="col-lg-6">
                            <input id="email" name="email" class="form-control" value="{{ $interviewee->email }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="comment">Коментар</label>
                        <div class="col-lg-6">
                            <textarea type="input" id="comment" name="comment" class="form-control"
                                      value="{{ $interviewee->comment }}">{{ $interviewee->comment }}</textarea>
                        </div>
                    </div>
                    <hr class="w-100">
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="interviewee_photo">Завантажити фото</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="interviewee_photo"
                                           id="interviewee_photo"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel1">Вибрати
                                        фото</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="interviewee_file">Завантажити файл</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="interviewee_file"
                                           id="interviewee_file"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel2'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel2">Вибрати
                                        файл</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-10 mb-14">
                        <div class="col-md-4 mb-4">
                            {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'form' => 'form1']) }}
                        </div>
                    </div>
                    {{ Form::close() }}

                    {{--                    <form class="mt-4"--}}
                    {{--                          action="{{ route($roleData['roleData']['interviewees_add_documents'], ['id' => $interviewee->id]) }}"--}}
                    {{--                          method="post" enctype="multipart/form-data">--}}
                    {{--                        @csrf--}}

                    {{--                        <div class="form-group row">--}}
                    {{--                            <label class="col-lg-3 ml-4 col-form-label" for="">Завантажити документи</label>--}}
                    {{--                            <div class="row col-md-6 mb-12">--}}
                    {{--                                <div class="row col-md-6 mb-12">--}}
                    {{--                                    <div class="col-md-8">--}}
                    {{--                                        <div class="custom-file">--}}
                    {{--                                            <input type="file" class="custom-file-input" name="interviewee_file"--}}
                    {{--                                                   id="interviewee_file"--}}
                    {{--                                                   onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">--}}
                    {{--                                            <label class="custom-file-label" for="customFile" id="fileNameLabel1">Вибрати--}}
                    {{--                                                файл</label>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}

                    {{--                                    <div class="col-md-4">--}}
                    {{--                                        <button type="submit" class="btn btn-primary">Завантажити</button>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </form>--}}

                    {{--                    <form class="mt-4"--}}
                    {{--                          action="{{ route($roleData['roleData']['interviewees_add_photo'], ['id' => $interviewee->id]) }}"--}}
                    {{--                          method="post" enctype="multipart/form-data">--}}
                    {{--                        @csrf--}}

                    {{--                        <div class="form-group row">--}}
                    {{--                            <label class="col-lg-3 ml-4 col-form-label" for="">Завантажити фото</label>--}}
                    {{--                            <div class="row col-md-6 mb-12">--}}
                    {{--                                <div class="row col-md-6 mb-12">--}}
                    {{--                                    <div class="col-md-8">--}}
                    {{--                                        <div class="custom-file">--}}
                    {{--                                            <input type="file" class="custom-file-input" name="interviewee_photo"--}}
                    {{--                                                   id="interviewee_photo"--}}
                    {{--                                                   onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">--}}
                    {{--                                            <label class="custom-file-label" for="customFile" id="fileNameLabel1">Обрати--}}
                    {{--                                                фото</label>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="col-md-4">--}}
                    {{--                                        <button type="submit" class="btn btn-primary">Завантажити</button>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </form>--}}
                    {{--                    <hr class="w-100">--}}
                    {{--                    <div class="row col-md-10 mb-14">--}}
                    {{--                        <div class="col-md-4 mb-4">--}}
                    {{--                            {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'form' => 'form1']) }}--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>

