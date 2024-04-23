$(document).ready(function() {
    $("#addUserBtn").click(function() {
        // Get form data
        var formData = $("#userForm").serialize();

        // Send AJAX request
        $.ajax({
            url: "/register",
            type: "POST",
            data: formData,
            success: function(response) {
                // Handle response
                alert(response); // Show response
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    });
});