<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tophive
 */
if( tophive_metafans()->is_buddypress_active() ){
	$sidebar_id = apply_filters( 'tophive/sidebar-id', 'sidebar-1', 'primary', bp_current_component() );
}

else{
	$sidebar_id = apply_filters( 'tophive/sidebar-id', 'sidebar-1', 'primary' );
}
if ( ! is_active_sidebar( $sidebar_id ) ) {
	return;
}
?>
<aside id="sidebar-primary" <?php tophive_sidebar_primary_class(); ?>>
	<div class="sidebar-primary-inner sidebar-inner widget-area">
		<?php
		do_action( 'tophive/sidebar-primary/before' );
		if( tophive_metafans()->is_bbpress_active() && is_singular('forum') ) {
			$sidebar_id = apply_filters( 'tophive/sidebar-id', 'sidebar-1', 'primary', 'forum-single' );
		}
		if( tophive_metafans()->is_bbpress_active() && is_singular('topic') ) {
			$sidebar_id = apply_filters( 'tophive/sidebar-id', 'sidebar-1', 'primary', 'topic-single' );
		}
		dynamic_sidebar( $sidebar_id );
		do_action( 'tophive/sidebar-primary/after' );
		?>
	</div>
</aside><!-- #sidebar-primary -->
