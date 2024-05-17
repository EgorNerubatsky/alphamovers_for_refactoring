@extends('erp.content')
@section('title')
    <h2>{{ $chat->chat_name }}</h2>
@endsection
<script>
    let searchUsersRoute = "{{ route($roleData['roleData']['messages_search_users']) }}";
</script>

@section('content')
    <script>
        let privateChatId = "{{$chat->id}}";
    </script>
    <div class="form-row ml-3 mb-3 mt-3">
        <div class="col-lg-5 ml-3">
            @if($chat->chat_cover)
                <img src="{{ asset($chat->chat_cover) }}" height="90" width="90" class="mr-2 rounded-circle" alt="">
            @else
                <img src="{{ asset('img/movers_logo_mini.png') }}" height="90" width="90" class="mr-2 rounded-circle"
                     alt="">
            @endif
            <h4 class="card-title">@yield('title')</h4>

            <a href="#" data-toggle="modal" data-target="#updateChatModal{{$chat->id}}"
               class="btn btn-warning btn-sm mb-2 rounded d-inline-block" title="Редагувати">
                <i class="fas fa-edit"></i>
            </a>
            @include('erp.parts.messages.update_chat_title_modal')
            <a href="#" class="btn btn-danger btn-sm mb-2 rounded d-inline-block" data-toggle="modal"
               data-target="#confirmationModal"
               data-delete-url="{{ route($roleData['roleData']['messages_delete_chat'], ['id'=>$chat->getKey()]) }}"
               title="Видалити">
                <i class="fas fa-trash"></i>
            </a>
        </div>

        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
             aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Пiдтвердження</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Ви впевнені, що бажаєте видалити?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Вiдмiна</button>
                        <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @php
        $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <div class="card" style="min-width: 250px;">
                    <div class="card-body">
                        <div class="card-content">
                            <form action="{{ route($roleData['roleData']['messages_add_user'], ['id'=>$chat->id]) }}"
                                  method="post" enctype="multipart/form-data" class="form-profile">
                                @csrf
                                <div class="form-row ml-1 form-inline">
                                    <div class="custom-dropdown">
                                        <label for="selectUser" style="display: none"></label>
                                        <select class="js-select2" id="selectUser" name="recipient_user_id"
                                                style="width: 100%" required data-placeholder="Выберите сотрудника">
                                            <option></option>
                                        </select>
                                    </div>
                                    <button class="btn btn-danger btn-lg mb-2 ml-2" id="addButton"
                                            style="height: 38px;"><i class="fas fa-user-plus"></i></button>
                                </div>
                            </form>
                            <div class="card-content">
                                @foreach($chatUsers as $user)
                                    @php
                                        $randomColor = $colors[array_rand($colors)];
                                    @endphp
                                    <a href="#" data-toggle="modal" data-target="#myModal{{$user->id}}">
                                        <div class="alert alert-{{ $randomColor }}"><img
                                                src="{{ asset($user->photo_path) }}" height="30" width="30"
                                                class="mr-2 circle-rounded" alt="">{{$user->name}} {{$user->lastname}}
                                        </div>
                                    </a>
                                    @include('erp.parts.messages.create_user_chat_message_modal', ['user'=>$user])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <button type="button" data-toggle="collapse" href="#messageForm2" aria-expanded="false"
                                        aria-controls="messageForm2" class="btn mb-1 btn-outline-dark"
                                        style="width: 250px;">Надiслати повiдомлення у чат
                                </button>
                            </div>
                        </div>
                        <div class="basic-form">
                            <div id="messageForm2" class="collapse">
                                <br>

                                <form
                                    action="{{ route($roleData['roleData']['messages_store_chat_message'], ['id'=>$chat->id]) }}"
                                    method="post" enctype="multipart/form-data" class="form-profile">
                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="message">Текст повiдомлення</label>
                                            <textarea class="form-control summernote" name="message" id="message"
                                                      required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <div class="btn btn-default btn-file mt-4">
                                                <i class="fas fa-paperclip"></i> Додати файл
                                                <input type="file" id="message_file" name="message_file">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-8 text-right mt-4">
                                            <button type="submit" class="btn btn-primary px-3 mr-2">Вiдправити</button>
                                            <a href="{{ route($roleData['roleData']['messages_index']) }}"
                                               class="btn btn-primary px-3">Скинути</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" id="render-chat-messages">
                        @include('erp.parts.messages.modules.chat_messages')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
