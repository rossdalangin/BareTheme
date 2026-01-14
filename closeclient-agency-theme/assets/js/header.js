( function() {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function() {
		var header = document.querySelector( '.header-builder-main' );
		if ( ! header ) {
			return;
		}

		var isSticky = document.body.classList.contains('sticky-header');

		if ( isSticky ) {
			var headerOffset = header.offsetTop;

			window.onscroll = function() {
				if ( window.pageYOffset > headerOffset ) {
					header.classList.add( 'fixed' );
				} else {
					header.classList.remove( 'fixed' );
				}
			};
		}
	} );

} )();
