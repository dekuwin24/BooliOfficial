<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tophive
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=yes">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" <?php tophive_site_classes(); ?>>
	<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'metafans' ); ?></a>
	<?php
	do_action( 'tophive/site-start/before' );
	if ( ! tophive_is_e_theme_location( 'header' ) ) {
		/**
		 * Site start
		 *
		 * Hooked
		 *
		 * @see tophive_customize_render_header - 10
		 * @see Tophive_Page_Header::render - 35
		 */
		do_action( 'tophive/site-start' );
		do_action( 'tophive/breadcrumb-start' );
	}
	do_action( 'tophive/site-start/after' );

	/**
	 * Hook before main content
	 *
	 * @since 0.2.1
	 */
	do_action( 'tophive/before-site-content' );
	?>
	<div id="site-content" <?php tophive_site_content_class(); ?>>
		<div <?php tophive_site_content_container_class(); ?>>
			<?php 
				if( tophive_metafans()->is_buddypress_active() ){
					if( bp_is_user() ){
						do_action( 'tophive/buddypress/profile-header' );
					}
				}
			?>
			<div <?php tophive_site_content_grid_class(); ?>>
				<main id="main" <?php tophive_main_content_class(); ?>>
					<?php do_action( 'tophive/main/before' ); ?>
