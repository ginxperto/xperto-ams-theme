<?php if (is_user_logged_in() && is_user_member_of_blog()) : ?>
    <?php
    // lets try to get a membership from the group of memberpress
    $user_id = get_current_user_id();

    // * Lets try to load the memberpress user details
    $rc = new ReflectionClass('MeprUser');

    // instantiate via reflection
    $mepr_user = $rc->newInstanceArgs(array($user_id));

    // we have a memberpress user loaded
    if (get_class($mepr_user) === MeprUser::class) :
        $subs_title = '';
        $highest_tier = null;
        $show_upgrade = true;
        $group_products = array();
        $group_url = home_url();
        $subs = $mepr_user->active_product_subscriptions();

        foreach ($subs as $sub) :
            // * Lets try to load the memberpress details
            $rc = new ReflectionClass('MeprProduct');

            // instantiate via reflection
            // get 1 product
            $product = $rc->newInstanceArgs(array($sub));

            // we haven't retrieve all product inside the group
            if (empty($group_products)) {
                // * Lets try to load the memberpress details
                $rc = new ReflectionClass('MeprGroup');

                // instantiate via reflection                
                // get the group of product
                $group = $rc->newInstanceArgs(array($product->group_id));

                if ($group && (get_class($group) === MeprGroup::class)) {
                    // get products inside the group
                    $group_products = $group->products();

                    // cache this upgrade flag                 
                    $group_url = $product->group_url();
                    $show_upgrade = $product->group_order < (count($group_products) - 1);
                }
            }
        endforeach;

        // we found the group
        if (!empty($group_products)) {
            // get the highest tier
            $highest_tier = end($group_products);
        }

        // failsafe
        if ($highest_tier && (get_class($highest_tier) === MeprProduct::class)) :
    ?>
            <section id="membership-upgrade-content" class="w-full <?php echo (!$show_upgrade) ? 'hidden' : ''; ?>">
                <div class="flex flex-row rounded-lg bg-xperto-success-light-80 border border-xperto-success-base p-6 relative">
                    <div class="flex flex-col w-full space-y-4">
                        <span class="text-2xl text-xperto-green font-semibold">Upgrade your account!</span>
                        <p class="text-xperto-neutral-dark-1"><?php echo $highest_tier->post_title; ?> get additional perks, such as unlocking exclusive <?php echo $highest_tier->post_title; ?> profile badges, exclusive invites to <?php echo $highest_tier->post_title; ?>-only events and seminars, and so much more!</p>
                        <a class=" flex-none text-center xperto-button-outlined md:max-w-fit" href="<?php echo $group_url; ?>">Upgrade</a>
                    </div>
                </div>
            </section><!-- #membership-upgrade-content -->
    <?php
        endif;
    endif; ?>
<?php else :
    // user is not logged in 
?>
    <?php
    $args = array(
        'post_type' => 'memberpressgroup',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );
    $posts = new WP_Query($args);

    while ($posts->have_posts()) : $posts->the_post();
        // * Lets try to load the memberpress details
        $rc = new ReflectionClass('MeprGroup');

        // get the group of product
        $groups = $rc->newInstanceArgs(array($posts->ID));
    endwhile;

    if (get_class($groups) === MeprGroup::class) :
        // get products inside the group
        $group_products = $groups->products();

        if (count($group_products) > 0) : ?>
            <section id="membership-upgrade-content" class="w-full">
                <div class="flex flex-row rounded-lg bg-xperto-success-light-80 border border-xperto-success-base p-6 relative">
                    <div class="flex flex-col space-y-4 w-full">
                        <span class="text-2xl text-xperto-green font-semibold">Join the <?php bloginfo(); ?></span>
                        <p class="text-xperto-neutral-dark-1">New members get additional perks, such as exclusive organization merchandise, exclusive invites to Member-only events and seminars, and so much more!</p>
                        <a class="flex-none w-full text-center xperto-button-contained md:max-w-fit" href="<?php echo $group_products[0]->group_url(); ?>">Become a member</a>
                    </div>
                </div>
            </section>
<?php endif;
    endif;
endif;
?>