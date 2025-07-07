<?php
/*
Template Name: Your recipe
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
$name = '';
$location = '';
$details = '';
$user_image = 'https://img.icons8.com/ios/50/000000/camera--v1.png';
if (is_user_logged_in()) {
    $current_user_id = get_current_user_id();

    // Retrieve user meta
    $name = get_user_meta($current_user_id, 'name', true);
    $location = get_user_meta($current_user_id, 'location', true);
    $details = get_user_meta($current_user_id, 'details', true);
    $user_image = get_user_meta($current_user_id, 'user_image', true);
}
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<style>
    .menu-inner,
    .info-setting-container {
        background-color: rgba(248, 247, 246, 1);
        padding: 25px;
        border-radius: 12px;

    }


    .info-menu {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: column;
    }

    .email {
        font-family: Poppins;
        font-size: 18px;
        font-weight: 600;
        line-height: 36px;
        color: rgba(48, 48, 48, 1);
    }

    .menu {
        font-family: Poppins;
        font-size: 18px;
        font-weight: 500;
        line-height: 27px;
        letter-spacing: 0.01em;
        color: rgba(48, 48, 48, 1);
    }

    .active {
        color: rgba(255, 59, 59, 1);
    }

    .menu:hover {
        color: rgba(255, 59, 59, 1);
    }

    table th,
    table td {
        border: none !important;
    }

    table th {
        text-align: start;
        font-size: 18px;
        font-weight: 500;
        line-height: 32px;
        letter-spacing: 0.01em;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);


    }

    table td {
        text-align: start;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(102, 102, 102, 1);
    }

    table td h4 {
        text-align: start;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
    }

    table td h4 a {
        color: rgba(102, 102, 102, 1);

    }

    table td h4 a:hover {
        color: rgba(102, 102, 102, 1);

    }

    table td .recipe_status {
        color: rgba(37, 191, 96, 1);
        background-color: white;
        padding: 4px 12px;
        border-radius: 100px;
    }

    table tbody>tr:nth-child(odd)>td {
        background-color: transparent !important;
    }

    table tbody tr:hover>td {
        background-color: transparent !important;

    }

    textarea {
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 16px !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        color: rgba(102, 102, 102, 1);
        height: 100px;
    }

    label {
        font-size: 20px;
        font-weight: 600;
        line-height: 32px;
        color: rgba(48, 48, 48, 1);
        margin: 15px 0px;

    }

    input {
        border: 1px solid rgba(171, 167, 167, 1) !important;
        border-radius: 100px !important;
        padding: 15px !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        color: rgba(102, 102, 102, 1);
    }

    select {
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 100px;
        padding: 15px;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        color: rgba(102, 102, 102, 1);
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: none !important;
        border: 1px solid rgba(171, 167, 167, 1) !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 info-menu">
            <?php @include('personalinfo-sidebar.php'); ?>
        </div>
        <div class="col-md-8 info-setting-container">
            <?php
            if (is_user_logged_in()) {
                $current_user_id = get_current_user_id();

                // Query to fetch all recipes (published and pending) created by the logged-in user
                $args = array(
                    'post_type'      => 'recipe', // Replace with your custom post type slug
                    'post_status'    => ['publish',  'draft'], // Fetch both published and pending recipes
                    'author'         => $current_user_id,
                    'posts_per_page' => -1, // Fetch all recipes
                );

                $recipes_query = new WP_Query($args);

                if ($recipes_query->have_posts()) {
            ?>
                    <table class="table table-responive">
                        <thead>
                            <tr>
                                <th style="width:50%;">Your Recipes</th>
                                <!-- <th>Status</th> -->
                                <th>Rating</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($recipes_query->have_posts()) {
                                $recipes_query->the_post();

                                // Fetch custom meta values (e.g., rating) if applicable
                                $recipe_status = get_post_status(); // Get the post status
                                // Fetch approved comments
                                $comments = get_comments([
                                    'post_id' => get_the_ID(),
                                    'status' => 'approve',
                                ]);

                                $total_rating = 0;
                                $rating_count = 0;

                                foreach ($comments as $comment) {
                                    $rating = get_comment_meta($comment->comment_ID, 'rating', true);

                                    // Only count numeric ratings (to avoid null or invalid data)
                                    if (is_numeric($rating) && $rating > 0) {
                                        $total_rating += floatval($rating);
                                        $rating_count++;
                                    }
                                }

                                $average_rating = ($rating_count > 0) ? round($total_rating / $rating_count, 1) : 0;

                            ?>
                                <tr>
                                    <td style="width:50%;">
                                        <h4 class="recipe_title">
                                            <a href="<?php echo get_permalink(); ?>">
                                                <?php the_title();
                                                if (get_post_status() === 'draft') {
                                                    echo ' - Draft';
                                                } ?>
                                            </a>

                                        </h4>
                                    </td>
                                    <!-- <td>
                                        <p class="recipe_status"><?php // echo ucfirst($recipe_status); // Capitalize the status 
                                                                    ?></p>
                                    </td> -->
                                    <td><?php
                                        if ($average_rating > 0) {
                                            echo '<p class="recipe_rating">';
                                            echo '<span style="color: red;">&#9733;</span> ' . number_format($average_rating, 1);
                                            echo '</p>';
                                        } else {
                                            echo '<p>N/A</p>';
                                        }
                                        ?></td>
                                    <td>
                                        <a href="<?php echo get_edit_post_link(get_the_ID()); ?>" class=" ">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M18.5 2.49998C18.8978 2.10216 19.4374 1.87866 20 1.87866C20.5626 1.87866 21.1022 2.10216 21.5 2.49998C21.8978 2.89781 22.1213 3.43737 22.1213 3.99998C22.1213 4.56259 21.8978 5.10216 21.5 5.49998L12 15L8 16L9 12L18.5 2.49998Z" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>

                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo get_delete_post_link(get_the_ID()); ?>" class=" " onclick="return confirm('Are you sure you want to delete this recipe?');">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 6H5H21" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10 11V17" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M14 11V17" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>

                                        </a>
                                    </td>
                                </tr>



                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
            <?php
                    wp_reset_postdata();
                } else {
                    echo '<p>No recipes found.</p>';
                }
            } else {
                echo '<p>You must be logged in to view your recipes.</p>';
            }
            ?>


        </div>
    </div>
</div>
<script>

</script>

<?php get_footer(); ?>