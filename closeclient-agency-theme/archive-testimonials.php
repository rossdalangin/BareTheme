<?php
/**
 * The template for displaying archive pages for the testimonials CPT.
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

			<div class="testimonials-archive">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					?>
                    <blockquote class="testimonial-item">
                        <div class="testimonial-content">
                            <?php the_content(); ?>
                        </div>
                        <cite class="testimonial-citation">&mdash; <?php the_title(); ?></cite>
                    </blockquote>
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
