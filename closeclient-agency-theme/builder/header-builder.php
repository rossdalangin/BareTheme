<?php
/**
 * Header Builder for CLOSECLIENT AGENCY THEME
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

// Load all module files.
foreach ( glob( get_template_directory() . '/builder/modules/*.php' ) as $file ) {
	require_once $file;
}

/**
 * Render the header builder output.
 */
function closeclient_render_header_builder() {
	$layout_json = get_theme_mod( 'closeclient_header_layout', '' );
	if ( empty( $layout_json ) ) {
		return;
	}

	$layout = json_decode( $layout_json, true );
	if ( ! is_array( $layout ) ) {
		return;
	}

	echo '<div class="header-builder-main">';
	foreach ( $layout as $row_index => $row ) {
		$layout_class = isset( $row['layout'] ) ? ' layout-' . $row['layout'] : '';
		echo '<div class="h-row' . esc_attr( $layout_class ) . '" data-row="' . esc_attr( $row_index ) . '">';
		foreach ( $row['columns'] as $col_index => $column ) {
			echo '<div class="h-col" data-col="' . esc_attr( $col_index ) . '">';
			foreach ( $column['modules'] as $module ) {
				$classes = 'builder-module builder-module-' . $module['type'];
				if ( ! empty( $module['hide_on'] ) ) {
					foreach ( $module['hide_on'] as $device ) {
						$classes .= ' hide-on-' . $device;
					}
				}

				echo '<div class="' . esc_attr( $classes ) . '">';
				if ( function_exists( 'closeclient_render_module_' . $module['type'] ) ) {
					call_user_func( 'closeclient_render_module_' . $module['type'], $module );
				}
				echo '</div>'; // .builder-module
			}
			echo '</div>'; // .h-col
		}
		echo '</div>'; // .h-row
	}
	echo '</div>'; // .header-builder-main
}
add_action( 'closeclient_header', 'closeclient_render_header_builder' );
