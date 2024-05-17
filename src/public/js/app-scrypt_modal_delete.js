$(document).ready(function () {
    // Handle the delete link click
    $('#confirmationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var deleteUrl = button.data('delete-url'); // Get the delete URL from data attribute
        $('#deleteLink').attr('href', deleteUrl); // Set the href of the Delete button


        // Handle the Delete button click
        $('#deleteLink').on('click', function () {
            $('#confirmationModal').modal('hide'); // Close the modal

            // Redirect to the delete URL
        });
    });
});


$('.dropdown-item').on('click', function() {
    var userId = $(this).data('value');
    $('#recipient_user_id').val(userId);
    $('.btn-secondary').html($(this).html());
});

