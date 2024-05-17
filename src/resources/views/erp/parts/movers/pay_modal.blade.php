<!-- Модальное окно для редактирования -->
<div class="modal fade" id="editModal2{{ $orderDatesMover->id }}" tabindex="1" role="dialog"
     aria-labelledby="editModal2Label{{ $orderDatesMover->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal2Label">Нарахувати премію</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::model($orderDatesMover, ['route' => [$roleData['roleData']['movers_pay_to_mover'], $orderDatesMover->getKey()], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="row col-md-12 mb-9">
                    <div class="col-md-12 mb-4">
                        <label for="order_source">Здійснити оплату для <label for="order_source"
                                                                              style="color: #008080; font-size: 16px;">{{ $orderDatesMover->mover->lastname }} {{ $orderDatesMover->mover->name }}
                                ?</label></label>
                    </div>
                </div>
                <div class="card-footer">
                    {{ Form::submit('Оплатити', ['class' => 'btn btn-primary', 'id' => 'saveButton', 'route'=>$roleData['roleData']['movers_planning']]) }}
                </div>
                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>


