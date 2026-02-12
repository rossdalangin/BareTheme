<?php
/**
 * Custom Post Type Registrations
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Post Types.
 */
function closeclient_agency_theme_register_cpts() {
    // Services CPT
    $services_labels = array(
        'name'                  => _x( 'Services', 'Post Type General Name', 'closeclient-agency-theme' ),
        'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'closeclient-agency-theme' ),
        'menu_name'             => __( 'Services', 'closeclient-agency-theme' ),
        'all_items'             => __( 'All Services', 'closeclient-agency-theme' ),
        'add_new_item'          => __( 'Add New Service', 'closeclient-agency-theme' ),
    );
    $services_args = array(
        'label'                 => __( 'Service', 'closeclient-agency-theme' ),
        'description'           => __( 'Services offered', 'closeclient-agency-theme' ),
        'labels'                => $services_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-briefcase',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'services', $services_args );

    // Testimonials CPT
    $testimonials_labels = array(
        'name'                  => _x( 'Testimonials', 'Post Type General Name', 'closeclient-agency-theme' ),
        'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'closeclient-agency-theme' ),
        'menu_name'             => __( 'Testimonials', 'closeclient-agency-theme' ),
        'all_items'             => __( 'All Testimonials', 'closeclient-agency-theme' ),
        'add_new_item'          => __( 'Add New Testimonial', 'closeclient-agency-theme' ),
    );
    $testimonials_args = array(
        'label'                 => __( 'Testimonial', 'closeclient-agency-theme' ),
        'description'           => __( 'Client testimonials', 'closeclient-agency-theme' ),
        'labels'                => $testimonials_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-format-quote',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'testimonials', $testimonials_args );

    // Gallery CPT
    $gallery_labels = array(
        'name'                  => _x( 'Gallery', 'Post Type General Name', 'closeclient-agency-theme' ),
        'singular_name'         => _x( 'Gallery Item', 'Post Type Singular Name', 'closeclient-agency-theme' ),
        'menu_name'             => __( 'Gallery', 'closeclient-agency-theme' ),
        'all_items'             => __( 'All Gallery Items', 'closeclient-agency-theme' ),
        'add_new_item'          => __( 'Add New Gallery Item', 'closeclient-agency-theme' ),
    );
    $gallery_args = array(
        'label'                 => __( 'Gallery Item', 'closeclient-agency-theme' ),
        'description'           => __( 'Gallery items', 'closeclient-agency-theme' ),
        'labels'                => $gallery_labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-images-alt2',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'gallery', $gallery_args );

    // Team CPT
    $team_labels = array(
        'name'                  => _x( 'Team', 'Post Type General Name', 'closeclient-agency-theme' ),
        'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'closeclient-agency-theme' ),
        'menu_name'             => __( 'Team', 'closeclient-agency-theme' ),
        'all_items'             => __( 'All Team Members', 'closeclient-agency-theme' ),
        'add_new_item'          => __( 'Add New Team Member', 'closeclient-agency-theme' ),
    );
    $team_args = array(
        'label'                 => __( 'Team Member', 'closeclient-agency-theme' ),
        'description'           => __( 'Team members', 'closeclient-agency-theme' ),
        'labels'                => $team_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'team', $team_args );
}
add_action( 'init', 'closeclient_agency_theme_register_cpts', 0 );
