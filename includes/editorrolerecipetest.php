<?php
if (! defined('ABSPATH')) exit;

// approve recipe  logic
add_action('wp_ajax_approve_recipe_by_tester', 'approve_recipe_by_tester');
add_action('wp_ajax_nopriv_approve_recipe_by_tester', 'approve_recipe_by_tester');

if (!function_exists('approve_recipe_by_tester')) {
    function approve_recipe_by_tester()
    {
        // Check for required parameters
        if (!isset($_POST['postid'])) {
            wp_send_json_error(['message' => 'Missing post ID.']);
        }

        // Ensure user is logged in and has appropriate role
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'You must be logged in to approve recipes.']);
        }

        $user_id = get_current_user_id();
        $user = wp_get_current_user();

        if (!in_array('editor', $user->roles) && !current_user_can('edit_others_posts')) {
            wp_send_json_error(['message' => 'You are not authorized to approve recipes.']);
        }

        $post_id = intval($_POST['postid']);

        // Update post status to 'publish'
        $update_result = wp_update_post([
            'ID' => $post_id,
            'post_status' => 'publish',
        ], true);

        if (is_wp_error($update_result)) {
            wp_send_json_error(['message' => 'Failed to approve recipe.']);
        }

        // Save editor info as post meta
        update_post_meta($post_id, '_approved_by_editor', $user_id);
        // email to author
        $post = get_post($post_id);
        $author_id = $post->post_author;
        $author_email = get_the_author_meta('user_email', $author_id);
        error_log($author_email);
        $author_email = 'mkashifly125@gmail.com';

        // Send approval email to author
        $subject = 'Your recipe has been approved!';
        $message = 'Hi, your submitted recipe "' . get_the_title($post_id) . '" has been approved by our team. You can view it here: ' . get_permalink($post_id);
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        // wp_mail($author_email, $subject, $message, $headers);

        wp_send_json_success([
            'message' => 'Recipe approved successfully!',
            'redirect_url' => get_permalink($post_id),
        ]);
    }
}
// reject recipe  logic
add_action('wp_ajax_reject_recipe_by_tester', 'reject_recipe_by_tester');
add_action('wp_ajax_nopriv_reject_recipe_by_tester', 'reject_recipe_by_tester');

if (!function_exists('reject_recipe_by_tester')) {
    function reject_recipe_by_tester()
    {

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $reason  = isset($_POST['reason']) ? sanitize_text_field($_POST['reason']) : '';
    
        if (!$post_id || empty($reason)) {
            wp_send_json_error(['message' => 'Missing post ID or reason.']);
        }
    
        // Get current user
        $current_user_id = get_current_user_id();
        $current_user = wp_get_current_user();
    
        // Ensure the user has permission (editor, admin, etc.)
        if (!current_user_can('edit_post', $post_id)) {
            wp_send_json_error(['message' => 'You are not allowed to reject this recipe.']);
        }
    
       
    
       
    
        // Get post author
        $author_id = get_post_field('post_author', $post_id);
        $author_email = get_the_author_meta('user_email', $author_id);
        $post_title = get_the_title($post_id);
    
        // Send email to author
        $subject = "Your Recipe \"{$post_title}\" Was Rejected";
        $message = "Hi,\n\nYour recipe titled \"{$post_title}\" was rejected by a recipe editor.\n\nReason for rejection:\n{$reason}\n\nPlease review your submission and update it if needed.\n\nThanks,\nRecipe Review Team";
        $headers = ['Content-Type: text/plain; charset=UTF-8'];
    
        // wp_mail($author_email, $subject, $message, $headers);
        error_log(json_encode($message));
    
        wp_send_json_success(['message' => 'Recipe rejected']);
    
    }
}
