<?php
/**
 * Template Name: Services / Practice Areas
 * Template Post Type: page
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="services-grid">
        <?php
        $args = array(
            'post_type'      => 'services',
            'posts_per_page' => -1,
        );
        $services_query = new WP_Query( $args );
        if ( $services_query->have_posts() ) :
            while ( $services_query->have_posts() ) :
                $services_query->the_post();
                ?>
                <div class="service-item">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div><?php the_excerpt(); ?></div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

</main><!-- #main -->

<?php
get_footer();
