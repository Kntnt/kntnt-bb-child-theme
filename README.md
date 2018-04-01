# Kntnt's Beaver Builder Child Theme

A WordPress child theme to Beaver Builder Theme.

## Description

Kntnt's Beaver Builder Child Theme is an advanced child theme of *[Beaver Builder Theme](https://www.wpbeaverbuilder.com/wordpress-framework-theme/)*, which is included in the Beaver Builder's *Pro* and *Agency* packages.

## Features

Kntnt's Beaver Builder Child Theme provides many features, including:

* Responsive font sizes.
* Beaver Builder Page Builder's breakpoints are used if present.
* Removes from Customizer everything that can be replaced with *[Beaver Themer](https://www.wpbeaverbuilder.com/beaver-themer/)* if the plugin is active.

## For developers

Don't edit `style.css` or `function.php`. Edit instead following files. Each are explained below.

* `custom/fonts.php` — add additional Google fonts to download
* `custom/function.php` — for your own PHP code
* `custom/image-formats.php` — for your own image formats
* `custom/script.js`  — add your own JavaScript to be global included
* `custom/setting.less` — override  [Less](http://lesscss.org/) variables used by theme
* `custom/style.css` — add your own CSS to be global included

### custom/fonts.php

Here you can add additional fonts from Google Fonts. For each font, add a line similar to following:

    <?php $fonts['roboto'] = '300,300i,400,400i,700,700i'; ?>

### custom/function.php

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
<td>Thumbnail (crop)</td>
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

Notice that this theme modify how WordPress crop images: The image is scaled down to its minimum size completely covering the bounding box while maintaiing aspect ratio and keeping image center at the center of the bounding box. The *bleed*, i.e. the part of image outside the bounding box, is croped away. (WordPress default behaviour is to scale down the image to its maxium size fitting in the bounding box while maintaiing aspect ratio. This creates black bands above/under or left/right of the image is its aspect ratio differ from the bounding box.)

Notice that the machine name is outputted as a CSS-class.

Notice that the banner formats are supposed to be used inside the shortcode `[pull banner image]…[/pull]` provided by [Kntnt's Pull Contet plugin](https://github.com/TBarregren/kntnt-pull-content). Alternatively, you can add following snippet to  `custom/style.php`:

```php
@media screen {
  p img[class*="wp-image-"][class*='_banner'],
  figure.wp-caption img[class*="wp-image-"][class*='_banner'] {
    max-width: 100vw !important;
    width: 100vw;
    margin-left: calc(~"50% - 50vw");
  }
}
```

You can add a parallax effect to any of the image formats by using [Kntnt's Parallax Images plugin](https://github.com/TBarregren/kntnt-parallax-images) and adding the class `parallax` to the image itself or any elemtn containing it. The image visible height will be half of its actuall size. Thus, if you want a parallax banner with 300 or 600 pixels of height, you should replace `…` in `[pull banner image parallax]…[/pull]` with an image of the format `medium-banner` or `extra-large-banner`, respectively.

### custom/script.js

Here you can add JS code that should be loaded with the theme.

### custom/setting.less

This file overrides [Less](http://lesscss.org/) variables of the theme. Examples:

    @text-font: Lora, Georgia, serif;
    @heading-font: "Roboto Condensed", Arial, Helvetica, san-serif;
    @monospace-font: "Lucida Console", Monaco, monospace;
    @service-font: @text-font;
    @text-size: 24px;
    @small-text-size: 18px;
    @pre-text-size: 14px;
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

Here you can add CSS ad Less code that should be loaded with the theme.

Notice that  that [Less](http://lesscss.org/) evalutates `calc(…)`. To prevent that and leave the evaulation to browsers, you must escape the expression `…` by altering it to `~"…"`. Less will, for an example, evaulate `calc(10px + 5 px)` and replaced it with `15px`, while just replace `calc(~"10px + 5 px")` with `calc(10px + 5 px)` which will be evaulated by browsers.