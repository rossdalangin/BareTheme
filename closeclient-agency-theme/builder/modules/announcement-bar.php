<?php
/**
 * Builder Module: Announcement Bar
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the announcement bar module.
 *
 * @param array $module The module data.
 */
function closeclient_render_module_announcement_bar( $module ) {
	$text = ! empty( $module['text'] ) ? $module['text'] : __( 'Announcement Text', 'closeclient-agency-theme' );
	$link = ! empty( $module['link'] ) ? $module['link'] : '';

	echo '<div class="builder-module-announcement-bar">';
	if ( ! empty( $link ) ) {
		echo '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
	} else {
		echo esc_html( $text );
	}
	echo '</div>';
}
