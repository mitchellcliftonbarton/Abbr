<?php
  // get post id
  $post_id = get_the_ID();

  // get modules
  $modules = get_modules(array(
    'post_id' => $post_id
  ));
?>

<?php get_header(); ?>

<div class="modules-wrapper">
  <?php if ($modules): ?>
    <?php foreach ($modules as $module): ?>
      <?php get_template_part('partials/module-wrapper', null, array(
        'module' => $module
      )); ?>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
