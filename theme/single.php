<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package xperto-ams
 */

get_header();
?>

<main id="primary" class="w-full flex flex-row items-start min-h-[calc(100vh-80px)">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 m:w-2/3 lg:space-x-0 xl:mx-auto">
		<?php
		while (have_posts()) :
			the_post();

			get_template_part('template-parts/content/content', get_post_type());

			// * we don't need it for AMS
			// the_post_navigation(
			// 	array(
			// 		'prev_text' => '<span>' . esc_html__('Previous:', 'xperto-ams') . '</span> <span>%title</span>',
			// 		'next_text' => '<span>' . esc_html__('Next:', 'xperto-ams') . '</span> <span>%title</span>',
			// 	)
			// );

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
	</div>
	<div class="hidden w-1/3 bg-white p-6 mt-[1px] self-stretch lg:block lg:w-1/4 md:max-w-xs">
		<?php get_sidebar('single'); ?>
	</div>
</main><!-- #main -->

<?php
get_footer();
