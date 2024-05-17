/* global $, window, privateUserId, privateChatId, clearInterval */

$(document).ready(function () {
    var intervalId = window.setInterval(function () {
        var currentUrl = window.location.href;

        var url = '/update-chats-data';

        if (currentUrl.includes('showPrivatChat')) {
            url = '/update-chats-data?id=' + privateUserId;
        }
        if (currentUrl.includes('showChat')) {
            url = '/update-chats-data?id=' + privateChatId;
        }

        $.ajax({

            url: url,
            method: 'GET',
            success: function (data) {
                // Update UI with received data
                $('#emailsCount').text(data.emailsCount);
                $('#newMessagesCount').text(data.newMessagesCount);
                $('#tasksCount').text(data.tasksCount);

                $('#dropdown-messages').html(data.newMessagesView);
                $('#dropdown-emails').html(data.newEmailsView);
                $('#dropdown-tasks').html(data.newTasksView);

                $('#render-messages').html(data.renderMessagesView);
                $('#render-all-messages').html(data.renderAllMessagesView);
                $('#render-messages-chats').html(data.renderCountsView);
                $('#render-chat-messages').html(data.renderChatMessagesView);


                ['newMessagesCount', 'emailsCount', 'tasksCount'].forEach(function (id) {
                    if (data[id] > 0) {
                        $('#' + id).show();
                    } else {
                        $('#' + id).hide();
                    }
                });
            },
            error: function () {
                console.error('Ошибка при обновлении данных');
            }
        });
    }, 5000);

    $(document).on('click', '.btn-edit', function () {
        clearInterval(intervalId);
        intervalId = null;
    });
});
