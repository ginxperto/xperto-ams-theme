<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg p-6 w-full'); ?>>
    <?php if (is_user_logged_in()) : ?>
        <header class="w-full mb-6">
            <span class="w-full text-lg">
                <?php
                $user_id = get_current_user_id();

                // * Lets try to load the memberpress user details
                $rc = new ReflectionClass('MeprUser');

                // instantiate via reflection
                $mepr_user = $rc->newInstanceArgs(array($user_id));

                // we have a memberpress user loaded
                if ($mepr_user instanceof MeprUser) {
                    $subs_title;
                    $subs = $mepr_user->active_product_subscriptions();

                    foreach ($subs as $sub) :
                        $product = new MeprProduct($sub);

                        if ($product instanceof MeprProduct) :
                            $subs_title[] = $product->post_title;
                        endif;
                    endforeach;

                    if (!empty($subs_title)) {
                        echo '<span class="text-lg text-xperto-neutral-mid-1">You current plan: </span>';
                        echo implode(", ", $subs_title);
                    }
                }
                ?>
            </span>
        </header>
    <?php endif; ?>

    <?php xperto_ams_post_thumbnail(); ?>

    <div class="entry-content w-full flex flex-col items-center justify-center">
        <?php
        the_content(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Continue reading<span> "%s"</span>', 'xperto-ams'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            )
        );

        wp_link_pages(
            array(
                'before' => '<div>' . esc_html__('Pages:', 'xperto-ams'),
                'after'  => '</div>',
            )
        );
        ?>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->