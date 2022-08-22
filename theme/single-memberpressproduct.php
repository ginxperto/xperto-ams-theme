<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package xperto-ams
 */

get_header('memberpressproduct');
?>
<main id="primary" class="w-full flex">
	<div class="xperto-memberpressproduct container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 lg:space-x-0 xl:mx-auto">
		<?php
		while (have_posts()) :
			the_post();

			get_template_part('template-parts/content/content', get_post_type());

		endwhile; // End of the loop.
		?>
	</div>
</main><!-- #main -->

<?php
// important to enquque footer js
get_footer();
