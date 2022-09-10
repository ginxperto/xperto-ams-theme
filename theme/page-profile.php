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

// force user to login
if (!is_user_logged_in()) {
	wp_redirect(home_url('?loginaction=xpertoOauthLogin'));
	exit();
}

// * Do before everything, prevent 'header already sent error'
if (!isset($_GET['id'])) {
	$url = home_url('/profile');
	$args = array(
		'id' => get_current_user_id()
	);
	$final_url = esc_url_raw(add_query_arg($args, $url));
	wp_redirect($final_url);
	exit();
}

get_header();
?>
<main id="primary" class="w-full flex flex-row items-start">
	<div class="container flex flex-1 flex-col items-start p-4 space-y-6 max-w-[1200px] md:p-8 xl:mx-auto">

		<?php
		get_template_part('template-parts/content/content', 'profile');
		?>
	</div>
</main>

<?php
// important to enquque footer js
get_footer();
