<?php
/**
 * Header & Footer Builder Render Functions
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the header builder layout.
 */
function closeclient_render_header_builder() {
	$layout_json = get_theme_mod( 'closeclient_header_layout', '' );
	$layout      = json_decode( $layout_json, true );

	if ( empty( $layout ) || ! is_array( $layout ) ) {
		return;
	}

	echo '<div id="closeclient-header-builder">';
	foreach ( $layout as $row_index => $row ) {
		$layout_class = isset( $row['layout'] ) ? ' layout-' . esc_attr( $row['layout'] ) : '';
		echo '<div class="h-row' . $layout_class . '" data-row-index="' . esc_attr( $row_index ) . '">';
		if ( ! empty( $row['columns'] ) && is_array( $row['columns'] ) ) {
			foreach ( $row['columns'] as $col_index => $col ) {
				echo '<div class="h-col" data-col-index="' . esc_attr( $col_index ) . '">';
				if ( ! empty( $col['modules'] ) && is_array( $col['modules'] ) ) {
					foreach ( $col['modules'] as $module ) {
						closeclient_render_builder_module( $module, 'header' );
					}
				}
				echo '</div>';
			}
		}
		echo '</div>';
	}
	echo '</div>';
}
add_action( 'closeclient_header', 'closeclient_render_header_builder' );


/**
 * Render the footer builder layout.
 */
function closeclient_render_footer_builder() {
	$layout_json = get_theme_mod( 'closeclient_footer_layout', '' );
	$layout      = json_decode( $layout_json, true );

	if ( empty( $layout ) || ! is_array( $layout ) ) {
		return;
	}

	echo '<div id="closeclient-footer-builder">';
	foreach ( $layout as $row_index => $row ) {
		$layout_class = isset( $row['layout'] ) ? ' layout-' . esc_attr( $row['layout'] ) : '';
		echo '<div class="f-row' . $layout_class . '" data-row-index="' . esc_attr( $row_index ) . '">';
		if ( ! empty( $row['columns'] ) && is_array( $row['columns'] ) ) {
			foreach ( $row['columns'] as $col_index => $col ) {
				echo '<div class="f-col" data-col-index="' . esc_attr( $col_index ) . '">';
				if ( ! empty( $col['modules'] ) && is_array( $col['modules'] ) ) {
					foreach ( $col['modules'] as $module ) {
						closeclient_render_builder_module( $module, 'footer' );
					}
				}
				echo '</div>';
			}
		}
		echo '</div>';
	}
	echo '</div>';
}
add_action( 'closeclient_footer', 'closeclient_render_footer_builder' );


/**
 * Renders a single builder module.
 *
 * @param array  $module The module data.
 * @param string $context 'header' or 'footer'.
 */
function closeclient_render_builder_module( $module, $context = 'header' ) {
    // Check display conditions
    if ( ! closeclient_evaluate_module_conditions( $module ) ) {
        return;
    }

	// Handle global components
    if ( isset( $module['global_id'] ) ) {
        $global_components_json = get_theme_mod( 'closeclient_global_components', '{}' );
        $global_components      = json_decode( $global_components_json, true );
        $global_id              = $module['global_id'];

        if ( isset( $global_components[ $global_id ]['module'] ) ) {
            // Merge the global module data with the instance data
            // The instance can only override a few things, like visibility.
            $global_module = $global_components[ $global_id ]['module'];
            $module = array_merge( $global_module, $module );
        }
    }

	if ( ! isset( $module['type'] ) ) {
		return;
	}

    // Generate style attribute
    $style_attr = '';
    if ( ! empty( $module['style'] ) && is_array( $module['style'] ) ) {
        foreach ( $module['style'] as $key => $value ) {
            if ( ! empty( $value ) ) {
                $css_key = str_replace( '_', '-', $key );
                $style_attr .= $css_key . ': ' . esc_attr( $value ) . '; ';
            }
        }
    }

    // Generate visibility classes
    $visibility_classes = '';
    if ( ! empty( $module['hide_on'] ) && is_array( $module['hide_on'] ) ) {
        foreach( $module['hide_on'] as $device ) {
            $visibility_classes .= ' hide-on-' . esc_attr( $device );
        }
    }

	$id_attr = isset( $module['id'] ) ? ' id="module-' . esc_attr( $module['id'] ) . '"' : '';
	$classes = 'module module-type-' . esc_attr( $module['type'] ) . $visibility_classes;

	echo '<div' . $id_attr . ' class="' . $classes . '" style="' . $style_attr . '">';

	switch ( $module['type'] ) {
		case 'logo':
			echo '<h1>' . get_bloginfo( 'name' ) . '</h1>';
			break;
		case 'navigation':
			wp_nav_menu( array( 'theme_location' => 'primary' ) );
			break;
		case 'button':
			$text = isset( $module['text'] ) ? esc_html( $module['text'] ) : __( 'Button', 'closeclient-customizer-pro' );
			$link = isset( $module['link'] ) ? esc_url( $module['link'] ) : '#';
			echo '<a href="' . $link . '" class="button">' . $text . '</a>';
			break;
		case 'social_icons':
			$networks = array( 'facebook', 'twitter', 'instagram', 'linkedin' );
			echo '<div class="social-icons">';
			foreach ( $networks as $network ) {
				if ( ! empty( $module[ $network ] ) ) {
					echo '<a href="' . esc_url( $module[ $network ] ) . '" target="_blank"><span class="dashicons dashicons-' . esc_attr( $network ) . '"></span></a>';
				}
			}
			echo '</div>';
			break;
		case 'announcement_bar':
			$text = isset( $module['text'] ) ? wp_kses_post( $module['text'] ) : '';
			$link = isset( $module['link'] ) ? esc_url( $module['link'] ) : '';
			if ( ! empty( $text ) ) {
				if ( ! empty( $link ) ) {
					echo '<a href="' . $link . '">' . $text . '</a>';
				} else {
					echo '<span>' . $text . '</span>';
				}
			}
			break;
	}

	echo '</div>';
}

/**
 * Adds inline styles for hover states.
 */
function closeclient_builder_dynamic_styles() {
    $header_layout_json = get_theme_mod( 'closeclient_header_layout', '' );
	$header_layout      = json_decode( $header_layout_json, true );
    $footer_layout_json = get_theme_mod( 'closeclient_footer_layout', '' );
	$footer_layout      = json_decode( $footer_layout_json, true );

    $layouts = array_merge( is_array($header_layout) ? $header_layout : [], is_array($footer_layout) ? $footer_layout : [] );

    if ( empty( $layouts ) ) {
        return;
    }

    $style_output = '';

    foreach( $layouts as $row ) {
        if( !empty($row['columns']) && is_array($row['columns']) ) {
            foreach( $row['columns'] as $col ) {
                if( !empty($col['modules']) && is_array($col['modules']) ) {
                    foreach( $col['modules'] as $module ) {
                        if ( ! empty( $module['style'] ) && is_array( $module['style'] ) ) {
                            $module_id_val = isset( $module['id'] ) ? $module['id'] : (isset($module['global_id']) ? $module['global_id'] : '');
                            if(empty($module_id_val)) continue;

                            $module_id = '#module-' . esc_attr( $module_id_val );
                            $css = '';

                            foreach($module['style'] as $key => $value) {
                                if(!empty($value)) {
                                    $css_key = str_replace('_', '-', $key);
                                    if(strpos($key, 'hover') === false) {
                                        $css .= $css_key . ': ' . esc_attr( $value ) . '; ';
                                    } else {
                                        // Handle hover states separately
                                        if($key === 'link_hover_color') {
                                            $style_output .= $module_id . ' a:hover { color: ' . esc_attr( $value ) . '; }';
                                        }
                                        if($key === 'icon_hover_color') {
                                            $style_output .= $module_id . ' a:hover { color: ' . esc_attr( $value ) . '; }';
                                        }
                                    }
                                }
                            }
                            if(!empty($css)) {
                                $style_output .= $module_id . ' { ' . $css . '}';
                            }
                        }
                    }
                }
            }
        }
    }

    if( !empty($style_output) ) {
        echo '<style type="text/css">' . $style_output . '</style>';
    }
}
add_action( 'wp_head', 'closeclient_builder_dynamic_styles' );

/**
 * Evaluates the display conditions for a module.
 *
 * @param array $module The module data.
 * @return bool True to display, false to hide.
 */
function closeclient_evaluate_module_conditions( $module ) {
    if ( empty( $module['conditions'] ) || ! is_array( $module['conditions'] ) ) {
        return true; // No conditions, so display.
    }

    foreach ( $module['conditions'] as $condition ) {
        $type = $condition['type'];

        switch ( $type ) {
            case 'is_singular':
                if ( ! is_singular() ) {
                    return false;
                }
                break;
            case 'is_user_logged_in':
                if ( ! is_user_logged_in() ) {
                    return false;
                }
                break;
            // Add more conditions here in the future
            default:
                // Unknown condition, assume true.
                break;
        }
    }

    return true; // All conditions passed.
}
