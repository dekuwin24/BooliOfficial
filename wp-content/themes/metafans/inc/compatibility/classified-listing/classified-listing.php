<?php 
/**
 * MetaFans Integration for BuddyBress, Buddypress-gammiperss, Buddypress-learnpress
 */
class Tophive_CL
{
    static $_instance;

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function is_active() {
		return class_exists('Rtcl');
	}
	function __construct(){
		if( $this->is_active() ){
			add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
		}
	}
	function load_scripts(){
		wp_enqueue_style( 'th-classified-listing', get_template_directory_uri() . '/assets/css/compatibility/classified-listing.css', $deps = array(), $ver = false, $media = 'all' );
	}
}
function Tophive_CL() {
	return Tophive_CL::get_instance();
}

if ( tophive_metafans()->is_classified_listing_active() ) {
	Tophive_CL();
}	