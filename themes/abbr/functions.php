<?php

require_once('lib/setup-theme.php');
require_once('lib/custom-functions.php');
require_once('lib/setup-post-types.php');
require_once('lib/setup-admin.php');
require_once("lib/setup-images.php");
require_once('lib/setup-acf.php');


/*
----------------
CORS Headers for WP GraphQL
----------------
*/

add_action('init', function () {
	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');
		header('Access-Control-Max-Age: 3600');
		status_header(200);
		exit;
	}
}, 0);

add_action('send_headers', function () {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type, Authorization');
});


/*
----------------
SETUP THEME
----------------
*/

add_action( 'after_setup_theme', 'setup_theme' );


/*
----------------
POST TYPES/TAXONOMIES
----------------
*/

add_action( 'init', 'setup_post_types' );


/*
----------------
CUSTOM IMAGE SIZES
----------------
*/

// Add custom image sizes
add_action('after_setup_theme', 'add_custom_image_sizes');

// Remove default WordPress image sizes
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes', 20);

// Disable scaled image size
add_filter('big_image_size_threshold', '__return_false');


/*
----------------
ACF
----------------
*/

add_action('acf/fields/flexible_content/layout_title', 'my_acf_flexible_content_layout_title', 10, 4);



/*
----------------
ADMIN UPDATES
----------------
*/

// Remove comments from admin
add_action( 'admin_menu', 'remove_admin_menus' ); // Removes from admin menu
add_action('init', 'remove_comment_support', 100); // Removes from post and pages
add_action( 'wp_before_admin_bar_render', 'remove_comments_admin_bar' ); // Removes from admin bar

// Removes content editor on select pages
add_action('admin_init', 'remove_textarea');
add_action('init', 'remove_editor');

// Remove admin bar
add_filter('show_admin_bar', '__return_false');

// Change 'posts' to 'news'
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );


/*
----------------
ENQUEUE SCRIPTS/FILES
----------------
*/

add_action( 'wp_enqueue_scripts', function() {
	// get directory and uri
	$dir = get_stylesheet_directory();
  $uri = get_stylesheet_directory_uri();

	// get last updated at for css and js
  $style_last_updated_at = filemtime("$dir/dist/main.css");
  $script_last_updated_at = filemtime("$dir/dist/main.js");

	// enqueue css and js with last updated at for caching
  wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/dist/main.css', array(), $style_last_updated_at );
  wp_enqueue_script( 'index', get_stylesheet_directory_uri() . '/dist/main.js', array(), $script_last_updated_at );
});