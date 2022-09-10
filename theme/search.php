<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package xperto-ams
 */

get_header();
?>

<main id="primary" class="w-full flex flex-row items-start">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 xl:mx-auto">

		<?php if (have_posts()) : ?>
			<header>
				<h1 class="entry-title text-4xl text-xperto-neutral-dark-1 font-bold w-full">
					<?php
					/* translators: %s: search query. */
					printf(esc_html__('Search Results for: %s', 'xperto-ams'), '<span>' . get_search_query() . '</span>');
					?>
				</h1>
			</header>

		<?php
			/* Start the Loop */
			while (have_posts()) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part('template-parts/content/content', 'search');

			endwhile;

			the_posts_navigation();
		else :
			get_template_part('template-parts/content/content', 'none');
		endif;
		?>
	</div>
</main>

<?php
// important to enquque footer js
get_footer();
