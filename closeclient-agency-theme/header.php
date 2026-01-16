<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'closeclient-agency-theme' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="site-branding">
            <?php the_custom_logo(); ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        </div>

        <nav id="site-navigation" class="main-navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'closeclient-agency-theme' ); ?></button>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                )
            );
            ?>
        </nav>
        <div class="header-cta">
            <a href="<?php echo esc_url( get_theme_mod( 'header_cta_button_link', '#' ) ); ?>" class="button-primary"><?php echo esc_html( get_theme_mod( 'header_cta_button_text', 'Get a Quote' ) ); ?></a>
        </div>
        <div class="dark-mode-toggle">
            <input type="checkbox" id="dark-mode-switch" name="dark-mode-switch" <?php checked( get_theme_mod( 'ccd_dark_mode_enabled' ), true ); ?>>
            <label for="dark-mode-switch"></label>
        </div>
    </header>
