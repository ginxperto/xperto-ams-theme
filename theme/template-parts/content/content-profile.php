<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

$profile;
$mepr_user;
$user_id = $_GET['id'];

// About Me URL
$profile_url = home_url('/profile');
$profile_args = array(
    'id' => $user_id
);
$final_profile_url = esc_url_raw(add_query_arg($profile_args, $profile_url));

// Credentials URL
$profile_args = array(
    'id' => $user_id,
    'tab' => 'credentials'
);
$final_credentials_url = esc_url_raw(add_query_arg($profile_args, $profile_url));

if (is_user_logged_in()) :
    // * Lets try to load the memberpress user details
    $rc = new ReflectionClass('MeprUser');

    // instantiate via reflection
    $mepr_user = $rc->newInstanceArgs(array($user_id));

    // we have a memberpress user loaded
    if ($mepr_user instanceof MeprUser && !empty($mepr_user->ID)) :
        // get custom fields
        $profile = $mepr_user->custom_profile_values();
    else :
        get_template_part('template-parts/content/content', 'not-found');
        exit;
    endif;
endif;

// Try to select a tab
$tabIndex = (isset($_GET['tab']) && $_GET['tab'] === 'credentials') ? 1 : 0;

?>

<section class="flex flex-col w-full bg-white rounded-lg space-y-20">
    <header class="w-full relative aspect-3/1 bg-xperto-custom-header rounded-t-lg min-w-[330px]">
        <?php if (!empty($profile) && !empty($profile['mepr_profile_banner'])) : ?>
            <img class="rounded-t-lg absolute w-full h-full object-cover mix-blend-overlay" src="<?php echo $profile['mepr_profile_banner']; ?>" alt="Profile Banner" />
        <?php else : ?>
            <img class="rounded-t-lg absolute w-full h-full object-cover mix-blend-overlay" src="<?php echo get_template_directory_uri() . '/images/profile_banner.png' ?>" alt="Profile Banner" />
        <?php endif; ?>
        <!-- Profile Banner -->

        <div class="absolute -bottom-12 inset-x-9 flex flex-row space-x-4">
            <?php if (!empty($profile) && !empty($profile['mepr_profile_picture'])) : ?>
                <img src="<?php echo $profile['mepr_profile_picture']; ?>" class="bg-white rounded-full  border-4 border-white w-32 h-32" />
            <?php else :
                echo get_avatar($current_user->ID, 128, '', 'avatar', array('class' => 'rounded-full'));
            endif;
            ?>
            <div class="flex-1 flex flex-col mt-6">
                <span class="text-white font-bold"><?php echo esc_html($mepr_user->display_name); ?></span>
                <div class="h-6">
                    <?php
                    $subs = $mepr_user->active_product_subscriptions();
                    foreach ($subs as $sub) :
                        $product = new MeprProduct($sub);

                        if ($product instanceof MeprProduct) :
                            // pick color from tailwind
                            $color_list = array(
                                'text-xperto-member-color-0',
                                'text-xperto-member-color-1',
                                'text-xperto-member-color-2'
                            );
                            $color = $color_list[$product->group_order]; ?>
                            <span class="text-sm font-bold <?php echo $color; ?>" style="color: <?php echo get_post_custom_values('badge_color',$product->ID)[0]; ?>">
                                <?php echo $product->post_title; ?>
                            </span>
                    <?php endif;
                    endforeach; ?>
                </div>
                <div class="flex flex-row space-x-2 mt-6 min-w-[250px]">
                    <?php if (array_key_exists('mepr_facebook', $profile) && !empty($profile['mepr_facebook'])) : ?>
                        <a href="<?php echo esc_url($profile['mepr_facebook']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_fb.png' ?>" class="w-5 h-5" /></a>
                    <?php endif; ?>
                    <?php if (array_key_exists('mepr_twitter', $profile) && !empty($profile['mepr_twitter'])) : ?>
                        <a href="<?php echo esc_url($profile['mepr_twitter']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_twitter.png' ?>" class="w-5 h-5" /></a>
                    <?php endif; ?>
                    <?php if (array_key_exists('mepr_linkedin', $profile) && !empty($profile['mepr_linkedin'])) : ?>
                        <a href="<?php echo esc_url($profile['mepr_linkedin']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_linkedin.png' ?>" class="w-5 h-5" /></a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url('mailto:' . $mepr_user->rec->user_email); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_email.png' ?>" class="w-5 h-5" /></a>
                </div>
            </div>
        </div>
        <!-- User V-card -->
    </header>
    <!-- header -->
    <div class="w-full px-6">
        <ul class="flex flex-wrap text-sm font-medium text-center text-xperto-neutral-mid-1 border-b border-gray-200">
            <li class="mr-2">
                <?php $active = ($tabIndex === 0) ? 'xperto-tab-active' : ''; ?>
                <a href="<?php echo $final_profile_url; ?>" aria-current="page" class="inline-block p-4 text-xperto-neutral-mid-1 hover:bg-xperto-orange-light-90 hover:text-xperto-orange <?php echo $active; ?>">About Me</a>
            </li>
            <li class="mr-2">
                <?php $active = ($tabIndex === 1) ? 'xperto-tab-active' : ''; ?>
                <a href="<?php echo $final_credentials_url; ?>" class="inline-block p-4 text-xperto-neutral-mid-1 hover:bg-xperto-orange-light-90 hover:text-xperto-orange <?php echo $active; ?>">Credentials</a>
            </li>
        </ul>
        <?php
        // About Me Tab
        if ($tabIndex === 0) :
        ?>
            <div class="py-6 space-y-4">
                <?php if ($mepr_user->ID === get_current_user_id()) : ?>
                    <div class="w-full flex justify-end">
                        <a href="<?php echo home_url('/account'); ?>" class="text-xperto-orange font-bold hover:bg-xperto-orange-light-90">Edit</a>
                    </div>
                <?php
                endif;

                if (!empty($profile)) : ?>
                    <div class="w-full">
                        <?php echo $profile['mepr_about']; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php
        // Credentialing Tab
        else : ?>
            <div class="py-6 space-y-4">
                <div class="w-full relative">
                    <?php
                    $current_user_id = get_current_user_id();

                    // current user is viewing his own profile
                    if ($current_user_id == $mepr_user->ID) : ?>
                        <div class="flex flex-col items-center justify-center h-[400px]">
                            <img src="<?php echo get_template_directory_uri() . '/images/icon_cert.png'; ?>" alt="Certificate Icon" class="w-20" />
                            <span class="font-bold text-lg mt-6">You have no crendetials yet</span>
                            <span>You haven't applied any credentials.</span>
                            <a href="<?php home_url(); /* TODO: UPDATE THIS */ ?>" class="mt-4 rounded-lg py-3 px-4 bg-xperto-orange text-white hover:bg-xperto-orange-base-20 active:bg-xperto-orange-base-plus-10">Apply for Credentials</a>
                        </div>
                    <?php else : ?>
                        <div class="flex flex-col min-h-[200px]">
                            <h3 class="font-bold text-lg">User hasn't uploaded any credentials yet.</h3>
                            <div class="flex flex-row items-center">
                                <?php // TODO: add credentials result here 
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>