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
    <div class="wp-block-group alignfull has-white-color has-secondary-background-color has-text-color has-background" style="padding-top:8rem;padding-bottom:8rem">
        <h1 class="has-text-align-center" style="font-size:4rem"><?php echo esc_html( get_theme_mod( 'homepage_hero_heading', 'Expert Legal Counsel for a Modern World' ) ); ?></h1>
        <p class="has-text-align-center has-light-gray-color has-text-color" style="font-size:1.2rem"><?php echo wp_kses_post( get_theme_mod( 'homepage_hero_subheading', 'Navigate your legal challenges with a team of dedicated, experienced, and forward-thinking attorneys.' ) ); ?></p>
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <div class="wp-block-buttons">
            <div class="wp-block-button"><a class="wp-block-button__link has-white-color has-primary-background-color has-text-color has-background" href="<?php echo esc_url( get_theme_mod( 'homepage_hero_button_link', '#' ) ); ?>" style="border-radius:0.5rem;padding-top:1rem;padding-bottom:1rem;padding-left:2rem;padding-right:2rem"><?php echo esc_html( get_theme_mod( 'homepage_hero_button_text', 'Schedule a Free Consultation' ) ); ?></a></div>
        </div>
    </div>

    <!-- Practice Areas -->
    <div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem">
        <h2 class="has-text-align-center"><?php echo esc_html( get_theme_mod( 'homepage_practice_areas_heading', 'Our Practice Areas' ) ); ?></h2>
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <div class="wp-block-columns">
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <div class="wp-block-column">
                    <div class="wp-block-group has-border-color has-light-gray-border-color" style="border-width:1px;border-radius:0.5rem;padding:2rem">
                        <h3><?php echo esc_html( get_theme_mod( "homepage_practice_area_{$i}_title", "Practice Area {$i}" ) ); ?></h3>
                        <p><?php echo wp_kses_post( get_theme_mod( "homepage_practice_area_{$i}_description", "Description for practice area {$i}." ) ); ?></p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="wp-block-group has-light-gray-background-color has-background" style="padding-top:4rem;padding-bottom:4rem">
        <h2 class="has-text-align-center"><?php echo esc_html( get_theme_mod( 'homepage_testimonials_heading', 'What Our Clients Say' ) ); ?></h2>
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <div class="wp-block-columns">
            <div class="wp-block-column">
                <blockquote class="wp-block-quote">
                    <p>"<?php echo wp_kses_post( get_theme_mod( 'homepage_testimonial_quote', 'Their team provided exceptional service and achieved a fantastic result for my case. I couldn\'t be happier.' ) ); ?>"</p>
                    <cite><?php echo esc_html( get_theme_mod( 'homepage_testimonial_citation', 'John Doe, CEO of Acme Inc.' ) ); ?></cite>
                </blockquote>
            </div>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
