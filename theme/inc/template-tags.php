<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package xperto-ams
 */

if (!function_exists('xperto_ams_posted_on')) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function xperto_ams_posted_on()
	{
		$time_string = '<time datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date())
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x(' on %s', 'post date', 'xperto-ams'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="text-black hover:text-xperto-orange">' . $time_string . '</a>'
		);

		echo '<span class="text-xperto-neutral-mid-1">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('xperto_ams_posted_by')) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function xperto_ams_posted_by()
	{
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x('Posted by %s', 'post author', 'xperto-ams'),
			'<span><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" class="text-black hover:text-xperto-orange">' . esc_html(get_the_author()) . '</a></span>'
		);

		echo '<span class="text-xperto-neutral-mid-1"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('xperto_ams_entry_footer')) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function xperto_ams_entry_footer()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(', ', 'xperto-ams'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span>' . esc_html__('Posted in %1$s', 'xperto-ams') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'xperto-ams'));
			if ($tags_list) {
				/* translators: 1: list of tags. */
				printf('<span>' . esc_html__('Tagged %1$s', 'xperto-ams') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
			echo '<span>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__('Leave a Comment<span> on %s</span>', 'xperto-ams'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				)
			);
			echo '</span>';
		}

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
	}
endif;

if (!function_exists('xperto_ams_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function xperto_ams_post_thumbnail($additional_attr = array(), $img_additional_attr = array())
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()) :
?>

			<div>
				<?php the_post_thumbnail(); ?>
			</div>

		<?php else : ?>

			<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" class="<?php echo implode(" ", $additional_attr) ?>">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array_merge(
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							)
						),
						$img_additional_attr
					)
				);
				?>
			</a>

<?php
		endif; // End is_singular().
	}
endif;


if (!function_exists('xperto_ams_entry_category')) :
	/**
	 * Prints HTML with meta information for the categories, and tags.
	 */
	function xperto_ams_entry_category()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			$separator = ' ';
			$categories_list = [];
			$post_categories = get_the_category();

			if ($post_categories) {
				foreach ($post_categories as $post_category) {
					$tw_class = "bg-xperto-neutral-light-2 text-xperto-secondary-base text-xs font-bold mr-2 px-2.5 py-0.5 rounded hover:text-xperto-orange";
					$categories_list[] = '<a href="' . esc_url(get_category_link($post_category)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'xperto-ams'), $post_category->name)) . '"> 
						<span class="' . $tw_class . '">' . esc_html($post_category->name) . '</span>
					</a>';
				}
			}

			if ($categories_list) {
				printf('<span>' . esc_html__(' %1$s', 'xperto-ams') . '</span>', implode($separator, $categories_list)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if (!function_exists('xperto_ams_entry_tag')) :
	/**
	 * Prints HTML with meta information for the categories, and tags.
	 */
	function xperto_ams_entry_tag()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			$separator = ' ';
			$tags_list = [];
			$post_tags = get_the_tags();

			if ($post_tags) {
				foreach ($post_tags as $post_tag) {
					$tw_class = "bg-xperto-neutral-light-2 text-xperto-secondary-base text-xs font-bold mr-2 px-2.5 py-0.5 rounded hover:text-xperto-orange";
					$tags_list[] = '<a href="' . esc_url(get_category_link($post_tag)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'xperto-ams'), $post_tag->name)) . '"> 
						<span class="' . $tw_class . '">' . esc_html($post_tag->name) . '</span>
					</a>';
				}
			}

			if ($tags_list) {
				printf('<span>' . esc_html__(' %1$s', 'xperto-ams') . '</span>', implode($separator, $tags_list)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;
