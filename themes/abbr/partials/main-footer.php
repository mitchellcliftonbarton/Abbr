<?php
$footer_text_main = get_field('footer_text_main', 'option');
$footer_text_sub = get_field('footer_text_sub', 'option');
$footer_links = get_field('footer_links', 'option');
?>

<footer id="main-footer" class="p-8">
  <div class="inner p-6 rounded-2xl flex flex-col justify-between items-center">
    <div class="flex justify-between items-start w-full pb-[178px]">
      <?php if ($footer_text_main): ?>
        <div class="text-white text-xl tracking-[-.01em] leading-[.9] font-medium translate-y-[-.12em]"><?= nl2br($footer_text_main) ?></div>
      <?php endif; ?>

      <a href="/">
        <?php get_template_part('partials/icons/logo'); ?>
      </a>
    </div>

    <?php if ($footer_links or $footer_text_sub): ?>
      <div class="flex justify-between items-end w-full">
        <?php if ($footer_text_sub): ?>
          <div class="text-white text-xs rich-text tracking-[-.02em] leading-[1] max-w-[350px]"><?= $footer_text_sub ?></div>
        <?php endif; ?>

        <?php if ($footer_links): ?>
          <div class="links flex gap-8">
            <?php foreach ($footer_links as $link): ?>
              <?php
                $link_object = $link['link'];
              ?>

              <a href="<?= $link_object['url'] ?>" target="<?= $link_object['target'] ?? '_self' ?>" class="play-link text-white text-xs font-secondary uppercase">
                <?php get_template_part('partials/icons/play'); ?>
                <span><?= $link_object['title'] ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</footer>