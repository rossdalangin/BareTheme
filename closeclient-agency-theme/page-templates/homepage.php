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

    <?php
    $sections = json_decode( get_theme_mod( 'homepage_sections_order', json_encode( array( 'hero' => true, 'practice_areas' => true, 'testimonials' => true ) ) ), true );

    foreach ( $sections as $section => $enabled ) {
        if ( $enabled ) {
            ?>
            <div class="page-section">
                <?php get_template_part( 'template-parts/homepage', $section ); ?>
            </div>
            <?php
        }
    }
    ?>

</main><!-- #main -->

<?php
get_footer();
