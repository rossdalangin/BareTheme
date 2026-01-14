( function( $ ) {
	'use strict';

	// Color settings to preview.
	const colorSettings = [
		'ccd_text_color',
		'ccd_bg_color',
		'ccd_brand_primary',
		'ccd_brand_secondary',
		'ccd_link_color',
		'ccd_link_hover_color',
	];

	// Loop through the color settings and create the live preview.
	colorSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( to ) {
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), to );
			} );
		} );
	} );

	// Typography settings to preview.
	const typographySettings = [
		'ccd_body_font_family',
		'ccd_heading_font_family',
		'ccd_body_font_size',
		'ccd_h1_font_size',
		'ccd_h2_font_size',
	];

	// Loop through the typography settings and create the live preview.
	typographySettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( to ) {
				let unit = '';
				if ( setting.includes( 'font_size' ) ) {
					unit = 'rem';
				}
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), to + unit );
			} );
		} );
	} );

	// Spacing settings to preview.
	const spacingSettings = [
		'ccd_spacing_unit',
		'ccd_spacing_xs',
		'ccd_spacing_s',
		'ccd_spacing_m',
		'ccd_spacing_l',
		'ccd_spacing_xl',
	];

	// Function to update spacing CSS variables.
	function updateSpacing() {
		const spacingUnit = parseFloat( wp.customize( 'ccd_spacing_unit' )() );
		spacingSettings.forEach( function( setting ) {
			if ( setting !== 'ccd_spacing_unit' ) {
				const multiplier = parseFloat( wp.customize( setting )() );
				const value = spacingUnit * multiplier;
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), value + 'rem' );
			}
		} );
	}

	// Loop through the spacing settings and create the live preview.
	spacingSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function() {
				updateSpacing();
			} );
		} );
	} );

	// Border settings to preview.
	const borderSettings = [
		'ccd_border_width',
		'ccd_border_style',
		'ccd_border_color',
		'ccd_border_radius_s',
		'ccd_border_radius_m',
		'ccd_border_radius_l',
	];

	// Loop through the border settings and create the live preview.
	borderSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( to ) {
				let unit = '';
				if ( setting.includes( 'width' ) ) {
					unit = 'px';
				} else if ( setting.includes( 'radius' ) ) {
					unit = 'rem';
				}
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), to + unit );
			} );
		} );
	} );

	// Shadow settings to preview.
	const shadowSettings = [
		'ccd_shadow_offset_x',
		'ccd_shadow_offset_y',
		'ccd_shadow_blur',
		'ccd_shadow_spread',
		'ccd_shadow_color',
	];

	// Function to update shadow CSS variable.
	function updateShadow() {
		const offsetX = wp.customize( 'ccd_shadow_offset_x' )();
		const offsetY = wp.customize( 'ccd_shadow_offset_y' )();
		const blur = wp.customize( 'ccd_shadow_blur' )();
		const spread = wp.customize( 'ccd_shadow_spread' )();
		const color = wp.customize( 'ccd_shadow_color' )();
		const boxShadow = `${offsetX}px ${offsetY}px ${blur}px ${spread}px ${color}`;
		document.documentElement.style.setProperty( '--ccd-box-shadow', boxShadow );
	}

	// Loop through the shadow settings and create the live preview.
	shadowSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function() {
				updateShadow();
			} );
		} );
	} );

	// Layout settings to preview.
	const layoutSettings = [
		'ccd_container_width_default',
		'ccd_container_width_wide',
	];

	// Loop through the layout settings and create the live preview.
	layoutSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( to ) {
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), to + 'px' );
			} );
		} );
	} );

	// Button settings to preview.
	const buttonSettings = [
		'ccd_primary_btn_bg_color', 'ccd_primary_btn_text_color', 'ccd_primary_btn_padding_y',
		'ccd_primary_btn_padding_x', 'ccd_primary_btn_border_radius',
		'ccd_secondary_btn_bg_color', 'ccd_secondary_btn_text_color', 'ccd_secondary_btn_padding_y',
		'ccd_secondary_btn_padding_x', 'ccd_secondary_btn_border_radius',
	];

	// Loop through the button settings and create the live preview.
	buttonSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( to ) {
				const unit = ( setting.includes( 'padding' ) || setting.includes( 'radius' ) ) ? 'rem' : '';
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), to + unit );
			} );
		} );
	} );

	// Form settings to preview.
	const formSettings = [
		'ccd_form_input_bg_color', 'ccd_form_input_text_color', 'ccd_form_input_border_color',
		'ccd_form_input_padding_y', 'ccd_form_input_padding_x', 'ccd_form_input_border_radius',
		'ccd_form_label_font_size',
	];

	// Loop through the form settings and create the live preview.
	formSettings.forEach( function( setting ) {
		wp.customize( setting, function( value ) {
			value.bind( function( to ) {
				const unit = ( setting.includes( 'padding' ) || setting.includes( 'radius' ) || setting.includes( 'font_size' ) ) ? 'rem' : '';
				document.documentElement.style.setProperty( '--' + setting.replace( /_/g, '-' ), to + unit );
			} );
		} );
	} );

} )( jQuery );
