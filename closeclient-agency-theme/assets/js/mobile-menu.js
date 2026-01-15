( function() {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function() {
        var menuToggle = document.querySelector( '.menu-toggle' );
        var siteNavigation = document.querySelector( '#site-navigation' );

        if ( ! menuToggle || ! siteNavigation ) {
            return;
        }

        menuToggle.addEventListener( 'click', function() {
            siteNavigation.classList.toggle( 'toggled-on' );
            var isExpanded = siteNavigation.classList.contains( 'toggled-on' );
            menuToggle.setAttribute( 'aria-expanded', isExpanded );
        } );
    } );

} )();
