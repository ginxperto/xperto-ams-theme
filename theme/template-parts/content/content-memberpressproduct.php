<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg p-6 w-full md:w-[480px] self-center'); ?>>
    <?php if (is_user_logged_in()) : ?>
        <header class="w-full mb-4">
            <span class="text-2xl font-bold text-xperto-neutral-dark-1"><?php the_title(); ?></span>
        </header>
    <?php endif; ?>

    <?php xperto_ams_post_thumbnail(); ?>

    <div class="entry-content w-full flex flex-col items-start justify-center">
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