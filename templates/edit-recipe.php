<?php

/*
Template Name: Add Recipe
*/
if (! defined('ABSPATH')) {
    exit;
}
get_header();
wp_head();


$post_id = $_GET['post'] ?? 0;
$post = get_post($post_id);
$title = get_the_title($post_id);
$description = apply_filters('the_content', $post->post_content);
$plain_text_description = wp_strip_all_tags($description);


$dish_photo = get_post_meta($post_id, '_dish_photo', true);
$video_link = get_post_meta($post_id, '_video_link', true);
$catagory = get_post_meta($post_id, '_recipe_category', true);
$prep_time = get_post_meta($post_id, '_preparation_time', true);
$cooking_time = get_post_meta($post_id, '_cooking_time', true);
$total_time = get_post_meta($post_id, '_total_time', true);
$serving = get_post_meta($post_id, '_serving', true);
$cuisine = get_post_meta($post_id, '_cuisine', true);
$recipe_notes = get_post_meta($post_id, '_recipe_notes', true);
$unique_confirm = get_post_meta($post_id, '_unique_confirm', true);
$insipiration = get_post_meta($post_id, '_inspiration', true);
$ingredients = get_post_meta($post_id, '_ingredients', true);
$instructions = get_post_meta($post_id, '_instructions', true);
error_log(json_encode($instructions));
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="ingredients-container">
                <label for="">Ingredients</label>
                <div class="ingredients-container-inner">
                    <div class="ingredients-container-inner-input row">
                        <?php

                        if (!empty($ingredients) && is_array($ingredients)) {
                            foreach ($ingredients as $index => $ingredient) {
                                $name = esc_attr($ingredient['name']); // Escape the name
                                $unit = esc_attr($ingredient['unit']); // Escape the unit
                        ?>
                                <div class="col-md-6">
                                    <input type="text" name="ingredients[<?php echo $index; ?>][name]" placeholder="Add Ingredients" value="<?php echo $name; ?>">
                                </div>
                                <div class="col-md-6">
                                    <select name="ingredients[<?php echo $index; ?>][unit]">
                                        <option value="gram" <?php selected($unit, 'gram'); ?>>Gram</option>
                                        <option value="Celsius" <?php selected($unit, 'Celsius'); ?>>Celsius</option>
                                        <option value="Cm" <?php selected($unit, 'Cm'); ?>>Cm</option>
                                    </select>
                                </div>
                            <?php
                            }
                        } else {
                            // If no ingredients exist, display a single empty input
                            ?>
                            <div class="col-md-6">
                                <input type="text" name="ingredients[0][name]" placeholder="Add Ingredients">
                            </div>
                            <div class="col-md-6">
                                <select name="ingredients[0][unit]">
                                    <option value="gram">Gram</option>
                                    <option value="Celsius">Celsius</option>
                                    <option value="Cm">Cm</option>
                                </select>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="ingredients-container-inner-button-container">
                        <div>
                            <button type="button" id="add-ingredient">+ Add New Ingredient</button>
                        </div>
                        <div>
                            <img src="<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/3.png'); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="ingredients-container recipe-instructions">
                <label for="">Recipe Instructions</label>
                <div class="ingredients-container-inner recipe-instruction-inner">
                    <div class="recipe-instructions-container">
                        <?php
                        // Fetch instructions data from the meta
                        $instructions = get_post_meta($post_id, '_instructions', true);

                        if (!empty($instructions) && is_array($instructions)) {
                            foreach ($instructions as $index => $instruction) {
                                $text = esc_textarea($instruction['text']); // Escape the text
                                $image = esc_url($instruction['image']); // Escape the image URL
                        ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="photo-upload">
                                            <img src="<?php echo $image ? $image : 'https://img.icons8.com/ios/50/000000/camera--v1.png'; ?>" alt="Instruction Image">
                                            <?php if (!$image): ?>
                                                <span class="span">Add Photo</span>
                                            <?php endif; ?>

                                            <input name="instructions[<?php echo $index; ?>][image]" type="file" accept="image/*">

                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="instructions[<?php echo $index; ?>][text]" placeholder="Instruction text"><?php echo $text; ?></textarea>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            // If no instructions exist, display a single empty block
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="photo-upload">
                                        <img src="https://img.icons8.com/ios/50/000000/camera--v1.png" alt="Camera Icon">
                                        <span class="span">Add Photo</span>
                                        <input name="instructions[0][image]" type="file" accept="image/*">
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <textarea name="instructions[0][text]" placeholder="Instruction text"></textarea>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="ingredients-container-inner-button-container">
                        <div>
                            <button type="button" id="add-new-instruction">+ Add New Instructions</button>
                        </div>
                        <div>
                            <img src="<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/4.png'); ?>" alt="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="recipe_category"> Recipe Category </label>
                    <select name="recipe_category" id="recipe_category">
                        <option value="healthy_nutritious" <?php selected($catagory, 'healthy_nutritious'); ?>>Healthy & Nutritious</option>
                        <option value="quick_easy" <?php selected($catagory, 'quick_easy'); ?>>Quick & Easy</option>
                        <option value="comfort_food" <?php selected($catagory, 'comfort_food'); ?>>Comfort Food</option>
                        <option value="vegetarian_vegan" <?php selected($catagory, 'vegetarian_vegan'); ?>>Vegetarian & Vegan</option>
                        <option value="gluten_free" <?php selected($catagory, 'gluten_free'); ?>>Gluten-Free</option>
                        <option value="low_carb_keto" <?php selected($catagory, 'low_carb_keto'); ?>>Low-Carb & Keto</option>
                        <option value="desserts_sweets" <?php selected($catagory, 'desserts_sweets'); ?>>Desserts & Sweets</option>
                        <option value="breakfast_brunch" <?php selected($catagory, 'breakfast_brunch'); ?>>Breakfast & Brunch</option>
                        <option value="snacks_appetizers" <?php selected($catagory, 'snacks_appetizers'); ?>>Snacks & Appetizers</option>
                        <option value="special_occasions_holidays" <?php selected($catagory, 'special_occasions_holidays'); ?>>Special Occasions & Holidays</option>
                        <option value="one_pot_slow_cooker" <?php selected($catagory, 'one_pot_slow_cooker'); ?>>One-Pot & Slow Cooker</option>
                        <option value="meal_prep_make_ahead" <?php selected($catagory, 'meal_prep_make_ahead'); ?>>Meal Prep & Make-Ahead</option>
                        <option value="kid_friendly" <?php selected($catagory, 'kid_friendly'); ?>>Kid-Friendly</option>
                        <option value="juices_smoothies" <?php selected($catagory, 'juices_smoothies'); ?>>Juices & Smoothies</option>
                        <option value="active_lifestyle_meals" <?php selected($catagory, 'active_lifestyle_meals'); ?>>Active Lifestyle Meals</option>
                    </select>

                </div>
                <div class="col-md-6">
                    <label for="cuisine">Cuisine </label>
                    <select name="cuisine" id="Cuisine">
                        <option value="american" <?php selected($cuisine, 'american'); ?>>American</option>
                        <option value="argentinian" <?php selected($cuisine, 'argentinian'); ?>>Argentinian</option>
                        <option value="australian_new_zealander" <?php selected($cuisine, 'australian_new_zealander'); ?>>Australian and New Zealander</option>
                        <option value="austrian" <?php selected($cuisine, 'austrian'); ?>>Austrian</option>
                        <option value="bangladeshi" <?php selected($cuisine, 'bangladeshi'); ?>>Bangladeshi</option>
                        <option value="belgian" <?php selected($cuisine, 'belgian'); ?>>Belgian</option>
                        <option value="brazilian" <?php selected($cuisine, 'brazilian'); ?>>Brazilian</option>
                        <option value="canadian" <?php selected($cuisine, 'canadian'); ?>>Canadian</option>
                        <option value="chilean" <?php selected($cuisine, 'chilean'); ?>>Chilean</option>
                        <option value="chinese" <?php selected($cuisine, 'chinese'); ?>>Chinese</option>
                        <option value="colombian" <?php selected($cuisine, 'colombian'); ?>>Colombian</option>
                        <option value="cuban" <?php selected($cuisine, 'cuban'); ?>>Cuban</option>
                        <option value="danish" <?php selected($cuisine, 'danish'); ?>>Danish</option>
                        <option value="dutch" <?php selected($cuisine, 'dutch'); ?>>Dutch</option>
                        <option value="filipino" <?php selected($cuisine, 'filipino'); ?>>Filipino</option>
                        <option value="finnish" <?php selected($cuisine, 'finnish'); ?>>Finnish</option>
                        <option value="french" <?php selected($cuisine, 'french'); ?>>French</option>
                        <option value="german" <?php selected($cuisine, 'german'); ?>>German</option>
                        <option value="greek" <?php selected($cuisine, 'greek'); ?>>Greek</option>
                        <option value="indian" <?php selected($cuisine, 'indian'); ?>>Indian</option>
                        <option value="indonesian" <?php selected($cuisine, 'indonesian'); ?>>Indonesian</option>
                        <option value="israeli" <?php selected($cuisine, 'israeli'); ?>>Israeli</option>
                        <option value="italian" <?php selected($cuisine, 'italian'); ?>>Italian</option>
                        <option value="jamaican" <?php selected($cuisine, 'jamaican'); ?>>Jamaican</option>
                        <option value="japanese" <?php selected($cuisine, 'japanese'); ?>>Japanese</option>
                        <option value="jewish" <?php selected($cuisine, 'jewish'); ?>>Jewish</option>
                        <option value="korean" <?php selected($cuisine, 'korean'); ?>>Korean</option>
                        <option value="lebanese" <?php selected($cuisine, 'lebanese'); ?>>Lebanese</option>
                        <option value="malaysian" <?php selected($cuisine, 'malaysian'); ?>>Malaysian</option>
                        <option value="mexican" <?php selected($cuisine, 'mexican'); ?>>Mexican</option>
                        <option value="norwegian" <?php selected($cuisine, 'norwegian'); ?>>Norwegian</option>
                        <option value="pakistani" <?php selected($cuisine, 'pakistani'); ?>>Pakistani</option>
                        <option value="persian" <?php selected($cuisine, 'persian'); ?>>Persian</option>
                        <option value="peruvian" <?php selected($cuisine, 'peruvian'); ?>>Peruvian</option>
                        <option value="polish" <?php selected($cuisine, 'polish'); ?>>Polish</option>
                        <option value="portuguese" <?php selected($cuisine, 'portuguese'); ?>>Portuguese</option>
                        <option value="puerto_rican" <?php selected($cuisine, 'puerto_rican'); ?>>Puerto Rican</option>
                        <option value="russian" <?php selected($cuisine, 'russian'); ?>>Russian</option>
                        <option value="scandinavian" <?php selected($cuisine, 'scandinavian'); ?>>Scandinavian</option>
                        <option value="south_african" <?php selected($cuisine, 'south_african'); ?>>South African</option>
                        <option value="spanish" <?php selected($cuisine, 'spanish'); ?>>Spanish</option>
                        <option value="swedish" <?php selected($cuisine, 'swedish'); ?>>Swedish</option>
                        <option value="swiss" <?php selected($cuisine, 'swiss'); ?>>Swiss</option>
                        <option value="thai" <?php selected($cuisine, 'thai'); ?>>Thai</option>
                        <option value="turkish" <?php selected($cuisine, 'turkish'); ?>>Turkish</option>
                        <option value="vietnamese" <?php selected($cuisine, 'vietnamese'); ?>>Vietnamese</option>
                    </select>

                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <label> Preparation Time (In Minutes) </label>
                    <input type="number" name="preparation_time" value="<?php echo esc_html($prep_time); ?>" placeholder="15 minutes">
                </div>
                <div class="col-md-6">
                    <label> Cooking Time (In Minutes) </label>
                    <input type="number" name="cooking_time" value="<?php echo esc_html($cooking_time); ?>" placeholder="The time required to cook the recipe">
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <label> Total Time (In Minutes) </label>
                    <input type="number" name="total_time" value="<?php echo esc_html($total_time); ?>" placeholder="20 minutes">
                </div>
                <div class="col-md-6">
                    <label> Serving </label>
                    <input type="number" name="serving" value="<?php echo esc_html($serving); ?>" placeholder="20 minutes">
                </div>
            </div>

            <div>
                <label> Recipe Notes (Optional)
                </label>
                <textarea name="recipe_notes" id=""> <?php echo esc_html($recipe_notes); ?></textarea>
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
        const addButton = document.getElementById('add-ingredient');
        const inputContainer = document.querySelector('.ingredients-container-inner-input');
        let ingredientCount = inputContainer.querySelectorAll('input[name^="ingredients"]').length;
        addButton.addEventListener('click', function() {
            const newinstructionblocks = `
                              <div class="col-md-6">

                            <input type="text" name="ingredients[${ingredientCount}][name]" placeholder="Add Ingredients">
                        </div>
                        <div class="col-md-6">
                            <select name="ingredients[${ingredientCount}][unit]" >
                                <option value="gram">Gram</option>
                                <option value="Celsius">Celsius</option>
                                <option value="Cm">Cm</option>                            </select>

                        </div>
         `;

            inputContainer.insertAdjacentHTML('beforeend', newinstructionblocks);

            // Increment the counter for the next instruction
            ingredientCount++;

        });

        const addInstructionButton = document.getElementById('add-new-instruction');
        const instructionsContainer = document.querySelector('.recipe-instructions-container');
        let instructionCount = instructionsContainer.querySelectorAll('.row').length;

        addInstructionButton.addEventListener('click', function() {
            // Define the HTML block to be added
            const newInstructionBlock = `
        <div class="row">
            <div class="col-md-4">
                <label class="photo-upload">
                    <img src="https://img.icons8.com/ios/50/000000/camera--v1.png" alt="Camera Icon">
                    <span class="span">Add Photo</span>
                    <input type="file" name="instructions[${instructionCount}][image]" accept="image/*">
                </label>
            </div>
            <div class="col-md-8">
                <textarea name="instructions[${instructionCount}][text]" placeholder="Instruction text"></textarea>
            </div>
        </div>
    `;

            // Add the new block to the instructions container
            instructionsContainer.insertAdjacentHTML('beforeend', newInstructionBlock);

            // Increment the counter for the next instruction
            instructionCount++;


        });


        // Event delegation for handling image previews
        instructionsContainer.addEventListener('change', function(event) {
            const input = event.target;

            // Check if the changed element is a file input
            if (input.type === 'file' && input.accept.includes('image/*')) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Find the closest <img> element and update its src
                        const previewImg = input.closest('.photo-upload').querySelector('img');
                        const span = input.closest('.photo-upload').querySelector('.span');
                        if (span) {
                            span.style.display = 'none';
                        }
                        if (previewImg) {
                            previewImg.src = e.target.result;
                        }
                    };

                    reader.readAsDataURL(input.files[0]); // Read the file as a data URL
                }
            }
        });
    });






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
</script>


<?php get_footer(); ?>