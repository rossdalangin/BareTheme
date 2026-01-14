<?php
/**
 * Footer Builder for CLOSECLIENT AGENCY THEME
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Render the footer builder output.
 */
function closeclient_render_footer_builder() {
	$layout_json = get_theme_mod( 'closeclient_footer_layout', '' );
	if ( empty( $layout_json ) ) {
		return;
	}

	$layout = json_decode( $layout_json, true );
	if ( ! is_array( $layout ) ) {
		return;
	}

	echo '<div class="footer-builder-main">';
	foreach ( $layout as $row_index => $row ) {
		echo '<div class="f-row" data-row="' . esc_attr( $row_index ) . '">';
		foreach ( $row['columns'] as $col_index => $column ) {
			echo '<div class="f-col" data-col="' . esc_attr( $col_index ) . '">';
			foreach ( $column['modules'] as $module ) {
				if ( function_exists( 'closeclient_render_module_' . $module['type'] ) ) {
					call_user_func( 'closeclient_render_module_' . $module['type'], $module );
				}
			}
			echo '</div>'; // .f-col
		}
		echo '</div>'; // .f-row
	}
	echo '</div>'; // .footer-builder-main
}
add_action( 'closeclient_footer', 'closeclient_render_footer_builder' );
