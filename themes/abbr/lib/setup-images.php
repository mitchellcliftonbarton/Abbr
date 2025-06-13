<?php

function add_custom_image_sizes() {
    add_image_size('custom-xs', 300, 9999); // 300 pixels wide (and unlimited height)
    add_image_size('custom-sm', 648, 9999); // 648 pixels wide (and unlimited height)
    add_image_size('custom-md', 768, 9999); // 768 pixels wide (and unlimited height)
    add_image_size('custom-lg', 1024, 9999); // 1024 pixels wide (and unlimited height)
    add_image_size('custom-xl', 1280, 9999); // 1280 pixels wide (and unlimited height)
    add_image_size('custom-xxl', 1920, 9999); // 1920 pixels wide (and unlimited height)
}

function remove_default_image_sizes($sizes) {
    // remove medium_large, large, 1536x1536, 2048x2048. We keep 'thumbnail' and 'medium' because they are used in the media library
    $sizes = array_diff($sizes, array('medium_large', 'large', '1536x1536', '2048x2048'));

    return $sizes;
}