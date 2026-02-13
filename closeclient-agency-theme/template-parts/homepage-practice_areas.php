<?php
/**
 * Template part for displaying practice areas on the homepage.
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */
?>
<!-- Practice Areas -->
<div id="practice-areas" class="practice-areas-section">
    <div class="container">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'homepage_practice_areas_heading', __( 'Our Practice Areas', 'closeclient-agency-theme' ) ) ); ?></h2>
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
                    <article class="practice-area-item card">
                        <h3><?php the_title(); ?></h3>
                        <div class="practice-area-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="button-link"><?php esc_html_e( 'Learn More &rarr;', 'closeclient-agency-theme' ); ?></a>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p><?php esc_html_e( 'Please add some Services to display here.', 'closeclient-agency-theme' ); ?></p>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>
