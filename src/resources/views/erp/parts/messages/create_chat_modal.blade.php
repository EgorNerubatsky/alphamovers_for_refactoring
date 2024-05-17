<script>
    function submitFormAndReload() {
        document.getElementById('taskForm').submit();
    }

    if (session('reload'))
        window.location.href = window.location.href;
</script>

<div id="myModal" class="modal">
    <div class="modal-content-my">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Додати новий чат</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form id="taskForm" class="mt-4" action="{{ route($roleData['roleData']['messages_store_chat']) }}" method="post"
                  enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="chat_name" class="col-form-label">Назва нового чату:</label>
                    <textarea class="form-control" id="chat_name" name="chat_name" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="submitFormAndReload()">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>
