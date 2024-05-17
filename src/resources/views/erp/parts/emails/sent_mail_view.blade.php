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
                    <div class="card-header">
                        <h3 class="card-title">Змiст листа</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                            <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="mailbox-read-info">
                            <h5>{{ $email->subject }}</h5>
                            <h6>Вiд: {{ $email->recipient_name }} {{ $email->recipient_email }}
                                <span class="mailbox-read-time float-right">{{$email->created_at}}</span></h6>
                        </div>
                        <div class="mailbox-controls with-border text-center">
                            <div class="btn-group">
                                <form id="emaildelete"
                                      action="{{ route($roleData['roleData']['emails_delete_email'], ['selected_emails' => [$email->id]]) }}"
                                      method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="btn btn-default btn-sm" data-container="body"
                                            title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-default btn-sm" data-container="body"
                                        title="Reply">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm" data-container="body"
                                        title="Forward">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-default btn-sm" title="Print">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                        <div class="mailbox-read-message">
                            <h5>{{ $email->message }}</h5>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        @if(isset($email->attachment_paths))

                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                @foreach($filesNames as $key=>$fileName)

                                    <li>
                                            <?php $pathInfo = pathinfo($fileName); ?>
                                        @if(isset($pathInfo['extension']) && $pathInfo['extension'] == 'docx')
                                            <span class="mailbox-attachment-icon"><i
                                                    class="far fa-file-word"></i></span>
                                        @elseif(isset($pathInfo['extension']) && $pathInfo['extension'] == 'pdf')
                                            <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                                        @endif
                                        <div class="mailbox-attachment-info">
                                            <a href="#" class="mailbox-attachment-name"><i
                                                    class="fas fa-paperclip"></i>{{ $key }}</a>
                                            <span class="mailbox-attachment-size clearfix mt-1">
                                              <span>1,245 KB</span>
                                              <a href="{{ asset($fileName) }}" target="_blank"
                                                 class="btn btn-default btn-sm float-right"><i
                                                      class="fas fa-cloud-download-alt"></i></a>
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                            <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                        </div>
                        <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
