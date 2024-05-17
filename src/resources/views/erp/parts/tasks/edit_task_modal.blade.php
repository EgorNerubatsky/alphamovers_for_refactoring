<div class="modal" id="modalEdit" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редагувати завдання</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

        <div class="modal-body">

            <form id="eventForm" class="mt-4" action="{{ route($roleData['roleData']['tasks_update']) }}"
                  method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <input type="hidden" id="eventId" name="eventId">
                    <label for="eventTitle" class="col-form-label">Завдання:</label>
                    <textarea class="form-control" id="eventTitle" name="eventTitle" required></textarea>
                </div>
                <div class="form-group">
                    <label for="eventStart" class="col-form-label">Початок виконання:</label>
                    <input type="datetime-local" id="eventStart" name="eventStart" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="eventEnd" class="col-form-label">Дата виконання:</label>
                    <input type="datetime-local" id="eventEnd" name="eventEnd" class="form-control">
                </div>
                <div class="form-group">
                    <label for="status" class="col-form-label">Статус:</label>
                </div>
                <select id="status" name="status" class="form-control">
                    <option value="Нове" name="Нове">Нове</option>
                    <option value="У роботі" name="У роботі">У роботі</option>
                    <option value="Виконано" name="Виконано">Виконано</option>
                </select>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="moveToWorkButton">У роботу</button>
                    <button type="button" class="btn btn-info" id="markAsDoneButton">Виконано</button>
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
