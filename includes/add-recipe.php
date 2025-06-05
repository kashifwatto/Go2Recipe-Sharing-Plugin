<?php
if (! defined('ABSPATH')) exit;

// Start of add recipe  logic
add_action('wp_ajax_recipe_sharing_by_kashif_watto_add_recipe', 'recipe_sharing_by_kashif_watto_add_recipe');
add_action('wp_ajax_nopriv_recipe_sharing_by_kashif_watto_add_recipe', 'recipe_sharing_by_kashif_watto_add_recipe');

if (!function_exists('recipe_sharing_by_kashif_watto_add_recipe')) {
    function recipe_sharing_by_kashif_watto_add_recipe()
    {

      
        $title = sanitize_text_field($_POST['title'] ?? '');
        $description = wp_kses_post($_POST['description'] ?? '');
        $inspiration = sanitize_text_field($_POST['inspiration'] ?? '');
        $instructions = wp_kses_post($_POST['instructions'] ?? '');
        $ingredients = wp_kses_post($_POST['ingredients'] ?? '');


        $recipe_category = [];

        if (isset($_POST['recipe_category'])) {
            if (is_array($_POST['recipe_category'])) {
                $recipe_category = array_map('sanitize_text_field', $_POST['recipe_category']);
            } else {
                // Fallback in case a single value is sent (rare with [] in name, but good to check)
                $recipe_category = [sanitize_text_field($_POST['recipe_category'])];
            }
        }
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

// Get the post status from the form
        $post_status = sanitize_text_field($_POST['post_status'] ?? 'draft');
        
        // Validate status - only allow publish or draft
        if (!in_array($post_status, ['publish', 'draft'])) {
            $post_status = 'draft';
        }


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
            'post_status'  => $post_status,
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
        if (!empty($recipe_category)) {
            wp_set_post_terms($post_id, $recipe_category, 'recipe_category');
        }

        update_post_meta($post_id, '_instructions', $instructions);
        update_post_meta($post_id, '_ingredients', $ingredients);
        update_post_meta($post_id, '_inspiration', $inspiration);
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

            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Upload the file
            $dish_upload = wp_handle_upload($dish_photo, ['test_form' => false]);

            if (isset($dish_upload['file'])) {
                $dish_photo_url = $dish_upload['url'];
                $dish_photo_path = $dish_upload['file'];
                $filetype = wp_check_filetype($dish_photo_path, null);

                // Create attachment post
                $attachment = [
                    'guid'           => $dish_photo_url,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => sanitize_file_name(basename($dish_photo_path)),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];

                // Insert attachment to the media library
                $attach_id = wp_insert_attachment($attachment, $dish_photo_path, $post_id);

                // Generate metadata and thumbnails
                $attach_data = wp_generate_attachment_metadata($attach_id, $dish_photo_path);
                wp_update_attachment_metadata($attach_id, $attach_data);

                // Set as featured image
                set_post_thumbnail($post_id, $attach_id);

                // Optional: Save the URL to post meta too
                update_post_meta($post_id, '_dish_photo', $dish_photo_url);

                error_log("Dish photo uploaded and set as featured image: $dish_photo_url");
            } else {
                error_log("Dish photo upload failed: " . $dish_upload['error']);
            }
        }
// Send success response with appropriate message
        $message = $post_status === 'publish' 
            ? 'Recipe published successfully!' 
            : 'Recipe saved as draft!';
            
        // Send success response
                wp_send_json_success([
            'message' => $message,
            'post_id' => $post_id,
            'redirect_url' => site_url('your-recipes/')
        ]);

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
        $instructions = wp_kses_post($_POST['instructions'] ?? '');
        $ingredients = wp_kses_post($_POST['ingredients'] ?? '');
        // $recipe_category = sanitize_text_field($_POST['recipe_category'] ?? '');
        // $cuisine = sanitize_text_field($_POST['cuisine'] ?? '');
        $preparation_time_hour = sanitize_text_field($_POST['preparation_time_hour'] ?? '');
        $preparation_time_minutes = sanitize_text_field($_POST['preparation_time_minutes'] ?? '');
        $cooking_time_hour = sanitize_text_field($_POST['cooking_time_hour'] ?? '');
        $cooking_time_minutes = sanitize_text_field($_POST['cooking_time_minutes'] ?? '');
        $total_time_hour = sanitize_text_field($_POST['total_time_hour'] ?? '');
        $total_time_minutes = sanitize_text_field($_POST['total_time_minutes'] ?? '');
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


        update_post_meta($post_id, '_instructions', $instructions);
        update_post_meta($post_id, '_ingredients', $ingredients);
        // Save other custom fields and metadata
        update_post_meta($post_id, '_inspiration', $inspiration);
        // update_post_meta($post_id, '_recipe_category', $recipe_category);
        // update_post_meta($post_id, '_cuisine', $cuisine);
        update_post_meta($post_id, '_preparation_time_hour', $preparation_time_hour);
        update_post_meta($post_id, '_preparation_time_minutes', $preparation_time_minutes);
        update_post_meta($post_id, '_cooking_time_hour', $cooking_time_hour);
        update_post_meta($post_id, '_cooking_time_minutes', $cooking_time_minutes);
        update_post_meta($post_id, '_total_time_hour', $total_time_hour);
        update_post_meta($post_id, '_total_time_minutes', $total_time_minutes);
        update_post_meta($post_id, '_serving', $serving);
        update_post_meta($post_id, '_video_link', $video_link);
        update_post_meta($post_id, '_recipe_notes', $recipe_notes);

        // Handle dish photo upload
        if (!empty($_FILES['dish_photo']['name'])) {
            $dish_photo = $_FILES['dish_photo'];

            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Upload the file
            $dish_upload = wp_handle_upload($dish_photo, ['test_form' => false]);

            if (isset($dish_upload['file'])) {
                $dish_photo_url = $dish_upload['url'];
                $dish_photo_path = $dish_upload['file'];
                $filetype = wp_check_filetype($dish_photo_path, null);

                // Create attachment post
                $attachment = [
                    'guid'           => $dish_photo_url,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => sanitize_file_name(basename($dish_photo_path)),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ];

                // Insert attachment to the media library
                $attach_id = wp_insert_attachment($attachment, $dish_photo_path, $post_id);

                // Generate metadata and thumbnails
                $attach_data = wp_generate_attachment_metadata($attach_id, $dish_photo_path);
                wp_update_attachment_metadata($attach_id, $attach_data);

                // Set as featured image
                set_post_thumbnail($post_id, $attach_id);

                // Optional: Save the URL to post meta too
                update_post_meta($post_id, '_dish_photo', $dish_photo_url);

                error_log("Dish photo uploaded and set as featured image: $dish_photo_url");
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

// start of assgin recipe to new user 

function recipe_sharing_by_kashif_watto_assign_recipe_to_new_user()
{

 $post_id = intval($_POST['post_id']);
    $new_author_id = intval($_POST['new_author']);
    $current_user_id = get_current_user_id();

    if (!current_user_can('administrator')) {
        wp_send_json_error(['message' => 'You are not authorized.']);
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'recipe') {
        wp_send_json_error(['message' => 'Invalid recipe.']);
    }

    if ($post->post_author != $current_user_id) {
        wp_send_json_error(['message' => 'You are not the author of this recipe.']);
    }

    $new_user = get_userdata($new_author_id);
    if (!$new_user || !in_array('subscriber', $new_user->roles)) {
        wp_send_json_error(['message' => 'Selected user is not a subscriber.']);
    }

    wp_update_post([
        'ID' => $post_id,
        'post_author' => $new_author_id
    ]);

    wp_send_json_success(['message' => 'Recipe successfully reassigned.']);
}
add_action('wp_ajax_recipe_sharing_by_kashif_watto_assign_recipe_to_new_user', 'recipe_sharing_by_kashif_watto_assign_recipe_to_new_user');
add_action('wp_ajax_nopriv_recipe_sharing_by_kashif_watto_assign_recipe_to_new_user', 'recipe_sharing_by_kashif_watto_assign_recipe_to_new_user');
