<?php

namespace Kntnt\BB_Child_Theme;

class BB_Builder_Enhancer {

  public function __construct() {
    $this->run();
  }

  public function run() {
    
    // Load Beaver Builder Page Builder specific LESS
    add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths'], 13);

    // Prevents redirection of pagination with trailing slash. Necessary to
    // make a Beaver Themer "part" with Post Grid at end of a regular post to
    // work. This bug has been reported to the Beaver Builder team.
    add_filter('redirect_canonical', 'fix_redirection', 10, 2);

  }

  public function set_less_paths($paths) {
    $paths[] = THEME_DIR . '/less/bb-page-builder.less';
    return $paths;
  }

  public function fix_redirection($redirect_url, $requested_url) {
    if (is_singular() && preg_filter("/.*\/page\/(\d+)\/?$/", "$1", $requested_url)) return false;
    return $redirect_url;
  }

}
