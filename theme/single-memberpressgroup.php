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

<main id="primary" class="w-full flex">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 m:w-2/3 lg:space-x-0 xl:mx-auto">
		<div class="mx-auto text-4xl text-center mb-9">
			<h1 class="">
				<?php if (is_user_logged_in()) : ?>
					Upgrade your plan
				<?php else : ?>
					Choose your plan
				<?php endif; ?>
			</h1>
		</div>
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
