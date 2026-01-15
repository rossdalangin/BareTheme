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
    <div class="team-section">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'about_us_team_heading', 'Meet Our Team' ) ); ?></h2>
        <div class="team-grid">
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <div class="team-member">
                    <?php
                    $image_url = get_theme_mod( "about_us_team_member_{$i}_image" );
                    if ( $image_url ) :
                    ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_theme_mod( "about_us_team_member_{$i}_name" ) ); ?>" class="team-member-image"/>
                    <?php endif; ?>
                    <h4 class="team-member-name"><?php echo esc_html( get_theme_mod( "about_us_team_member_{$i}_name", "Team Member {$i}" ) ); ?></h4>
                    <p class="team-member-title"><?php echo esc_html( get_theme_mod( "about_us_team_member_{$i}_title", "Title" ) ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
