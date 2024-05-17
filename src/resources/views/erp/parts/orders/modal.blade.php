<!-- Модальное окно для редактирования -->
<div class="modal fade" id="editModal2{{ $order->id }}" tabindex="1" role="dialog"
     aria-labelledby="editModal2Label{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Здесь разместите содержимое модального окна -->
            <div class="modal-header">
                <h5 class="modal-title" id="editModal2Label">Додати коментар</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::model($order, ['route' => [$roleData['roleData']['orders_addComment'], $order->getKey()], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    {{ Form::label('comment', 'comment') }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'style' => 'height: 100px;', 'placeholder' => 'comment']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('screenshot', 'screenshot') }}
                    {{ Form::file('screenshot', ['class' => 'form-control-file', 'id' => 'fileInput', 'accept' => 'application/pdf,image/jpeg,image/png']) }}
                </div>


                <div class="card-footer">
                    {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'id' => 'saveButton', 'route'=>'erp.manager.leads.update']) }}
                </div>

                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>


