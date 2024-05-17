<div class="modal fade bd-example-modal-sm" id="myModalChat{{ $message->id }}" tabindex="-1" role="dialog"
     aria-labelledby="previewModalLabel" aria-hidden="true">

    <div class="modal-content-my">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Повiдомлення для
                <strong>{{ $message->user->name }} {{ $message->user->lastname }}</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="taskForm" class="mt-4"
                  action="{{ route($roleData['roleData']['messages_chat_reply'], ['id'=> $message->id]) }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="message">Текст повiдомлення</label>
                        <textarea class="form-control" name="message" id="message" cols="60" rows="6"
                                  placeholder="Ваша вiдповiдь" required></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="btn btn-default btn-file mt-4">
                            <i class="fas fa-paperclip"></i> Додати файл
                            <input type="file" id="message_file" name="message_file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Вiдправити</button>
                    <a href="{{ route($roleData['roleData']['messages_index']) }}" class="btn btn-secondary px-3">Скинути</a>
                </div>
            </form>
        </div>
    </div>
</div>
