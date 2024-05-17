<div class="modal fade" id="createLeadModal" tabindex="-1" role="dialog"
     aria-labelledby="createLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLeadModalLabel">Створити лiд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="taskForm" class="mt-4" action="{{ route($roleData['roleData']['leads_store']) }}"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        {{ Form::label('company', 'Company') }}
                        {{ Form::text('company', null, ['class' => 'form-control', 'required' => true]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('fullname', 'Fullname') }}
                        {{ Form::text('fullname', null, ['class' => 'form-control', 'required' => true]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('phone', 'phone') }}
                        {{ Form::text('phone', null, ['class' => 'form-control', 'maxlength'=>13, 'required' => true, 'pattern' => '(\+)?380[0-9]{9}', 'title'=>"Необхідно ввести коректний номер '+380 та 9 цифр'"]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', 'email') }}
                        {{ Form::text('email', null, ['class' => 'form-control', 'required' => true, 'pattern' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}', 'title'=>"Необхідно ввести коректне Прізвище"]) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('comment', 'comment') }}
                        {{ Form::textarea('comment', null, ['class' => 'form-control', 'style' => 'height: 100px;','maxlength'=>255]) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', 'Status') }}
                        {{ Form::select('status', ['новый' => 'новый', 'в работе' => 'в работе', 'отказ' => 'отказ', 'удален' => 'удален'], ['class' => 'form-control', 'placeholder' => 'новый', 'name' => 'status']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('lead_file', 'File') }}
                        {{ Form::file('lead_file', ['class' => 'form-control-file']) }}
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-3 mr-2">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






















<style>
    #createLeadModal  {
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0; /* Set initial opacity to 0 */
        pointer-events: none; /* Make it not clickable initially */
        transition: opacity 0.3s ease; /* Add a smooth transition for opacity */
    }

    #createLeadModal.show {
        opacity: 1; /* Make it fully visible when the 'show' class is added */
        pointer-events: auto; /* Enable pointer events when visible */
    }
</style>
<div class="modal" id="createLeadModal" aria-labelledby="createLeadModalLabel">
    <div class="modal-content-my">
        <div class="modal-header">
            <h5 class="modal-title" id="createLeadModalLabel">Новий лiд</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="taskForm" class="mt-4" action="{{ route($roleData['roleData']['leads_store']) }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    {{ Form::label('company', 'Company') }}
                    {{ Form::text('company', null, ['class' => 'form-control', 'required' => true]) }}
                </div>
            <div class="form-group">
                {{ Form::label('fullname', 'Fullname') }}
                {{ Form::text('fullname', null, ['class' => 'form-control', 'required' => true]) }}
            </div>
            <div class="form-group">
                {{ Form::label('phone', 'phone') }}
                {{ Form::text('phone', null, ['class' => 'form-control', 'maxlength'=>13, 'required' => true, 'pattern' => '(\+)?380[0-9]{9}', 'title'=>"Необхідно ввести коректний номер '+380 та 9 цифр'"]) }}
            </div>
            <div class="form-group">
                {{ Form::label('email', 'email') }}
                {{ Form::text('email', null, ['class' => 'form-control', 'required' => true, 'pattern' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}', 'title'=>"Необхідно ввести коректне Прізвище"]) }}
            </div>

            <div class="form-group">
                {{ Form::label('comment', 'comment') }}
                {{ Form::textarea('comment', null, ['class' => 'form-control', 'style' => 'height: 100px;','maxlength'=>255]) }}
            </div>

            <div class="form-group">
                {{ Form::label('status', 'Status') }}
                {{ Form::select('status', ['новый' => 'новый', 'в работе' => 'в работе', 'отказ' => 'отказ', 'удален' => 'удален'], ['class' => 'form-control', 'placeholder' => 'новый', 'name' => 'status']) }}
            </div>

                <div class="form-group">
                    {{ Form::label('lead_file', 'File') }}
                    {{ Form::file('lead_file', ['class' => 'form-control-file', 'accept' => '.pdf,.doc,.docx']) }}
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                <button type="submit" class="btn btn-primary px-3 mr-2">Зберегти</button>
            </div>
            </form>
        </div>

    </div>
</div>


