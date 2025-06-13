<?php
  /*
  Defaults
  */

  // get post
  $post_id = get_the_ID();
  $post_slug = null;

  if ($post_id) {
    $post_slug = get_post($post_id)->post_name;
  }

  // get site metadata
  $metadata = get_site_metadata([
    'post_id' => $post_id
  ]);

  // determine body classes
  $extra_body_classes = [];

  // add slug class
  $extra_body_classes[] = 'page-' . $post_slug;

  if (is_singular('project')) {
    $extra_body_classes[] = 'project-page';
  }

  // favicon
  $favicon = get_field('favicon', 'option');

  /*
  End Defaults
  */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?= $metadata['description'] ?>" />
    <meta property="og:title" content="<?= $metadata['title'] ?>" />
    <meta property="og:type" content="<?= $metadata['url'] ?>" />
    <meta property="og:url" content="<?= $metadata['url'] ?>" />
    <meta property="og:description" content="<?= $metadata['description'] ?>" />
    <meta property="og:site_name" content="<?= $metadata['title'] ?>" />
    <meta property="og:locale" content="en_US" />

    <?php if ($metadata['og_image']): ?>
      <meta property="og:image" content="<?= $metadata['og_image'] ?>" />
    <?php endif; ?>

    <?php if ($favicon): ?>
      <link rel="icon" href="<?= $favicon['url'] ?>" />
    <?php endif; ?>

    <?php wp_head(); ?>
  </head>

  <body
    class="<?= implode(' ', $extra_body_classes) ?>"
  >
    <?php wp_body_open(); ?>

    <?php get_template_part('partials/main-nav'); ?>
      
    <main id="swup">

      