<?php
/**
 * Template Name: Portfolio
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

    <div class="gallery-grid">
        <?php
        $args = array(
            'post_type'      => 'gallery',
            'posts_per_page' => -1,
        );
        $gallery_query = new WP_Query( $args );
        if ( $gallery_query->have_posts() ) :
            while ( $gallery_query->have_posts() ) :
                $gallery_query->the_post();
                ?>
                <div class="gallery-item">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </a>
                    <?php endif; ?>
                    <h2 class="gallery-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
