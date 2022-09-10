<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}
?>

<div id="comments" class="rounded-lg bg-white px-6 py-9 w-full">
	<?php
	// You can start editing here -- including this comment!
	if (have_comments()) :
	?>
		<h2 class="text-2xl	font-bold text-black mb-6">
			<?php
			$xperto_ams_comment_count = get_comments_number();
			if ('1' === $xperto_ams_comment_count) {
				echo esc_html__('Comments', 'xperto-ams');
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html(_nx('Comments (%1$s)', 'Comments (%1$s)', $xperto_ams_comment_count, 'comments title', 'xperto-ams')),
					number_format_i18n($xperto_ams_comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol>
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'format'      => 'xperto', // our custom format to make sure we are using the custom walker
					'short_ping' => true,
					'walker' => new XpertoCustomCommentWalker
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if (!comments_open()) :
		?>
			<p><?php esc_html_e('Comments are closed.', 'xperto-ams'); ?></p>
	<?php
		endif;
	endif; // Check for have_comments().

	$comments_args = array(
		'label_submit' => 'Post Comment'
	);
	comment_form($comments_args);
	?>

</div><!-- #comments -->