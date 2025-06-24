<?php
  /*
    Mini Carousel
    -
    Available Globally
  */

  // get module data
  $module = isset($args['module']) ? $args['module'] : false;

  // fields
  $background_image = $module['background_image'] ?? false;
  $carousel_title = $module['carousel_title'] ?? false;
  $carousel_link = $module['carousel_link'] ?? false;
  $carousel_items = $module['carousel_items'] ?? false;

  $background_image_set = get_image_set([
    'image_id' => $background_image['ID']
  ])
?>

<?php if ($background_image_set and $carousel_items): ?>
  <section class="global-mini-carousel global-module h-[100svh] w-full max-h-[900px] min-h-[500px] relative bg-grey-1 flex justify-center items-center">
    <figure class="fill-parent">
      <img data-srcset="<?= $background_image_set['srcset'] ?>" sizes="<?= $background_image_set['sizes'] ?>" alt="<?= $background_image['alt'] ?>" class="fill-parent object-cover lazyload">
    </figure>

    <mini-carousel class="block w-1/4 aspect-[4/5.8] relative rounded-xl flex flex-col justify-between">
      <div class="flex justify-between items-center flex-none p-6">
        <?php if ($carousel_title): ?>
          <h2 class="text-sm uppercase text-grey-2 tracking-default leading-none font-medium"><?= $carousel_title ?></h2>
        <?php endif; ?>

        <?php if (count($carousel_items) > 1): ?>
          <div class="flex gap-3">
            <?php foreach ($carousel_items as $key =>$carousel_item): ?>
              <button class="carousel-button <?php if ($key === 0): ?>active<?php endif; ?>"></button>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="swiper flex-1 relative">
        <div class="swiper-wrapper">
          <?php foreach ($carousel_items as $key => $carousel_item): ?>
            <?php
              $quote = $carousel_item['quote'] ?? false;
              $author = $carousel_item['author'] ?? false;
              $source = $carousel_item['source'] ?? false;
            ?>

            <?php if ($quote): ?>
              <div class="swiper-slide fill-parent pt-4 px-6 <?php if ($key === 0): ?>active<?php endif; ?>">
                <div class="quote text-lg tracking-default leading-none font-medium">
                  <p>“</p>
                  <div><?= $quote ?></div>
                </div>

                <?php if ($author or $source): ?>
                  <div class="mt-6 flex flex-col items-start gap-1">
                    <?php if ($author): ?>
                      <div class="author text-sm tracking-default leading-none font-medium"><?= $author ?></div>
                    <?php endif; ?>

                    <?php if ($source): ?>
                      <div class="source text-sm tracking-default leading-none font-medium opacity-50"><?= $source ?></div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>

      <?php if ($carousel_link): ?>
        <div class="p-6 flex-none">
          <a href="<?= $carousel_link['url'] ?>" target="<?= $carousel_link['target'] ?? '_self' ?>" class="circle-link circle-link-white"><?= $carousel_link['title'] ?></a>
        </div>
      <?php endif; ?>
    </mini-carousel>
  </section>
<?php endif; ?>