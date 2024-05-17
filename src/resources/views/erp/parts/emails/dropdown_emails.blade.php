<ul style="max-height: 250px; overflow-y: auto">

    @if(isset($newEmails) && count($newEmails) > 0)
        @foreach($newEmails as $newEmail)
            <li>
{{--                <a href="{{ route($roleData['roleData']['emails_index']) }}">--}}
                <a href="{{ route($roleData['roleData']['emails_open_email'], ['id' => $newEmail->id]) }}">
                    <span class="mr-3 avatar-icon bg-white"><i class="mdi mdi-email-outline" style="font-size: 35px;"></i></span>
                    <div class="notification-content">
                        <h6 class="notification-heading">{{$newEmail->sender}}</h6>
                        <span
                        class="notification-text">{{ strlen(strip_tags($newEmail->subject)) > 50 ? substr(strip_tags($newEmail->subject), 0, 80) . '...' : strip_tags($newEmail->subject) }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    @else
        <li>Нема нових листів</li>
    @endif
</ul>


