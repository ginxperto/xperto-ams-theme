<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package xperto-ams
 */

get_header();
?>
<main id="primary" class="w-full flex flex-row items-start">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 xl:mx-auto">
		<section class="w-full">
			<header>
				<h1 class="entry-title text-4xl text-xperto-neutral-dark-1 font-bold w-full"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'xperto-ams'); ?></h1>
			</header>

			<div class="entry-content flex flex-col w-full items-center space-y-6 bg-white rounded-lg p-6 pb-12">
				<img src="<?php echo get_template_directory_uri() . '/images/search_empty.png'; ?>" alt="">
				<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'xperto-ams'); ?></p>
				<?php get_template_part('template-parts/content/content', 'body-search'); ?>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
