( function( $, wp ) {
	'use strict';

	wp.customize( 'closeclient_header_layout', function( value ) {
		value.bind( function( to ) {
			// Just trigger a refresh for now. A full AJAX preview is more complex.
			wp.customize.previewer.refresh();
		} );
	} );

	wp.customize( 'closeclient_footer_layout', function( value ) {
		value.bind( function( to ) {
			wp.customize.previewer.refresh();
		} );
	} );

} )( jQuery, wp );
