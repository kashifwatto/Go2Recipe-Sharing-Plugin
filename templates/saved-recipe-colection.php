<?php

/*
Template Name: Saved Recipe & Collection
*/
if (! defined('ABSPATH')) {
    exit;
}
// Redirect non-logged-in users to homepage
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

get_header();
wp_head();
?>
<h3>Personal Info</h3>
<?php get_footer(); ?>