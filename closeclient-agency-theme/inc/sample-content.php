<?php
/**
 * Sample Content Generator for CLOSECLIENT AGENCY THEME
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

/**
 * Generate sample content on theme activation.
 */
function closeclient_generate_sample_content() {
    // Only run if a flag isn't set
    if ( get_option( 'closeclient_sample_content_generated' ) ) {
        return;
    }

    // --- Sample Services ---
    $services = array(
        array(
            'title'   => 'Corporate Law',
            'content' => 'Comprehensive legal solutions for businesses of all sizes, from startups to global corporations.',
        ),
        array(
            'title'   => 'Strategic Consulting',
            'content' => 'Expert guidance to help your agency scale, optimize operations, and increase profitability.',
        ),
        array(
            'title'   => 'Estate Planning',
            'content' => 'Secure your future and protect your legacy with our detailed and compassionate estate planning services.',
        ),
    );

    foreach ( $services as $service ) {
        if ( ! get_page_by_title( $service['title'], OBJECT, 'services' ) ) {
            wp_insert_post( array(
                'post_title'   => $service['title'],
                'post_content' => $service['content'],
                'post_status'  => 'publish',
                'post_type'    => 'services',
            ) );
        }
    }

    // --- Sample Testimonials ---
    $testimonials = array(
        array(
            'title'   => 'John Doe, CEO',
            'content' => 'The expertise provided by this firm was instrumental in our latest acquisition. Highly recommended!',
        ),
        array(
            'title'   => 'Sarah Smith, Founder',
            'content' => 'Professional, responsive, and truly dedicated to our success. A partner you can trust.',
        ),
    );

    foreach ( $testimonials as $testimonial ) {
        if ( ! get_page_by_title( $testimonial['title'], OBJECT, 'testimonials' ) ) {
            wp_insert_post( array(
                'post_title'   => $testimonial['title'],
                'post_content' => $testimonial['content'],
                'post_status'  => 'publish',
                'post_type'    => 'testimonials',
            ) );
        }
    }

    // --- Sample Team ---
    $team = array(
        array(
            'title'   => 'Robert Harrison',
            'content' => 'Senior Managing Partner',
        ),
        array(
            'title'   => 'Amanda Sterling',
            'content' => 'Head of Corporate Strategy',
        ),
    );

    foreach ( $team as $member ) {
        if ( ! get_page_by_title( $member['title'], OBJECT, 'team' ) ) {
            wp_insert_post( array(
                'post_title'   => $member['title'],
                'post_content' => $member['content'],
                'post_status'  => 'publish',
                'post_type'    => 'team',
            ) );
        }
    }

    // Set flag so it only runs once
    update_option( 'closeclient_sample_content_generated', 1 );
}
add_action( 'after_switch_theme', 'closeclient_generate_sample_content' );
