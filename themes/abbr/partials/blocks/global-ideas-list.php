<?php
  /*
    Ideas List
    -
    Available Globally
  */

  // get module data
  $module = isset($args['module']) ? $args['module'] : false;

  $idea_slug_param = isset($_GET['idea_slug']) ? $_GET['idea_slug'] : false;

  // print_r($idea_slug_param);

  // fields
  $type = $module['type'] ?? false;
  $featured_ideas = $module['featured_ideas'] ?? false;

  $ideas = null;

  if ($type === 'all') {
    $ideas = get_posts([
      'post_type' => 'post',
      'posts_per_page' => -1,
      'orderby' => 'date',
      'order' => 'DESC',
    ]);
  } else if ($type === 'manual') {
    $ideas = $featured_ideas;
  }
?>

<?php if ($ideas): ?>
  <section id="all-ideas" class="global-ideas-list global-module px-8">
    <ideas-container class="bg-grey-1 w-5/6 mx-auto max-w-[900px] rounded-2xl aspect-[3.5/2.2] relative flex flex-col justify-between gap-6 overflow-hidden">
      <div class="titles px-6 pt-6 flex-none">
        <div class="flex justify-between items-center border-b border-grey-2 pb-4">
          <h2 class="text-lg text-grey-2 tracking-[-.02em] leading-none font-medium">Abbr. Ideas</h2>

          <a href="/" class="circle-link">Share</a>
        </div>
      </div>

      <div class="all-ideas flex-none flex flex-nowrap gap-2 px-6 overflow-x-auto">
        <?php foreach ($ideas as $key =>$idea): ?>
          <?php
            $idea_main_image = get_field('main_image', $idea);
            $idea_text = get_field('text', $idea);
            $word_count = str_word_count($idea_text);
            $slug = get_post_field('post_name', $idea);

            $idea_main_image_set = get_image_set([
              'image_id' => $idea_main_image['ID']
            ]);

            $is_active = $key === 0;

            if ($idea_slug_param) {
              $is_active = $slug === $idea_slug_param;
            }
          ?>

          <a href="/?idea_slug=<?= $slug ?>#all-ideas" data-no-swup class="idea-link flex-none aspect-[6/2] w-[200px] relative grid grid-cols-4 border border-grey-2 rounded-xl overflow-hidden <?php if ($is_active): ?>active<?php endif; ?>">
            <div class="col-span-1 h-full relative">
              <figure class="fill-parent">
                <img data-srcset="<?= $idea_main_image_set['srcset'] ?>" alt="<?= $idea_main_image['alt'] ?>" sizes="<?= $idea_main_image_set['sizes'] ?>" class="w-full h-full object-cover lazyload">
              </figure>
            </div>

            <div class="col-span-3 text-sm leading-[1.2] p-2">
              <p class="text-black line-clamp-2"><?= get_the_title($idea) ?></p>

              <div class="text-grey-3"><?= $word_count ?> words</div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="flex-1 relative">
        <?php foreach ($ideas as $key =>$idea): ?>
          <?php
            $active = $key === 0;

            $idea_main_image = get_field('main_image', $idea);
            $idea_text = get_field('text', $idea);

            $idea_main_image_set = get_image_set([
              'image_id' => $idea_main_image['ID']
            ]);
          ?>

          <?php if ($idea_main_image and $idea_text): ?>
            <div class="idea-content-item fill-parent grid grid-cols-10 gap-6 px-6 <?php if ($active): ?>active<?php endif; ?>">
              <div class="col-span-4">
                <figure class="aspect-square w-full rounded-2xl overflow-hidden">
                  <img data-srcset="<?= $idea_main_image_set['srcset'] ?>" alt="<?= $idea_main_image['alt'] ?>" sizes="<?= $idea_main_image_set['sizes'] ?>" class="w-full h-full object-cover lazyload">
                </figure>
              </div>

              <div class="text-container col-span-6 pb-32">
                <div class="text rich-text"><?= $idea_text ?></div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </ideas-container>
  </section>
<?php endif; ?>