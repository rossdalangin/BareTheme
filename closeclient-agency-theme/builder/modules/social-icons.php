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
	$social_networks = array(
		'facebook'  => 'https://facebook.com',
		'twitter'   => 'https://twitter.com',
		'instagram' => 'https://instagram.com',
		'linkedin'  => 'https://linkedin.com',
	);

	echo '<div class="builder-module-social-icons">';
	foreach ( $social_networks as $network => $link ) {
		echo '<a href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer">';
		// In a real-world scenario, you would use an icon font or SVG here.
		echo esc_html( ucfirst( $network ) );
		echo '</a>';
	}
	echo '</div>';
}
