<?php
/**
 * Template Name: Contact Us
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

    <!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem">
        <!-- wp:heading {"textAlign":"center"} -->
        <h2 class="has-text-align-center">Contact Us</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"textAlign":"center"} -->
        <p class="has-text-align-center">We're here to help. Reach out to us for a consultation.</p>
        <!-- /wp:paragraph -->

        <!-- wp:spacer {"height":"2rem"} -->
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:paragraph {"textAlign":"center","style":{"typography":{"fontStyle":"italic"}},"textColor":"gray"} -->
        <p class="has-text-align-center has-gray-color has-text-color" style="font-style:italic">Your contact form shortcode or block can be placed here.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

</main><!-- #main -->

<?php
get_footer();
