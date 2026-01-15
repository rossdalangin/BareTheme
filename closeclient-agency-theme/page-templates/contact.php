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

    <div class="contact-section">
        <h2 class="section-heading"><?php echo esc_html( get_theme_mod( 'contact_page_heading', __( 'Contact Us', 'closeclient-agency-theme' ) ) ); ?></h2>
        <p class="section-subheading"><?php echo esc_html( get_theme_mod( 'contact_page_subheading', __( 'We\'re here to help. Reach out to us for a consultation.', 'closeclient-agency-theme' ) ) ); ?></p>

        <div class="contact-form">
            <?php
            // Display the page content first
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
