@extends('erp.content')

@section('title')
    <h2>Пошта</h2>
@endsection

@section('content')
    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>
        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
            <a href="{{ route($roleData['roleData']['emails_new_mail']) }}" class="btn mb-1 btn-outline-dark">Новий
                лист</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    @include('erp.parts.emails.inbox')
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route($roleData['roleData']['emails_send_email']) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title"><b>Пiдготовка нового листа</b></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="recipient_name" style="display: none"></label>
                                <input class="form-control" id="recipient_name" name="recipient_name"
                                       placeholder="Кому (Iм'я):" required>
                            </div>
                            <div class="form-group">
                                <label for="sender_name" style="display: none"></label>
                                <input class="form-control" id="sender_name" name="sender_name"
                                       placeholder="Вiд кого (Iм'я):" required>
                            </div>
                            <div class="form-group">
                                <label for="recipient_email" style="display: none"></label>
                                <input class="form-control" id="recipient_email" name="recipient_email"
                                       placeholder="Адреса:" required>
                            </div>
                            <div class="form-group">
                                <label for="subject" style="display: none"></label>
                                <input class="form-control" id="subject" name="subject" placeholder="Тема:" required>
                            </div>
                            <div class="form-group">
                                <label for="compose-textarea" style="display: none"></label>
                                <textarea id="compose-textarea" name="message" class="form-control"
                                          style="height: 300px"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Attachment
                                    <input type="file" id="attachment" name="attachment[]" multiple>
                                </div>
                                <p class="help-block">Max. 10MB (pdf, doc, docx, png, jpeg, jpg, rar, zip)</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send
                                </button>
                            </div>
                            <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
