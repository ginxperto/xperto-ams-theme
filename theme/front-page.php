<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package xperto-ams
 */

get_header();
?>

<main id="primary" class="container flex flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 lg:flex-row lg:space-y-0 lg:space-x-6 xl:mx-auto">
	<div class="center-content flex flex-col w-full space-y-6 lg:w-2/3 xl:w-3/4">
		<section id="custom-header" class="flex flex-col w-full space-y-4 lg:flex-row lg:space-y-0 lg:space-x-6">
			<!-- lock the aspect ratio on higher resolution -->
			<div id="site-header" class="bg-xperto-custom-header flex flex-col relative w-full aspect-video xl:aspect-3/1 rounded-lg">
				<img src="<?php header_image(); ?>" alt="custom header" class="absolute w-full h-full object-cover mix-blend-overlay rounded-lg" />
				<div class="mt-auto p-6">
					<span class="text-4xl text-white"><?php bloginfo('name'); ?></span>
				</div>
			</div>
		</section><!-- #custom-header -->

		<?php if (is_user_logged_in() && current_user_can('manage_options')) { ?>
			<section class="w-full lg:hidden">
				<?php get_template_part('template-parts/layout/orgadmincard', 'content'); ?>
			</section>
		<?php } ?>

		<section id="membership-upgrade-content" class="w-full">
			<div class="flex flex-row rounded-lg bg-xperto-success-light-80 border border-xperto-success-base p-6">
				<div class="flex flex-col w-full space-y-4">
					<span class="text-2xl text-xperto-success-base font-semibold">Upgrade your membership!</span>
					<p class="text-xperto-neutral-dark-1">Gold members get additional perks, such as unlocking exclusive Gold Member profile badges, exclusive invites to Gold Member-only events and seminars, and so much more!</p>
					<a class="rounded-lg bg-xperto-orange py-3 px-4 text-white flex-none w-full text-center md:w-48 hover:bg-xperto-orange-base-20 active:bg-xperto-orange-base-plus-10" href="http://localhost/dev/wordpress-theme-sbx/register/basic-bundle/">Upgrade Membership</a>
				</div>
				<div class="hidden mx-auto self-center md:inline">
					<img src="<?php echo get_template_directory_uri(); ?>/images/membership_upgrade.png" />
				</div>
			</div>
		</section><!-- #membership-upgrade-content -->

		<section id="feature-content" class="flex flex-col lg:flex-row lg:space-x-6 lg:items-start">
			<div class="flex flex-col space-x-0 space-y-6 xl:flex-row xl:space-x-6 xl:space-y-0">
				<div class="bg-white rounded-lg p-6 w-full xl:w-1/2">
					<span class="text-xperto-neutral-dark-1 font-bold text-2xl">Pinned Announcement</span>
					<div class="mt-6 md:mt-2.5">
						<?php get_template_part('template-parts/layout/pinned', 'content'); ?>
					</div>
				</div>
				<div class="bg-white rounded-lg p-6 w-full xl:w-1/2">
					<span class="text-xperto-neutral-dark-1 font-bold text-2xl">
						Latest
					</span>
					<div class="mt-6 md:mt-2 5">
						<ul>
							<?php
							$recent_posts = wp_get_recent_posts(array(
								'numberposts' => 3, // Number of recent posts thumbnails to display
								'post_status' => 'publish' // Show only the published posts
							));
							foreach ($recent_posts as $post_item) : ?>
								<li class="py-2">
									<a href="<?php echo get_permalink($post_item['ID']) ?>" class="flex items-center">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-xperto-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
											<path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
										</svg>
										<span class="text-xperto-orange ml-2"><?php echo $post_item['post_title'] ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- #feature-content -->
	</div>
	<?php
	// add spacing for cards with org admin
	$org_admin_sidebar = '';
	if (current_user_can('manage_options')) {
		$org_admin_sidebar = 'lg:space-y-6';
	}
	?>
	<div class="secondary-sidebar w-full flex flex-col lg:w-1/3 xl:w-1/4 <?php echo $org_admin_sidebar; ?> ">
		<section class="hidden w-full lg:block">
			<?php get_template_part('template-parts/layout/orgadmincard', 'content'); ?>
		</section>
		<?php get_template_part('template-parts/layout/about', 'content'); ?>
	</div>
</main><!-- #main -->

<?php
// get_sidebar();
