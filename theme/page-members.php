<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

get_header();
?>
<main id="primary" class="w-full flex flex-col items-start">
	<div class="container flex flex-col items-start p-4 space-y-6 w-full max-w-[1200px] md:p-8 xl:mx-auto">
		<h3 class="text-4xl text-xperto-neutral-dark-1 font-bold w-full">Members</h3>
		<div class="flex flex-col-reverse items-start md:flex-row space-y-0 p-6 rounded-lg bg-white w-full md:space-x-4 md:items-center">
			<div class="w-full flex flex-row items-center space-x-4 mt-4 md:w-auto md:mt-0">
				<span class="">Sort by:</span>
				<select name="order_by" id="members-sort-by" class="block border border-xperto-neutral-light-1 text-sm p-2.5 rounded-lg focus:bg-white focus:ring-xperto-orange-focus focus-visible:outline-xperto-orange-focus">
					<option value="user_registered">Recently Joined</option>
					<option value="first_name">First Name</option>
					<option value="last_name">Last Name</option>
				</select>
			</div>
			<form role="search" method="get" id="search-form" action="<?php echo esc_url(home_url('/members')); ?>" class="input-group flex flex-1 items-center w-full">
				<div class="relative w-full group">
					<input type="search" class="form-control w-full px-4 py-3 bg-xperto-neutral-light-2 text-xperto-neutral-mid-2 text-sm rounded-lg p-2.5 focus:bg-white focus:ring-xperto-orange-focus focus-visible:outline-xperto-orange-focus" placeholder="Search" aria-label="search" name="s" id="search-input" value="<?php echo esc_attr(get_search_query()); ?>" required />
					<div id="search-icon" class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none group-focus-within:hidden group-focus:hidden">
						<svg aria-hidden="true" class="w-5 h-5 text-xperto-orange" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
						</svg>
					</div>
				</div>
			</form>
		</div>
		<!-- toolbar -->
		<!-- <div class="flow-root w-full"> -->
			<div class="flex flex-wrap w-full space-y-6 lg:space-y-0 lg:gap-6 lg:grid lg:grid-cols-2">
				<?php
				$data;
				$limit = 10;

				// if its already loaded
				if (class_exists('MeprUser')) :
					$rc = new ReflectionClass('MeprUser');

					// instantiate via reflection
					$obj = $rc->newInstanceArgs();

					if ($obj instanceof MeprUser) {
						// * we only one 3 people
						$users = $obj::all('objects', array(), 'user_registered', $limit);

						foreach ($users as $user) {
							// display only when active
							if ($user->is_active()) {
								$data[] = $user;
							}
						}
					}
				endif;

				foreach ($data as $data) :
					$profile = $data->custom_profile_values();
				?>
					<div class="flex w-full min-w-min bg-white rounded-lg p-6">
						<div class="flex flex-row items-start space-x-4 w-full">
							<div class="w-20">
								<?php if (array_key_exists('mepr_profile_picture', $profile)) { ?>
									<a href="#" class="hover:text-xperto-orange" alt="Visit profile" title="Visit Profile">
										<img src="<?php echo $profile['mepr_profile_picture']; ?>" class="rounded-full min-w-[80px] hover:border hover:border-xperto-orange" />
									</a>
								<?php } ?>
							</div>
							<div class="flex flex-col items-start space-y-4">
								<header class="w-full">
									<div class="flex flex-row justify-between">
										<h4>
											<!-- TOOD: Add profile link -->
											<a href="#" class="hover:text-xperto-orange font-bold" alt="Visit profile" title="Visit Profile">
												<?php echo $data->first_name . ' ' . $data->last_name; ?>
											</a>
										</h4>
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
									<?php
									$subs = $data->active_product_subscriptions();
									foreach ($subs as $sub) :
										$product = new MeprProduct($sub);

										if ($product instanceof MeprProduct) :
											// pick color from tailwind
											$color_list = array(
												'text-xperto-member-color-0',
												'text-xperto-member-color-1',
												'text-xperto-member-color-2'
											);
											$color = $color_list[$product->group_order]; ?>
											<span class="text-sm font-bold <?php echo $color; ?>">
												<?php echo $product->post_title; ?>
											</span>
									<?php endif;
									endforeach;
									?>
									<!-- Subscriptions -->
								</header>
								<?php if (array_key_exists('mepr_about', $profile)) { ?>
									<p>
										<?php echo $profile['mepr_about']; ?>
									</p>
								<?php } ?>
								<!-- TOOD: Add social icons here -->
							</div>
						</div>
					</div>
					<!-- Card -->
				<?php endforeach; ?>
			</div>
		<!-- </div> -->
		<!-- Member Cards -->
	</div>
</main>
<?php
get_footer();
