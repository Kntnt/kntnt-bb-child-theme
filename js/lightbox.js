jQuery(document).ready(function($) {

  var body = $('body');

  // MagnificPopup support
  if(typeof body.magnificPopup != 'undefined') {

    // Same as theme.js except only `a` as selector insetad of `.fl-content`
		if(!body.hasClass('fl-builder') && !body.hasClass('woocommerce')) {
			$('a').filter(function() {
				return /\.(png|jpg|jpeg|gif)(\?.*)?$/i.test(this.href);
			}).magnificPopup({
				closeBtnInside: false,
				type: 'image',
				gallery: {
					enabled: true
				}
			});
		}

  // Context where following code apply
    ctx =
      'body.single-post:not(.fl-builder),' +
      'body.page:not(.fl-builder),' +
      'div.fl-module-rich-text';

    // Lightbox for  youtube.com, vimeo.com, maps.google.com (predefined), and
    // youtu.be, ted.com. See http://dimsemenov.com/plugins/magnific-popup.
    $(
      'a[href^="https://youtu.be/"],' +
      'a[href^="https://www.youtube.com/watch"],' +
      'a[href^="https://vimeo.com/"],' +
      'a[href^="https://www.ted.com/talks/"]',
      ctx
    ).magnificPopup({
      type: 'iframe',
        iframe: {
          patterns: {
            youtu_be: {
              index: 'youtu.be/',
              id: '/',
              src: '//www.youtube.com/embed/%id%?autoplay=1'
            },
            ted: {
              index: 'ted.com/talks',
              id: function(url) {
                id = null;
                matches = /^https:\/\/www.ted.com\/talks\/(.*?)(?:\?language=(.*))?$/.exec(url);
                if (matches) {
                  id = matches[1];
                  if (matches.length > 1) {
                    id = 'lang/' + matches[2] + '/' + id;
                  }
                }
                return id;
              },
              src: 'https://embed-ssl.ted.com/talks/%id%'
            }
          }
        },
        disableOn: 320,
        preloader: false,
        closeBtnInside: false,
        fixedContentPos: true,
        gallery: {
          enabled: true
        }
    });

  }

});

