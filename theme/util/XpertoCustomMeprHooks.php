<?php

function xperto_account_home_label($title)
{
    return 'Account Details';
}
add_filter('mepr-account-nav-home-label', 'xperto_account_home_label');

function xperto_before_account_subscriptions($mepr_current_user)
{
    $sub_list = null;
    $subs = $mepr_current_user->active_product_subscriptions();
    foreach ($subs as $sub) {
        $product = new MeprProduct($sub);

        if ($product instanceof MeprProduct) {
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
    $group_perma_link = null;
    $group_query = new WP_Query($args);
    $group_query->have_posts();

    // Loop through the obituaries:
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
