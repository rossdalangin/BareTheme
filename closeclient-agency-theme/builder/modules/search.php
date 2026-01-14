<?php
/**
 * Builder Module: Search
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the search module.
 *
 * @param array $module The module data.
 */
function closeclient_render_module_search( $module ) {
	echo '<div class="builder-module-search">';
	get_search_form();
	echo '</div>';
}
