@php use App\Models\Message;use App\Models\User; @endphp
@extends('erp.content')

@section('title')
    <h2>{{ $privateUser->name }} {{ $privateUser->lastname }}</h2>
@endsection

@section('content')
    @if(session('reload'))
        <script>
            location.reload();
        </script>
    @endif
    <div class="form-row mb-3 mt-3 ml-4">
        <div class="col-md-4">
            <h3 class="card-title"><img src="{{ asset($privateUser->photo_path) }}" height="40" width="40"
                                        class="mr-2 rounded-circle" alt=""> @yield('title')</h3>
        </div>
    </div>
    <script>
        let privateUserId = "{{ $privateUser->id }}";
    </script>
    @php
        $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
    @endphp
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-4 col-xl-4" id="render-messages-chats">
                @include('erp.parts.messages.modules.chats_and_privats')
            </div>

            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <button type="button" data-toggle="collapse" href="#messageForm" aria-expanded="false"
                                        aria-controls="messageForm" class="btn mb-1 btn-outline-dark"
                                        style="width: 200px;">Нове повiдомлення
                                </button>
                            </div>
                        </div>

                        <div class="basic-form">
                            <div id="messageForm" class="collapse">
                                <br>
                                <form action="{{ route($roleData['roleData']['messages_store_message']) }}"
                                      method="post"
                                      enctype="multipart/form-data" class="form-profile">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="message">Текст
                                                повiдомлення</label>
                                            <textarea class="form-control summernote" name="message" id="message"
                                                      required>
                                            </textarea>
                                        </div>
                                    </div>
                                    <input type="hidden"
                                           id="recipient_user_id"
                                           name="recipient_user_id"
                                           value="{{ $privateUser->id }}"
                                           required>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <div
                                                class="btn btn-default btn-file mt-4">
                                                <i class="fas fa-paperclip"></i>
                                                Додати файл
                                                <input type="file"
                                                       id="message_file"
                                                       name="message_file">
                                            </div>
                                        </div>
                                        <div
                                            class="form-group col-md-8 text-right mt-4">
                                            <button type="submit"
                                                    class="btn btn-success">
                                                Вiдправити
                                            </button>
                                            <a href="{{ route($roleData['roleData']['messages_index']) }}"
                                               class="btn btn-secondary px-3">Скинути</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-5">Повiдомлення</h4>

                        <div id="render-messages">
                            @include('erp.parts.messages.modules.private_chat_messages')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
