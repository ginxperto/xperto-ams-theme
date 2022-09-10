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

// force redirect to profile page
$url = home_url('/profile');
$args = array(
    'id' => get_the_author_meta('ID')
);
$final_url = esc_url_raw(add_query_arg($args, $url));
wp_redirect($final_url);
exit();
