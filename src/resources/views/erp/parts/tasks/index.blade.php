@extends('erp.content')

@section('title')
    <h2>Завдання</h2>
@endsection

@section('content')

    <style>

        .card-header {
            border-top-left-radius: 10px; /* Adjust the value for the desired roundness */
            border-top-right-radius: 10px; /* Adjust the value for the desired roundness */
        }

        .external-event {
            min-width: 200px; /* Set your desired fixed width */
            max-width: 500px; /* Set your desired fixed width */

            /*position: relative;*/
            z-index: 1000; /* or any value higher than the z-index of your Kanban columns */
            border-radius: 10px; /* Adjust the value for the desired roundness */
            cursor: move; /* Set cursor to indicate draggability */
            padding: 10px; /* Add padding for better visibility and interaction */
        }
    </style>


    <script>
        let routeUrl = "{{ route($roleData['roleData']['tasks_remove']) }}";
    </script>


    <script>
        let tasksIndexUrl = "{{ route($roleData['roleData']['tasks_index']) }}";
    </script>


    <script>
        let updateTaskColumn = "{{ route($roleData['roleData']['tasks_update_task_column']) }}";
    </script>



    <script src="{{ asset('js/app-scrypt.js') }}"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timelineYear,dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                views: {
                    timelineYear: {
                        type: 'dayGridYear',
                        duration: {years: 1}
                    }
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                customButtons: {
                    prevYear: {
                        text: '<<',
                        click: function () {
                            calendar.prev(2, 'year'); // Переключаемся на два предыдущих года
                        }
                    },
                    nextYear: {
                        text: '>>',
                        click: function () {
                            calendar.next(2, 'year'); // Переключаемся на два последующих года
                        }
                    }
                },
                datesSet: function (info) {
                    if (info.view.type === 'dayGridMonth') {
                        calendar.setOption('title', info.view.title);
                    }
                },
                locale: 'ru',
                events: JSON.parse('{!! $events !!}'),
                editable: true,
                eventBackgroundColor: 'green',

                eventDrop: function (info) {
                    let eventData = {
                        id: info.event.id,
                        start: info.event.start.toISOString(),
                        end: info.event.end ? info.event.end.toISOString().slice(0, 16) : '' // Изменили формат даты
                    };
                    console.log(eventData);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", routeUrl, true);
                    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                    xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                console.log('Task date updated successfully!');
                                console.log(eventData);
                            } else {
                                console.error('Failed to update task date!');
                            }
                        }
                    };

                    xhr.send(JSON.stringify(eventData));
                    window.location.href = tasksIndexUrl;
                },
                eventClick: function (info) {

                    let eventDatar = {
                        id: info.event.id,
                        title: info.event.title,
                        company: info.event.extendedProps.company,
                        status: info.event.extendedProps.status,
                        start: info.event.start.toISOString().slice(0, 16), // Изменили формат даты
                        end: info.event.end ? info.event.end.toISOString().slice(0, 16) : '' // Изменили формат даты
                    };

                    let modal = document.getElementById('modalEdit');

                    let closeModal = document.getElementsByClassName('close')[0];
                    let eventForm = document.getElementById('eventForm');
                    let eventIdInput = document.getElementById('eventId');
                    let eventTitleInput = document.getElementById('eventTitle');
                    let eventCompanyInput = document.getElementById('company');
                    let eventStatusInput = document.getElementById('status');
                    let eventStartInput = document.getElementById('eventStart');
                    let eventEndInput = document.getElementById('eventEnd');

                    console.log(eventDatar);

                    eventIdInput.value = eventDatar.id;
                    eventTitleInput.value = eventDatar.title;
                    eventCompanyInput.textContent = eventDatar.company;
                    eventStatusInput.value = eventDatar.status;
                    eventStartInput.value = eventDatar.start;
                    eventEndInput.value = eventDatar.end;

                    modal.style.display = 'block';
                    modal.style.opacity = 1;
                    modal.style.pointerEvents = "auto";

                    closeModal.addEventListener('click', function () {
                        modal.style.opacity = 0;
                        modal.style.pointerEvents = "none";
                        setTimeout(function () {
                            modal.style.display = 'none';
                        }, 300);

                    });

                    window.addEventListener('click', function (event) {
                        if (event.target === modal) {
                            modal.style.display = 'none';
                        }
                    });

                    eventForm.addEventListener('submit', function (event) {
                        event.preventDefault();
                        let form = this;
                        let formData = new FormData(form);

                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', form.action, true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    console.log('Event updated successfully!');
                                    info.event.setProp('task', formData.get('task')); // Обновляем заголовок задачи
                                    // info.event.setExtendedProp('company', formData.get('company')); // Обновляем компанию задачи
                                    // info.event.setExtendedProp('status', formData.get('status')); // Обновляем статус задачи
                                    info.event.setStart(formData.get('start_task')); // Обновляем время начала задачи
                                    info.event.setEnd(formData.get('end_task')); // Обновляем время окончания задачи

                                    // После обновления закрываем модальное окно
                                    // closeModal.click();

                                } else {
                                    console.error('Failed to update event!');
                                }

                            }
                        };

                        xhr.send(formData);

                        modal.style.display = 'none';
                        form.reset();

                        // window.location.href = tasksIndexUrl;
                        window.location.reload();
                    });
                }
            });

            let moveToWorkButton = document.getElementById('moveToWorkButton');
            moveToWorkButton.addEventListener('click', function () {
                let modalEdit = document.getElementById('eventId').value;
                document.getElementById('status').value = "У роботі";
                let form = document.getElementById('eventForm');
                let formData = new FormData(form);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log('Event updated successfully!');
                            let modal = document.getElementById('modalEdit');
                            modal.style.opacity = "0";
                            modal.style.pointerEvents = "none";
                            setTimeout(function () {
                                modal.style.display = 'none';
                            }, 300);
                        } else {
                            console.error('Failed to update event!');
                        }
                    }
                };

                xhr.send(formData);
                window.location.href = tasksIndexUrl;
            });

            let markAsDoneButton = document.getElementById('markAsDoneButton');
            markAsDoneButton.addEventListener('click', function () {
                document.getElementById('status').value = "Виконано";
                let form = document.getElementById('eventForm');
                let formData = new FormData(form);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log('Event updated successfully!');
                            let modal = document.getElementById('modalEdit');
                            modal.style.opacity = 0;
                            modal.style.pointerEvents = "none";
                            setTimeout(function () {
                                modal.style.display = 'none';
                            }, 300);
                        } else {
                            console.error('Failed to update event!');
                        }
                    }
                };

                xhr.send(formData);
                window.location.href = tasksIndexUrl;
            });
            // window.location.reload(); // Перезагрузка страницы

            calendar.render();
        });

    </script>



    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h2>Канбан</h2>
        </div>
        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
            <button id="openModalBtn2" type="button" class="btn mb-1 btn-outline-dark mb-3" data-toggle="modal"
                    data-target="#myKanbanModal">Новий канбан
            </button>
        </div>
    </div>


    @include('erp.parts.tasks.create_kanban_modal')
    @include('erp.parts.tasks.edit_task_modal')
    @include('erp.parts.tasks.create_task_modal')

    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    @foreach($kanbans as $kanban)
                        <div class="col">

                            <div class="card card-row card-{{$kanban->title_color}} kanban-column"
                                 id="column{{$kanban->id}}"
                                 style="max-width: 300px;">
                                <div class="card-header rounded-top rounded-right rounded-bottom rounded-left">
                                    <div class="d-flex justify-content-between align-items-center"
                                         style="min-width:200px;">

                                        <h3 class="card-title text-white" style="text-align: center;">
                                            {{$kanban->kanban_title}}
                                        </h3>

                                        <div>

                                            <a href="#" data-toggle="modal"
                                               data-target="#myKanbanTaskModal{{$kanban->id}}"
                                               title="Додати завдання">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                            <a href="#" class="ml-2" data-toggle="modal"
                                               data-target="#kanbanEditModal{{$kanban->id}}" title="Редагувати">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="ml-2" data-toggle="modal"
                                               data-target="#confirmationModal"
                                               data-delete-url="{{ route($roleData['roleData']['tasks_delete_kanban'], ['id'=>$kanban->getKey()]) }}"
                                               title="Видалити">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @include('erp.parts.tasks.edit_kanban_modal')

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
                                                        <div class="modal-body text-dark">
                                                            Ви впевнені, що бажаєте видалити?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Вiдмiна
                                                            </button>
                                                            <a id="deleteLink" href="#"
                                                               class="btn btn-danger">Видалити</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('erp.parts.tasks.create_kanban_task_modal', ['kanban'=>$kanban])

                                    </div>
                                </div>

                                <div class="card3">

                                    @foreach($kanban->kanbanTasks as $kanbanTask)
                                        <div
                                            class="d-flex justify-content-between align-items-center external-event bg-{{$kanbanTask->task_color}} text-white kanban-task ml-1 mr-2"
                                            data-task-id="{{$kanbanTask->id}}" data-class="bg-primary"><i
                                                class="fa fa-move"></i>{{$kanbanTask->task}}

                                            <div class="toppanel" style="min-width: 50px;">

                                                <a href="#" data-toggle="modal"
                                                   data-target="#kanbanTaskEditModal{{$kanbanTask->id}}"
                                                   title="Редагувати">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="ml-2" data-toggle="modal"
                                                   data-target="#confirmationModal"
                                                   data-delete-url="{{ route($roleData['roleData']['tasks_delete_kanban_task'], ['id'=>$kanbanTask->getKey()]) }}"
                                                   title="Видалити">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                @include('erp.parts.tasks.edit_kanban_task_modal')
                                            </div>

                                        </div>
                                        <script>
                                            $('#kanbanTask{{$kanbanTask->id}}').dblclick(function () {
                                                $('#editTask{{$kanbanTask->id}}').click();
                                            });
                                        </script>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>





    <div class="form-row mb-3 mt-3">
        <div class="col-md-4">
            <h3 class="card-title">@yield('title')</h3>
        </div>

        <div class="col-md-4 ml-md-auto mt-1 mt-md-0 text-md-right">
            <button id="openModalBtn3" type="button" class="btn mb-1 btn-outline-dark mb-3" data-toggle="modal"
                    data-target="#myTaskModal">Додати завдання
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-4">
                    <button type="button" data-toggle="collapse" href="#searchForm" aria-expanded="false"
                            aria-controls="searchForm" class="btn mb-1 btn-outline-dark" style="width: 200px;">
                        Розширений пошук
                    </button>
                </div>
                <div class="col-md-6  ml-auto">
                    <form action="{{ route($roleData['roleData']['tasks_search']) }}" method="GET">
                        <div class="input-group">
                            <label for="search" style="display: none"></label>
                            <input type="text" id="search" name="search" class="form-control rounded"
                                   value="{{ Request::get('search') }}" style="height: 40px;">
                            <div class="append">
                                <button class="btn btn-outline-dark rounded-1" type="submit" style="height: 40px;">
                                    Пошук
                                </button>
                                <a href="{{ route($roleData['roleData']['tasks_index']) }}" class="btn btn-outline-info"
                                   style="height: 40px;">Скинути</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="basic-form">
                <div id="searchForm" class="collapse">
                    <br>
                    <form action="{{ route($roleData['roleData']['tasks_index']) }}" method="GET">

                        <div class="form-row">

                            <div class="form-group col-md-3">
                                <label for="selectStatus">Статус</label>
                                <select id="selectStatus" name="selectStatus" class="form-control">
                                    <option value="">Всі</option>
                                    @foreach($tasksStatuses as $tasksStatuse)
                                        <option value="{{ $tasksStatuse }}"
                                                name="{{ $tasksStatuse }}">{{ $tasksStatuse }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Показати</button>
                            <a href="{{ route($roleData['roleData']['tasks_index']) }}" class="btn btn-secondary">Скинути</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead style="background-color: #AFEEEE">
                                <tr>
                                    <th style="width: 200px; text-align: center; vertical-align: middle;">
                                        На сьогоднi
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(json_decode($todayEvents, true) as $todayEvent)
                                    <tr>
                                        <td class="event-info">
                                            <i class="far fa-calendar-alt"></i>
                                            <span
                                                class="event-time text-bold">{{ date('H:i', strtotime($todayEvent['start'])) }}</span>
                                            <span class="badge badge-success">
                                            <span class="event-title">{{ $todayEvent['title'] }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <link href="{{ asset('assets/fullcalendar/css/style.css') }}" rel='stylesheet'/>

@endsection
