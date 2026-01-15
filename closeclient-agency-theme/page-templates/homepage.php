<?php
/**
 * Template Name: Homepage
 * Template Post Type: page
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero CTA -->
    <div class="hero-section alignfull">
        <h1 class="hero-heading"><?php echo esc_html( get_theme_mod( 'homepage_hero_heading', 'Expert Legal Counsel for a Modern World' ) ); ?></h1>
        <p class="hero-subheading"><?php echo wp_kses_post( get_theme_mod( 'homepage_hero_subheading', 'Navigate your legal challenges with a team of dedicated, experienced, and forward-thinking attorneys.' ) ); ?></p>
        <div class="hero-buttons">
            <a class="wp-block-button__link" href="<?php echo esc_url( get_theme_mod( 'homepage_hero_button_link', '#' ) ); ?>"><?php echo esc_html( get_theme_mod( 'homepage_hero_button_text', 'Schedule a Free Consultation' ) ); ?></a>
        </div>
    </div>

    <!-- Practice Areas -->
    <div class="practice-areas-section">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'homepage_practice_areas_heading', 'Our Practice Areas' ) ); ?></h2>
        <div class="practice-areas-grid">
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <div class="practice-area-item">
                    <h3><?php echo esc_html( get_theme_mod( "homepage_practice_area_{$i}_title", "Practice Area {$i}" ) ); ?></h3>
                    <p><?php echo wp_kses_post( get_theme_mod( "homepage_practice_area_{$i}_description", "Description for practice area {$i}." ) ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="testimonials-section">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'homepage_testimonials_heading', 'What Our Clients Say' ) ); ?></h2>
        <blockquote class="testimonial-quote">
            <p>"<?php echo wp_kses_post( get_theme_mod( 'homepage_testimonial_quote', 'Their team provided exceptional service and achieved a fantastic result for my case. I couldn\'t be happier.' ) ); ?>"</p>
            <cite><?php echo esc_html( get_theme_mod( 'homepage_testimonial_citation', 'John Doe, CEO of Acme Inc.' ) ); ?></cite>
        </blockquote>
    </div>

</main><!-- #main -->

<?php
get_footer();
