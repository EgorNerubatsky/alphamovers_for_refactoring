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
                            <h3 class="ml-4">{{ $mover->name }} {{ $mover->lastname }}</h3>
                        </div>
                        <div class="row col-md-10 mb-9 mt-4 ml-5">
                            @if(!isset($mover->photo_path))
                                <img src="{{ asset('uploads/photos/users/photo_plug.png') }}"
                                     class="img-circle elevation-2" alt="User Image" style="width: 150px; height:150px">
                            @else
                                <img src="{{ asset($mover->photo_path) }}" class="img-circle elevation-2"
                                     alt="User Image" style="width: 150px; height:150px">
                            @endif
                        </div>
                    </div>
                    <hr>

                    {{ Form::model($mover, ['route' => [$roleData['roleData']['movers_update'], $mover->getKey()], 'method' => 'put','enctype'=>"multipart/form-data", 'id' => 'form1']) }}
                    @method('PUT')
                    @csrf

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="lastname">Прізвище</label>
                        <div class="col-lg-6">
                            <input id="lastname" name="lastname" class="form-control" value="{{ $mover->lastname }}"
                                   pattern="^[a-zA-Zа-яА-Я\s]{1,20}$" title="Необхідно ввести коректне Прізвище" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="name">Ім'я</label>
                        <div class="col-lg-6">
                            <input id="name" name="name" class="form-control" value="{{ $mover->name }}"
                                   pattern="^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$" title="Необхідно ввести коректне iм`я" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="birth_date">Дата народження</label>
                        <div class="col-lg-6">
                            <input type="date" id="birth_date" name="birth_date" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($mover->birth_date)->format('Y-m-d') }}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="gender">Стать</label>
                        <div class="col-md-2 mb-4">
                            <input type="radio" id="male" name="gender" class="form-control custom-checkbox" value="чол"
                                   @if ($mover->gender === 'чол') checked @endif>
                            <label for="male">чол</label>
                        </div>
                        <div class="col-md-2 mb-4">
                            <input type="radio" id="female" name="gender" class="form-control custom-checkbox"
                                   value="жін" @if ($mover->gender === 'жін') checked @endif>
                            <label for="female">жін</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                        <div class="col-lg-6">
                            <input id="phone" name="phone" class="form-control" value="{{ $mover->phone }}"
                                   pattern="(\+)?380[0-9]{9}" title="Необхідно ввести +380 та 9 цифр номера телефону" required>
                            <small class="text-danger">Введіть +380 та 9 цифр номера телефону</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="email">E-mail</label>
                        <div class="col-lg-6">
                            <input id="email" name="email" class="form-control"
                                   value="{{ $mover->email }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="note">Категорія</label>
                        <div class="col-lg-6">
                            <select id="note" name="note" class="form-control" required>
                                <option value="кат. 1" {{ $mover->note == 'кат. 1' ? 'selected' : '' }}>кат. 1</option>
                                <option value="кат. 2" {{ $mover->note == 'кат. 2' ? 'selected' : '' }}>кат. 2</option>
                                <option value="кат. 3" {{ $mover->note == 'кат. 3' ? 'selected' : '' }}>кат. 3</option>
                                <option value="кат. 4" {{ $mover->note == 'кат. 4' ? 'selected' : '' }}>кат. 4</option>
                                <option value="кат. 5" {{ $mover->note == 'кат. 5' ? 'selected' : '' }}>кат. 5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="advantages">Переваги</label>
                        <div class="col-lg-6">
                            <select id="advantages" name="advantages" class="form-control" required>
                                <option
                                    value="Висотні роботи" {{ $mover->advantages == 'Висотні роботи' ? 'selected' : '' }}>
                                    Висотні роботи
                                </option>
                                <option
                                    value="Водій A, B, C, D" {{ $mover->advantages == 'Водій A, B, C, D' ? 'selected' : '' }}>
                                    Водій A, B, C, D
                                </option>
                                <option value="Погрузчик" {{ $mover->advantages == 'Погрузчик' ? 'selected' : '' }}>
                                    Погрузчик
                                </option>
                                <option
                                    value="Автопогрузчик" {{ $mover->advantages == 'Автопогрузчик' ? 'selected' : '' }}>
                                    Автопогрузчик
                                </option>
                                <option value="Електрик" {{ $mover->advantages == 'Електрик' ? 'selected' : '' }}>
                                    Електрик
                                </option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="address">Адреса</label>
                        <div class="col-lg-6">
                            <input id="address" name="address" class="form-control" value="{{ $mover->address }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="bank_card">Банківська картка</label>
                        <div class="col-lg-6">
                            <input id="bank_card" name="bank_card" class="form-control" value="{{ $mover->bank_card }}"
                                   pattern="[0-9]{16}" title="Необхідно ввести 16 цифр номера картки">
                            <small class="text-danger">Введіть 16 цифр номера картки</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="passport_number">Номер паспорта</label>
                        <div class="col-lg-6">
                            <input id="passport_number" name="passport_number" class="form-control"
                                   value="{{ $mover->passport_number }}" pattern="[0-9]{6}"
                                   title="Необхідно ввести 6 цифр номера паспорта">
                            <small class="text-danger">Введіть 6 цифр номера паспорта</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="passport_series">Серія паспорта</label>
                        <div class="col-lg-6">
                            <input id="passport_series" name="passport_series" class="form-control"
                                   value="{{ $mover->passport_series }}" pattern="[А-Я]{2}"
                                   title="Серiя паспорта, 2 заглавнi букви без пробiлу">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="mover_photo">Завантажити фото</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control-file" name="mover_photo"
                                           id="mover_photo"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel1">Вибрати
                                        фото</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}


                    <hr class="w-100">
                    <div class="row col-md-10 mb-14">
                        <div class="col-md-4 mb-4">
                            {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'form' => 'form1']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

