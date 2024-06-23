jQuery(document).ready(function($) {
    $('#pledgeForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);
        formData.append('action', 'custom_pw_add_pledge');
        formData.append('security', customPw.security);

        $.ajax({
            url: customPw.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    console.log('Pledge added successfully:', response);
                    // Optionally, you can reset the form after successful submission
                    $('#pledgeForm')[0].reset();
                    // Display a success message or perform other actions
                    alert('Pledge added successfully!');
                } else {
                    console.error('Failed to add pledge:', response);
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error occurred while adding pledge. Please try again later.');
            }
        });
    });
});