<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

get_header();
?>
<main id="primary" class="w-full flex flex-row items-start">
    <div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 m:w-2/3 lg:space-x-0 xl:mx-auto">
        <h3 class="text-4xl text-xperto-neutral-dark-1 font-bold w-full">Community</h3>
        <?php
        while (have_posts()) :
            the_post();

            get_template_part('template-parts/content/content', get_post_type());

            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>
        <?php
        $nav_attr = array(
            'class' => 'community-nav' // tailwind css
        );
        the_posts_navigation($nav_attr);
        ?>
    </div>
    <div class="hidden w-1/3 bg-white p-6 mt-[1px] self-stretch lg:block lg:w-1/4 md:max-w-xs">
        <?php get_sidebar('community'); ?>
    </div>
</main>

<?php
// important to enquque footer js
get_footer();
