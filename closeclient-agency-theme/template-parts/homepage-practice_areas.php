<!-- Practice Areas -->
<div class="practice-areas-section">
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
