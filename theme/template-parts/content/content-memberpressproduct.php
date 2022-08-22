<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<?php if (isset($_GET['action']) && $_GET['action'] == 'checkout') : ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg p-6 w-full md:w-[480px] self-center'); ?>>
    <?php else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg p-6 w-full'); ?>>
        <?php endif; ?>
        <?php if (is_user_logged_in()) : ?>
            <header class="w-full mb-4">
                <span class="text-2xl font-bold text-xperto-neutral-dark-1"><?php the_title(); ?></span>
            </header>
        <?php endif; ?>

        <?php xperto_ams_post_thumbnail(); ?>

        <?php if (isset($_GET['action']) && $_GET['action'] == 'checkout') : ?>
            <div class="entry-content w-full flex flex-col items-start justify-center">
            <?php else : ?>
                <div class="entry-content w-full flex flex-col items-start justify-center md:space-x-10 md:flex-row">
                <?php endif;

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
        </article><!-- #post-<?php the_ID(); ?> -->