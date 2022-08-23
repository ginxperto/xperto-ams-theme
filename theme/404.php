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
		<?php get_template_part('template-parts/content/content', 'not-found'); ?>
	</div>
</main>

<?php
get_footer();
