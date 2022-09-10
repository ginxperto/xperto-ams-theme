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

if (is_page('login')) {
	wp_redirect(home_url('?loginaction=xpertoOauthLogin'));
	exit();
}

get_header();
?>
<main id="primary" class="w-full flex flex-row items-start">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 lg:space-x-0 xl:mx-auto">
		<?php
		while (have_posts()) :
			the_post();

			get_template_part('template-parts/content/content', 'page');

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
	</div>
</main>

<?php
get_footer();
