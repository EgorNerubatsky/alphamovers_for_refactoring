
<div id="myTaskModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Додати нове завдання</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form id="taskForm" class="mt-4" action="{{ route($roleData['roleData']['tasks_store']) }}"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="task_to_user_id" class="col-form-label">Завдання для:</label>
                        <select id="task_to_user_id" name="task_to_user_id" class="form-control" required>
                            <option value="{{ Auth::id() }}" name="{{ Auth::id() }}">Собi</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}" name="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="company" class="col-form-label">Компанiя:</label>
                        <select id="company" name="company" class="form-control" required>
                            <option value="" name="">Оберiть компанiю</option>

                            @foreach($companys as $company)
                                <option value="{{ $company->company }}"
                                        name="{{ $company->id }}">{{ $company->company }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="task" class="col-form-label">Завдання:</label>
                        <textarea class="form-control" id="task" name="task" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="start_task" class="col-form-label">Дата початку:</label>
                        <input type="datetime-local" id="start_task" name="start_task" class="form-control"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="end_task" class="col-form-label">дата закінчення:</label>
                        <input type="datetime-local" id="end_task" name="end_task" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
