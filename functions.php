<?php
if (! defined('ABSPATH')) exit;

/**
 * Plugin Name:       Recipe Sharing By Kashif Watto
 * Description:       Enhance your Elementor experience with the Star Plus Addon For Elementor. This versatile addon offers custom widgets, including stylish button widgets and eye-catching icon cards, enabling you to create professional and interactive website designs effortlessly. Unlock new design possibilities with Star Plus Addon For Elementor
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Kashif Watto
 * Author URI:        https://kashifwatto.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       recipe-sharing-by-kashif-watto
 */


if (!defined('recipe_sharing_dir_folder')) {
    define('recipe_sharing_dir_folder', plugin_dir_url(__FILE__));
}
add_action('wp_enqueue_scripts', 'scripts_style_adding');
function scripts_style_adding()
{
    wp_enqueue_script('sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', [], null, true);
    wp_enqueue_script(
        'register-user-script',
        plugin_dir_url(__FILE__) . 'assets/js/registeruser.js',
        ['jquery'],
        null,
        true
    );
    wp_enqueue_script(
        'personal-info-script',
        plugin_dir_url(__FILE__) . 'assets/js/personal-info.js',
        ['jquery'],
        null,
        true
    );
    wp_enqueue_script(
        'recipe-script',
        plugin_dir_url(__FILE__) . 'assets/js/recipe.js',
        ['jquery'],
        null,
        true
    );
    wp_enqueue_style('style-css', plugin_dir_url(__FILE__) . 'assets/css/style.css',);

    wp_localize_script('register-user-script', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
};



// Disable admin dashboard access and hide admin bar for subscribers.
add_action('init', function () {
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        if (in_array('subscriber', (array) $user->roles)) {
            show_admin_bar(false); // Hide admin bar
            if (is_admin() && !defined('DOING_AJAX')) {
                wp_redirect(home_url());
                exit;
            }
        }
    }
});

add_action('admin_menu', 'customize_editor_admin_menu', 999);

function customize_editor_admin_menu() {
    // Only modify menu for editors
    if (!current_user_can('editor')) {
        return;
    }

    // Remove specific menu pages
    remove_menu_page('edit.php');              // Posts
    remove_menu_page('upload.php');            // Media
    remove_menu_page('edit.php?post_type=page'); // Pages
    remove_menu_page('edit.php?post_type=elementor_library'); // Elementor Templates
    remove_menu_page('edit-comments.php');      // Comments

// for restrict editor to add new recipe 
    $restricted_pages = [
        'post-new.php?post_type=recipe', // Add New Recipe
    ];

    foreach ($restricted_pages as $page) {
        if (strpos($_SERVER['REQUEST_URI'], $page) !== false) {
            wp_redirect(admin_url('?recipe_redirect_notice=1'));
            exit;
        }
    }
}

add_action('admin_notices', 'show_recipe_redirect_notice');

function show_recipe_redirect_notice() {
    if (isset($_GET['recipe_redirect_notice']) && current_user_can('editor')) {
        echo '<div class="notice notice-warning is-dismissible">
                <p>You are not allowed to add new recipes.</p>
              </div>';
    }
}

// check User profile, add recipe page exsit or not if not then create them 
register_activation_hook(__FILE__, 'recipe_sharing_by_kashif_watto_to_checkpage_exsist');
// Activation callback function
if (!function_exists('recipe_sharing_by_kashif_watto_to_checkpage_exsist')) {
    function recipe_sharing_by_kashif_watto_to_checkpage_exsist()
    {
        $page_title = "Add Recipe";
        $page_title_3 = "Personal Info";
        $page_title_4 = "Your Recipes";
        $page_title_5 = "Saved Recipes & Collections";
        // Check if a page with the title exists
        $existing_page = new WP_Query(array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'name'           => sanitize_title($page_title),
            'posts_per_page' => 1,
        ));
        if (!$existing_page->have_posts()) {
            // Create a new page
            $new_page_id = wp_insert_post(array(
                'post_title'   => $page_title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ));
        }

        $existing_page_2 = new WP_Query(array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'name'           => sanitize_title($page_title_3),
            'posts_per_page' => 1,
        ));
        if (!$existing_page_2->have_posts()) {
            // Create a new page
            $new_page_id_2 = wp_insert_post(array(
                'post_title'   => $page_title_3,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ));
        }
        $existing_page_2 = new WP_Query(array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'name'           => sanitize_title($page_title_4),
            'posts_per_page' => 1,
        ));
        if (!$existing_page_2->have_posts()) {
            // Create a new page
            $new_page_id_2 = wp_insert_post(array(
                'post_title'   => $page_title_4,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ));
        }
        $existing_page_2 = new WP_Query(array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'name'           => sanitize_title($page_title_5),
            'posts_per_page' => 1,
        ));
        if (!$existing_page_2->have_posts()) {
            // Create a new page
            $new_page_id_2 = wp_insert_post(array(
                'post_title'   => $page_title_5,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ));
        }
        // Be sure to reset the query to avoid potential conflicts
        wp_reset_postdata();
    }
}
add_filter('page_template', 'recipe_sharing_by_kashif_watto_to_apply_addrecipetemp');
if (!function_exists('recipe_sharing_by_kashif_watto_to_apply_addrecipetemp')) {
    function recipe_sharing_by_kashif_watto_to_apply_addrecipetemp($page_template)
    {
        if (is_page('Add Recipe')) {
            $page_template = plugin_dir_path(__FILE__) . 'templates/add-recipe.php';
        }
        if (is_page('Personal Info')) {
            $page_template = plugin_dir_path(__FILE__) . 'templates/personal-info.php';
        }
        if (is_page('Your Recipes')) {
            $page_template = plugin_dir_path(__FILE__) . 'templates/your-recipe.php';
        }
        return $page_template;
    }
}

add_filter('template_include', function ($template) {
    if (is_singular('recipe')) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-recipe.php';
        return file_exists($plugin_template) ? $plugin_template : $template;
    }

    if (is_post_type_archive('recipe')) {
        $plugin_archive_template = plugin_dir_path(__FILE__) . 'templates/single-recipe.php';
        return file_exists($plugin_archive_template) ? $plugin_archive_template : $template;
    }

    return $template;
});




function recipe_sharing_custom_post_type()
{
    // Register the Recipe custom post type
    register_post_type('recipe', [
        'labels' => [
            'name'               => __('Recipes', 'textdomain'),
            'singular_name'      => __('Recipe', 'textdomain'),
            'menu_name'          => __('Recipes', 'textdomain'),
            'name_admin_bar'     => __('Recipe', 'textdomain'),
            'add_new'            => __('Add New', 'textdomain'),
            'add_new_item'       => __('Add New Recipe', 'textdomain'),
            'new_item'           => __('New Recipe', 'textdomain'),
            'edit_item'          => __('Edit Recipe', 'textdomain'),
            'view_item'          => __('View Recipe', 'textdomain'),
            'all_items'          => __('All Recipes', 'textdomain'),
            'search_items'       => __('Search Recipes', 'textdomain'),
            'parent_item_colon'  => __('Parent Recipes:', 'textdomain'),
            'not_found'          => __('No recipes found.', 'textdomain'),
            'not_found_in_trash' => __('No recipes found in Trash.', 'textdomain'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'recipes'],
        'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-carrot', // WordPress Dashicon for Recipes
    ]);

    flush_rewrite_rules();
}
add_action('init', 'recipe_sharing_custom_post_type');


function recipe_sharing_add_admin_menu()
{
    // Add parent menu
    add_menu_page(
        __('Recipe Sharing', 'textdomain'), // Page title
        __('Recipe Sharing', 'textdomain'), // Menu title
        'manage_options',                   // Capability
        'recipe_sharing',                   // Menu slug
        'recipe_sharing_dashboard_page',    // Callback function
        'dashicons-carrot',                 // Icon
        20                                  // Position
    );

    // Add submenu for managing recipes
    add_submenu_page(
        'recipe_sharing',                   // Parent slug
        __('Manage Recipes', 'textdomain'), // Page title
        __('Manage Recipes', 'textdomain'), // Submenu title
        'manage_options',                   // Capability
        'edit.php?post_type=recipe'         // Redirect to Recipe post type list
    );
}

// Callback for parent menu page (optional)
function recipe_sharing_dashboard_page()
{
    echo '<div class="wrap"><h1>' . __('Recipe Sharing Dashboard', 'textdomain') . '</h1>';
    echo '<p>' . __('Welcome to the Recipe Sharing Dashboard!', 'textdomain') . '</p></div>';
}

add_action('admin_menu', 'recipe_sharing_add_admin_menu');



@include('includes/add-recipe.php');
@include('includes/registeruser.php');
@include('includes/edit-recipe.php');

add_action('admin_head', 'load_custom_recipe_edit_template');

function load_custom_recipe_edit_template()
{
    global $pagenow, $typenow;
    if ($pagenow == 'post.php' && $typenow == 'recipe' && isset($_GET['action']) && $_GET['action'] == 'edit') {
        include plugin_dir_path(__FILE__) . 'templates/edit-recipe.php';
        exit;
    }
}
// end of register user logic

// Start of user profile info
add_action('wp_ajax_recipe_sharing_by_kashif_watto_edit_user_profile_info', 'recipe_sharing_by_kashif_watto_edit_user_profile_info');
add_action('wp_ajax_nopriv_recipe_sharing_by_kashif_watto_edit_user_profile_info', 'recipe_sharing_by_kashif_watto_edit_user_profile_info');

if (!function_exists('recipe_sharing_by_kashif_watto_edit_user_profile_info')) {
    function recipe_sharing_by_kashif_watto_edit_user_profile_info()
    {

        $name = sanitize_text_field($_POST['name'] ?? '');
        $location = sanitize_text_field($_POST['location'] ?? '');
        $details = sanitize_text_field($_POST['details'] ?? '');


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_user_logged_in()) {
            $current_user_id = get_current_user_id(); // Get the current logged-in user ID


            error_log('REQUEST_METHOD');
            // Update user meta
            update_user_meta($current_user_id, 'name', $name);
            update_user_meta($current_user_id, 'location', $location);
            update_user_meta($current_user_id, 'details', $details);
            // Handle file upload (if a file was submitted)
            if (!empty($_FILES['userimage']['name'])) {
                $file = $_FILES['userimage'];
                error_log(json_encode($file));
                // Use WordPress's file handling functions for safety
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                $upload = wp_handle_upload($file, ['test_form' => false]);

                if (isset($upload['file'])) {
                    $file_url = $upload['url'];

                    // Save the file URL as user meta or avatar
                    update_user_meta($current_user_id, 'user_image', $file_url);

                    error_log("File uploaded successfully: $file_url");
                } else {

                    error_log("File upload failed: " . $upload['error']);
                }
            }

            // Debugging
            error_log(json_encode([
                'name' => $name,
                'location' => $location,
                'details' => $details,
                'file' => $_FILES['userimage'] ?? null
            ]));


            wp_send_json_success(['message' => 'User details updates successfuly']);
        }









        // Send success response
    }
}



// end of  add recipe  logic
