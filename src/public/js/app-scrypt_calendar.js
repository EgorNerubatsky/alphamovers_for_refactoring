let routeUrl = "{{ route($roleData['roleData']['tasks_remove']) }}";

let tasksIndexUrl = "{{ route($roleData['roleData']['tasks_index']) }}";

let updateTaskColumn = "{{ route($roleData['roleData']['tasks_update_task_column']) }}";


document.addEventListener('DOMContentLoaded', function() {
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
                duration: { years: 1 }
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
        datesSet: function (info){
            if (info.view.type === 'dayGridMonth'){
                calendar.setOption('title', info.view.title);
            }
        },
        locale: 'ru',
        events: JSON.parse('{!! $events !!}'),
        editable: true,
        eventBackgroundColor: 'green',

        eventDrop: function(info) {
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
            xhr.onreadystatechange = function() {
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
        eventClick: function(info) {

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

            closeModal.addEventListener('click', function() {
                modal.style.opacity = 0;
                modal.style.pointerEvents = "none";
                setTimeout(function(){
                    modal.style.display = 'none';
                }, 300);
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            eventForm.addEventListener('submit', function(event) {
                event.preventDefault();
                let form = this;
                let formData = new FormData(form);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log('Event updated successfully!');
                        } else {
                            console.error('Failed to update event!');
                        }
                    }
                };

                xhr.send(formData);

                modal.style.display = 'none';
                form.reset();

                window.location.href = tasksIndexUrl;
            });
        }
    });

    let moveToWorkButton = document.getElementById('moveToWorkButton');
    moveToWorkButton.addEventListener('click', function() {
        let taskId = document.getElementById('eventId').value;
        document.getElementById('status').value = "У роботі";
        let form = document.getElementById('eventForm');
        let formData = new FormData(form);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Event updated successfully!');
                    let modal = document.getElementById('modalEdit');
                    modal.style.opacity = 0;
                    modal.style.pointerEvents = "none";
                    setTimeout(function() {
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
    markAsDoneButton.addEventListener('click', function() {
        document.getElementById('status').value = "Виконано";
        let form = document.getElementById('eventForm');
        let formData = new FormData(form);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Event updated successfully!');
                    let modal = document.getElementById('modalEdit');
                    modal.style.opacity = 0;
                    modal.style.pointerEvents = "none";
                    setTimeout(function() {
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

    calendar.render();
});
