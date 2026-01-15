    <footer id="colophon" class="site-footer">
        <div class="footer-widgets-area">
            <div class="footer-widgets-container">
                <div class="footer-widget-column">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    <?php endif; ?>
                </div>
                <div class="footer-widget-column">
                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    <?php endif; ?>
                </div>
                <div class="footer-widget-column">
                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="site-info">
            &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
