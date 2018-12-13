<?php

namespace Kntnt\BB_Child_Theme;

class BB_Builder_Enhancer {

	public function run() {
		add_filter( 'fl_theme_compile_less_paths', [ $this, 'set_less_paths' ], 13 );
	}

	/**
	 * Load Beaver Builder Page Builder specific Less.
	 */
	public function set_less_paths( $paths ) {
		$paths[] = THEME_DIR . '/less/bb-page-builder.less';
		return $paths;
	}

}
