<?php
  // get post id
  $post_id = get_the_ID();

  $service_param = isset($_GET['service']) ? $_GET['service'] : false;

  // get featured projects
  $featured_projects = false;
  $featured_projects_field = get_field('featured_projects', 'option');

  if (!$featured_projects_field) {
    $args = [
      'post_type' => 'project',
      'posts_per_page' => -1
    ];

    if ($service_param) {
      $args['tax_query'] = [
        [
          'taxonomy' => 'project-service-category',
          'field' => 'slug',
          'terms' => $service_param
        ]
      ];
    }

    $featured_projects = get_posts($args);
  } else {
    $featured_projects = $featured_projects_field;

    if ($service_param) {
      $featured_projects = array_filter($featured_projects, function($project) use ($service_param) {
        return has_term($service_param, 'project-service-category', $project);
      });
    }
  }

  $featured_projects_ids = array_map(function($project) {
    return $project->ID;
  }, $featured_projects) ?? false;

  // get all projects (exclude featured projects)
  $all_projects = [];

  if ($featured_projects_ids) {
    $all_projects = get_posts([
      'post_type' => 'project',
      'posts_per_page' => -1,
      'post__not_in' => $featured_projects_ids,
    ]);
  } else {
    $args = [
      'post_type' => 'project',
      'posts_per_page' => -1
    ];

    if ($service_param) {
      $args['tax_query'] = [
        [
          'taxonomy' => 'project-service-category',
          'field' => 'slug',
          'terms' => $service_param
        ]
      ];
    }

    $all_projects = get_posts($args);
  }
?>

<?php get_header(); ?>

<section class="pt-40">
  <?php if (count($featured_projects) > 0): ?>
    <div class="featured-projects grid grid-cols-3">
      <?php foreach ($featured_projects as $project): ?>
        <?php get_template_part('partials/project-item', null, array(
          'project' => $project
        )); ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (count($all_projects) > 0): ?>
    <div class="all-projects px-8">
      <h2 class="text-lg text-grey-2 tracking-[-.02em] leading-none font-medium">Archive</h2>

      <div class="grid grid-cols-6 gap-4 mt-8">
        <?php foreach ($all_projects as $project): ?>
          <?php get_template_part('partials/project-item-alt', null, array(
            'project' => $project
          )); ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
