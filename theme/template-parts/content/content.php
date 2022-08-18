<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg p-6'); ?>>
	<header class="w-full">
		<?php
		if ('post' === get_post_type()) :
		?>
			<div class="mb-5 flex flex-row justify-between">
				<div class="flex-1">
					<span class="text-xperto-neutral-mid-2"> / </span>
					<?php
					xperto_ams_posted_by();
					xperto_ams_posted_on();
					?>
				</div>
				<div class="hidden flex-row justify-evenly sm:flex">
					<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="fb-xfbml-parse-ignore">
						<img src="<?php echo get_template_directory_uri() . '/images/icon_fb.png' ?>" class="w-5h -5" />
					</a>
					<a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo the_title() . ' ' . urlencode(get_permalink()); ?>">
						<img src="<?php echo get_template_directory_uri() . '/images/icon_twitter.png' ?>" class="w-5h -5" />
					</a>
					<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo the_title(); ?>&summary=<?php echo the_title(); ?>&source=<?php echo home_url() ?>">
						<img src="<?php echo get_template_directory_uri() . '/images/icon_linkedin.png' ?>" class="w-5h -5" />
					</a>
				</div>
			</div>
		<?php endif; ?>
		<?php
		if (is_singular()) :
			the_title('<h1 class="entry-title text-black text-2xl font-bold mb-4 mx-0 hover:text-xperto-orange">', '</h1>');
		else :
			the_title('<h2 class="entry-title text-black text-2xl font-bold mb-4 mx-0 hover:text-xperto-orange"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
		endif; ?>
		<div class="mb-6">
			<?php xperto_ams_entry_category(); ?>
			<?php xperto_ams_entry_tag(); ?>
		</div>
	</header>

	<?php xperto_ams_post_thumbnail(); ?>

	<div class="entry-content w-full">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__('Continue reading<span> "%s"</span>', 'xperto-ams'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			)
		);

		wp_link_pages(
			array(
				'before' => '<div>' . esc_html__('Pages:', 'xperto-ams'),
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->