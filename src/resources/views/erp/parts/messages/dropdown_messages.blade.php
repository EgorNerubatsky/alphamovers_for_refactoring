<ul style="max-height: 250px; overflow-y: auto">
    @if(isset($newMessages) && count($newMessages) > 0)
        @foreach($newMessages as $newMessage)
            <li>
{{--                <a href="{{ route($roleData['roleData']['messages_index']) }}">--}}
                <a href="{{ route($roleData['roleData']['messages_show_private_chat'], ['id'=>$newMessage->user->id]) }}">
                    <span class="avatar-icon"><img src="{{ asset($newMessage->user->photo_path) }}" height="40"
                                                   width="40" class="rounded-circle" alt=""></span>
                    <div class="notification-content">
                        <h6 class="notification-heading">{{$newMessage->user->name}} {{$newMessage->user->lastname}}</h6>
                        <span
                            class="notification-text">{{ strlen(strip_tags($newMessage->message)) > 35 ? substr(strip_tags($newMessage->message), 0, 40) . '...' : strip_tags($newMessage->message) }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    @else
        <li>Нема повiдомлень</li>
    @endif
</ul>
