<?php
/**
 * The template for displaying all single posts for the gallery CPT.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package CLOSECLIENT_AGENCY_THEME
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div><!-- .post-thumbnail -->
                <?php endif; ?>

            </article><!-- #post-<?php the_ID(); ?> -->
            <?php

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
