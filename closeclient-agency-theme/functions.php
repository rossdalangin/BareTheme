<?php
/**
 * CLOSECLIENT AGENCY THEME functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

if ( ! function_exists( 'closeclient_agency_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function closeclient_agency_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CLOSECLIENT AGENCY THEME, use a find and replace
		 * to change 'closeclient-agency-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'closeclient-agency-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'closeclient-agency-theme' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'closeclient_agency_theme_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'closeclient_agency_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function closeclient_agency_theme_scripts() {
	wp_enqueue_style( 'closeclient-agency-theme-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );

	if ( get_theme_mod( 'closeclient_header_sticky' ) ) {
		wp_enqueue_script( 'closeclient-header', get_template_directory_uri() . '/assets/js/header.js', array(), '1.0.0', true );
	}

    wp_enqueue_script( 'closeclient-mobile-menu', get_template_directory_uri() . '/assets/js/mobile-menu.js', array(), '1.0.0', true );

    wp_enqueue_script( 'closeclient-agency-theme-dark-mode', get_template_directory_uri() . '/assets/js/dark-mode.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'closeclient_agency_theme_scripts' );

/**
 * Add custom body classes.
 */
function closeclient_body_classes( $classes ) {
	if ( get_theme_mod( 'closeclient_header_sticky' ) ) {
		$classes[] = 'sticky-header';
	}
	if ( get_theme_mod( 'closeclient_header_transparent' ) ) {
		$classes[] = 'transparent-header';
	}
    if ( get_theme_mod( 'ccd_dark_mode_enabled' ) ) {
        $classes[] = 'dark-mode';
    }
	return $classes;
}
add_filter( 'body_class', 'closeclient_body_classes' );

/**
 * Custom Post Type Registrations.
 */
require get_template_directory() . '/inc/cpt-registrations.php';

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function closeclient_agency_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'closeclient-agency-theme' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'closeclient-agency-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
    register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'closeclient-agency-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'closeclient-agency-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
    register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'closeclient-agency-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'closeclient-agency-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'closeclient_agency_theme_widgets_init' );

/**
 * Block Patterns.
 */
require get_template_directory() . '/inc/block-patterns.php';
