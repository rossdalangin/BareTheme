<?php
/**
 * Builder Module: Logo
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the logo module.
 *
 * @param array $module The module data.
 */
function closeclient_render_module_logo( $module ) {
	echo '<div class="builder-module-logo">';
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
	}
	echo '</div>';
}
