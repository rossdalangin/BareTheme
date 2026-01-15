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
    <div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem">
        <h2 class="has-text-align-center"><?php echo esc_html( get_theme_mod( 'about_us_team_heading', 'Meet Our Team' ) ); ?></h2>
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <div class="wp-block-columns">
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <div class="wp-block-column has-text-align-center">
                    <?php
                    $image_url = get_theme_mod( "about_us_team_member_{$i}_image" );
                    if ( $image_url ) :
                    ?>
                        <figure class="wp-block-image aligncenter size-thumbnail is-resized is-style-rounded">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_theme_mod( "about_us_team_member_{$i}_name" ) ); ?>" width="150" height="150"/>
                        </figure>
                    <?php endif; ?>
                    <h4 class="has-text-align-center"><?php echo esc_html( get_theme_mod( "about_us_team_member_{$i}_name", "Team Member {$i}" ) ); ?></h4>
                    <p class="has-text-align-center"><?php echo esc_html( get_theme_mod( "about_us_team_member_{$i}_title", "Title" ) ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
