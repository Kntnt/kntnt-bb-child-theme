# Kntnt's Child Theme for Beaver Builder

A WordPress child theme to Beaver Builder Theme.

## Description

Kntnt's Beaver Builder Child Theme is an advanced child theme of *[Beaver Builder Theme](https://www.wpbeaverbuilder.com/wordpress-framework-theme/)*, which is included in the Beaver Builder's *Pro* and *Agency* packages.

## Features

Kntnt's Beaver Builder Child Theme provides many features, including:

* Responsive font sizes.
* Beaver Builder Page Builder's breakpoints are used if present.
* Removes from Customizer everything that can be replaced with *[Beaver Themer](https://www.wpbeaverbuilder.com/beaver-themer/)* if the plugin is active.

## Companion plugins

You should consider using following [plugins](https://wordpress.org/support/article/must-use-plugins/)
in conjunction with this theme:

* [Kntnt Add Referrer Origin](https://github.com/Kntnt/kntnt-add-referrer-origin)
* [Kntnt Fix Colon in Fragments of Relative URLs](https://github.com/Kntnt/kntnt-fix-colon-in-fragments-of-relative-urls)
* [Kntnt Remove Capital P Dangit](https://github.com/Kntnt/kntnt-remove-capital-p-dangit)
* [Kntnt Remove WP Generator](https://github.com/Kntnt/kntnt-remove-wp-generator)

You should install them as mu-plugins, although they can also be installed as regular plugins as well.

Follow these steps to install them as mu-plugins:

1. In your `wp-content` directory, create a `mu-plugin` directory if not already existing.
2. Download mu-plugin you want to install and unzip it somewhere outside your Wordpress installation.
3. Move or copy the single PHP file inside the unzipped directory into the `mu-plugin` directory.
4. Delete the downloaded zip-file and the unzipped directory and its content. 

## For developers

Don't edit `style.css` or `function.php`. Edit instead following files. Each are explained below.

* `custom/google-fonts.php` — add additional Google fonts to download
* `custom/functions.php` — for your own PHP code
* `custom/image-formats.php` — for your own image formats
* `custom/script.js`  — add your own JavaScript to be global included
* `custom/setting.less` — override  Less variables used by theme
* `custom/style.css` — add your own CSS to be global included

### custom/google-fonts.php

Here you can add additional fonts from Google Fonts. For each font, add a line similar to following:

    <?php $fonts['roboto'] = '300,300i,400,400i,700,700i'; ?>

### custom/functions.php

Here you can add any PHP code that you normally would put in functions.php.

### custom/image-formats.php

Here you can override and add image formats. Add following code snippets to
alter or add an image format:

    $image_formats['machine_name'] = [
      'name'   => 'Human name',
      'width'  => 600,
      'height' => 400,
      'crop'   => false
    ];

Remember to regerante all images. You can do that with Alex Mills plugin
Regenerate Thumbnails or with WP-CLI like this:

    wp media regenerate --yes

Following image formats are overridden or defined by this theme. You can
override any of them.

<table>
<thead>
<tr>
<td>Image size name</td>
<td style="text-align: right">Width</td>
<td style="text-align: right">Height</td>
<td>Crop</td>
<td>Machine name</td>
</tr>
</thead>
<tbody>
<tr>
<td>Extra small</td>
<td style="text-align: right">180</td>
<td style="text-align: right"></td>
<td>No</td>
<td>extra_small</td>
</tr>
<tr>
<td>Extra small (crop)</td>
<td style="text-align: right">180</td>
<td style="text-align: right">180</td>
<td>Yes</td>
<td>thumbnail</td>
</tr>
<tr>
<td>Small</td>
<td style="text-align: right">300</td>
<td style="text-align: right"></td>
<td>No</td>
<td>small</td>
</tr>
<tr>
<td>Small (crop)</td>
<td style="text-align: right">300</td>
<td style="text-align: right">200</td>
<td>Yes</td>
<td>small_crop</td>
</tr>
<tr>
<td>Medium</td>
<td style="text-align: right">600</td>
<td style="text-align: right"></td>
<td>No</td>
<td>medium</td>
</tr>
<tr>
<td>Medium (crop)</td>
<td style="text-align: right">600</td>
<td style="text-align: right">400</td>
<td>Yes</td>
<td>medium_large</td>
</tr>
<tr>
<td>Large</td>
<td style="text-align: right">900</td>
<td style="text-align: right"></td>
<td>No</td>
<td>large</td>
</tr>
<tr>
<td>Extra large</td>
<td style="text-align: right">1920</td>
<td style="text-align: right"></td>
<td>No</td>
<td>extra_large</td>
</tr>
<tr>
<td>Small banner</td>
<td style="text-align: right">1920</td>
<td style="text-align: right">300</td>
<td>Yes</td>
<td>small_banner</td>
</tr>
<tr>
<td>Medium banner</td>
<td style="text-align: right">1920</td>
<td style="text-align: right">600</td>
<td>Yes</td>
<td>medium_banner</td>
</tr>
<tr>
<td>Large banner</td>
<td style="text-align: right">1920</td>
<td style="text-align: right">900</td>
<td>Yes</td>
<td>large_banner</td>
</tr>
<tr>
<td>Extra large banner</td>
<td style="text-align: right">1920</td>
<td style="text-align: right">1200</td>
<td>Yes</td>
<td>extra_large_banner</td>
</tr>
</tbody>
</table>

Notice that the machine name is outputted as a CSS-class.

Notice that this theme includes following CSS, that targets images
conatining `_banner` in their machine name to make them breakout of their
containers and span the full width of the screen.

  @media screen {
    p img[class*="wp-image-"][class*='_banner'],
    figure.wp-caption img[class*="wp-image-"][class*='_banner'] {
      max-width: 100vw !important;
      width: 100vw;
      margin-left: calc(50% - 50vw);
      box-shadow: none;
    }
  }

Notice that this theme modify WordPress crop to use <a href="https://en.wikipedia.org/wiki/Bleed_(printing)">bleed</a>.

### custom/script.js
Here you can add JS code that should be loaded with the theme.

### custom/setting.less
This file overrides LESS variables of the theme. Examples:

    @text-font: Lora, Georgia, serif;
    @heading-font: "Roboto Condensed", Arial, Helvetica, san-serif;
    @monospace-font: "Lucida Console", Monaco, monospace;
    @service-font: @text-font;
    @text-size: 24px;
    @small-text-size: 17px;
    @monospace-text-size: 14px;
    @service-text-size: 14px;
    @accent-color: #2C9A43;
    @secondary-accent-color: @accent-color-hover;
    @black: #080808;
    @almost-black: #333;
    @dark-gray: #555;
    @mid-gray: #ccc;
    @light-gray: #eee;
    @almost-light-gray: #f5f5f5;
    @almost-white: #fdfdfd;
    @white: #fff;
    @box-shadow: 5px 5px 15px @mid-gray;

### custom/style.css

Here you can add CSS code that should be loaded with the theme.
