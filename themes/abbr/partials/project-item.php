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

  $intro_text = get_field('intro_text', $project);

  // get project-sector taxonomy items
  $project_sectors = get_the_terms($project, 'project-sector');

  // turn project sectors into a string separated by commas
  $project_sectors_string = implode(', ', array_map(function($project_sector) {
    return $project_sector->name;
  }, $project_sectors));
?>

<a href="<?= get_the_permalink($project) ?>" class="project-item grid grid-cols-2 gap-8 p-8 rounded-2xl">
  <figure class="aspect-[4/5] col-span-1 rounded-2xl overflow-hidden bg-grey-1">
    <img data-srcset="<?= $main_image_set['srcset'] ?>" alt="<?= $main_image['alt'] ?>" sizes="<?= $main_image_set['sizes'] ?>" class="w-full h-full object-cover lazyload">
  </figure>

  <div class="col-span-1">
    <div>
      <h2 class="text-base text-black tracking-[-.02em] leading-none font-medium"><?= get_the_title($project) ?></h2>

      <?php if ($project_sectors): ?>
        <p class="text-base text-grey-2 tracking-[-.02em] leading-none font-medium"><?= $project_sectors_string ?></p>
      <?php endif; ?>
    </div>

    <?php if ($intro_text): ?>
      <div class="intro-text mt-8 text-base text-black tracking-[-.02em] leading-none font-medium"><?= $intro_text ?></div>
    <?php endif; ?>
  </div>
</a>