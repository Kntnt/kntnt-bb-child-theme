# Kntnt's Beaver Builder Child Theme

A WordPress child theme to Beaver Builder Theme.

## Description

Kntnt's Beaver Builder Child Theme is an advanced child theme of *[Beaver Builder Theme](https://www.wpbeaverbuilder.com/wordpress-framework-theme/)*, which is included in the Beaver Builder's *Pro* and *Agency* packages.

## Features

Kntnt's Beaver Builder Child Theme provides many features, including:

* Responsive font sizes.
* Beaver Builder Page Builder's breakpoints are used if present.
* Featured image also on pages (in addition to posts).
* Featured image shows caption if provided.
* Featured images links to its original image. Thus it is shown in Beaver Builder's lightbox when clicked on.
* Removes from Customizer everything that can be replaced with *[Beaver Themer](https://www.wpbeaverbuilder.com/beaver-themer/)* if the plugin is active.

## For developers

Don't edit `style.css` or `function.php`. Edit instead following files:

* `custom/fonts.php` — add additional Google fonts to download
* `custom/setting.less` — override  Less variables used by theme
* `custom/style.css` — add your own CSS to be global included
* `custom/script.js`  — add your own JavaScript to be global included
* `custom/function.php` — for your own PHP code

You can use [Less](http://lesscss.org/) in `custom/style.css`, including all variables provided by Beaver Builder's Theme and the additional one described below.

Font families, colors, shade of grays and shadows used by the child theme are defined by following Less variables which you can override in the file `custom/custom.settings`:

- `@service-font` — defaults to the heading font family set in Customizer

- `@monospace-font` — defaults to `monospace`.

- `@primary-color` — defaults to the the accent color set in Customizer

- `@secondary-color` — defaults to the the hover accent color set in Customizer

- `@black` — defaults to `#080808`

- `@almost-black` — defaults to `#333`

- `@dark-gray` — defaults to `#555`

- `@mid-gray` — defaults to `#ccc`

- `@light-gray` — defaults to `#eee`

- `@almost-light-gray` — defaults to `#f5f5f5`

- `@almost-white` — defaults to `#fdfdfd`

- `@white` — defaults to `#fff`

- `@box-shadow` — defaults to `5px 5px 15px @mid-gray`
