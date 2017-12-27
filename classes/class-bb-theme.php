<?php

namespace Kntnt\BB_Child_Theme;

new BB_Theme();

class BB_Theme {

  public function __construct() {
    $this->run();
  }

  public function run() {

    // Add LESS variables and LESS files.
    add_filter('fl_less_vars', [$this, 'set_less_variables']);

    // Add LESS files. Please notice that the Custom-class adds filters
    // before and after this filetr (with weight 9 and 11, respectively).
    add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths'], 10);

    // The theme doesn't set $content_width. It seems not possible to set it here;
    // it only works in function.php. Another way is to set the fallback values,
    // and that is what we do here. TODO: Set also $content_width.
    add_filter('embed_defaults', [$this, 'set_content_width']);

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

  public function set_less_variables($vars) {

    // Use the gloabal break points of Beaver Bulider's Page Builder
    // as break points for responsive fonts.
    if (class_exists('FLBuilderModel')) {
      $global_settings = FLBuilderModel::get_global_settings();
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

    // Additional fonts
    $vars['service-font'] = $vars['text-font'];
    $vars['monospace-font'] = 'monospace';

    // Additional colors
    $vars['primary-color'] = $vars['accent-color'];
    $vars['secondary-color'] = 'spin(@primary-color, 120)';
    $vars['tertiary-color'] = 'spin(@primary-color, -120)';
    $vars['black'] = '#080808';
    $vars['almost-black'] = '#333';
    $vars['dark-gray'] = '#555';
    $vars['mid-gray'] = '#ccc';
    $vars['light-gray'] = '#eee';
    $vars['almost-light-gray'] = '#f5f5f5';
    $vars['almost-white'] = '#fdfdfd';
    $vars['white'] = '#fff';

    // Additional LESS variables
    $vars['box-shadow'] = "5px 5px 15px @mid-gray";

    return $vars;

  }
  
  public function set_less_paths($paths) {
    $paths[] = THEME_DIR . '/less/responsive-fonts.less';
    $paths[] = THEME_DIR . '/less/wordpress.less';
    $paths[] = THEME_DIR . '/less/bootstrap.less';
    $paths[] = THEME_DIR . '/less/bb-theme.less';
    $paths[] = THEME_DIR . '/less/bb-page-builder.less';
    $paths[] = THEME_DIR . '/less/content.less';
    $paths[] = THEME_DIR . '/less/utilities.less';
    $paths[] = THEME_DIR . '/less/print.less';
    return $paths;
  }
  
  public function set_content_width($defaults) {
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

}
