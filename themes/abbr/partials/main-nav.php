<?php
  $is_work_page = is_page('work');

  // get project-service-category taxonomy items
  $project_service_categories = get_terms([
    'taxonomy' => 'project-service-category',
    'hide_empty' => true,
  ]);
?>

<header id="main-nav" class="fixed top-0 left-0 px-8 py-6 flex justify-between items-center w-full font-semibold">
  <a href="/" class="block">Abbreviated</a>

  <?php if ($is_work_page): ?>
    <div class="flex items-center gap-8">
      <?php foreach ($project_service_categories as $project_service_category): ?>
        <a href="/work/?service=<?= $project_service_category->slug ?>" class="block project-filter-link">
          <span><?= $project_service_category->name ?></span>
          <sup><?= $project_service_category->count ?></sup>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <a href="/work/" class="block">Projects</a>
  <?php endif; ?>
</header>