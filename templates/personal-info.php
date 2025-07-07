<?php
/*
Template Name: Personal Info
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
$user_image = '';
if (is_user_logged_in()) {
    $current_user_id = get_current_user_id();

    // Retrieve user meta
    $name = get_user_meta($current_user_id, 'fristname', true);
    $location = get_user_meta($current_user_id, 'location', true);
    $details = get_user_meta($current_user_id, 'details', true);
    $user_image = get_user_meta($current_user_id, 'user_image', true);
}
$placeholder_image = 'http://go2recipe.com/wp-content/uploads/2025/07/placeholderimage.png';

if (empty($user_image)) {
    $user_image = $placeholder_image;
}

$is_custom_image = ($user_image !== $placeholder_image);
?>
<style>
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

    .menu-inner,
    .info-setting-container {
        background-color: rgba(248, 247, 246, 1);
        padding: 25px;
        border-radius: 12px;

    }

    .form-inner {
        background-color: rgba(255, 255, 255, 1);
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
        display: flex;
        align-items: center;
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


    .photo-upload {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 180px;
        border: 1px solid rgba(171, 167, 167, 1);
        border-radius: 16px;
        cursor: pointer;
        margin: 0px !important;
        transition: border-color 0.3s ease;
    }

    .photo-upload:hover {
        border-color: rgba(171, 167, 167, 1);
    }

    .photo-upload input[type="file"] {
        display: none;
    }

    .photo-upload .imagePreviewcontainer img {
        max-width: 100%;
        max-height: 100%;

        /* margin-bottom: 8px; */
    }

    .imagePreviewcontainer {
        height: 140px;
        width: 140px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .photo-upload span {
        font-size: 16px;
        color: rgba(102, 102, 102, 1);
    }

    .info-setting-container-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-setting-container-button button {
        background: rgba(171, 167, 167, 1);
        border-radius: 8px;
        border: none;
        color: white;
        font-family: Poppins;
        font-size: 16px;
        font-weight: 600;
        line-height: 24px;
        color: white;


    }

    .info-setting-container-button button:hover {
        color: white;
    }

    .info-setting-container-button h2 {
        font-family: Poppins;
        font-size: 36px;
        font-weight: 600;
        /* line-height: 60px; */

    }

    @media(max-width:767px) {
        .info-setting-container-button h2 {
            font-size: 24px;
        }

        .info-setting-container-button button {
            font-size: 14px;
        }
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 info-menu">
            <?php @include('personalinfo-sidebar.php'); ?>
        </div>
        <div class="col-md-8 info-setting-container">
            <form id="personal-info-form" enctype="multipart/form-data" method="post">
                <div class="info-setting-container-button">
                    <div>

                        <h2>Profile Setting</h2>
                    </div>
                    <div>
                        <button type="submit">Save Changes</button>

                    </div>
                </div>
                <div class="form-inner">
                    <label> Your Name </label>
                    <input type="text" name="name" placeholder="Frist Name" value="<?php if (is_user_logged_in()) echo $name;  ?>">

                    <label> Your Location </label>
                    <input type="text" name="location" placeholder="Location" value="<?php if (is_user_logged_in()) echo $location;  ?>">
                    <label for="">About You</label>
                    <textarea name="details"> <?php if (is_user_logged_in()) echo $details;  ?></textarea>
                    <label for="">Add an Image</label>
                    <label class="photo-upload">
                        <div class="imagePreviewcontainer">
                            <img id="imagePreview" src="<?php echo esc_url($user_image); ?>" alt="User Image">
                        </div>

                        <span id="uploadLabel"><?php echo $is_custom_image ? 'Edit Photo' : 'Add Photo'; ?></span>

                        <input id="imageInput" name="userimage" type="file" accept="image/*">
                    </label>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result;

            // Update the label to say "Edit Photo" after upload
            document.getElementById('uploadLabel').textContent = 'Edit Photo';
        };
        reader.readAsDataURL(input.files[0]);
    }
});
</script>

<?php get_footer(); ?>