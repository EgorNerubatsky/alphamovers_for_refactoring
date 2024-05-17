@extends('erp.content')

@section('title')
    <h2>Спiлкування</h2>
@endsection
<script>
    let searchUsersRoute = "{{ route($roleData['roleData']['messages_search_users']) }}";
</script>

@section('content')
    @if(session('reload'))
        <script>
            location.reload();
        </script>

    @endif

    <div class="form-row mb-3 mt-3 ml-4">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>

    </div>





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
                            <div class="col-md-6  ml-auto">
                                <form action="{{ route($roleData['roleData']['messages_search']) }}" method="GET">
                                    <div class="input-group">
                                        <label for="search" style="display: none"></label>
                                        <input type="text" id="search" name="search" class="form-control rounded"
                                               value="{{ Request::get('search') }}" style="height: 40px;">
                                        <div class="append">
                                            <button class="btn btn-outline-dark rounded-1" type="submit"
                                                    style="height: 40px;">
                                                Пошук
                                            </button>
                                            <a href="{{ route($roleData['roleData']['messages_index']) }}"
                                               class="btn btn-outline-info"
                                               style="height: 40px;">Скинути</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="basic-form">
                            <div id="messageForm" class="collapse">
                                <br>
                                <form action="{{ route($roleData['roleData']['messages_store_message']) }}"
                                      method="post"
                                      enctype="multipart/form-data" class="form-profile">
                                    @csrf
                                    <div class="custom-dropdown">
                                        <label for="selectUser" style="display: none"></label>
                                        <select class="js-select2" id="selectUser" name="recipient_user_id"
                                                style="width: 100%" required data-placeholder="Выберите сотрудника">
                                            <option></option>
                                        </select>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="message">Текст
                                                повiдомлення</label>
                                            <textarea
                                                class="form-control summernote"
                                                name="message" id="message"
                                                required></textarea>
                                        </div>
                                    </div>
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

                    <div class="card-body" id="render-all-messages">
                        @include('erp.parts.messages.modules.all_messages')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
