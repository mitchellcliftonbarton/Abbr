<?php

/*
----------------
Setup All Post Types
----------------
*/

function setup_post_types() {
  create_projects();
  create_project_service_categories();
  create_project_sectors();
}

/*
----------------
Projects
----------------  
*/

function create_projects() {
  register_post_type( 'project',
    array(
      'labels' => array(
        'name' => __( 'Project' ),
        'singular_name' => __( 'Project' ),
        'search_items' =>  __( 'Search Projects' ),
        'all_items' => __( 'All Projects' ),
        'parent_item' => __( 'Parent Project' ),
        'parent_item_colon' => __( 'Parent Project:' ),
        'edit_item' => __( 'Edit Project' ), 
        'update_item' => __( 'Update Project' ),
        'add_new' => __( 'Add New Project' ),
        'add_new_item' => __( 'Add New Project' ),
        'new_item_name' => __( 'New Project Name' ),
        'menu_name' => __( 'Projects' ),
      ),
      'public' => true,
      'has_archives' => false,
			'has_archive' => false,
      'show_in_rest' => true,
      'show_in_nav_menus' => true,
      'supports' => array('title', 'thumbnail'),
      'menu_icon' => 'dashicons-portfolio',
      'show_in_graphql' => true,
      'graphql_single_name' => 'project',
      'graphql_plural_name' => 'projects',
      'rewrite' => array(
        'slug' => 'projects'
      ),
    )
  );
}

/*
----------------
Project Service Categories
--
These apply to Projects. They have a slug of 'project-service-category'.
----------------
*/

function create_project_service_categories() {
  $category_labels = array(
    'name' => _x( 'Services', 'taxonomy general name' ),
    'singular_name' => _x( 'Service', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Services' ),
    'all_items' => __( 'All Services' ),
    'parent_item' => __( 'Parent Service' ),
    'parent_item_colon' => __( 'Parent Service:' ),
    'edit_item' => __( 'Edit Service' ), 
    'update_item' => __( 'Update Service' ),
    'add_new_item' => __( 'Add Service' ),
    'new_item_name' => __( 'New Service Name' ),
    'menu_name' => __( 'Services' ),
  );

  register_taxonomy('project-service-category', array('project'), array(
    'hierarchical' => true,
    'labels' => $category_labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'show_in_graphql' => true,
    'rewrite' => array( 'slug' => 'project-service-category' ),
    'graphql_single_name' => 'projectServiceCategory',
    'graphql_plural_name' => 'projectServiceCategories',
  ));
}

/*
----------------
Project Sectors
--
These apply to Projects. They have a slug of 'project-sector'.
----------------
*/

function create_project_sectors() {
  $category_labels = array(
    'name' => _x( 'Sectors', 'taxonomy general name' ),
    'singular_name' => _x( 'Sector', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Sectors' ),
    'all_items' => __( 'All Sectors' ),
    'parent_item' => __( 'Parent Sector' ),
    'parent_item_colon' => __( 'Parent Sector:' ),
    'edit_item' => __( 'Edit Sector' ), 
    'update_item' => __( 'Update Sector' ),
    'add_new_item' => __( 'Add Sector' ),
    'new_item_name' => __( 'New Sector Name' ),
    'menu_name' => __( 'Sectors' ),
  );

  register_taxonomy('project-sector', array('project'), array(
    'hierarchical' => true,
    'labels' => $category_labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'show_in_graphql' => true,
    'rewrite' => array( 'slug' => 'project-service-category' ),
    'graphql_single_name' => 'projectSector',
    'graphql_plural_name' => 'projectSectors',
  ));
}