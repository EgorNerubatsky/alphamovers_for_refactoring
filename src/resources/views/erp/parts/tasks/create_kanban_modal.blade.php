<script>
    function submitFormAndReload() {
        document.getElementById('kanbanForm').submit();
    }
    // После успешной отправки формы, перенаправляем на текущую страницу
    // if(session('reload'))
    //     window.location.href = window.location.href;
</script>

<div id="myKanbanModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Додати новий канбан</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form id="kanbanForm" class="mt-4" action="{{ route($roleData['roleData']['tasks_store_kanban']) }}"
                  method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <label for="kanban_title" class="form-label">Назва нового канбану:</label>
                    <input class="form-control" id="kanban_title" name="kanban_title" required>
                    <div class="col mt-3">
                        <div class="form-check">
                            <label for="primary" style="display: none"></label>
                            <input id="primary" name="title_color" class="form-check-input" type="radio"
                                   value="primary">
                            <div class="label label-secondary ml-2 mb-2"
                                 style="width: 150px; height: 24px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            </div>
                            <label for="secondary" style="display: none"></label>
                            <input id="secondary" name="title_color" class="form-check-input" type="radio"
                                   value="secondary">
                            <div class="label label-primary ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                            <label for="success" style="display: none"></label>
                            <input id="success" name="title_color" class="form-check-input" type="radio"
                                   value="success">
                            <div class="label label-success ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                            <label for="danger" style="display: none"></label>
                            <input id="danger" name="title_color" class="form-check-input" type="radio" value="danger">
                            <div class="label label-danger ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                            <label for="info" style="display: none"></label>
                            <input id="info" name="title_color" class="form-check-input" type="radio" value="info">
                            <div class="label label-info ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-primary" onclick="submitFormAndReload()">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>
