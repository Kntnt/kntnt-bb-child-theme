<?php

namespace Kntnt\BB_Child_Theme;

include THEME_DIR . '/classes/class-wordpress-enhancer.php';
include THEME_DIR . '/classes/class-bb-theme-enhancer.php';
include THEME_DIR . '/classes/class-bb-builder-enhancer.php';
include THEME_DIR . '/classes/class-image-formats.php';

new Theme;

class Theme {

    public function __construct() {
        $this->run();
    }

    public function run() {

        // Create theme enhancers for WordPress, BB Theme and BB Builder.
        (new WordPress_Enhancer)->run();
        (new BB_Theme_Enhancer)->run();
        (new BB_Builder_Enhancer)->run();
        (new Image_Formats)->run();

        // Replace Beaver Builder's presets with those found in the presets
        // directory, set less variables and load less files.
        add_action('after_setup_theme', [$this, 'replace_presets'], 11);
        add_filter('fl_less_vars', [$this, 'set_less_variables']);
        add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths'], 10);

        // Load custom/*
        add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths_before'], 1);
        add_filter('fl_theme_compile_less_paths', [$this, 'set_less_paths_after'], 9999);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_google_fonts']);
        if (is_readable(THEME_DIR . '/custom/functions.php')) {
            include THEME_DIR . '/custom/functions.php';
        }

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

        // Use the global break points of Beaver Builder's Page Builder
        // as break points for responsive fonts.
        if (class_exists('FLBuilderModel')) {
            $global_settings = \FLBuilderModel::get_global_settings();
            $vars['medium_breakpoint'] = $global_settings->medium_breakpoint . 'px';
            $vars['small_breakpoint'] = $global_settings->responsive_breakpoint . 'px';
        }
        else {
            $vars['medium_breakpoint'] = '992px';
            $vars['small_breakpoint'] = '768px';
        }

        // Express font size relative root font size.
        $vars['root-size'] = '16px';
        $vars['root-size-medium'] = '13.4px';
        $vars['root-size-small'] = '11.2px';
        $vars['text-size'] = ((float)$vars['text-size']) / $vars['root-size'] . 'rem';
        $vars['small-text-size'] = 16 / $vars['root-size'] . 'rem';
        $vars['service-text-size'] = 13 / $vars['root-size'] . 'rem';
        $vars['h1-size'] = ((float)$vars['h1-size']) / $vars['root-size'] . 'rem';
        $vars['h2-size'] = ((float)$vars['h2-size']) / $vars['root-size'] . 'rem';
        $vars['h3-size'] = ((float)$vars['h3-size']) / $vars['root-size'] . 'rem';
        $vars['h4-size'] = ((float)$vars['h4-size']) / $vars['root-size'] . 'rem';
        $vars['h5-size'] = ((float)$vars['h5-size']) / $vars['root-size'] . 'rem';
        $vars['h6-size'] = ((float)$vars['h6-size']) / $vars['root-size'] . 'rem';

        // Additional LESS variables for fonts
        $vars['service-font'] = '@text-font';
        $vars['monospace-font'] = 'Menlo, Monaco, Consolas, "Andale Mono WT", "Andale Mono", monospace';
        $vars['monospace-text-size'] = '87.5%';

        // Additional LESS variables for colors
        $vars['secondary-accent-color'] = '@accent-hover-color';
        $vars['black'] = '#080808';
        $vars['almost-black'] = '#282828';
        $vars['dark-gray'] = '#808080';
        $vars['mid-gray'] = '#d8d8d8';
        $vars['light-gray'] = '#e0e0e0';
        $vars['almost-light-gray'] = '#f0f0f0';
        $vars['almost-white'] = '#f8f8f8';
        $vars['white'] = '#ffffff';
        $vars['box-shadow'] = '5px 5px 15px @mid-gray';

        return $vars;

    }

    public function set_less_paths_before($paths) {
        if (is_readable(THEME_DIR . '/custom/setting.less')) {
            $paths[] = THEME_DIR . '/custom/setting.less';
        }
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
        if (is_readable(THEME_DIR . '/custom/style.css')) {
            $paths[] = THEME_DIR . '/custom/style.css';
        }
        return $paths;
    }

    public function enqueue_scripts() {
        if (is_readable(THEME_DIR . '/custom/script.js')) {
            wp_enqueue_script('kntnt-bb-child-theme-custom-js', THEME_URI . '/custom/script.js', ['jquery'], wp_get_theme()->get('Version'), true);
        }
    }

    public function enqueue_google_fonts() {
        if (is_readable(THEME_DIR . '/custom/google-fonts.php')) {
            $fonts = [];
            include THEME_DIR . '/custom/google-fonts.php';
            foreach ($fonts as $font => $variants) {
                wp_enqueue_style("kntnt-bb-child-$font", "https://fonts.googleapis.com/css?family=$font:$variants");
            }
        }
    }

}
