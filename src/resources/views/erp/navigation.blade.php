@php
    $newEmails = App\Models\Email::where('read', false)->latest()->get();
    $emailsCount = $newEmails->count();
    $newMessages = App\Models\Message::where('recipient_user_id', auth()->user()->id)->where('read', false)->latest()->get();
    $newMessagesCount = $newMessages->count();
    $newTasks = App\Models\UserTask::where('task_to_user_id', auth()->user()->id)->where('status', 'Нове')->orWhere('status', 'У роботі')->get();
    $tasksCount = $newTasks->count();
@endphp




{{--@if(Auth::user()->is_executive)--}}
{{--    <script>--}}
{{--        let updateNotifications = "{{ route('erp.executive.messages.updateNotifications') }}";--}}
{{--    </script>--}}
{{--@elseif(Auth::user()->is_manager)--}}
{{--    <script>--}}
{{--        let updateNotifications = "{{ route('erp.manager.messages.updateNotifications') }}";--}}
{{--    </script>--}}
{{--@elseif(Auth::user()->is_logist)--}}
{{--    <script>--}}
{{--        let updateNotifications = "{{ route('erp.logist.messages.updateNotifications') }}";--}}
{{--    </script>--}}
{{--@elseif(Auth::user()->is_accountant)--}}
{{--    <script>--}}
{{--        let updateNotifications = "{{ route('erp.accountant.messages.updateNotifications') }}";--}}
{{--    </script>--}}
{{--@elseif(Auth::user()->is_hr)--}}
{{--    <script>--}}
{{--        let updateNotifications = "{{ route('erp.hr.messages.updateNotifications') }}";--}}
{{--    </script>--}}
{{--@elseif(Auth::user()->is_admin)--}}
{{--    <script>--}}
{{--        let updateNotifications = "{{ route('erp.admin.messages.updateNotifications') }}";--}}
{{--    </script>--}}
{{--@endif--}}


{{--<script>--}}
{{--    setInterval(function () {--}}
{{--        $.ajax({--}}
{{--            url: '/update-notifications',--}}
{{--            method: 'GET',--}}
{{--            success: function (data) {--}}
{{--                $('#emailsCount').text(data.emailsCount);--}}
{{--                $('#newMessagesCount').text(data.newMessagesCount);--}}
{{--                $('#tasksCount').text(data.newMessagesCount);--}}

{{--                $('.dropdown-notfication .dropdown-content-body').html(data.newMessagesView);--}}
{{--                $('.dropdown-notfication .dropdown-content-body').html(data.newEmailsView);--}}
{{--                $('.dropdown-notfication .dropdown-content-body').html(data.newTasksView);--}}

{{--                if (data.newMessagesCount > 0) {--}}
{{--                    $('#newMessagesCount').show();--}}
{{--                } else {--}}
{{--                    $('#newMessagesCount').hide();--}}
{{--                }--}}

{{--                if (data.emailsCount > 0) {--}}
{{--                    $('#emailsCount').show();--}}
{{--                } else {--}}
{{--                    $('#emailsCount').hide();--}}
{{--                }--}}

{{--                if (data.tasksCount > 0) {--}}
{{--                    $('#tasksCount').show();--}}
{{--                } else {--}}
{{--                    $('#tasksCount').hide();--}}
{{--                }--}}

{{--            },--}}
{{--            error: function () {--}}
{{--                console.error('Ошибка при обновлении данных');--}}
{{--            }--}}
{{--        });--}}
{{--    }, 60000);--}}

{{--</script>--}}


<div class="nav-control" >
    <div class="hamburger">
        <span class="toggle-icon"><i class="icon-menu"></i></span>
    </div>
</div>
<div class="header-left">
    <div class="input-group icons">


        <div class="drop-down animated flipInX d-md-none">

        </div>
    </div>
</div>
<div class="header-right">
    <ul class="clearfix">
        @if(!auth()->user()->is_admin)
        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                <i class="icon-check" style="font-size: 35px;"></i>
                <span class="badge badge-pill gradient-1" id="tasksCount">{{ $tasksCount }}</span>
            </a>
            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                <div id="dropdown-tasks" class="dropdown-content-body">
                    @include('erp.parts.tasks.dropdown_tasks')
                </div>
            </div>
        </li>
        @endif

        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                <i class="mdi mdi-email-outline" style="font-size: 35px;"></i>
                <span class="badge badge-pill gradient-1" id="emailsCount">{{ $emailsCount }}</span>
            </a>
            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                <div id="dropdown-emails" class="dropdown-content-body">
                    @include('erp.parts.emails.dropdown_emails')
                </div>
            </div>
        </li>

        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                <i class="icon-speech" style="font-size: 35px;"></i>
                <span class="badge badge-pill gradient-2" id="newMessagesCount">{{ $newMessagesCount }}</span>
            </a>
            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                <div id="dropdown-messages" class="dropdown-content-body">
                    @include('erp.parts.messages.dropdown_messages')
                </div>
            </div>
        </li>


        <li class="icons dropdown" style="z-index: 9999;">
            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                <span class="activity active"></span>
                <img src="{{ asset(Auth::user()->photo_path) }}" height="40" width="40" alt="">
            </div>
            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu" style="z-index: 9999;">
                <div class="dropdown-content-body">
                    <ul>
                        <li>
                            <a href="{{ route('profile.edit') }}"><i class="icon-user"></i> <span>Профiль</span></a>
                        </li>

                        <hr class="my-2">
                        <li>
                            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="document.getElementById('logoutForm').submit();">
                                    <i class="icon-key"></i> <span>Вихiд</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>

<!--**********************************
    Header end ti-comment-alt
***********************************-->
