<?php

namespace Kntnt\BB_Child_Theme;

class BB_Theme_Enhancer {

	public function run() {

		// Load Beaver Builder Theme specific Less.
		add_filter( 'fl_theme_compile_less_paths', [ $this, 'set_less_paths' ], 12 );

		// BB Theme comes with Magnific popup. By loading this script, its usage
		// is extended to also include youtube.com, vimeo.com, maps.google.com
		// (predefined), and youtu.be, ted.com.
		add_action( 'wp_enqueue_scripts', [ $this, 'lightbox_script' ] );

		// Set the default width and height of embeds.
		// See also https://codex.wordpress.org/Content_Width.
		add_filter( 'embed_defaults', [ $this, 'set_embed_default' ] );

		// This is an awful hack to solve what really is a bug in Beaver Builder's
		// Theme: Google fonts are not loaded with common weights or styles.
		// For instance, if the text font is Lora, only the nrmal weight of roman
		// is loaded. Wuth this hack we also have bold, italic and bold italic.
		add_action( 'wp_print_styles', [ $this, 'fix_fonts' ] );

		// Change avatar size.
		add_filter( 'author_box_avatar_size', function ( $size ) { return 96; } );

		// HTML5 support.
		add_theme_support( 'html5', [ 'gallery', 'caption' ] );

		// Change minimum content width in Customizer.
		add_action( 'customize_register', [ $this, 'modify_customizer' ], 1e9 );

		// Add shortcode for rendering search icon. Use it as a menu item (see
		// https://github.com/TBarregren/kntnt-shortcodes-in-menu) when
		// the themes header is replaced with Beaver Themer.
		add_shortcode( 'bb-nav-search', [ $this, 'bb_nav_search' ] );

	}

	public function set_less_paths( $paths ) {
		$paths[] = THEME_DIR . '/less/bootstrap.less';
		$paths[] = THEME_DIR . '/less/bb-theme.less';
		$paths[] = THEME_DIR . '/less/bb-nav-search.less';
		return $paths;
	}

	public function set_embed_default( $defaults ) {
		$defaults['width'] = \FLCustomizer::get_mods()['fl-content-width'];
		$defaults['height'] = (int) round( \FLCustomizer::get_mods()['fl-content-width'] * 2 / 3 );
		return $defaults;
	}

	public function fix_fonts() {
		foreach ( wp_styles()->registered as $handle => $item ) {
			if ( 'fl-builder-google-fonts-' === substr( $handle, 0, 24 ) ) {
				$src = explode( '=', $item->src );
				$src[1] = explode( '|', $src[1] );
				for ( $i = 0; $i < count( $src[1] ); ++ $i ) {
					$src[1][ $i ] = explode( ':', $src[1][ $i ] );
					$src[1][ $i ][1] = explode( ',', $src[1][ $i ][1] );
					$src[1][ $i ][1] = array_unique( $src[1][ $i ][1], SORT_NUMERIC );
					array_walk( $src[1][ $i ][1], function ( &$weight ) { $weight = "{$weight},{$weight}i"; } );
					$src[1][ $i ][1] = implode( ',', $src[1][ $i ][1] );
					$src[1][ $i ] = implode( ':', $src[1][ $i ] );
				}
				$src[1] = implode( '|', $src[1] );
				$item->src = implode( '=', $src );
			}
		}
	}

	public function lightbox_script() {
		wp_enqueue_script( 'kntnt-bb-child-theme-lightbox', THEME_URI . '/js/lightbox.js', [ 'jquery', 'jquery-magnificpopup' ], wp_get_theme()->get( 'Version' ), false );
	}

	public function modify_customizer( $customizer ) {

		// Change minimum content width in Customizer.
		$customizer->controls()['fl-content-width']->choices['min'] = 600;

		// Remove all controls, sections and panels from Customizer corresponding
		// to features that can be replaced by Beaver Themer if the filter
		// `kntnt_bb_child_theme_for_themer` returns `true`. By default
		// the filter returns true if Beaver Themer is activated.
		if ( apply_filters( 'kntnt_bb_child_theme_for_themer', defined( 'FL_THEME_BUILDER_VERSION' ) ) ) {
			$customizer->remove_panel( 'fl-header' );
			$customizer->remove_panel( 'fl-footer' );
			$customizer->remove_section( 'fl-content-blog' );
			$customizer->remove_section( 'fl-content-archives' );
			$customizer->remove_section( 'fl-content-posts' );
			$customizer->remove_section( 'fl-content-woo' );
		}

	}

	public function bb_nav_search( $atts ) {
		ob_start();
		get_template_part( 'includes/nav-search' );
		return '<div class="bb-nav-search-shortcode">' . ob_get_clean() . '</div>';
	}

}
