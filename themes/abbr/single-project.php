<?php
  // get post id
  $post_id = get_the_ID();

  // get modules
  // $modules = get_modules(array(
  //   'post_id' => $post_id
  // ));

  // fields
  $title = get_field('title', $post_id);
  $client_name = get_field('client_name', $post_id);
  $intro_text = get_field('intro_text', $post_id);
  $services = get_field('services', $post_id);
  $team = get_field('team', $post_id);
?>

<?php get_header(); ?>

<div class="px-8">
  <div class="grid grid-cols-12 gap-8">
    <div class="intro col-span-6 pt-20">
      <div class="font-bold">
        <p>for</p>
        <h1><?= $client_name ?? $title ?></h1>
      </div>

      <?php if ($intro_text): ?>
        <div class="text-black tracking-[-.02em] leading-none font-bold"><?= $intro_text ?></div>
      <?php endif; ?>

      <?php if ($services): ?>
        <div class="services">
          <h2 class="square-title uppercase text-grey-2 font-secondary text-sm">Services</h2>

          <div class="rich-text mt-4 text-sm uppercase font-medium leading-none"><?= $services ?></div>
        </div>
      <?php endif; ?>

      <?php if ($team): ?>
        <div class="team">
          <h2 class="square-title uppercase text-grey-2 font-secondary text-sm">Team</h2>

          <div class="rich-text mt-4 text-sm uppercase font-medium leading-none"><?= $team ?></div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
