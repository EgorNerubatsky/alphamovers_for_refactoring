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
                    {{ Form::open(['route' => $roleData['roleData']['employee_store'], 'method' => 'post', 'enctype'=>'multipart/form-data', 'id' => 'form1']) }}
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="lastname">Прізвище</label>
                        <div class="col-lg-6">
                            <input id="lastname" name="lastname" class="form-control" value=""
                                   pattern="^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$" title="Необхідно ввести коректне Прізвище">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="name">Ім'я</label>
                        <div class="col-lg-6">
                            <input id="name" name="name" class="form-control" value=""
                                   pattern="^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$" title="Необхідно ввести коректне iм`я">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="name">По-батькові</label>
                        <div class="col-lg-6">
                            <input id="middle_name" name="middle_name" class="form-control" value=""
                                   pattern="^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$" title="Необхідно ввести коректне по-батькові">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Дата народження</label>
                        <div class="col-lg-6">
                            <label for="birth_date" style="display: none;"></label><input type="date" id="birth_date"
                                                                                          name="birth_date"
                                                                                          class="form-control" value="">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="gender">Стать</label>
                        <div class="col-md-6 mb-4">
                            <select id="gender" name="gender" class="form-control">
                                <option value="чол">чол</option>
                                <option value="жін">жін</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                        <div class="col-lg-6">
                            <input id="phone" name="phone" class="form-control" value="+380"
                                   pattern="(\+)?380[0-9]{9}" title="Необхідно ввести +380 та 9 цифр номера телефону">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="email">E-mail</label>
                        <div class="col-lg-6">
                            <input id="email" name="email" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="email">Тимчасовий пароль</label>
                        <div class="col-lg-6">
                            <input id="password" name="password" class="form-control" value=""
                                   pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$"
                                   title="Пароль повинен містити як мінімум одну заголовну літеру, одну малу літеру та одну цифру">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="position">Посада</label>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input id="is_manager" name="is_manager" class="form-check-input ml-1" type="radio"
                                       value="1">
                                <label for="is_manager" style="font-weight: normal;" class="ml-4">Менеджер</label>
                                <br>
                                <input id="is_admin" name="is_admin" class="form-check-input ml-1" type="radio"
                                       value="1">
                                <label for="is_admin" style="font-weight: normal;" class="ml-4">Адмiнiстратор</label>
                                <br>
                                <input id="is_hr" name="is_hr" class="form-check-input ml-1" type="radio" value="1">
                                <label for="is_hr" style="font-weight: normal;" class="ml-4">HR</label>
                                <br>
                                <input id="is_accountant" name="is_accountant" class="form-check-input ml-1"
                                       type="radio" value="1">
                                <label for="is_accountant" style="font-weight: normal;" class="ml-4">Бухгалтер</label>
                                <br>
                                <input id="is_logist" name="is_logist" class="form-check-input ml-1" type="radio"
                                       value="1">
                                <label for="is_logist" style="font-weight: normal;" class="ml-4">Логiст</label>
                                <br>
                                <input id="is_executive" name="is_executive" class="form-check-input ml-1" type="radio"
                                       value="1">
                                <label for="is_executive" style="font-weight: normal;" class="ml-4">Директор</label>
                                <br>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="address">Адреса</label>
                        <div class="col-lg-6">
                            <input id="address" name="address" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="bank_card">Банківська картка</label>
                        <div class="col-lg-6">
                            <input id="bank_card" name="bank_card" class="form-control" value=""
                                   pattern="[0-9]{16}" title="Необхідно ввести 16 цифр номера картки">
                            <small class="text-danger">Введіть 16 цифр номера картки</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="passport_number">Номер паспорта</label>
                        <div class="col-lg-6">
                            <input id="passport_number" name="passport_number" class="form-control"
                                   value="" pattern="[0-9]{6}" title="Необхідно ввести 6 цифр номера паспорта">
                            <small class="text-danger">Введіть 6 цифр номера паспорта</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="passport_series">Серія паспорта</label>
                        <div class="col-lg-6">
                            <input id="passport_series" name="passport_series" class="form-control"
                                   value="" pattern="[А-Я]{2}" title="Серiя паспорта, 2 заглавнi букви без пробiлу">
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

