<?php
/**
 * Available filters for extending Merlin WP.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

/**
 * Filter the home page title from your demo content.
 * If your demo's home page title is "Home", you don't need this.
 *
 * @param string $output Home page title.
 */
/*function prefix_merlin_content_home_page_title( $output ) {
	return 'My front page';
}
add_filter( 'merlin_content_home_page_title', 'prefix_merlin_content_home_page_title' );*/

/**
 * Filter the blog page title from your demo content.
 * If your demo's blog page title is "Blog", you don't need this.
 *
 * @param string $output Index blogroll page title.
 */
function metafans_merlin_content_blog_page_title( $output ) {
	return 'Journal';
}
add_filter( 'merlin_content_blog_page_title', 'metafans_merlin_content_blog_page_title' );

/**
 * Add your widget area to unset the default widgets from.
 * If your theme's first widget area is "sidebar-1", you don't need this.
 *
 * @see https://stackoverflow.com/questions/11757461/how-to-populate-widgets-on-sidebar-on-theme-activation
 *
 * @param  array $widget_areas Arguments for the sidebars_widgets widget areas.
 * @return array of arguments to update the sidebars_widgets option.
 */
function metafans_merlin_unset_default_widgets_args( $widget_areas ) {

	$widget_areas = array(
		'sidebar-1' => array(),
	);

	return $widget_areas;
}
add_filter( 'merlin_unset_default_widgets_args', 'metafans_merlin_unset_default_widgets_args' );

/**
 * Custom content for the generated child theme's functions.php file.
 *
 * @param string $output Generated content.
 * @param string $slug Parent theme slug.
 */
function metafans_generate_child_functions_php( $output, $slug ) {

    $slug_no_hyphens = strtolower( preg_replace( '#[^a-zA-Z]#', '', $slug ) );

    $output = "
        <?php
        /**
         * Theme functions and definitions.
         */
        function {$slug_no_hyphens}_child_enqueue_styles() {
            if ( SCRIPT_DEBUG ) {
                wp_enqueue_style( '{$slug}-style' , get_template_directory_uri() . '/style.css' );
            } else {
                wp_enqueue_style( '{$slug}-minified-style' , get_template_directory_uri() . '/style.min.css' );
            }
            wp_enqueue_style( '{$slug}-child-style',
                get_stylesheet_directory_uri() . '/style.css',
                array( '{$slug}-style' ),
                wp_get_theme()->get('Version')
            );
        }
        add_action(  'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles' );\n
    ";

    // Let's remove the tabs so that it displays nicely.
    $output = trim( preg_replace( '/\t+/', '', $output ) );

    // Filterable return.
    return $output;
}
add_filter( 'merlin_generate_child_functions_php', 'metafans_generate_child_functions_php', 10, 2 );

/**
 * Define the demo import files (remote files).
 *
 * To define imports, you just have to add the following code structure,
 * with your own values to your theme (using the 'merlin_import_files' filter).
 */

/* Function located in /inc/admin/imports/import.php */
add_filter( 'merlin_import_files', 'metafans_ocdi_import_files' );


/**
 * Execute custom code after the whole import has finished.
 */
/* Function located in /inc/admin/imports/import.php */
add_action( 'merlin_after_all_import', 'metafans_ocdi_after_import' );
