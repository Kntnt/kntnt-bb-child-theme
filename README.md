# Kntnt's child theme of Beaver Builder Theme

This is a child theme of [Beaver Builder's Theme](https://www.wpbeaverbuilder.com/wordpress-framework-theme/). Its main features includes

* Responsive font sizes.
* Feaured image also on pages (not only posts).
* Featured image links to original image (allows it to be displayed in lightbox).
* Adhere to global breakpoints of Beaver Builder's Page Builder plugin.
* Many small but important improvements.

Don't edit `style.css` or `function.php`. Edit instead following files:

* `custom/custom.settings` — for overriding LESS variables used by theme (see below)
* `custom/custom.css` — for frontend CSS
* `custom/custom.js`  — for frontend JavaScript
* `custom/custom.php` — for backend PHP

You can use [LESS](http://lesscss.org/) in `custom.css`, including all variables provided by Beaver Builder's Theme and the additional one described below.

Font families, colors, shade of grays and shadows used by the child theme are defined by following LESS variables which you can override in the file `custom/custom.settings`:

- `@body-font` — defaults to the text font family set in Customizer

- `@heading-font` — defaults to the heading font family set in Customizer

- `@service-font` — defaults to the heading font family set in Customizer

- `@monospace-font` — defaults to [Inconsolata](https://fonts.google.com/specimen/Inconsolata) which the child theme inlcudes

- `@primary-color` — defaults to the the primary color set in Customizer

- `@secondary-color` — defaults to the the secondary color set in Customizer

- `@tertiary-color` — defaults to `#74C4D6`

- `@black` — defaults to `#080808`

- `@almost-black` — defaults to `#333`

- `@dark-gray` — defaults to `#555`

- `@mid-gray` — defaults to `#ccc`

- `@light-gray` — defaults to `#eee`

- `@almost-light-gray` — defaults to `#f5f5f5`

- `@almost-white` — defaults to `#fdfdfd`

- `@white` — defaults to `#fff`

- `@box-shadow` — defaults to `5px 5px 15px @mid-gray`
