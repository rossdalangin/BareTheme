( function( $, wp ) {
	'use strict';

	wp.customize.preview.bind( 'update-module-style', function( data ) {
		var styleId = 'module-style-' + data.moduleId;
		var $style = $( '#' + styleId );

		if ( $style.length ) {
			$style.replaceWith( data.style );
		} else {
			$('head').append( data.style );
		}
	});

} )( jQuery, wp );
