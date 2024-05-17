@php use Carbon\Carbon; @endphp
<div class="form-row mb-3 mt-3 ml-4">
    <div class="col-md-4">
        <h2>@yield('title')</h2>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row col-md-12 mb-9">
                        <div class="row col-md-10 mb-9 mt-4">
                            <h3 class="ml-4">{{ $employee->name }} {{ $employee->lastname }}</h3>
                        </div>
                        <div class="row col-md-10 mb-9 mt-4">
                            @foreach($employee->usersFiles as $file)
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
                                                   data-delete-url="{{ route($roleData['roleData']['employee_delete_file'], ['id'=> $file->getKey()]) }}"
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
                                               data-delete-url="{{ route($roleData['roleData']['employee_delete_file'], ['id'=> $file->getKey()]) }}"
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
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <button type="button" data-toggle="collapse" href="#messageForm" aria-expanded="false"
                                    aria-controls="messageForm" class="btn mb-1 btn-outline-dark"
                                    style="width: 200px;">Змiнити пароль
                            </button>
                        </div>
                        @error('old_password')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        @error('new_password_confirm')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="basic-form">
                        <div id="messageForm" class="collapse">
                            <br>
                            {{--                            <form action="{{ route($roleData['roleData']['messages_store_message']) }}"--}}
                            {{--                                  method="post"--}}
                            {{--                                  enctype="multipart/form-data" class="form-profile">--}}
                            {{--                                @csrf--}}
                            {{ Form::model($employee, ['route' => ['profile.passwordUpdate', $employee->getKey()], 'method' => 'put', 'enctype'=>"multipart/form-data", 'id' => 'form1']) }}
                            @method('PUT')
                            @csrf

                            <div class="form-row mt-4">
                                <div class="form-group col-md-3">
                                    <label for="new_password_confirm">Старий пароль</label>
                                    <div class="input-group">
                                        <input type="password" id="old_password" name="old_password"
                                               class="form-control"
                                               value="{{ Request::get('old_password') }}">
                                        <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-eye" id="toggle_old_password"
                                                       onclick="togglePassword('old_password')"></i>
                                                </span>
                                        </div>
                                    </div>
                                    @error('old_password')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3 ml-5">
                                    <label for="new_password">Новий пароль</label>
                                    <div class="input-group">
                                        <input type="password" id="new_password" name="new_password"
                                               class="form-control"
                                               value="{{ Request::get('new_password') }}">
                                        <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-eye" id="toggle_new_password"
                                                       onclick="togglePassword('new_password')"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="new_password_confirm">Новий пароль (пiдтвердження)</label>
                                    <div class="input-group">
                                        <input type="password" id="new_password_confirm" name="new_password_confirm"
                                               class="form-control"
                                               value="{{ Request::get('new_password_confirm') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-eye" id="toggle_new_password_confirm"
                                                   onclick="togglePassword('new_password_confirm')"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @error('new_password_confirm')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <script>
                                function togglePassword(inputId) {
                                    var x = document.getElementById(inputId);
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                }
                            </script>

                            <div class="form-row">
                                <div class="form-group col-md-12 text-right mt-4">
                                    <button type="submit"
                                            class="btn btn-success">
                                        Вiдправити
                                    </button>
                                    <a href="{{ route($roleData['roleData']['messages_index']) }}"
                                       class="btn btn-secondary px-3">Скинути</a>
                                </div>
                            </div>
                            {{--                            </form>--}}
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">


                    <hr>

                    {{--                    {{ Form::model($employee, ['route' => [$roleData['roleData']['employee_update'], $employee->getKey()], 'method' => 'put', 'enctype'=>"multipart/form-data", 'id' => 'form1']) }}--}}
                    {{ Form::model($employee, ['route' => ['profile.update', $employee->getKey()], 'method' => 'put', 'enctype'=>"multipart/form-data", 'id' => 'form1']) }}
                    @method('PUT')
                    @csrf

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="lastname">Прізвище</label>
                        <div class="col-lg-6">
                            <input id="lastname" name="lastname" class="form-control"
                                   value="{{ $employee->lastname }}" pattern="^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$"
                                   title="Необхідно ввести коректне Прізвище">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="name">Ім'я</label>
                        <div class="col-lg-6">
                            <input id="name" name="name" class="form-control" value="{{ $employee->name }}"
                                   pattern="^[a-zA-Zа-яА-Яіїєґ\'\`\s]{1,20}$" title="Необхідно ввести коректне iм`я">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="name">По-батькові</label>
                        <div class="col-lg-6">
                            <input id="middle_name" name="middle_name" class="form-control"
                                   value="{{ $employee->middle_name }}"
                                   pattern="^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$" title="Необхідно ввести коректне по-батькові">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Дата народження</label>
                        <div class="col-lg-6">
                            <label for="birth_date" style="display: none"></label><input type="date" id="birth_date"
                                                                                         name="birth_date"
                                                                                         class="form-control"
                                                                                         value="{{ Carbon::parse($employee->birth_date)->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="gender">Стать</label>
                        <div class="col-md-6 mb-4">
                            <select id="gender" name="gender" class="form-control">
                                <option value="чол" @if ($employee->gender === 'чол') selected @endif>чол</option>
                                <option value="жін" @if ($employee->gender === 'жін') selected @endif>жін</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                        <div class="col-lg-6">
                            <input id="phone" name="phone" class="form-control"
                                   value="{{ $employee->phone }}" pattern="(\+)?380[0-9]{9}"
                                   title="Необхідно ввести +380 та 9 цифр номера телефону">
                            <small class="text-danger">Введіть +380 та 9 цифр номера телефону</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="email">E-mail</label>
                        <div class="col-lg-6">
                            <input id="email" name="email" class="form-control"
                                   value="{{ $employee->email }}">
                        </div>
                    </div>
                    @if(Auth::user()->is_admin)

                        <div class="form-group row">
                            <label class="col-lg-3 ml-4 col-form-label" for="email">Пароль</label>
                            <div class="col-lg-6">
                                <input id="password" name="password" class="form-control"
                                       value="{{ $employee->password }}"
                                       title="Необхідно ввести до 9 цифр тимчасового паролю">
                            </div>
                        </div>
                    @endif


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="position">Посада</label>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <label for="is_manager" style="display: none"></label><input id="is_manager"
                                                                                             name="is_manager"
                                                                                             class="form-check-input ml-1"
                                                                                             type="radio"
                                                                                             value="1"
                                                                                             @if ($employee->is_manager === 1) checked @endif>
                                <label for="manager" style="font-weight: normal;" class="ml-4">Менеджер</label>
                                <br>
                                <label for="is_admin" style="display: none"></label><input id="is_admin" name="is_admin"
                                                                                           class="form-check-input ml-1"
                                                                                           type="radio"
                                                                                           value="1"
                                                                                           @if ($employee->is_admin === 1) checked @endif>
                                <label for="admin" style="font-weight: normal;" class="ml-4">Адмiнiстратор</label>
                                <br>
                                <label for="is_hr" style="display: none"></label><input id="is_hr" name="is_hr"
                                                                                        class="form-check-input ml-1"
                                                                                        type="radio" value="1"
                                                                                        @if ($employee->is_hr === 1) checked @endif>
                                <label for="hr" style="font-weight: normal;" class="ml-4">HR</label>
                                <br>
                                <label for="is_accountant" style="display: none"></label><input id="is_accountant"
                                                                                                name="is_accountant"
                                                                                                class="form-check-input ml-1"
                                                                                                type="radio" value="1"
                                                                                                @if ($employee->is_accountant === 1) checked @endif>
                                <label for="accountant" style="font-weight: normal;" class="ml-4">Бухгалтер</label>
                                <br>
                                <label for="is_logist" style="display: none"></label><input id="is_logist"
                                                                                            name="is_logist"
                                                                                            class="form-check-input ml-1"
                                                                                            type="radio"
                                                                                            value="1"
                                                                                            @if ($employee->is_logist === 1) checked @endif>
                                <label for="logist" style="font-weight: normal;" class="ml-4">Логiст</label>
                                <br>
                                <label for="is_executive" style="display: none"></label><input id="is_executive"
                                                                                               name="is_executive"
                                                                                               class="form-check-input ml-1"
                                                                                               type="radio"
                                                                                               value="1"
                                                                                               @if ($employee->is_executive === 1) checked @endif>
                                <label for="executive" style="font-weight: normal;" class="ml-4">Директор</label>
                                <br>
                            </div>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="address">Адреса</label>
                        <div class="col-lg-6">
                            <input id="address" name="address" class="form-control"
                                   value="{{ $employee->address }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="bank_card">Банківська картка</label>
                        <div class="col-lg-6">
                            <input id="bank_card" name="bank_card" class="form-control"
                                   value="{{ $employee->bank_card }}" pattern="[0-9]{16}"
                                   title="Необхідно ввести 16 цифр номера картки">
                            <small class="text-danger">Введіть 16 цифр номера картки</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="passport_number">Номер паспорта</label>
                        <div class="col-lg-6">
                            <input id="passport_number" name="passport_number" class="form-control"
                                   value="{{ $employee->passport_number }}" pattern="[0-9]{6}"
                                   title="Необхідно ввести 6 цифр номера паспорта">
                            <small class="text-danger">Введіть 6 цифр номера паспорта</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="passport_series">Серія паспорта</label>
                        <div class="col-lg-6">
                            <input id="passport_series" name="passport_series" class="form-control"
                                   value="{{ $employee->passport_series }}" pattern="[А-Я]{2}"
                                   title="Серiя паспорта, 2 заглавнi букви без пробiлу">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="employee_photo">Завантажити фото</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control-file" name="employee_photo"
                                           id="employee_photo"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel1">Вибрати
                                        фото</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="employee_file">Завантажити файл</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control-file" name="employee_file"
                                           id="employee_file"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel2'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel2">Вибрати
                                        файл</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="w-100">
                    <div class="row col-md-10 mb-14">
                        <div class="col-md-4 mb-4">
                            {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'form' => 'form1']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

