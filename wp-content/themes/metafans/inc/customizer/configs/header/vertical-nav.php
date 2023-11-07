<?php

class Tophive_Builder_Item_Vertical_Nav {
	public $id = 'vertical_nav';
	public $section = 'vertical_nav';
	public $name = 'vertical_nav';
	public $label = '';

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->label = esc_html__( 'Vertical Nav', 'metafans' );
		
		add_filter( 'body_class', array($this, 'v_nav_body_classes') );
		add_action( 'wp_footer', array( $this, 'render' ) );
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
				'name'            => $this->section . '_show',
				'type'            => 'checkbox',
				'section'         => $this->section,
				'default'         => 0,
				'checkbox_label'  => esc_html__( 'Show Vertical Nav', 'metafans' ),
				'selector'        => '.tophive-vertical-nav',
				'render_callback' => $fn,
			),
			array(
				'name'            => $this->section . '_vnav_icon',
				'type'            => 'image',
				'section'         => $this->section,
				'device_settings' => false,
				'selector'        => '.v-menu-toggler',
				'title'           => esc_html__( 'Nav icon', 'metafans' ),
				'render_callback' => $fn,
			),
			array(
				'name'            => $this->name . '_nav_menu__icon_size',
				'type'            => 'slider',
				'section'         => $this->section, 
				'selector'        => '.menu-icon-class', 
				'css_format'  	  => 'width:{{value}};',
				'min'	 		  => 10,
				'max' 			  => 100,
				'title'  => esc_html__( 'Icon Size', 'metafans' ),
			),
			array(
				'name'     => $this->section . '_con_style_heading',
				'type'     => 'heading',
				'section'  => $this->section,
				'title'    => esc_html__( 'Container Styling', 'metafans' )
			),
			array(
				'name'            => $this->name . '_container_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => '.tophive-vertical-nav',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Menu Links Styling', 'metafans' ),
				'description'  => esc_html__( 'User Dropdown Links Styling', 'metafans' ),
				'fields'      => array(
					'normal_fields' => array(
						'link_color' => false,
						'text_color' => false,
						'bg_image'       => false,
					),
					'hover_fields'  => false
				),
			),			
			array(
				'name'            => $this->name . '_nav_menu_width',
				'type'            => 'slider',
				'section'         => $this->section, 
				'selector'        => '.tophive-vertical-nav', 
				'css_format'  	  => 'width:{{value}};',
				'min'	 		  => 150,
				'max' 			  => 600,
				'title'  => esc_html__( 'Menu Width', 'metafans' ),
			),	

			array(
				'name'     => $this->section . '_menu_link_a',
				'type'     => 'heading',
				'section'  => $this->section,
				'title'    => esc_html__( 'Menu Items', 'metafans' )
			),
			array(
				'name'            => $this->name . '_menu_link_styling',
				'type'            => 'styling',
				'section'         => $this->section, 
				'selector'        => array(
					'normal' => 'body .tophive-vertical-nav ul li a',
					'hover' => 'body .tophive-vertical-nav ul li a:hover',
				), 
				'css_format'  	  => 'styling',
				'title'  => esc_html__( 'Menu links styling', 'metafans' ),
				'fields'      => array(
					'normal_fields' => array(
						'text_color' => false, // Disable for special field.
						'bg_heading'     => false,
						'bg_cover'       => false,
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
				'name'            => $this->name . '_menu_link_typo',
				'type'            => 'typography',
				'section'         => $this->section, 
				'selector'        => 'body .tophive-vertical-nav ul li a', 
				'css_format'  	  => 'typography',
				'title'  => esc_html__( 'Menu item typography', 'metafans' ),
			),			
			array(
				'name'            => $this->name . '_nav_menu_icon_size',
				'type'            => 'slider',
				'section'         => $this->section, 
				'selector'        => 'body .tophive-vertical-nav ul li a svg, body .tophive-vertical-nav ul li a img', 
				'css_format'  	  => 'width:{{value}}; height:{{value}}',
				'min'	 		  => 12,
				'max' 			  => 50,
				'title'  => esc_html__( 'Icon size', 'metafans' ),
			),			
			array(
				'name'            => $this->name . '_nav_menu_icon_spacing',
				'type'            => 'css_ruler',
				'section'         => $this->section, 
				'selector'        => '.tophive-vertical-nav a svg, .tophive-vertical-nav a img', 
				'css_format' => array(
					'top'    => 'margin-top: {{value}};',
					'right'  => 'margin-right: {{value}};',
					'bottom' => 'margin-bottom: {{value}};',
					'left'   => 'margin-left: {{value}};',
				),
				'title'  => esc_html__( 'Icon spacing', 'metafans' ),
			),
		);

		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}
	function v_nav_body_classes( $classes ){
		$show = tophive_metafans()->get_setting( 'vertical_nav_show' );
		if( $show ){
			$classes[] = 'v-nav-active';
     	}
	    return $classes;
	}
	/**
	 * Optional. Render item content
	 */
	function render() {
		/**
		 * Hook: tophive/builder_item/search-box/before_html
		 *
		 * @since 1.1.2
		 */

		$show = tophive_metafans()->get_setting( $this->section . '_show' );
		$icon = tophive_metafans()->get_setting( $this->section . '_vnav_icon' );

		if ( ! $show ) {
			return;
		}
		if ( !is_user_logged_in() ){
			return;
		}
		$menu_items = $this->get_menu_items_by_registered_slug('vertical-menu');
		do_action( 'tophive/builder_item/vertical-nav/before_html' );
		$html = '<div class="header-' . esc_attr( $this->id ) . '-item item--' . esc_attr( $this->id ) . '">';
			$html .= '<div class="tophive-vertical-nav">';
				$html .= '<span class="v-menu-toggler">';
				if( empty($icon['url']) ){
					$html .= '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#272a2b" stroke-width="1" stroke-linecap="round" stroke-linejoin="arcs"><path d="M21 9.5H7M21 4.5H3M21 14.5H3M21 19.5H7"/></svg>';

				}else{
					$html .= '<image class="menu-icon-class" src="'.$icon['url'].'" />';
				}
				$html .= '</span>';
				$html .= '<ul>';
				if( !empty($menu_items) ){
					foreach ($menu_items as $item) {
						$icon = get_post_meta( $item->ID, "_menu_item_menu-icon-text", true );
						$icon_type = $this->getRemoteMimeType($icon);
						if( $icon_type == 'svg' ){
							$arrContextOptions=array(
								"ssl"=>array(
									"verify_peer"=>false,
									"verify_peer_name"=>false,
								),
							);

							$get_icon = file_get_contents($icon,false, stream_context_create($arrContextOptions));
							$html .= '<li><a href="'. $item->url .'">' . $get_icon . '<span>' . $item->title . '</span><span class="hover">' . $item->title . '</span></a></li>';
						}else{
							$get_icon = !empty($icon) ? '<img src="' . $icon . '">' : '';
							$html .= '<li><a href="'. $item->url .'">'. $get_icon .'<span>'. $item->title . '</span><span class="hover">'. $item->title . '</span></a></li>';
						}
					}
				}
				$html .= '</ul>';
			$html .= '</div>';

		$html .= '</div>';
		echo tophive_sanitize_filter($html);
		/**
		 * Hook: tophive/builder_item/search-box/after_html
		 *
		 * @since 0.2.8
		 */
		do_action( 'tophive/builder_item/vertical-nav/after_html' );
	}
	function getRemoteMimeType($url) {
		$media_filename = basename($url);
		return pathinfo($media_filename, PATHINFO_EXTENSION);
	}
    function get_menu_items_by_registered_slug($menu_slug) {
	    $menu_items = array();
	    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_slug ] ) ) {
	        $menu = get_term( $locations[ $menu_slug ] );
	        $menu_items = wp_get_nav_menu_items($menu->term_id);
	    }
	    return $menu_items;
	}
}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_Vertical_Nav() );
