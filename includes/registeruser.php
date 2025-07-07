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
    $fname = sanitize_text_field($_POST['fname']);
    $lname = sanitize_text_field($_POST['lname']);
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
    update_user_meta($user_id, 'fristname', $fname);
    update_user_meta($user_id, 'lastname', $lname);




    // Send verification email
    $verification_url = add_query_arg([
        'verify_email' => 1,
        'key' => $verification_key,
        'user' => $user_id,
    ], site_url());
// Prepare email
$subject = '✅ Please Verify Your Email to Get Started';
$headers = ['Content-Type: text/html; charset=UTF-8'];

// Optional: Logo URL
$logo_url = 'https://go2recipe.com/wp-content/uploads/2025/01/image-359.png'; // replace with your actual logo path

// HTML email content
$message = "
<html>
<head>
  <style>
    .email-wrapper {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      padding: 40px 20px;
      text-align: center;
      color: #333;
    }
    .email-content {
      background: #fff;
      max-width: 600px;
      margin: auto;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .logo {
      max-width: 150px;
      margin-bottom: 20px;
    }
    .verify-button {
      display: inline-block;
      margin: 25px 0;
      padding: 12px 30px;
      background-color: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-size: 16px;
    }
    .footer {
      font-size: 12px;
      color: #888;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class='email-wrapper'>
    <div class='email-content'>
      <img src='$logo_url' alt='Go2Recipe Logo' class='logo' />
      <h2>Hi " . esc_html($fname) . ",</h2>
      <p>Thanks for signing up! To complete your registration and activate your account, please verify your email address by clicking the button below:</p>
      <a href='$verification_url' class='verify-button'>👉 Verify Email</a>
      <p>If the button doesn't work, copy and paste this link into your browser:</p>
      <p><a href='$verification_url'>$verification_url</a></p>
      <p>If you didn’t sign up for this account, please ignore this email.</p>
      <p>Thanks,<br><strong>Go To Recipe Team</strong></p>
    </div>
    <div class='footer'>© " . date('Y') . " Go To Recipe. All rights reserved.</div>
  </div>
</body>
</html>
";

// Send email
wp_mail($email, $subject, $message, $headers);

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
