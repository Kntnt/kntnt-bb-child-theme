<?php

namespace Kntnt\BB_Child_Theme;

class BB_Theme {

  public function __construct() {
    $this->run();
  }

  public function run() {

    // Load Beaver Builder Theme specific LESS
    add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths'], 12);

    // BB THeme comes with Magnific popup. By loading this script, its usage
    // is extended to also include youtube.com, vimeo.com, maps.google.com
    // (predefined), and youtu.be, ted.com.
    add_action('wp_enqueue_scripts', [$this, 'lightbox_script']);

    // Set the default width and height of embeds.
    // See also https://codex.wordpress.org/Content_Width.
    add_filter('embed_defaults', [$this, 'set_embed_default']);

    // This is an awful hack to solve what really is a bug in Beaver Builder's
    // Theme: Google fonts are not loaded with common weights or styles.
    // For instance, if the text font is Lora, only the nrmal weight of roman
    // is loaded. Wuth this hack we also have bold, italic and bold italic.
    add_action('wp_print_styles', [$this, 'fix_fonts']);

    // Change minimum content width in Customizer.
    add_action('customize_register', function ($customizer) {
      $customizer->controls()['fl-content-width']->choices['min'] = 600;
    }, 1e6);

    // Change avatar size.
    add_filter('author_box_avatar_size', function($size) { return 96; });
    
    // HTML5 support.
    add_theme_support('html5', [ 'gallery', 'caption' ]);

  }

  public function set_less_paths($paths) {
    $paths[] = THEME_DIR . '/less/bootstrap.less';
    $paths[] = THEME_DIR . '/less/bb-theme.less';
    return $paths;
  }

  public function set_embed_default($defaults) {
    $defaults['width'] = FLCustomizer::get_mods()['fl-content-width'];
    $defaults['height'] = (int) round(FLCustomizer::get_mods()['fl-content-width'] * 2 / 3);
    return $defaults;
  }
  
  public function fix_fonts() {
    foreach (wp_styles()->registered as $handle => $item) {
      if ('fl-builder-google-fonts-' === substr($handle, 0, 24)) {
        $src = explode('=', $item->src);
        $src[1] = explode('|', $src[1]);
        for ($i = 0; $i < count($src[1]); ++$i) {
          $src[1][$i] = explode(':', $src[1][$i]);
          $src[1][$i][1] = explode(',', $src[1][$i][1]);
          $src[1][$i][1] = array_unique($src[1][$i][1], SORT_NUMERIC);
          array_walk($src[1][$i][1], function(&$weight) { $weight = "{$weight},{$weight}i"; });
          $src[1][$i][1] = implode(',', $src[1][$i][1]);
          $src[1][$i] = implode(':', $src[1][$i]);
        }
        $src[1] = implode('|', $src[1]);
        $item->src = implode('=', $src);
      }
    }
  }
  
  public function lightbox_script() {
error_log(THEME_URI .  '/js/lightbox.js');
    wp_enqueue_script('kntnt-bb-child-theme-lightbox', THEME_URI .  '/js/lightbox.js', ['jquery', 'jquery-magnificpopup'], wp_get_theme()->get('Version'), false);
  }


}
