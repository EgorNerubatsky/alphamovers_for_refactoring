// function selectUser(userId, userName) {
//     document.getElementById('recipient_user_id').value = userId;
//     document.getElementById('addButton').disabled = false;
// }

// function addUser() {
//     var form = document.querySelector('.form-profile');

//     // Listen for the form submission event
//     form.addEventListener('submit', function() {
//         // Disable the button after submission
//         document.getElementById('addButton').disabled = true;
//     });

//     // Submit the form
//     form.submit();
// }


function selectUser(userId, userName) {
    document.getElementById('recipient_user_id').value = userId;
    document.getElementById('addButton').style.display = 'block';

}

$(document).ready(function(){
    $('.modal').on('click', function(e) {
        if(e.target === this) {
            $(this).modal('hide');
        }
    });
});


