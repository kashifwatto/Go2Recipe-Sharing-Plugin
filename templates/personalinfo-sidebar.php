<div class="menu-inner">
    <div class="row">
        <div class="col-4"><img src="<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/user-img.png'); ?>" alt=""></div>
        <div class="col-8">
            <h3 class="email">
                <?php
                if (is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    $first_name = get_user_meta($current_user->ID, 'fristname', true);

                    if (!empty($first_name)) {
                        echo 'Hi ' . esc_html($first_name);
                    } else {
                        echo 'Hi ' . esc_html($current_user->user_email);
                    }
                }
                ?>
            </h3>
        </div>
    </div>
    <?php
    $current_url = home_url(add_query_arg([], $wp->request));
    ?>

    <hr>
    <a href="<?php echo site_url('/personal-info/'); ?>" class="menu <?php echo (strpos($current_url, '/personal-info') !== false) ? 'active' : ''; ?>">personal information</a>

    <hr>
    <a href="<?php echo site_url('/add-recipe/'); ?>" class="menu <?php echo (strpos($current_url, '/add-recipe') !== false) ? 'active' : ''; ?>">add new recipe</a>

    <hr>
    <a href="<?php echo site_url('/your-recipes/'); ?>" class="menu <?php echo (strpos($current_url, '/your-recipes') !== false) ? 'active' : ''; ?>">your recipes</a>

    <hr>
    <!-- <a href="<?php // echo site_url('/saved-recipes-collections/'); 
                    ?>" class="menu">Saved Recipes & Collections</a> -->
</div>

<div>
    <img src="<?php echo esc_url(recipe_sharing_dir_folder . '/assets/images/4.png'); ?>" alt="">
</div>