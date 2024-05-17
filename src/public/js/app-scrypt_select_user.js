$(document).ready(function($) {
    $('.js-select2').select2({
        placeholder: 'Выберите сотрудника',
        ajax: {
            url: searchUsersRoute,
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        templateResult: formatUserResult,
        templateSelection: formatUserSelection
    });

    $('.js-select2').on('select2:select', function (e) {
        var userId = e.params.data.id;
        $('#recipient_user_id').val(userId);
    });
});

// Добавлена функция templateResult
function formatUserResult(user) {
    if (user.loading) {
        return user.text;
    }

    var markup = (user.name || '') + ' ' + (user.lastname || '');
    return markup;
}

// Добавлена функция templateSelection
function formatUserSelection(user) {
    return user.id ? user.name + ' ' + user.lastname : 'Выберите сотрудника';
}
















//
//
//
// $(document).ready(function() {
//     function formatUser(user) {
//         if (!user.id) {
//             return user.text;
//         }
//
//         return $('<span>' + user.name + ' ' + user.lastname + '</span>');
//     }
//
//     $(".js-select2").select2({
//         ajax: {
//             url: '/search-users',
//             dataType: 'json',
//             delay: 250,
//             data: function(params) {
//                 return {
//                     q: params.term
//                 };
//             },
//             processResults: function(data) {
//                 return {
//                     results: data.results.map(function(user) {
//                         return {
//                             id: user.id,
//                             text: user.name + ' ' + user.lastname
//                         };
//                     })
//                 };
//             },
//             cache: true
//         },
//         placeholder: 'Выберите сотрудника',
//         escapeMarkup: function(markup) {
//             return markup;
//         },
//         minimumInputLength: 1,
//         templateResult: formatUser,
//         templateSelection: function(user) {
//             return user.name + ' ' + user.lastname; // Отображаем выбранного пользователя
//         }
//     }).on('select2:select', function (e) {
//         // При выборе элемента устанавливаем значение recipient_user_id
//         $('#recipient_user_id').val(e.params.data.id);
//     });
// });



