<?php
/**
 * Tophive functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tophive
 */

/**
 *  Same the hook `the_content`
 *
 * @TODO: do not effect content by plugins
 *
 * 8 WP_Embed:run_shortcode
 * 8 WP_Embed:autoembed
 * 10 wptexturize
 * 10 wpautop
 * 10 shortcode_unautop
 * 10 prepend_attachment
 * 10 wp_filter_content_tags
 * 11 capital_P_dangit
 * 11 do_shortcode
 * 20 convert_smilies
 */
global $wp_embed;
add_filter( 'tophive_the_content', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'tophive_the_content', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'tophive_the_content', 'wptexturize' );
add_filter( 'tophive_the_content', 'wpautop' );
add_filter( 'tophive_the_content', 'shortcode_unautop' );
add_filter( 'tophive_the_content', 'wp_filter_content_tags' );
add_filter( 'tophive_the_content', 'capital_P_dangit' );
add_filter( 'tophive_the_content', 'do_shortcode' );
add_filter( 'tophive_the_content', 'convert_smilies' );


/**
 *  Same the hook `the_content` but not auto P
 *
 * @TODO: do not effect content by plugins
 *
 * 8 WP_Embed:run_shortcode
 * 8 WP_Embed:autoembed
 * 10 wptexturize
 * 10 shortcode_unautop
 * 10 prepend_attachment
 * 10 wp_filter_content_tags
 * 11 capital_P_dangit
 * 11 do_shortcode
 * 20 convert_smilies
 */
add_filter( 'tophive_the_title', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'tophive_the_title', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'tophive_the_title', 'wptexturize' );
add_filter( 'tophive_the_title', 'shortcode_unautop' );
add_filter( 'tophive_the_title', 'wp_filter_content_tags' );
add_filter( 'tophive_the_title', 'capital_P_dangit' );
add_filter( 'tophive_the_title', 'do_shortcode' );
add_filter( 'tophive_the_title', 'convert_smilies' );

// Include the main Tophive class.
require_once get_template_directory() . '/inc/class-tophive.php';
function tophive_sanitize_filter( $elem ){
	return $elem;
}
/**
 * Main instance of Tophive.
 *
 * Returns the main instance of Tophive.
 *
 * @return Tophive
 */
function tophive_metafans() {
	return Tophive::get_instance();
}

add_action('after_switch_theme', 'matafans_setup_options');

function matafans_setup_options () {
    global $pagenow;
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
        wp_redirect(admin_url("themes.php?page=metafans-installer"));
    }   
}
add_filter('wp_nav_menu_objects', 'change_menu');

function change_menu($items){
    foreach($items as $item){

        if( $item->title == 'Activity' ){
            $last_part = basename($item->url);
            if( !home_url() ){
                if( $last_part !== 'activity' ){
                    $item->url = str_replace( $last_part, 'activity', $item->url );
                }
            }
        }
        if( $item->title == 'Members' ){
            $last_part = basename($item->url);
            $item->url = str_replace( $last_part, 'members', $item->url );
        }
    }
    return $items;
}

add_action( 'rest_api_init', function(){
    register_rest_route( 'metafans/v1', '/activity/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_activity_by_id'
    ) );
} );

function get_activity_by_id( $data ){
    $posts = get_posts( array(
        'author' => $data['id'],
      ) );
     
      if ( empty( $posts ) ) {
        return 'No posts found from this author';
      }
     
      return $posts[0]->post_title;
}

function redirect_login_page() {
    $redirect_page = tophive_metafans()->get_setting('theme_globals_unsigned_redirect');
    if( !empty($redirect_page) ){
        if ( ! is_user_logged_in() && ! is_page( $redirect_page ) && !is_home() && !is_singular('post') ) {
            wp_redirect( home_url( '/' . $redirect_page . '/' ) );
            exit;
        }elseif( is_user_logged_in() && is_page( $redirect_page ) ){
            wp_redirect( home_url( '/' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'redirect_login_page' );

function hashtag_template( $template ){
    global $wp_query;
    $hash = get_query_var('hashtag');
    if( !empty($hash) ){
        return locate_template('hashtag-search.php');
    }
    return $template;
}
add_action( 'template_include', 'hashtag_template' );
function metafans_query_vars( $qvars ) {
    $qvars[] = 'hashtag';
    return $qvars;
}
add_filter( 'query_vars', 'metafans_query_vars' );
require_once get_parent_theme_file_path( '/inc/admin/plugins/plugins.php' );
require_once get_parent_theme_file_path( '/inc/admin/import/import.php' );

require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/inc/merlin/merlin-config.php' );
require_once get_parent_theme_file_path( '/inc/merlin/merlin-filters.php' );


tophive_metafans();

//api need to refector to anather file
function mf_activity_search(){
	$photo_type = "all";
	$search_term = false;
	if(isset($_POST['photo_type']) ){
		$photo_type = $_POST['photo_type'];
	}
	if(isset($_POST['search_term']) && !empty($_POST['search_term'])){
		$search_term = $_POST['search_term'];
	}

	if($search_term){
		$activityes = BP_Activity_Activity::get(
			array(
				'page' => 1,
				'per_page' => false,
				'fields' => 'ids',
				'search_terms' => $search_term,
				'filter' => array(
					'user_id' => $photo_type == "all" ? false : get_current_user_id(),
				),
			)
		);
	}else{
	$activityes = BP_Activity_Activity::get(
		array(
			'page' => 1,
			'per_page' => false,
			'fields' => 'ids',
			'filter' => array(
				'user_id' => $photo_type == "all" ? false : get_current_user_id(),
			),
		)
	);
	}

	$photos = array();

	foreach( $activityes['activities'] as $id ){
		$is_album = bp_activity_get_meta($id,'is_album_activity',true);

		if(! empty($is_album) ){
			$images = bp_activity_get_meta( $id, 'activity_media', false );
			if( !empty( $images ) && !empty( $images[0] )  ){
				$newImages = $images[0];
					$newImages['album'] = true;
					$newImages['activity_id'] = $id;
					array_push($photos,$newImages);	
			}
		}else{
			$images = bp_activity_get_meta( $id, 'activity_media', false );
			if( !empty( $images ) && !empty( $images[0] )  ){
				$newImages = $images[0];
				$newImages['album'] = false;
				$newImages['activity_id'] = $id;
				array_push($photos,$newImages);	
			}
		}
	}
	wp_send_json($photos,200);
}
add_action("wp_ajax_mf_activity_search",'mf_activity_search');
add_action("wp_ajax_nopriv_mf_activity_search",'mf_activity_search');

function mf_get_activity_by_id(){

	$activity = BP_Activity_Activity::get(
		array(
			'in' => array($_POST['activity_id']),
			)
	);

	$activity["meta"] =  bp_activity_get_meta($_POST['activity_id'],'activity_media',true);
	$activity["activity_visibility"] =  bp_activity_get_meta($_POST['activity_id'],'activity_accessibility',true);

	wp_send_json($activity,200);
}
add_action("wp_ajax_mf_get_activity_by_id",'mf_get_activity_by_id');
add_action("wp_ajax_nopriv_mf_get_activity_by_id",'mf_get_activity_by_id');


function mf_get_activity_content_by_id(){

	$activity = BP_Activity_Activity::get(
		array(
			'in' => array($_POST['activity_id']),
			)
	);

	$html = $activity["activities"][0];
	wp_send_json($html,200);
}
add_action("wp_ajax_mf_get_activity_content_by_id",'mf_get_activity_content_by_id');
//add_action("wp_ajax_nopriv_mf_get_activity_content_by_id",'mf_get_activity_content_by_id');
