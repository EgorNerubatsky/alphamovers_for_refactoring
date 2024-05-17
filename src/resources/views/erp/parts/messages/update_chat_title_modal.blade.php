<style>
    #updateChatModal{{ $chat->id }}   {
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0; /* Set initial opacity to 0 */
        pointer-events: none; /* Make it not clickable initially */
        transition: opacity 0.5s ease; /* Add a smooth transition for opacity */
    }

    #updateChatModal{{ $chat->id }}.show {
        opacity: 1; /* Make it fully visible when the 'show' class is added */
        pointer-events: auto; /* Enable pointer events when visible */
    }
</style>


<div class="modal" id="updateChatModal{{$chat->id}}" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
     aria-hidden="true">

    <div class="modal-content-my">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Нова назва для <strong>{{$chat->chat_name}}</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form id="taskForm" class="mt-4"
                  action="{{ route($roleData['roleData']['messages_update_chat'], ['id'=>$chat->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="recipient_user_id" name="recipient_user_id" value="{{ $chat->id }}">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="message">Назва Чату</label>
                        <label for="chat_name" style="display: none"></label>
                        <input class="form-control" name="chat_name" id="chat_name" value="{{ $chat->chat_name }}"
                               required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="btn btn-default btn-file mt-4">
                            <i class="fas fa-paperclip"></i> Фото чату
                            <input type="file" id="chat_cover" name="chat_cover">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-3 mr-2">Зберегти</button>
                    <a href="{{ route($roleData['roleData']['messages_show_chat'], ['id'=>$chat->id]) }}"
                       class="btn btn-secondary px-3">Скинути</a>
                </div>
            </form>
        </div>
    </div>
</div>
