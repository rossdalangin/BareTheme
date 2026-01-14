	<footer id="colophon" class="site-footer">
		<?php
		if ( ! get_theme_mod( 'closeclient_footer_layout' ) ) {
			// Default footer content if builder is not used.
			?>
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'closeclient-agency-theme' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'closeclient-agency-theme' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'closeclient-agency-theme' ), 'closeclient-agency-theme', '<a href="https://example.com/">Jules</a>' );
				?>
			</div><!-- .site-info -->
			<?php
		} else {
			// Render the footer builder.
			do_action( 'closeclient_footer' );
		}
		?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
