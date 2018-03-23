<?php

namespace Kntnt\BB_Child_Theme;

include THEME_DIR . '/classes/class-wordpress-enhancer.php';
include THEME_DIR . '/classes/class-bb-theme-enhancer.php';
include THEME_DIR . '/classes/class-bb-builder-enhancer.php';
include THEME_DIR . '/classes/class-image-formats.php';

new Theme();

class Theme {

  public function __construct() {
    $this->run();
  }

  public function run() {

    // Create theme enhancers for WordPress, BB Theme and BB Builder.
    new WordPress_Enhancer();
    new BB_Theme_Enhancer();
    new BB_Builder_Enhancer();
    new Image_Formats();

    // Replace Beaver Builder's presets with those found in the presets
    // directory, set less variabels and load less files.
    add_action('after_setup_theme', [$this, 'replace_presets'], 11);
    add_filter('fl_less_vars', [$this, 'set_less_variables']);
    add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths'], 10);    

    // Load custom/*
    add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths_before'], 1);
    add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths_after'], 9999);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_fonts']);
    include THEME_DIR . '/custom/function.php';

  }

  public function replace_presets() {

    // Remove old presets
    \FLCustomizer::remove_preset([
      'default',
      'default-dark',
      'classic',
      'modern',
      'bold',
      'stripe',
      'deluxe',
      'premier',
      'dusk',
      'midnight',
    ]);

    // Add new presets
    foreach (glob(THEME_DIR . '/presets/*.php') as $file) {
      \FLCustomizer::add_preset(basename($file, '.php'), include $file);
    }

  }

  public function set_less_variables($vars) {

    // Use the gloabal break points of Beaver Bulider's Page Builder
    // as break points for responsive fonts.
    if (class_exists('FLBuilderModel')) {
      $global_settings = \FLBuilderModel::get_global_settings();
      $vars['medium_breakpoint'] = $global_settings->medium_breakpoint . 'px';
      $vars['small_breakpoint'] = $global_settings->responsive_breakpoint . 'px';
    }
    else {
      $vars['medium_breakpoint'] = '1024px';
      $vars['small_breakpoint'] = '768px';
    }

    // Express font size relative the text size.
    $text_size = ((float) $vars['text-size']);
    $vars['root-size'] = ($text_size / 1.5) . 'px';
    $vars['h1-size'] = ((float) $vars['h1-size']) / $text_size . 'em';
    $vars['h2-size'] = ((float) $vars['h2-size']) / $text_size . 'em';
    $vars['h3-size'] = ((float) $vars['h3-size']) / $text_size . 'em';
    $vars['h4-size'] = ((float) $vars['h4-size']) / $text_size . 'em';
    $vars['h5-size'] = ((float) $vars['h5-size']) / $text_size . 'em';
    $vars['h6-size'] = ((float) $vars['h6-size']) / $text_size . 'em';

    // Additional LESS variables used by LESS-files included by this theme.
    $vars['service-font'] = '@text-font';
    $vars['monospace-font'] = 'Menlo, Monaco, Consolas, "Andale Mono WT", "Andale Mono", monospace';
    $vars['small-text-size'] = '18px';
    $vars['service-text-size'] = '14px';
    $vars['pre-text-size'] = '14px';
    $vars['secondary-accent-color'] = '@accent-color-hover';
    $vars['black'] = '#080808';
    $vars['almost-black'] = '#333';
    $vars['dark-gray'] = '#555';
    $vars['mid-gray'] = '#ccc';
    $vars['light-gray'] = '#eee';
    $vars['almost-light-gray'] = '#f5f5f5';
    $vars['almost-white'] = '#fdfdfd';
    $vars['white'] = '#fff';
    $vars['box-shadow'] = '5px 5px 15px @mid-gray';

    return $vars;

  }

  public function set_less_paths_before($paths) {
    $paths[] = THEME_DIR . '/custom/setting.less';
    return $paths;
  }

  public function set_less_paths($paths) {
    $paths[] = THEME_DIR . '/less/responsive-fonts.less';
    $paths[] = THEME_DIR . '/less/content.less';
    $paths[] = THEME_DIR . '/less/utilities.less';
    $paths[] = THEME_DIR . '/less/print.less';
    return $paths;
  }

  public function set_less_paths_after($paths) {
    $paths[] = THEME_DIR . '/custom/style.css';
    return $paths;
  }
  
  public function enqueue_scripts() {
    wp_enqueue_script('kntnt-bb-child-theme-custom-js', THEME_URI .  '/custom/script.js', ['jquery'], wp_get_theme()->get('Version'), true);
  }
  
  public function enqueue_fonts() {
    $fonts = [];
    include THEME_DIR . '/custom/fonts.php';
    foreach ($fonts as $font => $variants) {
      wp_enqueue_style("kntnt-bb-child-$font", "https://fonts.googleapis.com/css?family=$font:$variants");
    }
  }

}
