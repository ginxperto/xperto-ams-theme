<?php if (is_user_logged_in() && is_user_member_of_blog()) : ?>
    <?php
    // lets try to get a membership from the group of memberpress
    $user_id = get_current_user_id();

    // * Lets try to load the memberpress user details
    $rc = new ReflectionClass('MeprUser');

    // instantiate via reflection
    $mepr_user = $rc->newInstanceArgs(array($user_id));

    // we have a memberpress user loaded
    if ($mepr_user instanceof MeprUser) :
        $subs_title;
        $highest_tier;
        $show_upgrade = true;
        $group_products = array();
        $group_url = home_url();
        $subs = $mepr_user->active_product_subscriptions();

        foreach ($subs as $sub) :
            //get 1 product
            $product = new MeprProduct($sub);

            // we haven't retrieve all product inside the group
            if (empty($group_products)) {
                // get the group of product
                $group = new MeprGroup($product->group_id);

                if ($group instanceof MeprGroup) {
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
        if ($highest_tier instanceof MeprProduct) :
    ?>
            <section id="membership-upgrade-content" class="w-full <?php echo (!$show_upgrade) ? 'hidden' : ''; ?>">
                <div class="flex flex-row rounded-lg bg-xperto-success-light-80 border border-xperto-success-base p-6 relative">
                    <div class="flex flex-col w-full space-y-4">
                        <span class="text-2xl text-xperto-green font-semibold">Upgrade your account!</span>
                        <p class="text-xperto-neutral-dark-1"><?php echo $highest_tier->post_title; ?> get additional perks, such as unlocking exclusive <?php echo $highest_tier->post_title; ?> profile badges, exclusive invites to <?php echo $highest_tier->post_title; ?>-only events and seminars, and so much more!</p>
                        <a class="rounded-lg border border-xperto-orange py-3 px-4 text-xperto-orange flex-none text-center hover:bg-xperto-orange-base-20 hover:text-white active:bg-xperto-orange-base-plus-10" href="<?php echo $group_url; ?>">Upgrade</a>
                    </div>
                </div>
            </section><!-- #membership-upgrade-content -->
    <?php
        endif;
    endif; ?>
<?php else : ?>
    <?php
    $args = array(
        'post_type' => 'memberpressgroup',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );
    $posts = new WP_Query($args);

    while ($posts->have_posts()) : $posts->the_post();
        $groups = new MeprGroup($posts->ID);
    endwhile;

    if ($groups instanceof MeprGroup) :
        // get products inside the group
        $group_products = $groups->products();

        if (count($group_products) > 0) : ?>
            <section id="membership-upgrade-content" class="w-full">
                <div class="flex flex-row rounded-lg bg-xperto-success-light-80 border border-xperto-success-base p-6 relative">
                    <div class="flex flex-col space-y-4 w-full">
                        <span class="text-2xl text-xperto-green font-semibold">Join the <?php bloginfo(); ?></span>
                        <p class="text-xperto-neutral-dark-1">New members get additional perks, such as exclusive organization merchandise, exclusive invites to Member-only events and seminars, and so much more!</p>
                        <a class="rounded-lg bg-xperto-orange py-3 px-4 text-white flex-none w-full text-center md:w-48 hover:bg-xperto-orange-base-20 active:bg-xperto-orange-base-plus-10" href="<?php echo $group_products[0]->group_url(); ?>">Become a member</a>
                    </div>
                </div>
            </section>
<?php endif;
    endif;
endif;
?>