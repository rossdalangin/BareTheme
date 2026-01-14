<?php
/**
 * Builder Module: Social Icons
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the social icons module.
 *
 * @param array $module The module data.
 */
function closeclient_render_module_social_icons( $module ) {
	$social_networks = array( 'facebook', 'twitter', 'instagram', 'linkedin' );

	echo '<div class="builder-module-social-icons">';
	foreach ( $social_networks as $network ) {
		if ( ! empty( $module[ $network ] ) ) {
			echo '<a href="' . esc_url( $module[ $network ] ) . '" target="_blank" rel="noopener noreferrer">';
			// In a real-world scenario, you would use an icon font or SVG here.
			echo esc_html( ucfirst( $network ) );
			echo '</a>';
		}
	}
	echo '</div>';
}
