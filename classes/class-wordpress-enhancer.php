<?php

namespace Kntnt\BB_Child_Theme;

class WordPress_Enhancer {

	public function run() {


		// Load WordPress specific LESS
		add_filter( 'fl_theme_compile_less_paths', [ $this, 'set_less_paths' ], 11 );

		// Show caption on featured images
		add_filter( 'post_thumbnail_html', [ $this, 'add_caption_to_featured_image' ], 10, 5 );

		// Replace 'p' with 'figure' around images without caption.
		add_filter( 'the_content', [ $this, 'use_figure_instead_of_p' ], 100 );

	}

	public function set_less_paths( $paths ) {
		$paths[] = THEME_DIR . '/less/wordpress.less';
		return $paths;
	}

	public function add_caption_to_featured_image( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		if ( is_single() ) {
			$caption = get_post( $post_thumbnail_id )->post_excerpt;
			if ( $caption ) {
				$html = "$html<figcaption>$caption</figcaption>";
			}

		}
		return $html;
	}

	public function use_figure_instead_of_p( $html ) {
		return preg_replace( '/<p>\s*(<a\s[^>]*>)?\s*<img\s+([^\s]*?)\s*class="(?=.*?wp-image-(\d+))([^\s]*?)\s*(align[^"\s]+)\s*([^"]*?)"\s*([^>]*)>\s*(<\/a>)?\s*<\/p>/si', '<figure id="attachment_$3" class="wp-caption $5">$1<img $2 class="$4 $6" $7>$8</figure>', $html );
	}

}
