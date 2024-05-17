@php use App\Models\ChatsActivity; @endphp
@foreach($chatMessages as $message)
    <div class="media media-reply">
        <img class="mr-3 circle-rounded" src="{{asset($message->user->photo_path)}}" width="50"
             height="50" alt="Generic placeholder image">
        <div class="media-body">
            <div class="d-sm-flex justify-content-between mb-2">
                <h5 class="mb-sm-0">{{ $message->user->name }} {{ $message->user->lastname }}
                    @if($message->created_at != $message->updated_at)

                        <small
                            class="text-muted ml-3">{{$message->created_at->format('d.m.Y')}} {{$message->created_at->format('H:i')}}
                            (Кореговано)</small>
                    @else
                        <small
                            class="text-muted ml-3">{{$message->created_at->format('d.m.Y')}} {{$message->created_at->format('H:i')}}</small>
                    @endif
                </h5>
                <div class="media-reply__link">
                    <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-up"></i>
                    </button>
                    @if($message->user->id == Auth::user()->id)

                        <a href="#" class="btn btn-transparent p-0 mr-3" data-toggle="modal"
                           data-target="#confirmationModal"
                           data-delete-url="{{ route($roleData['roleData']['messages_delete_chat_message'], ['id'=>$message->id]) }}"
                           title="Видалити">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    @endif

                    <a href="#" data-toggle="modal" data-target="#myModalChat{{$message->id}}"
                       class="btn btn-transparent p-0 ml-3 font-weight-bold">Вiдповiсти</a>
                    @include('erp.parts.messages.create_user_reply_chat_modal', ['id'=>$message->id])
                </div>
            </div>
            @if(isset($message->reply_id))
                @php
                    $reply = ChatsActivity::findOrFail($message->reply_id);
                @endphp

                <div class='card' style='color: #acbad5'>
                    <div class='card-body'>
                        {{$reply->user->name}} {{$reply->user->lastname}}
                        ({{$reply->created_at->format('d.m.Y, H:i')}}):<br>{{$reply->message}}
                        <br>
                    </div>
                </div>
            @endif
            <p>{!! $message->message !!}</p>

            @if(isset($message->attachment_path))
                @php
                    $fileExtension = pathinfo($message->attachment_path, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($fileExtension), ['jpeg', 'jpg', 'png', 'gif']);
                    $isDocument = in_array(strtolower($fileExtension), ['doc', 'docx', 'pdf', 'pptx', 'ppt']);
                @endphp
                @if($isImage)
                    <a href="#" data-toggle="modal" data-target="#previewModal{{$message->id}}">
                        <img src="{{asset($message->attachment_path)}}" alt="Screenshot Preview"
                             style="max-width: 200px; height: auto;">
                    </a>
                    <div class="modal fade" id="previewModal{{$message->id}}" tabindex="-1"
                         role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="previewModalLabel">Просмотр</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset($message->attachment_path) }}"
                                         alt="Screenshot Preview" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($isDocument)
                    @php
                        $pathInfo = pathinfo($message->attachment_path);
                        $filename = $pathInfo['filename'];
                    @endphp
                    <div class="mailbox-attachments d-flex align-items-stretch clearfix">
                        <div class="mailbox-attachment-info">
                            <a href="{{ asset($message->attachment_path) }}" target="_blank"
                               class="btn btn-default btn-sm float-right"><span
                                    class="mailbox-attachment-icon"><i
                                        class="far fa-file-word"></i></span>{{ $filename }}</a>
                        </div>
                    </div>
                @endif
            @endif






            @if($message->user_id == $sender->id)
                <div class="form-row">
                    <div class="col-md-4">
                        <button type="button" data-toggle="collapse"
                                href="#messageForm2{{$message->id}}" aria-expanded="false"
                                aria-controls="messageForm2{{$message->id}}"
                                class="btn mb-1 btn-primary btn-xs btn-edit">Корегувати
                        </button>
                    </div>
                </div>
                <div class="basic-form">
                    <div id="messageForm2{{$message->id}}" class="collapse">
                        <br>

                        <form
                            action="{{ route($roleData['roleData']['messages_update_chat_message'], ['id'=>$message->id]) }}"
                            method="post" enctype="multipart/form-data" class="form-profile">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="message">Коригувати повiдомлення</label>
                                    <textarea class="form-control summernote" name="message"
                                              id="message"
                                              required>{{$message->message}}</textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="btn btn-default btn-file mt-4">
                                        <i class="fas fa-paperclip"></i> Додати файл
                                        <input type="file" id="message_file"
                                               name="message_file">
                                    </div>
                                </div>
                                <div class="form-group col-md-8 text-right mt-4">
                                    <button type="submit" class="btn btn-primary px-3 mr-2">
                                        Вiдправити
                                    </button>
                                    <a href="{{ route($roleData['roleData']['messages_index']) }}"
                                       class="btn btn-primary px-3">Скинути</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif


        </div>
    </div>
@endforeach
<div class="card-tools">
    {{ $chatMessages->links('pagination::bootstrap-4') }}
</div>
