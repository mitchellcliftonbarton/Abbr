<?php
  /*
    Grouped List
    -
    Available Globally
  */

  // get module data
  $module = isset($args['module']) ? $args['module'] : false;

  // fields
  $headline = $module['headline'] ?? false;
  $eyebrow_link = $module['eyebrow_link'] ?? false;
  $groups = $module['groups'] ?? false;
?>

<?php if ($groups): ?>
  <section class="global-grouped-list global-module relative z-10">
    <?php if ($headline or $eyebrow_link): ?>
      <div class="titles flex justify-between items-center border-b border-black pb-4 px-8">
        <?php if ($headline): ?>
          <h2 class="text-lg text-grey-2 tracking-default leading-none font-medium"><?= $headline ?></h2>
        <?php endif; ?>

        <?php if ($eyebrow_link): ?>
          <a href="<?= $eyebrow_link['url'] ?>" target="<?= $eyebrow_link['target'] ?? '_self' ?>" class="circle-link"><?= $eyebrow_link['title'] ?></a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php foreach ($groups as $group): ?>
      <?php
        $group_title = $group['title'] ?? false;
        $group_subtitle = $group['subtitle'] ?? false;
        $group_text = $group['text'] ?? false;
        $group_link = $group['link'] ?? false;
      ?>

      <?php if ($group_title and $group_text and $group_link): ?>
        <a href="<?= $group_link['url'] ?>" target="<?= $group_link['target'] ?? '_self' ?>" class="group-item grid grid-cols-12 gap-8 border-b border-black px-8 pt-3 pb-6">
          <div class="group-item-title col-span-8">
            <h3 class="title text-lg text-grey-3 tracking-default leading-none font-medium"><?= $group_title ?></h3>

            <?php if ($group_subtitle): ?>
              <div class="subtitle text-lg text-grey-2 tracking-default leading-none font-medium w-1/2 max-w-[500px]"><?= $group_subtitle ?></div>
            <?php endif; ?>
          </div>

          <div class="col-span-4 relative">
            <div class="text text-lg text-grey-3 tracking-default leading-none font-medium"><?= nl2br($group_text) ?></div>

            <div class="def-button absolute top-0 right-0"><?= $group_link['title'] ?></div>
          </div>
        </a>
      <?php endif; ?>
    <?php endforeach; ?>
  </section>
<?php endif; ?>