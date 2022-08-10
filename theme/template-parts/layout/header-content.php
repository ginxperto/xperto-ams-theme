<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<aside class="w-44 sticky left-0 top-0 h-screen shadow-left">
	<div id="branding" class="mt-6 mx-5">
		<?php
		the_custom_logo();
		?>
	</div>
	<nav id="site-navigation" class="mt-16 mx-4">
		<?php
		wp_nav_menu(
			array(
				'menu' => 'sidebar',
				'container' => '',
				'theme_location' => 'xperto-sidebar-menu',
				'items_wrap' => '<ul id="" class="space-y-2">%3$s</ul>',
				'walker' => new XpertoCustomNavWalker, // imported via functions.php
				'menu_class' => 'primary-menu reset-list-style'
			)
		);
		?>
	</nav><!-- #site-navigation -->
</aside>

<main id="primary" class="py-5">
	<header id="masthead">
		<div>
			<?php
			the_custom_logo();
			if (is_front_page()) :
			?>
				<h1><?php bloginfo('name'); ?></h1>
			<?php
			else :
			?>
				<p><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
			<?php
			endif;
			$xperto_ams_description = get_bloginfo('description', 'display');
			if ($xperto_ams_description || is_customize_preview()) :
			?>
				<p><?php echo $xperto_ams_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
					?></p>
			<?php endif; ?>
		</div>
	</header><!-- #masthead -->