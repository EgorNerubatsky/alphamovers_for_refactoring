<div class="form-row mb-3 mt-3 ml-4">
    <div class="col-md-4">
        <h2>@yield('title')</h2>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row col-md-12 mb-9">
                        <div class="row col-md-10 mb-9 mt-4">
                            <h3 class="ml-4">{{ $applicant->fullname }}</h3>
                        </div>
                        {{--                        <div class="form-group row mt-4">--}}
                        <div class="row col-md-10 mb-9 mt-4">
                            @foreach($applicantFiles as $applicantFile)
                                @if(!empty($applicantFile->path))
                                    @php
                                        $extension = pathinfo($applicantFile->path, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(in_array($extension, ['jpeg', 'jpg', 'png', 'bmp']))
                                        <label class="col-lg-3 ml-4 col-form-label" for="lastname">
                                            <div style="position: relative; display: inline-block;">
                                                <img src="{{ asset($applicantFile->path) }}"
                                                     class="img-circle elevation-2" alt="User Image">
                                                <a href="#" class="btn btn-danger btn-rounded btn-sm"
                                                   style="position: absolute; top: 5px; right: 5px;"
                                                   data-toggle="modal" data-target="#confirmationModal"
                                                   data-delete-url="{{ route($roleData['roleData']['applicants_delete_file'], ['id'=> $applicantFile->getKey()]) }}"
                                                   title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </label>
                                    @endif

                                    <div class="col-lg-8">
                                        @if(in_array($extension, ['pdf','doc', 'docx']))
                                            <a href="{{ asset($applicantFile->path) }}" target="_blank" class="btn mb-1 btn-rounded btn-warning">
                                                <span class="btn-icon-left">
                                                    <i class="fas fa-eye"></i>
                                                </span>Переглянути резюме
                                            </a>

                                            <a href="#" data-toggle="modal" data-target="#confirmationModal" data-delete-url="{{ route($roleData['roleData']['applicants_delete_file'], ['id'=> $applicantFile->getKey()]) }}" title="Delete" class="btn btn-danger btn-rounded btn-sm">
                                                <span >
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                             aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Пiдтвердження</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">

                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Ви впевнені, що бажаєте видалити?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Вiдмiна
                                        </button>
                                        <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::model($applicant, ['route' => [$roleData['roleData']['applicants_update'], $applicant->getKey()], 'method' => 'put','enctype' => 'multipart/form-data', 'id' => 'form1']) }}
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="lastname">Прізвище</label>
                        <div class="col-lg-6">
                            <label for="fullname_surname" style="display: none"></label>
                            <input id="fullname_surname"
                                   name="fullname_surname"
                                   class="form-control"
                                   value="{{ $fullnameSurname }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_name">Ім'я</label>
                        <div class="col-lg-6">
                            <input id="fullname_name" name="fullname_name" class="form-control"
                                   value="{{ $fullnameName }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_patronymic">По-батькові</label>
                        <div class="col-lg-6">
                            <input id="fullname_patronymic" name="fullname_patronymic" class="form-control"
                                   value="{{ $fullnamePatronymic }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                        <div class="col-lg-6">
                            <input id="phone" name="phone" class="form-control" value="{{ $applicant->phone }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="desired_position">Бажана посада</label>
                        <div class="col-lg-6">
                            <input id="desired_position" name="desired_position" class="form-control"
                                   value="{{ $applicant->desired_position }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="comment">Коментар</label>
                        <div class="col-lg-6">
                            <textarea type="input" id="comment" name="comment" class="form-control"
                                      value="{{ $applicant->comment }}">{{ $applicant->comment }}</textarea>
                        </div>
                    </div>

                    <hr class="w-100">
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="applicant_photo">Завантажити фото</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="applicant_photo"
                                           id="applicant_photo"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel1'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel1">Вибрати
                                        фото</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="applicant_file">Завантажити файл</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="applicant_file"
                                           id="applicant_file"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel2'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel2">Вибрати
                                        файл</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-10 mb-14">
                        <div class="col-md-4 mb-4">
                            {{ Form::submit('Зберегти', ['class' => 'btn btn-primary', 'form' => 'form1']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

