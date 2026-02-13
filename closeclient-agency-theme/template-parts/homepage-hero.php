<?php
/**
 * Template part for displaying the hero section on the homepage.
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */
?>
<!-- Hero CTA -->
<div class="hero-section">
    <div class="container">
        <h1 class="hero-heading"><?php echo esc_html( get_theme_mod( 'homepage_hero_heading', __( 'Expert Legal Counsel for a Modern World', 'closeclient-agency-theme' ) ) ); ?></h1>
        <p class="hero-subheading"><?php echo wp_kses_post( get_theme_mod( 'homepage_hero_subheading', __( 'Navigate your legal challenges with a team of dedicated, experienced, and forward-thinking attorneys.', 'closeclient-agency-theme' ) ) ); ?></p>
        <div class="hero-buttons">
            <a class="button button-primary" href="<?php echo esc_url( get_theme_mod( 'homepage_hero_button_link', '#' ) ); ?>">
                <?php echo esc_html( get_theme_mod( 'homepage_hero_button_text', __( 'Schedule a Free Consultation', 'closeclient-agency-theme' ) ) ); ?>
            </a>
            <a class="button button-secondary" href="#practice-areas">
                <?php esc_html_e( 'Our Expertise', 'closeclient-agency-theme' ); ?>
            </a>
        </div>
    </div>
</div>
