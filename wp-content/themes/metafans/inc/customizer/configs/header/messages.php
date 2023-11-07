<?php

class Tophive_Builder_Item_User_Messages {
	public $id = 'user_messenger';
	public $section = 'user_messenger';
	public $name = 'user_messenger';
	public $label = '';

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->label = esc_html__( 'Live Messenger', 'metafans' );
		add_filter('th-bp-user-messenger', array($this, 'th_bp_user_messenger' ), 10, 2);
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
		);

		$is_bp_active = class_exists('BuddyPress') ? true : false;


		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}
	
	
	/**
	 * Optional. Render item content
	 */
	function render() {
		global $bp;
		$is_bp_active = class_exists('BuddyPress') ? true : false;

		if( !$is_bp_active ){
			return;
		}
		$user_display_name = get_the_author_meta( 'user_nicename', get_current_user_id() );
		$notification_url = site_url() . '/members/' . $user_display_name . '/notifications';


		/**
		 * Hook: tophive/builder_item/user-messenger/before_html
		 *
		 * @since 0.2.8
		 */ 

		$inbox_logo = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
		  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
		</svg>';
		ob_start();
		if( is_user_logged_in() ){
			echo '<div class="th-bp-header-messenger-container">
				<div class="th-bp-inbox-logo">'. $inbox_logo .'<span>'. $notification_count .'</span></div>
			<ul class="th-bpm-chat-members">
			<span class="messenger-title">'. esc_html__( 'Messages', 'metafans' ) .'<a class="ec-float-right" href="'. $notification_url .'">'. esc_html__( 'View All', 'metafans' ) .'</a></span>';

				do_action( 'tophive/buddypress/header/messenger' );

			echo '</ul>
			</div>
			<div class="header-' . esc_attr( $this->id ) . '-item item--' . esc_attr( $this->id ) . '">
				<div class="user-account-segment">';

				echo '</div>
			</div>';
		}
		return ob_get_clean();
		/**
		 * Hook: tophive/builder_item/user-messenger/after_html
		 *
		 * @since 0.2.8
		 */
		do_action( 'tophive/builder_item/user-messenger/after_html' );
	}
}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_User_Messages() );
