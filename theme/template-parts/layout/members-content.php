<div class="flex flex-wrap w-full space-y-6 lg:space-y-0 lg:gap-6 lg:grid lg:grid-cols-2">
    <?php
    global $wpdb;
    $user_data;
    $ids;

    $order_by = '';
    $offset = 0;
    $items_per_page = get_option('posts_per_page');

    if (isset($_GET['order_by'])) {
        $order_by = " ORDER BY {$_GET['order_by']}";
    }
    $page = isset($_GET['member_page']) ? abs((int) $_GET['member_page']) : 1;
    $offset = ($page * $items_per_page) - $items_per_page;
    $limit = " LIMIT {$offset},{$items_per_page}";
    $where = " WHERE memberships <> '' ";
    $members_table = $wpdb->prefix . 'mepr_members';

    // Query All
    $query = "SELECT user_id FROM {$members_table}
        {$where}";

    // Query by Name
    if (isset($_GET['member_name'])) {
        $name = $_GET['member_name'];

        $users_table = $wpdb->prefix . 'users';
        $query = "SELECT user_id FROM {$members_table} 
            LEFT JOIN {$users_table} 
            ON {$members_table}.user_id = {$users_table}.ID 
            WHERE memberships <> '' 
                AND {$users_table}.display_name LIKE '%{$name}%'";
    }

    // get total count
    $total = $wpdb->get_var("SELECT COUNT(1) FROM (${query}) AS combined_table");

    // limit the results per page
    $query .= " {$order_by}{$limit}";

    // var_dump($query); // * uncomment if needed

    $results = $wpdb->get_results($query);

    foreach ($results as $result) {
        $ids[] = $result->user_id;

        // if its already loaded
        if (class_exists('MeprUser')) :
            $rc = new ReflectionClass('MeprUser');

            // instantiate via reflection
            $obj = $rc->newInstanceArgs(array($result->user_id));

            if ($obj instanceof MeprUser) {
                $user_data[] = $obj;
            }
        endif;
    }

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
                            echo get_avatar($current_user->ID, 68, '', 'avatar', array('class' => 'rounded-full min-w-[80px] hover:border hover:border-xperto-orange'));
                        endif; ?>
                    </div>
                    <div class="flex flex-col items-start space-y-4">
                        <header class="w-full">
                            <div class="flex flex-row justify-between">
                                <h4>
                                    <a href="<?php echo $profile_link; ?>" class="hover:text-xperto-orange font-bold" alt="Visit profile" title="Visit Profile">
                                        <?php echo $data->display_name; ?>
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
                                $product = new MeprProduct($sub);

                                if ($product instanceof MeprProduct) :
                                    // pick color from tailwind
                                    $color_list = array(
                                        'text-xperto-member-color-0',
                                        'text-xperto-member-color-1',
                                        'text-xperto-member-color-2'
                                    );
                                    $color = $color_list[$product->group_order];
                            ?>
                                    <span class="text-sm font-bold <?php echo $color; ?>" style="color: <?php echo get_post_custom_values('badge_color', $product->ID) === null ?>">
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