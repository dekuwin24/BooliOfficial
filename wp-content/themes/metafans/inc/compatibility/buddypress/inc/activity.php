<?php 
/**
 ***
 ** MetaFans BuddyPress Activity Integration
 ** @package WordPress
 ** @subpackage Metafans
 ** @since 2.3.0
 *
 *
 */
class Tophive_BP_Activity
{
    static $_instance;
    public $helper = '';

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct(){
		if( $this->is_active() ){
			require_once 'helper.php';
			// require_once 'media.php';
			$this->helper = new Tophive_BP_Helper();
			// $this->media = new Tophive_BP_Media();
			define( 'ALLOW_UNFILTERED_UPLOADS', true );
			add_action( 'tophive/buddypress/activity/share-activity', 	array( $this, 'shared_activity' ), 10, 1 );
			add_action( 'bp_before_activity_post_form', 				array( $this, 'before_activity_post_form' ) );
			add_action( 'tophive/buddypress/activity/comments', 		array( $this, 'activity_comments' ) );
			add_action( 'tophive/buddypress/search/activity/comments', 	array( $this, 'activity_search_comments' ), 10, 1 );
			add_action( 'tophive/buddypress/activity/header', 			array( $this, 'activity_header'), 10, 1 );
			add_action( 'tophive/buddypress/search/activity/header', 	array( $this, 'activity_search_header' ), 10, 1 );
			add_action( 'tophive/buddypress/activity/content', 			array( $this, 'activity_content' ) );
			add_action( 'tophive/buddypress/activity/media', 			array( $this, 'activity_media' ) );
			add_action( 'tophive/buddypress/search/activity/media', 	array( $this, 'activity_search_media' ), 10, 1 );

			// Add new activity
			add_action( 'wp_ajax_th_bp_post_update', 					array($this, 'activity_update') );
			add_action( 'wp_ajax_nopriv_th_bp_post_update', 			array($this, 'activity_update') );
			
			// Delete activity
			add_action( 'wp_ajax_metafans_activity_delete', 			array( $this, 'metafans_activity_delete') );
			add_action( 'wp_ajax_nopriv_metafans_activity_delete', 		array( $this, 'metafans_activity_delete') );

	        // Add attachments mimetypes
			add_filter('upload_mimes', array($this, 'th_allowed_mime_types'), 99);
			// Uploading Activity Media Files
	        add_action( 'wp_ajax_activity_upload', array($this, 'activity_media_upload') );
	        add_action( 'wp_ajax_nopriv_activity_upload', array($this, 'activity_media_upload') );

	        // Remove activity media files
	        add_action( 'wp_ajax_th_bp_remove_media', array($this, 'activity_remove_media') );
	        add_action( 'wp_ajax_nopriv_th_bp_remove_media', array($this, 'activity_remove_media') );

	        // Get media files author - ajax action
	        add_action( 'wp_ajax_th_bp_media_author', array($this, 'media_author') );
			add_action( 'wp_ajax_nopriv_th_bp_media_author', array($this, 'media_author') );

			// activity visibility update
			add_action( 'wp_ajax_th_bp_update_activity_visibility', array( $this, 'update_activity_visibility') );
			// activity favourite 
			add_action( 'wp_ajax_th_bp_add_favourite_activity', array( $this, 'add_favorite_activity') );
			//search 
			add_action( 'wp_ajax_tophive_search', array( $this, 'get_search_result') );
		

	        // Activity Comments - Add Activity Comments
			add_action( 'wp_ajax_tophive_bp_activity_comment', array($this, 'add_comment') );
			add_action( 'wp_ajax_nopriv_tophive_bp_activity_comment', array($this, 'add_comment') );

			// Activity Comments - Delete Activity Comments
			add_action( 'wp_ajax_tophive_bp_delete_comment', array($this, 'delete_comment') );
			add_action( 'wp_ajax_nopriv_tophive_bp_delete_comment', array($this, 'delete_comment') );

			// Activity Comments - Load more activity comments
			add_action( 'wp_ajax_tophive_bp_more_comments', array($this, 'show_more_comments') );
			add_action( 'wp_ajax_nopriv_tophive_bp_more_comments', array($this, 'show_more_comments') );

			// Activity Reactions 
			add_action( 'wp_ajax_th_bp_activity_reaction', array($this, 'tophive_bp_activity_reaction') );
			add_action( 'wp_ajax_nopriv_th_bp_activity_reaction', array($this, 'tophive_bp_activity_reaction') );

			// Activity Reactions - Get All Reactions
			add_action( 'wp_ajax_th_bp_activity_all_reaction', array($this, 'tophive_bp_activity_all_reaction') );
			add_action( 'wp_ajax_nopriv_th_bp_activity_all_reaction', array($this, 'tophive_bp_activity_all_reaction') );

			// Activity Share - Post activity share
			add_action( 'wp_ajax_tophive_bp_share_activity', array($this, 'post_activity_share') );
			add_action( 'wp_ajax_nopriv_tophive_bp_share_activity', array($this, 'post_activity_share') );

			// Activity URL Scrapper
			add_action( 'wp_ajax_tophive_bp_get_scrapped_html', array($this, 'scrape_url') );
			add_action( 'wp_ajax_nopriv_tophive_bp_get_scrapped_html', array($this, 'scrape_url') );

			// Media Comments - get media comments
			add_action( 'wp_ajax_th_bp_media_comments', array($this, 'media_comments_html') );
			add_action( 'wp_ajax_nopriv_th_bp_media_comments', array($this, 'media_comments_html') );

			// Media Comments - post media comments
			add_action( 'wp_ajax_th_bp_media_comments_post', array($this, 'post_media_comments') );
			add_action( 'wp_ajax_nopriv_th_bp_media_comments_post', array($this, 'post_media_comments') );

			// Media Reactions 
			add_action( 'wp_ajax_th_bp_media_reaction', array($this, 'media_reaction') );
			add_action( 'wp_ajax_nopriv_th_bp_media_reaction', array($this, 'media_reaction') );
			/* --------------- delete comments ---------------*/
	        // Activity Footer
	        add_action( 'bp_footer_actions', array($this, 'footer_actions') );
	        add_action( 'bp_footer_search_actions', array($this, 'footer_search_actions'), 10, 1 );

	        // Load Imojis
	        add_action( 'wp_enqueue_scripts', array( $this, 'activity_scripts' ), 10, 1 );

	        // activity type filter
	        add_action( 'bp_activity_check_activity_types', array( $this, 'activity_type_filter' ), 10, 1 );
		}
	}

	public function update_activity_visibility () {
		$id = $_POST["activity_id"];
		$activity_accessibility = $_POST["activity_accessibility"];
		$activity_arr = bp_activity_get( array("in" => $id ) )["activities"];
		if(! empty($activity_arr) ){
			$can_update = $activity_arr[0]->user_id === get_current_user_id();
			if($can_update){
			   bp_activity_update_meta( intval($id), 'activity_accessibility', $activity_accessibility );
			   wp_send_json("success fully updated",200);
			}
		}
		wp_send_json("something wrong. try again later.", 404);
	}

	public function add_favorite_activity () {
		$id = $_POST["activity_id"];
		$mode = $_POST["action_type"];
		if(empty( $id )){
			wp_send_json( __("Cant make this Action","metafans"), 400);
		}
		
		if($mode === "add"){
			$result = bp_activity_add_user_favorite( $id );
			if($result){
				wp_send_json( __("Added to your favorite"), 200);
				die();
			}
		}
		if($mode === "delete") {
			$result = bp_activity_remove_user_favorite( $id );
			if($result){
				wp_send_json( __("Removed from your favorite"), 200);
				die();
			}
		}
		wp_send_json( __("Something wrong. Try again later"), 500);
	}

	//this fn retuen search result based on parameter 
	//send by client. 
	//@param `post_type` either any of this 'USERS,ACTIVITY,FORUM,TOPICS,BLOGS'
	//@param `posts_per_page` int number. How many posts to return
	//@param `searchtext` string get result based on this string
	//@param `offset` int how many result to skip

	public function get_search_result () {
		$post_type = $_POST["post_type"];
		$posts_per_page = $_POST["posts_per_page"];
		$searchtext = $_POST["searchtext"];
		$offset = $_POST["offset"];

		switch ($post_type) {
			case "USERS":
				//user query
				$users_query = new WP_User_Query( array(
				    'search'         => '*'.esc_attr( $searchtext ).'*',
				    'number'	     => $posts_per_page,
				    'search_columns' => array(
					'user_login',
					'user_nicename',
				    ),
				) );
				$users = $users_query->get_results();

			case "ACTIVITY":
				// Activities Query
				global $wpdb;
				$activities_sql = $wpdb->prepare("SELECT * FROM {$wpdb->base_prefix}bp_activity  WHERE content LIKE '%%%s%%' ORDER BY id DESC  LIMIT %d ",array( $searchtext,$posts_per_page ));

				$activities_results = $wpdb->get_results( $activities_sql );

			case "FORUM":
				//forum query
				$forum_query = new WP_Query(array(
					"s"	=> $searchtext,
					"post_type" => "forum",
					"posts_per_page" => $posts_per_page,
				));

			case "TOPICS":
				//topics query
				$topics_query = new WP_Query(array(
					"s"	=> $searchtext,
					"post_type" => "topic",
					"posts_per_page" => $posts_per_page,
				));

			case "BLOGS":
				//blogs query
				$blogs_query = new WP_Query(array(
					"s"	=> $searchtext,
					"post_type" => "post",
					"posts_per_page" => $posts_per_page,
				));
			}
	}

	public function activity_scripts(){
		wp_enqueue_style('metafans-emojis', get_template_directory_uri() . '/assets/css/compatibility/emoji.css', false);
		wp_enqueue_script('metafans-emojis', get_template_directory_uri() . '/assets/js/compatibility/emoji.js', false);
		wp_localize_script( 'metafans-emojis', 'emoji_object',
	        array( 
	            'sitedir' => get_template_directory_uri(),
	        )
	    );
	}

	public function activity_type_filter($types){
		$types = array();
		return $types;
	}

	/**
	***
	*  Post Or update an activity
	*  
	*  @since 1.0.0
	*  @return Ajax reponse on activity update
	*
	**
	*/

	public function activity_update(){
		$bp = buddypress();
		
		$response = [];
		$data = $_POST['data'];
		$media = $data['whats-new-post-media'];
		$preview_url = $data['whats-new-post-url-preview'];
		$activity_accessibility = $data['activity_accessibility'];
		$activity_id = isset( $data['activity_id'] ) ? $data['activity_id'] : false;
		$is_delete_activity = false;
		$is_album_activity = array();
		$media_urls = [];


		$content = apply_filters( 'bp_activity_post_update_content', $data['whats-new-post-content'] );

		if ( ! empty( $data['whats-new-post-object'] ) ) {
			$object = apply_filters( 'bp_activity_post_update_object', $data['whats-new-post-object'] );
		}

		if ( ! empty( $data['whats-new-post-in'] ) ) {
			$item_id = apply_filters( 'bp_activity_post_update_item_id', $data['whats-new-post-in'] );
		}

		if(  isset( $data['is_album_activity'] ) ) {
			$is_album_activity = array(
				'album_name' => $data['is_album_activity']['name'],
				'created_at' => time()
			);
		}

		if ( isset( $data['is_delete_activity'] ) && $data['is_delete_activity'] === "true" ) {
			$is_delete_activity = true;
		}

		if(!empty( $media )){
			$media = explode(', ', $media);

			foreach ($media as $value) {
				$id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1, 10);
				$media_url['id'] = $id;
				$media_url['thumb'] = wp_get_attachment_image_src( $value, array(300, 300) );
				$media_url['full'] = wp_get_attachment_url( $value );
				$media_url['author'] = get_current_user_id();
				$media_url['reactions'] = array(
					'likes' => 0,
					'love' 	=> 0,
					'care' 	=> 0,
					'haha' 	=> 0,
					'sad'	=> 0,
					'wow'	=> 0,
					'angry'	=> 0,
					'so_what' => 0
				);
				$media_url['comments'] = array();
				$media_url['timestamp'] = time();
				$media_url['attachment_id'] = $value;
				$media_url['attachment_type'] = get_post_mime_type($value);

				array_push( $media_urls, $media_url );
			}
		}

		if( empty($content) ){
			$content = '<span></span>';

		}
		$content = $this->helper->convert_strings($content);

		$content = $this->helper->convert_hashtag($content);
		if( !empty($preview_url) ){
			$ch = curl_init($preview_url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		    /* Set a browser UA so that we aren't told to update */
		    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36');

		    $res = curl_exec($ch);

		    if ($res === false) {
		        die('error occured: ' . curl_error($ch));
		    }

		    curl_close($ch);

		    $d = new DOMDocument();
		    @$d->loadHTML($res);

		    $output = array(
		        'title' => '',
		        'thumb'  => '',
		        'site_name'  => ''
		    );

		    $x = new DOMXPath($d);

		    $title = $x->query("//title");
		    if ($title->length > 0) {
		        $output['title'] = $title->item(0)->textContent;
		    }

		    $meta = $x->query("//meta[@property = 'og:image']");
		    if ($meta->length > 0) {
		        $output['thumb'] = $meta->item(0)->getAttribute('content');
		    }

		    $site_name = $x->query("//meta[@property = 'og:site_name']");
		    if ($site_name->length > 0) {
		        $output['site_name'] = $site_name->item(0)->getAttribute('content');
		    }
			// $html_dom = file_get_html($preview_url);
			// $title = $html_dom->find('title', 0);
			// $image = $html_dom->find('meta[property="og:image"]', 0);
			// $site_name = $html_dom->find('meta[property="og:site_name"]', 0);

			// $res['title'] = $title->plaintext;
			// $res['thumb'] = $image->content;
			// $res['site_name'] = $site_name->content;

			$parse = parse_url($preview_url);

			$urltype = $this->helper->detectMediaUrlType( $preview_url );

			if( $urltype['video_type'] == 'youtube' || $urltype['video_type'] == 'vimeo' ){
				$embedurl = $this->helper->generateVideoEmbedUrl( $preview_url );
				$prev_thumb = '<div class="whats-new-live-preview">';
					$prev_thumb .= '<div class="video-embed preview-thumb">';
						$prev_thumb .= '<iframe src="'. $embedurl .'" ></iframe>';
					$prev_thumb .= '</div>';
				$prev_thumb .= '</div>';
			}elseif( $urltype['video_type'] == 'soundcloud' ){
				$embedurl = 'https://w.soundcloud.com/player/?url=' . $urltype['video_id'];
				$prev_thumb = '<div class="activity-soundcloud-embed">';
					$prev_thumb .= '<iframe src='. $embedurl .'/>';
				$prev_thumb .= '</div>';
			}else{
				$prev_thumb = '<a href="'. $preview_url .'" target="_blank" class="link_open_new_tab">';
				$prev_thumb .= '<div class="whats-new-live-preview">';
					$prev_thumb .= '<div class="preview-thumb">';
						$prev_thumb .= '<img src="'. $output['thumb'] .'" />';
					$prev_thumb .= '</div>';
					$prev_thumb .= '<div class="preview-content">';
						$prev_thumb .= '<span>'. $output['site_name'] .'</span>';
						$prev_thumb .= '<span>'. $output['title'] .'</span>';
					$prev_thumb .= '</div>';
				$prev_thumb .= '</div>';
				$prev_thumb .= '</a>';
			}

			$content = $content . $prev_thumb;
		}
		if ( empty( $content ) && empty( $media ) ) {
			$response['error'][] = esc_html__( 'Please enter some content to post.', 'metafans' );
			wp_send_json( $response, 200 );
		}
		if ( empty( $item_id ) || $item_id == 0 ) {
				if($is_delete_activity){
					bp_activity_delete(array('id' => $data['activity_id']));
				}
			    $activity_id = bp_activity_post_update( array('content' => $content ) );
		} elseif ( 'groups' == $object && bp_is_active( 'groups' ) ) {
			if ( (int) $item_id ) {
				if($is_delete_activity){
					bp_activity_delete(array('id' => $data['activity_id']));
				}
				$activity_id = groups_post_update( array( 'content' => $content, 'group_id' => $item_id, 'id' => intval($activity_id) ) );
			}
		}

		if( $activity_id ){
			bp_activity_update_meta( $activity_id, 'activity_media', $media_urls );
			bp_activity_update_meta( $activity_id, 'activity_accessibility', $activity_accessibility );
			if(  isset( $data['is_album_activity'] ) ) {
			bp_activity_update_meta( $activity_id, 'is_album_activity', $is_album_activity );
			}
			if($is_delete_activity){
				bp_activity_update_meta( $activity_id, 'last_edited', array( "is_edited" => true, "timestamp" => time() ) );
			}

		}

		$last_recorded = current_time( 'timestamp' );
		$activity_args = array( 
			'since' 		=> $last_recorded,
			'activity_id' 	=> $activity_id,
			'class'			=> 'activity activity_update activity-item date-recorded-'. $last_recorded .' just-posted',
		);

		if ( bp_has_activities ( $activity_args ) ) {
			$response['activity'] = $this->get_activity_html( $activity_args );
		}
		if ( !empty( $activity_id ) ){
			$response['success']['message'] = esc_html__( 'Post and media updated', 'metafans' );
			$response['success']['res'] = true;
		}
		else
			$response['error'][] = esc_html__( 'There was an error when posting your update. Please try again.', 'metafans' );
		wp_send_json( $response, 200 );
	}


	public function get_activity_html( $args ){
		$activity = new BP_Activity_Activity( $args['activity_id'] );



		$activity_accessibility_type = bp_activity_get_meta($args['activity_id'],'activity_accessibility',true);
		$activity_visibility_svg = "";

		if(empty($activity_accessibility_type)){
			$activity_accessibility_type = "public";
		}

	switch($activity_accessibility_type){
		case "public":
			$activity_visibility_svg = '<span class="ac-vi-co" data-vi="1"><span class="ac_vi_text">' . __('Public','tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="16" height="16" fill="#b6b0ae"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg></span>';
		break;

		case "friends":
			$activity_visibility_svg = '<span class="ac-vi-co" data-vi="2"><span class="ac_vi_text">' . __('Friends','tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" fill="#b6b0ae"><title>People</title><path d="M336 256c-20.56 0-40.44-9.18-56-25.84-15.13-16.25-24.37-37.92-26-61-1.74-24.62 5.77-47.26 21.14-63.76S312 80 336 80c23.83 0 45.38 9.06 60.7 25.52 15.47 16.62 23 39.22 21.26 63.63-1.67 23.11-10.9 44.77-26 61C376.44 246.82 356.57 256 336 256zm66-88zM467.83 432H204.18a27.71 27.71 0 01-22-10.67 30.22 30.22 0 01-5.26-25.79c8.42-33.81 29.28-61.85 60.32-81.08C264.79 297.4 299.86 288 336 288c36.85 0 71 9 98.71 26.05 31.11 19.13 52 47.33 60.38 81.55a30.27 30.27 0 01-5.32 25.78A27.68 27.68 0 01467.83 432zM147 260c-35.19 0-66.13-32.72-69-72.93-1.42-20.6 5-39.65 18-53.62 12.86-13.83 31-21.45 51-21.45s38 7.66 50.93 21.57c13.1 14.08 19.5 33.09 18 53.52-2.87 40.2-33.8 72.91-68.93 72.91zM212.66 291.45c-17.59-8.6-40.42-12.9-65.65-12.9-29.46 0-58.07 7.68-80.57 21.62-25.51 15.83-42.67 38.88-49.6 66.71a27.39 27.39 0 004.79 23.36A25.32 25.32 0 0041.72 400h111a8 8 0 007.87-6.57c.11-.63.25-1.26.41-1.88 8.48-34.06 28.35-62.84 57.71-83.82a8 8 0 00-.63-13.39c-1.57-.92-3.37-1.89-5.42-2.89z"/></svg></span>';
			break;

		case "onlyme":
			$activity_visibility_svg = '<span class="ac-vi-co" data-vi="3"><span class="ac_vi_text">' . __('Me','tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" width="30px" height="30px">
			<g id="surface67244366">
			<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 15 2 C 11.144531 2 8 5.144531 8 9 L 8 11 L 6 11 C 4.894531 11 4 11.894531 4 13 L 4 25 C 4 26.105469 4.894531 27 6 27 L 24 27 C 25.105469 27 26 26.105469 26 25 L 26 13 C 26 11.894531 25.105469 11 24 11 L 22 11 L 22 9 C 22 5.273438 19.035156 2.269531 15.355469 2.074219 C 15.242188 2.027344 15.121094 2.003906 15 2 Z M 15 4 C 17.773438 4 20 6.226562 20 9 L 20 11 L 10 11 L 10 9 C 10 6.226562 12.226562 4 15 4 Z M 15 4 "/>
			</g>
			</svg></span>';
		break;

	default:
			$activity_visibility_svg = '<span class="ac-vi-co" data-vi="1"><span class="ac_vi_text">' . __('Public','tophive') . '</span><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="16" height="16" fill="#b6b0ae"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg></span>';
	}




		$activity_permalink = bp_activity_get_permalink( $args['activity_id'] );
		$time_since = '<span class="time-since">'. esc_html__( 'Just now', 'metafans' ) .'</span>';			

		$activity_meta = sprintf( '<a href="%1$s" class="view activity-time-since bp-tooltip" data-bp-tooltip="%2$s">%3$s</a>',
			$activity_permalink,
			esc_attr__( 'View Discussion', 'metafans' ),
			$time_since
		);
		$can_edite = bp_activity_user_can_delete( $activity ) ? "data-canedite=true" : "data-canedite=false";
		$html = '<li class="'. $args['class'] .'" id="activity-'. $args['activity_id'] .'" data-bp-activity-id="'. $args['activity_id'] .'" data-bp-timestamp="'. $args['since'] .'"' . $can_edite . '>';

			$html .= '<div class="activity-avatar item-avatar">';

				$html .= '<a href="'. bp_core_get_user_domain( get_current_user_id() ) .'">';

					$html .= bp_get_activity_avatar( array( 'type' => 'full', 'user_id' => get_current_user_id() ) );

				$html .= '</a>';

			$html .= '</div>';

			$html .= '<div class="activity-content">';

				$html .= '<div class="activity-header">';

					$html .= $this->get_activity_header( $args['activity_id'],$activity_visibility_svg );
					if( is_user_logged_in() ){
						$html .= '<div class="activity-extension-links">';
							$html .= '<span class="open-button">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
									<path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
								</svg>
							</span>';
							$html .= '<span class="more-option">'. esc_html__("More Options", "metafans") . '</span>';
							$html .= '<ul>';
								$html .= '<li>
											<a class="button bp-secondary-action bp-tooltip activity-make-favourite" href="">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
												<div>

													<h4>'. esc_html__( 'Save', 'metafans' ).'</h4>
													<p>'. esc_html__( 'Save this post / add to favourite', 'metafans' ) .'</p>
												</div>
											</a>
										</li>';

								$html .= '<li>
									<a class="edite-activity">
										<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21,12a1,1,0,0,0-1,1v6a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h6a1,1,0,0,0,0-2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM6,12.76V17a1,1,0,0,0,1,1h4.24a1,1,0,0,0,.71-.29l6.92-6.93h0L21.71,8a1,1,0,0,0,0-1.42L17.47,2.29a1,1,0,0,0-1.42,0L13.23,5.12h0L6.29,12.05A1,1,0,0,0,6,12.76ZM16.76,4.41l2.83,2.83L18.17,8.66,15.34,5.83ZM8,13.17l5.93-5.93,2.83,2.83L10.83,16H8Z" fill="#1d2327"/></svg>
										<div>
											<h4>'. esc_html__( 'Edit', 'metafans' ) .'</h4>
											<p>'. esc_html__( 'Edit this activity', 'metafans' ) .'</p>
										</div>
									</a>
								</li>';

							
							if ( bp_activity_user_can_delete( $activity ) ) {	
								$html .= '<li>
									<a class="button button-activity-delete" href="" data-id="' . $args['activity_id'] . '" data-action="delete" >
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
										<div>
											<h4>'. esc_html__( 'Delete', 'metafans' ) .'</h4>
											<p>'. esc_html__( 'Move this activity to trash', 'metafans' ) .'</p>
										</div>
									</a>
								</li>';
							}

				        $html .= '</ul>';
						$html .= '</div>';
					}
				$html .= '</div>';
				if( $activity->type === 'new_avatar' ){
						$cover_src = bp_attachments_get_attachment( 'url', array(
							'item_id' => bp_get_activity_user_id()
						) );
				 
						$html .= '<div class="bp-activity-avatar-change">';
				      		$html .= '<img class="image-cover" src="'. $cover_src .'" alt="imgur"/>';
							$html .= bp_get_activity_avatar( array( 'type' => 'full' ) );
						$html .= '</div>';
				}
				if ( $activity->type === 'activity_update' ){
					$html .= '<div class="activity-inner">';
						$html .= '<p>' . html_entity_decode(str_replace("\n","<br>", $activity->content) ) . '</p>';
			 			$html .= $this->activity_media_html( $args['activity_id'] );
					$html .= '</div>';
				}
				$html .= '<div class="activity-footer-links">';
					$html .= $this->get_footer_actions( $args['activity_id'] );
				$html .= '</div>';

			$html .= '</div>';

			if ( ( is_user_logged_in() && ( bp_activity_can_comment() || bp_is_single_activity() ) ) ){

				$html .= '<div class="activity-comments">';

					$html .= $this->get_activity_comments( $args['activity_id'] );

				$html .= '</div>';
			}

		$html .= '</li>';
		return $html;
	}

	public function before_activity_post_form(){
		if( !function_exists('bp_get_user_firstname') ){
			return;
		}
		echo '<p class="what-is-new-avatar-text">' . bp_get_user_firstname( bp_get_loggedin_user_fullname() ) . '</p>';
		?>
			<div class="mf-activity-accessibility-container">
					<select id="mf-activity-accessibility" class="mf-activity-accessibility" name="">
						<option value="public"><?php esc_html_e('Public','tophive'); ?></option>
						<option value="friends"><?php esc_html_e('Friends','tophive'); ?></option>
						<option value="onlyme"><?php esc_html_e('Only me','tophive'); ?></option>
					</select>
				</div>
		<?php
	}

	// Delete activity
	public function metafans_activity_delete(){
		$activity_id = $_POST['activity_id'];
		$action_type = $_POST['action_type'];
		$response = [];

		if( $action_type == 'delete' ){
			if( bp_activity_delete( array( 'id' => $activity_id ) ) ){
				$response['response_type'] = esc_html__( "success", 'metafans' );
				$response['response_msg'] = esc_html__( "The activity deleted successfully", 'metafans' );
			}else{
				$response['response_type'] = esc_html__( "error", 'metafans' );
				$response['response_msg'] = esc_html__( "The activity could not be deleted!", 'metafans' );
			}
		}
		wp_send_json( $response, 200 );
	}

	/**
	***
	*  Shows Shared activity content
	*  
	*  @since 2.1.0
	*  @param $activity_id | Int | Activity id to retrive content
	*  @return String | Returns shared activity content
	*
	**
	*/
	public function shared_activity( $activity_id ){
		
		global $wpdb;
		$activity = $wpdb->get_results("SELECT user_id, content, date_recorded, type from {$wpdb->base_prefix}bp_activity where id={$activity_id}");

		$user_id = $activity[0]->user_id;
		$type = $activity[0]->type;
		$content = $activity[0]->content;
		$date = $activity[0]->date_recorded;

		$last_recorded = strtotime($date[0]->date_recorded);
		$activity_args = array( 
			'since' 		=> $last_recorded,
			'activity_id' 	=> $activity_id,
			'class'			=> 'activity activity_update activity-item date-recorded-'. $last_recorded,
		);

		$html = '<div class="shared-activity '. $args['class'] .'" id="activity-'. $activity_id .'" data-bp-activity-id="'. $args['activity_id'] .'" data-bp-timestamp="'. $args['since'] .'">';

			$html .= '<div class="activity-avatar item-avatar">';

				$html .= '<a href="'. bp_core_get_user_domain( $user_id ) .'">';

					$html .= bp_get_activity_avatar( array( 'type' => 'full', 'user_id' => $user_id ) );

				$html .= '</a>';

			$html .= '</div>';

			$html .= '<div class="activity-content">';

				$html .= '<div class="activity-header">';

					$html .= $this->get_activity_header( $activity_id,'<svg></svg>' );
				$html .= '</div>';
				if( $type === 'new_avatar' ){
						// Get the Cover Image
						$cover_src = bp_attachments_get_attachment( 'url', array(
							'item_id' => bp_get_activity_user_id()
						) );
				 
						$html .= '<div class="bp-activity-avatar-change">';
				      		$html .= '<img class="image-cover" src="'. $cover_src .'" alt="imgur"/>';
							$html .= bp_get_activity_avatar( array( 'type' => 'full' ) );
						$html .= '</div>';
				}
				if ( $type === 'activity_update' ){

					$html .= '<div class="activity-inner">';
						$html .= $content;
			 			$html .= $this->activity_media_html( $activity_id );
					$html .= '</div>';
				}

			$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}

	/**
	***
	*  Retrives activity header content
	*  
	*  @since 1.3.0
	*  @param $activity_id | Int | Activity id to retrive header
	*  @return String | Returns activity header
	*
	**
	*/
	public function get_activity_header( $activity_id, $svg ){
		global $wpdb;
		$activity = $wpdb->get_results("SELECT user_id, action, content, date_recorded, type from {$wpdb->base_prefix}bp_activity where id={$activity_id}");
		$user_id = $activity[0]->user_id;
		$action = $activity[0]->action;
		$date = $activity[0]->date_recorded;

		$activity_permalink = bp_activity_get_permalink( $activity_id );
		$is_edited = bp_activity_get_meta($activity_id,'last_edited',true);
		$edited_text = "";
		if(!empty($is_edited)){
			$edited_text = esc_html__(" (edited)","metafans");
		}
		$time_since = '<span class="time-since">'. $this->helper->get_time_since( $date ) . $edited_text .'<i class="line"></i>' . $svg . '</span>';

		$activity_meta = sprintf( '<a href="%1$s" class="view activity-time-since bp-tooltip" data-bp-tooltip="%2$s">%3$s</a>',
			$activity_permalink,
			esc_attr__( 'View Discussion', 'metafans' ),
			$time_since
		);
		return '<p>'. $action . $activity_meta .'</p>';
	}
	public function activity_header($svg){
		$activity_id = bp_get_activity_id();
		echo $this->get_activity_header( $activity_id, $svg );
	}
	public function activity_search_header($activity_id){
		echo $this->get_activity_header( $activity_id, '<svg></svg>');
	}

	/**
	***
	*  Retrives activity main content [text, image, videos]
	*  
	*  @since 2.3.1
	*  @param $activity_id | Int | Activity id to retrive header
	*  @return String | Returns activity header
	*
	**
	*/
	public function activity_content(){
		global $wpdb;
		$activity_id = bp_get_activity_id();
		$activity = $wpdb->get_results("SELECT content from {$wpdb->base_prefix}bp_activity where id={$activity_id}");
		$content = $activity[0]->content;
		echo $content;
	}



	/**
	***
	*  Echos activity media
	*  
	*  @since 1.1.0
	*  @param $activity_id | Int | Activity id to retrive content
	*  @return String | Returns shared activity content
	*
	**
	*/

	public function activity_media_html( $activity_id ){
		$media = bp_activity_get_meta( $activity_id, 'activity_media', true );

		if(!empty( $media )){

			if( count($media) == 1 ){
				$image_class = 'post-media-single';
			}elseif( count($media) == 2 ){
				$image_class = 'post-media-double';
			}elseif( count($media) == 3 ){
				$image_class = 'post-media-triple';
			}elseif( count($media) == 4 ){
				$image_class = 'post-media-fours';
			}else{
				$image_class = 'post-media-more';
			}
			$media_html = '<div class="post-media '. $image_class .' bp-image-previewer">';
			$i = 1;
			$remaining = count($media) - 4;

				foreach ($media as $media_url) {
					$media_type = $this->helper->get_media_type( $media_url['full'] );
						if( $media_type == 'video' ){
							$media_html .= '<div class="" id="'. $i .'">';
							$media_html .= '<video controls width="100%"><source src="'. $media_url['full'] .'" alt=""></video>';
							$media_html .= '</div>';
						}else if( $media_type == 'image' ){
							$media_html .= '<div class="bp-image-single post-media-single-image-container" id="'. $i .'">';
							$media_html .= '<a class="media-popup-thumbnail" href="'. $media_url['full'] .'" data-id="'. $media_url['id'] .'" data-activity="'. $activity_id .'" >';
							$media_html .= '<img src="'. $media_url['full'] .'"data-attachment-id="'.$media_url['attachment_id'].'" alt="gm" />';
							$media_html .= '</a>';
// 							ob_start();
// 							var_dump($media_url);
// 							$media_html .= ob_get_clean();
							if( $i == 4 && $remaining > 0 ){
								$media_html .= '<span class="media-remaining">+'. $remaining .'</span>';
							}
							$media_html .= '</div>';
						}else if( $media_type == 'document' ){
							$media_filename = basename($media_url['full']);
							$ext = pathinfo($media_filename, PATHINFO_EXTENSION);

							$media_html .= '<div class="bp-document-container" id="'. $i .'">';
							$media_html .= $this->documentsPreviewHTML( $media_filename, $ext, true, $media_url['full'] );
							$media_html .= '<a class="download" href="'. $media_url['full'] .'">';
							$media_html .= '<svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m256 362.667969c-8.832031 0-16-7.167969-16-16v-330.667969c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v330.667969c0 8.832031-7.167969 16-16 16zm0 0"/><path d="m256 362.667969c-4.097656 0-8.191406-1.558594-11.308594-4.695313l-85.332031-85.332031c-6.25-6.25-6.25-16.382813 0-22.636719 6.25-6.25 16.382813-6.25 22.636719 0l74.023437 74.027344 74.027344-74.027344c6.25-6.25 16.386719-6.25 22.636719 0 6.25 6.253906 6.25 16.386719 0 22.636719l-85.335938 85.332031c-3.15625 3.136719-7.25 4.695313-11.347656 4.695313zm0 0"/><path d="m453.332031 512h-394.664062c-32.363281 0-58.667969-26.304688-58.667969-58.667969v-96c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v96c0 14.699219 11.96875 26.667969 26.667969 26.667969h394.664062c14.699219 0 26.667969-11.96875 26.667969-26.667969v-96c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v96c0 32.363281-26.304688 58.667969-58.667969 58.667969zm0 0"/></svg>';
							$media_html .= '</a>';

							$media_html .= '</div>';
							$media_html .= '</div>';
							$media_html .= '</div>';
						}
					$i++;
				}
			$media_html .= '</div>';
		}
		return $media_html;
	}
	public function activity_media(){
	 	$activity_id = bp_get_activity_id();
		$media_html = $this->activity_media_html( $activity_id );
		echo $media_html;
	}
	public function activity_search_media( $activity_id ){
		$media_html = $this->activity_media_html( $activity_id );
		echo $media_html;	
	}
	function th_allowed_mime_types($mime_types){
	    $mime_types['svg'] 	= 'image/svg+xml'; //Adding svg extension
	    $mime_types['psd'] 	= 'image/vnd.adobe.photoshop'; //Adding photoshop files
	    $mime_types['pdf'] 	= 'application/pdf'; //Adding pdf files
	    $mime_types['text'] = 'text/plain'; //Adding photoshop files
	    $mime_types['css'] 	= 'text/css'; //Adding photoshop files
	    return $mime_types;
	}

	/* 
	** Activity Media Uploader | Produces Ajax Response
	*/
	public function activity_media_upload(){
	    $usingUploader = 2;
	    $fileErrors = array(
	        0 => "There is no error, the file uploaded with success",
	        1 => "The uploaded file exceeds the upload_max_files in server settings",
	        2 => "The uploaded file exceeds the MAX_FILE_SIZE from html form",
	        3 => "The uploaded file uploaded only partially",
	        4 => "No file was uploaded",
	        6 => "Missing a temporary folder",
	        7 => "Failed to write file to disk",
	        8 => "A PHP extension stoped file to upload" 
	    );
	    $posted_data =  isset( $_POST ) ? $_POST : array();
	    $file_data = isset( $_FILES ) ? $_FILES : array();
	    $data = array_merge( $posted_data, $file_data );
	    $response = array();
	    if( $usingUploader == 1 ) {
	        $uploaded_file = wp_handle_upload( $data['upload_file'], array( 'test_form' => false ) );
	        if( $uploaded_file && ! isset( $uploaded_file['error'] ) ) {
	            $response['response'] = "SUCCESS";
	            $response['filename'] = basename( $uploaded_file['url'] );
	            $response['url'] = $uploaded_file['url'];
	            $response['id'] = $uploaded_file['id'];
	            $response['type'] = $uploaded_file['type'];
	            $response['html'] = $this->get_media_upload_thumb_html( $uploaded_file['url'] );
				if( isset($data['file_uniqId']) ){
					$response['file_uniqId']  = $data['file_uniqId'];
				}
	        } else {
	            $response['response'] = "ERROR";
	            $response['error'] = $uploaded_file['error'];
	        }
	    } elseif ( $usingUploader == 2) {
	        $attachment_id = media_handle_upload( 'upload_file', 0 );
	        
	        if ( is_wp_error( $attachment_id ) ) { 
	            $response['response'] = "ERROR";
	            $response['error'] = $fileErrors[ $data['upload_file']['error'] ];
	        } else {
	            $fullsize_path = get_attached_file( $attachment_id );
	            $pathinfo = pathinfo( $fullsize_path );
	            $url = wp_get_attachment_url( $attachment_id );
	            $response['response'] = "SUCCESS";
	            $response['filename'] = $pathinfo['filename'];
	            $response['id'] = $attachment_id;
	            $response['url'] = $url;
	            $response['html'] = $this->get_media_upload_thumb_html( $url );
	            $type = $pathinfo['extension'];
	            if( $type == "jpeg"
	            || $type == "jpg"
	            || $type == "png"
	            || $type == "gif" ) {
	                $type = "image/" . $type;
	            }
	            $response['type'] = $type;
	        }
	    }
	    $response['mimetype'] = $file_data['upload_file']['type'];
	    $response['icontag'] = '<img src="'. $response['url'] .'" />';
		if( isset($data['file_uniqId']) ){
			$response['file_uniqId']  = $data['file_uniqId'];
		}

	    echo json_encode( $response );
	    die();
	}

	/*
	** AJAX || Get media author
	*/
	public function media_author(){
		$media_id = $_POST['media_id'];
		$activity_id = $_POST['activity_id'];

		$images = bp_activity_get_meta( $activity_id, 'activity_media', false )[0];

		$key = $this->helper->searchArray( $media_id, $images );

		$author_id = $images[$key]['author'];
		$post_time = $images[$key]['timestamp'];

		$author = '';
		$author .= '<div class="media_author">';
			$author .= '<div class="media_author_img">';
			$author .= get_avatar( $author_id, 40, '', 'media_author', null );
			$author .= '</div>';
			$author .= '<div class="media_author_data">';
			$author .= '<span>' . get_the_author_meta( 'display_name', $author_id ) . '</span>';
			$author .= '<span>' . $this->helper->get_time_since( '@' . $post_time ) . '</span>';
			$author .= '</div>';
		$author .= '</div>';

		wp_send_json( $author, 200 );
	}

	/*
	** Generate media thumbnail after activity image upload
	*  
	*/
	public function get_media_upload_thumb_html( $url ){
		$media_type = $this->helper->get_media_type( $url );
		if( $media_type == 'video' ){
			return '<video src="'. $url .'" />';
		}elseif( $media_type == 'image' ){
			return '<img src="'. $url .'" />';
		}elseif( $media_type == 'document' ){
			$media_filename = basename($url);
			$ext = pathinfo($media_filename, PATHINFO_EXTENSION);
			return  $this->documentsPreviewHTML( $media_filename, $ext );
		}
	}

	private function documentsPreviewHTML( $filename, $filetype, $filemeta = false, $url = '' ){
		if( !empty($url) ){
			$path = str_replace( site_url('/'), ABSPATH, esc_url( $url) );
			if ( is_file( $path ) ){
			    $filesize = ' - ' . size_format( filesize( $path ) ); 
			}
		}else{
			$filesize = '';
		}
		if( $filemeta ){
			$filemetadata = '<br><span class="filemetadata">'. $filetype . $filesize .'</span>'; 
		}else{
			$filemetadata = '';
		}
		switch ($filetype) {
			case 'pdf':
				$pdficon = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
				<path style="fill:#E2E5E7;" d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z"/>
				<path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z"/>
				<polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 "/>
				<path style="fill:#F15642;" d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16
					V416z"/>
				<g>
					<path style="fill:#FFFFFF;" d="M101.744,303.152c0-4.224,3.328-8.832,8.688-8.832h29.552c16.64,0,31.616,11.136,31.616,32.48
						c0,20.224-14.976,31.488-31.616,31.488h-21.36v16.896c0,5.632-3.584,8.816-8.192,8.816c-4.224,0-8.688-3.184-8.688-8.816V303.152z
						 M118.624,310.432v31.872h21.36c8.576,0,15.36-7.568,15.36-15.504c0-8.944-6.784-16.368-15.36-16.368H118.624z"/>
					<path style="fill:#FFFFFF;" d="M196.656,384c-4.224,0-8.832-2.304-8.832-7.92v-72.672c0-4.592,4.608-7.936,8.832-7.936h29.296
						c58.464,0,57.184,88.528,1.152,88.528H196.656z M204.72,311.088V368.4h21.232c34.544,0,36.08-57.312,0-57.312H204.72z"/>
					<path style="fill:#FFFFFF;" d="M303.872,312.112v20.336h32.624c4.608,0,9.216,4.608,9.216,9.072c0,4.224-4.608,7.68-9.216,7.68
						h-32.624v26.864c0,4.48-3.184,7.92-7.664,7.92c-5.632,0-9.072-3.44-9.072-7.92v-72.672c0-4.592,3.456-7.936,9.072-7.936h44.912
						c5.632,0,8.96,3.344,8.96,7.936c0,4.096-3.328,8.704-8.96,8.704h-37.248V312.112z"/>
				</g>
				<path style="fill:#CAD1D8;" d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z"/>
				</svg>';
				return '<div class="document-preview-wrapper">'. $pdficon . '<p class="filedata">' . $filename . $filemetadata .'</p><div>';
				break;
			case 'docs':
				$docsicon = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
				<path style="fill:#E2E5E7;" d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z"/>
				<path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z"/>
				<polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 "/>
				<path style="fill:#50BEE8;" d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16
					V416z"/>
				<g>
					<path style="fill:#FFFFFF;" d="M92.576,384c-4.224,0-8.832-2.32-8.832-7.936v-72.656c0-4.608,4.608-7.936,8.832-7.936h29.296
						c58.464,0,57.168,88.528,1.136,88.528H92.576z M100.64,311.072v57.312h21.232c34.544,0,36.064-57.312,0-57.312H100.64z"/>
					<path style="fill:#FFFFFF;" d="M228,385.28c-23.664,1.024-48.24-14.72-48.24-46.064c0-31.472,24.56-46.944,48.24-46.944
						c22.384,1.136,45.792,16.624,45.792,46.944C273.792,369.552,250.384,385.28,228,385.28z M226.592,308.912
						c-14.336,0-29.936,10.112-29.936,30.32c0,20.096,15.616,30.336,29.936,30.336c14.72,0,30.448-10.24,30.448-30.336
						C257.04,319.008,241.312,308.912,226.592,308.912z"/>
					<path style="fill:#FFFFFF;" d="M288.848,339.088c0-24.688,15.488-45.92,44.912-45.92c11.136,0,19.968,3.328,29.296,11.392
						c3.456,3.184,3.84,8.816,0.384,12.4c-3.456,3.056-8.704,2.688-11.776-0.384c-5.232-5.504-10.608-7.024-17.904-7.024
						c-19.696,0-29.152,13.952-29.152,29.552c0,15.872,9.328,30.448,29.152,30.448c7.296,0,14.08-2.96,19.968-8.192
						c3.952-3.072,9.456-1.552,11.76,1.536c2.048,2.816,3.056,7.552-1.408,12.016c-8.96,8.336-19.696,10-30.336,10
						C302.8,384.912,288.848,363.776,288.848,339.088z"/>
				</g>
				<path style="fill:#CAD1D8;" d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z"/>
				</svg>';
				return '<div class="document-preview-wrapper">'. $docsicon . '<p class="filedata">' . $filename . $filemetadata .'</p><div>';
				break;
			case 'docx':
				$docsicon = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
				<path style="fill:#E2E5E7;" d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z"/>
				<path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z"/>
				<polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 "/>
				<path style="fill:#50BEE8;" d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16
					V416z"/>
				<g>
					<path style="fill:#FFFFFF;" d="M92.576,384c-4.224,0-8.832-2.32-8.832-7.936v-72.656c0-4.608,4.608-7.936,8.832-7.936h29.296
						c58.464,0,57.168,88.528,1.136,88.528H92.576z M100.64,311.072v57.312h21.232c34.544,0,36.064-57.312,0-57.312H100.64z"/>
					<path style="fill:#FFFFFF;" d="M228,385.28c-23.664,1.024-48.24-14.72-48.24-46.064c0-31.472,24.56-46.944,48.24-46.944
						c22.384,1.136,45.792,16.624,45.792,46.944C273.792,369.552,250.384,385.28,228,385.28z M226.592,308.912
						c-14.336,0-29.936,10.112-29.936,30.32c0,20.096,15.616,30.336,29.936,30.336c14.72,0,30.448-10.24,30.448-30.336
						C257.04,319.008,241.312,308.912,226.592,308.912z"/>
					<path style="fill:#FFFFFF;" d="M288.848,339.088c0-24.688,15.488-45.92,44.912-45.92c11.136,0,19.968,3.328,29.296,11.392
						c3.456,3.184,3.84,8.816,0.384,12.4c-3.456,3.056-8.704,2.688-11.776-0.384c-5.232-5.504-10.608-7.024-17.904-7.024
						c-19.696,0-29.152,13.952-29.152,29.552c0,15.872,9.328,30.448,29.152,30.448c7.296,0,14.08-2.96,19.968-8.192
						c3.952-3.072,9.456-1.552,11.76,1.536c2.048,2.816,3.056,7.552-1.408,12.016c-8.96,8.336-19.696,10-30.336,10
						C302.8,384.912,288.848,363.776,288.848,339.088z"/>
				</g>
				<path style="fill:#CAD1D8;" d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z"/>
				</svg>';
				return '<div class="document-preview-wrapper">'. $docsicon . '<p class="filedata">' . $filename . $filemetadata .'</p><div>';
				break;
			case 'text':
				$icon = '<svg id="Layer_1" enable-background="new 0 0 512.025 512.025" height="512" viewBox="0 0 512.025 512.025" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m448.009 104.025v368c0 22.06-17.94 40-40 40h-304c-22.06 0-40-17.94-40-40v-432c0-22.06 17.94-40 40-40h240c2.12 0 4.16.84 5.66 2.34l96 96c1.5 1.5 2.34 3.54 2.34 5.66z" fill="#edebfd"/><path d="m448.009 104.025v368c0 22.06-17.94 40-40 40h-40c22.06 0 40-17.94 40-40v-368c0-2.12-.84-4.16-2.34-5.66l-69.66-69.66v-20.68c0-5.792 5.973-9.513 10.9-7.45 2.325.897-4.513-5.483 98.76 97.79 1.396 1.396 2.34 3.406 2.34 5.66z" fill="#d2d2fc"/><path d="m440.009 112.025h-96c-4.42 0-8-3.58-8-8v-96c0-7.093 8.606-10.692 13.66-5.66l96 96c5.024 5.046 1.443 13.66-5.66 13.66z" fill="#7acef9"/><path d="m445.669 98.365-96-96c-5.047-5.024-13.66-1.443-13.66 5.66v20.68l69.66 69.66c5.024 5.046 1.443 13.66-5.66 13.66h40c7.093 0 10.691-8.606 5.66-13.66z" fill="#6cb9e7"/><g fill="#7acef9"><path d="m377.009 208.025h-240c-4.418 0-8 3.582-8 8s3.582 8 8 8h240c4.418 0 8-3.582 8-8s-3.582-8-8-8z"/><path d="m137.009 160.025h240c4.418 0 8-3.582 8-8s-3.582-8-8-8h-240c-4.418 0-8 3.582-8 8s3.581 8 8 8z"/><path d="m377.009 272.025h-240c-4.418 0-8 3.582-8 8s3.582 8 8 8h240c4.418 0 8-3.582 8-8s-3.582-8-8-8z"/><path d="m377.009 336.025h-240c-4.418 0-8 3.582-8 8s3.582 8 8 8h240c4.418 0 8-3.582 8-8s-3.582-8-8-8z"/><path d="m313.009 400.025h-176c-4.418 0-8 3.582-8 8s3.582 8 8 8h176c4.418 0 8-3.582 8-8s-3.582-8-8-8z"/></g></g></svg>';
				return '<div class="document-preview-wrapper">'. $icon . '<p class="filedata">' . $filename . $filemetadata .'</p><div>';
				break;
			case 'psd':
				$icon = '<svg id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m460.04 112.07v347.84c0 28.72-23.37 52.09-52.1 52.09h-303.88c-28.73 0-52.1-23.37-52.1-52.09v-407.82c0-28.72 23.37-52.09 52.1-52.09h243.91z" fill="#f6f6f6"/><path d="m460.04 112.07v347.84c0 28.72-23.37 52.09-52.1 52.09h-152.83v-512h92.86z" fill="#efefef"/><path d="m460.039 97.07v15h-97.07c-8.28 0-15-6.72-15-15v-97.07h15c3.98 0 7.8 1.58 10.61 4.39l82.07 82.07c2.809 2.81 4.39 6.63 4.39 10.61z" fill="#58adf9"/><path d="m512 252.89v168.22c0 8.29-6.72 15-15 15h-482c-8.28 0-15-6.71-15-15v-168.22c0-8.29 6.72-15 15-15h482c8.28 0 15 6.71 15 15z" fill="#71e1ff"/><path d="m512 252.89v168.22c0 8.29-6.72 15-15 15h-241.89v-198.22h241.89c8.28 0 15 6.71 15 15z" fill="#58adf9"/><g><path d="m180.462 279.274h-49.157c-8.284 0-15 6.716-15 15v85.451c0 8.284 6.716 15 15 15s15-6.716 15-15v-21.294h34.157c8.284 0 15-6.716 15-15v-49.157c0-8.284-6.715-15-15-15zm-15 49.158h-19.157v-19.157h19.157z" fill="#fff"/><path d="m294.69 337v42.73c0 8.28-6.71 15-15 15h-49.15c-8.29 0-15-6.72-15-15 0-8.29 6.71-15 15-15h34.15v-12.73h-34.15c-8.29 0-15-6.72-15-15v-42.73c0-8.28 6.71-15 15-15h49.15c8.29 0 15 6.72 15 15 0 8.29-6.71 15-15 15h-34.15v12.73h34.15c8.29 0 15 6.72 15 15z" fill="#fff"/><path d="m362.062 279.274h-30.525c-8.284 0-15 6.716-15 15v85.451c0 8.284 6.716 15 15 15h30.525c18.545 0 33.632-15.087 33.632-33.632v-48.187c-.001-18.544-15.088-33.632-33.632-33.632zm3.631 81.819c0 2.003-1.629 3.632-3.632 3.632h-15.525v-55.451h15.525c2.003 0 3.632 1.629 3.632 3.632z" fill="#d7ffff"/></g><g fill="#d7ffff"><path d="m279.69 309.27h-24.58v-30h24.58c8.29 0 15 6.72 15 15 0 8.29-6.71 15-15 15z"/><path d="m294.69 337v42.73c0 8.28-6.71 15-15 15h-24.58v-30h9.58v-12.73h-9.58v-30h24.58c8.29 0 15 6.72 15 15z"/></g></g></svg>';
				return '<div class="document-preview-wrapper">'. $icon . '<p class="filedata">' . $filename . $filemetadata .'</p><div>';
				break;
			case 'css':
				$icon = '<svg viewBox="-31 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m420 120v76c0 8.398438-6.597656 15-15 15h-360c-8.402344 0-15-6.601562-15-15v-181c0-8.402344 6.597656-15 15-15h255zm0 0" fill="#ececf1"/><path d="m420 120v76c0 8.398438-6.597656 15-15 15h-180v-211h75zm0 0" fill="#e2e2e7"/><path d="m420 436v61c0 8.398438-6.597656 15-15 15h-360c-8.402344 0-15-6.601562-15-15v-61c0-8.402344 6.597656-15 15-15h360c8.402344 0 15 6.597656 15 15zm0 0" fill="#ececf1"/><path d="m420 436v61c0 8.398438-6.597656 15-15 15h-180v-91h180c8.402344 0 15 6.597656 15 15zm0 0" fill="#e2e2e7"/><path d="m415.585938 94.375-89.960938-89.960938c-2.691406-2.699218-7.925781-4.414062-10.625-4.414062h-15v105c0 8.285156 6.714844 15 15 15h105v-15c0-2.683594-1.707031-7.925781-4.414062-10.625zm0 0" fill="#babac0"/><path d="m405 181h-360c-24.902344 0-45 20.097656-45 45v180c0 24.898438 20.097656 45 45 45h360c24.902344 0 45-20.101562 45-45v-180c0-24.902344-20.097656-45-45-45zm0 0" fill="#ff7816"/><path d="m450 226v180c0 24.898438-20.097656 45-45 45h-180v-270h180c24.902344 0 45 20.097656 45 45zm0 0" fill="#ff4b00"/><path d="m105 391c-24.8125 0-45-20.1875-45-45v-60c0-24.8125 20.1875-45 45-45s45 20.1875 45 45c0 8.289062-6.710938 15-15 15s-15-6.710938-15-15c0-8.277344-6.722656-15-15-15s-15 6.722656-15 15v60c0 8.277344 6.722656 15 15 15s15-6.722656 15-15c0-8.289062 6.710938-15 15-15s15 6.710938 15 15c0 24.8125-20.1875 45-45 45zm0 0" fill="#ececf1"/><path d="m270 346c0 24.898438-20.097656 45-45 45s-45-20.101562-45-45c0-8.402344 6.597656-15 15-15s15 6.597656 15 15c0 8.398438 6.597656 15 15 15s15-6.601562 15-15c0-8.402344-6.597656-15-15-15-24.902344 0-45-20.101562-45-45 0-24.902344 20.097656-45 45-45s45 20.097656 45 45c0 8.398438-6.597656 15-15 15s-15-6.601562-15-15c0-8.402344-6.597656-15-15-15s-15 6.597656-15 15c0 8.398438 6.597656 15 15 15 24.902344 0 45 20.097656 45 45zm0 0" fill="#ececf1"/><g fill="#e2e2e7"><path d="m345 391c-24.8125 0-45-20.1875-45-45 0-8.289062 6.710938-15 15-15s15 6.710938 15 15c0 8.277344 6.722656 15 15 15s15-6.722656 15-15-6.722656-15-15-15c-24.8125 0-45-20.1875-45-45s20.1875-45 45-45 45 20.1875 45 45c0 8.289062-6.710938 15-15 15s-15-6.710938-15-15c0-8.277344-6.722656-15-15-15s-15 6.722656-15 15 6.722656 15 15 15c24.8125 0 45 20.1875 45 45s-20.1875 45-45 45zm0 0"/><path d="m270 346c0 24.898438-20.097656 45-45 45v-30c8.402344 0 15-6.601562 15-15 0-8.402344-6.597656-15-15-15v-30c24.902344 0 45 20.097656 45 45zm0 0"/><path d="m225 271v-30c24.902344 0 45 20.097656 45 45 0 8.398438-6.597656 15-15 15s-15-6.601562-15-15c0-8.402344-6.597656-15-15-15zm0 0"/></g></svg>';
				return '<div class="document-preview-wrapper">'. $icon . '<p class="filedata">' . $filename . $filemetadata .'</p><div>';
				break;
			
			default:
				// code...
				break;
		}
	} 

	/**
	** Remove a media
	*/
	public function activity_remove_media(){
		$media_id = $_POST['att_id'];
		$media_deleted = wp_delete_attachment( $media_id, true );
		wp_send_json( $media_deleted );
	}


	/**
	***
	*  Get activity comments. This section includes activity comments CRUD functions along with 
	*  comments forms and html format of the comments
	*  
	*  @since 1.1.0
	*
	**
	*/

	// Get activity comments for BP activity template
	public function activity_comments(){
		$id = bp_get_activity_id();
		echo $this->get_activity_comments( $id );
	}
	public function activity_search_comments( $id ){
		echo $this->get_activity_comments( $id );
	}
	// Get activity comments ( Comments list + Comments form ) by activity ID
	public function get_activity_comments( $activity_id ){
		return $this->get_activity_comment_form( $activity_id ) . $this->get_comments_html( $activity_id );
	}
	// Get activity comment form | activity_id, type, $comment_id
	public function get_activity_comment_form($id, $type = 'postComment', $comment_id = ''){
		if( is_user_logged_in() && bp_activity_can_comment() ){
			$html = '<div class="activity-comments-form">';
			$html .= get_avatar( get_current_user_id(), 30 );
			$html .= '<form class="tophive-bp-comment-form activity-'. $id .'" data-type="'. $type .'" data-comment-id="'. $comment_id .'"  data-activity-id="'. $id .'">';
			// $html .= '<textarea row="2" class="comments-text" placeholder="'. esc_html__( 'Type a comments...', 'metafans' ) .'"></textarea>';
			$html .= '<div class="comments-text editable-div"
				  contenteditable data-placeholder="'. esc_html__('Type a comment...', 'metafans') .'"
				></div>';
			$html .= '<div class="comments-media-icons">';
			$html .= '<p class="comments-image-uploader">
					<label for="comment-upload-media-'. $id .'">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#999999" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M20.4 14.5L16 10 4 20"/></svg>
					</label>
					<input type="file" name="comment-upload-media" data-id="'. $id .'" class="comment-upload-media" id="comment-upload-media-'. $id .'">
			</p>';
			// $html .= '<p class="comments-emojipicker">
			// 	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
			// </p>';
			$html .= '</div>';
			$html .= '<div>
				<input type="hidden" class="comment-media-url" id="comment-media-url-'. $id .'" value="" />
			</div>';
			// $html .= '<button type="submit" class="comment-submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
			//   <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
			// </svg></button>';
			$html .= '</form>';
			$html .= '</div>';
			$html .= '<div class="comments-media-previewer comments-media-preview-'. $id .'"></div>';
			return $html;
		}else{
			return false;
		}
	}

	// Get activity Comments lists
	public function get_comments_html( $activity_id, $show = 1 ){
		$comments = bp_activity_get_meta( $activity_id, 'tophive_activity_comments', true );
		if( !is_user_logged_in() ){
			return;
		}
		if( empty($comments) ){
			return;
		}
		$comments = array_reverse($comments);
		$i = 0;
		$html = '';
		$html .= '<ul id="main-comments-container-'. $activity_id .'">';
		foreach ($comments as $comment) {
			if( $i < $show ){
				$html .= '<li data-id="'. $comment['ID'] .'">';
					$html .= '<span class="comment-avatar">'. get_avatar( $comment['author'], 30 ) .'</span>';
					$html .= '<span class="comment-content">';
					$html .= '<span class="comment-meta">';
					$html .= '<a href="'. bp_core_get_user_domain($comment['author']) .'">'. get_the_author_meta( 'display_name', $comment['author'] ) .'</a>';
					$html .= '<span class="comment-date">'. $this->helper->get_time_since( '@' . $comment['time'] ) .'</span>';
					$html .= '</span>';
					// Comment Content
					$html .= '<p>' . $comment['content'] . '</p>';
					$html .= '</span>';
					// Comments options
					// if( current_user_can( 'manage_options' ) || get_current_user_id() == $comment['author'] ){
					// 	$html .= '<span class="comment-options">';
					// 	$html .= '<span class="comment-options-toggle">···</span>';
					// 	$html .= '<ul>';
					// 		$html .= '<li><a href="#" data-activity-id="'. $activity_id .'" data-reply-id="" data-comment-id="'. $comment['ID'] .'">'. esc_html__( 'Delete comment', 'metafans' ) .'</a></li>';
					// 		//$html .= '<li><a href="#" data-activity-id="'. $activity_id .'" data-reply-id="" data-comment-id="'. $comment['ID'] .'">'. esc_html__( 'Edit comment', 'metafans' ) . '</a></li>';
					// 	$html .= '</ul>';
					// 	$html .= '</span>';
					// }
					// Comment meta actions - reply and reaction button
					$html .= '<span class="comment-meta-actions">';
					$html .= '<a class="comment-reply-form-toggle" href="#comment-reply-form-'. $comment['ID'] .'">'. esc_html__( 'Reply', 'metafans' ) .'</a>';
					if( current_user_can( 'manage_options' ) || get_current_user_id() == $comment['author'] ){
						$html .= '<a class="comment-delete" href="#" data-activity-id="'. $activity_id .'" data-reply-id="" data-comment-id="'. $comment['ID'] .'">'. esc_html__( 'Delete', 'metafans' ) .'</a>';
					}
					$html .= '</span>';
					// Comment replies
					if( !empty($comment['replies']) ){
						$i = 0;
						$html .= '<span class="comment-replies">';
						$html .= '<ul>';
							foreach ($comment['replies'] as $reply) {
								// if( $i < $show ){
								$html .= '<li data-id="'. $comment['ID'] .'">';
									$html .= '<span class="comment-avatar">'. get_avatar( $reply['reply_author'], 30 ) .'</span>';
									$html .= '<span class="comment-content">';
									$html .= '<span class="comment-meta">';
									$html .= '<a href="'. bp_core_get_user_domain($reply['reply_author']) .'">'. get_the_author_meta( 'display_name', $reply['reply_author'] ) .'</a>';
									$html .= '<span class="comment-date">'. $this->helper->get_time_since( '@' . $reply['reply_time'] ) .'</span>';
									$html .= '</span>';
									// Comment Content
									$html .= '<p>' . $reply['reply_content'] . '</p>';
									$html .= '</span>';
									// Comments options
									// if( current_user_can( 'manage_options' ) || get_current_user_id() == $comment['author'] ){
									// 	$html .= '<span class="comment-options">';
									// 	$html .= '<span class="comment-options-toggle">···</span>';
									// 	$html .= '<ul>';
											// $html .= '<li><a href="#" data-activity-id="'. $activity_id .'" data-reply-id="'. $i .'" data-comment-id="'. $comment['ID'] .'">'. esc_html__( 'Delete comment', 'metafans' ) .'</a></li>';
									// 		//$html .= '<li><a href="#" data-activity-id="'. $activity_id .'" data-reply-id="'. $i .'" data-comment-id="'. $comment['ID'] .'">'. esc_html__( 'Edit comment', 'metafans' ) . '</a></li>';
									// 	$html .= '</ul>';
									// 	$html .= '</span>';
									// }
									// Comment meta actions - reply and reaction button
									$html .= '<span class="comment-meta-actions">';
									$html .= '<a class="comment-reply-form-toggle" href="#comment-reply-form-'. $comment['ID'] .'">'. esc_html__( 'Reply', 'metafans' ) .'</a>';
									if( current_user_can( 'manage_options' ) || get_current_user_id() == $comment['author'] ){
											$html .= '<a class="comment-delete" href="#" data-activity-id="'. $activity_id .'" data-reply-id="'. $i .'" data-comment-id="'. $comment['ID'] .'">'. esc_html__( 'Delete', 'metafans' ) .'</a>';
										}
									$html .= '</span>';
									
								$html .= '</li>';
								// }
								$i++;
							}
						$html .= '</ul>';
						$html .= '</span>';
					}
					// Comment reply form
					$html .= '<span class="comment-reply comment-reply-form-'. $comment['ID'] .'" id="comment-reply-form-'. $comment['ID'] .'">';
					$html .= $this->get_activity_comment_form( $activity_id, 'postCommentReply', $comment['ID'] );
					$html .= '</span>';
				$html .= '</li>';
			}
			$i++;
		}
		$html .= '</ul>';
		if( count($comments) > $show ){
			$to_show = (int)$show + 3;
			$html .= '<a class="show-more-comments" href="#" data-activity-id="'. $activity_id .'" data-show="'. $to_show .'">' . esc_html__( 'Show more comments', 'metafans' ) . '</a>';
		}
		return $html;
	}

	// Get activity comments count with string | String
	public function comments_count_html($id){
		$comments_count = $this->get_comments_count($id);
		if( !is_user_logged_in() ){
			if( $comments_count > 0 ){
				return '<span>'. $comments_count['total'] . esc_html__( ' Comments', 'metafans' ) . '</span>';
			}else{
				return '';
			}
		}
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-fill" viewBox="0 0 16 16">
			  <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15z"/>
			</svg>';
		if( $comments_count > 0 ){
			return '<a href="#main-comments-container-'. $id .'" class="activity-comments-toggle">' . $icon . $comments_count['total'] . esc_html__( ' Comments', 'metafans' ) . '</a>';
		}else{
			return '<a href="" class=""></a>';
		}
	}
	// Get activity comments count without string | int
	public function get_comments_count( $activity_id ){
		$count = [];
		$replies_count = 0;
		$comments = bp_activity_get_meta( $activity_id, 'tophive_activity_comments', true );
		if( !empty($comments) ){
			$count['main_comments'] = count($comments);
			foreach ($comments as $comment) {
				if( !empty($comment['replies']) ){
					$replies_count += count($comment['replies']);
				}
			}
			$count['replies'] = $replies_count;
			$count['total'] = $count['main_comments'] + $count['replies'];
			return $count;
		}else{
			return 0;
		}
	}
	// Add A Comment
	public function add_comment(){
		if( !is_user_logged_in() ){
			return;
		}
		$activity_id = $_POST['activity_id'];
		$text = $_POST['comment_text'];
		$text = $this->helper->convert_hashtag( $text );
		$type = $_POST['type'];
		$comment_id = $_POST['comment_id'];
		if( $type === 'postComment' ){
			$response['html'] = $this->post_comment( $activity_id, $text, $type );
			$response['count'] = $this->comments_count_html( $activity_id );
		}elseif( $type === 'postCommentReply' && !empty($comment_id) ){
			$response['html'] = $this->post_comment_reply( $activity_id, $text, $comment_id );
			$response['count'] = $this->comments_count_html( $activity_id );
		}
		wp_send_json( $response, 200 );
	}
	// Check if an activity has comment
	public function has_comments( $activity_id ){
		$comments = bp_activity_get_meta( $activity_id, 'tophive_activity_comments', true );
		if( !empty($comments) ){
			return true;
		}else{
			return false;
		}
	}
	// Post A comment
	public function post_comment( $activity_id, $text ){
		$current_comments = [];
		if( $this->has_comments( $activity_id ) ){
			$current_comments = $this->get_comments( $activity_id );
		}
		$newComment = $this->helper->activity_comment_format();
		$newComment['content'] = $text;
		$current_comments[] = $newComment;

		$comment_id = bp_activity_update_meta( $activity_id, 'tophive_activity_comments', $current_comments );
		if( function_exists('bp_notifications_add_notification') ){
			if( $this->helper->get_author_id_from_activity_id($activity_id) !== get_current_user_id() ){
				bp_notifications_add_notification( array(
					'user_id'           => $this->helper->get_author_id_from_activity_id($activity_id),
					'item_id'           => $activity_id,
					'secondary_item_id' => get_current_user_id(),
					'component_name'    => 'activity',
					'component_action'  => 'update_reply',
					'date_notified'     => bp_core_current_time(),
					'is_new'            => 1,
				) );
			}
		}
		if( $comment_id ){
			return $this->get_activity_comments( $activity_id );
		}
	}
	// Post a comment reply
	public function post_comment_reply( $activity_id, $text, $comment_id ){
		
		$current_comments = $this->get_comments( $activity_id );
		$key = $this->helper->searchArray( $comment_id, $current_comments );
		$comment_reply = $this->helper->comment_reply_format();
		$comment_reply['reply_content'] = $text;
		$current_comments[$key]['replies'][] = $comment_reply;

		$comment_id = bp_activity_update_meta( $activity_id, 'tophive_activity_comments', $current_comments );
		if( function_exists('bp_notifications_add_notification') ){
			if( $this->helper->get_author_id_from_activity_id($activity_id) !== get_current_user_id() ){
				bp_notifications_add_notification( array(
					'user_id'           => $this->helper->get_author_id_from_activity_id($activity_id),
					'item_id'           => $activity_id,
					'secondary_item_id' => get_current_user_id(),
					'component_name'    => 'activity',
					'component_action'  => 'comment_reply',
					'date_notified'     => bp_core_current_time(),
					'is_new'            => 1,
				) );
			}
		}
		if( $comment_id ){
			return $this->get_activity_comments( $activity_id );
		}
	}
	// Delete comment ajax
	public function delete_comment(){
		if( !is_user_logged_in() ){
			return;
		}
		$activity_id = $_POST['activity_id'];
		$comment_id = $_POST['comment_id'];
		$reply_id = $_POST['reply_id'];
		$new_comments = $this->delete_comment_func( $activity_id, $comment_id, $reply_id );
		$this->update_comments( $activity_id, $new_comments );
		
		$response['html'] = $this->get_activity_comments( $activity_id );
		$response['count'] = $this->comments_count_html( $activity_id );
		wp_send_json( $response, 200 );
	}
	// Delete a comment
	public function delete_comment_func( $activity_id, $comment_id, $reply_id ){	
		$comments = $this->get_comments($activity_id);
		if( $reply_id == '' ){
			$search_comment = $this->helper->searchArray( $comment_id, $comments );
			unset($comments[$search_comment]);
		}else{
			$search_comment = $this->helper->searchArray( $comment_id, $comments );
			unset($comments[$search_comment]['replies'][$reply_id]);
		}
		return $comments;
	}

	// Get comments
	public function get_comments( $activity_id ){
		return bp_activity_get_meta( $activity_id, 'tophive_activity_comments', true );
	}
	// Update a comment
	public function update_comments( $activity_id, $new_comments ){
		return bp_activity_update_meta( $activity_id, 'tophive_activity_comments', $new_comments );
	}

	/***
	 ** Buddypress Activity Reactions
	 *  package: Metafans
	 *  since: v1.0.0
	 ** function : Ajax response to post an activity reaction
	 *  returns : Activity reactions html with count
	 *
	*/

	public function tophive_bp_activity_reaction(){
		if( !is_user_logged_in() ){
			return;
		}
		$activity_id = $_POST['activity_id'];
		$type = $_POST['reaction_type'];

		$response = $this->post_activity_reactions_html( $activity_id, $type, get_current_user_id() );

		wp_send_json( $response, 200 );
	}

		/***
	 ** Buddypress Activity All Reactions
	 *  package: Metafans
	 *  since: v1.0.0
	 ** function : Ajax response to all reactions to show in popup
	 *
	*/
	function tophive_bp_activity_all_reaction(){
		$activity_id = $_POST['activity_id'];
		$reactions = $this->get_acitivity_reactions( $activity_id );
		$html = '<ul class="reaction_tabs">';
			foreach ($reactions as $key => $value) {
				if( $value['count'] > 0 ){
					$html .= '<li><a href="#'. $key .'">'. $this->helper->get_reaction_img_url( $key ) . $value['count'] . '</a></li>';
				}
			}
		$html .= '</ul>';
		$html .= '<div class="reaction_container">';
			foreach ($reactions as $key => $value) {
				if( $value['count'] > 0 ){
					$html .= '<div class="single-reactions" id="'. $key .'">';
					if( is_array($value['users']) ){
						foreach ($value['users'] as $user_id) {
							$html .= '<div class="single-reactions-user">';
								$html .= '<span class="single-reaction-avatar">' . get_avatar( $user_id, 36 ) . '</span>';
								$html .= '<span class="given-reaction">' . $this->helper->get_reaction_img_url( $key ) . '</span>';
								$html .= '<a href="'. bp_core_get_user_domain( $user_id ) .'">' . get_the_author_meta( 'display_name', $user_id ) . '</a>';
							$html .= '</div>';
						}
					}
					$html .= '</div>';
				}
			}
		$html .= '</div>';
		wp_send_json( $html );
	}

	// Activity Reactions | Get reactions metadata
	
	function get_acitivity_reactions( $activity_id ){
		return bp_activity_get_meta( $activity_id, 'tophive_activity_reactions', true );
	}

	// Activity Reactions | Ajax response to all reactions to show below activity text or image

	public function get_activity_reaction_count( $activity_id ){
		$reactions = $this->get_acitivity_reactions( $activity_id );
		if(empty($reactions)){
			return;
		}
		$user_id = get_current_user_id();
		$count = 0;
		foreach ( $reactions as $key => $value ) {
			if( is_numeric($value['count']) ){
				$count += $value['count'];
			}
		}
		return $count;
	}
	// Activity Reactions | Post reactions metadata | Returns activity reactions after posting
	public function post_activity_reactions_html( $activity_id, $reaction_type, $user_id ){
		if( !$this->get_acitivity_reactions( $activity_id ) ){
			$reaction_format = $this->helper->activity_reaction_format();
			$reaction_format[$reaction_type]['count'] = 1;

			array_push($reaction_format[$reaction_type]['users'], get_current_user_id());
			
			bp_activity_add_meta( $activity_id, 'tophive_activity_reactions', $reaction_format );
			return $this->activity_reactions_html($activity_id);
		}else{			
			$reactions = bp_activity_get_meta( $activity_id, 'tophive_activity_reactions', true);
			$reacted = $this->helper->current_user_already_reacted( $activity_id );
			if( $reacted ){
				if( $reaction_type === $reacted ){
					$reactions[$reaction_type]['count'] = $reactions[$reaction_type]['count'];
				}elseif( $reaction_type === 'decrement' ){
					$reactions[$reacted]['count'] = $reactions[$reacted]['count'] - 1;
					if( $reactions[$reacted]['count'] < 0 ){
						$reactions[$reacted]['count'] = 0;
					}
					if ( ($key = array_search($user_id, $reactions[$reacted]['users']) ) !== false ) {
					    unset($reactions[$reacted]['users'][$key]);
					}
				}
				else{
					$reactions[$reacted]['count'] = $reactions[$reacted]['count'] -1;
					if ( ($key = array_search($user_id, $reactions[$reacted]['users']) ) !== false ) {
					    unset($reactions[$reacted]['users'][$key]);
					}
					$reactions[$reaction_type]['count'] = $reactions[$reaction_type]['count'] + 1;
					array_push($reactions[$reaction_type]['users'], get_current_user_id());
				}
				bp_activity_update_meta( $activity_id, 'tophive_activity_reactions', $reactions );
				return $this->activity_reactions_html($activity_id);
			}else{
				$reactions[$reaction_type]['count'] = $reactions[$reaction_type]['count'] + 1;
				array_push($reactions[$reaction_type]['users'], get_current_user_id());
				bp_activity_update_meta( $activity_id, 'tophive_activity_reactions', $reactions );
				return $this->activity_reactions_html($activity_id);
			}
		}
	}

	// Activity Reactions | Ajax | Get all reactions html
	public function activity_reactions_html( $activity_id ){
		return $this->get_activity_reactions_img( $activity_id ) . $this->get_activity_reaction_text( $activity_id );
	}

	/***
	 ** Buddypress Single Activity Reactions i.e: Image Only ( returns 3 images )
	 *  package: Metafans
	 *  since: v1.0.0
	 *
	*/
	function get_activity_reactions_img( $activity_id ){
		if( is_user_logged_in() ){
			$reactions = $this->get_acitivity_reactions( $activity_id );
			if(empty($reactions)){
				return;
			}
			$html = '<span class="reaction-meta-container">';
			$html .= '<span class="reaction-images">';
			foreach ($reactions as $key => $row) {
			    $count[$key]  = $row['count'];
			}
			array_multisort($count, SORT_DESC, $reactions);

			$i = 1;
			foreach ($reactions as $key => $value) {
				if( $i < 4 ){
					if( $value['count'] > 0 && $key !== 'decrement' ){
						$html .= '<img src="'. get_template_directory_uri() . '/assets/images/reactions/'. $key .'.png' .'" />';
						$i++;
					}
				}
			}
			$html .= '</span>';
			return $html;
		}else{
			return '';
		}
	}
	/***
	 ** Buddypress Single Activity Reactions Text
	 *  package: Metafans
	 *  since: v1.0.0
	 ** function : Activity reaction text
	 *
	*/
	public function get_activity_reaction_text( $activity_id ){
		$reaction_count = $this->get_activity_reaction_count( $activity_id );
		$current_user = get_current_user_id();
		if( !is_user_logged_in() ){
			return $reaction_count . esc_html__( ' likes', 'metafans' );	
		}
		$reactions = $this->get_acitivity_reactions( $activity_id );
		$reaction_text = '';

		if( $reaction_count == 1 ){
			foreach ($reactions as $key => $value) {
				if( $value['count'] == 1 ){
					if( get_current_user_id() === $value['users'][0] ){
						$reaction_text .= esc_html__( 'You', 'metafans' );
					}else{
						$reaction_text .= get_the_author_meta( 'display_name', $value['users'][0] );
					}
				}
			}
		}
		if( $reaction_count == 2 ){
			$reacting_users = $this->get_reacting_users( $reactions );
			$users = [];
			foreach ( $reacting_users as $value ) {
				if( $current_user == $value ){
					$users[] = esc_html__( 'You', 'metafans' );
				}else{
					$users[] = get_the_author_meta( 'display_name', $value );
				}
			}
			$reaction_text .= implode(' and ', $users);
		}
		if( $reaction_count > 2 ){
			$get_users = [];
			foreach ($reactions as $key => $value) {
				if( is_array($value['users']) ){
					if( in_array(get_current_user_id(), $value['users']) ){
						$ext_text = esc_html__( 'You and ', 'metafans' );
					}
				}
			}
			if( !isset($ext_text) ){
				$reaction_text .= $reaction_count . esc_html__( ' people', 'metafans' );
			}else{
				$reaction_text .= esc_html__( 'You and ', 'metafans' ) . ($reaction_count - 1) . esc_html__( ' others', 'metafans' );
			}
		}
		$reaction_text .= '</span>';
		return $reaction_text;
	}
	// AJAX || Show more comments from activity
	public function show_more_comments(){
		if( !is_user_logged_in() ){
			return;
		}
		$activity_id = $_POST['activity_id'];
		$show = $_POST['show'];
		$res = $this->get_activity_comment_form( $activity_id ) . $this->get_comments_html( $activity_id, $show );
		wp_send_json( $res, 200 );
	}


	/**
	** Media Comments
	*/
	// get media comments
	function media_comments_html(){
		$media_id = $_POST['media_id'];
		$activity_id = $_POST['activity_id'];		

		$images = bp_activity_get_meta( $activity_id, 'activity_media', false )[0];


		$key = $this->helper->searchArray( $media_id, $images );
		$comments = array_reverse($images[$key]['comments']);
		$reactions = $images[$key]['reactions'];

		$comments_html = '';
		if( !empty($comments) ){
			$comments_html .= '<div class="th-media-comments-all">';
		}
		foreach ($comments as $value) {
			$comments_html .= '<div class="th-media-single-comment">';
			$comments_html .= '<div class="comment_author">';
				$comments_html .= get_avatar( $value['comment_author'], 30, '', '', null );
			$comments_html .= '</div>';
			$comments_html .= '<div class="comment_data">';
				$comments_html .= '<span>' . get_the_author_meta( 'display_name', $value['comment_author'] ) . '</span>';
				$comments_html .= '<span class="times">' . $this->helper->get_time_since( '@' . $value['comment_time']) . '</span>';
				$comments_html .= '<p class="comment_text">' . $value['comment_text'] . '</p>';
			$comments_html .= '</div>';
			$comments_html .= '</div>';
		}
		if( !empty($comments) ){
			$comments_html .= '</div>';
		}

		$people_reacted = $reactions[$type]['people_reacted'];
		$class = '';
		if( is_array($people_reacted) && !empty($people_reacted) ){
			if( in_array(get_current_user_id(), $people_reacted) ){
				$class = 'active';
			}
		}

		$comment_box = $this->media_comment_box( $media_id, $activity_id );
		$media_meta = $this->media_comments_meta( $media_id, $activity_id, $class );

		$response = $media_meta . $comments_html . $comment_box;
		wp_send_json( $response, 200 ); 
	}
	// Media Comment box
	public function media_comment_box( $media_id, $activity_id ){
		$comment_box = '';
		if( is_user_logged_in() ){
			$user_id = get_current_user_id();
			$author_avatar = get_avatar( $user_id, 30, '', '', null );
			$comment_box .= '<div class="media_comment_box">';
				$comment_box .= '<div class="comment_author_img">';
					$comment_box .= $author_avatar;
				$comment_box .= '</div>';
				$comment_box .= '<div class="comment_text">';
					$comment_box .= '<textarea row="2" placeholder="'. esc_html__( 'Write a comment...', 'metafans' ) .'"></textarea>';
					$comment_box .= '<button data-media-id="'. $media_id .'" data-activity-id="'. $activity_id .'" class="th_media_comment_submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cursor" viewBox="0 0 16 16">
					  <path d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z"/>
					</svg></button>';
				$comment_box .= '</div>';
			$comment_box .= '</div>';
		}
		return $comment_box;
	}
	// Media Comments HTML
	public function media_comments_meta( $mid, $aid, $class = '' ){
		$images = bp_activity_get_meta( $aid, 'activity_media', false )[0];

		$key = $this->helper->searchArray( $mid, $images );
		$reactions = $images[$key]['reactions'];

		$people_reacted = $reactions['love']['people_reacted'];
		if( $people_reacted == null ){
			$people_reacted = array();
		}

		if( in_array( get_current_user_id() , $people_reacted) ) {
			$class = "active";
		}

		$comments = $images[$key]['comments'];

		$comments_count = count($comments);
		$reaction_count = $this->helper->getTotalReactionCount($images[$key]['reactions']);

		if( $class == 'active' ){
			$icon = '<svg  width="16" height="16" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512;margin-top: -4px;" ><g><path d="m0 1v8c0 .552246.447693 1 1 1h3v-10h-3c-.552307 0-1 .447693-1 1z" transform="translate(0 5)" fill="currentColor" data-original="#000000" class=""></path><path d="m9.15332 5.02979h-2.9541c-.258301 0-.387695-.172363-.431152-.246582-.043457-.0737305-.131348-.270508-.0063477-.496094l1.0415-1.87549c.228516-.410645.251953-.893555.0649414-1.32471-.187012-.43164-.556152-.744629-1.0127-.858398l-.734375-.183594c-.178711-.0449219-.368164.0122071-.492676.150391l-3.9873 4.42969c-.413574.460449-.641113 1.0542-.641113 1.67236v5.23242c0 1.37842 1.12158 2.5 2.5 2.5l4.97412-.0004883c1.12305 0 2.11475-.756348 2.41113-1.83887l1.06738-4.89844c.03125-.13623.0473633-.275879.0473633-.415527 0-1.01807-.828613-1.84668-1.84668-1.84668z" transform="translate(5 .97)" fill="currentColor" data-original="#000000" class=""></path></g></svg>';
		}else{
			$icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-top: -4px;"><path d="M19.782,9H15.388l.863-2.592a3.9,3.9,0,0,0-1.532-4.464,2.447,2.447,0,0,0-3.341.63l-4.693,6.7A.993.993,0,0,0,6,9H2a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1H6a1,1,0,0,0,1-1v-.132l1.445.964A1.006,1.006,0,0,0,9,23h9a1,1,0,0,0,.895-.553l3.658-7.317A4.264,4.264,0,0,0,23,13.236V12.218A3.222,3.222,0,0,0,19.782,9ZM5,21H3V11H5Zm16-7.764a2.255,2.255,0,0,1-.236,1L17.382,21H9.3L7,19.465v-7.15L13.017,3.72a.43.43,0,0,1,.593-.112,1.893,1.893,0,0,1,.744,2.168l-1.3,3.908A1,1,0,0,0,14,11h5.782A1.219,1.219,0,0,1,21,12.218Z"></path></svg>';
		}

		$html .= '<div class="th-bp-media-comment-button">
			<a href="" class="bp-media-reactions '. $class .'" data-media-id="'. $mid .'" data-activity-id="'. $aid .'">
				'. $icon .'
					<span class="like_count">' . $reaction_count . '</span>
			</a>
			<a href="" class="">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16">
				  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
				  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
				</svg>
					<span class="like_count">' . $comments_count . '</span>
			</a>
		</div>';
		return $html;
	}
	// AJAX || Submit Media Comment
	public function post_media_comments(){
		$comment_text = $_POST['comment_text'];
		$media_id = $_POST['media_id'];
		$activity_id = $_POST['activity_id'];

		$images = bp_activity_get_meta( $activity_id, 'activity_media', false )[0];

		$new_comment = array(
			'comment_text' => $comment_text,
			'comment_author' => get_current_user_id(),
			'comment_time' => time()
		);
		$key = $this->helper->searchArray( $media_id, $images );
		array_push( $images[$key]['comments'] , $new_comment );

		$updated = bp_activity_update_meta( $activity_id, 'activity_media', $images );
		if( $updated ){
			$response = true;
		}else{
			$response = esc_html__( 'Something went wrong!', 'metafans' );
		}
		wp_send_json( $response, 200 );
	}

	// AJAX || Media Reactions
	public function media_reaction(){
		$media_id = $_POST['media_id'];
		$activity_id = $_POST['activity_id'];
		$type = $_POST['reaction_type'];
		$new_reaction_count = 0;

		$images = bp_activity_get_meta( $activity_id, 'activity_media', false )[0];
		$newImages = $images;
		$key = $this->helper->searchArray( $media_id, $images );
		$reactions = $images[$key]['reactions'];

		$people_reacted = $reactions[$type]['people_reacted'];
		if( $people_reacted == null ){
			$people_reacted = array();
		}

		$get_current_reaction_count = $reactions[$type]['count'];
		if( $get_current_reaction_count !== null ){
			if( in_array( get_current_user_id() , $people_reacted) ){
				$get_current_reaction_count = --$get_current_reaction_count;
				if (($to_unset = array_search( get_current_user_id(), $people_reacted)) !== false) {
				    unset($people_reacted[$to_unset]);
				}
				$class = '';
			}else{
				$get_current_reaction_count = ++$get_current_reaction_count;
				array_push( $people_reacted, get_current_user_id() );
				$class = 'active';
			}
		}else{
			if( in_array( get_current_user_id() , $people_reacted) ){
				$get_current_reaction_count = --$get_current_reaction_count;
				if (($to_unset = array_search( get_current_user_id(), $people_reacted)) !== false) {
				    unset($people_reacted[$to_unset]);
				}
				$class = '';
			}else{
				$get_current_reaction_count = ++$get_current_reaction_count;
				array_push( $people_reacted, get_current_user_id() );
				$class = 'active';
			}
		}

		$newCurrentReaction = array(
			'count' => $get_current_reaction_count,
			'people_reacted' => $people_reacted
		);


		$newImages[$key]['reactions'][$type] = $newCurrentReaction;
		bp_activity_update_meta( $activity_id, 'activity_media', $newImages );

		$response = $this->media_comments_meta( $media_id, $activity_id, $class );

		wp_send_json( $response, 200 );
	}

	// AJAX || Post an Activity Share
	public function post_activity_share(){
		if( !is_user_logged_in() ){
			return;
		}
		global $wpdb;
		$table = $wpdb->base_prefix . 'bp_activity';
		$activity_id = $_POST['activity_id'];
		$activity = $wpdb->get_results("SELECT user_id, primary_link FROM {$table} where id={$activity_id}");
		$activity_user_id = $activity[0]->user_id;

		if( $activity_user_id == get_current_user_id() ){
			$action = '<a href="'. bp_core_get_user_domain( $activity_user_id ) .'">'. get_the_author_meta( 'display_name', $activity_user_id ) .'</a>' . esc_html__( ' shared his post', 'metafans' );
		}else{
			$action = '<a href="'. bp_core_get_user_domain( get_current_user_id() ) .'">'. get_the_author_meta( 'display_name', get_current_user_id() ) .'</a> ' . sprintf(esc_html__( 'shared %s post', 'metafans' ), '<a href="'. bp_core_get_user_domain( $activity_user_id ) .'">'. get_the_author_meta( 'display_name', $activity_user_id ) .'</a>' );
		}

		$wpdb->insert(
 			$table,
 			array(
 				'user_id' => get_current_user_id(),
 				'component' => 'activity',
 				'type' => 'activity_share',
 				'action' => $action,
 				'content' => '',
 				'primary_link' => $activity[0]->primary_link,
 				'date_recorded' => current_time('mysql')
 			),
 			array(
 				'%d', '%s', '%s', '%s', '%s', '%s', '%s'
 			)
 		);
 		$shared_id = $wpdb->insert_id;

 		bp_activity_update_meta( $shared_id, 'shared_activity_id', $activity_id );

 		if( $shared_id ){
 			$res = true;
 		}else{
 			$res = false;
 		}

		wp_send_json( $res, 200 );
	}
	/**
	** Activity Footer [ This sections is before comments sections, which contains Reactions,Comments and 
	** share counts ]
	*  @since 1.1.0
	*/
	public function footer_actions(){
		$id = bp_get_activity_id();
		echo $this->get_footer_actions( $id );
	}	
	public function footer_search_actions( $id ){
		echo $this->get_footer_actions( $id );
	}	
	public function get_footer_actions( $id ){
		$html = '<div class="th-bp-footer-meta">';
			if( is_user_logged_in() ){
				$html .= '<div class="reactions-meta" data-activity-id="'. $id .'">' . $this->reactions_html($id) . '</div>';
				$html .= '<div class="comments-meta activity-comments-meta-'. $id .'" data-activity-id="'. $id .'">' . $this->comments_count_html($id) . '</div>';
			}else{
				if( $this->activity_has_reactions( $id ) ){
					$html .= '<span class="logged-out">' . $this->reactions_html($id) . '</span> ';
				}
				$html .= '<span class="logged-out">' . $this->comments_count_html($id) . '</span>';
			}
		$html .= '</div>';
		$html .= '<div class="th-bp-footer-meta-actions">';
			$html .= $this->reactions_picker() . $this->comments_toggler() . $this->activity_sharer();
		$html .= '</div>';
		return $html;
	}
	// Check if activity has reaction
	public function activity_has_reactions( $activity_id ){
		$reaction_count = $this->get_reaction_count( $activity_id );
		if( $reaction_count > 0 ){
			return true;
		}else{
			return false;
		}
	}

	// Buddypress Single Activity Reactions i.e: Image + Count
	public function reactions_html( $activity_id ){
		return $this->get_reactions_img( $activity_id ) . 
		$this->get_reaction_text( $activity_id );
	}

	// Get reations images/icons
	public function get_reactions_img( $activity_id ){
		if( is_user_logged_in() ){
			$reactions = $this->get_reactions( $activity_id );
			if(empty($reactions)){
				return;
			}
			$html = '<span class="reaction-meta-container">';
			$html .= '<span class="reaction-images">';
			foreach ($reactions as $key => $row) {
			    $count[$key]  = $row['count'];
			}
			array_multisort($count, SORT_DESC, $reactions);

			$i = 1;
			foreach ($reactions as $key => $value) {
				if( $i < 4 ){
					if( $value['count'] > 0 && $key !== 'decrement' ){
						$html .= '<img src="'. get_template_directory_uri() . '/assets/images/reactions/'. $key .'.png' .'" />';
						$i++;
					}
				}
			}
			$html .= '</span>';
			return $html;
		}else{
			return '';
		}
	}
	// Get reaction text
	public function get_reaction_text( $activity_id ){
		$reaction_count = $this->get_reaction_count( $activity_id );
		$current_user = get_current_user_id();
		if( !is_user_logged_in() ){
			return $reaction_count . esc_html__( ' likes', 'metafans' );	
		}
		$reactions = $this->get_reactions( $activity_id );
		$reaction_text = '';

		if( $reaction_count == 1 ){
			foreach ($reactions as $key => $value) {
				if( $value['count'] == 1 ){
					if( get_current_user_id() === $value['users'][0] ){
						$reaction_text .= esc_html__( 'You', 'metafans' );
					}else{
						$reaction_text .= get_the_author_meta( 'display_name', $value['users'][0] );
					}
				}
			}
		}
		if( $reaction_count == 2 ){
			$reacting_users = $this->get_reacting_users( $reactions );
			$users = [];
			foreach ( $reacting_users as $value ) {
				if( $current_user == $value ){
					$users[] = esc_html__( 'You', 'metafans' );
				}else{
					$users[] = get_the_author_meta( 'display_name', $value );
				}
			}
			$reaction_text .= implode(' and ', $users);
		}
		if( $reaction_count > 2 ){
			$get_users = [];
			foreach ($reactions as $key => $value) {
				if( is_array($value['users']) ){
					if( in_array(get_current_user_id(), $value['users']) ){
						$ext_text = esc_html__( 'You and ', 'metafans' );
					}
				}
			}
			if( !isset($ext_text) ){
				$reaction_text .= $reaction_count . esc_html__( ' people', 'metafans' );
			}else{
				$reaction_text .= esc_html__( 'You and ', 'metafans' ) . ($reaction_count - 1) . esc_html__( ' others', 'metafans' );
			}
		}
		$reaction_text .= '</span>';
		return $reaction_text;
	}

	// Get the users who have reacted
	public function get_reacting_users( $reactions ){
		$users = array();
		foreach ($reactions as $key => $value) {
			if( $value['count'] > 0 ){
				if( is_array($value['users']) ){
					$users = array_merge($users, $value['users']);
				}
			}
		}
		return array_unique($users);
	}

	// Get reaction count
	public function get_reaction_count( $activity_id ){
		$reactions = $this->get_reactions( $activity_id );
		if(empty($reactions)){
			return;
		}
		$user_id = get_current_user_id();
		$count = 0;
		foreach ( $reactions as $key => $value ) {
			if( is_numeric($value['count']) ){
				$count += $value['count'];
			}
		}
		return $count;
	}
	// Get the reactions
	public function get_reactions( $activity_id ){
		return bp_activity_get_meta( $activity_id, 'tophive_activity_reactions', true );
	}
	// Check if current user has any reactions on a activity
	public function current_user_reacted( $activity_id ){
		$reactions = $this->get_reactions( $activity_id );
		if(empty($reactions)){
			return;
		}
		$user_id = get_current_user_id();
		foreach ($reactions as $key => $value) {
			if( is_array($value['users']) ){
				if( in_array($user_id, $value['users']) ){
					return $key;
				}
			}
		}
	}

	// Buddypress Single Activity Reactions Picker i.e: Image + Count 
	public function reactions_picker( ){
		if( is_user_logged_in() ){

			$id = bp_get_activity_id();

			$reacted = $this->current_user_reacted( $id );

			if( $reacted ){
				$text = ' ' . ucfirst( $reacted );
				$icon = '<img src="';
				$icon .= get_template_directory_uri() . '/assets/images/reactions/'. $reacted .'.png';
				$icon .= '"/>';
				$class = $reacted;
			}else{
				$text = esc_html__( 'Like', 'metafans' );

				$icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>';
				$class = '';
			}

			return '<div class="th-bp-post-like-button th-bp-activity-like-button">
				<a href="#" data-reaction="'. $class .'" data-id="' . $id . '" class="button" data-user="'. get_current_user_id() .'" data-nonce="'. wp_create_nonce('th-bp-likes') .'" >
					'. $icon . $text .'
				</a>
				<span class="reaction_icons">

					<span class="reaction_icon_con">
					    <img data-activity-id="'. $id .'" data-type="like" src="'. get_template_directory_uri() . '/assets/images/reactions/like.png" alt="reaction" />
					    <span class="reaction_icon_tooltip">'. esc_html__("like","metafans") . '</span>
					</span>

					<span class="reaction_icon_con">
					   <img data-activity-id="'. $id .'" data-type="love" src="'. get_template_directory_uri() . '/assets/images/reactions/love.png" alt="reaction" />
					    <span class="reaction_icon_tooltip">'. esc_html__("love","metafans") . '</span>
					</span>

					<span class="reaction_icon_con">
					    <img data-activity-id="'. $id .'" data-type="haha" src="'. get_template_directory_uri() . '/assets/images/reactions/haha.png" alt="reaction" />
					    <span class="reaction_icon_tooltip">'. esc_html__("haha","metafans") . '</span>
					</span>

					<span class="reaction_icon_con">
					    <img data-activity-id="'. $id .'" data-type="wow" src="'. get_template_directory_uri() . '/assets/images/reactions/wow.png" alt="reaction" />
					    <span class="reaction_icon_tooltip">'. esc_html__("wow","metafans") . '</span>
					</span>

					<span class="reaction_icon_con">
					    <img data-activity-id="'. $id .'" data-type="cry" src="'. get_template_directory_uri() . '/assets/images/reactions/sad.png" alt="reaction" />
					    <span class="reaction_icon_tooltip">'. esc_html__("cry","metafans") . '</span>
					</span>

					<span class="reaction_icon_con">
					    <img data-activity-id="'. $id .'" data-type="angry" src="'. get_template_directory_uri() . '/assets/images/reactions/angry.png" alt="reaction" />
					    <span class="reaction_icon_tooltip">'. esc_html__("angry","metafans") . '</span>
					</span>

				</span>
			</div>';	
		}else{

			$text = esc_html__( 'Like', 'metafans' );
			$icon .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>';

			return '<div class="th-bp-logged-out">
				<a href="#">'. $icon . $text .'</a>
			</div>';
		}
	}
	// Comments toggle for activity
	public function comments_toggler( ){
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>';
		if ( is_user_logged_in() ){

			if ( bp_activity_can_comment() ){
				return '<div class="th-bp-post-comment-button">
					<a href="" data-activity-id="activity-'. bp_get_activity_id() .'" class="button">
						'. $icon .'
						<span>' . esc_html__( 'Comment', 'metafans' ) . '</span>
					</a>
				</div>';
			}
		}else{
			return '<div class="th-bp-logged-out">
				<a href="#">'. $icon . esc_html__( 'Comment', 'metafans' ) .'</a>
			</div>';
		}
	}

	// Activity sharer
	public function activity_sharer( ){
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>';
		$timeline_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
		  <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
		</svg>';
		$facebook_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
		  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
		</svg>';
		$twitter_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
		  <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
		</svg>';
		$whatsapp_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
		  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
		</svg>';
		if ( is_user_logged_in() ){
			if( bp_get_activity_type() === 'activity_share' ){
				$activity_id = bp_activity_get_meta( bp_get_activity_id(), 'shared_activity_id', true );
			}else{
				$activity_id = bp_get_activity_id();
			}

			if ( bp_activity_can_comment() ){
				return '<div class="th-bp-post-share-button th-ml-auto">
					<a href="" data-activity-id="'. bp_get_activity_id() .'" class="button activity-share">
						<span class="share_icon">'. $icon .'</span>
						<span>' . esc_html__( 'Share', 'metafans' ) . '</span>
					</a>
					<ul class="sharing-options">
						<li><a href="'. $activity_id .'" class="timeline-share">'. $timeline_icon . esc_html__( 'Share on activity', 'metafans' ) .'</a></li>
						<li><a target="_blank" data-share-type="twitter" href="https://twitter.com/intent/tweet?url='. bp_get_activity_thread_permalink() .'">'. $twitter_icon . esc_html__( 'Share on twitter', 'metafans' ) .'</a></li>
						<li><a target="_blank" data-share-type="facebook" href="https://www.facebook.com/sharer/sharer.php?u='. bp_get_activity_thread_permalink() .'">'. $facebook_icon . esc_html__( 'Share on facebook', 'metafans' ) .'</a></li>
						<li><a data-share-type="whatsapp" href="whatsapp://send?text='. bp_get_activity_thread_permalink() .'" data-action="share/whatsapp/share">'. $whatsapp_icon . esc_html__( 'Share on whatsApp', 'metafans' ) .'</a></li>
					</ul>
				</div>';
			}
		}else{
			return '<div class="th-bp-logged-out">
				<a href="#">'. $icon . esc_html__( 'Share', 'metafans' ) .'</a>
			</div>';
		}

	}

	public function scrape_url(){
		$url = $_REQUEST['url'];
		// wp_send_json( $url );
		$ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    /* 
	     * XXX: This is not a "fix" for your problem, this is a work-around.  You 
	     * should fix your local CAs 
	     */
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	    /* Set a browser UA so that we aren't told to update */
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36');

	    $res = curl_exec($ch);

	    if ($res === false) {
	        die('error: ' . curl_error($ch));
	    }

	    curl_close($ch);

	    $d = new DOMDocument();
	    @$d->loadHTML($res);

	    $output = array(
	        'title' => '',
	        'thumb'  => ''
	    );

	    $x = new DOMXPath($d);

	    $title = $x->query("//title");
	    if ($title->length > 0) {
	        $output['title'] = $title->item(0)->textContent;
	    }

	    $meta = $x->query("//meta[@property = 'og:image']");
	    if ($meta->length > 0) {
	        $output['thumb'] = $meta->item(0)->getAttribute('content');
	    }

	    // wp_send_json($output);
		// $html = file_get_html($url);
		// $title = $html->find('title', 0);
		// $image = $html->find('meta[property="og:image"]', 0);

		// $res['title'] = $title->plaintext;
		// $res['thumb'] = $image->content;

		$parse = parse_url($url);

		$urltype = $this->helper->detectMediaUrlType( $url );

		if( $urltype['video_type'] == 'youtube' || $urltype['video_type'] == 'vimeo' ){
			$embedurl = $this->helper->generateVideoEmbedUrl( $url );
			$preview = '<div class="whats-new-live-preview">';
				$preview .= '<span class="cross"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
				  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg></span>';
				$preview .= '<div class="video-embed preview-thumb">';
					$preview .= '<iframe src="'. $embedurl .'" ></iframe>';
				$preview .= '</div>';
			$preview .= '</div>';
		}elseif ( $urltype['video_type'] == 'soundcloud' ){
			$src = 'https://w.soundcloud.com/player/?url=' . $urltype['video_id'];
			$preview = '<div class="activity-soundcloud-embed">';
				$preview .= '<iframe src='. $src .'/>';
			$preview .= '</div>';
		}else{
			$preview = '<div class="whats-new-live-preview">';
				$preview .= '<span class="cross"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
				  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg></span>';
				$preview .= '<div class="preview-thumb">';
					$preview .= '<img src="'. $output['thumb'] .'" />';
				$preview .= '</div>';
				$preview .= '<div class="preview-content">';
					$preview .= '<p>'. $parse['host'] .'</p>';
					$preview .= '<h5>'. $output['title'] .'</h5>';
				$preview .= '</div>';
			$preview .= '</div>';
		}


		wp_send_json( $preview, 200 );
	}

	public function is_active() {
		return tophive_metafans()->is_buddypress_active();
	}

}
function Tophive_BP_Activity() {
	return Tophive_BP_Activity::get_instance();
}

if ( tophive_metafans()->is_buddypress_active() ) {
	Tophive_BP_Activity();
}
