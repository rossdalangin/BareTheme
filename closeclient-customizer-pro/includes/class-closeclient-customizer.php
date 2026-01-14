<?php
/**
 * CLOSECLIENT CUSTOMIZER PRO Customizer Class
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The main customizer class.
 */
class CLOSECLIENT_CUSTOMIZER {

	/**
	 * Setup class.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_customize_settings' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue_customizer_preview_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_control_scripts' ) );
	}

	/**
	 * Enqueue customizer control scripts.
	 */
	public function enqueue_customizer_control_scripts() {
		wp_enqueue_script(
			'closeclient-builder-customizer',
			CCP_PLUGIN_URL . 'assets/js/builder-customizer.js',
			array( 'jquery', 'customize-controls', 'jquery-ui-sortable' ),
			CCP_VERSION,
			true
		);

		wp_enqueue_style(
			'closeclient-builder-customizer',
			CCP_PLUGIN_URL . 'assets/css/builder-customizer.css',
			array(),
			CCP_VERSION
		);

		wp_enqueue_script(
			'closeclient-builder-preview',
			CCP_PLUGIN_URL . 'assets/js/builder-preview.js',
			array( 'jquery', 'customize-preview' ),
			CCP_VERSION,
			true
		);
	}

	/**
	 * Enqueue customizer preview scripts.
	 */
	public function enqueue_customizer_preview_scripts() {
		wp_enqueue_script(
			'closeclient-customizer-preview',
			CCP_PLUGIN_URL . 'assets/js/customizer-preview.js',
			array( 'jquery', 'customize-preview' ),
			CCP_VERSION,
			true
		);
	}

	/**
	 * Register customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
	 */
	public function register_customize_settings( $wp_customize ) {
		// Add the Global Design System Panel.
		$wp_customize->add_panel( 'closeclient_global_design_system', array(
			'title'       => __( 'Global Design System', 'closeclient-customizer-pro' ),
			'priority'    => 10,
		) );

		// Add the Colors Section.
		$wp_customize->add_section( 'closeclient_colors_section', array(
			'title'       => __( 'Colors', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// Define Color Controls.
		$color_controls = array(
			'ccd_text_color' => array(
				'label'   => __( 'Text Color', 'closeclient-customizer-pro' ),
				'default' => '#333333',
			),
			'ccd_bg_color' => array(
				'label'   => __( 'Background Color', 'closeclient-customizer-pro' ),
				'default' => '#FFFFFF',
			),
			'ccd_brand_primary' => array(
				'label'   => __( 'Brand Primary', 'closeclient-customizer-pro' ),
				'default' => '#0073e6',
			),
			'ccd_brand_secondary' => array(
				'label'   => __( 'Brand Secondary', 'closeclient-customizer-pro' ),
				'default' => '#f0f0f0',
			),
			'ccd_link_color' => array(
				'label' => __( 'Link Color', 'closeclient-customizer-pro' ),
				'default' => '#0073e6',
			),
			'ccd_link_hover_color' => array(
				'label' => __( 'Link Hover Color', 'closeclient-customizer-pro' ),
				'default' => '#005cb8',
			),
		);

		foreach ( $color_controls as $id => $control ) {
			// Add Setting.
			$wp_customize->add_setting( $id, array(
				'default'   => $control['default'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			) );

			// Add Control.
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
				'label'    => $control['label'],
				'section'  => 'closeclient_colors_section',
				'settings' => $id,
			) ) );
		}

		// Add the Typography Section.
		$wp_customize->add_section( 'closeclient_typography_section', array(
			'title'       => __( 'Typography', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// Define Typography Controls
		$typography_controls = array(
			'ccd_body_font_family' => array(
				'label'   => __( 'Body Font Family', 'closeclient-customizer-pro' ),
				'type'    => 'text',
				'default' => 'sans-serif',
			),
			'ccd_heading_font_family' => array(
				'label'   => __( 'Heading Font Family', 'closeclient-customizer-pro' ),
				'type'    => 'text',
				'default' => 'sans-serif',
			),
			'ccd_body_font_size' => array(
				'label'   => __( 'Body Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1,
			),
			'ccd_h1_font_size' => array(
				'label'   => __( 'H1 Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 2.5,
			),
			'ccd_h2_font_size' => array(
				'label'   => __( 'H2 Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 2,
			),
		);

		foreach ( $typography_controls as $id => $control ) {
			// Add Setting.
			$sanitize_callback = ( $control['type'] === 'text' ) ? 'sanitize_text_field' : 'floatval';
			$wp_customize->add_setting( $id, array(
				'default'   => $control['default'],
				'transport' => 'postMessage',
				'sanitize_callback' => $sanitize_callback,
			) );

			// Add Control.
			$wp_customize->add_control( $id, array(
				'label'    => $control['label'],
				'section'  => 'closeclient_typography_section',
				'settings' => $id,
				'type'     => $control['type'],
			) );
		}

		// Add the Spacing Section.
		$wp_customize->add_section( 'closeclient_spacing_section', array(
			'title'       => __( 'Spacing', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// Define Spacing Controls
		$spacing_controls = array(
			'ccd_spacing_unit' => array(
				'label'   => __( 'Base Spacing Unit (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1,
			),
			'ccd_spacing_xs' => array(
				'label'   => __( 'Extra Small Spacing (multiplier)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 0.25,
			),
			'ccd_spacing_s' => array(
				'label'   => __( 'Small Spacing (multiplier)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 0.5,
			),
			'ccd_spacing_m' => array(
				'label'   => __( 'Medium Spacing (multiplier)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1,
			),
			'ccd_spacing_l' => array(
				'label'   => __( 'Large Spacing (multiplier)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 2,
			),
			'ccd_spacing_xl' => array(
				'label'   => __( 'Extra Large Spacing (multiplier)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 4,
			),
		);

		foreach ( $spacing_controls as $id => $control ) {
			// Add Setting.
			$wp_customize->add_setting( $id, array(
				'default'   => $control['default'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'floatval',
			) );

			// Add Control.
			$wp_customize->add_control( $id, array(
				'label'    => $control['label'],
				'section'  => 'closeclient_spacing_section',
				'settings' => $id,
				'type'     => $control['type'],
				'input_attrs' => array(
					'step' => '0.1',
				),
			) );
		}

		// Add the Borders & Radius Section.
		$wp_customize->add_section( 'closeclient_borders_section', array(
			'title'       => __( 'Borders & Radius', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// Define Border Controls.
		$border_controls = array(
			'ccd_border_width' => array(
				'label'   => __( 'Border Width (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1,
			),
			'ccd_border_style' => array(
				'label'   => __( 'Border Style', 'closeclient-customizer-pro' ),
				'type'    => 'select',
				'choices' => array(
					'solid'  => __( 'Solid', 'closeclient-customizer-pro' ),
					'dashed' => __( 'Dashed', 'closeclient-customizer-pro' ),
					'dotted' => __( 'Dotted', 'closeclient-customizer-pro' ),
				),
				'default' => 'solid',
			),
			'ccd_border_color' => array(
				'label'   => __( 'Border Color', 'closeclient-customizer-pro' ),
				'default' => '#cccccc',
			),
			'ccd_border_radius_s' => array(
				'label'   => __( 'Small Radius (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 0.25,
			),
			'ccd_border_radius_m' => array(
				'label'   => __( 'Medium Radius (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 0.5,
			),
			'ccd_border_radius_l' => array(
				'label'   => __( 'Large Radius (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1,
			),
		);

		foreach ( $border_controls as $id => $control ) {
			// Add Setting.
			$sanitize_callback = ( $id === 'ccd_border_color' ) ? 'sanitize_hex_color' : ( $control['type'] === 'select' ? 'sanitize_text_field' : 'floatval' );
			$wp_customize->add_setting( $id, array(
				'default'   => $control['default'],
				'transport' => 'postMessage',
				'sanitize_callback' => $sanitize_callback,
			) );

			// Add Control.
			if ( $id === 'ccd_border_color' ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
					'label'    => $control['label'],
					'section'  => 'closeclient_borders_section',
					'settings' => $id,
				) ) );
			} else {
				$wp_customize->add_control( $id, array(
					'label'    => $control['label'],
					'section'  => 'closeclient_borders_section',
					'settings' => $id,
					'type'     => $control['type'],
					'choices'  => isset( $control['choices'] ) ? $control['choices'] : array(),
					'input_attrs' => $control['type'] === 'number' ? array( 'step' => '0.1' ) : array(),
				) );
			}
		}

		// Add the Shadows Section.
		$wp_customize->add_section( 'closeclient_shadows_section', array(
			'title'       => __( 'Shadows', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// Define Shadow Controls.
		$shadow_controls = array(
			'ccd_shadow_offset_x' => array(
				'label'   => __( 'Offset X (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 0,
			),
			'ccd_shadow_offset_y' => array(
				'label'   => __( 'Offset Y (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 2,
			),
			'ccd_shadow_blur' => array(
				'label'   => __( 'Blur (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 10,
			),
			'ccd_shadow_spread' => array(
				'label'   => __( 'Spread (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 0,
			),
			'ccd_shadow_color' => array(
				'label'   => __( 'Shadow Color', 'closeclient-customizer-pro' ),
				'default' => 'rgba(0,0,0,0.1)',
			),
		);

		foreach ( $shadow_controls as $id => $control ) {
			// Add Setting.
			$sanitize_callback = ( $id === 'ccd_shadow_color' ) ? 'sanitize_text_field' : 'floatval'; // Using sanitize_text_field for rgba
			$wp_customize->add_setting( $id, array(
				'default'   => $control['default'],
				'transport' => 'postMessage',
				'sanitize_callback' => $sanitize_callback,
			) );

			// Add Control.
			if ( $id === 'ccd_shadow_color' ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
					'label'    => $control['label'],
					'section'  => 'closeclient_shadows_section',
					'settings' => $id,
				) ) );
			} else {
				$wp_customize->add_control( $id, array(
					'label'    => $control['label'],
					'section'  => 'closeclient_shadows_section',
					'settings' => $id,
					'type'     => $control['type'],
					'input_attrs' => array( 'step' => '1' ),
				) );
			}
		}

		// Add the Layout Section.
		$wp_customize->add_section( 'closeclient_layout_section', array(
			'title'       => __( 'Layout', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// Define Layout Controls.
		$layout_controls = array(
			'ccd_container_width_default' => array(
				'label'   => __( 'Default Container Width (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1200,
			),
			'ccd_container_width_wide' => array(
				'label'   => __( 'Wide Container Width (px)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1600,
			),
		);

		foreach ( $layout_controls as $id => $control ) {
			// Add Setting.
			$wp_customize->add_setting( $id, array(
				'default'   => $control['default'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'floatval',
			) );

			// Add Control.
			$wp_customize->add_control( $id, array(
				'label'    => $control['label'],
				'section'  => 'closeclient_layout_section',
				'settings' => $id,
				'type'     => $control['type'],
				'input_attrs' => array( 'step' => '10' ),
			) );
		}

		// Add the Buttons Section.
		$wp_customize->add_section( 'closeclient_buttons_section', array(
			'title'       => __( 'Buttons', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// -- Primary Button Controls --
		$wp_customize->add_setting( 'ccd_primary_button_heading', array( 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ccd_primary_button_heading', array(
			'label' => '<hr><h3>' . __( 'Primary Button', 'closeclient-customizer-pro' ) . '</h3>',
			'section' => 'closeclient_buttons_section',
			'type' => 'hidden',
		) ) );

		$primary_button_controls = array(
			'ccd_primary_btn_bg_color' => array( 'label' => __( 'Background Color', 'closeclient-customizer-pro' ), 'default' => '#0073e6', 'type' => 'color' ),
			'ccd_primary_btn_text_color' => array( 'label' => __( 'Text Color', 'closeclient-customizer-pro' ), 'default' => '#ffffff', 'type' => 'color' ),
			'ccd_primary_btn_padding_y' => array( 'label' => __( 'Padding Y (rem)', 'closeclient-customizer-pro' ), 'default' => 0.75, 'type' => 'number' ),
			'ccd_primary_btn_padding_x' => array( 'label' => __( 'Padding X (rem)', 'closeclient-customizer-pro' ), 'default' => 1.5, 'type' => 'number' ),
			'ccd_primary_btn_border_radius' => array( 'label' => __( 'Border Radius (rem)', 'closeclient-customizer-pro' ), 'default' => 0.5, 'type' => 'number' ),
		);

		foreach ( $primary_button_controls as $id => $control ) {
			$wp_customize->add_setting( $id, array(
				'default' => $control['default'], 'transport' => 'postMessage', 'sanitize_callback' => $control['type'] === 'color' ? 'sanitize_hex_color' : 'floatval',
			) );
			if ( $control['type'] === 'color' ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $control['label'], 'section' => 'closeclient_buttons_section' ) ) );
			} else {
				$wp_customize->add_control( $id, array( 'label' => $control['label'], 'section' => 'closeclient_buttons_section', 'type' => 'number', 'input_attrs' => array('step' => '0.1') ) );
			}
		}

		// -- Secondary Button Controls --
		$wp_customize->add_setting( 'ccd_secondary_button_heading', array( 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ccd_secondary_button_heading', array(
			'label' => '<hr><h3>' . __( 'Secondary Button', 'closeclient-customizer-pro' ) . '</h3>',
			'section' => 'closeclient_buttons_section',
			'type' => 'hidden',
		) ) );

		$secondary_button_controls = array(
			'ccd_secondary_btn_bg_color' => array( 'label' => __( 'Background Color', 'closeclient-customizer-pro' ), 'default' => '#f0f0f0', 'type' => 'color' ),
			'ccd_secondary_btn_text_color' => array( 'label' => __( 'Text Color', 'closeclient-customizer-pro' ), 'default' => '#333333', 'type' => 'color' ),
			'ccd_secondary_btn_padding_y' => array( 'label' => __( 'Padding Y (rem)', 'closeclient-customizer-pro' ), 'default' => 0.75, 'type' => 'number' ),
			'ccd_secondary_btn_padding_x' => array( 'label' => __( 'Padding X (rem)', 'closeclient-customizer-pro' ), 'default' => 1.5, 'type' => 'number' ),
			'ccd_secondary_btn_border_radius' => array( 'label' => __( 'Border Radius (rem)', 'closeclient-customizer-pro' ), 'default' => 0.5, 'type' => 'number' ),
		);

		foreach ( $secondary_button_controls as $id => $control ) {
			$wp_customize->add_setting( $id, array(
				'default' => $control['default'], 'transport' => 'postMessage', 'sanitize_callback' => $control['type'] === 'color' ? 'sanitize_hex_color' : 'floatval',
			) );
			if ( $control['type'] === 'color' ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $control['label'], 'section' => 'closeclient_buttons_section' ) ) );
			} else {
				$wp_customize->add_control( $id, array( 'label' => $control['label'], 'section' => 'closeclient_buttons_section', 'type' => 'number', 'input_attrs' => array('step' => '0.1') ) );
			}
		}

		// Add the Forms Section.
		$wp_customize->add_section( 'closeclient_forms_section', array(
			'title'       => __( 'Forms', 'closeclient-customizer-pro' ),
			'panel'       => 'closeclient_global_design_system',
		) );

		// -- Form Controls --
		$form_controls = array(
			'ccd_form_input_bg_color' => array( 'label' => __( 'Input BG Color', 'closeclient-customizer-pro' ), 'default' => '#f9f9f9', 'type' => 'color' ),
			'ccd_form_input_text_color' => array( 'label' => __( 'Input Text Color', 'closeclient-customizer-pro' ), 'default' => '#333333', 'type' => 'color' ),
			'ccd_form_input_border_color' => array( 'label' => __( 'Input Border Color', 'closeclient-customizer-pro' ), 'default' => '#cccccc', 'type' => 'color' ),
			'ccd_form_input_padding_y' => array( 'label' => __( 'Input Padding Y (rem)', 'closeclient-customizer-pro' ), 'default' => 0.5, 'type' => 'number' ),
			'ccd_form_input_padding_x' => array( 'label' => __( 'Input Padding X (rem)', 'closeclient-customizer-pro' ), 'default' => 1, 'type' => 'number' ),
			'ccd_form_input_border_radius' => array( 'label' => __( 'Input Border Radius (rem)', 'closeclient-customizer-pro' ), 'default' => 0.25, 'type' => 'number' ),
			'ccd_form_label_font_size' => array( 'label' => __( 'Label Font Size (rem)', 'closeclient-customizer-pro' ), 'default' => 0.9, 'type' => 'number' ),
		);

		foreach ( $form_controls as $id => $control ) {
			$wp_customize->add_setting( $id, array(
				'default' => $control['default'], 'transport' => 'postMessage', 'sanitize_callback' => $control['type'] === 'color' ? 'sanitize_hex_color' : 'floatval',
			) );
			if ( $control['type'] === 'color' ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $control['label'], 'section' => 'closeclient_forms_section' ) ) );
			} else {
				$wp_customize->add_control( $id, array( 'label' => $control['label'], 'section' => 'closeclient_forms_section', 'type' => 'number', 'input_attrs' => array('step' => '0.1') ) );
			}
		}

		// == Header & Footer Builder Panels ==

		// Load and register the builder control.
		require_once CCP_PLUGIN_DIR . 'includes/class-closeclient-builder-control.php';
		$wp_customize->register_control_type( 'CLOSECLIENT_Builder_Control' );

		// Add Header Builder Panel.
		$wp_customize->add_panel( 'closeclient_header_builder_panel', array(
			'title'    => __( 'Header Builder', 'closeclient-customizer-pro' ),
			'priority' => 20,
		) );

		$wp_customize->add_section( 'closeclient_header_options_section', array(
			'title' => __( 'Options', 'closeclient-customizer-pro' ),
			'panel' => 'closeclient_header_builder_panel',
		) );

		$wp_customize->add_setting( 'closeclient_header_sticky', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
		$wp_customize->add_control( 'closeclient_header_sticky', array(
			'label' => __( 'Enable Sticky Header', 'closeclient-customizer-pro' ),
			'section' => 'closeclient_header_options_section',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'closeclient_header_transparent', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
		$wp_customize->add_control( 'closeclient_header_transparent', array(
			'label' => __( 'Enable Transparent Header', 'closeclient-customizer-pro' ),
			'section' => 'closeclient_header_options_section',
			'type' => 'checkbox',
		) );

		$wp_customize->add_section( 'closeclient_header_builder_section', array(
			'title' => __( 'Layout', 'closeclient-customizer-pro' ),
			'panel' => 'closeclient_header_builder_panel',
		) );

		$wp_customize->add_setting( 'closeclient_header_layout', array(
			'default'   => '',
			'transport' => 'postMessage', // Will be handled by JS later
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( new CLOSECLIENT_Builder_Control( $wp_customize, 'closeclient_header_layout', array(
			'label'    => __( 'Header Layout', 'closeclient-customizer-pro' ),
			'section'  => 'closeclient_header_builder_section',
			'builder_type' => 'header',
		) ) );

		// Add Footer Builder Panel.
		$wp_customize->add_panel( 'closeclient_footer_builder_panel', array(
			'title'    => __( 'Footer Builder', 'closeclient-customizer-pro' ),
			'priority' => 21,
		) );

		$wp_customize->add_section( 'closeclient_footer_builder_section', array(
			'title' => __( 'Layout', 'closeclient-customizer-pro' ),
			'panel' => 'closeclient_footer_builder_panel',
		) );

		$wp_customize->add_setting( 'closeclient_footer_layout', array(
			'default'   => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_control( new CLOSECLIENT_Builder_Control( $wp_customize, 'closeclient_footer_layout', array(
			'label'    => __( 'Footer Layout', 'closeclient-customizer-pro' ),
			'section'  => 'closeclient_footer_builder_section',
			'builder_type' => 'footer',
		) ) );
	}
}

new CLOSECLIENT_CUSTOMIZER();
