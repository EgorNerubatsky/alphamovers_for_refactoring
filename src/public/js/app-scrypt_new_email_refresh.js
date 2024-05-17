setInterval(function () {
    // Выполните AJAX-запрос для получения новых данных
    $.ajax({
        url: updateEmailStatus,
        method: 'GET',
        success: function (data) {
            // Обновите значения на вашей странице
            $('#countMail').text(data.countMail);
            // $('#newMessagesCount').text(data.newMessagesCount);
        },
        error: function () {
            console.error('Ошибка при обновлении данных');
        }
    });
}, 60000); 




// $(document).ready(function() {
//     // Получение CSRF-токена
//     console.log('Document is ready');

//     var csrfToken = $('meta[name="csrf-token"]').attr('content');

//     // Функция для обновления почты
//     function updateEmails() {
//         console.log('Updating emails...');

//         $.ajax({
//             url: getMailsRoute,
//             type: 'GET',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             success: function(_response) {
//                 // Обработка успешного обновления
//                 console.log('Почта успешно обновлена');
//             },
//             error: function(xhr, status, error) {
//                 console.error('Ошибка при обновлении почты', xhr.responseText);
//                 console.error('Status:', status);
//                 console.error('Error:', error);
//             }
//         });
//     }

//     // Запускаем обновление каждые 5 минут
//     setInterval(function() {
//         updateEmails();
//     }, 60000); // 300000 миллисекунд = 5 минут
// });
