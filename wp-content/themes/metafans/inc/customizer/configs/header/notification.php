<?php

class Tophive_Builder_Item_User_Notification {
	public $id = 'user_notification';
	public $section = 'user_notification';
	public $name = 'user_notification';
	public $label = '';

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->label = esc_html__( 'User Notification', 'metafans' );
		add_filter('th-bp-user-notification', array($this, 'th_bp_user_notification' ), 10, 2);
	}

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => $this->label,
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '1',
			'priority' => 20,
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		// Render callback function.
		$fn       = array( $this, 'render' );

		$config   = array(
			array(
				'name'  => $this->section,
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => $this->label,
			),

			array(
				'name'            => $this->name . '_icon_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => 'body .builder-item--' . $this->name . ' .th-bp-notif-logo',
					'hover' => 'body .builder-item--' . $this->name . ' .th-bp-notif-logo:hover',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Notification Icon Styling', 'metafans' ),
			),
			array(
				'name'            => $this->name . '_counter_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => 'body .builder-item--' . $this->name . ' .th-bp-notif-logo span',
					'hover' => 'body .builder-item--' . $this->name . ' .th-bp-notif-logo span:hover',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Notification Count Styling', 'metafans' ),
			),
			array(
				'name'            => $this->name . '_count_position_x',
				'type'            => 'slider',
				'section'         => $this->section,
				'device_settings' => true,
				'max'             => 150,
				'title'           => esc_html__( 'Counter Position Vertical', 'metafans' ),
				'selector'        => 'body .builder-item--' . $this->name . ' .th-bp-notif-logo span',
				'css_format'      => 'right: {{value}};',
				'default'         => array(),
			),
			array(
				'name'            => $this->name . '_count_position_y',
				'type'            => 'slider',
				'section'         => $this->section,
				'device_settings' => true,
				'max'             => 150,
				'title'           => esc_html__( 'Counter Position Top Bottom', 'metafans' ),
				'selector'        => 'body .builder-item--' . $this->name . ' .th-bp-notif-logo span',
				'css_format'      => 'top: {{value}};',
				'default'         => array(),
			),

			// array(
			// 	'name'            => "{$this->name}_show_qty",
			// 	'type'            => 'checkbox',
			// 	'section'         => $this->section,
			// 	'selector'        => '.builder-item--' . $this->id . '.th-bp-notif-logo svg',
			// 	'render_callback' => $fn,
			// 	'default'  => 1,
			// 	'label'  => __( 'Counter', 'metafans' ),
			// 	'checkbox_label'  => __( 'Show counter', 'metafans' ),
			// ),

			// array(
			// 	'name'        => "{$this->name}_icon_styling",
			// 	'type'        => 'styling',
			// 	'section'     => $this->section,
			// 	'title'       => esc_html__( 'Styling', 'metafans' ),
			// 	'selector'    => array(
			// 		'normal' => '.builder-item--' . $this->id . ' .th-bp-notif-logo',
			// 		'hover'  => '.builder-item--' . $this->id . ' .th-bp-notif-logo:hover',
			// 	),
			// 	'css_format'  => 'styling',
			// 	'default'     => array(),
			// 	'fields'      => array(
			// 		'normal_fields' => array(
			// 			'link_color'    => false, // disable for special field.
			// 			'margin'        => false,
			// 			'bg_image'      => false,
			// 			'bg_cover'      => false,
			// 			'bg_position'   => false,
			// 			'bg_repeat'     => false,
			// 			'bg_attachment' => false,
			// 		),
			// 		'hover_fields'  => array(
			// 			'link_color' => false, // disable for special field.
			// 		),
			// 	),
			// ),

			// array(
			// 	'name'       => "{$this->name}_typography",
			// 	'type'       => 'typography',
			// 	'section'    => $this->section,
			// 	'title'      => __( 'Typography', 'metafans' ),
			// 	'selector'   => '.builder-item--' . $this->id,
			// 	'css_format' => 'typography',
			// 	'default'    => array(),
			// ),

			// array(
			// 	'name'    => "{$this->name}_icon_h",
			// 	'type'    => 'heading',
			// 	'section' => $this->section,
			// 	'title'   => __( 'Icon Settings', 'metafans' ),
			// ),

			// array(
			// 	'name'            => "{$this->name}_icon_size",
			// 	'type'            => 'slider',
			// 	'section'         => $this->section,
			// 	'device_settings' => true,
			// 	'max'             => 150,
			// 	'title'           => __( 'Icon Size', 'metafans' ),
			// 	'selector'        => '.builder-item--' . $this->id . 'wishlist-icon i:before',
			// 	'css_format'      => 'font-size: {{value}};',
			// 	'default'         => array(),
			// ),

			// array(
			// 	'name'        => "{$this->name}_icon_styling",
			// 	'type'        => 'styling',
			// 	'section'     => $this->section,
			// 	'title'       => __( 'Styling', 'metafans' ),
			// 	'description' => __( 'Advanced styling for wishlist icon', 'metafans' ),
			// 	'selector'    => array(
			// 		'normal' => '.builder-item--' . $this->id . 'wishlist_products_counter .wishlist-icon i',
			// 		'hover'  => '.builder-item--' . $this->idhover . 'wishlist_products_counter .wishlist-icon i',
			// 	),
			// 	'css_format'  => 'styling',
			// 	'default'     => array(),
			// 	'fields'      => array(
			// 		'normal_fields' => array(
			// 			'link_color'    => false,
			// 			// 'margin' => false,
			// 			'bg_image'      => false,
			// 			'bg_cover'      => false,
			// 			'bg_position'   => false,
			// 			'bg_repeat'     => false,
			// 			'bg_attachment' => false,
			// 		),
			// 		'hover_fields'  => array(
			// 			'link_color' => false, // disable for special field.
			// 		),
			// 	),
			// ),

			// array(
			// 	'name'        => "{$this->name}_qty_styling",
			// 	'type'        => 'styling',
			// 	'section'     => $this->section,
			// 	'title'       => __( 'Counter', 'metafans' ),
			// 	'description' => __( 'Advanced styling for counter bubble', 'metafans' ),
			// 	'selector'    => array(
			// 		'normal' => '.builder-item--' . $this->id . 'wishlist-icon .wishlist_products_counter_number',
			// 		'hover'  => '.builder-header-' . $this->id . 'wishlist-icon .wishlist_products_counter_number',
			// 	),
			// 	'css_format'  => 'styling',
			// 	'default'     => array(),
			// 	'fields'      => array(
			// 		'normal_fields' => array(
			// 			'link_color'    => false, // disable for special field.
			// 			// 'margin' => false,
			// 			'bg_image'      => false,
			// 			'bg_cover'      => false,
			// 			'bg_position'   => false,
			// 			'bg_repeat'     => false,
			// 			'bg_attachment' => false,
			// 		),
			// 		'hover_fields'  => array(
			// 			'link_color' => false, // disable for special field.
			// 		),
			// 	),
			// ),
		);

		$is_bp_active = class_exists('BuddyPress') ? true : false;


		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}
	
	
	/**
	 * Optional. Render item content
	 */
	function render() {
		if( !is_user_logged_in() ){
			return;
		}
		global $bp, $wpdb;
		$is_bp_active = class_exists('BuddyPress') ? true : false;

		if( !$is_bp_active ){
			return;
		}
		$user_display_name = get_the_author_meta( 'user_nicename', get_current_user_id() );
		$notification_url = site_url() . '/members/' . $user_display_name . '/notifications';
		$user_id = get_current_user_id();

		/**
		 * Hook: tophive/builder_item/user-notification/before_html
		 *
		 * @since 0.2.8
		 */

		$raw_notifications = apply_filters( 'tophive/header/buddypress/notifications/raw', '' );
		$notifications = apply_filters( 'tophive/header/buddypress/notifications/all', '' );

		$notification_count = apply_filters( 'tophive/header/buddypress/notifications/count', '' );
		$notification_logo = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
		  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
		</svg>';

		// echo '<pre>';
		// print_r($raw_notifications);
		// echo '</pre>';
		$notification_div = '<div class="th-bp-header-notification-container">';
		$notification_div .= '<div class="th-bp-notif-logo">'. $notification_logo .'<span>'. $notification_count .'</span></div>';
		$notification_div .= '<ul>';
		$notification_div .= '<span class="notification-title">'. esc_html__( 'Notifications', 'metafans' ) .'<a class="ec-float-right" href="'. $notification_url .'">'. esc_html__( 'View All', 'metafans' ) .'</a></span>';
		// $notification_div .= ;

		// if( bp_has_notifications( bp_ajax_querystring( 'notifications' ) ) ){
		// 		while ( bp_the_notifications() ){
		// 			$user_id = $bp->notifications->query_loop->notification->secondary_item_id;
		// 			bp_the_notification();

		// 			$notification_div .= '<li>';

		// 			$notification_div .= get_avatar( $user_id, 30 );
		// 			$notification_div .= bp_get_the_notification_description();
		// 			$notification_div .= '<span class="time">' . bp_get_the_notification_time_since() . '</span>';
					
		// 			$notification_div .= '</li>';
		// 		}
		// }
		if ( $notifications ) {
			foreach ($notifications as $notification) {
	        	$notification_div .= '<li>'. $notification .'</li>';
			}
		} else {
			$notification_div .= '<li><a href="'. $bp->loggedin_user->domain .'">'. esc_html__( 'You have no new Notifications.', 'metafans' ) .'</a></li>';
		}

		// echo '<pre>';
		// // print_r($notifs);
		// // $raw_notifications = array_column($raw_notifications, 'component_name', 'item_id');
		// print_r($notifications);
		// echo '</pre>';
		$notification_div .= '</ul>';
		$notification_div .= '</div>';

		do_action( 'tophive/builder_item/user-notification/before_html' );
		if( is_user_logged_in() ){
			$html = '<div class="header-' . esc_attr( $this->id ) . '-item item--' . esc_attr( $this->id ) . '">';
				$html .= '<div class="user-account-segment">';
					$html .= $notification_div;
				$html .= '</div>';

			$html .= '</div>';
		}
		echo tophive_sanitize_filter($html);
		/**
		 * Hook: tophive/builder_item/user-notification/after_html
		 *
		 * @since 0.2.8
		 */
		do_action( 'tophive/builder_item/user-notification/after_html' );
	}
}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_User_Notification() );
