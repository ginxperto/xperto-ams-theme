<?php

function my_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/login_logo.png);
            height: 65px;
            width: auto;
            background-size: contain;
            background-repeat: no-repeat;
        }

        #login #nav a {
            display: none;
        }
    </style>
    <?php }
add_action('login_enqueue_scripts', 'my_login_logo');

function my_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'my_login_logo_url');

function xperto_account_home_label($title)
{
    return 'Account Details';
}
add_filter('mepr-account-nav-home-label', 'xperto_account_home_label');

function xperto_pricebox_templates($templates)
{
    // return array_merge($tempplate, array());
    return $templates;
}
add_filter('mepr_group_theme_templates_paths', 'xperto_pricebox_templates');

function xperto_pricebox_themes($templates)
{
    $new_temp = array_merge($templates, array(get_template_directory() . '/css/plans'));
    return $new_temp;
    // return $templates;
}
add_filter('mepr_group_themes_paths', 'xperto_pricebox_themes');

function xperto_edit_post($post_id)
{
    echo '<style>
    #wpbody-content .wrap > form[name="post"]{
        display: block !important;
    }
    </style>';
}

add_action('load-post.php', 'xperto_edit_post');

function xperto_before_account_subscriptions($mepr_current_user)
{
    $sub_list = null;
    $subs = $mepr_current_user->active_product_subscriptions();

    foreach ($subs as $sub) {
        // * Lets try to load the memberpress details
        $rc = new ReflectionClass('MeprProduct');

        // instantiate via reflection
        // get 1 product
        $product = $rc->newInstanceArgs(array($sub));

        if ($product && (get_class($product) === MeprProduct::class)) {
            $sub_list[] = $product->post_title;
        }
    }

    $args = array(
        'post_type' => 'memberpressgroup',
        'posts_per_page' => 5
        // Several more arguments could go here. Last one without a comma.
    );

    // start the wrapper
    echo '<div class="mp_wrapper">';

    if (!empty($sub_list)) : ?>
        <div class="mb-1">You are currenly in a <?php echo implode(", ", $sub_list); ?> plan</div>
    <?php
    endif;

    // Query the posts
    $group_query = new WP_Query($args);
    $group_query->have_posts();

    // Loop through the posts:
    while ($group_query->have_posts()) : $group_query->the_post();
    ?>
        <div class="mb-4">
            <a href="<?php the_permalink() ?>" class="text-xperto-orange hover:text-xperto-orange-base-20 no-underline ">
                <span class="font-bold">View available <?php the_title(); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    <?php

    endwhile;
    // Reset Post Data
    wp_reset_postdata();

    // end wrapper
    echo '</div>';
}

add_action('mepr_before_account_subscriptions', 'xperto_before_account_subscriptions');

function xperto_acf_add_local_field_groups()
{
    acf_add_local_field_group(array(
        'key' => 'group_63062fadb1321',
        'title' => 'Membership Badge',
        'fields' => array(
            array(
                'key' => 'field_63062fd0e6189',
                'label' => 'Badge Color',
                'name' => 'badge_color',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '#A5A5A5',
                'enable_opacity' => 0,
                'return_format' => 'string',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'memberpressproduct',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
}
add_action('acf/init', 'xperto_acf_add_local_field_groups');

function add_favicon()
{
    if (!get_option('site_icon', false)) {
        // Show favicon
        echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/images/xperto_favicon.png"/>';
    }
}
add_action('wp_head', 'add_favicon');

function mepr_account_home_before_name($user)
{
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
    ?>

        <div class="mp-form-row mepr_first_name mepr-field-required">
            <div class="mp-form-label">
                <label for="user_first_name">Username:*</label>
            </div>
            <p class="mepr-form-input"><?php echo $current_user->user_login; ?></p>
        </div>
    <?php
    }
}
add_action('mepr-account-home-before-name', 'mepr_account_home_before_name');

function mpdn_show_on_account($user)
{
    ?>
    <p class="clear-both">
        By clicking "Save Profile", you agree to our <a href="<?php echo get_privacy_policy_url(); ?>">Privacy Statement</a>.
    </p>
    <?php
}
add_action('mepr-account-home-fields', 'mpdn_show_on_account');

function mepr_account_file_uploader_help_text()
{
    if (wp_script_is('jquery')) : ?>
        <script>
            (function($) {
                function xpertoMeprFileChecker(e) {
                    var maxSize = 2;
                    var files = e.target.files;
                    var filesLength = files.length;

                    for (var i = 0; i < filesLength; i++) {
                        var sizeMB = (files[i].size / 1024 / 1024).toFixed(4); //MB

                        if (sizeMB > maxSize) {
                            alert("File is too big, Maximum file size is 2MB.\nPlease select another file.");
                            $(this).val("");
                        }
                    }
                }

                $(document).ready(function() {
                    var $spanContent = '<div class="block mt-1"><span class="text-sm text-xperto-neutral-mid-1">Maximum File Size Upload: 2MB</span><div>';
                    var $fileUploaders = $('.mp-form-row.mepr_custom_field .mepr-file-uploader');

                    $($fileUploaders).each(function() {
                        $(this).after($spanContent);
                        $(this).on("change", xpertoMeprFileChecker)
                    });
                });
            })(jQuery);
        </script>
<?php endif;
}
add_action('wp_head', 'mepr_account_file_uploader_help_text');
