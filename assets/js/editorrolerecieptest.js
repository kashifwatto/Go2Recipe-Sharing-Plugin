

jQuery(document).ready(function ($) {


    const approveBtn = document.getElementById('approvebutton');
    const postId = approveBtn.dataset.postId;
    approveBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to approve this recipe? This will publish on website',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with AJAX
                $.ajax({
                    url: ajax_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'approve_recipe_by_tester',
                        postid: postId,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved Successfuly',
                                text: response.data.message,
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.href = response.data.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.data.message || 'An error occurred.',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.error('Response:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Unexpected Error',
                            text: 'An unexpected error occurred. Please try again.',
                        });
                    },
                });
            }
        });


    });


    $('#reject-recipe-form').on('submit', function (e) {
        e.preventDefault();

        const postId = $('#reject_post_id').val();
        const reason = $('#reject_reason').val();
        console.log(postId);
        console.log(reason);
        
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'reject_recipe_by_tester',
                post_id: postId,
                reason: reason
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Recipe Rejected',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.reload(); // or redirect as needed
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.data.message || 'Something went wrong.',
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Unexpected Error',
                    text: 'An unexpected error occurred. Please try again.',
                });
            }
        });
    });



});


