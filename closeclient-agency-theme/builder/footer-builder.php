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
		$layout_class = isset( $row['layout'] ) ? ' layout-' . $row['layout'] : '';
		echo '<div class="f-row' . esc_attr( $layout_class ) . '" data-row="' . esc_attr( $row_index ) . '">';
		foreach ( $row['columns'] as $col_index => $column ) {
			echo '<div class="f-col" data-col="' . esc_attr( $col_index ) . '">';
			foreach ( $column['modules'] as $module ) {
				$classes = 'builder-module builder-module-' . $module['type'];
				if ( ! empty( $module['hide_on'] ) ) {
					foreach ( $module['hide_on'] as $device ) {
						$classes .= ' hide-on-' . $device;
					}
				}

				$module_id = ! empty( $module['id'] ) ? 'id="' . esc_attr( $module['id'] ) . '"' : '';

				echo '<div ' . $module_id . ' class="' . esc_attr( $classes ) . '">';
				if ( function_exists( 'closeclient_render_module_' . $module['type'] ) ) {
					call_user_func( 'closeclient_render_module_' . $module['type'], $module );
				}
				echo '</div>'; // .builder-module
			}
			echo '</div>'; // .f-col
		}
		echo '</div>'; // .f-row
	}
	echo '</div>'; // .footer-builder-main
}
add_action( 'closeclient_footer', 'closeclient_render_footer_builder' );
