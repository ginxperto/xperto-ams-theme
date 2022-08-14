<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package xperto-ams
 */
?>

<aside id="secondary-sidebar">
	<?php
	// we don't use the standard sidebar
	// dynamic_sidebar('sidebar-1'); 
	?>
	<aside id="search" class="widget widget_search">
		<?php get_search_form(); ?>
	</aside>
	<aside id="archives" class="widget">
		<h3 class="widget-title"><?php _e('Archives', 'shape'); ?></h3>
		<ul>
			<?php wp_get_archives(array('type' => 'monthly')); ?>
		</ul>
	</aside>
	<aside id="meta" class="widget">
		<h3 class="widget-title"><?php _e('Meta', 'shape'); ?></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</aside>
</aside><!-- #secondary -->