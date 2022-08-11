<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package xperto-ams
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class('bg-xperto-neutral-light-2 xperto-auto w-full'); ?>>

<?php wp_body_open(); ?>

<a href="#primary" class="screen-reader-text"><?php esc_html_e( 'Skip to content', 'xperto-ams' ); ?></a>

<div id="page" class="relative min-h-screen flex">

	<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>
