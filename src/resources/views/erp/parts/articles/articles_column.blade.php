@php
    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
@endphp

<div class="col-lg-4 col-xl-3">
    <div class="card">
        <div class="card-body">
            <div class="card-content">
                <h5 class="mb-3">Обранi cтаттi</h5>

                @foreach($favorites as $favorite)
                    @php
                        $randomColor = $colors[array_rand($colors)];
                    @endphp

                    @if(isset($favorite))
                        <a href="{{ route($roleData['roleData']['articles_show_article'], ['id'=>$favorite->id]) }}"
                           class="alert-link">
                            <div class="alert alert-{{ $randomColor }}"><i class="icon-book-open menu-icon mr-2"
                                                                           style="font-size: 25px;"></i>{{$favorite->article->title}}
                            </div>
                        </a>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-content">
                <h5 class="mb-3">Статтi</h5>

                @foreach($articles as $article)
                    @php
                        $randomColor = $colors[array_rand($colors)];
                    @endphp
                    @if(isset($article) && !$article->deleted_at)
                        <a href="{{ route($roleData['roleData']['articles_show_article'], ['id'=>$article->id]) }}"
                           class="alert-link">
                            <div class="alert alert-{{ $randomColor }}"><i class="icon-book-open menu-icon mr-2"
                                                                           style="font-size: 25px;"></i>{{$article->title}}
                            </div>
                        </a>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
