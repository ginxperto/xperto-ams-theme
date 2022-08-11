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

<main id="primary" class="container flex flex-col items-center p-4 space-y-6 max-w-[1200px] md:p-8 xl:mx-auto">
	<section id="custom-header" class="flex flex-col w-full space-y-4 lg:flex-row lg:space-y-0 lg:space-x-6">
		<!-- lock the aspect ratio on higher resolution -->
		<div id="site-header" class="bg-xperto-custom-header flex flex-col relative w-full aspect-3/1 rounded-lg lg:w-2/3">
			<img src="<?php header_image(); ?>" alt="custom header" class="absolute w-full h-full object-cover mix-blend-overlay rounded-lg" />
			<div class="mt-auto p-6">
				<span class="text-4xl text-white"><?php bloginfo('name'); ?></span>
			</div>
		</div><!-- $site-header -->

		<!-- Make this same height on higher resolution -->
		<div id="org-admin-menu" class="flex flex-col items-center w-full bg-xperto-orange-light-90 border border-xperto-orange p-6 rounded-lg lg:w-1/3 lg:self-stretch">
			<span class="w-full text-xperto-neutral-dark-1 font-bold text-2xl">
				<?php esc_html_e('Org Admin Tools', 'xperto-ams'); ?>
			</span>
			<?php
			wp_nav_menu(
				array(
					'menu' => 'org-admin',
					'container' => '',
					'theme_location' => 'xperto-orgadmin-menu',
					'items_wrap' => '<ul id="" class="space-y-0 mt-3 w-full">%3$s</ul>',
					'walker' => new XpertoCustomOrgAdminNavWalker, // imported via functions.php
				)
			);
			?>
		</div>
	</section><!-- #custom-header -->

	<!--  class="flex flex-col space-y-4 xl:flex-row xl:space-y-0 xl:space-x-6"  -->
	<section id="feature-content" class="flex flex-col-reverse space-y-4 mt-6 xl:flex-row xl:space-x-6 xl:items-start">
		<div class="flex flex-col w-3/4 space-y-6">
			<div class="flex flex-row rounded-lg bg-xperto-success-light-80 border border-xperto-success-base p-6">
				<div class="flex flex-col w-full space-y-4">
					<span class="text-2xl text-xperto-success-base font-semibold">Upgrade your membership!</span>
					<p class="text-xperto-neutral-dark-1">Gold members get additional perks, such as unlocking exclusive Gold Member profile badges, exclusive invites to Gold Member-only events and seminars, and so much more!</p>
					<a class="rounded-lg bg-xperto-orange py-3 px-4 text-white flex-none w-full text-center md:w-48 hover:bg-xperto-orange-base-20 active:bg-xperto-orange-base-plus-10" href="http://localhost/dev/wordpress-theme-sbx/register/basic-bundle/">Upgrade Membership</a>
				</div>
				<div class="mx-auto">
					<img src="<?php echo get_template_directory_uri(); ?>/images/membership_upgrade.png" />
				</div>
			</div>
			<div class="flex flex-row space-x-6">
				<div class="bg-white rounded-lg p-6 lg:w-1/2">
					<span>Pinned Announcement</span>
				</div>
				<div class="bg-white rounded-lg p-6 lg:w-1/2">
					<span>
						Latest
					</span>
				</div>
			</div>
		</div>
		<div class="flex flex-col bg-white rounded-lg p-6 w-1/4">
			<span>About</span>
			<p class="whitespace-normal">Creative media founded in 2007, Webdesign-Inspiration helps UX designers, marketing teams and entrepreneurs to be inspired. 62.000 creative persons already joined our community. Every day, more than 3000 ux designers browse our articles and our daily feed of UX inspirations.</p>
		</div>
	</section>
	<!-- #feature-content -->

	<?php
	// if (have_posts()) :

	// if (is_home() && !is_front_page()) :
	?>
	<!-- <header>
				<h1><?php single_post_title(); ?></h1>
			</header> -->
	<?php
	// endif;

	/* Start the Loop */
	// while (have_posts()) :
	// 	the_post();

	// 	/*
	// 		 * Include the Post-Type-specific template for the content.
	// 		 * If you want to override this in a child theme, then include a file
	// 		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
	// 		 */
	// 	get_template_part('template-parts/content/content', get_post_type());

	// endwhile;

	// the_posts_navigation();

	// else :

	// get_template_part('template-parts/content/content', 'none');

	// endif;
	?>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
