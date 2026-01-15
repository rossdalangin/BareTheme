<?php
/**
 * Template Name: Case Results / Testimonials
 * Template Post Type: page
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="testimonials-archive">
        <?php
        $args = array(
            'post_type'      => 'testimonials',
            'posts_per_page' => -1,
        );
        $testimonials_query = new WP_Query( $args );
        if ( $testimonials_query->have_posts() ) :
            while ( $testimonials_query->have_posts() ) :
                $testimonials_query->the_post();
                ?>
                <blockquote class="testimonial-item">
                    <div class="testimonial-content">
                        <?php the_content(); ?>
                    </div>
                    <cite class="testimonial-citation">&mdash; <?php the_title(); ?></cite>
                </blockquote>
            <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

</main><!-- #main -->

<?php
get_footer();
