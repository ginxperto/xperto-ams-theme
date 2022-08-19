<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<section class="flex flex-col w-full">
	<header class="w-full">
		<h1 class="entry-title px-0 mx-0 text-4xl text-xperto-neutral-dark-1 font-bold w-full"><?php esc_html_e('Nothing Found', 'xperto-ams'); ?></h1>
	</header>

	<div class="entry-content flex flex-col w-full items-center space-y-6 bg-white rounded-lg p-6">
		<?php
		if (is_home() && current_user_can('publish_posts')) :
			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'xperto-ams'),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url(admin_url('post-new.php'))
			);
		elseif (is_search()) :
		?>
			<img src="<?php  echo get_template_directory_uri() . '/images/search_empty.png'; ?>" alt="">
			<p class="w-full"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'xperto-ams'); ?></p>
		<?php
			// get_search_form('body');
			get_template_part('template-parts/content/content', 'body-search');
		else :
		?>
			<img src="<?php  echo get_template_directory_uri() . '/images/search_empty.png'; ?>" alt="">
			<p class="w-full"><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'xperto-ams'); ?></p>
		<?php
			// get_search_form('body');
			get_template_part('template-parts/content/content', 'body-search');
		endif;
		?>
	</div>
</section>