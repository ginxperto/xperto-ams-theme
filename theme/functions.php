<?php

/**
 * xperto-ams functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package xperto-ams
 */

if (!defined('XPERTO_AMS_VERSION')) {
	// Replace the version number of the theme on each release.
	define('XPERTO_AMS_VERSION', '1.0.0');
}

if (!function_exists('xperto_ams_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function xperto_ams_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on xperto-ams, use a find and replace
		 * to change 'xperto-ams' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('xperto-ams', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'xperto-sidebar-menu' => esc_html__('Sidebar Menu', 'xperto-ams'),
				'xperto-orgadmin-menu' => esc_html__('Org Admin Menu', 'xperto-ams')
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'xperto_ams_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Add support for core custom header.
		 *
		 * @link https://codex.wordpress.org/Custom_Headers
		 */
		add_theme_support('custom-header', array(
			'default-image'      => get_template_directory_uri() . '/images/custom_header.png',
			'default-text-color' => '000',
			'width'              => 900,
			'height'             => 300,
			'flex-width'         => true,
			'flex-height'        => true,
		));

		/**
		 * Add responsive embeds and block editor styles.
		 */
		add_theme_support('responsive-embeds');
		add_theme_support('editor-styles');
		add_editor_style('style-editor.css');
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'xperto_ams_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function xperto_ams_content_width()
{
	$GLOBALS['content_width'] = apply_filters('xperto_ams_content_width', 640);
}
add_action('after_setup_theme', 'xperto_ams_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function xperto_ams_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'xperto-ams'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'xperto-ams'),
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'xperto_ams_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function xperto_ams_scripts()
{
	wp_enqueue_style('xperto-ams-style', get_stylesheet_uri(), array(), XPERTO_AMS_VERSION);
	wp_enqueue_script('xperto-ams-script', get_template_directory_uri() . '/js/script.min.js', array(), XPERTO_AMS_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'xperto_ams_scripts');

/**
 * Add the block editor class to TinyMCE.
 *
 * This allows TinyMCE to use Tailwind Typography styles with no other changes.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function xperto_ams_tinymce_add_class($settings)
{
	$settings['body_class'] = 'block-editor-block-list__layout';
	return $settings;
}
add_filter('tiny_mce_before_init', 'xperto_ams_tinymce_add_class');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Require onboarding functions
 */
require get_template_directory() . '/util/XpertoCustomOnBoarding.php';

/**
 * Require custom walker
 */

require get_template_directory() . '/util/XpertoCustomNavWalker.php';

/**
 * Require custom walker
 */

require get_template_directory() . '/util/XpertoCustomOrgAdminNavWalker.php';

/**
 * Require custom walker
 */

require get_template_directory() . '/util/XpertoCustomCommentWalker.php';

/**
 * Require custom filters and actions
 */
require get_template_directory() . '/util/XpertoCustomMeprHooks.php';

function add_favicon() {
	if( ! get_option( 'site_icon', false ) ) {
    // Show favicon
	error_log('<link rel="shortcut icon" type="image/png" href="'.get_template_directory_uri().'/images/xperto_fav.png" />');
	echo '<link rel="shortcut icon" type="image/png" href="'.get_template_directory_uri().'/images/xperto_favicon.png" />';
}
	error_log(get_option( 'site_icon', false ));
}

add_action('wp_head', 'add_favicon');
