<?php
/**
 * Builder Module: Button
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the button module.
 *
 * @param array $module The module data.
 */
function closeclient_render_module_button( $module ) {
	$text = ! empty( $module['text'] ) ? $module['text'] : __( 'Button Text', 'closeclient-agency-theme' );
	$link = ! empty( $module['link'] ) ? $module['link'] : '#';

	echo '<div class="builder-module-button">';
	echo '<a href="' . esc_url( $link ) . '" class="ccd-button-primary">' . esc_html( $text ) . '</a>';
	echo '</div>';
}
