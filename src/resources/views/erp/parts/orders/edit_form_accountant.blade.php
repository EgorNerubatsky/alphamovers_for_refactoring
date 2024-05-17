<div class="form-row">
    <div class="col-md-6 mb-3">
        <h2 class="card-title">@yield('title') # {{ $order->getKey() }}</h2>
    </div>
</div>
<div class="form-row">
    <div class="col-md-10 mb-5">
        <label class="btn bg-olive" id="documentsLabel">
            <a href="#accountantDocumentsForm" id="accountantDocumentsBtn">Документи</a>
            <input type="radio" name="options" id="option_b2" autocomplete="on">
        </label>
        <label class="btn bg-olive" id="historyLabel">
            <a href="#accountantHistoryForm" id="accountantHistoryBtn">Iсторiя</a>
            <input type="radio" name="options" id="option_b3" autocomplete="off">
        </label>
    </div>
</div>

<div id="accountantDocumentsForm" style="display: none;" class="row col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <h2 style="color: gray;">Замовлення # {{ $order->getKey() }}</h2>
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="fullname">Контактна особа</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        @if($clientContact->client_contact_id == $order->client_id)
                            <p style="color: gray;">{{ $clientContact->complete_name }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Номер телефону</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        @if($clientContact->client_contact_id == $order->client_id)
                            <p style="color: gray;">{{ $clientContact->client_phone }}</p>
                        @endif
                    @endforeach
                </div>
            </div>


            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">E-mail</label>
                <div class="col-lg-6">
                    @foreach($clientContacts as $clientContact)
                        @if($clientContact->client_contact_id == $order->client_id)
                            <p style="color: gray;">{{ $clientContact->email }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Клієнт</label>
                <div class="col-lg-6">
                    @foreach($clients as $client)
                        @if($client->id == $order->client_id)
                            <strong><p style="color: gray;">{{ $client->company }}</p></strong>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-row">
                <label class="col-lg-3 ml-4 col-form-label" for="">Замовлення на суму</label>
                <div class="col-lg-6">
                    <p style="color: gray;">
                        ₴ {{$order->total_price}} грн.<br>
                    </p>
                </div>
            </div>

            <form class="mt-4" action="{{ route('erp.accountant.orders.addFiles', ['id' => $order->id]) }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <label class="col-lg-3 ml-4 col-form-label mb-3" for="">Завантажити договiр</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="deed_file" id="deed_file"
                                   onchange="updateFileName(this, 'fileNameLabel1'); toggleExecutionDateRequired('deed_file');">
                            <label class="custom-file-label" for="deed_file" id="fileNameLabel1">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <label class="col-lg-3 ml-4 col-form-label mb-3" for="">Завантажити рахунок</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="invoice_file" id="invoice_file"
                                   onchange="updateFileName(this, 'fileNameLabel2'); toggleExecutionDateRequired('invoice_file');">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel2">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <label class="col-lg-3 ml-4 col-form-label mb-5" for="">Завантажити акт</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="act_file" id="act_file"
                                   onchange="updateFileName(this, 'fileNameLabel3'); toggleExecutionDateRequired('act_file');">
                            <label class="custom-file-label" for="customFile" id="fileNameLabel3">Choose file</label>
                        </div>
                    </div>
                </div>

                <hr class="w-100">

                <button type="submit" class="btn btn-primary">Завантажити</button>

            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3 mt-4">
                    <h2 style="color: gray;">Документи по замовленню: Договір</h2>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead style="background-color: #AFEEEE">
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <input type="checkbox" id="">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID документа
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
                    @foreach($orderDocuments as $orderDocument)
                        @if($orderDocument->description == 'Договiр')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="doc" style="display: none"></label>
                                    <input type="checkbox" id="doc" value="{{ $orderDocument->id }}">
                                </td>
                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $orderDocument->getKey() }}</td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $orderDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $orderDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $orderDocument->description }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $orderDocument->getKey() }} / {{ $orderDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    {{ $order->service_type }}<br>
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($orderDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $orderDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break

                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Вiдправлено' || $orderDocument->status == 'Отримано скан')
                                        <label for="scan_recieved_date_date" style="display: none"></label>
                                        <input type="date" id="scan_recieved_date_date" name="scan_recieved_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <label for="scan_recieved_date_time" style="display: none"></label>
                                        <input type="time" id="scan_recieved_date_time" name="scan_recieved_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif

                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Отримано скан')
                                        <label for="scan_send_date_date" style="display: none"></label>
                                        <input type="date" id="scan_send_date_date" name="scan_send_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <label for="scan_send_date_time" style="display: none"></label>
                                        <input type="time" id="scan_send_date_time" name="scan_send_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif

                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($orderDocument->path) }}" target="_blank">
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
                                                        action="{{ route('erp.accountant.orders.deleteFile', ['id' => $orderDocument->getKey()]) }}"
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
            <div class="form-row">
                <div class="col-md-6 mb-3 mt-4">
                    <h2 style="color: gray;">Документи по замовленню: Рахунки</h2>
                </div>
            </div>


            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead style="background-color: #AFEEEE">
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <label for="select-all-invoices" style="display: none"></label>
                            <input type="checkbox" id="select-all-invoices">
                        </th>

                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID документа
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
                        <th style="width: 50px; text-align: center; vertical-align: middle;">

                        </th>

                    </tr>
                    </thead>


                    <tbody>
                    @foreach($orderDocuments as $orderDocument)

                        @if($orderDocument->description == 'Рахунок')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_invoices" style="display: none"></label>
                                    <input type="checkbox" id="selected_invoices" name="selected_invoices[]"
                                           value="{{ $orderDocument->order_execution_date }}">
                                </td>

                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $orderDocument->getKey() }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $orderDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $orderDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $orderDocument->description }}
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $orderDocument->getKey() }} / {{ $orderDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    <p style="color: gray;">
                                        ₴ {{ $order->total_price }} грн.

                                    </p>
                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">

                                    @switch($orderDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $orderDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Рахунок сплачено')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($orderDocument->path) }}" target="_blank">
                                        <i class="fas fa-download fa-2x"></i>
                                        <br>
                                    </a>
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Рахунок сплачено')
                                        <button type="button" class="btn btn-secondary">Рахунок сплачено</button>
                                    @else
                                        <form
                                            action="{{ route('erp.accountant.orders.toBankOperations', ['id' => $orderDocument->getKey()]) }}"
                                            method="POST">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-success">Рахунок сплачено</button>
                                        </form>
                                    @endif
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
                                                        action="{{ route('erp.accountant.orders.deleteFile', ['id' => $orderDocument->getKey()]) }}"
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
            <div class="form-row">
                <div class="col-md-6 mb-3 mt-4">
                    <h2 style="color: gray;">Документи по замовленню: Акти</h2>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead style="background-color: #AFEEEE">
                    <tr>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <label for="select-all-leads" style="display: none"></label>
                            <input type="checkbox" id="select-all-leads">
                        </th>
                        <th style="width: 50px; text-align: center; vertical-align: middle;">
                            <a style="font-size: 14px;">
                                ID документа
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
                    @foreach($orderDocuments as $orderDocument)
                        @if($orderDocument->description == 'Акт')
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <label for="selected_documents" style="display: none"></label>
                                    <input type="checkbox" id="selected_documents" name="selected_documents[]" value="{{ $orderDocument->id }}">
                                </td>
                                <td class="small-font"
                                    style="text-align: center; vertical-align: middle;">{{ $orderDocument->getKey() }}</td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <i class="far fa-calendar-alt"></i> {{ $orderDocument->created_at->format('d.m.Y') }}
                                    <br>
                                    <i class="far fa-clock"></i> {{ $orderDocument->created_at->format('H:i') }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $orderDocument->description }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    № {{ $orderDocument->getKey() }} / {{ $orderDocument->created_at->format('Y') }}
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">

                                    {{ $order->service_type }}<br>


                                </td>


                                <td class="small-font" style="text-align: center; vertical-align: middle;">


                                    @switch($orderDocument->status)
                                        @case('Завантажено')
                                            <span class="badge badge-secondary">{{ $orderDocument->status }}</span>
                                            @break

                                        @case('Вiдправлено')
                                            <span class="badge badge-danger">{{ $orderDocument->status }}</span>
                                            @break
                                        @case('Отримано скан')
                                            <span class="badge badge-success">{{ $orderDocument->status }}</span>
                                            @break

                                            @break

                                    @endswitch
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'Вiдправлено' || $orderDocument->status == 'Отримано скан')

                                        <input type="date" id="scan_recieved_date_date" name="scan_recieved_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <input type="time" id="scan_recieved_date_time" name="scan_recieved_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_recieved_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>

                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    @if($orderDocument->status == 'orderDocument скан')

                                        <input type="date" id="scan_send_date_date" name="scan_send_date_date"
                                               class="form-control"
                                               value="{{ date('Y-m-d', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                        <input type="time" id="scan_send_date_time" name="scan_send_date_time"
                                               class="form-control"
                                               value="{{ date('H:i:s', strtotime($orderDocument->scan_send_date)) }}" {{ $order->status !== 'Попереднє замовлення' ? 'disabled' : '' }}>
                                    @endif
                                </td>
                                <td class="small-font" style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset($orderDocument->path) }}" target="_blank">
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
                                                        action="{{ route('erp.accountant.orders.deleteFile', ['id' => $orderDocument->getKey()]) }}"
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


<div id="accountantHistoryForm" style="display: none;" class="row col-md-12">
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal2{{ $order->id }}">Додати
                коментар</a>
            @include('erp.parts.orders.modal')
        </div>
    </div>

    @foreach($changesHistorys as $changesHistory)
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
                                        @case('order_source')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Джерело замовлення
                                            @break

                                        @case('status')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Статус

                                            @break

                                        @case('payment_method')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Форма оплати
                                            @break

                                        @case('client')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Клієнт
                                            @break

                                        @case('complete_name')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Контактна особа
                                            @break

                                        @case('client_phone')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Телефон
                                            @break

                                        @case('email')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна:E-mail
                                            @break

                                        @case('execution_date')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Дата виконання замовлення
                                            @break

                                        @case('service_type')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Тип послуг
                                            @break

                                        @case('city')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Місто
                                            @break

                                        @case('street')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Вулиця
                                            @break

                                        @case('house')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Будинок
                                            @break

                                        @case('number_of_workers')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Кількість робітників
                                            @break

                                        @case('transport')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Транспорт
                                            @break

                                        @case('task_description')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Примітка до замовлення
                                            @break

                                        @case('order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Орієнтовна тривалість замовлення
                                            @break

                                        @case('price_to_customer')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Вартість замовлення Робітнику
                                            @break

                                        @case('price_to_workers')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Причина зміни: Вартість замовлення Робітнику
                                            @break

                                        @case('total_price')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Загальна вартість замовлення
                                            @break

                                        @case('min_order_amount')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Сума мінімального замовлення
                                            @break

                                        @case('min_order_hrs')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Мінімальне замовлення (годин)
                                            @break

                                        @case('payment_note')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Примітка до оплати
                                            @break

                                        @case('user_logist_id')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Призначити логіста
                                            @break

                                        @case('deleted Рахунок')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Видалення рахунку
                                            @break

                                        @case('deleted Договiр')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Видалення Договiра
                                            @break

                                        @case('deleted Акт')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна:Видалення Акту
                                            @break

                                        @case('deed')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Завантаження Договiра
                                            @break

                                        @case('invoice')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Завантаження Рахунку
                                            @break

                                        @case('act')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Завантаження Акту
                                            @break

                                        @case('newcomment')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Новий Коментар
                                            @break

                                        @case('newCommentWithScr')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Новий Коментар
                                            @break


                                        @case('straps')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong>
                                            <hr> Зміна: Ремені
                                            <h5>
                                                @if($changesHistory->old_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif <i class="fas fa-arrow-right ml-3 mr-3"></i>
                                                @if($changesHistory->new_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif
                                            </h5>
                                            @break

                                        @case('tools')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Інструменти
                                            <h5>
                                                @if($changesHistory->old_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif <i class="fas fa-arrow-right ml-3 mr-3"></i>
                                                @if($changesHistory->new_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif
                                            </h5>
                                            @break

                                        @case('respirators')
                                            <strong>{{ $users->where('id', $changesHistory->user_id)->value('name') . ' ' . $users->where('id', $changesHistory->user_id)->value('lastname') }}
                                                .</strong> Зміна: Респіратори
                                            <h5>
                                                @if($changesHistory->old_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif <i class="fas fa-arrow-right ml-3 mr-3"></i>
                                                @if($changesHistory->new_value == 1)
                                                    Потрібно
                                                @else
                                                    Не потрібно
                                                @endif
                                            </h5>
                                            @break
                                            @endswitch
                                            <div class="small-font">
                                                <i class="far fa-calendar-alt"></i> {{ $changesHistory->created_at->format('d.m.Y') }}
                                                <i class="ml-4 far fa-clock"></i> {{ $changesHistory->created_at->format('H:i') }}
                                            </div>
                                            @if($changesHistory->reason != 'respirators' && $changesHistory->reason != 'tools' && $changesHistory->reason != 'straps' && $changesHistory->reason != 'newCommentWithScr' && $changesHistory->reason != 'user_logist_id')
                                                <h5>{{ $changesHistory->old_value }} <i
                                                        class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesHistory->new_value }}
                                                </h5>
                                            @endif

                                            @if($changesHistory->reason == 'newCommentWithScr')
                                                <h5>{{ $changesHistory->old_value }} <i
                                                        class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesHistory->new_value }}
                                                </h5>
                                                <a href="#" data-toggle="modal" data-target="#previewModal">
                                                    @if(isset($orderDocument->path))

                                                        <img src="{{ asset($orderDocument->path) }}"
                                                             alt="Screenshot Preview"
                                                             data-updated="{{ $changesHistory->updated_at }}"
                                                             style="max-width: 300px; height: auto;">
                                                    @endif

                                                </a>
                                            @endif

                                            @if($changesHistory->reason == 'user_logist_id')
                                                @php
                                                    $oldUser = $users->where('id',$changesHistory->old_value)->first();
                                                    $newUser = $users->where('id',$changesHistory->new_value)->first();
                                                @endphp
                                                <h5>{{ $oldUser->name ?? '' }} {{ $oldUser->lastname ?? '' }} <i
                                                        class="fas fa-arrow-right ml-3 mr-3"></i> {{ $newUser->name ?? '' }} {{ $newUser->lastname ?? '' }}
                                                </h5>
                                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Screenshot Preview</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(isset($orderDocument->path))
                                <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview" class="img-fluid"
                                     data-updated="{{ $changesHistory->updated_at }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    @foreach($changesClientHistorys as $changesClientHistory)
        @if($changesClientHistory->reason != 'updated_at')
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="bootstrap-media">
                            <div class="media">
                                <img class="mr-3 img-fluid"
                                     src="{{ asset($users->where('id', $changesClientHistory->user_id)->value('photo_path')) }}"
                                     alt="Generic placeholder image" style="max-width: 50px; max-height: 50px;">
                                <div class="media-body">

                                    <h5 class="bold">
                                        @switch($changesClientHistory->reason)

                                            @case('complete_name')
                                                <strong>{{ $users->where('id', $changesClientHistory->user_id)->value('name') . ' ' . $users->where('id', $changesClientHistory->user_id)->value('lastname') }}
                                                    .</strong>
                                                <hr> Зміна: Контактна особа
                                                @break

                                            @case('client_phone')
                                                <strong>{{ $users->where('id', $changesClientHistory->user_id)->value('name') . ' ' . $users->where('id', $changesClientHistory->user_id)->value('lastname') }}
                                                    .</strong>
                                                <hr> Зміна: Телефон
                                                @break

                                            @case('email')
                                                <strong>{{ $users->where('id', $changesClientHistory->user_id)->value('name') . ' ' . $users->where('id', $changesClientHistory->user_id)->value('lastname') }}
                                                    .</strong>
                                                <hr> Зміна:E-mail
                                                @break
                                        @endswitch
                                    </h5>

                                    <div class="small-font">
                                        <i class="far fa-calendar-alt"></i> {{ $changesClientHistory->created_at->format('d.m.Y') }}
                                        <i class="ml-4 far fa-clock"></i> {{ $changesClientHistory->created_at->format('H:i') }}
                                    </div>
                                    <h5>{{ $changesClientHistory->old_value }} <i
                                            class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesClientHistory->new_value }}
                                    </h5>

                                    @if($changesClientHistory->reason == 'newCommentWithScr')
                                        <h5>{{ $changesClientHistory->old_value }} <i
                                                class="fas fa-arrow-right ml-3 mr-3"></i> {{ $changesClientHistory->new_value }}
                                        </h5>
                                        <a href="#" data-toggle="modal" data-target="#previewModal">
                                            <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview"
                                                 data-updated="{{ $changesHistory->updated_at }}"
                                                 style="max-width: 300px; height: auto;">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">Screenshot Preview</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(isset($orderDocument->path))
                                <img src="{{ asset($orderDocument->path) }}" alt="Screenshot Preview" class="img-fluid"
                                     data-updated="{{ $changesHistory->updated_at }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr class="w-100">
        @endif
    @endforeach
</div>




