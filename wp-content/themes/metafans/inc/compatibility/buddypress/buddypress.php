<?php 
/**
 * MetaFans Integration for BuddyBress, Buddypress-gammiperss, Buddypress-learnpress
 */
class Tophive_BP
{
    static $_instance;

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function is_active() {
		return tophive_metafans()->is_buddypress_active();
	}
	function __construct(){
		if( $this->is_active() ){
			require 'dom-parser.php';
			require 'inc/profile.php';
			require 'inc/activity.php';
			require 'inc/members.php';
			require 'inc/notification.php';
			add_action( 'tophive/sidebar-id', array($this, 'th_bp_sidebar_id'), 10, 3 );
	        add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
			add_action( 'bp_core_setup_globals', array( $this, 'tophive_bp_set_default_component') );
			add_action( 'bp_actions', array( $this, 'tophive_bp_reorder_buddypress_profile_tabs'), 999 );
			add_action( 'upload_mimes', array( $this, 'add_file_types_to_uploads'));
			add_action( 'learn-press/buddypress/profile-tabs', array( $this, 'tophive_reorder_buddypress_lp_tabs'), 10, 1 );
			add_filter( 'bp_activity_allowed_tags', array($this, 'tophive_bp_activity_allowed_tags'), 10, 1 );
			if( !class_exists('Youzify') ){
				add_filter( 'bp_groups_default_extension', array( $this, 'th_groups_default_home') );
			}
			add_action( 'bp_get_the_notification_action_links', array($this, 'th_bp_notification_action_links'), 10, 2 );
			add_action( 'bp_setup_nav', array($this, 'profile_tab_photos') );

			add_action( 'wp_ajax_th_bp_bb_social_search', array($this, 'buddypress_bbpress_social_search') );
			add_action( 'wp_ajax_nopriv_th_bp_bb_social_search', array($this, 'buddypress_bbpress_social_search') );

	        add_action( 'wp_footer', array( $this, 'tophive_bp_media_viewer' ) );
	        add_action( 'wp_footer', array( $this, 'tophive_bp_activity_reactions_viewer' ) );
			add_action(	'wp_footer', array( $this, 'metafans_alert_dialogue' ));
			add_action(	'wp_footer', array( $this, 'metafans_toaster_notification' ));
	        add_action( 'bp_rest_activity_get_items', array( $this, 'metafans_bp_rest_activity_clear_cache' ), 10, 3 );
	        add_action( 'rest_api_init', array( $this, 'metafans_register_activity_rest_field'));
		}
	}
	function metafans_bp_rest_activity_clear_cache( $activities, $response, $request ){
		$response->set_headers(
			array('Cache-Control' => 'no-cache')
		);
		// $response['comments'] = 'comemts';
		return $response;
	}
	function metafans_register_activity_rest_field(){
		bp_rest_register_field(
        'activity',
        'comments',
	        array(
	            'get_callback'    => array( $this, 'comments_get_rest_field_callback' ),
	            'update_callback' => null,
	            'schema'          => array(
	                'description' => 'Comments',
	                'type'        => 'array',
	                'context'     => array( 'view', 'edit' ),
	            ),
	        )
	    );
	}
	function comments_get_rest_field_callback( $array, $attribute ){
		$metadata_key = 'tophive_activity_comments';
 
	    return bp_activity_get_meta( $array['id'], $metadata_key, true );
	}
	function th_groups_default_home( $default ) {
	    return 'activity';
	}
	function profile_tab_photos() {
      global $bp;
 
      bp_core_new_nav_item( array( 
            'name' => esc_html__( 'Photos', 'metafans' ), 
            'slug' => 'photos', 
            'screen_function' => array($this,'photos_screen'), 
            'position' => 40,
            'parent_url'      => bp_loggedin_user_domain() . '/photos/',
            'parent_slug'     => $bp->profile->slug,
            'default_subnav_slug' => 'photos'
      ) );
	}
	 
	function photos_screen() {
	    add_action( 'bp_template_content', array($this, 'photo_tab_content') );
	    bp_core_load_template( 'buddypress/members/single/plugins' );
	}
	function photo_tab_content() { 
	    $html = '';

	    $html .= '<div class="bp-profile-custom-page photos-page">';
		    $html .= '<div class="section-heading">';
		    $html .= '<h5 class="title">' . esc_html__('Photos', 'metafans') . '</h5>';
		    $html .= '</div>';
		    $html .= '<div class="section-content">';
		    $html .= apply_filters( 'tophive/buddypress/profile/photos', false );
		    $html .= '</div>';
	    $html .= '</div>';
	    echo $html;
	}

	function buddypress_bbpress_social_search(){
		$searchtext = $_REQUEST['text'];
		$posts_per_page = 3;
		// Activities query

		// Activities Query
		global $wpdb;
		$activities_sql = $wpdb->prepare("SELECT * FROM {$wpdb->base_prefix}bp_activity  WHERE content LIKE '%%%s%%' ORDER BY id DESC  LIMIT %d ",array( $searchtext, $posts_per_page ));
		$activities_results = $wpdb->get_results( $activities_sql );
		if( count($activities_results) > 0 ){
			$activity_html = '';
			$activity_html .= '<div>';
				$activity_html .= '<h6>'. esc_html__( 'Activities', 'metafans' ) .'</h6>';
				foreach($activities_results as $activity){
					$activity_permalink = bp_activity_get_permalink( $activity->id );
					$activity_html .= '<a href="'. $activity_permalink .'">';
						$activity_html .= '<div class="activity_item">';
							$activity_html .= '<div class="activity_avatar">
								'. get_avatar( $activity->user_id) .'
							</div>';
							$activity_html .= '<div>';
								$activity_html .= '<p class="activity_action"><span class="search-title">'. substr_replace( preg_replace('/<\/?a[^>]*>/','', $activity->action), "...", 45 ). '</span> • <span class="search-meta">' . $this->get_time_since($activity->date_recorded) .'</span></p>';
							$activity_html .= '</div>';
						$activity_html .= '</div>';
					$activity_html .= '</a>';
				}	
			$activity_html .= '</div>';
		}
		// TOpics Query
		$topics_wp_query = new WP_Query( array(
		    'post_type' => 'topic',
		    'posts_per_page' => 3,
		    'orderby'=> 'post_date',
		    's'=> $searchtext,
		    'post_status' => 'publish'
		));

		$topics = '';
		if( $topics_wp_query->have_posts() ){
			$topics .= '<div>';
				$topics .= '<h6>'. esc_html__( 'Topics', 'metafans' ) .'</h6>';
				while( $topics_wp_query->have_posts() ){
					$topics_wp_query->the_post();
					$forum_id = bbp_get_topic_forum_id( get_the_ID() );
					$forum_title = ! empty( $forum_id ) ? bbp_get_forum_title( $forum_id ) : '';
					$topics .= '<a class="topics-sections" href="'. get_the_permalink() .'">';
						$topics .= '<div class="topics-avatar">'. get_avatar( get_the_author_meta( 'ID' ), 40 ) .'</div>';
						$topics .= '<div class="topics-content">';
							$topics .= '<p class="search-title">' . get_the_title( get_the_ID() ) . '</p>';
							$topics .= '<p class="search-meta"><span>'. get_the_author_meta('display_name') .'</span>
							• <span>In : '. $forum_title .'</span></p>';
						$topics .= '</div>';
					$topics .= '</a>';
				}
			$topics .= '</div>';
		}
		$forum_wp_query = new WP_Query( array(
		    'post_type' => 'forum',
		    'posts_per_page' => 3,
		    'orderby'=> 'post_date',
		    's'=> $searchtext,
		    'post_status' => 'publish'
		));

		$forum = '';
		if( $forum_wp_query->have_posts() ){
			$forum .= '<div>';
				$forum .= '<h6>'. esc_html__( 'Forum', 'metafans' ) .'</h6>';
				while( $forum_wp_query->have_posts() ){
					$forum_wp_query->the_post();
					$forum .= '<p><a href="'. get_the_permalink() .'">' . get_the_title( get_the_ID() ) . '</a></p>';
				}
			$forum .= '</div>';
		}

		$user_query = new WP_User_Query( 
			array(  
				'search' => '*' . $searchtext . '*',
				'search_columns' => array( 'user_nicename', 'user_login' ),
				'number' => 3,
			)
		);
		$members = '';
		if( $user_query->get_results() ){
			$members .= '<div>';
				$members .= '<h6>'. esc_html__( 'User', 'metafans' ) .'</h6>';
				foreach( $user_query->get_results() as $user ){
					$members .= '<p><a href="'. bp_core_get_user_domain( $user->ID ) .'">' . $user->display_name . '</a></p>';
				}
			$members .= '</div>';
		}
		

		$response = $activity_html . $topics . $forum . $members;

		if( empty($response) ){
			$response = '<p class="ec-mb-0">' . esc_html__( 'Nothing Found for your search', 'metafans' ) . '</p>';
		}

		wp_send_json( $response, 200 );
	}
	/*
	** Get time since in a time
	** @since v1.0.0b 
	*
	*/
	public function get_time_since($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'min',
	        's' => 'sec',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . esc_html__(' ago', 'metafans') : esc_html__('just now', 'metafans');
	}
	/*
	** Create the buddypress alert 
	*
	*/
	function metafans_alert_dialogue(){
		?>
			<div class="metafans-alert-popup activity-delete">
				<div class="metafans-alert-popup-container">
					<div class="alert-popup-head">
						<h6><?php esc_html_e( 'Delete activity?', 'metafans' ); ?></h6>
					</div>
					<div class="alert-popup-content">
						<span class="content"><?php esc_html_e( 'This cannot be undone and this will be removed from your profile, timeline and search results.Are you sure?', 'metafans' ); ?></span>
					</div>
					<div class="alert-popup-footer">
						<button class="popup-cancel"><?php esc_html_e( 'Cancel', 'metafans' ); ?></button>
						<button class="popup-yes confirm-delete-activity"><?php esc_html_e( 'Yes, I understand', 'metafans' ); ?></button>
					</div>
				</div>
			</div>
			<div class="metafans-alert-popup notification-delete">
				<div class="metafans-alert-popup-container">
					<div class="alert-popup-head">
						<h6><?php esc_html_e( 'Delete Notification?', 'metafans' ); ?></h6>
					</div>
					<div class="alert-popup-content">
						<span class="content"><?php esc_html_e( 'This cannot be undone and this will be removed from your profile, timeline and search results.Are you sure?', 'metafans' ); ?></span>
					</div>
					<div class="alert-popup-footer">
						<button class="popup-cancel"><?php esc_html_e( 'Cancel', 'metafans' ); ?></button>
						<button class="popup-yes confirm-delete-notification"><?php esc_html_e( 'Yes, I understand', 'metafans' ); ?></button>
					</div>
				</div>
			</div>
		<?php
	} 
	function metafans_toaster_notification(){
		?>
			<div class="metafans-toaster-container">
				<div class="notification-icon">
					<span class="type-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
					</span>
				</div>
				<div class="notification-content">
					<!-- <span class="notification-close">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
							<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
						</svg>
					</span> -->
					<p class="notification-msg">
						<?php esc_html_e( 'Cheers ! It has been successfully deleted.', 'metafans' ); ?>	
					</p>
				</div>
			</div>
		<?php
	}
	function tophive_bp_activity_reactions_viewer(){
		if( is_user_logged_in() ){
			?>
				<div class="th-activity-reaction-viewer">
					<span class="close">✕</span>
					<div class="reactions"></div>
				</div>
			<?php
		}
	}
	function tophive_bp_media_viewer(){
		if(!is_user_logged_in()){
			return;
		}
		?>
			<div class="th-media-viewer-container">
				<div class="th-media-viewer">
					<span class="close">
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
						  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
						</svg>
					</span>
					<span class="image-viewer-next-prev">
						<span class="img-prev">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
							  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
							</svg>
						</span>
						<span class="img-next">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
							  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
							</svg>
						</span>
					</span>
					<div class="th-media-view"></div>
					<div class="th-media-comments">
						<div class="author_section"></div>
						<div class="comment_section"></div>
					</div>
				</div>
			</div>
		<?php
	}


	function add_file_types_to_uploads($file_types){
		$new_filetypes = array();
	    $new_filetypes['svg'] = 'image/svg';
	    $new_filetypes['svg'] = 'image/svg+xml';
	    $file_types = array_merge($file_types, $new_filetypes );

	    return $file_types;
	}
	function th_bp_notification_action_links( $retval, $r ){
		$r = wp_parse_args( $args, array(
			'before' => '',
			'after'  => '',
			'sep'    => '  ',
			'links'  => array(
				bp_get_the_notification_mark_link( $user_id ),
				bp_get_the_notification_delete_link( $user_id )
			)
		) );
		// $retval = $r['before'] . implode( $r['sep'], $r['links'] ) . $r['after'];
		return $retval;
	}
	function tophive_bp_get_context_user_id( $user_id = 0 ) {
 
	    if ( bp_is_my_profile() || ! is_user_logged_in() ) {
	        return 0;
	    }
	    if ( ! $user_id ) {
	        $user_id = bp_get_member_user_id();
	    }
	    if ( ! $user_id && bp_is_user() ) {
	        $user_id = bp_displayed_user_id();
	    }
	 
	    return apply_filters( 'tophive/buddypress/user/id', $user_id );
	}

	function tophive_bp_set_default_component () {
        define ( 'BP_DEFAULT_COMPONENT', 'activity' );
	}
	function tophive_reorder_buddypress_lp_tabs() {
		return array(
			array(
				'name'                    => __( 'Courses', 'metafans' ),
				'slug'                    => $this->get_tab_courses_slug(),
				'show_for_displayed_user' => true,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'default_subnav_slug'     => 'all',
				'position'                => 20
			),
			array(
				'name'                    => __( 'Quizzes', 'metafans' ),
				'slug'                    => $this->get_tab_quizzes_slug(),
				'show_for_displayed_user' => true,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'default_subnav_slug'     => 'all',
				'position'                => 20
			)
		);
	}
	public function get_tab_quizzes_slug() {
		$slugs = LP()->settings->get( 'profile_endpoints' );
		$slug  = '';
		if ( isset( $slugs['profile-quizzes'] ) ) {
			$slug = $slugs['profile-quizzes'];
		}
		if ( ! $slug ) {
			$slug = 'quizzes';
		}

		return sanitize_title(apply_filters( 'learn_press_bp_tab_quizzes_slug', $slug ));
	}
	public function bp_tab_content() {
		global $bp;
		$type = '';
		$current_component = $bp->current_component;
		$slugs = LP()->settings->get( 'profile_endpoints' );
		$tab_slugs_default = array( 'profile-courses', 'profile-quizzes', 'profile-orders' );
		$tab_slugs = array_keys( $slugs, $current_component );
		$tab_slugs = wp_parse_args($tab_slugs, $tab_slugs_default);
		$tab_slug = array_shift( $tab_slugs );
		if ( in_array( $tab_slug, $tab_slugs_default ) ) {
			switch ( $current_component ) {
				case  $this->get_tab_courses_slug():
					$type = 'courses';
					break;
				case  $this->get_tab_quizzes_slug():
					$type = 'quizzes';
					break;
				case  $this->get_tab_orders_slug():
					$type = 'orders';
					break;
				default:
					break;
			}
			if ( $type ) {
				add_action( 'bp_template_content', array( $this, "bp_tab_{$type}_content" ) );
				bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
			}
		}
		do_action( 'learn-press/buddypress/bp-tab-content', $current_component );
	}
	public function bp_tab_courses_content() {
		$args = array( 'user' => learn_press_get_current_user() );
		learn_press_get_template( 'profile/courses.php', $args, learn_press_template_path() . '/addons/buddypress/', LP_ADDON_BUDDYPRESS_PATH . '/templates' );
	}
	public function bp_tab_quizzes_content() {
		$args = array( 'user' => learn_press_get_current_user() );
		learn_press_get_template( 'profile/tabs/quizzes.php', $args );
	}
	public function get_tab_courses_slug() {
		$slugs = LP()->settings->get( 'profile_endpoints' );
		$slug  = '';
		if ( isset( $slugs['profile-courses'] ) ) {
			$slug = $slugs['profile-courses'];
		}
		if ( ! $slug ) {
			$slug = 'courses';
		}

		return sanitize_title(apply_filters( 'learn_press_bp_tab_courses_slug', $slug ));
	}
	function tophive_bp_reorder_buddypress_profile_tabs() {
	    $nav = buddypress()->members->nav;

	    $nav_items = array(
	        'activity' => 10,
	        'friends'  => 40,
	        'messages' => 50,
	        'groups'   => 60,
	        'blogs'    => 70,
	        'profile'  => 80,
	        'settings' => 90,
	    );
	 
	    foreach ( $nav_items as $nav_item => $position ) {
	        $nav->edit_nav( array( 'position' => $position ), $nav_item );
	    }
	    return $nav;
	}
	
	function th_bp_sidebar_id( $id, $sidebar_type = null, $bp_type = null ){
		if( $this->is_active() ){
			if( bp_current_component() !== false ){
				if( bp_is_user() && $bp_type == 'activity' ){
					switch ($sidebar_type) {
						case 'secondary':
								return 'buddy-press-profile-left';
							break;
						case 'primary':
								return 'buddy-press-profile-right';
							break;
						
						default:
								return 'buddy-press-profile-right';
							break;
					}
				}else{
					if( $bp_type == 'activity' ){
						switch ($sidebar_type) {
							case 'secondary':
									return 'buddy-press-activity-left';
								break;
							
							default:
									return 'buddy-press-activity-right';
								break;
						}
					}elseif( $bp_type == 'groups' ){
						switch ($sidebar_type) {
							case 'secondary':
									return 'buddy-press-groups-left';
								break;
							
							default:
									return 'buddy-press-groups-right';
								break;
						}
					}elseif( $bp_type == 'members' ){
						switch ($sidebar_type) {
							case 'secondary':
									return 'buddy-press-members-left';
								break;
							
							default:
									return 'buddy-press-members-right';
								break;
						}
					}elseif( $bp_type == 'profile' ){
						switch ($sidebar_type) {
							case 'secondary':
									return 'buddy-press-profile-left';
								break;
							
							default:
									return 'buddy-press-profile-right';
								break;
						}
					}
				}
			}else{
				return $id;
			}
		}
		return $id;
	}
	function load_scripts(){
		wp_enqueue_style( 'th-buddypress', get_template_directory_uri() . '/assets/css/compatibility/buddypress.css', $deps = array(), $ver = false, $media = 'all' );
		wp_enqueue_script('th-buddyrpess', get_template_directory_uri() . '/assets/js/compatibility/buddypress.js', array('jquery'), false, false);
		wp_localize_script('th-buddyrpess','mf_local', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
	}

	function tophive_bp_activity_allowed_tags( $allowed_tags ){
		return array(
			'div' => array(
				'class' => array(),
				'id' 	=> array()
			),
			'a' => array(
				'aria-label'      => array(),
				'class'           => array(),
				'data-bp-tooltip' => array(),
				'id'              => array(),
				'rel'             => array(),
				'target'          => array(),
				'href'          => array(),
			),
			'iframe' => array(
				'class' 		=> array(),
				'id' 		=> array(),
				'src' 		=> array(),
			),
			'img' => array(
				'src'    => array(),
				'alt'    => array(),
				'width'  => array(),
				'height' => array(),
				'class'  => array(),
				'id'     => array(),
			),
			'span'=> array(
				'class'          => array(),
				'data-livestamp' => array(),
			),
			'ul' => array(),
			'ol' => array(),
			'li' => array(),
		);
	}
}
function Tophive_BP() {
	return Tophive_BP::get_instance();
}

if ( tophive_metafans()->is_buddypress_active() ) {
	Tophive_BP();
}	
