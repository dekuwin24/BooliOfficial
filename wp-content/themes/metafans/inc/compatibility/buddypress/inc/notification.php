<?php 
/**
 ***
 ** MetaFans BuddyPress Notification Integration
 ** @package WordPress
 ** @subpackage Metafans
 ** @since 2.4.0
 *
 *
 */
class Tophive_BP_Notification
{
    static $_instance;
    public $helper = '';

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
			include_once 'helper.php';
			$this->helper = new Tophive_BP_Helper();
			add_filter( 'tophive/header/buddypress/notifications/count', array($this, 'get_unread_notification_count') );
			add_filter( 'tophive/header/buddypress/notifications/all', array($this, 'get_notifications_html') );
			add_filter( 'tophive/header/buddypress/notifications/raw', array($this, 'get_notifications') );

			add_action( 'wp_ajax_handle_notification', array( $this, 'metafans_handle_notification' ) );
		}
	}

	public function metafans_handle_notification(){
		$action = $_POST['Action'];
		$notification_id = $_POST['notification_id'];
		if( empty($action) || empty($notification_id) ){
			wp_send_json( false, 401 );
		}
		if( $action == "read" ){
			if( function_exists("bp_notifications_mark_notification") ){
				$res = bp_notifications_mark_notification( $notification_id );
				if( $res ){
					$response = array(
						'response_type' => "success",
						'response_msg' => esc_html__("Notification marked as read", 'metafans' )
					);
				}else{
					$response = array(
						'response_type' => "error",
						'response_msg' => esc_html__("Notification could not be marked as read", 'metafans' )
					);
				}
			}
		}elseif( $action == "unread" ){
			if( function_exists("bp_notifications_mark_notification") ){
				$res = bp_notifications_mark_notification( $notification_id, true );
			}
		}elseif( $action == "delete" ){
			if( function_exists("bp_notifications_delete_notification") ){
				$res = bp_notifications_delete_notification( $notification_id );
				if( $res ){
					$response = array(
						'response_type' => "success",
						'response_msg' => esc_html__("Notification deleted successfully", 'metafans' )
					);
				}else{
					$response = array(
						'response_type' => "error",
						'response_msg' => esc_html__("Notification could not be deleted", 'metafans' )
					);
				}
			}
		}
		wp_send_json( $response, 200 );
	}
	/*
	** Get ALL notifications for a user [ Read + Unread ]
	** @since v2.4.0
	*
	*/
	public function get_notifications(){
		global $wpdb;
		$user_id = get_current_user_id();
		$notifications = $wpdb->get_results("SELECT * from {$wpdb->base_prefix}bp_notifications where user_id={$user_id} and component_name IN ('activity', 'friends')", ARRAY_A);
		$notifs = array();
		foreach ($notifications as $value) {
			$notifs[$value['item_id']][] = $value;
		}
		return $notifs;
	}

	public function get_notifications_html(){
		$notifications_html = array();
		$notifications = $this->get_notifications();
		foreach ($notifications as $notification) {
			$html = $this->notification_text( $notification );
			if( !empty($html) ){
				array_push( $notifications_html, $html);
			}
		}
		return array_reverse($notifications_html);
	}


	/*
	** Get only unread notifications
	** @since v2.4.0
	*
	*/
	public function get_unread_notifications(){
		global $wpdb;
		$user_id = get_current_user_id();
		$notifications = $wpdb->get_results("SELECT * from {$wpdb->base_prefix}bp_notifications where user_id={$user_id} and component_name IN ('activity', 'friends') and is_new=1", ARRAY_A);
		return $notifications;	
	}

	/*
	** Get Unread Notifications count
	** @since v2.4.0
	*
	*/
	public function get_unread_notification_count(){
		$count = count($this->get_unread_notifications());
		if( $count > 9 ){
			return '9+';
		}else{
			return $count;
		}
	}

	/**
	** Get notification text
	*/
	public function notification_text( $notification ){
		$component_name = $notification[0]['component_name'];
		switch ($component_name) {
			case 'friends':
				return $this->get_friendship_notification( $notification );
				break;

			case 'activity':
				return $this->get_activity_notification( $notification );
				break;
			
			default:
				// code...
				break;
		}
	}

	public function get_friendship_notification( $notification ){
		$component_action = $notification[0]['component_action'];
		$user_id = $notification[0]['item_id'];
		if( $this->helper->user_id_exists($user_id) ){
			$status = $this->helper->get_friendship_status( $user_id );
			switch ($status) {
				case 'awaiting_response':
					return '<a>' . get_avatar($user_id) . '<span class="desc '. $user_id .'"><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $user_id )) . '</span>' . esc_html__( ' sent you a friend request', 'metafans' ) . '</span></a>
						<div class="notifications-action-buttons">
						<a href="" class="bp-th-friends-button" data-user-id="'. $user_id .'" data-action="' . $this->helper->get_friendship_status( $user_id ) .'">'. $this->helper->get_friend_button_text( $user_id ) .'</a>
						</div>';
					break;

				case 'is_friend':
					$profile_link = function_exists('bp_core_get_user_domain') ? bp_core_get_user_domain( $user_id ) : '';
					return '<a href="'. $profile_link .'">' . get_avatar($user_id) . '<span class="desc '. $user_id .'"><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $user_id )) . '</span>' . esc_html__( ' and you are now friends', 'metafans' ) . '</span></a>';
					break;
				
				default:
					// code...
					break;
			}
		}else{
			return null;
		}
	}

	public function get_activity_notification( $notification ){
		$notification = array_reverse( $notification );
		$component_action = $notification[0]['component_action'];
		$user_id = $notification[0]['secondary_item_id'];
		$activity_id = $notification[0]['item_id']; 
		$time = $notification[0]['date_notified']; 
		$get_permalink = bp_activity_get_permalink( $activity_id );
		$total = count($notification);
		if( $total == 2 ){
			$second_user_id = $notification[1]['secondary_item_id'];
			$commenter = get_avatar($user_id) . '<span class="desc"><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $user_id )) . esc_html__(' and ', 'metafans') . '</span><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $second_user_id )) . '</span>';
		}elseif( $total > 2 ){
			$second_user_id = $notification[1]['secondary_item_id'];
			$more = $total - 2;
			$commenter = get_avatar($user_id) . '<span class="desc"><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $user_id )) . esc_html__(', ', 'metafans') . '</span><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $second_user_id )) . '</span><span class="bold-600"> and ' . $more . ' others</span>';

		}else{
			$commenter = get_avatar($user_id) . '<span class="desc"><span class="bold-600">' . ucfirst(get_the_author_meta( 'display_name', $user_id )) . '</span>';
		}
		switch ($component_action) {
			case 'update_reply':
				return '<a href="'. $get_permalink .'">' . $commenter . $this->get_notification_text( 'comment', $activity_id ) . '<span class="notification-time">'. $this->helper->get_time_since($time) .'</span></span></a>';
				break;
			
			default:
				// code...
				break;
		}
	}
	public function get_activity_content( $activity_id ){
		global $wpdb;
		$results = $wpdb->get_results("SELECT content from {$wpdb->base_prefix}bp_activity where id={$activity_id}", ARRAY_A);

		if( !empty(strip_tags($results[0]['content'])) ){
			$content = '"' . $results[0]['content'] . '"';
			$content = substr($content,0,20).'...'. '"';
		}else{
			$content = $results[0]['content'];
		}
		return $content;
	}
	public function get_notification_text( $activity_id ){
		global $wpdb;
		$results = $wpdb->get_results("SELECT content from {$wpdb->base_prefix}bp_activity where id={$activity_id}", ARRAY_A);
		$content_text = $results[0]['content'];

		$activity_media = $this->get_activity_media( $activity_id );
		$content = $this->get_activity_content( $activity_id );
		if( !empty($activity_media) ){
			$view = 'photo';
		}else{
			preg_match('/(<img[^>]+>)/i', $content_text, $photos);
			if( !empty($photos) ){
				$view = 'photo';
			}else{
				$view = 'post';
			}
		}
		switch( $type ){
			case 'comment':
				switch($view){
					case 'photo':
						return esc_html__( ' commented on your photo', 'metafans' );
						break;
					case 'post':
						return esc_html__( ' commented on your post', 'metafans' ) . ' ' . $content;
						break;
				}
				break;
		}
	}
	public function get_activity_media( $activity_id ){
		return bp_activity_get_meta( $activity_id, 'activity_media', true );
	}

}
function Tophive_BP_Notification() {
	return Tophive_BP_Notification::get_instance();
}

if ( tophive_metafans()->is_buddypress_active() ) {
	Tophive_BP_Notification();
}