<div class="modal fade" id="editLeadModal{{ $lead->id }}" tabindex="-1" role="dialog"
     aria-labelledby="editLeadModalLabel{{ $lead->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeadModalLabel{{ $lead->id }}">Редагувати лiд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::model($lead, ['route' => [$roleData['roleData']['leads_update'], $lead->getKey()], 'method' => 'put','enctype'=>"multipart/form-data"]) }}
                {{ Form::hidden('_token', csrf_token()) }}
                <div class="form-group">
                    {{ Form::label('company', 'Компанія') }}
                    {{ Form::text('company', null, ['class' => 'form-control', 'required' => true]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('fullname', 'ПІБ') }}
                    {{ Form::text('fullname', null, ['class' => 'form-control', 'placeholder' => 'Fullname','required' => true]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('phone', 'Телефон') }}
                    {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'phone', 'maxlength'=>13, 'required' => true, 'pattern' => '(\+)?380[0-9]{9}', 'title'=>"Необхідно ввести коректний номер '+380 та 9 цифр'"]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'E-mail') }}
                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'email', 'required' => true, 'pattern' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}', 'title'=>"Необхідно ввести коректне Прізвище"]) }}
                </div>

                <div class="form-group">
                    {{ Form::label('comment', 'Опис') }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'style' => 'height: 100px;', 'placeholder' => 'comment', 'maxlength'=>255]) }}
                </div>

                <div class="form-group">
                    {{ Form::label('status', 'Статус') }}
                    {{ Form::select('status', ['новый' => 'новый', 'в работе' => 'в работе', 'отказ' => 'отказ', 'удален' => 'удален'], null, ['class' => 'form-control', 'placeholder' => 'Select status', 'name' => 'status']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('lead_file', 'Документи') }}<br>
                    @foreach($lead->documentsPaths as $document)
                        <a href="{{ asset($document->path) }}" target="_blank" data-toggle="tooltip"
                           title="Завантажити"><span class="badge badge-success"><i
                                    class="fas fa-download"></i> {{ pathinfo(str_replace('\\','/',$document->path), PATHINFO_FILENAME) }}</span>
                        </a>
                        <a href="#" class="btn btn-danger btn-rounded btn-sm" data-toggle="modal"
                           data-target="#confirmationModal"
                           data-delete-url="{{ route($roleData['roleData']['leads_delete_file'], ['id'=> $document->getKey()]) }}"
                           title="Видалити">
                            <i class="fas fa-trash"></i>
                        </a>
                        <br>
                    @endforeach
                    <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control-file" name="lead_file"
                               id="lead_file"
                               onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">
                        <label class="custom-file-label" for="customFile" id="fileNameLabel1">Вибрати
                            фото</label>
                    </div>
                </div>


                <div class="card-footer">
                    {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'id' => 'saveButton', 'route'=>$roleData['roleData']['leads_update']]) }}

                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

