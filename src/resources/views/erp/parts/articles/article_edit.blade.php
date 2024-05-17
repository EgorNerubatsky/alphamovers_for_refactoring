@extends('erp.content')

@section('title')
    <h2>База знань</h2>
@endsection
@section('content')

    <div class="form-row mb-3 mt-3 ml-4">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>

    </div>
    <div class="container-fluid">
        <div class="row">
            @include('erp.parts.articles.articles_column')

            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">


                        <div class="basic-form">

                            {{ Form::model($currentArticle, ['route' => [$roleData['roleData']['articles_update_article'], $currentArticle->getKey()], 'method' => 'put', 'enctype' => "multipart/form-data"]) }}
                            @method('PUT')
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label
                                        for="title">Заголовок</label>
                                    <input class="form-control"
                                           name="title" id="title"
                                           placeholder="Заголовок"

                                           value="{{ $currentArticle->title }}" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="content">Контент</label>
                                    <textarea class="form-control summernote" name="content" id="content"
                                              required>{{ $currentArticle->content }}</textarea>
                                </div>
                                @if(isset($currentArticle->attachment_path))
                                    @php
                                        $fileExtension = pathinfo($currentArticle->attachment_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpeg', 'jpg', 'png', 'gif']);
                                        $isDocument = in_array(strtolower($fileExtension), ['doc', 'docx', 'pdf', 'pptx', 'ppt']);
                                    @endphp
                                    @if($isImage)
                                        <a href="#" data-toggle="modal" data-target="#previewModal{{$message->id}}">
                                            <img src="{{asset($currentArticle->attachment_path)}}"
                                                 alt="Screenshot Preview" style="max-width: 200px; height: auto;">
                                        </a>

                                        <div class="modal fade" id="previewModal{{$currentArticle->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewModalLabel">Просмотр</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <img src="{{ asset($currentArticle->attachment_path) }}"
                                                             alt="Screenshot Preview" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($isDocument)
                                        @php
                                            $pathInfo = pathinfo($currentArticle->attachment_path);
                                            $filename = $pathInfo['filename'];
                                        @endphp
                                        <div class="mailbox-attachments d-flex align-items-stretch clearfix">
                                            <div class="mailbox-attachment-info">
                                                <a href="{{ asset($currentArticle->attachment_path) }}" target="_blank"
                                                   class="btn btn-default btn-sm float-right"><span
                                                        class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>{{ $filename }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <a href="#" data-toggle="modal" class="btn btn-danger btn-sm mb-2 rounded"
                                       data-target="#confirmationModal"
                                       data-delete-url="{{ route('erp.executive.articles.deleteFile', ['id'=>$currentArticle->id]) }}"
                                       title="Видалити">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                         aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                                                        Пiдтвердження</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Ви впевнені, що бажаєте видалити?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                        Вiдмiна
                                                    </button>
                                                    <a id="deleteLink" href="#" class="btn btn-danger">Видалити</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div
                                        class="btn btn-default btn-file mt-4">
                                        <i class="fas fa-paperclip"></i>
                                        Додати файл
                                        <input type="file"
                                               id="article_file"
                                               name="article_file">
                                    </div>
                                </div>
                                <div
                                    class="form-group col-md-8 text-right mt-4">
                                    <button type="submit"
                                            class="btn btn-success">
                                        Опублікувати
                                    </button>
                                    <a href="{{ route($roleData['roleData']['articles_index']) }}"
                                       class="btn btn-secondary px-3">Скинути</a>
                                </div>
                            </div>
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
