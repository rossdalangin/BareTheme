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
            <?php
            $args = array(
                'post_type'      => 'services',
                'posts_per_page' => 3,
            );
            $services_query = new WP_Query( $args );
            if ( $services_query->have_posts() ) :
                while ( $services_query->have_posts() ) :
                    $services_query->the_post();
                    ?>
                    <div class="practice-area-item">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div><?php the_excerpt(); ?></div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="testimonials-section">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'homepage_testimonials_heading', 'What Our Clients Say' ) ); ?></h2>
        <?php
        $testimonial_ids = get_theme_mod( 'homepage_testimonials', array() );

        if ( ! empty( $testimonial_ids ) ) :
            $args = array(
                'post_type'      => 'testimonials',
                'post__in'       => $testimonial_ids,
                'orderby'        => 'post__in',
            );
            $testimonials_query = new WP_Query( $args );
            if ( $testimonials_query->have_posts() ) :
                while ( $testimonials_query->have_posts() ) :
                    $testimonials_query->the_post();
                    ?>
                    <blockquote class="testimonial-quote">
                        <p>"<?php echo wp_kses_post( get_the_content() ); ?>"</p>
                        <cite><?php the_title(); ?></cite>
                    </blockquote>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
        endif;
        ?>
    </div>

</main><!-- #main -->

<?php
get_footer();
