<?php
global $wpdb;
$user_data = null;
$ids;

$order_by = '';
$offset = 0;
$items_per_page = get_option('posts_per_page');

$page = isset($_GET['member_page']) ? abs((int) $_GET['member_page']) : 1;
$offset = ($page * $items_per_page) - $items_per_page;

$orderby = 'name';
$order = 'DESC';
$paged = $offset;
$search = '';
$search_field = '';

// user has filtered
if (isset($_GET['member_name'])) {
    $name = $_GET['member_name'];
    $search = $name;
    $search_field = 'pm_first_name.meta_value';

    if (isset($_GET['search_by']) && $_GET['search_by'] == 'first_name') {
        $search_field = 'pm_first_name.meta_value';
    }

    if (isset($_GET['search_by']) && $_GET['search_by'] == 'last_name') {
        $search_field = 'pm_last_name.meta_value';
    }
}

$perpage = 10;
// * Only get the active ones
$params = array(
    'membership' => 'all',
    'status' => 'active',
);

$list_table  = MeprUser::list_table($orderby, $order, $paged, $search, $search_field, $perpage, $params);
$total = $list_table['count'];
$results = $list_table['results'];

foreach ($results as $result) {
    $ids[] = $result->ID;
    $mepr_user = null;

    // if its already loaded
    if (class_exists('MeprUser')) :
        $rc = new ReflectionClass('MeprUser');

        // instantiate via reflection
        $mepr_user = $rc->newInstanceArgs(array($result->ID));

        if ($mepr_user && (get_class($mepr_user) === MeprUser::class)) {
            $user_data[] = $mepr_user;
        }
    endif;
}

?>
<div class="flex flex-wrap w-full space-y-6 lg:space-y-0 lg:gap-6 lg:grid lg:grid-cols-2">
    <?php
    if (is_array($user_data) || is_object($user_data)) {
        foreach ($user_data as $data) :
            $profile = $data->custom_profile_values();
            $profile_link = add_query_arg("id", $data->ID, home_url('/profile')); ?>
            <div class="flex w-full min-w-min bg-white rounded-lg p-6">
                <div class="flex flex-row items-start space-x-4 w-full">
                    <div class="w-20">
                        <?php if (!empty($profile['mepr_profile_picture'])) : ?>
                            <a href="<?php echo $profile_link; ?>" class="hover:text-xperto-orange" alt="Visit profile" title="Visit Profile">
                                <img src="<?php echo $profile['mepr_profile_picture']; ?>" class="rounded-full min-w-[80px] hover:border hover:border-xperto-orange" />
                            </a>
                        <?php else :
                            echo get_avatar($data->ID, 68, '', 'avatar', array('class' => 'rounded-full min-w-[80px] hover:border hover:border-xperto-orange'));
                        endif; ?>
                    </div>
                    <div class="flex-1 flex flex-col items-start space-y-4">
                        <header class="w-full">
                            <div class="flex flex-row justify-between">
                                <h4>
                                    <a href="<?php echo $profile_link; ?>" class="hover:text-xperto-orange font-bold" alt="Visit profile" title="Visit Profile">
                                        <?php echo $data->first_name; ?> <?php echo $data->last_name; ?>
                                    </a>
                                </h4>
                                <div class="hidden flex-row justify-evenly sm:flex">
                                    <?php if (array_key_exists('mepr_facebook', $profile) && !empty($profile['mepr_facebook'])) : ?>
                                        <a href="<?php echo esc_url($profile['mepr_facebook']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_fb.png' ?>" class="w-5 h-5" /></a>
                                    <?php endif; ?>
                                    <?php if (array_key_exists('mepr_twitter', $profile) && !empty($profile['mepr_twitter'])) : ?>
                                        <a href="<?php echo esc_url($profile['mepr_twitter']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_twitter.png' ?>" class="w-5 h-5" /></a>
                                    <?php endif; ?>
                                    <?php if (array_key_exists('mepr_linkedin', $profile) && !empty($profile['mepr_linkedin'])) : ?>
                                        <a href="<?php echo esc_url($profile['mepr_linkedin']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_linkedin.png' ?>" class="w-5 h-5" /></a>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url('mailto:' . $data->rec->user_email); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_email.png' ?>" class="w-5 h-5" /></a>
                                </div>
                                <!-- Social Links -->
                            </div>
                            <?php
                            $subs = $data->active_product_subscriptions();
                            foreach ($subs as $sub) :
                                $reflectionClass = new ReflectionClass('MeprProduct');

                                // instantiate via reflection
                                $product = $reflectionClass->newInstanceArgs(array($sub));

                                if ($product && (get_class($product) === MeprProduct::class)) : ?>
                                    <span class="text-sm font-bold" style="color: <?php echo empty(get_post_custom_values('badge_color', $product->ID)) ? '#262626' : get_post_custom_values('badge_color', $product->ID)[0]; ?>">
                                        <?php echo $product->post_title; ?>
                                    </span>
                            <?php endif;
                            endforeach;
                            ?>
                            <!-- Subscriptions -->
                        </header>
                        <?php
                        // TODO: insert crendentialing badges here
                        ?>
                        <?php if (array_key_exists('mepr_about', $profile)) { ?>
                            <p>
                                <?php echo wp_trim_words($profile['mepr_about'], 20); ?>
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Card -->
        <?php endforeach; ?>
    <?php } ?>
</div>
<div class="flex flex-row w-full space-x-0 items-center">
    <?php
    echo paginate_links(array(
        'base' => add_query_arg('member_page', '%#%'),
        'format' => '',
        'prev_text' => __('&lt; Prev'),
        'next_text' => __('Next &gt;'),
        'total' => ceil($total / $items_per_page),
        'current' => $page
    ));
    ?>
</div>
<!-- Member Cards -->