<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg p-6 w-full h-80 flex flex-col justify-center'); ?>>
    <?php if (is_user_logged_in()) : ?>
        <header class="w-full flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 fill-xperto-success-base" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="text-2xl font-bold text-xperto-neutral-dark-1 mt-7">Payment Successful</span>
        </header>
    <?php endif; ?>
    <?php xperto_ams_post_thumbnail(); ?>
    <div class="entry-content w-full flex items-start justify-center">
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
        ); ?>
    </div>
    <footer class="flex self-center">
        <a href="<?php echo home_url() ?>" class="xperto-button-contained">Back to home</a>
    </footer>
</article><!-- #post-<?php the_ID(); ?> -->