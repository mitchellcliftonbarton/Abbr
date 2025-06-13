<?php
  // get project
  $project = isset($args['project']) ? $args['project'] : false;

  if (!$project) {
    return;
  }

  $main_image = get_field('main_image', $project);
  $main_image_set = get_image_set([
    'image_id' => $main_image['ID']
  ]);

  // get project-sector taxonomy items
  $project_sectors = get_the_terms($project, 'project-sector');

  // turn project sectors into a string separated by commas
  $project_sectors_string = implode(', ', array_map(function($project_sector) {
    return $project_sector->name;
  }, $project_sectors));
?>

<a href="<?= get_the_permalink($project) ?>" class="project-item-alt aspect-[6/2] grid grid-cols-4 border border-grey-2 rounded-2xl overflow-hidden">
  <div class="col-span-1 h-full relative">
    <figure class="fill-parent">
      <img data-srcset="<?= $main_image_set['srcset'] ?>" alt="<?= $main_image['alt'] ?>" sizes="<?= $main_image_set['sizes'] ?>" class="w-full h-full object-cover lazyload">
    </figure>
  </div>

  <div class="col-span-3 text-sm leading-[1.2] py-2 px-3">
    <p class="text-black line-clamp-2"><?= get_the_title($project) ?></p>

    <?php if ($project_sectors): ?>
      <p class="text-grey-3"><?= $project_sectors_string ?></p>
    <?php endif; ?>
  </div>
</a>