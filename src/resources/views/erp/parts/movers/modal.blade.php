<!-- Модальное окно для редактирования -->
<div class="modal fade" id="editModal3{{ $orderDatesMover->id }}" tabindex="1" role="dialog"
     aria-labelledby="editModal3Label{{ $orderDatesMover->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Здесь разместите содержимое модального окна -->
            <div class="modal-header">
                <h5 class="modal-title" id="editModal3Label">Нарахувати премію</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::model($orderDatesMover, ['route' => [$roleData['roleData']['movers_add_bonus'], $orderDatesMover->getKey()], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="order_source">Премія для: </label>
                    <div class="col-lg-6">
                        <label for="order_source"
                               style="color: #008080; font-size: 16px;">{{ $orderDatesMover->mover->lastname }} {{ $orderDatesMover->mover->name }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 ml-4 col-form-label" for="bonus">Сума премії </label>
                    <div class="col-lg-6">
                        <select id="bonus" name="bonus" class="form-control">
                            <option value="" disabled selected></option>
                            <option value="100" {{ request()->input('bonus') == '100' ? 'selected' : '' }}>100</option>
                            <option value="200" {{ request()->input('bonus') == "200" ? 'selected' : '' }}>200</option>
                            <option value="300" {{ request()->input('bonus') == '300' ? 'selected' : '' }}>300</option>
                            <option value="400" {{ request()->input('bonus') == '400' ? 'selected' : '' }}>400</option>
                            <option value="500" {{ request()->input('bonus') == '700' ? 'selected' : '' }}>700</option>
                            <option value="800" {{ request()->input('bonus') == '800' ? 'selected' : '' }}>800</option>
                            <option value="900" {{ request()->input('bonus') == '900' ? 'selected' : '' }}>900</option>
                            <option value="1000" {{ request()->input('bonus') == '1000' ? 'selected' : '' }}>1000
                            </option>
                            <option value="1100" {{ request()->input('bonus') == '1100' ? 'selected' : '' }}>1100
                            </option>
                            <option value="1200" {{ request()->input('bonus') == '1200' ? 'selected' : '' }}>1200
                            </option>
                        </select>
                    </div>
                </div>


                <div class="card-footer">
                    {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'id' => 'saveButton', 'route'=>$roleData['roleData']['movers_planning']]) }}
                </div>

                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>


