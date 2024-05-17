@php use App\Models\ArticleFavorite; @endphp
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
                        <div class="form-row">
                            <div class="col-md-4">
                                <button type="button" data-toggle="collapse" href="#messageForm" aria-expanded="false"
                                        aria-controls="messageForm" class="btn mb-1 btn-outline-dark"
                                        style="width: 200px;">Нова стаття
                                </button>
                            </div>
                            <div class="col-md-6  ml-auto">
                                <form action="{{ route($roleData['roleData']['articles_search']) }}" method="GET">
                                    <div class="input-group">
                                        <label for="search" style="display: none"></label>
                                        <input type="text" id="search" name="search" class="form-control rounded"
                                               value="{{ Request::get('search') }}" style="height: 40px;">
                                        <div class="append">
                                            <button class="btn btn-outline-dark rounded-1" type="submit" style="height: 40px;">
                                                Пошук
                                            </button>
                                            <a href="{{ route($roleData['roleData']['articles_index']) }}" class="btn btn-outline-info"
                                               style="height: 40px;">Скинути</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="basic-form">
                            <div id="messageForm" class="collapse">
                                <br>
                                <form action="{{ route($roleData['roleData']['articles_store_article']) }}"
                                      method="post"
                                      enctype="multipart/form-data" class="form-profile">
                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label
                                                for="title">Заголовок</label>
                                            <input class="form-control"
                                                   name="title" id="title"
                                                   placeholder="Заголовок"
                                                   required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="content">Контент</label>
                                            <textarea class="form-control summernote" name="content" id="content"
                                                      required></textarea>
                                        </div>

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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        @if(isset($currentArticle))
                            <h4 class="mb-5">{{ $currentArticle->title }}</h4>

                            <div class="media media-reply">
                                <img class="mr-3 circle-rounded" src="{{asset($currentArticle->user->photo_path)}}"
                                     width="50" height="50" alt="Generic placeholder image">

                                <div class="media-body bg-light">

                                    <div class="d-sm-flex justify-content-between mb-2">
                                        <h5 class="mb-sm-0">
                                            <small
                                                class="text-muted ml-3">{{ $currentArticle->user->name }} {{ $currentArticle->user->lastname }}
                                                , {{$currentArticle->created_at->format('d.m.Y')}} {{$currentArticle->created_at->format('H:i')}}</small>
                                        </h5>
                                        <div class="media-reply__link">
                                            @php
                                                $isFavorite = ArticleFavorite::where('article_id', $currentArticle->id)->where('user_id',auth()->user()->id)->exists();

                                            @endphp

                                            <form
                                                action="{{ route($roleData['roleData']['articles_add_to_favorites'], ['id' => $currentArticle->id]) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-transparent p-0 mr-3"
                                                        data-toggle="tooltip" title="До обраного">
                                                    <i class="icon-star{{ $isFavorite ? ' text-danger' : '' }}"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route($roleData['roleData']['articles_edit'], ['id'=>$currentArticle->id]) }}"
                                               class="btn btn-transparent p-0 mr-3" data-toggle="tooltip"
                                               title="Редагувати"><i class="icon-note"></i></a>
                                            <a href="{{ route($roleData['roleData']['articles_delete'], ['id'=>$currentArticle->id]) }}"
                                               class="btn btn-transparent p-0 mr-3" data-toggle="tooltip"
                                               title="Видалити"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                    </div>

                                    <p>{!! $currentArticle->content !!}</p>
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

                                            <div class="modal fade" id="previewModal{{$currentArticle->id}}"
                                                 tabindex="-1"
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
                                                    <a href="{{ asset($currentArticle->attachment_path) }}"
                                                       target="_blank"
                                                       class="btn btn-default btn-sm float-right"><span
                                                            class="mailbox-attachment-icon"><i
                                                                class="far fa-file-word"></i></span>{{ $filename }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
