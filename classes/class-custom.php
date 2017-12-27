<?php

namespace Kntnt\BB_Child_Theme;

new Custom();

class Custom {

  public function __construct() {
    $this->run();
  }
  
  public function run() {
     add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths_before'], 9);
     add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths_after'], 11);
     add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
     add_action('wp_enqueue_scripts', [$this, 'enqueue_fonts']);
     include THEME_DIR . '/custom/function.php';
 }
 
  public function set_less_paths_before($paths) {
    $paths[] = THEME_DIR . '/custom/setting.less';
    return $paths;
  }

  public function set_less_paths_after($paths) {
    $paths[] = THEME_DIR . '/custom/custom.css';
    return $paths;
  }
  
  public function enqueue_scripts() {
    wp_enqueue_script('kntnt-bb-child-theme-custom-js', THEME_URI .  '/custom/custom.js', ['jquery'], wp_get_theme()->get('Version'), true);
  }
  
  public function enqueue_fonts() {
    $fonts = [];
    include THEME_DIR . '/custom/fonts.php';
    foreach ($fonts as $font => $variants) {
      wp_enqueue_style("kntnt-bb-child-$font", "https://fonts.googleapis.com/css?family=$font:$variants");
    }
  }

}
