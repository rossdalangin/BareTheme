<?php
/**
 * The template for displaying archive pages for the services CPT.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="services-grid">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					?>
                    <div class="service-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="service-item-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="service-item-content">
                            <h2 class="service-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="service-item-excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="read-more-link"><?php esc_html_e( 'Read More', 'closeclient-agency-theme' ); ?></a>
                        </div>
                    </div>
                <?php
				endwhile;
                ?>
            </div>
            <?php

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_footer();
