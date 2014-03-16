/*
	License: GNU General Public License v2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
	Description: Functionality specific to hinagata Theme. Provides helper functions to enhance the theme experience.
 */
( function( $ ) {


	$( function() {

		// thickbox
		$( 'a[ href$="jpg" ], a[ href$="jpeg" ], a[ href$="JPG" ], a[ href$="JPEG" ], a[ href$="png" ], a[ href$="gif" ]' ).addClass( 'thickbox' );

		// scroll to id
		$( 'a[ href^="#" ]' ).click( function( event ) {
			var scrollOffset = 0;
			var scrollTarget = $( this ).attr( 'href' );
			scrollTarget = $( scrollTarget );
			if ( scrollTarget.length ) {
				var scrollPosition = scrollTarget.offset().top - scrollOffset;
				$( 'html, body' ).animate( { scrollTop: scrollPosition }, 'normal' );
				event.preventDefault();
			}
		} );

		// responsive medias
		$( 'video, iframe, embed, object' ).each( function() {
			var mediaRatio = Math.ceil( $( this ).attr( 'height' ) / $( this ).attr( 'width' ) * 100 ) + 1;
			$( this ).wrap( '<div class="responsive_media" style="padding-bottom:' + mediaRatio + '%">' );
		} );

		// media queries navigation
		var switchStatus = 0;
		$( 'h4#menu-toggle' ).click( function () {
			$( 'div#page' ).toggleClass( 'switch' );
			switchStatus = switchStatus == 0 ? 1 : 0;
			if ( switchStatus == 1 ) {
				setTimeout( function() {
					$( 'div#page' ).toggleClass( 'height0' );
				}, 100 );
			} else {
				$( 'div#page' ).toggleClass( 'height0' );
			}
			setTimeout( function() { $( 'nav#site-navigation' ).toggleClass( 'positionabsolute' ); }, 200 );
		} );

	} );

} )( jQuery );
