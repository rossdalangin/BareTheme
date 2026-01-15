<!-- Testimonials -->
<div class="testimonials-section">
    <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'homepage_testimonials_heading', __( 'What Our Clients Say', 'closeclient-agency-theme' ) ) ); ?></h2>
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
