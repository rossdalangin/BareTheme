( function() {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function() {
        var header = document.querySelector( '.site-header' );
        if ( ! header ) {
            return;
        }

        var isSticky = document.body.classList.contains('sticky-header');

        if ( isSticky ) {
            var headerOffset = header.offsetTop;
            var adminBar = document.querySelector( '#wpadminbar' );
            var adminBarHeight = adminBar ? adminBar.offsetHeight : 0;

            window.addEventListener('scroll', function() {
                if ( window.pageYOffset > headerOffset ) {
                    document.body.classList.add('header-fixed');
                    header.style.top = adminBarHeight + 'px';
                } else {
                    document.body.classList.remove('header-fixed');
                    header.style.top = '0px';
                }
            });
        }
    } );

} )();
