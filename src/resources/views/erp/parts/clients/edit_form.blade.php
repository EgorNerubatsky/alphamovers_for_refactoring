<div class="form-row ml-4">
    <div class="col-md-6 mb-3">
        <h2 class="card-title">@yield('title')</h2>
    </div>
</div>
<div class="form-row ml-4">
    <div class="col-md-6 mb-4">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn bg-olive active" id="basicInfoLabel2">
                <a href="#basicInfoForm2" id="basicInfoBtn2">Основна Iнформацiя</a>
                <input type="radio" name="options" id="option_b1" autocomplete="off" checked>
            </label>
            <label class="btn bg-olive" id="documentsLabel2">
                <a href="#documentsForm2" id="documentsBtn2">Документи</a>
                <input type="radio" name="options" id="option_b2" autocomplete="off">
            </label>
            <label class="btn bg-olive" id="historyLabel2">
                <a href="#historyForm2" id="historyBtn2">Iсторiя</a>
                <input type="radio" name="options" id="option_b3" autocomplete="off">
            </label>
        </div>
    </div>
</div>

<div id="basicInfoForm2">
    <div class="card">
        <div class="card-body">
            {{ Form::model($clientBase, ['route' => [$roleData['roleData']['clients_update'], $clientBase->getKey()], 'method' => 'put', 'id' => 'form1']) }}
            @method('PUT')
            @csrf


            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="type">Тип</label>
                <div class="col-md-6 mb-4">
                    <select id="type" name="type" class="form-control">
                        <option
                            value="Фізична особа" {{ $clientBase->type == 'Фізична особа' ? 'selected' : '' }}>Фізична
                            особа
                        </option>
                        <option value="Юридична особа" {{ $clientBase->type == 'Юридична особа' ? 'selected' : '' }}>
                            Юридична особа
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="debt_ceiling">Ліміт заборгованості</label>
                <div class="col-lg-6">
                    <input id="debt_ceiling" name="debt_ceiling" class="form-control"
                           value="{{ $clientBase->debt_ceiling }}">
                </div>
            </div>

            <hr class="w-100">

            <div class="row col-md-10 mb-9">
                <div class="col-md-6 mb-4">
                    <h2 style="color: gray;">Інформація про клієнта</h2>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="company">Назва компанії*</label>
                <div class="col-lg-6">
                    <input id="company" name="company" class="form-control" value="{{ $clientBase->company }}" required>
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

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="identification_number">ІПН*</label>
                <div class="col-lg-6">
                    <input id="identification_number" name="identification_number" class="form-control"
                           value="{{ $clientBase->identification_number }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="code_of_the_reason_for_registration">КПП</label>
                <div class="col-lg-6">
                    <input id="code_of_the_reason_for_registration" name="code_of_the_reason_for_registration"
                           class="form-control" value="{{ $clientBase->code_of_the_reason_for_registration }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="main_state_registration_number">ОГРН*</label>
                <div class="col-lg-6">
                    <input id="main_state_registration_number" name="main_state_registration_number"
                           class="form-control" value="{{ $clientBase->main_state_registration_number }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="director_name">ПІБ директора*</label>
                <div class="col-lg-6">
                    <input id="director_name" name="director_name" class="form-control"
                           value="{{ $clientBase->director_name }}" required>
                    <small>Особа, яка укладає договір</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="contact_person_position">Посада*</label>
                <div class="col-lg-6">
                    <input id="contact_person_position" name="contact_person_position" class="form-control"
                           value="{{ $clientBase->contact_person_position }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="acting_on_the_basis_of">Діючий на підставі*</label>
                <div class="col-lg-6">
                    <input id="acting_on_the_basis_of" name="acting_on_the_basis_of" class="form-control"
                           value="{{ $clientBase->acting_on_the_basis_of }}" required>
                    <small>Статут, домовленість та ін.</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="registered_address">Юридична адреса*</label>
                <div class="col-lg-6">
                    <input id="registered_address" name="registered_address" class="form-control"
                           value="{{ $clientBase->registered_address }}" required>
                    <small>Куди надсилати договір</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="zip_code">Поштова адреса*</label>
                <div class="col-lg-3">
                    <input id="zip_code" name="zip_code" class="form-control" value="{{ $clientBase->zip_code }}"
                           required placeholder="Індекс">
                </div>
                <div class="col-lg-3">
                    <label for="postal_address" style="display: none"></label><input id="postal_address"
                                                                                     name="postal_address"
                                                                                     class="form-control"
                                                                                     value="{{ $clientBase->postal_address }}"
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


            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="payment_account">Розрахунковий рахунок*</label>
                <div class="col-lg-6">
                    <input id="payment_account" name="payment_account" class="form-control"
                           value="{{ $clientBase->payment_account }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="bank_name">Назва банку*</label>
                <div class="col-lg-6">
                    <input id="bank_name" name="bank_name" class="form-control" value="{{ $clientBase->bank_name }}"
                           required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 ml-4 col-form-label" for="bank_identification_code">БIК*</label>
                <div class="col-lg-6">
                    <input id="bank_identification_code" name="bank_identification_code" class="form-control"
                           value="{{ $clientBase->bank_identification_code }}" required>
                </div>
            </div>


            <hr class="w-100">
            <div class="row col-md-10 mb-14">
                <div class="col-md-4 mb-4">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-lg-6">
                    <h2 style="color: gray;">Контактні особи</h2>
                </div>
            </div>


            <div id="contact-details-forms">
                @foreach($clientContacts as $index=> $clientContact)

                    <input type="hidden" name="client_contacts[{{ $index }}][client_base_id]"
                           value="{{ $clientContact->getKey() }}">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th>Прізвище, ім'я, по батькові</th>
                                <th>Посада</th>
                                <th>Телефон</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>


                            <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <label for="complete_name_{{ $index }}" style="display: none"></label>
                                            <input id="complete_name_{{ $index }}"
                                                   name="client_contacts[{{ $index }}][complete_name]"
                                                   class="form-control" value="{{ $clientContact->complete_name }}" required>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <label for="position_{{ $index }}" style="display: none"></label>
                                    <input id="position_{{ $index }}" name="client_contacts[{{ $index }}][position]"
                                           class="form-control" value="{{ $clientContact->position }}">
                                </td>
                                <td>
                                    <label for="client_phone_{{ $index }}" style="display: none"></label>
                                    <input id="client_phone_{{ $index }}"
                                           name="client_contacts[{{ $index }}][client_phone]" class="form-control"
                                           value="{{ $clientContact->client_phone }}" required>
                                </td>
                                <td>
                                    <label for="email_{{ $index }}" style="display: none"></label>
                                    <input id="email_{{ $index }}" name="client_contacts[{{ $index }}][email]"
                                           class="form-control" value="{{ $clientContact->email }}">
                                </td>
                                <td>

                                    <a href="#" data-toggle="modal" class="btn btn-danger btn-sm mb-2 rounded"
                                       data-target="#confirmationModal"
                                       data-delete-url="{{ route($roleData['roleData']['clients_contact_delete'], ['id'=>$clientContact->getKey()]) }}"
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
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                @endforeach
                <div class="row col-md-10 mb-14">
                    <div class="col-md-4 mb-4">
                        <button id="add-contact-date-button" class="btn btn-primary">Додати контактну особу</button>
                    </div>
                </div>

                <div class="row col-md-10 mb-14">
                    <div class="col-md-4 mb-4">
                        {{ Form::submit('Зберегти', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>


<div id="documentsForm2" style="display: none;" class="row col-md-12">


    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Клієнт</label>
                <div class="col-lg-6">
                    <p style="color: gray;">{{ $clientBase->company }}</p>
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Контактна особа</label>
                <div class="col-lg-6">
                    @foreach($clientContacts->where('client_contact_id', $clientBase->id) as $clientContact)
                        <p style="color: gray;">{{ $clientContact->complete_name }}</p>
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Замовлення на суму</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        ₴ {{ $totalPrice }} грн.
                    </p>
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Номер телефону</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        <p style="color: gray;">{{ $clientContact->client_phone }}</p>
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">E-mail</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        <p style="color: gray;">{{ $clientContact->email }}</p>
                    @endforeach
                </div>
            </div>
            <form class="mt-4"
                  action="{{ route($roleData['roleData']['clients_add_files'], ['id' => $clientBase->id]) }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row mb-3">
                    <label class="col-lg-3 ml-4 col-form-label" for="deed_file_order">Завантажити договiр</label>
                    <div class="col-lg-2">
                        <select id="deed_file_order" name="deed_file_order" class="form-control" required>
                            <option value="" disabled selected>ID заказа</option>

                            @foreach($orders as $order)
                                <option
                                    value="{{ $order->id }}" {{ request()->input('deed_file_order') == $order->id ? 'selected' : '' }}>{{ $order->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="order_service_type" style="display: none"></label>
                        <select id="order_service_type" name="order_service_type" class="form-control" required>
                            <option value="" disabled selected>Послуга</option>

                            @foreach($orderServiceTypes as $orderServiceType)
                                <option
                                    value="{{ $orderServiceType  }}" {{ request()->input('order_service_type') == $orderServiceType ? 'selected' : '' }}>{{ $orderServiceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="deed_file" id="deed_file"
                                   onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel1">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Завантажити рахунок</label>
                    <div class="col-lg-2">
                        <label for="invoice_file_order" style="display: none"></label>
                        <select id="invoice_file_order" name="invoice_file_order" class="form-control" required>
                            <option value="" disabled selected>ID заказа</option>
                            @foreach($orders as $order)
                                <option
                                    value="{{ $order->id }}" {{ request()->input('invoice_file_order') == $order->id ? 'selected' : '' }}>{{ $order->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select id="order_service_type" name="order_service_type" class="form-control" required>
                            <option value="" disabled selected>Послуга</option>
                            @foreach($orderServiceTypes as $orderServiceType)
                                <option
                                    value="{{ $orderServiceType  }}" {{ request()->input('order_service_type') == $orderServiceType ? 'selected' : '' }}>{{ $orderServiceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="invoice_file" id="invoice_file"
                                   onchange="updateFileName(updateFileName(this, 'fileNameLabel2'))">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel2">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <label class="col-lg-3 ml-4 col-form-label" for="">Завантажити акт</label>
                    <div class="col-lg-2">
                        <label for="act_file_order" style="display: none"></label>
                        <select id="act_file_order" name="act_file_order" class="form-control" required>
                            <option value="" disabled selected>ID заказа</option>

                            @foreach($orders as $order)
                                <option
                                    value="{{ $order->id }}" {{ request()->input('act_file_order') == $order->id ? 'selected' : '' }}>{{ $order->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select id="order_service_type" name="order_service_type" class="form-control" required>
                            <option value="" disabled selected>Послуга</option>

                            @foreach($orderServiceTypes as $orderServiceType)
                                <option
                                    value="{{ $orderServiceType  }}" {{ request()->input('order_service_type') == $orderServiceType ? 'selected' : '' }}>{{ $orderServiceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="act_file" id="act_file"
                                   onchange="updateFileName(updateFileName(this, 'fileNameLabel3'))">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel3">Choose file</label>
                        </div>
                    </div>
                </div>

                <hr class="w-100">

                <div class="form-row mb-3 ml-3">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="form-row mb-3 ml-3">
                <h2 style="color: gray;">Документи по Кліенту: Договір</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <label for="select-all-leads" style="display: none"></label>
                            <input type="checkbox" id="select-all-leads">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID замовлення
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Дата

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Тип документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Номер документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Послуга

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Статус


                        </th>


                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Документ надіслано замовнику

                        </th>
                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Отриман скан вiд замовника

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @foreach($clientDocuments as $clientDocument)
                        @if($clientDocument->description == 'Договiр')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_documents[]" style="display: none"></label>
                                    <input type="checkbox" id="selected_documents[]" name="selected_documents[]"
                                           value="{{ $clientDocument->id }}">
                                </td>
                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $clientDocument->order_id }}</td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $clientDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $clientDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $clientDocument->description }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $clientDocument->getKey() }} / {{ $clientDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">

                                    {{ $clientDocument->order_service_type }}<br>


                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($clientDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $clientDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $clientDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $clientDocument->status }}</span>
                                            @break

                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($clientDocument->status == 'Вiдправлено' || $clientDocument->status == 'Отримано скан')
                                        <label for="scan_recieved_date_date" style="display: none"></label>
                                        <input type="date" id="scan_recieved_date_date" name="scan_recieved_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($clientDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <label for="scan_recieved_date_time" style="display: none"></label>
                                        <input type="time" id="scan_recieved_date_time" name="scan_recieved_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($clientDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($clientDocument->status == 'Отримано скан')
                                        <label for="scan_send_date_date" style="display: none"></label>
                                        <input type="date" id="scan_send_date_date" name="scan_send_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($clientDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <label for="scan_send_date_time" style="display: none"></label>

                                        <input type="time" id="scan_send_date_time" name="scan_send_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($clientDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif

                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($clientDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                            data-target="#confirmDeleteModal">Видалити
                                    </button>
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Подтвердите
                                                        удаление</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Вы уверены, что хотите удалить этот файл?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Отмена
                                                    </button>
                                                    <form
                                                        action="{{ route($roleData['roleData']['clients_delete_file'], ['id' => $clientDocument->getKey()]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Да, удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="form-row mb-3 ml-3">
                <h2 style="color: gray;">Документи по Кліенту: Рахунки</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <input type="checkbox" id="select-all-leads">
                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID замовлення
                            </a>
                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Дата

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Тип документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Номер документа

                        </th>

                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Сума

                        </th>


                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Статус


                        </th>


                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @foreach($clientDocuments as $clientDocument)
                        @if($clientDocument->description == 'Рахунок')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_documents[]" style="display: none"></label>
                                    <input type="checkbox" id="selected_documents[]" name="selected_documents[]"
                                           value="{{ $clientDocument->id }}">
                                </td>

                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $clientDocument->order_id }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $clientDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $clientDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $clientDocument->description }}
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $clientDocument->getKey() }} / {{ $clientDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    <p style="color: gray;">
                                        ₴ {{ $totalPrice }} грн.

                                    </p>
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($clientDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $clientDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $clientDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $clientDocument->status }}</span>
                                            @break

                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($clientDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                            data-target="#confirmDeleteModal">Видалити
                                    </button>
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Подтвердите
                                                        удаление</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Вы уверены, что хотите удалить этот файл?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Отмена
                                                    </button>
                                                    <form
                                                        action="{{ route($roleData['roleData']['clients_delete_file'], ['id' => $clientDocument->getKey()]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Да, удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="form-row mb-3 ml-3">
                <h2 style="color: gray;">Документи по Кліенту: Акти</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <input type="checkbox" id="select-all-leads">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID замовлення
                            </a>
                        </th>
                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Дата
                        </th>
                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Тип документа
                        </th>
                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Номер документа
                        </th>
                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Послуга
                        </th>
                        <th style="width: 200px; text-align: center; vertical-align: middle;">
                            Статус
                        </th>
                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Документ надіслано замовнику
                        </th>
                        <th style="width: 150px; text-align: center; vertical-align: middle;">
                            Отриман скан вiд замовника
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                        </th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($clientDocuments as $clientDocument)

                        @if($clientDocument->description == 'Акт')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_documents[]" style="display: none"></label>
                                    <input type="checkbox" id="selected_documents[]" name="selected_documents[]"
                                           value="{{ $clientDocument->id }}">
                                </td>
                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $clientDocument->order_id }}</td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $clientDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $clientDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $clientDocument->description }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $clientDocument->getKey() }} / {{ $clientDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    {{ $clientDocument->order_service_type }}

                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($clientDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $clientDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $clientDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $clientDocument->status }}</span>
                                            @break

                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($clientDocument->status == 'Вiдправлено' || $clientDocument->status == 'Отримано скан')

                                        <input type="date" id="scan_recieved_date_date" name="scan_recieved_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($clientDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <input type="time" id="scan_recieved_date_time" name="scan_recieved_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($clientDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($clientDocument->status == 'Отримано скан')

                                        <input type="date" id="scan_send_date_date" name="scan_send_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($clientDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <input type="time" id="scan_send_date_time" name="scan_send_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($clientDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($clientDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                            data-target="#confirmDeleteModal">Видалити
                                    </button>
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Подтвердите
                                                        удаление</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Вы уверены, что хотите удалить этот файл?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Отмена
                                                    </button>
                                                    <form
                                                        action="{{ route($roleData['roleData']['clients_delete_file'], ['id' => $clientDocument->getKey()]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Да, удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="historyForm2" style="display: none;" class="row col-md-12">
    <div class="form-row">
        <div class="col-md-6 mb-3 ml-3">
            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal3{{ $clientBase->id }}">Додати
                коментар</a>
            @include('erp.parts.clients.modal')
        </div>
    </div>

    @foreach($chahgesHistorys as $changesHistory)
        @if($changesHistory->reason != 'updated_at')

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="bootstrap-media">
                            <div class="media">
                                <img class="mr-3 img-fluid"
                                     src="{{ asset($users->where('id', $changesHistory->user_id)->value('photo_path')) }}"
                                     alt="Generic placeholder image" style="max-width: 50px; max-height: 50px;">
                                <div class="media-body">
                                    @switch($changesHistory->reason)
                                        @case('position')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Посада
                                            @break

                                        @case('client_phone')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Телефон

                                            @break

                                        @case('complete_name')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: ПІБ контакт. особи
                                            @break

                                        @case('email')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: E-mail
                                            @break

                                        @case('company')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Назва компанії
                                            @break

                                        @case('type')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Тип клієнта
                                            @break

                                        @case('debt_ceiling')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Заборгованість
                                            @break

                                        @case('identification_number')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: ІПН
                                            @break

                                        @case('code_of_the_reason_for_registration')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: КПП
                                            @break

                                        @case('main_state_registration_number')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: ОГРН
                                            @break

                                        @case('director_name')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: ПІБ директора
                                            @break

                                        @case('contact_person_position')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Посада
                                            @break

                                        @case('acting_on_the_basis_of')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Діючий на підставі
                                            @break

                                        @case('registered_address')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Юридична адреса
                                            @break

                                        @case('zip_code')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Iндекс міста
                                            @break

                                        @case('postal_address')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Поштова адреса
                                            @break

                                        @case('payment_account')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Розрахунковий рахунок
                                            @break

                                        @case('bank_name')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Назва банку
                                            @break

                                        @case('bank_identification_code')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: БIК
                                            @break

                                        @case('min_order_amount')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Сума мінімального замовлення
                                            @break

                                        @case('min_order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Мінімальне замовлення (годин)
                                            @break

                                        @case('payment_note')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Примітка до оплати
                                            @break

                                        @case('logist')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Призначити логіста
                                            @break

                                        @case('deleted Рахунок')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Видалення рахунку
                                            @break

                                        @case('deleted Договiр')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Видалення Договiра
                                            @break

                                        @case('deleted Акт')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна:Видалення Акту
                                            @break

                                        @case('deed')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Завантаження Договiра
                                            @break

                                        @case('invoice')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Завантаження Рахунку
                                            @break

                                        @case('act')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Завантаження Акту
                                            @break

                                        @case('newcomment')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Новий Коментар
                                            @break

                                        @case('newCommentWithScr')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Новий Коментар
                                            @break
                                    @endswitch
                                    <div class="small-font">
                                        <i class="far fa-calendar-alt"></i> {{ $changesHistory->created_at->format('d.m.Y') }}
                                        <i class="ml-4 far fa-clock"></i> {{ $changesHistory->created_at->format('H:i') }}
                                    </div>
                                    @if($changesHistory->reason != 'newCommentWithScr')
                                        <h5>{{ $changesHistory->old_value }} <i
                                                class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesHistory->new_value }}
                                        </h5>
                                    @endif
                                    @if($changesHistory->reason == 'newCommentWithScr')
                                        <h5>{{ $changesHistory->old_value }} <i
                                                class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesHistory->new_value }}
                                        </h5>
                                        <a href="#" data-toggle="modal" data-target="#previewModal">
                                            @if(isset($changesHistory->where('reason', 'Скрiншот')->first()->new_value))
                                                <img
                                                    src="{{ asset( $changesHistory->where('reason', 'Скрiншот')->first()->new_value) }}"
                                                    alt="Screenshot Preview"
                                                    data-updated="{{ $changesHistory->updated_at }}"
                                                    style="max-width: 300px; height: auto;">
                                            @endif
                                        </a>
                                    @endif
                                    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog"
                                         aria-labelledby="previewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="previewModalLabel">Screenshot
                                                        Preview</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if(isset($changesHistory->where('reason', 'Скрiншот')->first()->new_value))
                                                        <img
                                                            src="{{ asset( $changesHistory->where('reason', 'Скрiншот')->first()->new_value) }}"
                                                            alt="Screenshot Preview" class="img-fluid"
                                                            data-updated="{{ $changesHistory->updated_at }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
        <div class="card-tools">
            {{ $chahgesHistorys->links('pagination::bootstrap-4') }}
        </div>
</div>
