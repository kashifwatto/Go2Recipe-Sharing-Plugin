<?php

/*
Template Name: Add Recipe
*/
if (! defined('ABSPATH')) {
    exit;
}
get_header();
wp_head();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        font-size: 16px;
        font-weight: 400;
        line-height: 40px;
        color: rgba(102, 102, 102, 1);
    }

    .add-recipe-form-second-part span {
        font-size: 16px;
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




    /* .add-recipe-form-inner .ingredients-container .ingredients-container-inner {
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


    } */
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
        justify-content: right;
    }

    .footerbuttoncontainer #cancelbutton {
        border: 1px solid rgba(255, 59, 59, 1);
        color: rgba(255, 59, 59, 1);
        background: #0000;
    }

    input.select2-search__field {
        border: none !important;
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
            <h2>Add Recipe</h2>
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
        <form id="add_recipe" enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-md-8">
                    <label> Recipe Title </label>
                    <input type="text" name="title" id="title" placeholder="The name of the recipe">
                    <label for="">Recipe Description</label>
                    <textarea name="description" id="">A brief introduction or description of the recipe (e.g., its origin, flavor profile, or personal story behind it)</textarea>

                </div>
                <div class="col-md-4 d-flex justify-content-end align-items-center  flex-column">
                    <label> Photo of the Dish </label>
                    <label class="photo-upload">
                        <img src="https://img.icons8.com/ios/50/000000/camera--v1.png" alt="Camera Icon" id="dish_photo_preview">
                        <span class="span">Add Photo</span>
                        <input name="dish_photo" id="dish_photo_input" type="file" accept="image/*">
                    </label>
                </div>
            </div>
            <div>
                <label> Video Link (Optional) </label>
                <input type="url" name="video_link" placeholder="https://www.youtube.com">
            </div>

            <label> Your Inspiration behind the dish </label>
            <input type="text" name="inspiration" placeholder="Your Inspiration behind the dish">
            <div class="ingredients-container">
                <label for="">Ingredients</label>
                <script>
                    tinymce.init({
                        selector: 'textarea.ingredients-editor',
                        plugins: [
                            // Core editing features
                            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                            // Your account includes a free trial of TinyMCE premium features
                            // Try the most popular premium features until Apr 22, 2025:
                            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
                        ],
                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                        tinycomments_mode: 'embedded',
                        tinycomments_author: 'Author name',
                        mergetags_list: [{
                                value: 'First.Name',
                                title: 'First Name'
                            },
                            {
                                value: 'Email',
                                title: 'Email'
                            },
                        ],
                        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
                    });
                </script>
                <textarea class="ingredients-editor" name="ingredients">

</textarea>

            </div>
            <div class="ingredients-container recipe-instructions mt-3">
                <label for="">Recipe Instructions</label>
                <textarea class="ingredients-editor" name="instructions">

</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="recipe_category"> Recipe Category </label>
                    <?php $categories = get_option('custom_recipe_categories', []);
                    ?>
                    <select name="recipe_category[]" id="recipe_category" style="border:none !Important;" class="form-select form-select-solid"
                        data-control="select2" data-close-on-select="false" data-placeholder="Select a Category" data-allow-clear="true" multiple="multiple">

                        <?php foreach ($categories as $category):
                            // Generate value and label
                            $value = ucwords(str_replace('_', ' ', $category)); // e.g., 'Quick & Easy' => 'quick-easy'
                            $label = ucwords(str_replace('_', ' ', $category)); // Format for display
                        ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>


                </div>
                <div class="col-md-6">
                    <label for="cuisine">Cuisine </label>
                    <select name="cuisine" id="Cuisine">
                        <option value="american">American</option>
                        <option value="argentinian">Argentinian</option>
                        <option value="australian_new_zealander">Australian and New Zealander</option>
                        <option value="austrian">Austrian</option>
                        <option value="bangladeshi">Bangladeshi</option>
                        <option value="belgian">Belgian</option>
                        <option value="brazilian">Brazilian</option>
                        <option value="canadian">Canadian</option>
                        <option value="chilean">Chilean</option>
                        <option value="chinese">Chinese</option>
                        <option value="colombian">Colombian</option>
                        <option value="cuban">Cuban</option>
                        <option value="danish">Danish</option>
                        <option value="dutch">Dutch</option>
                        <option value="filipino">Filipino</option>
                        <option value="finnish">Finnish</option>
                        <option value="french">French</option>
                        <option value="german">German</option>
                        <option value="greek">Greek</option>
                        <option value="indian">Indian</option>
                        <option value="indonesian">Indonesian</option>
                        <option value="israeli">Israeli</option>
                        <option value="italian">Italian</option>
                        <option value="jamaican">Jamaican</option>
                        <option value="japanese">Japanese</option>
                        <option value="jewish">Jewish</option>
                        <option value="korean">Korean</option>
                        <option value="lebanese">Lebanese</option>
                        <option value="malaysian">Malaysian</option>
                        <option value="mexican">Mexican</option>
                        <option value="norwegian">Norwegian</option>
                        <option value="pakistani">Pakistani</option>
                        <option value="persian">Persian</option>
                        <option value="peruvian">Peruvian</option>
                        <option value="polish">Polish</option>
                        <option value="portuguese">Portuguese</option>
                        <option value="puerto_rican">Puerto Rican</option>
                        <option value="russian">Russian</option>
                        <option value="scandinavian">Scandinavian</option>
                        <option value="south_african">South African</option>
                        <option value="spanish">Spanish</option>
                        <option value="swedish">Swedish</option>
                        <option value="swiss">Swiss</option>
                        <option value="thai">Thai</option>
                        <option value="turkish">Turkish</option>
                        <option value="vietnamese">Vietnamese</option>
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <label> Preparation Time </label>
                    <div class="row">
                        <div class="col-6"> <input type="text" name="preparation_time_hour" placeholder="1 hour">
                        </div>
                        <div class="col-6"> <input type="text" name="preparation_time_minutes" placeholder="15 minutes">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label> Cooking Time </label>
                    <div class="row">
                        <div class="col-6"> <input type="text" name="cooking_time_hour" placeholder="1 hour">
                        </div>
                        <div class="col-6"> <input type="text" name="cooking_time_minutes" placeholder="15 minutes">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <label> Total Time </label>
                    <div class="row">
                        <div class="col-6"> <input type="text" name="total_time_hour" placeholder="1 hour">
                        </div>
                        <div class="col-6"> <input type="text" name="total_time_minutes" placeholder="15 minutes">
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
                <textarea name="recipe_notes" id=""> Any tips or variations the author wants to add (e.g., substitutions, helpful information, advice, or special instructions).</textarea>
            </div>
            <div class="submitbuttoncontainer row">
                <div class="col-md-6">


                    <div style="margin-bottom:50px;">

                        <input type="checkbox" name="formconfirm" id="confirm">
                        <label for="confirm" style="font-size:16px; font-weight:400;">I confirm that this recipe is my own genuine creation.</label>
                    </div>
                </div>
                <div class=" col-md-6 ingredients-container-inner-button-container footerbuttoncontainer">
                    <div>

                        <button type="button" id="cancelbutton">Cancel</button>
                    </div>
                    <div>

                        <button type="submit" id="submitbutton">Submit Recipe</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        //     const addButton = document.getElementById('add-ingredient');
        //     const inputContainer = document.querySelector('.ingredients-container-inner-input');
        //     let ingredientCount = 1;
        //     addButton.addEventListener('click', function() {
        //         const newinstructionblocks = `
        //                           <div class="col-md-6">

        //                         <input type="text" name="ingredients[${ingredientCount}][name]" placeholder="Add Ingredients">
        //                     </div>
        //                     <div class="col-md-6">
        //                         <select name="ingredients[${ingredientCount}][unit]" >
        //                             <option value="gram">Gram</option>
        //                             <option value="Celsius">Celsius</option>
        //                             <option value="Cm">Cm</option>                            </select>

        //                     </div>
        //      `;

        //         inputContainer.insertAdjacentHTML('beforeend', newinstructionblocks);

        //         // Increment the counter for the next instruction
        //         ingredientCount++;

        //     });

        //     const addInstructionButton = document.getElementById('add-new-instruction');
        //     const instructionsContainer = document.querySelector('.recipe-instructions-container');
        //     let instructionCount = 1; // Initialize a counter to track the number of instructions

        //     addInstructionButton.addEventListener('click', function() {
        //         // Define the HTML block to be added
        //         const newInstructionBlock = `
        //     <div class="row">
        //         <div class="col-md-4">
        //             <label class="photo-upload">
        //                 <img src="https://img.icons8.com/ios/50/000000/camera--v1.png" alt="Camera Icon">
        //                 <span class="span">Add Photo</span>
        //                 <input type="file" name="instructions[${instructionCount}][image]" accept="image/*">
        //             </label>
        //         </div>
        //         <div class="col-md-8">
        //             <textarea name="instructions[${instructionCount}][text]" placeholder="Instruction text"></textarea>
        //         </div>
        //     </div>
        // `;

        //         // Add the new block to the instructions container
        //         instructionsContainer.insertAdjacentHTML('beforeend', newInstructionBlock);

        //         // Increment the counter for the next instruction
        //         instructionCount++;


        //     });


        //     // Event delegation for handling image previews
        //     instructionsContainer.addEventListener('change', function(event) {
        //         const input = event.target;

        //         // Check if the changed element is a file input
        //         if (input.type === 'file' && input.accept.includes('image/*')) {
        //             if (input.files && input.files[0]) {
        //                 const reader = new FileReader();

        //                 reader.onload = function(e) {
        //                     // Find the closest <img> element and update its src
        //                     const previewImg = input.closest('.photo-upload').querySelector('img');
        //                     const span = input.closest('.photo-upload').querySelector('.span');
        //                     if (span) {
        //                         span.style.display = 'none';
        //                     }
        //                     if (previewImg) {
        //                         previewImg.src = e.target.result;
        //                     }
        //                 };

        //                 reader.readAsDataURL(input.files[0]); // Read the file as a data URL
        //             }
        //         }
        //     });


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

    document.addEventListener("DOMContentLoaded", function() {
        // Use jQuery in noConflict mode
        jQuery(function($) {
            $('#recipe_category').select2({
                placeholder: "Select Recipe Categories"
            });
        });
    });
</script>


<?php get_footer(); ?>