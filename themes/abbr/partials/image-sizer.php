<?php
/*
Renders an image in a container with its aspect ratio
*/

$image_id = isset($args['image_id']) ? $args['image_id'] : false; // for featured image
$size = isset($args['size']) ? $args['size'] : 'custom-xxl';
$classes = isset($args['classes']) ? $args['classes'] : '';

// set default values
$url = false;
$alt = false;
$width = false;
$height = false;
$aspectRatio = 'auto';

// if imageObject is set, set the values
if ($image_id) {
  $src_object = wp_get_attachment_image_src($image_id, 'full');
  $url = $src_object[0];
  $width = $src_object[1];
  $height = $src_object[2];
  $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
  $aspectRatio = $width && $height ? $width / $height : 'auto';
}

$image_set = false;

if ($image_id) {
  $image_set = get_image_set(array(
    'image_id' => $imageObject['ID'] ?? $image_id,
    'size' => $size
  ));
}
?>

<?php if ($image_id): ?>
  <figure 
    class="w-full relative <?= implode(' ', $classes) ?>"
    style="aspect-ratio: <?= $aspectRatio; ?>;"
  >
    <div class="fill-parent">
      <?php if ($image_set): ?>
        <img 
          class="lazyload media-cover"
          data-srcset="<?= $image_set['srcset'] ?>"
          sizes="<?= $image_set['sizes'] ?>"
          alt="<?= $alt ?>"
        >
      <?php elseif ($url): ?>
        <img 
          class="lazyload media-cover"
          data-src="<?= $url ?>" 
          alt="<?= $alt ?>"
        >
      <?php endif; ?>
    </div>
  </figure>
<?php endif; ?>