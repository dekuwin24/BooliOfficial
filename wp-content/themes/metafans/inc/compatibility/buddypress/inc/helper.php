<?php 
/**
 ***
 ** MetaFans BuddyPress Helpers
 ** @package WordPress
 ** @subpackage Metafans
 ** @since 2.3.0
 *
 *
 */
class Tophive_BP_Helper
{

	/*
	** Get friendship status with current user and displayed user
	** @since v1.5.0
	*
	*/
	function get_friendship_status( $user_id ){
		if( class_exists('BP_Friends_Friendship') ){
			return BP_Friends_Friendship::check_is_friend( get_current_user_id(), $user_id );
		}
	}
	/*
	** Get friends button text depending on the friendship status
	** @since v1.5.0
	*
	*/
	function get_friend_button_text($user_id){
		$get_status = $this->get_friendship_status( $user_id );
		$pending_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
		  <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
		</svg>';

		$response_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
		  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
		</svg>';

		$friends_icon = '<svg class="small-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
		  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
		  <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
		</svg>';

		$add_friend_icon = '<svg class="small-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
		  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
		  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
		</svg>';

		switch ($get_status) {
			case 'pending':
				return '<span class="show">' . $pending_icon . esc_html__( ' Requested', 'metafans' ) . '</span><span class="hidden">' . esc_html__( 'Cancel', 'metafans' ) . '</span>'; 
				break;			

			case 'awaiting_response':
				return $response_icon . esc_html__( ' Response', 'metafans' ); 
				break;

			case 'is_friend':
				return '<span class="show">' . $friends_icon . esc_html__( ' Friends', 'metafans' ) . '</span><span class="hidden">'. esc_html__( 'Cancel', 'metafans' ) .'</span>'; 
				break;
			
			case 'not_friends':
				return $add_friend_icon . esc_html__( ' Add Friend', 'metafans' ); 
				break;
			
			default:
				return $add_friend_icon . esc_html__( ' Add Friend', 'metafans' );
				break;
		}
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
	** Get Media Type by a given URL
	** @since v1.5.0
	*
	*/
	public function get_media_type( $url ){
		$media_filename = basename($url);
		$ext = pathinfo($media_filename, PATHINFO_EXTENSION);
		$video_extensions = array("mov", "mp4", "3gp");
		$image_extensions = array("jpg", "jpeg", "gif", "png");
		$documents_extensions = array("pdf", "docs", "docx", "txt", "text", 'zip', 'psd', 'css');
		if( in_array($ext, $video_extensions) ){
			return 'video';
		}else if(in_array($ext, $image_extensions)){
			return 'image';
		}else if(in_array($ext, $documents_extensions)){
			return 'document';
		}
	}

	/*
	** Get conversion of thousands or millions
	** @since v1.0.0
	*
	*/
	public function convertThousandsPlus($num) {

	  	if($num>1000) {

	        $x = round($num);
	        $x_number_format = number_format($x);
	        $x_array = explode(',', $x_number_format);
	        $x_parts = array('k', 'm', 'b', 't');
	        $x_count_parts = count($x_array) - 1;
	        $x_display = $x;
	        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
	        $x_display .= $x_parts[$x_count_parts - 1];

	        return $x_display;
	  	}

	  	return $num;
	}

	/*
	** Convert a string of url or emoji to string...
	** @since v1.0.0
	*
	*/
	public function convert_strings( $content ){
		// $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
		$url = '/(?<!src=[\"\'])(http(s)?:\/\/(www\.)?[\/a-zA-Z0-9%\?\.\-]*)(?=$|<|\s)/'; 
		$content = 	preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $content);
		$content = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="?s=$1">#$1</a>', $content);
		$content = convert_smilies( $content );
		return $content;
	}
	public function convert_hashtag($s){  
      	$expression = "/#+([a-zA-Z0-9_]+)/";  
      	$s = preg_replace($expression, '<a href="?hashtag=$1&s=$1">$0</a>', $s);  
      	return $s;
	} 

	// Check if a actiivity has reactions
	public function activity_has_reactions( $activity_id ){
		$reaction_count = $this->get_activity_reaction_count( $activity_id );
		if( $reaction_count > 0 ){
			return true;
		}else{
			return false;
		}
	}

	// Activity Comments format
	public function activity_comment_format(){
		return array(
			'ID' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1, 10),
			'content' => '',
			'time' => time(),
			'author' => get_current_user_id(),
			'author_name' => get_the_author_meta( 'display_name', get_current_user_id() ),
			'author_url' => get_the_author_meta( 'user_url', get_current_user_id() ),
			'avatar' => get_avatar_url( get_current_user_id() ),
			'reactions' => array(
				'like' => array(
					'count' => 0,
					'users' => array(),
				),
				'love' => array(
					'count' => 0,
					'users' => array(),
				),
				'haha' => array(
					'count' => 0,
					'users' => array(),
				),
				'wow' => array(
					'count' => 0,
					'users' => array(),
				),
				'angry' => array(
					'count' => 0,
					'users' => array(),
				),
				'cry' => array(
					'count' => 0,
					'users' => array()
				)
			),
			'replies' => array(),
		);
	}
	// Comment reply format
	public function comment_reply_format(){
		return array(
			'reply_author' => get_current_user_id(),
			'reply_content' => '',
			'reply_time' => time(),
			'reactions' => array(
				'like' => array(
					'count' => 0,
					'users' => array(),
				),
				'love' => array(
					'count' => 0,
					'users' => array(),
				),
				'haha' => array(
					'count' => 0,
					'users' => array(),
				),
				'wow' => array(
					'count' => 0,
					'users' => array(),
				),
				'angry' => array(
					'count' => 0,
					'users' => array(),
				),
				'cry' => array(
					'count' => 0,
					'users' => array()
				)
			)

		);
	}

	// Search an array key by its value
	public function searchArray($id, $array) {
	   	foreach ($array as $key => $val) {
	       	if ($val['id'] === $id) {
	           	return $key;
	       	}elseif( $val['ID'] === $id ){
	       		return $key;
	       	}
	   	}
	   	return null;
	}

	// Detect Video URL Type
	public function detectMediaUrlType($url) {
	    $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
	    $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);


	    $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
	    $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);

	    $sc_rx = '/^(?:https?:\/\/)((?:www\.)|(?:m\.))?soundcloud\.com\/[a-z0-9](?!.*?(-|_){2})[\w-]{1,23}[a-z0-9](?:\/.+)?$/';
	    $has_match_soundcloud = preg_match($sc_rx, $url, $sc_matches);

		if($has_match_youtube) {
	        $video_id = $yt_matches[5]; 
	        $type = 'youtube';
	    }
	    elseif($has_match_vimeo) {
	        $video_id = $vm_matches[5];
	        $type = 'vimeo';
	    }
	    elseif($has_match_soundcloud) {
	        $video_id = $url;
	        $type = 'soundcloud';
	    }
	    else {
	        $video_id = 0;
	        $type = 'none';
	    }
	    $data['video_id'] = $video_id;
	    $data['video_type'] = $type;
	    return $data;
	}
	//This is a general function for generating an embed link of an FB/Vimeo/Youtube Video.
	public function generateVideoEmbedUrl($url){
	    $finalUrl = '';
	    if(strpos($url, 'facebook.com/') !== false) {
	        //it is FB video
	        $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
	    }else if(strpos($url, 'vimeo.com/') !== false) {
	        //it is Vimeo video
	        $videoId = explode("vimeo.com/",$url)[1];
	        if(strpos($videoId, '&') !== false){
	            $videoId = explode("&",$videoId)[0];
	        }
	        $finalUrl.='https://player.vimeo.com/video/'.$videoId;
	    }else if(strpos($url, 'youtube.com/') !== false) {
	        //it is Youtube video
	        $videoId = explode("v=",$url)[1];
	        if(strpos($videoId, '&') !== false){
	            $videoId = explode("&",$videoId)[0];
	        }
	        $finalUrl.='https://www.youtube.com/embed/'.$videoId;
	    }else if(strpos($url, 'youtu.be/') !== false){
	        //it is Youtube video
	        $videoId = explode("youtu.be/",$url)[1];
	        if(strpos($videoId, '&') !== false){
	            $videoId = explode("&",$videoId)[0];
	        }
	        $finalUrl.='https://www.youtube.com/embed/'.$videoId;
	    }else{
	        //Enter valid video URL
	    }
	    return $finalUrl;
	}
	/**
	** Get total reaction count
	*/
	public function getTotalReactionCount( $reactions ){
		$sum = 0;

		foreach($reactions as $key => $value) {
		    $sum += $value[ 'count' ];
		}
		return $sum;
	}
	/***
	 ** Buddypress Single Activity Reactions Format
	 *  package: Metafans
	 *  since: v1.0.0
	 ** function : Ajax response to all reactions to show below activity text or image
	 *
	*/
	public function activity_reaction_format(){
		return array(
			'like' => array(
				'count' => 0,
				'users' => array(),
			),
			'love' => array(
				'count' => 0,
				'users' => array(),
			),
			'haha' => array(
				'count' => 0,
				'users' => array(),
			),
			'wow' => array(
				'count' => 0,
				'users' => array(),
			),
			'angry' => array(
				'count' => 0,
				'users' => array(),
			),
			'cry' => array(
				'count' => 0,
				'users' => array()
			)
		);
	}

	/***
	 ** Buddypress Single Activity Reactions
	 *  package: Metafans
	 *  since: v1.0.0
	 ** function : If user already reacted
	 *
	*/
	public function current_user_already_reacted( $activity_id ){
		$reactions = $this->get_acitivity_reactions( $activity_id );
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

	/*
	** Get Activity author id
	** @since 2.4.0
	**
	*/
	public function get_author_id_from_activity_id( $activity_id ){
		if( empty($activity_id) ){
			return;
		}
		// return 'Hi';
		global $wpdb;
		$results = $wpdb->get_results("SELECT user_id from {$wpdb->base_prefix}bp_activity where id={$activity_id}", ARRAY_A);
		return $results[0]['user_id'];
	}
	public function get_acitivity_reactions( $activity_id ){
		return bp_activity_get_meta( $activity_id, 'tophive_activity_reactions', true );
	}
	/***
	 ** Buddypress Activity Reaction Image TAG
	 *  package: Metafans
	 *  since: v1.0.0
	 ** function : get reaction image tag
	 *
	*/
	public function get_reaction_img_url( $item ){
		return '<img src="'. get_template_directory_uri() . '/assets/images/reactions/'. $item .'.png' .'" />';	
	}
	public function user_id_exists($user){
	    global $wpdb;
	    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));
	    if($count == 1){ return true; }else{ return false; }
	}
}