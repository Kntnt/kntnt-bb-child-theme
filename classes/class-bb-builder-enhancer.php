<?php

namespace Kntnt\BB_Child_Theme;

class BB_Builder_Enhancer {

	public function run() {
		add_filter( 'fl_theme_compile_less_paths', [ $this, 'set_less_paths' ], 13 );
		add_filter( 'rewrite_rules_array', [ $this, 'pagination_rewrite_rules' ] );
	}

	/**
	 * Load Beaver Builder Page Builder specific Less.
	 */
	public function set_less_paths( $paths ) {
		$paths[] = THEME_DIR . '/less/bb-page-builder.less';
		return $paths;
	}

 	/**
	 * Beaver Builder add rewrite rules for pagination. These handle simpler
	 * permalink structures, including the predefined, but not more complex like
	 * %postname%/%post_id%. A bug report was filed 21 September and 3 December
	 * 2018. Awaiting a fix, this filter adds support for the format
	 * %postname%/%post_id%.
	 */
	public function pagination_rewrite_rules( $rules ) {
		$paged_regex = 'paged-[0-9]{1,}'; // See FLBuilderLoop::$paged_regex_base
		$new_rules[".+/(\d+)/$paged_regex/(\d+)"] = 'index.php?p=$matches[1]&flpaged=$matches[2]'; // See FLBuilderLoop::init_rewrite_rules
		return $new_rules + $rules;
	}

}
