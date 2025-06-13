<?php

$colors = [
  'level_1' => '#FCFF7B',
  'level_2' => '#feffc7'
];

/*
----------------------------------------
Main Function
----------------------------------------
*/

function my_acf_flexible_content_layout_title($title, $field, $layout, $i) {
  $new_title = $title;

  switch ($layout['name']) {
    case 'link_item':
      $new_title = link_item_layout($new_title, 'level_1');
      break;
    case 'text_image':
      $new_title = text_layout($new_title, 'level_1', 'headline');
      break;
    case 'full_width_media':
      $new_title = full_width_media_layout($new_title, 'level_1');
      break;
    case 'grouped_list':
      $new_title = text_layout($new_title, 'level_1', 'headline');
      break;
    case 'group_item':
      $new_title = text_layout($new_title, 'level_2', 'title');
      break;
    case 'mini_carousel':
      $new_title = text_layout($new_title, 'level_1', 'carousel_title');
      break;
    case 'carousel_item':
      $new_title = text_layout($new_title, 'level_2', ['author', 'source']);
      break;
    case 'featured_projects':
      $new_title = text_layout($new_title, 'level_1', 'headline');
      break;
  }

  return $new_title;
}


/*
----------------------------------------
Text Layout
----------------------------------------
*/

function text_layout($old_title, $color = 'level_1', $field_name = 'text') {
  global $colors;
  $truncate_length = 100;
  $text = false;

  if (is_array($field_name)) {
    foreach ($field_name as $field) {
      $field_value = get_sub_field($field);

      if ($field_value) {
        $text = $field_value;
        break;
      }
    }
  } else {
    $text = get_sub_field($field_name);
  }

  // strip html tags
  $text = strip_tags($text);

  // truncate text to 300 characters
  $text = truncate($text, $truncate_length);

  return $old_title . ': <span style="background-color: ' . $colors[$color] . ';">' . $text . '</span>';
}

/*
----------------------------------------
Link Item Layout
----------------------------------------
*/

function link_item_layout($old_title, $color = 'level_1') {
  global $colors;
  $link = get_sub_field('link');

  if ($link) {
    return $old_title . ': <span style="background-color: ' . $colors[$color] . ';">' . $link['title'] . '</span>';
  }

  return $old_title;
}

/*
----------------------------------------
Full Width Media Layout
----------------------------------------
*/

function full_width_media_layout($old_title, $color = 'level_1') {
  global $colors;
  $type = get_sub_field('type');
  $image = get_sub_field('image');
  $video_mp4 = get_sub_field('video_mp4');

  if ($type === 'video' and $video_mp4) {
    return $old_title . ': <video src="' . $video_mp4['url'] . '" preload="metadata" style="height: 20px;"></video>';
  } else if ($type === 'image' and $image) {
    return $old_title . ': <img src="' . $image['url'] . '" alt="' . $image['alt'] . '" style="height: 20px;">';
  }

  return $old_title;
}
