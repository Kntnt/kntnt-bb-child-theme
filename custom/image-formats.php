<?php

/*
 * Here you can override and add image formats.
 *
 * Add following code snippets to alter or add an image format:
 *
 *   $image_formats['machine_name'] = [
 *     'name'   => 'Human name',
 *     'width'  => 600,
 *     'height' => 400,
 *     'crop'   => false
 *   ];
 *
 * Remember to regerante all images. You can do that with Alex Mills plugin
 * Regenerate Thumbnails or with WP-CLI like this:
 *
 *   wp media regenerate --yes
 *
 * Following image formats are overridden or defined by this theme.
 * You can override any of them.
 *
 *   Machine name             | Human name
 *   =========================|=========================
 *   thumbnail                | Thumbnail
 *   medium                   | Small
 *   medium_large             | Medium
 *   large                    | Large
 *   extra_large              | Extra large
 *   medium_banner            | Small banner
 *   medium_large_banner      | Medium banner
 *   large_banner             | Large banner
 *   extra_large_banner       | Extra large banner
 *   extra_extra_large_banner | Extra extra large banner
 *
 * Notice that the machine name is outputted as a CSS-class.
 *
 * Notice that this theme includes following CSS, that targets images
 * conatining `_banner` in their machine name to make them breakout of their
 * containers and span the full width of the screen.
 *   
 *   @media screen {
 *     p img[class*="wp-image-"][class*='_banner'],
 *     figure.wp-caption img[class*="wp-image-"][class*='_banner'] {
 *       max-width: 100vw !important;
 *       width: 100vw;
 *       margin-left: calc(50% - 50vw);
 *       box-shadow: none;
 *     }
 *   }
 * 
 */


