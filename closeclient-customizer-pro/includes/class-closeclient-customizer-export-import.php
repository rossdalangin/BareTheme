<?php
/**
 * Customizer Export/Import
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The main export/import class.
 */
class CLOSECLIENT_CUSTOMIZER_EXPORT_IMPORT {

	/**
	 * Setup class.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_customize_settings' ) );
		add_action( 'wp_ajax_closeclient_customizer_export', array( $this, 'export_settings' ) );
		add_action( 'wp_ajax_closeclient_customizer_import', array( $this, 'import_settings' ) );
		add_action( 'wp_ajax_closeclient_customizer_reset', array( $this, 'reset_settings' ) );
	}

	/**
	 * Register customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
	 */
	public function register_customize_settings( $wp_customize ) {
		$wp_customize->add_section( 'closeclient_export_import_section', array(
			'title'    => __( 'Export/Import/Reset', 'closeclient-customizer-pro' ),
			'priority' => 200,
		) );

		// Export
		$wp_customize->add_setting( 'closeclient_export_button', array(
			'sanitize_callback' => 'wp_kses',
		) );
		$wp_customize->add_control( 'closeclient_export_button', array(
			'section'  => 'closeclient_export_import_section',
			'type'     => 'button',
			'settings' => 'closeclient_export_button',
			'label'    => __( 'Export Settings', 'closeclient-customizer-pro' ),
			'input_attrs' => array(
				'class' => 'button button-primary closeclient-export-button',
			),
		) );

		// Import
		$wp_customize->add_setting( 'closeclient_import_file', array(
			'sanitize_callback' => 'wp_kses',
		) );
		$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'closeclient_import_file', array(
			'section'  => 'closeclient_export_import_section',
			'label'    => __( 'Import Settings', 'closeclient-customizer-pro' ),
		) ) );

		// Reset
		$wp_customize->add_setting( 'closeclient_reset_button', array(
			'sanitize_callback' => 'wp_kses',
		) );
		$wp_customize->add_control( 'closeclient_reset_button', array(
			'section'  => 'closeclient_export_import_section',
			'type'     => 'button',
			'settings' => 'closeclient_reset_button',
			'label'    => __( 'Reset to Defaults', 'closeclient-customizer-pro' ),
			'input_attrs' => array(
				'class' => 'button button-secondary closeclient-reset-button',
			),
		) );

        // Nonce
        wp_nonce_field( 'closeclient_customizer_export_import_nonce', 'closeclient_customizer_export_import_nonce' );
	}

	/**
	 * Export settings.
	 */
	public function export_settings() {
        check_ajax_referer( 'closeclient_customizer_export_import_nonce', 'nonce' );
		$settings = get_theme_mods();
		wp_send_json_success( $settings );
	}

	/**
	 * Import settings.
	 */
	public function import_settings() {
        check_ajax_referer( 'closeclient_customizer_export_import_nonce', 'nonce' );
		if ( ! isset( $_FILES['file'] ) ) {
			wp_send_json_error( 'No file' );
		}
		$file = $_FILES['file'];
		$data = file_get_contents( $file['tmp_name'] );
		$data = json_decode( $data, true );
		if ( ! is_array( $data ) ) {
			wp_send_json_error( 'Invalid data' );
		}
		foreach ( $data as $key => $val ) {
			set_theme_mod( $key, $val );
		}
		wp_send_json_success();
	}

	/**
	 * Reset settings.
	 */
	public function reset_settings() {
        check_ajax_referer( 'closeclient_customizer_export_import_nonce', 'nonce' );
		remove_theme_mods();
		wp_send_json_success();
	}
}
