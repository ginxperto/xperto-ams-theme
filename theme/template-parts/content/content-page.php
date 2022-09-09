<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('w-full'); ?>>
	<headerclass="w-full">
		<?php
		if (!is_front_page()) {
			the_title('<h1 class="entry-title w-full rounded-t-lg self-stretch xl:rounded-none mx-0">', '</h1>');
		} else {
			the_title('<h2 class="entry-title w-full rounded-t-lg self-stretch xl:rounded-none mx-0">', '</h2>');
		}
		?>
		</header>
		<?php xperto_ams_post_thumbnail(); ?>
		<div class="entry-content bg-white rounded-lg p-6">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div>' . esc_html__('Pages:', 'xperto-ams'),
					'after'  => '</div>',
				)
			);
			?>
		</div>
		<?php if (get_edit_post_link()) : ?>
			<footer class="my-4">
				<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__('Edit <span>%s</span>', 'xperto-ams'),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post(get_the_title())
					),
					'<span>',
					'</span>'
				);
				?>
			</footer>
		<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->