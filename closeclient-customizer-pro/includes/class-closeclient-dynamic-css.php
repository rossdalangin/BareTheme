<?php
/**
 * CLOSECLIENT CUSTOMIZER PRO Dynamic CSS
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The main dynamic CSS class.
 */
class CLOSECLIENT_DYNAMIC_CSS {

	/**
	 * Setup class.
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'output_css' ) );
	}

	/**
	 * Output the dynamic CSS.
	 */
	public function output_css() {
		$css = ':root {';

		// Get color settings
		$color_settings = array(
			'ccd_text_color'        => '--ccd-text-color',
			'ccd_bg_color'          => '--ccd-bg-color',
			'ccd_brand_primary'     => '--ccd-brand-primary',
			'ccd_brand_secondary'   => '--ccd-brand-secondary',
			'ccd_link_color'        => '--ccd-link-color',
			'ccd_link_hover_color'  => '--ccd-link-hover-color',
		);

		foreach ( $color_settings as $setting => $variable ) {
			$css .= esc_attr( $variable ) . ': ' . esc_attr( get_theme_mod( $setting, '' ) ) . ';';
		}

		// Get typography settings
		$typography_settings = array(
			'ccd_body_font_family'    => '--ccd-body-font-family',
			'ccd_heading_font_family' => '--ccd-heading-font-family',
			'ccd_body_font_size'      => '--ccd-body-font-size',
			'ccd_h1_font_size'        => '--ccd-h1-font-size',
			'ccd_h2_font_size'        => '--ccd-h2-font-size',
		);

		foreach ( $typography_settings as $setting => $variable ) {
			$value = get_theme_mod( $setting, '' );
			if ( is_numeric( $value ) ) {
				$value .= 'rem';
			}
			$css .= esc_attr( $variable ) . ': ' . esc_attr( $value ) . ';';
		}

		// Get spacing settings
		$spacing_unit = (float) get_theme_mod( 'ccd_spacing_unit', 1 );
		$spacing_settings = array(
			'ccd_spacing_xs' => '--ccd-spacing-xs',
			'ccd_spacing_s'  => '--ccd-spacing-s',
			'ccd_spacing_m'  => '--ccd-spacing-m',
			'ccd_spacing_l'  => '--ccd-spacing-l',
			'ccd_spacing_xl' => '--ccd-spacing-xl',
		);

		foreach ( $spacing_settings as $setting => $variable ) {
			$multiplier = (float) get_theme_mod( $setting, 1 );
			$value = $spacing_unit * $multiplier;
			$css .= esc_attr( $variable ) . ': ' . esc_attr( $value ) . 'rem;';
		}

		// Get border settings
		$border_settings = array(
			'ccd_border_width'      => '--ccd-border-width',
			'ccd_border_style'      => '--ccd-border-style',
			'ccd_border_color'      => '--ccd-border-color',
			'ccd_border_radius_s'   => '--ccd-border-radius-s',
			'ccd_border_radius_m'   => '--ccd-border-radius-m',
			'ccd_border_radius_l'   => '--ccd-border-radius-l',
		);

		foreach ( $border_settings as $setting => $variable ) {
			$value = get_theme_mod( $setting, '' );
			if ( strpos( $setting, 'width' ) !== false ) {
				$value .= 'px';
			}
			if ( strpos( $setting, 'radius' ) !== false ) {
				$value .= 'rem';
			}
			$css .= esc_attr( $variable ) . ': ' . esc_attr( $value ) . ';';
		}

		// Get shadow settings
		$shadow_offset_x = get_theme_mod( 'ccd_shadow_offset_x', 0 );
		$shadow_offset_y = get_theme_mod( 'ccd_shadow_offset_y', 2 );
		$shadow_blur     = get_theme_mod( 'ccd_shadow_blur', 10 );
		$shadow_spread   = get_theme_mod( 'ccd_shadow_spread', 0 );
		$shadow_color    = get_theme_mod( 'ccd_shadow_color', 'rgba(0,0,0,0.1)' );
		$css .= '--ccd-box-shadow: ' . esc_attr( $shadow_offset_x ) . 'px ' . esc_attr( $shadow_offset_y ) . 'px ' . esc_attr( $shadow_blur ) . 'px ' . esc_attr( $shadow_spread ) . 'px ' . esc_attr( $shadow_color ) . ';';

		// Get layout settings
		$layout_settings = array(
			'ccd_container_width_default' => '--ccd-container-width-default',
			'ccd_container_width_wide'    => '--ccd-container-width-wide',
		);

		foreach ( $layout_settings as $setting => $variable ) {
			$value = get_theme_mod( $setting, '' );
			$css .= esc_attr( $variable ) . ': ' . esc_attr( $value ) . 'px;';
		}

		// Get button settings
		$button_settings = array(
			'ccd_primary_btn_bg_color', 'ccd_primary_btn_text_color', 'ccd_primary_btn_padding_y',
			'ccd_primary_btn_padding_x', 'ccd_primary_btn_border_radius',
			'ccd_secondary_btn_bg_color', 'ccd_secondary_btn_text_color', 'ccd_secondary_btn_padding_y',
			'ccd_secondary_btn_padding_x', 'ccd_secondary_btn_border_radius',
		);

		foreach ( $button_settings as $setting ) {
			$variable = '--' . str_replace( '_', '-', $setting );
			$value = get_theme_mod( $setting, '' );
			$unit = ( strpos( $setting, 'padding' ) !== false || strpos( $setting, 'radius' ) !== false ) ? 'rem' : '';
			$css .= esc_attr( $variable ) . ': ' . esc_attr( $value ) . $unit . ';';
		}

		// Get form settings
		$form_settings = array(
			'ccd_form_input_bg_color', 'ccd_form_input_text_color', 'ccd_form_input_border_color',
			'ccd_form_input_padding_y', 'ccd_form_input_padding_x', 'ccd_form_input_border_radius',
			'ccd_form_label_font_size',
		);

		foreach ( $form_settings as $setting ) {
			$variable = '--' . str_replace( '_', '-', $setting );
			$value = get_theme_mod( $setting, '' );
			$unit = ( strpos( $setting, 'padding' ) !== false || strpos( $setting, 'radius' ) !== false || strpos( $setting, 'font_size' ) !== false ) ? 'rem' : '';
			$css .= esc_attr( $variable ) . ': ' . esc_attr( $value ) . $unit . ';';
		}

		$css .= '}';

		echo '<style type="text/css" id="closeclient-customizer-pro-dynamic-css">' . $css . '</style>';
	}
}

new CLOSECLIENT_DYNAMIC_CSS();
