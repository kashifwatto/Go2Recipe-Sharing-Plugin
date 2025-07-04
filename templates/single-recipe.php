<?php
/*
Template Name: Single Recipe
*/
if (! defined('ABSPATH')) {
    exit;
}
get_header();
wp_head();
$post_id = get_the_ID();
$post = get_post($post_id);
$dish_photo = get_post_meta($post_id, '_dish_photo', true);
$video_link = get_post_meta($post_id, '_video_link', true);
$catagory = get_post_meta($post_id, '_recipe_category', true);
$prep_time_hour = get_post_meta($post_id, '_preparation_time_hour', true);
$prep_time_minutes = get_post_meta($post_id, '_preparation_time_minutes', true);
$cooking_time_hour = get_post_meta($post_id, '_cooking_time_hour', true);
$cooking_time_minutes = get_post_meta($post_id, '_cooking_time_minutes', true);
$total_time_hour = get_post_meta($post_id, '_total_time_hour', true);
$total_time_minutes = get_post_meta($post_id, '_total_time_minutes', true);
$serving = get_post_meta($post_id, '_serving', true);
$cuisine = get_post_meta($post_id, '_cuisine', true);
$recipe_notes = get_post_meta($post_id, '_recipe_notes', true);
$insipiration = get_post_meta($post_id, '_inspiration', true);
$ingredients = get_post_meta($post_id, '_ingredients', true);
$instructions = get_post_meta($post_id, '_instructions', true);
$embed_link = str_replace("watch?v=", "embed/", $video_link);

$post = get_post($post_id);
$author_id = $post->post_author;
// First priority: user_meta 'name'
$name = get_user_meta($author_id, 'name', true);

// Fallback to display_name if 'name' is empty
if (empty($name)) {
    $name = get_the_author_meta('display_name', $author_id);
}
$location = get_user_meta($author_id, 'location', true);
$user_image = get_user_meta($author_id, 'user_image', true);



$prep_time = null;
$cooking_time = null;
$total_time = null;
$terms = get_the_terms(get_the_ID(), 'recipe_category');

if (!is_wp_error($terms) && !empty($terms)) {
    $category_names = wp_list_pluck($terms, 'name'); // extract names only
    $formatted_category = implode(', ', $category_names); // comma-separated
} else {
    $formatted_category = 'Uncategorized';
}
$prep_time .= $prep_time_hour ? "$prep_time_hour hour" . ($prep_time_hour > 1 ? 's' : '') : '';
$prep_time .= $prep_time_minutes ? ($prep_time ? ' ' : '') . "$prep_time_minutes minute" . ($prep_time_minutes > 1 ? 's' : '') : '';
$cooking_time .= $cooking_time_hour ? "$cooking_time_hour hour" . ($cooking_time_hour > 1 ? 's' : '') : '';
$cooking_time .= $cooking_time_minutes ? ($cooking_time ? ' ' : '') . "$cooking_time_minutes minute" . ($cooking_time_minutes > 1 ? 's' : '') : '';
$total_time .= $total_time_hour ? "$total_time_hour hour" . ($total_time_hour > 1 ? 's' : '') : '';
$total_time .= $total_time_minutes ? ($total_time ? ' ' : '') . "$total_time_minutes minute" . ($total_time_minutes > 1 ? 's' : '') : '';
?>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<style>
    .top-header-title-part {
        width: 100%;
        height: 450px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
    }


    .top-header-title-part h1 {

        font-size: 48px;
        font-weight: 700;

        letter-spacing: 0.02em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: white;
    }

    .top-header-title-part button {
        background: rgba(255, 59, 59, 1);
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 600;
        line-height: 24px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        padding: 15px 28px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
    }

    .container-part {
        padding: 30px 5%;
        width: 90%;
    }

    .container-part-inner {
        width: 90%;
    }

    .image-part img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .author-profile-part h3.name {
        font-size: 24px;
        font-weight: 600;
        line-height: 30px;
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);

    }

    .author-profile-part h4.location {
        font-size: 16px;
        font-weight: 400;
        line-height: 20px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;

        color: rgba(102, 102, 102, 1);

    }

    .author-profile-part .button-part button {
        margin: 0px 10px;
        font-size: 16px;
        font-weight: 600;
        line-height: 24px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        background: rgba(255, 59, 59, 1);
        color: rgba(255, 255, 255, 1);
        border-radius: 100px;
        border: none;
        padding: 10px 25px;


    }

    .container-heading {
        font-size: 48px;
        font-weight: 700;
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);
        margin: 30px 0px;
    }

    p.description {
        color: rgba(102, 102, 102, 1);
        font-size: 18px;
        font-weight: 400;
        line-height: 28px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;

    }

    .after-author-meta {
        background-color: rgba(248, 247, 246, 1);
        border-radius: 12px;
        padding: 30px;
    }

    .after-author-meta h4.meta-name {
        font-size: 20px;
        font-weight: 600;
        line-height: 30px;
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);

    }

    .after-author-meta h5.meta-value {
        font-family: Poppins;
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(102, 102, 102, 1);

    }

    .after-author-meta hr {
        color: rgba(171, 167, 167, 1);
        margin: 30px 0px;
    }

    .after-author-meta a {
        font-size: 18px;
        font-weight: 500;
        line-height: 28px;
        letter-spacing: 0.01em;
        text-align: center;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(102, 102, 102, 1);

    }

    .jump_to_recipe {
        font-size: 18px;
        font-weight: 600;
        line-height: 24px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        background-color: rgba(255, 59, 59, 1);
        color: white;
        padding: 16px 32px;
        border: none;

    }

    .jump_to_recipe:hover {
        background-color: rgba(255, 59, 59, 1);

    }

    .ingredients_part {
        /* border: 1px solid red; */
        overflow: hidden;
    }

    .ingredients_part h1 {
        font-size: 48px;
        font-weight: 700;
        /* line-height: 60px; */
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);
    }

    .ingredients_part h3 {
        font-size: 36px;
        font-weight: 600;
        /* line-height: 60px; */
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);
    }

    .ingredients_part p {
        font-size: 18px;
        font-weight: 400;
        line-height: 28px;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(102, 102, 102, 1);

    }



    .reviews .reviews-inner {
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 12px;
        padding: 15px 35px;
        margin-top: 50px;
    }

    .reviews .reviews-inner h3 {
        font-size: 36px;
        font-weight: 600;
        line-height: 60px;
        letter-spacing: 0.01em;
        text-align: left;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
        color: rgba(48, 48, 48, 1);
    }

    /* form */


    .review-form {
        margin: 0 auto;
        font-family: Arial, sans-serif;
    }

    .review-form h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    /* Styling for the star rating system */

    .rating-group .stars {
        display: flex;
        gap: 5px;
        flex-direction: row-reverse;
        justify-content: start;

    }

    .rating-group input {
        display: none;
    }

    .rating-group label {
        font-size: 1.5rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    /* Highlight stars from left to right */
    .rating-group input:checked~label {
        color: #ddd;
    }

    .rating-group .stars label:hover,
    .rating-group .stars label:hover~label,
    .rating-group .stars input:checked+label,
    .rating-group .stars input:checked+label~label {
        color: #ffcc00;
    }

    textarea {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        resize: none;
    }

    .form-actions {
        display: flex;
        justify-content: end;
        margin-top: 1rem;
    }

    .btn-cancel,
    .btn-submit {
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-cancel {
        background-color: #f0f0f0;
        color: #333;
    }

    .btn-submit {
        background-color: #ff4d4d;
        color: white;
    }

    .btn-cancel:hover {
        background-color: #e0e0e0;
    }

    .btn-submit:hover {
        background-color: #e04343;
    }

    .askfrom_comunity-inner {
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 12px;
        padding: 30px;
    }

    .askfrom_comunity-inner h3 {
        font-size: 48px;
        font-weight: 700;
        color: rgba(48, 48, 48, 1);
    }

    .footerbuttoncontainer {
        display: flex;
        gap: 30px;
        justify-content: right;
    }

    .footerbuttoncontainer #rejectbutton {
        border: 1px solid rgba(255, 59, 59, 1);
        color: rgba(255, 59, 59, 1);
        background: #0000;
        border-radius: 100px;
        background-color: rgba(255, 59, 59, 1);
        border: none;
        padding: 15px 30px;
        color: rgba(255, 255, 255, 1);
        font-size: 22px;
        font-weight: 600;

    }

    .footerbuttoncontainer #approvebutton {

        border-radius: 100px;
        background-color: green;
        border: none;
        padding: 15px 30px;
        color: rgba(255, 255, 255, 1);
        font-size: 22px;
        font-weight: 600;

    }

    @media(max-width:767px) {
        .container-part {
            padding: 10px 5%;
            width: 95%;
        }

        .container-part-inner {
            width: 100%;
        }

        .top-header-title-part {
            padding: 10px;
        }

        .top-header-title-part h1 {
            font-size: 24px;
            text-align: center;
        }

        .top-header-title-part button {
            font-size: 14px;
        }

        .container-heading {
            font-size: 24px;
        }

        .author-profile-part .button-part button {
            padding: 5px 15px;
            font-size: 14px;
        }

        .jump_to_recipe {
            font-size: 18px;
            padding: 5px 15px;
        }

        hr.mt-4 {
            display: none;
        }

        .ingredients_part h1 {
            font-size: 24px;
        }

        .ingredients_part h3 {
            font-size: 24px;
        }
    }
</style>

<div class="top-header-title-part" style="background-image: url(' <?php echo esc_url($dish_photo) ?>  ');">
    <div>
        <?php
        echo '<h1>' . esc_html($post->post_title) . '</h1>';
        ?>

    </div>
    <div>
        <button>
            <span> Add To Favorite </span> <svg width="17" height="17" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.3671 3.84166C16.9415 3.41583 16.4361 3.07803 15.8799 2.84757C15.3237 2.6171 14.7275 2.49847 14.1254 2.49847C13.5234 2.49847 12.9272 2.6171 12.371 2.84757C11.8147 3.07803 11.3094 3.41583 10.8838 3.84166L10.0004 4.725L9.11709 3.84166C8.25735 2.98192 7.09128 2.49892 5.87542 2.49892C4.65956 2.49892 3.4935 2.98192 2.63376 3.84166C1.77401 4.70141 1.29102 5.86747 1.29102 7.08333C1.29102 8.29919 1.77401 9.46525 2.63376 10.325L3.51709 11.2083L10.0004 17.6917L16.4838 11.2083L17.3671 10.325C17.7929 9.89937 18.1307 9.39401 18.3612 8.83779C18.5917 8.28158 18.7103 7.6854 18.7103 7.08333C18.7103 6.48126 18.5917 5.88508 18.3612 5.32887C18.1307 4.77265 17.7929 4.26729 17.3671 3.84166Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

        </button>
    </div>

</div>
<div class="container-part">
    <?php if ($video_link) { ?>
        <div class="media-container">

            <h2 class="container-heading">

                Media
            </h2>

            <div>
                <iframe width="100%" height="315"
                    src="<?php echo $embed_link;  ?>"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    <?php } ?>
    <div class="container-part-inner">
        <div class="description-container">
            <h2 class="container-heading">
                Description
            </h2>
            <p class="description">
                <?php the_content(); ?>
            </p>
        </div>

        <div class="author-profile-part row">
            <div class="col-md-6">
                <div class="image-part d-flex gap-3 ">
                    <div>
                        <img src="<?php echo $user_image;  ?>" alt="">
                    </div>
                    <div>
                        <h3 class="name">
                            <?php echo $author_name; ?>
                        </h3>
                        <h4 class="location">
                            <?php echo $location; ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <div class="button-part d-flex justify-content-end align-items-center ">
                    <button> VIew Profile</button>
                    <button> Add To Favorite</button>
                </div>
            </div>
        </div>

        <div class="after-author-meta mt-2">
            <div class="row">
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Category</h4>
                    <h5 class="meta-value"><?php echo esc_html($formatted_category); ?></h5>
                </div>
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Prep Time</h4>
                    <h5 class="meta-value"><?php echo esc_html($prep_time);   ?></h5>
                </div>
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Cook Time</h4>
                    <h5 class="meta-value"><?php echo esc_html($cooking_time);  ?></h5>
                </div>
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Total Time</h4>
                    <h5 class="meta-value"><?php echo esc_html($total_time);  ?></h5>
                </div>

            </div>
            <div class="row">
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Cuisine</h4>
                    <h5 class="meta-value"><?php echo esc_html($cuisine);  ?></h5>
                </div>
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Serving</h4>
                    <h5 class="meta-value"><?php echo esc_html($serving);  ?> People</h5>
                </div>
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Cook Time</h4>
                    <h5 class="meta-value"><?php echo esc_html($cooking_time);  ?></h5>
                </div>
                <div class="col-6 col-md-3">
                    <h4 class="meta-name">Total Time</h4>
                    <h5 class="meta-value"><?php echo esc_html($total_time);  ?></h5>
                </div>

            </div>

            <hr>
            <div class="d-flex justify-content-center">

                <a href="">Jump to Nutrition Facts</a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-4 ">
                <hr class="mt-4">
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center">
                <button class="jump_to_recipe">Jump To Recipe</button>
            </div>
            <div class="col-4">
                <hr class="mt-4">
            </div>

        </div>

        <div class="ingredients_part">
            <h1>How to make <?php echo esc_html($post->post_title); ?> </h1>
            <p>You'll find a detailed ingredient list and step-by-step instructions in the recipe below, but let's go over the basics:</p>
            <h3>Ingredients</h3>
            <div class="ingredients_inner">
                <?php
                echo $ingredients;

                ?>



            </div>

            <h3 class="mt-5">Steps</h3>
            <p>Next, follow the steps to finalize your dish and finally be able to enjoy it!</p>

            <div class="steps_inner">
                <?php
                echo $instructions;
                ?>




            </div>

        </div>


        <div class="nutrition_facts"></div>
        <?php if (!current_user_can('editor') && !current_user_can('administrator')) : ?>
            <div class="reviews_container">
                <div class="row mt-5">
                    <div class="col-4 ">
                        <hr class="mt-4">
                    </div>
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <button class="jump_to_recipe">I Made It</button>
                    </div>
                    <div class="col-4">
                        <hr class="mt-4">
                    </div>

                </div>
                <!-- <div class="askfrom_comunity">
                    <div class="askfrom_comunity-inner mt-5">
                        <h3>Ask the Community (10)</h3>
                        <h4>Pending Task</h4>
                        <form>

                        </form>


                    </div>
                </div> -->
                <div class="reviews">
                    <?php
                    $comments = get_comments(['post_id' => get_the_ID()]);
                    $total_reviews = count($comments); // Count total comments

                    $total_rating = 0;
                    $rating_count = 0;

                    foreach ($comments as $comment) {
                        $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                        if ($rating) {
                            $total_rating += $rating;
                            $rating_count++;
                        }
                    }

                    // Calculate average rating
                    $average_rating = ($rating_count > 0) ? round($total_rating / $rating_count, 1) : 0;
                    ?>

                    <h2 class="container-heading">Reviews <?php echo number_format($total_reviews); ?>(<?php echo $average_rating; ?>)</h2>
                    <p>Check out our Community Guidelines about reviews.</p>

                    <div class="reviews-inner">
                        <!-- <h3>Apple Pie by Grandma Ople</h3> -->

                        <?php $comments = get_comments(['post_id' => $post_id, 'status' => 'approve']);
                        if (empty($comments)) {
                        ?>

                            <div class="review-form">
                                <form method="post" id="recipe-review-form">
                                    <div class="form-group rating-group">
                                        <label for="rating">Rating:</label>

                                        <div class="stars">
                                            <input type="radio" id="star5" name="rating" value="5" required />
                                            <label for="star5" title="5 stars">★</label>

                                            <input type="radio" id="star4" name="rating" value="4" required />
                                            <label for="star4" title="4 stars">★</label>

                                            <input type="radio" id="star3" name="rating" value="3" required />
                                            <label for="star3" title="3 stars">★</label>

                                            <input type="radio" id="star2" name="rating" value="2" required />
                                            <label for="star2" title="2 stars">★</label>

                                            <input type="radio" id="star1" name="rating" value="1" required />
                                            <label for="star1" title="1 star">★</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Review:</label>
                                        <textarea
                                            name="comment"
                                            id="comment"
                                            rows="4"
                                            placeholder="A brief introduction or description of the recipe (e.g., its origin, flavor profile, or personal story behind it)"
                                            required></textarea>
                                    </div>
                                    <div class="form-actions">
                                        <button type="button" class="btn-cancel mx-2">Cancel</button>
                                        <button type="submit" class="btn-submit">Submit</button>
                                    </div>
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
                                    <input type="hidden" name="comment_parent" value="0" />
                                </form>
                            </div>

                        <?php } ?>
                        <div>
                            <?php
                            // Fetch existing comments (reviews) for the current post
                            $comments = get_comments(['post_id' => $post_id, 'status' => 'approve']);
                            if (!empty($comments)) {
                                foreach ($comments as $comment) {
                                    $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                                    $author_id = $comment->user_id;
                                    $user_image = get_user_meta($author_id, 'user_image', true);

                            ?>
                                    <div class="review">

                                        <div class="image-part d-flex gap-3 ">
                                            <div>
                                                <img src="<?php echo $user_image;  ?>" alt="">
                                            </div>
                                            <div class="mx-2">
                                                <p class="name" style="margin-bottom: -5px;">
                                                    <?php echo esc_html($comment->comment_author);  ?>
                                                </p>

                                                <p><?php echo str_repeat('⭐', (int)$rating); ?></p>


                                            </div>
                                        </div>

                                        <p><?php echo esc_html($comment->comment_content); ?></p>
                                    </div>
                                    <hr>
                            <?php
                                }
                            } else {
                                echo '<p class="mt-2">No reviews yet. Be the first to leave a review!</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (current_user_can('editor') && get_post_status($post_id) !== 'publish') : ?>

            <div class="editor-side-container mt-5">
                <hr>
                <div class=" footerbuttoncontainer">
                    <div>

                        <button type="button" id="rejectbutton" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject Recipe</button>
                    </div>
                    <div>

                        <button type="button" id="approvebutton" data-post-id="<?php echo esc_attr($post_id); ?>">Approve Recipe</button>

                    </div>

                </div>
            </div>


            <div class="modal fade " id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <form id="reject-recipe-form">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel">Reject Recipe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="reject_reason">Reason for Rejection:</label>
                                <textarea name="reason" id="reject_reason" class="form-control" required></textarea>
                                <input type="hidden" name="post_id" id="reject_post_id" value="<?php echo esc_attr($post_id); ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



        <?php endif; ?>

        <?php if (current_user_can('administrator') && $author_id == get_current_user_id()) :
            $subscribers = get_users(['role' => 'subscriber']);

        ?>
            <div class="mt-3">
                <hr>
                <form id="assign-recipe-form">
                    <label for="new_author">Assign Recipe to:</label>
                    <select id="new_author" name="new_author">
                        <option value="">Select a subscriber</option>
                        <?php foreach ($subscribers as $user) : ?>
                            <option value="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html($user->display_name); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
                  

                    <button type="submit" class="mt-2" >Assign Recipe</button>
                </form>
            </div>

        <?php endif; ?>
    </div>

</div>


<?php get_footer(); ?>