<?php
if (! defined('ABSPATH')) exit;

// Start of add recipe  logic
add_action('wp_ajax_recipe_sharing_by_kashif_watto_add_recipe', 'recipe_sharing_by_kashif_watto_add_recipe');
add_action('wp_ajax_nopriv_recipe_sharing_by_kashif_watto_add_recipe', 'recipe_sharing_by_kashif_watto_add_recipe');

if (!function_exists('recipe_sharing_by_kashif_watto_add_recipe')) {
    function recipe_sharing_by_kashif_watto_add_recipe()
    {

        // Extract and sanitize form data
        error_log('POST Data: ' . print_r($_POST, true));


        $title = sanitize_text_field($_POST['title'] ?? '');
        $description = wp_kses_post($_POST['description'] ?? '');
        $inspiration = sanitize_text_field($_POST['inspiration'] ?? '');
        $instructions = sanitize_text_field($_POST['instructions'] ?? '');
        $ingredients = sanitize_text_field($_POST['ingredients'] ?? '');
        
        $recipe_category = isset($_POST['recipe_category']) ? array_map('sanitize_text_field', $_POST['recipe_category']) : [];
        $cuisine = sanitize_text_field($_POST['cuisine'] ?? '');
        $preparation_time_hour = sanitize_text_field($_POST['preparation_time_hour'] ?? '');
        $preparation_time_minutes = sanitize_text_field($_POST['preparation_time_minutes'] ?? '');
        $cooking_time_hour = sanitize_text_field($_POST['cooking_time_hour'] ?? '');
        $cooking_time_minutes = sanitize_text_field($_POST['cooking_time_minutes'] ?? '');
        $total_time_hour = sanitize_text_field($_POST['total_time_hour'] ?? '');
        $total_time_minutes = sanitize_text_field($_POST['total_time_minutes'] ?? '');
        $serving = intval($_POST['serving'] ?? 0);
        $video_link = esc_url_raw($_POST['video_link'] ?? '');
        $recipe_notes = wp_kses_post($_POST['recipe_notes'] ?? '');
        $form_confirm = sanitize_text_field($_POST['formconfirm'] ?? '');


        // Check if user is logged in
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'You must be logged in to submit a recipe.']);
            return;
        }

        // Get the current user
        $user_id = get_current_user_id();
       
        // Prepare post data
        $post_data = [
            'post_title'   => $title,
            'post_content' => $description,
            'post_author'  => $user_id,
            'post_status'  => 'pending', // Set to 'pending' for admin review
            'post_type'    => 'recipe',  // Replace with your custom post type
        ];

        // Insert the post
        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            wp_send_json_error(['message' => 'Failed to save the recipe.']);
            return;
        }

        // Save custom fields and metadata
        // Process Ingredients

     
        update_post_meta($post_id, '_instructions', $instructions);        
        update_post_meta($post_id, '_ingredients', $ingredients);
        update_post_meta($post_id, '_inspiration', $inspiration);
        update_post_meta($post_id, '_recipe_category', $recipe_category);
        update_post_meta($post_id, '_cuisine', $cuisine);
        update_post_meta($post_id, '_preparation_time_hour', $preparation_time_hour);
        update_post_meta($post_id, '_preparation_time_minutes', $preparation_time_minutes);
        update_post_meta($post_id, '_cooking_time_hour', $cooking_time_hour);
        update_post_meta($post_id, '_cooking_time_minutes', $cooking_time_minutes);
        update_post_meta($post_id, '_total_time_hour', $total_time_hour);
        update_post_meta($post_id, '_total_time_minutes', $total_time_minutes);
        update_post_meta($post_id, '_serving', $serving);
        update_post_meta($post_id, '_video_link', $video_link);
        update_post_meta($post_id, '_recipe_notes', $recipe_notes);
        update_post_meta($post_id, '_unique_confirm', $form_confirm);

        // Handle dish photo upload
        if (!empty($_FILES['dish_photo']['name'])) {
            $dish_photo = $_FILES['dish_photo'];

            // Use WordPress's file handling functions
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $dish_upload = wp_handle_upload($dish_photo, ['test_form' => false]);

            if (isset($dish_upload['file'])) {
                $dish_photo_url = $dish_upload['url'];

                // Save the dish photo URL
                update_post_meta($post_id, '_dish_photo', $dish_photo_url);

                error_log("Dish photo uploaded successfully: $dish_photo_url");
            } else {
                error_log("Dish photo upload failed: " . $dish_upload['error']);
            }
        }

        // Send success response
        wp_send_json_success(['message' => 'Recipe submitted successfully!', 'post_id' => $post_id, 'redirect_url' => site_url('your-recipes/')]);
    }
}



// end of  add recipe  logic
// Start of edit recipe  logic
add_action('wp_ajax_recipe_sharing_by_kashif_watto_edit_recipe', 'recipe_sharing_by_kashif_watto_edit_recipe');
add_action('wp_ajax_nopriv_recipe_sharing_by_kashif_watto_edit_recipe', 'recipe_sharing_by_kashif_watto_edit_recipe');

if (!function_exists('recipe_sharing_by_kashif_watto_edit_recipe')) {
    function recipe_sharing_by_kashif_watto_edit_recipe()
    {

        // Extract and sanitize form data


        $title = sanitize_text_field($_POST['title'] ?? '');
        $post_id = sanitize_text_field($_POST['post_id'] ?? '');
        $description = wp_kses_post($_POST['description'] ?? '');
        $inspiration = sanitize_text_field($_POST['inspiration'] ?? '');
        $instructions = $_POST['instructions'] ?? [];
        $ingredients = $_POST['ingredients'] ?? [];
        $recipe_category = sanitize_text_field($_POST['recipe_category'] ?? '');
        $cuisine = sanitize_text_field($_POST['cuisine'] ?? '');
        $preparation_time = sanitize_text_field($_POST['preparation_time'] ?? '');
        $cooking_time = sanitize_text_field($_POST['cooking_time'] ?? '');
        $total_time = sanitize_text_field($_POST['total_time'] ?? '');
        $serving = intval($_POST['serving'] ?? 0);
        $video_link = esc_url_raw($_POST['video_link'] ?? '');
        $recipe_notes = wp_kses_post($_POST['recipe_notes'] ?? '');
        // $form_confirm = sanitize_text_field($_POST['formconfirm'] ?? '');


        // Check if user is logged in
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'You must be logged in to submit a recipe.']);
            return;
        }

        if ($post_id) {
            // Prepare the updated post data
            $post_data = [
                'ID'           => $post_id,
                'post_title'   => $title,
                'post_content' => $description,
            ];
        }
        // Update the post
        $result = wp_update_post($post_data, true);


        // Save custom fields and metadata
        // Process Ingredients

        // Process Recipe Instructions
        $processed_instructions = [];
        if (!empty($instructions)) {
            foreach ($instructions as $index => $instruction) {
                $instruction_text = sanitize_text_field($instruction['text'] ?? '');

                // Handle image upload
                if (!empty($_FILES['instructions']['name'][$index]['image'])) {
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    $file = [
                        'name'     => $_FILES['instructions']['name'][$index]['image'],
                        'type'     => $_FILES['instructions']['type'][$index]['image'],
                        'tmp_name' => $_FILES['instructions']['tmp_name'][$index]['image'],
                        'error'    => $_FILES['instructions']['error'][$index]['image'],
                        'size'     => $_FILES['instructions']['size'][$index]['image'],
                    ];

                    // Use WordPress file handling functions
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    $upload = wp_handle_upload($file, ['test_form' => false]);

                    if (isset($upload['file'])) {
                        $instruction_image = $upload['url'];
                    }
                }

                // Save the instruction
                $processed_instructions[] = [
                    'text'  => $instruction_text,
                    'image' => $instruction_image,
                ];
            }
        }
        update_post_meta($post_id, '_instructions', $processed_instructions);

        // for ingredeints 
        $processed_instructions = [];
        if (!empty($ingredients)) {
            foreach ($ingredients as $index => $instruction) {
                $ingredeints_text = sanitize_text_field($instruction['name'] ?? '');
                $ingredeints_unit = sanitize_text_field($_POST['ingredients'][$index]['unit'] ?? '');




                // Save the instruction
                $processed_instructions[] = [
                    'name'  => $ingredeints_text,
                    'unit' => $ingredeints_unit,
                ];
            }
        }
        update_post_meta($post_id, '_ingredients', $processed_instructions);

        // Save other custom fields and metadata
        update_post_meta($post_id, '_inspiration', $inspiration);
        update_post_meta($post_id, '_recipe_category', $recipe_category);
        update_post_meta($post_id, '_cuisine', $cuisine);
        update_post_meta($post_id, '_preparation_time', $preparation_time);
        update_post_meta($post_id, '_cooking_time', $cooking_time);
        update_post_meta($post_id, '_total_time', $total_time);
        update_post_meta($post_id, '_serving', $serving);
        update_post_meta($post_id, '_video_link', $video_link);
        update_post_meta($post_id, '_recipe_notes', $recipe_notes);

        // Handle dish photo upload
        if (!empty($_FILES['dish_photo']['name'])) {
            $dish_photo = $_FILES['dish_photo'];

            // Use WordPress's file handling functions
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $dish_upload = wp_handle_upload($dish_photo, ['test_form' => false]);

            if (isset($dish_upload['file'])) {
                $dish_photo_url = $dish_upload['url'];

                // Save the dish photo URL
                update_post_meta($post_id, '_dish_photo', $dish_photo_url);

                error_log("Dish photo uploaded successfully: $dish_photo_url");
            } else {
                error_log("Dish photo upload failed: " . $dish_upload['error']);
            }
        }

        // Send success response
        wp_send_json_success(['message' => 'Recipe updated successfully!', 'post_id' => $post_id, 'redirect_url' => site_url('your-recipes/')]);
    }
}



// end of  add recipe  logic


// start of review 

function recipe_sharing_by_kashif_watto_submit_review()
{
    // Ensure user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'You must be logged in to submit a review.']);
    }

    // Get and sanitize input values
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $comment_content = isset($_POST['comment']) ? sanitize_textarea_field($_POST['comment']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $user_id = get_current_user_id();
    $user = get_userdata($user_id);

    // Validate input
    if (!$post_id || empty($comment_content) || $rating < 1 || $rating > 5) {
        wp_send_json_error(['message' => 'Invalid input data.']);
    }

    // Prepare comment data
    $comment_data = [
        'comment_post_ID' => $post_id,
        'comment_content' => $comment_content,
        'comment_author' => $user->display_name, // Use logged-in user's display name
        'comment_author_email' => $user->user_email, // Use logged-in user's email
        'user_id' => $user_id, // Set comment author as logged-in user
        'comment_approved' => 1, // Auto-approve comments
    ];

    // Insert comment into the database
    $comment_id = wp_insert_comment($comment_data);

    // Save rating as comment meta
    if ($comment_id) {
        add_comment_meta($comment_id, 'rating', $rating);
        wp_send_json_success(['message' => 'Your review has been submitted successfully!']);
    } else {
        wp_send_json_error(['message' => 'Failed to submit your review.']);
    }
}
add_action('wp_ajax_recipe_sharing_by_kashif_watto_submit_review', 'recipe_sharing_by_kashif_watto_submit_review');
add_action('wp_ajax_nopriv_recipe_sharing_by_kashif_watto_submit_review', 'recipe_sharing_by_kashif_watto_submit_review');
