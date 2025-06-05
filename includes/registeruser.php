<?php
// Start of register user logic
add_action('wp_ajax_register_user_via_ajax', 'register_user_via_ajax');
add_action('wp_ajax_nopriv_register_user_via_ajax', 'register_user_via_ajax');

function register_user_via_ajax()
{
    error_log("function is runing");

    // Validate input.
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        wp_send_json_error(['message' => 'Invalid data received.']);
        exit;
    }

    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    error_log($email);
    if (empty($email) || empty($password)) {
        wp_send_json_error(['message' => 'Please fill out all fields.']);
        exit;
    }

    // Check if email already exists.
    if (email_exists($email)) {
        wp_send_json_error(['message' => 'Email already exists.']);
        exit;
    }

    // Create user.
    $user_id = wp_create_user($email, $password, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error(['message' => 'Failed to create user.', 'error' => $user_id->get_error_message()]);
        exit;
    }
    // Assign Subscriber role and log in.
    $user = new WP_User($user_id);
    $user->set_role('subscriber');
    // Save verification status
    $verification_key = md5(time() . $email);
    update_user_meta($user_id, 'is_email_verified', 0);
    update_user_meta($user_id, 'email_verification_key', $verification_key);




    // Send verification email
    $verification_url = add_query_arg([
        'verify_email' => 1,
        'key' => $verification_key,
        'user' => $user_id,
    ], site_url());

    $subject = 'Verify your email at go2recipe.com';
    $message = "Click the link to verify your email: $verification_url";
    wp_mail($email, $subject, $message);


    // Success response.
    wp_send_json_success(['message' => 'User registered successfully. Varify Your Email']);
    exit;
}
// Start of login user logic
add_action('wp_ajax_login_user_via_ajax', 'login_user_via_ajax');
add_action('wp_ajax_nopriv_login_user_via_ajax', 'login_user_via_ajax');

function login_user_via_ajax()
{


    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        wp_send_json_error(['message' => 'Invalid data received.']);
        exit;
    }

    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);

    if (empty($email) || empty($password)) {
        wp_send_json_error(['message' => 'Please fill out all fields.']);
        exit;
    }

    // Get user by email
    $user = get_user_by('email', $email);

    if (!$user) {
        wp_send_json_error(['message' => 'User not found.']);
        exit;
    }
    // ✅ Check email verification status
    $is_verified = get_user_meta($user->ID, 'is_email_verified', true);
    if ($is_verified != 1) {
        wp_send_json_error(['message' => 'Please verify your email before logging in.']);
        exit;
    }

    // Authenticate user
    $creds = [
        'user_login'    => $user->user_login, // Use username instead of email
        'user_password' => $password,
        'remember'      => true,
    ];

    $login = wp_signon($creds, false);

    if (is_wp_error($login)) {
        wp_send_json_error(['message' => 'Login failed.', 'error' => $login->get_error_message()]);
        exit;
    }

    // Success response
    wp_send_json_success(['message' => 'Login successful. Redirecting...', 'redirect_url' => site_url('/personal-info/')]);
    exit;
}



// Start of register tester logic
add_action('wp_ajax_register_recipetester_via_ajax', 'register_recipetester_via_ajax');
add_action('wp_ajax_nopriv_register_recipetester_via_ajax', 'register_recipetester_via_ajax');

function register_recipetester_via_ajax()
{


    // Validate input.
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        wp_send_json_error(['message' => 'Invalid data received.']);
        exit;
    }

    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);

    if (empty($email) || empty($password)) {
        wp_send_json_error(['message' => 'Please fill out all fields.']);
        exit;
    }

    // Check if email already exists.
    if (email_exists($email)) {
        wp_send_json_error(['message' => 'Email already exists.']);
        exit;
    }

    // Create user.
    $user_id = wp_create_user($email, $password, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error(['message' => 'Failed to create user.', 'error' => $user_id->get_error_message()]);
        exit;
    }
    error_log('User Has been created');
    // Assign Subscriber role and log in.
    $user = new WP_User($user_id);
    $user->set_role('editor');

    $creds = [
        'user_login'    => $email,
        'user_password' => $password,
        'remember'      => true,
    ];
    $login = wp_signon($creds, false);

    if (is_wp_error($login)) {
        wp_send_json_error(['message' => 'Login failed.', 'error' => $login->get_error_message()]);
        exit;
    }
    error_log('User Has been login');


    // Success response.
    wp_send_json_success(['message' => 'User registered successfully. Redirecting...', 'redirect_url' => site_url('wp-admin/')]);
    exit;
}

// Start of login tester logic
add_action('wp_ajax_login_recipetester_via_ajax', 'login_recipetester_via_ajax');
add_action('wp_ajax_nopriv_login_recipetester_via_ajax', 'login_recipetester_via_ajax');

function login_recipetester_via_ajax()
{


    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        wp_send_json_error(['message' => 'Invalid data received.']);
        exit;
    }

    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);

    if (empty($email) || empty($password)) {
        wp_send_json_error(['message' => 'Please fill out all fields.']);
        exit;
    }

    // Get user by email
    $user = get_user_by('email', $email);

    if (!$user) {
        wp_send_json_error(['message' => 'User not found.']);
        exit;
    }

    // Authenticate user
    $creds = [
        'user_login'    => $user->user_login, // Use username instead of email
        'user_password' => $password,
        'remember'      => true,
    ];

    $login = wp_signon($creds, false);

    if (is_wp_error($login)) {
        wp_send_json_error(['message' => 'Login failed.', 'error' => $login->get_error_message()]);
        exit;
    }

    // Success response
    wp_send_json_success(['message' => 'Login successful. Redirecting...', 'redirect_url' => site_url('wp-admin/')]);
    exit;
}
