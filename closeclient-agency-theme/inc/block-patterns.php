<?php
/**
 * Block Patterns
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

function closeclient_agency_theme_register_block_patterns() {
    register_block_pattern(
        'closeclient-agency-theme/hero-cta',
        require __DIR__ . '/../patterns/hero-cta.php'
    );

    register_block_pattern(
        'closeclient-agency-theme/team-section',
        require __DIR__ . '/../patterns/team-section.php'
    );

    register_block_pattern(
        'closeclient-agency-theme/practice-areas-grid',
        require __DIR__ . '/../patterns/practice-areas-grid.php'
    );

    register_block_pattern(
        'closeclient-agency-theme/testimonial-quote',
        require __DIR__ . '/../patterns/testimonial-quote.php'
    );

    register_block_pattern(
        'closeclient-agency-theme/landing-page',
        require __DIR__ . '/../patterns/landing-page.php'
    );

    register_block_pattern(
        'closeclient-agency-theme/contact-page',
        require __DIR__ . '/../patterns/contact-page.php'
    );

    register_block_pattern(
        'closeclient-agency-theme/legal-page',
        require __DIR__ . '/../patterns/legal-page.php'
    );
}
add_action( 'init', 'closeclient_agency_theme_register_block_patterns' );
