<div id="kanbanEditModal{{$kanban->id}}" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Змiна назви</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form id="taskForm" class="mt-4" action="{{ route($roleData['roleData']['tasks_update_kanban']) }}"
                  method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="kanban_id" value="{{$kanban->id}}">
                    <label for="kanban_title" style="display: none"></label>
                    <input type="text" class="form-control" id="kanban_title" name="kanban_title"
                           value="{{$kanban->kanban_title}}" required>
                    <div class="col mt-3">
                        <div class="form-check"><label for="kanban_title" style="display: none"></label>
                            <label for="primary" style="display: none"></label>
                            <input id="primary" name="title_color" class="form-check-input" type="radio" value="primary"
                                   @if ($kanban->title_color == 'primary') checked @endif>
                            <div class="label label-info ml-2 mb-2" style="width: 150px; height: 24px;">
                                {{substr($kanban->kanban_title, 0, 35)}}</div>
                            <label for="secondary" style="display: none"></label>
                            <input id="secondary" name="title_color" class="form-check-input" type="radio"
                                   value="secondary" @if ($kanban->title_color == 'secondary') checked @endif>
                            <div class="label label-primary ml-2 mb-2" style="width: 150px; height: 24px;">
                                {{substr($kanban->kanban_title, 0, 35)}}</div>
                            <label for="success" style="display: none"></label>
                            <input id="success" name="title_color" class="form-check-input" type="radio" value="success"
                                   @if ($kanban->title_color == 'success') checked @endif>
                            <div class="label label-success ml-2 mb-2" style="width: 150px; height: 24px;">
                                {{substr($kanban->kanban_title, 0, 35)}}</div>
                            <label for="danger" style="display: none"></label>
                            <input id="danger" name="title_color" class="form-check-input" type="radio" value="danger"
                                   @if ($kanban->title_color == 'danger') checked @endif>
                            <div class="label label-danger ml-2 mb-2" style="width: 150px; height: 24px;">
                                {{substr($kanban->kanban_title, 0, 35)}}</div>
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
