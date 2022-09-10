<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<div id="main-wrapper" class="w-full min-h-screen  ">
	<header id="masthead" class="one-col-header w-full bg-white p-5 shadow-bottom top-0 z-10">
			<div class="flex justify-center items-center h-10">
				<?php
				if (has_custom_logo() ):
					the_custom_logo();
				else: ?>
					<a  href="<?php echo get_home_url(); ?>" class="h-full object-contain">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/xperto_logo_min.png" class="h-full"/>
					</a>

				<?php endif; ?>
				
			</div>	
	</header><!-- #masthead --> 