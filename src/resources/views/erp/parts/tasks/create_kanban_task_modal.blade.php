<div id="myKanbanTaskModal{{$kanban->id}}" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Додати нове завдання</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form id="taskForm" class="mt-4" action="{{ route($roleData['roleData']['tasks_store_kanban_task']) }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kanban_id" value="{{$kanban->id}}">
                <div class="modal-body">
                    <label for="task" style="display: none"></label>
                    <input type="text" class="form-control" id="task" name="task" required>
                    <input type="hidden" name="kanban_id" value="{{$kanban->id}}">
                    <div class="col mt-3">
                        <div class="form-check">
                            <label for="primary" style="display: none"></label>
                            <input id="primary" name="task_color" class="form-check-input" type="radio" value="primary">
                            <div class="label label-secondary ml-2 mb-2"
                                 style="width: 150px; height: 24px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            </div>
                            <label for="secondary" style="display: none"></label>
                            <input id="secondary" name="task_color" class="form-check-input" type="radio"
                                   value="secondary">
                            <div class="label label-primary ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                            <label for="success" style="display: none"></label>
                            <input id="success" name="task_color" class="form-check-input" type="radio" value="success">
                            <div class="label label-success ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                            <label for="danger" style="display: none"></label>
                            <input id="danger" name="task_color" class="form-check-input" type="radio" value="danger">
                            <div class="label label-danger ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                            <label for="info" style="display: none"></label>
                            <input id="info" name="task_color" class="form-check-input" type="radio" value="info">
                            <div class="label label-info ml-2 mb-2" style="width: 150px; height: 24px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                    <button type="submit" class="btn btn-primary px-3 mr-2">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>
