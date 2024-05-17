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
                        <h3 class="card-title"><b>Видаленi листи</b></h3>
                        <div class="card-tools">
                            <form action="{{ route($roleData['roleData']['emails_search']) }}" method="GET">
                                <div class="input-group">
                                    <label for="search" style="display: none"></label>
                                    <input type="text" id="search" name="search" class="form-control rounded"
                                           value="{{ Request::get('search') }}" style="height: 40px;">
                                    <input type="hidden" name="search_type" value="trashed_emails">
                                    <div class="append">
                                        <button class="btn btn-outline-dark rounded-1" type="submit"
                                                style="height: 40px;">
                                            Пошук
                                        </button>
                                        <a href="{{ route($roleData['roleData']['emails_deleted_emails']) }}"
                                           class="btn btn-outline-info"
                                           style="height: 40px;">Скинути</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <form id="emailsdelete"
                              action="{{ route($roleData['roleData']['emails_force_delete_emails']) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="mailbox-controls">
                                <label for="select_all_emails" style="display: none"></label>
                                <input type="checkbox" class="mt-1 ml-2 mr-2" id="select_all_emails">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default btn-sm" form="emailsdelete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                <button type="button" class="btn btn-default btn-sm">
                                    <a href="{{ route($roleData['roleData']['emails_get_mails']) }}"><i
                                            class="fas fa-sync-alt"></i></a>
                                </button>
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @foreach($mails as $mail)

                                        <tr>
                                            <td>
                                                <div class="icheck-primary">
                                                    <label for="selected_emails[]" style="display: none"></label>
                                                    <input type="checkbox" id="selected_emails[]"
                                                           name="selected_emails[]" value="{{$mail->id}}">
                                                    <label for="selected_emails[]"></label>
                                                </div>
                                            </td>
                                            @if(!$mail->read)
                                                <td class="mailbox-star"><a
                                                        href="{{ route($roleData['roleData']['emails_open_email'], ['id' => $mail->id]) }}"><i
                                                            class="fas fa-solid fa-envelope"></i></a></td>

                                            @else
                                                <td class="mailbox-star"><a href="#"></a></td>
                                            @endif

                                            <td class="mailbox-star"><a
                                                    href="{{ route($roleData['roleData']['emails_restore_email'], ['id' => $mail->id]) }}"><i
                                                        class="fas fa-solid fa-share"></i></a></td>


                                            @if(!$mail->read)
                                                <td class="mailbox-name"><a
                                                        href="{{ route($roleData['roleData']['emails_open_email'], ['id' => $mail->id]) }}"><strong>{{ $mail->sender }}</strong></a>
                                                </td>

                                            @else
                                                <td class="mailbox-name"><a
                                                        href="{{ route($roleData['roleData']['emails_open_email'], ['id' => $mail->id]) }}">{{ $mail->sender }}</a>
                                                </td>
                                            @endif

                                            <td class="mailbox-subject">{{ $mail->subject }}</td>
                                            @if(isset($mail->attachment_paths))
                                                <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                            @else
                                                <td class="mailbox-attachment"></td>
                                            @endif
                                            <td class="mailbox-date">{{ $mail->date }}</td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <div class="mailbox-controls">

                        <div class="float-right">
                            <div class="btn-group">
                                {{ $mails->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
