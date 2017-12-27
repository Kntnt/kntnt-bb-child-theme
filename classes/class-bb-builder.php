<?php

namespace Kntnt\BB_Child_Theme;

new BB_Builder();

class BB_Builder {

  public function __construct() {
    $this->run();
  }

  public function run() {
    
    // Prevents redirection of pagination with trailing slash. Necessary to
    // make a Beaver Themer "part" with Post Grid at end of a regular post to
    // work.
    add_filter('redirect_canonical', 'fix_redirection', 10, 2);
  }

  public function fix_redirection($redirect_url, $requested_url) {
    if (is_singular() && preg_filter("/.*\/page\/(\d+)\/?$/", "$1", $requested_url)) return false;
    return $redirect_url;
  }

}
