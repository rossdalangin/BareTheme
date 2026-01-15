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

    <?php
    // Display the page content first
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>

    <!-- wp:pattern {"slug":"closeclient-agency-theme/team-section"} /-->

</main><!-- #main -->

<?php
get_footer();
