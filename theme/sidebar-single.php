<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package xperto-ams
 */
?>

<aside id="secondary-sidebar" class="flex flex-col space-y-6">
	<?php
	// we don't use the standard sidebar
	// dynamic_sidebar('sidebar-1'); 
	?>
	<?php if (current_user_can('edit_posts')) : ?>
		<a href="<?php echo get_admin_url(null, 'post-new.php'); ?>" class="bg-xperto-orange text-white font-bold rounded-lg py-3 inline-flex items-center justify-center focus:outline-none hover:bg-xperto-orange-base-20 active:bg-xperto-orange-base-plus-10">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
			</svg>
			<span>New Post</span>
		</a>
	<?php endif; ?>
	<aside id="search" class="widget widget_search">
		<?php get_search_form(); ?>
	</aside>
	<aside id="org-summary" class="widget flex flex-col space-y-2">
		<?php
		$current_user = get_user_by('id', get_the_author_meta('id'));

		if (($current_user instanceof WP_User)) : ?>
			<?php
			// * Lets try to load the memberpress user details
			$rc = new ReflectionClass('MeprUser');
			$profile_link;

			// instantiate via reflection
			$mepr_user = $rc->newInstanceArgs(array($current_user->ID));

			// we have a memberpress user loaded
			if ($mepr_user instanceof MeprUser) {
				// get custom fields
				$profile = $mepr_user->custom_profile_values();
				$profile_link = add_query_arg("id", $mepr_user->ID, home_url('/profile'));

				// load only if exists
				if (!empty($profile['mepr_profile_picture'])) { ?>
					<a href="<?php echo $profile_link ?>">
						<img src="<?php echo $profile['mepr_profile_picture']; ?>" class="rounded-full border border-xperto-neutral-light-1 w-16 h-16" />
					</a>
			<?php
				} else {
					// else get default avater as fallback
					echo get_avatar($current_user->ID, 64, '', 'avatar', array('class' => 'rounded-full'));
				}
			} else {
				// else get default avater as fallback
				echo get_avatar($current_user->ID, 64, '', 'avatar', array('class' => 'rounded-full'));
			}
			?>

			<a href="<?php echo $profile_link ?>">
				<span class="text-xperto-neutral-dark-1 font-semibold"><?php echo esc_html($current_user->display_name); ?></span>
			</a>
			<?php // we have a memberpress user loaded
			if ($mepr_user instanceof MeprUser) :
				// get custom fields
				$profile = $mepr_user->custom_profile_values();
			?>
				<p class="text-xperto-neutral-mid-1 text-xs">
					<?php echo wp_trim_words($profile['mepr_about'], 20); ?>
				</p>
		<?php
			endif;
		endif;
		?>
	</aside>
	<?php get_template_part('template-parts/layout/membership-upgrade-sm', 'content'); ?>
	<aside>
		<h3 class="widget-title text-base text-xperto-neutral-dark-1 font-bold mb-4"><?php _e('Related content', 'shape'); ?></h3>
		<ul>
			<?php
			$categories = get_the_category();
			$category;

			if (!empty($categories)) {
				$category = $categories[0]->name;
			}

			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'category_name' => $category,
				'posts_per_page' => 3,
			);
			$arr_posts = new WP_Query($args);

			if ($arr_posts->have_posts()) :
				foreach ($arr_posts->posts as $post_item) :
			?>
					<li class="py-2">
						<a href="<?php echo get_permalink($post_item->ID); ?>" class="flex items-center">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-xperto-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
							</svg>
							<span class="text-xperto-orange ml-2"><?php echo $post_item->post_title; ?></span>
						</a>
					</li>
			<?php endforeach;
			endif; ?>
		</ul>
	</aside>
	<aside>
		<h3 class="widget-title text-base text-xperto-neutral-dark-1 font-bold mb-4"><?php _e('Recommended Topics', 'shape'); ?></h3>
		<?php xperto_ams_all_tag(); ?>
	</aside>
</aside><!-- #secondary -->