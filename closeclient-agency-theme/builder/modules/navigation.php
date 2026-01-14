<?php
/**
 * Builder Module: Navigation
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the navigation module.
 *
 * @param array $module The module data.
 */
function closeclient_render_module_navigation( $module ) {
	echo '<div class="builder-module-navigation">';
	wp_nav_menu( array(
		'theme_location' => 'menu-1',
		'fallback_cb'    => false,
	) );
	echo '</div>';
}
