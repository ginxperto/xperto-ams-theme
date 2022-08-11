<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<footer id="colophon">
	<div class="flex justify-center">
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'xperto-ams' ) ); ?>" class="text-center">
			<?php
			/* translators: %s: CMS name, i.e. WordPress. */
			printf( esc_html__( 'All rights reserved by %s', 'xperto-ams' ), 'XPERTO' );
			?>
		</a>
	</div>
</footer><!-- #colophon -->
