<?php

class Tophive_Builder_Item_Singin_Signup {
	public $id = 'signin_signup';
	public $section = 'signin_signup';
	public $name = 'signin_signup';
	public $label = '';

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->label = esc_html__( 'User Account', 'metafans' );
		add_filter('wc_user_loggedin_menu', array($this, 'wc_action_header' ), 10, 2);
		add_filter('lp_user_loggedin_menu', array($this, 'lp_action_header' ), 12, 2);
		add_filter('bp_user_loggedin_menu', array($this, 'bp_action_header' ), 12, 2);
		if( !is_user_logged_in() ){
			add_action( 'tophive/before-site-content', array($this, 'login_register_form'), 10, 0 );
		}
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
				'name'     => $this->section . '_login_btn_heading',
				'type'     => 'heading',
				'section'  => $this->section,
				'title'    => esc_html__( 'Login/signup button', 'metafans' )
			),
			array(
				'name'            => $this->name . '_loggedout_state',
				'type'            => 'checkbox',
				'section'         => $this->section,
				'checkbox_label'  => esc_html__( 'Switch to logged out state', 'metafans' ),
				'render_callback' => $fn,
			),
			array(
				'name'            => $this->name . '_signup_btn',
				'type'            => 'checkbox',
				'section'         => $this->section, 
				'checkbox_label'  => esc_html__( 'Hide Signup Button', 'metafans' ),
				'render_callback' => $fn,
			),
			array(
				'name'            => $this->name . '_signin_btn',
				'type'            => 'checkbox',
				'section'         => $this->section, 
				'checkbox_label'  => esc_html__( 'Hide Signin Button', 'metafans' ),
				'render_callback' => $fn,
			),
			array(
				'name'            => $this->name . '_signin_btn_text',
				'type'            => 'text',
				'section'         => $this->section, 
				'default'		  => esc_html__( 'Sign In', 'metafans' ),
				'placeholder'     => esc_html__( 'Sign In', 'metafans' ),
				'selector'        => '.builder-item--' . $this->name . ' .user-account-segment button.button-signin',
				'title'  		  => esc_html__( 'Signin Button Text', 'metafans' ),
			),			
			array(
				'name'            => $this->name . '_signin_btn_style',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => 'body .builder-item--' . $this->name . ' .user-account-segment button.button-signin',
					'hover' => 'body .builder-item--' . $this->name . ' .user-account-segment button.button-signin:hover',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Signin Button Styling', 'metafans' ),
			),
			array(
				'name'            => $this->name . '_signin_btn_typo',
				'type'            => 'typography',
				'section'         => $this->section, 
				'selector'        => 'body .builder-item--' . $this->name . ' .user-account-segment button.button-signin', 
				'css_format'  	  => 'typography',
				'title'  => esc_html__( 'Signin Button Typography', 'metafans' ),
			),
			array(
				'name'            => $this->name . '_signup_btn_text',
				'type'            => 'text',
				'section'         => $this->section, 
				'default'		  => esc_html__( 'Sign Up', 'metafans' ),
				'placeholder'     => esc_html__( 'Sign Up', 'metafans' ),
				'selector'        => '.builder-item--' . $this->name . ' .user-account-segment button.button-signup',
				'title'  => esc_html__( 'Signup Button Text', 'metafans' ),
			),		
			array(
				'name'            => $this->name . '_signup_btn_style',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => 'body .builder-item--' . $this->name . ' .user-account-segment button.button-signup',
					'hover' => 'body .builder-item--' . $this->name . ' .user-account-segment button.button-signup:hover',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Signup Button Styling', 'metafans' ),
			),	
			array(
				'name'            => $this->name . '_signup_btn_typo',
				'type'            => 'typography',
				'section'         => $this->section, 
				'selector'        => 'body .builder-item--' . $this->name . ' .user-account-segment button.button-signup', 
				'css_format'  	  => 'typography',
				'title'  => esc_html__( 'Signup Button Typography', 'metafans' ),
			),
			array(
				'name'     => $this->section . '_profile_heading',
				'type'     => 'heading',
				'section'  => $this->section,
				'title'    => esc_html__( 'Profile Section', 'metafans' )
			),			
			array(
				'name'            => $this->name . '_avatar_size',
				'type'            => 'slider',
				'section'         => $this->section, 
				'selector'        => '.builder-item--' . $this->name . ' .user-account-segment img.avatar', 
				'css_format'  	  => 'width:{{value}}; height: {{value}}',
				'min'	 		  => 30,
				'max' 			  => 150,
				'title'  => esc_html__( 'Profile Avatar Size', 'metafans' ),
			),			
			array(
				'name'            => $this->name . '_avatar_br',
				'type'            => 'slider',
				'section'         => $this->section, 
				'selector'        => '.builder-item--' . $this->name . ' .user-account-segment img.avatar', 
				'css_format'  	  => 'border-radius:{{value}}',
				'min'	 		  => 0,
				'max' 			  => 100,
				'title'  => esc_html__( 'Avatar Border Radius', 'metafans' ),
			),			
			array(
				'name'            => $this->name . '_menu_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => '.builder-item--' . $this->name . ' .user-account-segment .loggedin-user-links', 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'User Menu Styling', 'metafans' ),
				'description'  => esc_html__( 'User Menu Dropdown Styling', 'metafans' ),
				'fields'      => array(
					'normal_fields' => array(
						'text_color'     => false,
						'link_color'     => false,
					),
					'hover_fields'  => false
				),
			),		
			array(
				'name'            => $this->name . '_menu_links_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => '.builder-item--' . $this->name . ' .user-account-segment .loggedin-user-links li a',
					'hover' => '.builder-item--' . $this->name . ' .user-account-segment .loggedin-user-links li a:hover',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Menu Links Styling', 'metafans' ),
				'description'  => esc_html__( 'User Dropdown Links Styling', 'metafans' ),
				'fields'      => array(
					'normal_fields' => array(
						'text_color' => false, // Disable for special field.
						'bg_image'       => false,
						'border_heading' => false,
						'border_color'   => false,
						'border_radius'  => false,
						'border_width'   => false,
						'border_style'   => false,
						'box_shadow'     => false,
					),
					'hover_fields'  => array(
						'text_color'     => false,
						'padding'        => false,
						'bg_heading'     => false,
						'bg_cover'       => false,
						'bg_image'       => false,
						'bg_repeat'      => false,
						'border_heading' => false,
						'border_color'   => false,
						'border_radius'  => false,
						'border_width'   => false,
						'border_style'   => false,
						'box_shadow'     => false,
					),
				),
			),
			array(
				'name'            => $this->name . '_menu_links_typo',
				'type'            => 'typography',
				'section'         => $this->section, 
				'selector'        => '.builder-item--' . $this->name . ' .user-account-segment .loggedin-user-links li a', 
				'css_format'  	  => 'typography',
				'title'  => esc_html__( 'Menu Links Typography', 'metafans' ),
				'description'  => esc_html__( 'User Dropdown Links Typography', 'metafans' ),
			),
			array(
				'name'            => $this->name . '_menu_links_count_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => '.builder-item--' . $this->name . ' .user-account-segment .loggedin-user-links li a span.count',
					'hover' => '.builder-item--' . $this->name . ' .user-account-segment .loggedin-user-links li a:hover span.count',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Menu Links Count', 'metafans' ),
				'description'  => esc_html__( 'Dropdown Links count Styling', 'metafans' ),
				'fields'      => array(
					'normal_fields' => array(
						'link_color' => false, // Disable for special field.
						'bg_image'       => false,
						'border_heading' => false,
						'border_color'   => false,
						'border_radius'  => false,
						'border_width'   => false,
						'border_style'   => false,
						'box_shadow'     => false,
					),
					'hover_fields'  => array(
						'text_color'     => false,
						'padding'        => false,
						'bg_heading'     => false,
						'bg_cover'       => false,
						'bg_image'       => false,
						'bg_repeat'      => false,
						'border_heading' => false,
						'border_color'   => false,
						'border_radius'  => false,
						'border_width'   => false,
						'border_style'   => false,
						'box_shadow'     => false,
					),
				),
			),
		);
		$is_wc_active = class_exists('woocommerce') ? true : false; 
		$is_lp_active = class_exists('LearnPress') ? true : false;
		$is_bp_active = class_exists('BuddyPress') ? true : false;

		if( $is_wc_active ){
			$config[] = array(
				'name'            => $this->name . '_show_wc_menu',
				'type'            => 'checkbox',
				'section'         => $this->section,
				'checkbox_label'  => esc_html__( 'Show WooCommerce Menus', 'metafans' ),
				'default' => 0,
				'render_callback' => $fn,
			);
		}
		if( $is_lp_active ){
			$config[] = array(
				'name'            => $this->name . '_show_lp_menu',
				'type'            => 'checkbox',
				'section'         => $this->section,
				'checkbox_label'  => esc_html__( 'Show LearnPress Menus', 'metafans' ),
				'default' => 1,
				'render_callback' => $fn,
			);
		}
		if( $is_bp_active ){
			$config[] = array(
				'name'            => $this->name . '_show_bp_menu',
				'type'            => 'checkbox',
				'section'         => $this->section,
				'checkbox_label'  => esc_html__( 'Show BuddyPress Menus', 'metafans' ),
				'default' => 1,
				'render_callback' => $fn,
			);
		}

		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}
	function wc_action_header( $is_wc_active, $is_logged_in ){
		$th_wc_header_menu = tophive_metafans()->get_setting( $this->name . '_show_wc_menu' );
		$wc_li = '';
		if( $is_wc_active && $th_wc_header_menu ){
			$my_account_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
			$wc_account_items = wc_get_account_menu_items();
			unset($wc_account_items['customer-logout']);
			foreach ($wc_account_items as $key => $value) {
				$wc_li .= '<li><a href="' . $my_account_url . $key . '">'. esc_attr($value) .'</a></li>'; 
			}
		}
	 	return $wc_li; 
	}
	function lp_action_header( $is_lp_active, $is_logged_in ){
		$th_lp_header_menu = tophive_metafans()->get_setting( $this->name . '_show_lp_menu' );
		$html = '';
		if( $is_lp_active && $th_lp_header_menu ){
			$profile  = learn_press_get_profile();
			foreach ( $profile->get_tabs()->tabs() as $tab_key => $tab_data ) {
				$slug        = $profile->get_slug( $tab_data, $tab_key );
				if( $tab_key == 'dashboard' ){
					$link        = $profile->get_tab_link( 'courses', true );
				}else{
					$link        = $profile->get_tab_link( $tab_key, true );
				}
				$tab_classes = array( esc_attr( $tab_key ) );
				$sections    = $tab_data['sections'];
				if ( $sections && sizeof( $sections ) > 1 ) {
					$tab_classes[] = 'has-child';
				}
				if ( $profile->is_current_tab( $tab_key ) ) {
					$tab_classes[] = 'active';
				} 
	            $html .= '<li class="' . join( ' ', $tab_classes ) . '" id="'. $tab_key .'">
	                <a href="'. esc_url( $link ) .'" data-slug="'. esc_attr( $slug ) .'">
						'. apply_filters( 'learn_press_profile_' . $tab_key . '_tab_title', esc_html( $tab_data['title'] ), $tab_key ) .'
	                </a>
	            </li>';
			}
		}
		return $html;
	}
	function bp_action_header( $is_bp_active, $is_logged_in ){

		if( !$is_bp_active ){
			return;
		}

		$th_bp_header_menu = tophive_metafans()->get_setting( $this->name . '_show_bp_menu' );

		$bbpress_query = new WP_Query( 
			array( 
				'author' 	=> get_current_user_id(),
				'post_type' => 'topic',
				'post_status' => 'publish',
				'posts_per_page' => -1
			)
		);	

		$user_display_name = get_the_author_meta( 'user_nicename', get_current_user_id() );
		$profile_url = site_url() . '/members/' . $user_display_name;

		$self_topics = $bbpress_query->found_posts;
		$groups_for_member = bp_is_active( 'groups' ) ? groups_get_user_groups( get_current_user_id() )['total'] : '';
		$friends_for_member = bp_is_active( 'friends' ) ?  friends_get_friend_count_for_user( get_current_user_id() ) : '';
		$messages = bp_is_active( 'messages' ) ? messages_get_unread_count( get_current_user_id() ) : '';

		$html = '';
		if( $is_bp_active && $th_bp_header_menu ){
			// Topics
			$html .= '<li><a href="'. $profile_url .'">'. esc_html__( 'Profile', 'metafans' ) . '</a></li>';
			$html .= '<li><a href="'. $profile_url .'/forums">'. esc_html__( 'Topics', 'metafans' ) . '<span class="count">' . $self_topics . '</span></a></li>';
			$html .= '<li><a href="'. $profile_url .'/groups">'. esc_html__( 'Groups', 'metafans' ) . '<span class="count">' . $groups_for_member . '</span></a></li>';
			$html .= '<li><a href="'. $profile_url .'/friends">'. esc_html__( 'Friends', 'metafans' ) . '<span class="count">' . $friends_for_member . '</span></a></li>';
			$html .= '<li><a href="'. $profile_url .'/messages">'. esc_html__( 'Messages', 'metafans' )  . '<span class="count">' . $messages . '</span></a></li>';
			$html .= '<li><a href="'. $profile_url .'/settings">'. esc_html__( 'Settings', 'metafans' ) . '</a></li>';
		}
		return preg_replace( array('#^<ul[^>]*>#', '#</ul>$#'), '', $html);
	}
	/**
	 * Optional. Render item content
	 */
	function render() {
		if( tophive_metafans()->get_setting( $this->section . '_loggedout_state' )){
			$is_logged_in = false;
		}else{
			$is_logged_in = is_user_logged_in();
		}
		$is_wc_active = class_exists('woocommerce') ? true : false; 
		$is_lp_active = class_exists('LearnPress') ? true : false;
		$is_bp_active = class_exists('BuddyPress') ? true : false;
		$user_nick_name = get_the_author_meta( 'display_name', get_current_user_id() );

		// User Display Picture
		$user_avatar = get_avatar( get_current_user_id());
		$user_dp = '';
		if( $user_avatar ){
			$user_dp = get_avatar( get_current_user_id(), 70, $default = '', $alt = '', $args = null );
		}else{
			$user_dp = '<span class="th-user-avatar-letter">'. $user_nick_name[0] .'</span>';
		}

		$user_header_section = '<div>';
		$user_header_section .= '<h6 class="ec-mb-0 ec-mt-2">' . esc_html__( 'Hello, ', 'metafans' ) . $user_nick_name .'</h6>';
		$user_header_section .= '<a href="'. wp_logout_url() .'">'. esc_html__( 'Logout', 'metafans' ) .'</a>';
		$user_header_section .= '</div>';

		$user_header_section_dd = '<div class="account-avatar">';
			$user_header_section_dd .= $user_dp;	
		$user_header_section_dd .= '</div>';

		$user_header_section_dd .= '<div class="account-diplay-name">';
			$user_header_section_dd .= '<h6 class="ec-mb-0 ec-mt-2">' . esc_html__( 'Hello, ', 'metafans' ) . $user_nick_name .'</h6>';
			if( $is_bp_active ){
				$user_header_section_dd .= '<p>'. str_replace('-', ' ', ucwords(bp_get_member_type( get_current_user_id(), true ))) .'</p>';
			}
		$user_header_section_dd .= '</div>';

		$user_dp = apply_filters( 'th_profile_header_dp', $user_dp );

		$loggedin_item = '<div>';
			$loggedin_item .= '<div class="ec-text-right user-loggedin">';
				$loggedin_item .= '<div>';
					$loggedin_item .= $user_dp;
				$loggedin_item .= '</div>';
				$loggedin_item .= '<div class="ec-w-75 user-header-section">';
					$loggedin_item .= $user_header_section;
				$loggedin_item .= '</div>';
			$loggedin_item .= '</div>';
			$loggedin_item .= '<ul class="loggedin-user-links">';
				$loggedin_item .= '<li class="user-account-dd-segment">'. $user_header_section_dd .'</li>';
				// $loggedin_item .= apply_filters( 'wc_user_loggedin_menu', $is_wc_active, $is_logged_in );
				$loggedin_item .= apply_filters( 'bp_user_loggedin_menu', $is_bp_active, $is_logged_in );
				// $loggedin_item .= apply_filters( 'lp_user_loggedin_menu', $is_lp_active, $is_logged_in );
				$loggedin_item .= '<li><a href="'. wp_logout_url() .'">'. esc_html__( 'Logout', 'metafans' ) .'</a></li>';
			$loggedin_item .= '</ul>';
		$loggedin_item .= '</div>';



		$signin_text = !empty(tophive_metafans()->get_setting( $this->name . '_signup_btn_text' )) ? tophive_metafans()->get_setting( $this->name . '_signin_btn_text' ) : esc_html__( 'Signin', 'metafans' );
		$signup_text = !empty(tophive_metafans()->get_setting( $this->name . '_signin_btn_text' )) ? tophive_metafans()->get_setting( $this->name . '_signup_btn_text' ) : esc_html__( 'Signup', 'metafans' );

		$loggedout_item  = '<div class="ec-d-flex signin-items">';
		if( !tophive_metafans()->get_setting( $this->name . '_signin_btn' ) ){
			$loggedout_item .= '<button class="button button-signin show-signin-form-modal">'. $signin_text .'</button>';
		}
		if( !tophive_metafans()->get_setting( $this->name . '_signup_btn' ) ){
			$loggedout_item .= '<button class="button button-signup show-signup-form-modal">'. $signup_text .'</button>';
		}
		$loggedout_item .= '</div>';

		/**
		 * Hook: tophive/builder_item/search-box/before_html
		 *
		 * @since 0.2.8
		 */

		do_action( 'tophive/builder_item/signin-signup/before_html' );
		$html = '<div class="header-' . esc_attr( $this->id ) . '-item item--' . esc_attr( $this->id ) . '">';
			$html .= '<div class="user-account-segment">';
			if($is_logged_in ){
				$html .= $loggedin_item;
			}else{
				$html .= $loggedout_item;
			}
			$html .= '</div>';

		$html .= '</div>';
		echo tophive_sanitize_filter($html);
		/**
		 * Hook: tophive/builder_item/search-box/after_html
		 *
		 * @since 0.2.8
		 */
		do_action( 'tophive/builder_item/signin-signup/after_html' );
	}
	function login_register_form(){
		?>
		<div class="tophive-popup-modal" id="tophive-signin-signup">
			
			<div class="tophive-popup-content-wrapper">
				<span class="ec-float-right tophive-popup-modal-close"><a href="">
					<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
					  <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
					</svg>
				</a></span>
				<div class="ec-d-block login-segment">
				    <?php 
						$signin_title = tophive_metafans()->get_setting('theme_globals_signin_form_title');
						if( !empty($signin_title) ){
							?>
							    <h3 class="ec-text-center ec-mb-4"><?php echo $signin_title; ?></h3>
						    <?php 
						}
				    	do_action( 'tophive/login/form' );
				    ?>
				</div>
				<div class="ec-d-block recover-segment">
				    <?php 
						$recover_form_title = tophive_metafans()->get_setting('theme_globals_recover_form_title');
						if( !empty($recover_form_title) ){
							?>
							    <h3 class="ec-text-center ec-mb-4"><?php echo $recover_form_title; ?></h3>
						    <?php 
						}else{
							?>
							<h3 class="ec-text-center ec-mb-4"><?php esc_html_e('Recover Password', 'metafans'); ?></h3>
							<?php
						}
				    	do_action( 'tophive/recover-pass/form' );
				    ?>
				</div>
				
				<?php if( get_option( 'users_can_register' ) ){ ?>
					<?php 

					?>
					<div class="ec-d-none signup-segment">
						<?php 
							$after_title_text = tophive_metafans()->get_setting('theme_globals_text_after_title');
							$signup_title = tophive_metafans()->get_setting('theme_globals_signup_form_title');
							if( !empty($signup_title) ){
								?>
								    <h3 class="ec-text-center ec-mb-4"><?php echo $signup_title; ?></h3>
							    <?php 
							}
					    	echo $after_title_text;
					    	do_action( 'tophive/registration/form' );
					    ?>

					</div>

				<?php } ?>

			</div>
		</div>
		<?php
	}
}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_Singin_Signup() );
