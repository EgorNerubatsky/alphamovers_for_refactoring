// $(document).ready(function () {
//     // User selection logic for the first form ("messageForm")
//     $('#messageForm .dropdown-item').on('click', function() {
//         var userId = $(this).data('value');
//         $('#recipient_user_id').val(userId);
//         $('#messageForm .btn-secondary').html($(this).html());
//     });

//     // Submit event handler for the first form ("messageForm")
//     $('#messageForm').submit(function () {
//         var recipientUserId = $('#recipient_user_id').val();

//         if (!recipientUserId) {
//             alert('Please select a user.');
//             return false; // Prevent form submission
//         }

//         // Continue with form submission if a user is selected
//     });

//     // Exclude user selection logic and alert for the second form ("messageForm2")
//     $('#messageForm2').submit(function () {
//         // Continue with form submission for the second form
//     });
// });
