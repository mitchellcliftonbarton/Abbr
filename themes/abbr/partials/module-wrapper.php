<?php
  // get module
  $module = isset($args['module']) ? $args['module'] : false;

  if (!$module) {
    return;
  }

  $module_name = str_replace('_', '-', $module['acf_fc_layout']); // replace underscores with hyphens

  $template = 'partials/blocks/global-' . $module_name;
?>

<?php if (file_exists(get_template_directory() . '/' . $template . '.php')): ?>
  <?php get_template_part($template, null, array(
    'module' => $module
  )); ?>
<?php else: ?>
  <p>Module <?= $template ?> not found</p>
<?php endif; ?>