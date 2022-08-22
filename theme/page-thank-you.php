<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package xperto-ams
 */

get_header('memberpressgroup');
?>
<main id="primary" class="w-full flex item-start h-[calc(100vh-160px)] md:items-center md:justify-center">
	<div class="container flex flex-col items-start p-4 space-y-6 max-w-[1200px] w-[480px] xl:mx-auto">
		<?php
		while (have_posts()) :
			the_post();

			get_template_part('template-parts/content/content', 'thank-you');

		endwhile; // End of the loop.
		?>
	</div>
</main><!-- #main -->

<?php
// important to enquque footer js
get_footer();
