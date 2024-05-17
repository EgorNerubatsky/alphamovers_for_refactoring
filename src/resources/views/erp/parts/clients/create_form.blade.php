<div class="form-row ml-4">
    <div class="col-md-6 mb-3">
        <h2 class="card-title">@yield('title')</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <form class="mt-4" action="{{ route($roleData['roleData']['clients_store']) }}"
              method="post" enctype="multipart/form-data">
            @csrf

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="type">Тип</label>
                </div>
                <div class="col-md-6 mb-4">
                    <select id="type" name="type" class="form-control">
                        @foreach($clientTypes as $clientType)
                            <option
                                value="{{ $clientType }}" {{ request()->input('type') == $clientType ? 'selected' : '' }}>{{ $clientType }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="debt_ceiling">Ліміт заборгованості</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="debt_ceiling" name="debt_ceiling" class="form-control" value="">
                </div>
            </div>

            <hr class="w-100">

            <div class="row col-md-10 mb-9">
                <div class="col-md-6 mb-4">
                    <h2 style="color: gray;">Інформація про клієнта</h2>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="company">Назва компанії*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="company" name="company" class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" value="{{ old('company') }}" required>
                    <div id="company-error" class="invalid-feedback">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <small>Повністю з ТОВ</small>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="identification_number">ІПН*</label>
                </div>
                <div class="col-md-4 mb-4">
                    <input id="identification_number" name="identification_number" class="form-control" value=""
                           required>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="code_of_the_reason_for_registration">КПП</label>
                </div>
                <div class="col-md-4 mb-4">
                    <input id="code_of_the_reason_for_registration" name="code_of_the_reason_for_registration"
                           class="form-control" value="">
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="main_state_registration_number">ОГРН*</label>
                </div>
                <div class="col-md-4 mb-4">
                    <input id="main_state_registration_number" name="main_state_registration_number"
                           class="form-control" value="" required>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="director_name">ПІБ директора*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="director_name" name="director_name" class="form-control" value="" required>
                    <small>Особа, яка укладає договір</small>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="contact_person_position">Посада*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="contact_person_position" name="contact_person_position" class="form-control" value=""
                           required>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="acting_on_the_basis_of">Діючий на підставі*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="acting_on_the_basis_of" name="acting_on_the_basis_of" class="form-control" value=""
                           required>
                    <small>Статут, домовленість та ін.</small>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="registered_address">Юридична адреса*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="registered_address" name="registered_address" class="form-control" value="" required>
                    <small>Куди надсилати договір</small>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="zip_code">Поштова адреса*</label>
                </div>
                <div class="col-md-3 mb-4">
                    <input id="zip_code" name="zip_code" class="form-control" value="" required
                           placeholder="Індекс">
                </div>
                <div class="col-md-3 mb-4">
                    <label for="postal_address" style="display: none"></label><input id="postal_address"
                                                                                     name="postal_address"
                                                                                     class="form-control" value=""
                                                                                     required
                                                                                     placeholder="Місто, адреса доставки">
                </div>
            </div>

            <hr class="w-100">

            <div class="row col-md-12 mb-9">
                <div class="col-md-12 mb-4">
                    <h2 style="color: gray;">Банківські реквізити</h2>
                </div>
            </div>


            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="payment_account">Розрахунковий рахунок*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="payment_account" name="payment_account" class="form-control" value="" required>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="bank_name">Название банка*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="bank_name" name="bank_name" class="form-control" value="" required>
                </div>
            </div>

            <div class="row col-md-10 mb-9">
                <div class="col-md-4 mb-4">
                    <label for="bank_identification_code">БIК*</label>
                </div>
                <div class="col-md-6 mb-4">
                    <input id="bank_identification_code" name="bank_identification_code" class="form-control"
                           value="" required>
                </div>
            </div>


            <hr class="w-100">

                    <div class="row col-md-12 mb-9">
                        <div class="col-md-12 mb-4">
                            <h2 style="color: gray;">Контактні особи</h2>
                        </div>
                    </div>

                    <div id="client-details-forms">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 400px">Прізвище, ім'я, по батькові</th>
                                <th style="width: 200px">Посада</th>
                                <th style="width: 200px">Телефон</th>
                                <th style="width: 200px">Email</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <label for="full_name" style="display: none"></label><input id="full_name"
                                                                                                        name="full_name"
                                                                                                        class="form-control"
                                                                                                        value="" required
                                                                                                        placeholder="Прізвище">
                                        </div>
                                        <div class="col">
                                            <label for="name" style="display: none"></label><input id="name" name="name"
                                                                                                   class="form-control"
                                                                                                   value="" required
                                                                                                   placeholder="Ім'я">
                                        </div>
                                        <div class="col">
                                            <label for="last_name" style="display: none"></label><input id="last_name"
                                                                                                        name="last_name"
                                                                                                        class="form-control"
                                                                                                        value="" required
                                                                                                        placeholder="По батькові">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <label for="position" style="display: none"></label><input id="position" name="position"
                                                                                               class="form-control" value=""
                                                                                               required>
                                </td>
                                <td>
                                    <label for="client_phone" style="display: none"></label>
                                    <input id="client_phone" name="client_phone" class="form-control" {{ $errors->has('client_phone') ? 'is-invalid' : '' }}" value="{{ old('client_phone') }}" required>
                                        <div id="phone-error" class="invalid-feedback">
                                            @if(session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </div>

                                </td>
                                <td>
                                    <label for="email" style="display: none"></label><input id="email" name="email"
                                                                                            class="form-control" value=""
                                                                                            required>
                                </td>
                                <td>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
            <hr class="w-100">
            <div class="row col-md-10 mb-14">
                <div class="col-md-4 mb-4">
                    <button type="submit" class="btn btn-primary px-3 mr-2">Зберегти</button>
                </div>
            </div>
        </form>

    </div>
</div>


