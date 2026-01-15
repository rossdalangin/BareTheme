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
		// Scripts for the global design system will be enqueued here.
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
				'default' => '#212529', // Darker gray for better contrast
			),
			'ccd_bg_color' => array(
				'label'   => __( 'Background Color', 'closeclient-customizer-pro' ),
				'default' => '#FFFFFF',
			),
			'ccd_brand_primary' => array(
				'label'   => __( 'Brand Primary', 'closeclient-customizer-pro' ),
				'default' => '#0A2B4C', // Deep, trustworthy blue
			),
			'ccd_brand_secondary' => array(
				'label'   => __( 'Brand Secondary', 'closeclient-customizer-pro' ),
				'default' => '#F8F9FA', // Very light gray for subtle backgrounds
			),
			'ccd_link_color' => array(
				'label' => __( 'Link Color', 'closeclient-customizer-pro' ),
				'default' => '#0A2B4C',
			),
			'ccd_link_hover_color' => array(
				'label' => __( 'Link Hover Color', 'closeclient-customizer-pro' ),
				'default' => '#071F38', // Slightly darker blue for hover
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
				'default' => '"Source Sans Pro", sans-serif',
			),
			'ccd_heading_font_family' => array(
				'label'   => __( 'Heading Font Family', 'closeclient-customizer-pro' ),
				'type'    => 'text',
				'default' => '"Playfair Display", serif',
			),
			'ccd_body_font_size' => array(
				'label'   => __( 'Body Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1.1,
			),
			'ccd_h1_font_size' => array(
				'label'   => __( 'H1 Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 3.052,
			),
			'ccd_h2_font_size' => array(
				'label'   => __( 'H2 Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 2.441,
			),
            'ccd_h3_font_size' => array(
				'label'   => __( 'H3 Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1.953,
			),
            'ccd_h4_font_size' => array(
				'label'   => __( 'H4 Font Size (rem)', 'closeclient-customizer-pro' ),
				'type'    => 'number',
				'default' => 1.563,
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
            $sanitize_callback = 'floatval';
            if ( $id === 'ccd_border_color' ) {
                $sanitize_callback = 'sanitize_hex_color';
            } elseif ( $id === 'ccd_border_style' ) {
                $sanitize_callback = array( $this, 'sanitize_border_style' );
            }

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
			$sanitize_callback = ( $id === 'ccd_shadow_color' ) ? array( $this, 'sanitize_rgba_color' ) : 'floatval';
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
			'ccd_primary_btn_bg_color' => array( 'label' => __( 'Background Color', 'closeclient-customizer-pro' ), 'default' => '#0A2B4C', 'type' => 'color' ),
			'ccd_primary_btn_text_color' => array( 'label' => __( 'Text Color', 'closeclient-customizer-pro' ), 'default' => '#FFFFFF', 'type' => 'color' ),
			'ccd_primary_btn_padding_y' => array( 'label' => __( 'Padding Y (rem)', 'closeclient-customizer-pro' ), 'default' => 0.8, 'type' => 'number' ),
			'ccd_primary_btn_padding_x' => array( 'label' => __( 'Padding X (rem)', 'closeclient-customizer-pro' ), 'default' => 2, 'type' => 'number' ),
			'ccd_primary_btn_border_radius' => array( 'label' => __( 'Border Radius (rem)', 'closeclient-customizer-pro' ), 'default' => 0.3, 'type' => 'number' ),
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

		// == Theme Options Panel ==
		$wp_customize->add_panel( 'closeclient_theme_options_panel', array(
			'title'    => __( 'Theme Options', 'closeclient-customizer-pro' ),
			'priority' => 20,
		) );

		// Header Section
		$wp_customize->add_section( 'closeclient_header_section', array(
			'title' => __( 'Header', 'closeclient-customizer-pro' ),
			'panel' => 'closeclient_theme_options_panel',
		) );

		$wp_customize->add_setting( 'closeclient_header_sticky', array(
			'default'           => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'closeclient_header_sticky', array(
			'label' => __( 'Enable Sticky Header', 'closeclient-customizer-pro' ),
			'section' => 'closeclient_header_section',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'closeclient_header_transparent', array(
			'default'           => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'closeclient_header_transparent', array(
			'label' => __( 'Enable Transparent Header', 'closeclient-customizer-pro' ),
			'section' => 'closeclient_header_section',
			'type' => 'checkbox',
		) );

        // == Page Content Panel ==
		$wp_customize->add_panel( 'closeclient_page_content_panel', array(
			'title'    => __( 'Page Content', 'closeclient-customizer-pro' ),
			'priority' => 25,
		) );

        // Homepage Section
        $wp_customize->add_section( 'closeclient_homepage_section', array(
            'title' => __( 'Homepage', 'closeclient-customizer-pro' ),
            'panel' => 'closeclient_page_content_panel',
        ) );

        // -- Hero CTA --
        $wp_customize->add_setting( 'homepage_hero_heading', array( 'default' => 'Expert Legal Counsel for a Modern World', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'homepage_hero_heading', array( 'label' => 'Hero Heading', 'section' => 'closeclient_homepage_section', 'type' => 'text' ) );
        $wp_customize->add_setting( 'homepage_hero_subheading', array( 'default' => 'Navigate your legal challenges with a team of dedicated, experienced, and forward-thinking attorneys.', 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( 'homepage_hero_subheading', array( 'label' => 'Hero Subheading', 'section' => 'closeclient_homepage_section', 'type' => 'textarea' ) );
        $wp_customize->add_setting( 'homepage_hero_button_text', array( 'default' => 'Schedule a Free Consultation', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'homepage_hero_button_text', array( 'label' => 'Hero Button Text', 'section' => 'closeclient_homepage_section', 'type' => 'text' ) );
        $wp_customize->add_setting( 'homepage_hero_button_link', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( 'homepage_hero_button_link', array( 'label' => 'Hero Button Link', 'section' => 'closeclient_homepage_section', 'type' => 'url' ) );

        // -- Practice Areas --
        $wp_customize->add_setting( 'homepage_practice_areas_heading', array( 'default' => 'Our Practice Areas', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'homepage_practice_areas_heading', array( 'label' => 'Practice Areas Heading', 'section' => 'closeclient_homepage_section', 'type' => 'text' ) );
        // Repeater for practice areas would go here in a real-world scenario. For now, we'll use three static sections.
        for($i = 1; $i <= 3; $i++) {
            $wp_customize->add_setting( "homepage_practice_area_{$i}_title", array( 'default' => "Practice Area {$i}", 'sanitize_callback' => 'sanitize_text_field' ) );
            $wp_customize->add_control( "homepage_practice_area_{$i}_title", array( 'label' => "Practice Area {$i} Title", 'section' => 'closeclient_homepage_section', 'type' => 'text' ) );
            $wp_customize->add_setting( "homepage_practice_area_{$i}_description", array( 'default' => "Description for practice area {$i}.", 'sanitize_callback' => 'wp_kses_post' ) );
            $wp_customize->add_control( "homepage_practice_area_{$i}_description", array( 'label' => "Practice Area {$i} Description", 'section' => 'closeclient_homepage_section', 'type' => 'textarea' ) );
        }

        // -- Testimonials --
        $wp_customize->add_setting( 'homepage_testimonials_heading', array( 'default' => 'What Our Clients Say', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'homepage_testimonials_heading', array( 'label' => 'Testimonials Heading', 'section' => 'closeclient_homepage_section', 'type' => 'text' ) );
        $wp_customize->add_setting( 'homepage_testimonial_quote', array( 'default' => 'Their team provided exceptional service and achieved a fantastic result for my case. I couldn\'t be happier.', 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( 'homepage_testimonial_quote', array( 'label' => 'Testimonial Quote', 'section' => 'closeclient_homepage_section', 'type' => 'textarea' ) );
        $wp_customize->add_setting( 'homepage_testimonial_citation', array( 'default' => 'John Doe, CEO of Acme Inc.', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'homepage_testimonial_citation', array( 'label' => 'Testimonial Citation', 'section' => 'closeclient_homepage_section', 'type' => 'text' ) );

        // About Us Section
        $wp_customize->add_section( 'closeclient_about_us_section', array(
            'title' => __( 'About Us', 'closeclient-customizer-pro' ),
            'panel' => 'closeclient_page_content_panel',
        ) );

        // -- Team Section --
        $wp_customize->add_setting( 'about_us_team_heading', array( 'default' => 'Meet Our Team', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'about_us_team_heading', array( 'label' => 'Team Section Heading', 'section' => 'closeclient_about_us_section', 'type' => 'text' ) );
        for($i = 1; $i <= 3; $i++) {
            $wp_customize->add_setting( "about_us_team_member_{$i}_name", array( 'default' => "Team Member {$i}", 'sanitize_callback' => 'sanitize_text_field' ) );
            $wp_customize->add_control( "about_us_team_member_{$i}_name", array( 'label' => "Team Member {$i} Name", 'section' => 'closeclient_about_us_section', 'type' => 'text' ) );
            $wp_customize->add_setting( "about_us_team_member_{$i}_title", array( 'default' => "Title", 'sanitize_callback' => 'sanitize_text_field' ) );
            $wp_customize->add_control( "about_us_team_member_{$i}_title", array( 'label' => "Team Member {$i} Title", 'section' => 'closeclient_about_us_section', 'type' => 'text' ) );
            $wp_customize->add_setting( "about_us_team_member_{$i}_image", array( 'sanitize_callback' => 'esc_url_raw' ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "about_us_team_member_{$i}_image", array(
                'label'    => __( "Team Member {$i} Image", 'closeclient-customizer-pro' ),
                'section'  => 'closeclient_about_us_section',
            ) ) );
        }

        // Services Section
        $wp_customize->add_section( 'closeclient_services_section', array(
            'title' => __( 'Services', 'closeclient-customizer-pro' ),
            'panel' => 'closeclient_page_content_panel',
        ) );

        // Testimonials Section
        $wp_customize->add_section( 'closeclient_testimonials_section', array(
            'title' => __( 'Testimonials', 'closeclient-customizer-pro' ),
            'panel' => 'closeclient_page_content_panel',
        ) );
	}

    /**
     * Sanitize RGBA color.
     *
     * @param string $color The color to sanitize.
     * @return string The sanitized color.
     */
    public function sanitize_rgba_color( $color ) {
        if ( empty( $color ) || is_array( $color ) ) {
            return '';
        }

        // If string does not start with 'rgba', then treat as hex
        // sanitize the hex color and finally convert hex to rgba
        if ( false === strpos( $color, 'rgba' ) ) {
            return sanitize_hex_color( $color );
        }

        // Sanitize
        $color = str_replace( ' ', '', $color );
        sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

        return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
    }

    /**
     * Sanitize border style.
     *
     * @param string $style The style to sanitize.
     * @return string The sanitized style.
     */
    public function sanitize_border_style( $style ) {
        $allowed_styles = array( 'solid', 'dashed', 'dotted' );
        if ( in_array( $style, $allowed_styles, true ) ) {
            return $style;
        }
        return 'solid';
    }
}

new CLOSECLIENT_CUSTOMIZER();
