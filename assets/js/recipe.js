jQuery(document).ready(function ($) {


    $('#post_status').change(function () {
        const status = $(this).val();
        const buttonText = status === 'publish' ? 'Publish Recipe' : 'Save as Draft';
        $('#submitbutton').text(buttonText);
    });
    $('#post_status').trigger('change');
    $('#add_recipe').on('submit', function (e) {
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
                    const status = $('#post_status').val();
                    const successMessage = status === 'publish'
                        ? 'Recipe published successfully!'
                        : 'Recipe saved as draft!';

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: successMessage,
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


    // $('#add_recipe').on('submit', function (e) {
    //     e.preventDefault();
    //     let addrecipeData = new FormData(this);
    //     addrecipeData.append('action', 'recipe_sharing_by_kashif_watto_add_recipe');
    //     $.ajax({
    //         url: ajax_object.ajax_url,
    //         type: 'POST',
    //         data: addrecipeData,
    //         processData: false,
    //         contentType: false,
    //         success: function (response) {
    //             if (response.success) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Added Successful!',
    //                     text: response.data.message,
    //                     timer: 2000,
    //                     showConfirmButton: false,
    //                 }).then(() => {
    //                     window.location.href = response.data.redirect_url;
    //                 });
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: response.data.message || 'An error occurred.',
    //                 });
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error('AJAX Error:', status, error);
    //             console.error('Response:', xhr.responseText);
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Unexpected Error',
    //                 text: 'An unexpected error occurred. Please try again.',
    //             });
    //         },
    //     });
    // });
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
    // assing reciepe to another

    $('#assign-recipe-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        console.log(formData);
        formData.append('action', 'recipe_sharing_by_kashif_watto_assign_recipe_to_new_user');
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to assign this recipe to another user.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, assign it!'
        }).then((result) => {
            if (result.isConfirmed) {

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
                                title: 'Recipe Assigned!',
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
            }
        });

    });

});

