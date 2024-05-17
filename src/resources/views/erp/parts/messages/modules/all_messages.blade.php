<h4 class="mb-5">Вхiднi повiдомлення</h4>



@foreach($scopeMessages as $message)
    <div class="media media-reply">
        @if(isset($message->user))
            <img class="mr-3 circle-rounded" src="{{asset($message->user->photo_path)}}"
                 width="50"
                 height="50" alt="Generic placeholder image">
            <div class="media-body bg-light">
                <div class="d-sm-flex justify-content-between mb-2">
                    <h5 class="mb-sm-0">{{ $message->user->name }} {{ $message->user->lastname }}
                        @if(isset($message->created_at))
                            <small
                                class="text-muted ml-3">{{$message->created_at->format('d.m.Y')}} {{$message->created_at->format('H:i')}}</small>
                        @endif
                    </h5>
                    @endif
                    <div class="media-reply__link">
                        <button class="btn btn-transparent p-0 mr-3"><i
                                class="fa fa-thumbs-up"></i>
                        </button>
                        @if(isset($message->id))
                            <a href="{{ route($roleData['roleData']['messages_read_message'], ['id'=>$message->id]) }}"
                               class="btn btn-transparent p-0 mr-3" data-toggle="tooltip"
                               title="Прочитано"><i class="icon-speech"></i></a>
                            <a href="{{ route($roleData['roleData']['messages_delete_message'], ['id'=>$message->id]) }}"
                               class="btn btn-transparent p-0 mr-3" data-toggle="tooltip"
                               title="Видалити"><i class="far fa-trash-alt"></i></a>
                            <a href="#" data-toggle="modal"
                               data-target="#myModal{{$message->id}}"
                               class="btn btn-transparent p-0 ml-3 font-weight-bold">Вiдповiсти</a>
                            @include('erp.parts.messages.create_user_reply_message_modal', ['id'=>$message->id])
                        @endif
                    </div>
                </div>
                @if(isset($message->message))
                    <p>{!! $message->message !!}</p>
                    @if(isset($message->attachment_path))
                        @php
                            $fileExtension = pathinfo($message->attachment_path, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($fileExtension), ['jpeg', 'jpg', 'png', 'gif']);
                            $isDocument = in_array(strtolower($fileExtension), ['doc', 'docx', 'pdf', 'pptx', 'ppt']);
                        @endphp

                        @if($isImage)
                            <a href="#" data-toggle="modal"
                               data-target="#previewModal{{$message->id}}">
                                <img src="{{asset($message->attachment_path)}}"
                                     alt="Screenshot Preview"
                                     style="max-width: 200px; height: auto;">
                            </a>

                            <div class="modal fade" id="previewModal{{$message->id}}"
                                 tabindex="-1"
                                 role="dialog" aria-labelledby="previewModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="previewModalLabel">
                                                Просмотр</h5>
                                            <button type="button" class="close"
                                                    data-dismiss="modal"
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
                            <div
                                class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <div class="mailbox-attachment-info">
                                    <a href="{{ asset($message->attachment_path) }}"
                                       target="_blank"
                                       class="btn btn-default btn-sm float-right"><span
                                            class="mailbox-attachment-icon"><i
                                                class="far fa-file-word"></i></span>{{ $filename }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <div style="position: relative; display: inline-block;">
                @if(isset($message->read))
                    @if(!$message->read)
                        <span class="badge badge-pill gradient-1"
                              style="position: absolute; top: -5px; right: -5px;">new</span>
                    @endif
                @endif
            </div>
    </div>
@endforeach

<div class="card-tools">
    {{ $scopeMessages->links('pagination::bootstrap-4') }}
</div>
