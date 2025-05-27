<?php

/*
Template Name: Edit Recipe
*/
if (! defined('ABSPATH')) {
    exit;
}
// wp_head();
get_header();


$post_id = $_GET['post'] ?? 0;
$post = get_post($post_id);
$title = get_the_title($post_id);
$description = apply_filters('the_content', $post->post_content);
$plain_text_description = wp_strip_all_tags($description);


$dish_photo = get_post_meta($post_id, '_dish_photo', true);
$video_link = get_post_meta($post_id, '_video_link', true);
// $catagory = get_post_meta($post_id, '_recipe_category', true);
$preparation_time_hour = get_post_meta($post_id, '_preparation_time_hour', true);
$preparation_time_minutes = get_post_meta($post_id, '_preparation_time_minutes', true);
$cooking_time_hour = get_post_meta($post_id, '_cooking_time_hour', true);
$cooking_time_minutes = get_post_meta($post_id, '_cooking_time_minutes', true);
$total_time_hour = get_post_meta($post_id, '_total_time_hour', true);
$total_time_minutes = get_post_meta($post_id, '_total_time_minutes', true);

$serving = get_post_meta($post_id, '_serving', true);
$cuisine = get_post_meta($post_id, '_cuisine', true);
$recipe_notes = get_post_meta($post_id, '_recipe_notes', true);
$unique_confirm = get_post_meta($post_id, '_unique_confirm', true);
$insipiration = get_post_meta($post_id, '_inspiration', true);
$ingredients = get_post_meta($post_id, '_ingredients', true);
$instructions = get_post_meta($post_id, '_instructions', true);

?>
<script src="https://cdn.tiny.cloud/1/e7j9amg1yznezj5u8xskqm6hbzmpgonvzfmzivqqofxu3jhc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .add-recipe-top-header {
        width: 100%;
        height: 450px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url("<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/add-recipe-headerbg.png'); ?>") no-repeat center center;
        background-size: cover;
    }

    .add-recipe-top-header {
        font-family: Poppins;
        font-size: 64px;
        font-weight: 700;
        color: #ffffff;

    }

    .add-recipe-form {
        padding: 100px;

    }

    .add-recipe-form-first-part {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .add-recipe-form-first-part img {
        height: 130px;
        width: 130px;
    }

    .add-recipe-form-first-part h2 {
        font-size: 48px;
        font-weight: 700;
        color: rgba(48, 48, 48, 1);
    }

    .add-recipe-form-second-part p {
        font-size: 18px;
        font-weight: 400;
        line-height: 40px;
        color: rgba(102, 102, 102, 1);
    }

    .add-recipe-form-second-part span {
        font-size: 18px;
        font-weight: 600;
        line-height: 40px;
    }

    .add-recipe-form-inner {
        padding: 50px;
    }



    .add-recipe-form-inner select {
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 100px;
        padding: 15px;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        color: rgba(102, 102, 102, 1);
    }




    .add-recipe-form-inner .ingredients-container .ingredients-container-inner {
        padding: 40px;
        padding-bottom: 0px;
        background-color: rgba(248, 247, 246, 1);
        border-radius: 16px;
    }

    .add-recipe-form-inner .ingredients-container .ingredients-container-inner .ingredients-container-inner-button-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0px;

    }

    .add-recipe-form-inner .ingredients-container .ingredients-container-inner .ingredients-container-inner-input input {
        margin: 10px 0px;

    }

    .add-recipe-form-inner .ingredients-container .ingredients-container-inner .ingredients-container-inner-input select {
        margin: 10px 0px;

    }

    .ingredients-container-inner-button-container button {
        border-radius: 100px;
        background-color: rgba(255, 59, 59, 1);
        border: none;
        padding: 15px 30px;
        color: rgba(255, 255, 255, 1);
        font-size: 22px;
        font-weight: 600;


    }

    .photo-upload {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 250px;
        height: 180px;
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 16px;
        cursor: pointer;
        margin: 0px !important;
        transition: border-color 0.3s ease;
        padding: 20px;
    }

    .photo-upload:hover {
        border-color: rgba(171, 167, 167, 1);
    }

    .photo-upload input[type="file"] {
        display: none;
    }

    .photo-upload img {

        max-width: 100%;
        max-height: 100%;


    }

    .photo-upload span {
        font-size: 16px;
        color: rgba(102, 102, 102, 1);
    }

    .recipe-instructions .recipe-instructions-container .row {

        margin: 15px 0px;
    }


    .recipe-instructions .recipe-instructions-container textarea {
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 16px;
        font-size: 16px;
        font-weight: 400;
        line-height: 22px;
        color: rgba(102, 102, 102, 1);
        height: 180px;
        width: 100%;
    }

    .input50width {
        display: flex;
        gap: 50px;

    }

    .input50width div {
        width: 100%;
    }

    .submitbuttoncontainer {
        display: flex;
        justify-content: space-between;
        align-items: end;
    }

    .footerbuttoncontainer {
        display: flex;
        gap: 30px;
    }

    .footerbuttoncontainer #cancelbutton {
        border: 1px solid rgba(255, 59, 59, 1);
        color: rgba(255, 59, 59, 1);
        background: #0000;
    }

    @media(max-width:767px) {
        .add-recipe-form {
            padding: 10px;

        }

        .add-recipe-form-inner {
            padding: 10px;
        }
    }
</style>

<div class="add-recipe-top-header">
    <div>
        <h2>Home > Recipe</h2>
    </div>


</div>

<div class="add-recipe-form">
    <div class="add-recipe-form-first-part">
        <div>
            <img src="<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/icon-right.png'); ?>" alt="">
        </div>
        <div style="padding:0px 50px;">
            <h2>Edit Recipe</h2>
        </div>
        <div>
            <img src="<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/icon-left.png'); ?>" alt="">

        </div>
    </div>
    <div class="add-recipe-form-second-part">
        <p>Recipe Submission Guidelines</p>
        <p>We’re excited to showcase your best go-to recipe! Please follow these simple guidelines when submitting your recipe:</p>
        <p><span>1. Original Recipes Only:</span> Submissions must be your own work. No copied content.</p>
        <p><span>2. Clear Instructions:</span> Provide complete ingredient lists with specific measurements and easy-to-follow steps.</p>
        <p><span>3. Photos: </span>Provide high-quality images of the finished dish. Please ensure they are your own.</p>
        <p><span>4. Helpful advice:</span> Offer helpful tips, advice, or ingredient substitutions to make the recipe more accessible to everyone.</p>
        <p><span>5. Personal Story:</span> Share the story behind your dish to make it more relatable and memorable.</p>
        <p><span>6. Respectful Content:</span> All submissions should be respectful and family-friendly. We reserve the right to remove inappropriate content.</p>
        <p>Recipes will be reviewed and may be edited for clarity. We’ll reach out if significant changes are needed.</p>
        <p>Thank you for sharing your delicious creations with <span>Go To Recipe!</span></p>
    </div>

    <div class="add-recipe-form-inner">
        <form id="edit_recipe" enctype="multipart/form-data" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <div class="row">
                <div class="col-md-8">
                    <label> Recipe Title </label>
                    <input type="text" name="title" id="title" value="<?php echo esc_html($title); ?>" placeholder="The name of the recipe">
                    <label for="">Recipe Description</label>
                    <textarea name="description"><?php echo esc_html($plain_text_description);
                                                    ?>
                    </textarea>

                </div>
                <div class="col-md-4 d-flex justify-content-end align-items-center  flex-column">
                    <label> Photo of the Dish </label>
                    <label class="photo-upload">
                        <img src="<?php echo esc_html($dish_photo); ?>" alt="Camera Icon" id="dish_photo_preview">
                        <?php if (!$dish_photo) { ?> <span class="span">Add Photo</span> <?php } ?>
                        <input name="dish_photo" id="dish_photo_input" type="file" accept="image/*">
                    </label>
                </div>
            </div>
            <div>
                <label> Video Link (Optional) </label>
                <input type="url" name="video_link" value="<?php echo esc_url($video_link); ?>" placeholder="https://www.youtube.com">
            </div>

            <label> Your Inspiration behind the dish </label>
            <input type="text" name="inspiration" value="<?php echo esc_html($insipiration); ?>" placeholder="Your Inspiration behind the dish">
            <script>
                tinymce.init({
                    selector: 'textarea.ingredients-editor',
                    plugins: [
                        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons',
                        'image', 'link', 'lists', 'media', 'searchreplace',
                        'table', 'visualblocks', 'wordcount'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                        'link image media table | numlist bullist indent outdent | ' +
                        'emoticons charmap | removeformat',
                    menubar: false,
                    branding: false,
                    height: 300
                });
            </script>
            <div class="ingredients-container">
                <label for="">Ingredients</label>
                <textarea class="ingredients-editor" name="ingredients">
                 <?php echo esc_html($ingredients); ?>
                </textarea>
            </div>

            <div class="ingredients-container recipe-instructions">
                <label for="">Recipe Instructions</label>
                <textarea class="ingredients-editor" name="instructions">
                <?php echo esc_html($instructions); ?>
                </textarea>

            </div>


            <div class="row">
                <div class="col-md-6">
                    <label> Preparation Time </label>
                    <div class="row">
                        <div class="col-6"> <input type="text" name="preparation_time_hour" placeholder="0 hour"  value="<?php echo esc_html($preparation_time_hour); ?>">
                        </div>
                        <div class="col-6"> <input type="text" name="preparation_time_minutes" placeholder="0 minutes" value="<?php echo esc_html($preparation_time_minutes); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label> Cooking Time </label>
                    <div class="row">
                        <div class="col-6"> <input type="text" name="cooking_time_hour" placeholder="0 hour"  value="<?php echo esc_html($cooking_time_hour); ?>">
                        </div>
                        <div class="col-6"> <input type="text" name="cooking_time_minutes" placeholder="0 minutes" value="<?php echo esc_html($cooking_time_minutes); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <label> Total Time </label>
                    <div class="row">
                        <div class="col-6"> <input type="text" name="total_time_hour" placeholder="0 hour"   value="<?php echo esc_html($total_time_hour); ?>">
                        </div>
                        <div class="col-6"> <input type="text" name="total_time_minutes" placeholder="0 minutes" value="<?php echo esc_html($total_time_minutes); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label> Serving </label>
                    <input type="number" name="serving" placeholder="5 People">
                </div>
            </div>
         

            <div>
                <label> Recipe Notes (Optional)
                </label>
                <textarea name="recipe_notes" > <?php echo esc_html($recipe_notes); ?></textarea>
            </div>
            <div class="submitbuttoncontainer row">
                <div class="col-md-6">


                    <div style="margin-bottom:50px;">

                        <!-- <input type="checkbox" name="formconfirm" id="confirm">
                        <label for="confirm" style="font-size:16px; font-weight:400;">I confirm that this recipe is my own genuine creation.</label> -->
                    </div>
                </div>
                <div class=" col-md-6 mt-3 ingredients-container-inner-button-container footerbuttoncontainer">
                    <div>

                        <button type="button" id="cancelbutton">Cancel</button>
                    </div>
                    <div>

                        <button type="submit" id="submitbutton">Update Recipe</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {





                document.getElementById('dish_photo_input').addEventListener('change', function(event) {
                    const input = event.target;
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const dish_photo_preview = document.getElementById('dish_photo_preview');

                            dish_photo_preview.src = e.target.result; // Set the preview image to the file's data URL

                        };

                        reader.readAsDataURL(input.files[0]); // Read the file as a data URL
                    }
                });

                jQuery(function($) {
                    $('#edit_recipe_category').select2({
                        placeholder: "Select Recipe Categories"
                    });
                });

            }
</script>


<?php  get_footer(); ?>