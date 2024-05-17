@php
    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
    use App\Models\ChatsActivity;use App\Models\Message;use App\Models\User;use Illuminate\Support\Facades\Auth;
@endphp
<div class="card" style="min-width: 250px;">
    <div class="card-body">
        <div class="card-content">
            <h5 class="mb-3">Чати</h5>

            <button id="openModalBtn" class="btn mb-1 btn-outline-dark mb-3">Новий Чат</button>
            @include('erp.parts.messages.create_chat_modal')
            @foreach($chats as $chat)
                @php
                    $randomColor = $colors[array_rand($colors)];
//                    $chatCount = Message::where('sender_user_id', $user->id )->where('recipient_user_id', $currentUser->id)->where('read', false)->count();
//                    $chatCount = ChatsActivity::where('chat_', $user->id )->where('recipient_user_id', $currentUser->id)->where('read', false)->count();

                @endphp
                @if(isset($chat) && !$chat->deleted_at)
                    <a href="{{ route($roleData['roleData']['messages_show_chat'], ['id'=>$chat->chat->id]) }}"
                       class="alert-link">
                        <div class="alert alert-secondary">
                            @if($chat->chat->chat_cover)
                                <img src="{{ asset($chat->chat->chat_cover) }}" height="40"
                                     width="40" class="mr-2 rounded-circle" alt="">
                            @else
                                <img src="{{ asset('img/movers_logo_mini.png') }}" height="40"
                                     width="40" class="mr-2 rounded-circle" alt="">
                            @endif
                            {{ $chat->chat->chat_name }}
{{--                            @if($count > 0)--}}
{{--                                <span class="badge badge-pill gradient-1"--}}
{{--                                      style="position: absolute; top: -5px; right: -5px;">{{$chatCount}}</span>--}}
{{--                            @endif--}}
                        </div>
                    </a>
                @endif
            @endforeach
            <div class="card-tools">
                {{ $chats->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="card-content">
            <h5 class="mb-3">Приватнi бесiди</h5>
            @foreach($combinateIds as $userId)
                @php
                    $randomColor = $colors[array_rand($colors)];
                    $user = User::find($userId);
                    $currentUser = Auth::user();
                    $count = Message::where('sender_user_id', $user->id )->where('recipient_user_id', $currentUser->id)->where('read', false)->count();
                @endphp

                <a href="{{ route($roleData['roleData']['messages_show_private_chat'], ['id'=>$userId]) }}"
                   class="alert-link" style="position: relative; display: block;">
                    <div class="alert alert-secondary" style="position: relative; padding-right: 40px;">
                        <img src="{{ asset($user->photo_path) }}" height="40" width="40" class="mr-2 rounded-circle"
                             alt="">
                        {{$user->name}} {{$user->lastname}}
                        @if($count > 0)
                            <span class="badge badge-pill gradient-1"
                                  style="position: absolute; top: -5px; right: -5px;">{{$count}}</span>
                        @endif
                    </div>
                </a>

            @endforeach
        </div>
    </div>
</div>
