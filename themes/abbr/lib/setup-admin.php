<?php

/*
----------------
Get rid of default content editor
----------------
*/

function remove_textarea() {
  remove_post_type_support( 'event', 'editor' );
}

function remove_editor() {
  // remove for all pages
  remove_post_type_support('page', 'editor');
	
	// remove for all posts
	remove_post_type_support('post', 'editor');
}


/*
----------------
Change posts to 'notes' or 'news' (optional)
----------------
*/

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Ideas';
    $submenu['edit.php'][5][0] = 'Idea';
    $submenu['edit.php'][10][0] = 'Add Idea';
    echo '';
}

function change_post_object_label() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = 'Idea';
		$labels->singular_name = 'Idea';
		$labels->add_new = 'Add Idea';
		$labels->add_new_item = 'Add Idea';
		$labels->edit_item = 'Edit Idea';
		$labels->new_item = 'Idea';
		$labels->view_item = 'View Idea';
		$labels->search_items = 'Search Idea';
		$labels->not_found = 'No Idea found';
		$labels->not_found_in_trash = 'No Idea found in Trash';
}

/*
----------------
Stuff to remove comments/posts from admin
----------------
*/

function remove_admin_menus() {
  remove_menu_page( 'edit-comments.php' );

	// remove tags from posts
	register_taxonomy('post_tag', array());
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
	remove_meta_box( 'tagsdiv-post_tag','post','normal' );

	// remove categories from posts
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
	remove_meta_box( 'categorydiv', 'post', 'normal' );

	// remove page attributes from pages
	remove_post_type_support('page','page-attributes');
}

function remove_comment_support() {
  remove_post_type_support( 'post', 'comments' );
  remove_post_type_support( 'page', 'comments' );
}

function remove_comments_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
}