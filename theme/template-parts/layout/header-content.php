<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

?>

<div id="main-sidebar" class="bg-white shadow-right sidebar w-44 p-4 absolute inset-y-0 left-0 transform -translate-x-full transition duration-200 ease-in-out z-50 md:relative md:translate-x-0">
	<div id="branding" class="mt-2">
		<?php
		the_custom_logo();
		?>
	</div>
	<nav id="site-navigation" class="mt-16">
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
</div><!-- #main-sidebar -->

<div id="main-wrapper" class="flex-1">
	<header id="masthead" class="w-full bg-white p-4 shadow-bottom sticky top-0 md:px-8 z-10">
		<div class="flex justify-between items-center md:justify-end">
			<div class="md:hidden">
				<button id="mobile-menu-button" class="focus:outline-none">
					<svg class="h-6 w-6 text-xperto-neutral-mid-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
					</svg>
				</button>
			</div>
			<?php
			if (is_user_logged_in()) {
			?>
				<div id="nav-menu" class="flex items-center self-end space-x-6">
					<div class="hidden md:flex">
						<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.8384 26.1509C12.8384 26.1578 12.8379 26.1648 12.8379 26.1717C12.8379 27.9179 14.2534 29.3335 15.9996 29.3335C17.7458 29.3335 19.1614 27.9179 19.1614 26.1717C19.1614 26.1648 19.1609 26.1578 19.1608 26.1509H12.8384Z" fill="#A5A5A5" />
							<path d="M26.0949 22.1984L23.2493 18.0184C23.2493 16.7388 23.2493 13.6121 23.2493 12.8033C23.2493 9.28623 20.7446 6.35457 17.4217 5.6939V4.08798C17.4216 3.30296 16.7852 2.6665 16.0001 2.6665C15.2151 2.6665 14.5787 3.30296 14.5787 4.08798V5.69396C11.2558 6.35468 8.75103 9.28635 8.75103 12.8033C8.75103 14.1802 8.75103 17.2204 8.75103 18.0184L5.90546 22.1985C5.60572 22.6388 5.57402 23.2087 5.82308 23.6795C6.07214 24.1504 6.56108 24.4448 7.09373 24.4448H24.9065C25.4392 24.4448 25.9281 24.1503 26.1772 23.6795C26.4263 23.2087 26.3945 22.6387 26.0949 22.1984Z" fill="#A5A5A5" />
						</svg>
					</div>
					<!-- notification -->
					<div class="relative inline-block">
						<a href="#" id="user-menu" class="flex items-center space-x-3">
							<?php
							if (is_user_logged_in()) :
								$current_user = wp_get_current_user();

								if (($current_user instanceof WP_User)) : ?>
									<span class="text-xperto-neutral-dark-1 font-bold"><?php echo esc_html($current_user->display_name); ?></span>
									<?php
									// * Lets try to load the memberpress user details
									$rc = new ReflectionClass('MeprUser');

									// instantiate via reflection
									$mepr_user = $rc->newInstanceArgs(array($current_user->ID));

									// we have a memberpress user loaded
									if ($mepr_user instanceof MeprUser) {
										// get custom fields
										$profile = $mepr_user->custom_profile_values();

										// load only if exists
										if (!empty($profile['mepr_profile_picture'])) { ?>
											<img src="<?php echo $profile['mepr_profile_picture']; ?>" class="rounded-full border border-xperto-neutral-light-1 w-10 h-10" />
									<?php
										} else {
											// else get default avater as fallback
											echo get_avatar($current_user->ID, 40, '', 'avatar', array('class' => 'rounded-full'));
										}
									} else {
										// else get default avater as fallback
										echo get_avatar($current_user->ID, 40, '', 'avatar', array('class' => 'rounded-full'));
									}
									?>
									<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0.865111 2.95662L5.69879 7.4785C5.86669 7.6433 6.06855 7.7745 6.29225 7.86414C6.51594 7.95378 6.75678 8 7.00013 8C7.24349 8 7.48433 7.95378 7.70802 7.86414C7.93172 7.7745 8.13364 7.6433 8.30153 7.4785L13.1352 2.95662C13.39 2.71353 13.5629 2.40584 13.6325 2.07169C13.7021 1.73753 13.6654 1.39162 13.5268 1.07682C13.3882 0.762026 13.154 0.492194 12.853 0.300779C12.5521 0.109364 12.1977 0.00478184 11.8338 0H2.16645C1.80257 0.00478184 1.4482 0.109364 1.14726 0.300779C0.846316 0.492194 0.612083 0.762026 0.473523 1.07682C0.334964 1.39162 0.298217 1.73753 0.367825 2.07169C0.437434 2.40584 0.610337 2.71353 0.865111 2.95662Z" fill="#A5A5A5" />
									</svg>
							<?php
								endif;
							endif;
							?>
						</a><!-- #user-menu -->

						<?php if (is_user_logged_in()) { ?>
							<ul id="user-menu-popover" class="py-4 px-2 rounded-lg flex flex-col space-y-2 bg-white shadow-xperto-pop-over-shadow origin-top-right absolute right-0 mt-5 w-56 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none transition ease-out duration-100 transform opacity-0" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
								<li class=" flex flex-col px-4 py-2 rounded-lg hover:text-xperto-orange hover:bg-xperto-orange-light-90">
									<a href="<?php echo home_url("/profile"); ?>">My Profile</a>
								</li>
								<li class=" flex flex-col px-4 py-2 rounded-lg hover:text-xperto-orange hover:bg-xperto-orange-light-90">
									<a href="<?php echo home_url("/account"); ?>">Account Settings</a>
								</li>
								<li class=" flex flex-col px-4 py-2 rounded-lg hover:text-xperto-orange hover:bg-xperto-orange-light-90">
									<?php wp_loginout(); ?>
								</li>
							</ul>
							<!-- #user-menu-popover -->
						<?php } ?>
					</div>
				</div><!-- #nav-menu -->
			<?php } else { ?>
				<div id="nav-menu" class="flex items-center space-x-6">
					<a href="<?php echo wp_login_url() ?>" class="rounded-lg bg-xperto-orange text-white p-3 hover:bg-xperto-orange-base-20 active:bg-xperto-orange-base-plus-10">
						<span class="whitespace-nowrap text-white font-bold">Login</span>
					</a>
				</div>
			<?php } ?>
		</div>
	</header><!-- #masthead -->