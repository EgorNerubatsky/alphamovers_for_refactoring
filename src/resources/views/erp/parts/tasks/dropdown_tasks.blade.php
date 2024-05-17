<ul class="task-list" style="max-height: 250px; overflow-y: auto">
    @if(isset($newTasks) && count($newTasks) > 0)
        @if(!auth()->user()->is_admin)
        @foreach($newTasks as $newTask)

            <li>
                <a href="{{ route($roleData['roleData']['tasks_index']) }}">
                    <span class="mr-3 avatar-icon bg-white"><i class="icon-check" style="font-size: 35px;"></i></span>
                    <div class="notification-content">
                        <h6 class="notification-heading">{{ date('d.m.Y', strtotime($newTask->end_task)) }} {{ date('H:i', strtotime($newTask->end_task)) }}</h6>
                        <span class="notification-text">{{ strlen($newTask->task) > 40 ? substr($newTask->task, 0, 60) . '...' : $newTask->task }}</span>
                    </div>
                </a>
            </li>
        @endforeach
            @endif
    @else
        <li>Нема завдань</li>
    @endif
</ul>




