$(".kanban-task").draggable({
revert: "invalid",
helper: "clone",
});

$(".kanban-column").droppable({
    accept: ".kanban-task",
    drop: function (event, ui) {
        var task_id = ui.helper.data("task-id");
        var new_kanban_id = $(this).attr("id").replace("column", "");

        // Make an AJAX call to update task's kanban_id
        $.ajax({
            url: updateTaskColumn,
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                task_id: task_id,
                kanban_id: new_kanban_id,
            },
            success: function (response) {
                console.log(response);
                // Reload the page after a successful drop
                location.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    },
});

