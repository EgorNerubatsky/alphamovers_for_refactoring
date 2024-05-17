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
                    {{ Form::open(['route' => $roleData['roleData']['applicants_store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'form1']) }}
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_surname">Прізвище</label>
                        <div class="col-lg-6">
                            <input id="fullname_surname" name="fullname_surname" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_name">Ім'я</label>
                        <div class="col-lg-6">
                            <input id="fullname_name" name="fullname_name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="fullname_patronymic">По-батькові</label>
                        <div class="col-lg-6">
                            <input id="fullname_patronymic" name="fullname_patronymic" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="phone">Телефон</label>
                        <div class="col-lg-6">
                            <input id="phone" name="phone" class="form-control" placeholder="+380" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="desired_position">Бажана посада</label>
                        <div class="col-lg-6">
                            <input id="desired_position" name="desired_position" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="comment">Коментар</label>
                        <div class="col-lg-6">
                            <textarea type="input" id="comment" name="comment" class="form-control"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 ml-4 col-form-label" for="applicant_photo">Завантажити фото</label>
                        <div class="row col-md-6 mb-12">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="applicant_photo" id="applicant_photo"
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
                                    <input type="file" class="custom-file-input" name="applicant_file" id="applicant_file"
                                           onchange="updateFileName(updateFileName(this, 'fileNameLabel2'))">
                                    <label class="custom-file-label" for="customFile" id="fileNameLabel2">Вибрати
                                        файл</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="w-100">
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

