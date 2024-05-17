


    $(document).ready(function() {
        console.log("jQuery is ready!");
    
        $('#client').change(function() {
            console.log("Client value changed!");
    
            var selectedClientId = $(this).val();
           
            $.ajax({
                url: '/getClientContactInfo',
                type: 'GET',
                data: { clientId: selectedClientId },
                success: function(response) {
                    console.log("AJAX request successful!");
                    console.log(response);
    
                    $('#fullname').val(response.fullname);
                    $('#phone').val(response.phone);
                    $('#email').val(response.email);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed!");
                    console.error(xhr, status, error);
                }
            });
        });
    });

