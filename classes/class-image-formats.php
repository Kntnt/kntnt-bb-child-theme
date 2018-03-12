<?php

namespace Kntnt\BB_Child_Theme;

class Image_Formats {

  private static $built_in_sizes = [ 'thumbnail', 'medium', 'medium_large', 'large' ];

  public function __construct() {
    $this->setup_image_formats();
    add_filter('image_size_names_choose', array( $this, 'update_ui' ), 9999);
    add_filter('image_resize_dimensions', [$this, 'crop_with_bleed'], 10, 6);
  }

  public static function image_formats() {

    $image_formats['thumbnail'] = [
      'name' => __('Thumbnail', 'kntnt-bb-child-theme'),
      'width' => 180,
      'height' => 180,
      'crop' => true
    ];

    $image_formats['medium'] = [
      'name' => __('Small', 'kntnt-bb-child-theme'),
      'width' => 300,
      'height' => 9999,
      'crop' => false
    ];

    $image_formats['medium_large'] = [
      'name' => __('Medium', 'kntnt-bb-child-theme'),
      'width' => 600,
      'height' => 9999,
      'crop' => false
    ];

    $image_formats['large'] = [
      'name' => __('Large', 'kntnt-bb-child-theme'),
      'width' => 900,
      'height' => 9999,
      'crop' => false
    ];

    $image_formats['extra_large'] = [
      'name' => __('Extra large', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 9999,
      'crop' => false
    ];

    $image_formats['medium_banner'] = [
      'name' => __('Small banner', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 200,
      'crop' => true
    ];

    $image_formats['medium_large_banner'] = [
      'name' => __('Medium banner', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 400,
      'crop' => true
    ];

    $image_formats['large_banner'] = [
      'name' => __('Large banner', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 600,
      'crop' => true
    ];

    $image_formats['medium_parallax'] = [
      'name' => __('Small parallax banner', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 200,
      'crop' => true
    ];

    $image_formats['medium_large_parallax'] = [
      'name' => __('Medium parallax banner', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 400,
      'crop' => true
    ];

    $image_formats['large_parallax'] = [
      'name' => __('Large parallax banner', 'kntnt-bb-child-theme'),
      'width' => 1920,
      'height' => 600,
      'crop' => true
    ];

    return $image_formats;

  }

  public function setup_image_formats() {

    $image_formats = self::image_formats();
    include THEME_DIR . '/custom/image-formats.php';  

    foreach ($image_formats as $slug => $format) {
      $this->setImageSize($slug, $format['width'], $format['height'], $format['crop'], $format['name']);
    }

  }

  public function update_ui($sizes) {

    // Remove all previously defined images sizes that is overriden by ImageSizeBuilder.
    $sizes = array_diff_key($sizes, $this->names);

    // Remove all images sizes with an empty name.
    $names = array_filter($this->names);

    // Return all image sizes defined by this class and the leftovers.
    return array_merge($names, $sizes);

  }

 public function crop_with_bleed($payload, $src_w, $src_h, $dst_w, $dst_h, $crop) {

    if (!$crop) return null;

    $scale_factor = max($dst_w / $src_w, $dst_h / $src_h);

    $crop_w = round($dst_w / $scale_factor);
    $crop_h = round($dst_h / $scale_factor);

    $src_x = floor(($src_w - $crop_w) / 2);
    $src_y = floor(($src_h - $crop_h) / 2);

    return array(0, 0, (int) $src_x, (int) $src_y, (int) $dst_w, (int) $dst_h, (int) $crop_w, (int) $crop_h);

  }

  private function setImageSize($slug, $width, $height, $crop, $name) {

    // Store the name in order
    $this->names[$slug] = $name;

    // Update the image size
    add_image_size($slug, $width, $height, $crop);

    // Update the options for the built-in image sizes
    if (in_array($slug, self::$built_in_sizes)) {
      update_option($slug . '_size_w', $width);
      update_option($slug . '_size_h', $height);
      if ($slug == 'thumbnail') {
        update_option($slug . '_size_crop', $crop);
      }
    }

  }

}
