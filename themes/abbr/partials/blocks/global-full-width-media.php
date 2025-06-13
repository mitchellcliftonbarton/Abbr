<?php
  /*
    Full Width Media
    -
    Available Globally
  */

  // get module data
  $module = isset($args['module']) ? $args['module'] : false;

  // fields
  $type = $module['type'] ?? false;
  $image = $module['image'] ?? false;
  $video_mp4 = $module['video_mp4'] ?? false;
  $image_mobile = $module['image_mobile'] ?? false;
  $video_mp4_mobile = $module['video_mp4_mobile'] ?? false;

  // qualifiers
  $has_image = $type === 'image' and $image;
  $has_video = $type === 'video' and $video_mp4;
?>

<?php if ($has_image or $has_video): ?>
  <section class="global-full-width-media global-module h-[85svh] lg:h-[100svh] w-full bg-grey-1 relative">
    <?php if ($has_image): ?>
      <?php
        $image_set = get_image_set(array(
          'image_id' => $image['ID'],
        ));
      ?>

      <figure class="fill-parent <?php if ($image_mobile): ?>hidden lg:block<?php endif; ?>">
        <img 
          data-srcset="<?= $image_set['srcset'] ?>"
          sizes="<?= $image_set['sizes'] ?>"
          alt="<?= $image['alt'] ?>"
          class="object-cover w-full h-full object-center lazyload"
        >
      </figure>

      <?php if ($image_mobile): ?>
        <?php
          $image_set_mobile = get_image_set(array(
            'image_id' => $image_mobile['ID'],
          ));
        ?>

        <figure class="fill-parent block lg:hidden">
          <img 
            data-srcset="<?= $image_set_mobile['srcset'] ?>"
            sizes="<?= $image_set_mobile['sizes'] ?>"
            alt="<?= $image['alt'] ?>"
            class="object-cover w-full h-full object-center lazyload"
          >
        </figure>
      <?php endif; ?>
    <?php elseif ($has_video): ?>
      <video src="<?= $video_mp4['url'] ?>" autoplay muted loop playsinline class="fill-parent"></video>
    <?php endif; ?>
  </section>
<?php endif; ?>