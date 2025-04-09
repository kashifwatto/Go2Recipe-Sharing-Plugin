jQuery(document).ready(function ($) {


    // edit personal info
    $('#personal-info-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('action', 'recipe_sharing_by_kashif_watto_edit_user_profile_info');

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
                        title: 'Details Updated!',
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




jQuery(document).ready(function ($) {
    console.log('jQuery Loaded:', $);
    console.log('Ajax URL:', ajax_object.ajax_url);
// register User
    $(document).on('submit', '#register_user_form', function (e) {
        e.preventDefault();

        const email = $('#email').val();
        const password = $('#password').val();
        const confrimpassword = $('#confrimpassword').val();
        console.log(email);
        console.log(password);
        console.log(confrimpassword);
        if (!email || !password || !confrimpassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill out all fields.',
            });
            return;

        }
        if(password!=confrimpassword){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password and confirm password should be same',
            });  
            return;
        }

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'register_user_via_ajax',
                email: email,
                password: password,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: response.data.message,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = response.data.redirect_url;                    });
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

    // Login User 
    $(document).on('submit', '#login_user_form', function (e) {
        e.preventDefault();

        const email = $('#login_email').val();
        const password = $('#login_password').val();
        console.log(email);
        console.log(password);
        if (!email || !password ) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill out all fields.',
            });
            return;

        }

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'login_user_via_ajax',
                email: email,
                password: password,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        text: response.data.message,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = response.data.redirect_url;                    });
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

    // Register Tester

    $(document).on('submit', '#register_tester_form', function (e) {
        e.preventDefault();

        const email = $('#testeremail').val();
        const password = $('#testerpassword').val();
        const confrimpassword = $('#testerconfrimpassword').val();
        
        if (!email || !password || !confrimpassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill out all fields.',
            });
            return;

        }
        if(password!=confrimpassword){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password and confirm password should be same',
            });  
            return;
        }

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'register_recipetester_via_ajax',
                email: email,
                password: password,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: response.data.message,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = response.data.redirect_url;                    });
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
        // Login Tester 
        $(document).on('submit', '#login_tester_form', function (e) {
            e.preventDefault();
    
            const email = $('#login_tester_email').val();
            const password = $('#login_tester_password').val();
            console.log(email);
            console.log(password);
            if (!email || !password ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill out all fields.',
                });
                return;
    
            }
            
    
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'login_recipetester_via_ajax',
                    email: email,
                    password: password,
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful!',
                            text: response.data.message,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = response.data.redirect_url;                    });
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

// Ensure script runs in Elementor editor mode
jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
        jQuery(document).trigger('customFormReady');
    });
});

