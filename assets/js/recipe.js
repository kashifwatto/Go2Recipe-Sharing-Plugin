jQuery(document).ready(function ($) {

    // document.getElementById('saveasdraft').addEventListener('click', function (e) {
    //     e.preventDefault();
    //     alert();
    //     document.getElementById('post_status').value = 'draft';
    //     document.getElementById('add_recipe').submit(); // manually submit form
    // });
    $('#add_recipe').on('submit', function (e) {
        // alert();
        e.preventDefault();
        let addrecipeData = new FormData(this);
        addrecipeData.append('action', 'recipe_sharing_by_kashif_watto_add_recipe');
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: addrecipeData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added Successful!',
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
    });
    $('#edit_recipe').on('submit', function (e) {
        e.preventDefault();
        let editrecipeData = new FormData(this);
        editrecipeData.append('action', 'recipe_sharing_by_kashif_watto_edit_recipe');
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: editrecipeData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated Successful!',
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
    });


    // review form

    $('#recipe-review-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('action', 'recipe_sharing_by_kashif_watto_submit_review');

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        text: response.data.message,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
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
    });

});

