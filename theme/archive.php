<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

get_header();
?>
<main id="primary" class="w-full flex flex-row items-start">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 xl:mx-auto">
		<?php if (have_posts()) : ?>

			<header>
				<?php
				the_archive_title('<h1 class="entry-title text-4xl text-xperto-neutral-dark-1 font-bold w-full">', '</h1>');
				the_archive_description('<div>', '</div>');
				?>
			</header>

		<?php
			/* Start the Loop */
			while (have_posts()) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part('template-parts/content/content', 'archive');

			endwhile;

			the_posts_navigation();
		else :
			get_template_part('template-parts/content/content', 'none');
		endif;
		?>
	</div>
</main><!-- #main -->

<?php
get_footer();
