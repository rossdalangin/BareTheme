<?php
/**
 * Template Name: About Us
 * Template Post Type: page
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Team Section -->
    <div class="page-section team-section">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'about_us_team_heading', 'Meet Our Team' ) ); ?></h2>
        <div class="team-grid">
            <?php
            $args = array(
                'post_type'      => 'team',
                'posts_per_page' => -1,
            );
            $team_query = new WP_Query( $args );
            if ( $team_query->have_posts() ) :
                while ( $team_query->have_posts() ) :
                    $team_query->the_post();
                    ?>
                    <div class="team-member">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'team-member-image' ) ); ?>
                        <?php endif; ?>
                        <h4 class="team-member-name"><?php the_title(); ?></h4>
                        <div class="team-member-title"><?php the_content(); ?></div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
