<?php

function setup_theme() {
	// Add theme supports
	// add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	add_theme_support( 'menus' );
	add_post_type_support('page', 'excerpt');

	// Add ACF global options page
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page(array(
			'page_title' => 'Global Data',
			'menu_title' => 'Global Data',
			'position'   => '60',
			'show_in_graphql' => true,
			'graphql_field_name' => 'global',
		));
	}
}