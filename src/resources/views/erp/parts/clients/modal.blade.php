<!-- Модальное окно для редактирования -->
<div class="modal" id="editModal3{{ $clientBase->id }}" tabindex="1" role="dialog"
     aria-labelledby="editModal3Label{{ $clientBase->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal3Label">Додати коментар</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::model($clientBase, ['route' => [$roleData['roleData']['clients_add_comment'], $clientBase->getKey()], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    {{ Form::label('comment', 'comment') }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'style' => 'height: 100px;', 'placeholder' => 'comment']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('screenshot', 'screenshot') }}
                    {{ Form::file('screenshot', ['class' => 'form-control-file', 'id' => 'fileInput', 'accept' => 'application/pdf,image/jpeg,image/png']) }}
                </div>
                <div class="card-footer">
                    {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'id' => 'saveButton']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>


