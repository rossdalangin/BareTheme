<?php
/**
 * Template Name: Landing Page
 * Template Post Type: page
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="page-section">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <div><?php the_content(); ?></div>
    </div>

</main>

<?php
get_footer();
