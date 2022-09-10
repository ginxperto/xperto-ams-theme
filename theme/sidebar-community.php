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
		<a href="<?php echo get_admin_url(null, 'post-new.php'); ?>" class="font-bold inline-flex items-center justify-center xperto-button-contained">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
			</svg>
			<span>New Post</span>
		</a>
	<?php endif; ?>
	<aside id="search" class="widget widget_search">
		<?php get_search_form(); ?>
	</aside>
	<?php get_template_part('template-parts/layout/membership-upgrade-sm', 'content'); ?>
	<aside>
		<h3 class="widget-title text-base text-xperto-neutral-dark-1 font-bold mb-4"><?php _e('Recommended Topics', 'shape'); ?></h3>
		<?php xperto_ams_all_tag(); ?>
	</aside>
	<?php if (is_user_logged_in() && is_user_member_of_blog()) : ?>
		<aside id="meta" class="widget mt-8 space-y-4">
			<h3 class="widget-title text-base text-xperto-neutral-dark-1 font-bold mb-4"><?php _e('Connect with members', 'shape'); ?></h3>
			<?php
			$list;
			$current_user = wp_get_current_user();

			// if its already loaded
			if (class_exists('MeprUser')) :
				$rc = new ReflectionClass('MeprUser');

				// instantiate via reflection
				$obj = $rc->newInstanceArgs();

				if (get_class($obj) === MeprUser::class) {
					// this will give all users, we still need to check if they are active
					$users = $obj::all('objects', array(), 'user_registered', 50);

					foreach ($users as $user) {
						// display only when active
						if ($user->is_active()) {
							$list[] = $user;

							// * we only want 3 people
							if (count($list) > 2) {
								break;
							}
						}
					}
				}
			endif;

			foreach ($list as $data) :
				$profile = $data->custom_profile_values();
				$profile_link = add_query_arg("id", $data->ID, home_url('/profile'));
			?>
				<div class="flex flex-row items-start space-x-4">
					<div class="w-1/4">
						<?php if (!empty($profile['mepr_profile_picture'])) : ?>
							<a href="<?php echo $profile_link; ?>" class="hover:text-xperto-orange" alt="Visit profile" title="Visit Profile">
								<img src="<?php echo $profile['mepr_profile_picture']; ?>" class="rounded-full border border-xperto-neutral-light-1 w-14 h-14" />
							</a>
						<?php else :
							echo get_avatar($current_user->ID, 68, '', 'avatar', array('class' => 'rounded-full border border-xperto-neutral-light-1 w-14 h-14'));
						endif;
						?>
					</div>
					<div class="w-3/4 flex flex-col items-start space-y-2">
						<h4>
							<a href="<?php echo $profile_link; ?>" class="hover:text-xperto-orange" alt="Visit profile" title="Visit Profile">
								<?php echo $data->first_name . ' ' . $data->last_name; ?>
							</a>
						</h4>
						<?php if (array_key_exists('mepr_about', $profile)) { ?>
							<p class="text-xperto-neutral-mid-1 text-xs">
								<?php echo wp_trim_words($profile['mepr_about'], 20); ?>
							</p>
						<?php } ?>
						<div class="hidden flex-row justify-evenly sm:flex">
							<?php if (array_key_exists('mepr_facebook', $profile) && !empty($profile['mepr_facebook'])) : ?>
								<a href="<?php echo esc_url($profile['mepr_facebook']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_fb.png' ?>" class="w-5h -5" /></a>
							<?php endif; ?>
							<?php if (array_key_exists('mepr_twitter', $profile) && !empty($profile['mepr_twitter'])) : ?>
								<a href="<?php echo esc_url($profile['mepr_twitter']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_twitter.png' ?>" class="w-5h -5" /></a>
							<?php endif; ?>
							<?php if (array_key_exists('mepr_linkedin', $profile) && !empty($profile['mepr_linkedin'])) : ?>
								<a href="<?php echo esc_url($profile['mepr_linkedin']); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_linkedin.png' ?>" class="w-5h -5" /></a>
							<?php endif; ?>
							<a href="<?php echo esc_url('mailto:' . $data->rec->user_email); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/icon_email.png' ?>" class="w-5h -5" /></a>
						</div>
						<!-- Social Links -->
					</div>
				</div>
			<?php endforeach; ?>
			<div>
				<a href="<?php echo home_url('/members') ?>" class="text-xperto-orange font-bold hover:text-xperto-orange-base-20">See more members</a>
			</div>
		</aside>
	<?php endif; ?>
</aside><!-- #secondary -->