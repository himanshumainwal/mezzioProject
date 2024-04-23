$(document).ready(function() {
    $("#loginBtn").click(function() {
        // Get form data
        var formData = $("#loginForm").serialize();

        // Send AJAX request
        $.ajax({
            url: "/login",
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