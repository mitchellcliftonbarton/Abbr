<?php
  /*
    Text Image
    -
    Available Globally
  */

  // get module data
  $module = isset($args['module']) ? $args['module'] : false;

  // fields
  $headline = $module['headline'] ?? false;
  $link = $module['link'] ?? false;
  $text = $module['text'] ?? false;
  $image = $module['image'] ?? false;
?>

<?php if ($text or $image): ?>
  <section class="global-text-image global-module px-8">
    <?php if ($headline or $link): ?>
      <div class="titles flex justify-between items-center border-b border-grey-2 pb-4">
        <?php if ($headline): ?>
          <h2 class="text-lg text-grey-2 tracking-[-.02em] leading-none font-medium"><?= $headline ?></h2>
        <?php endif; ?>

        <?php if ($link): ?>
          <a href="<?= $link['url'] ?>" target="<?= $link['target'] ?? '_self' ?>" class="play-link font-secondary uppercase text-xs">
            <?php get_template_part('partials/icons/play'); ?>

            <span><?= $link['title'] ?></span>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="text-content grid grid-cols-12 gap-8">
      <?php if ($text): ?>
        <div class="col-span-12 lg:col-span-8">
          <div class="text-lg text-black tracking-[-.02em] leading-[1] rich-text font-medium"><?= $text ?></div>
        </div>
      <?php endif; ?>

      <?php if ($image): ?>
        <div class="col-start-10 col-span-3">
          <?php get_template_part('partials/image-sizer', null, array(
            'image_id' => $image['ID'],
            'classes' => [
              'rounded-2xl',
              'overflow-hidden'
            ]
          )); ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>