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

    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="container">
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>

    <!-- Team Section -->
    <div class="page-section team-section">
        <div class="container">
            <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'about_us_team_heading', __( 'Meet Our Team', 'closeclient-agency-theme' ) ) ); ?></h2>
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
                        <div class="team-member card">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="team-member-image-wrapper">
                                    <?php the_post_thumbnail( 'medium', array( 'class' => 'team-member-image' ) ); ?>
                                </div>
                            <?php endif; ?>
                            <h4 class="team-member-name"><?php the_title(); ?></h4>
                            <div class="team-member-title"><?php the_content(); ?></div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p><?php esc_html_e( 'Please add some Team members.', 'closeclient-agency-theme' ); ?></p>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
