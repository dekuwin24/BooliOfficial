<?php

class Tophive_Builder_Item_Primary_Menu {
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;
	public $theme_location;

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->id             = 'primary-menu';
		$this->label          = esc_html__( 'Primary Menu', 'metafans' );
		$this->prefix         = 'primary_menu';
		$this->selector       = '.builder-item--' . $this->id . ' .nav-menu-desktop .primary-menu-ul';
		$this->section        = 'header_menu_primary';
		$this->theme_location = 'menu-1';
	}

	function item() {
		return array(
			'name'    => $this->label,
			'id'      => $this->id,
			'width'   => '6',
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	function customize() {
		$section = $this->section;
		$fn      = array( $this, 'render' );
		$config  = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'header_settings',
				'theme_supports' => '',
				'title'          => $this->label,
				'description'    => sprintf( esc_html__( 'Assign <a href="#menu_locations"  class="focus-section">Menu Location</a> for %1$s', 'metafans' ), $this->label ),
			),

			array(
				'name'            => $this->prefix . '_style',
				'type'            => 'image_select',
				'section'         => $section,
				'selector'        => '.builder-item--' . $this->id . " .{$this->id}",
				'render_callback' => $fn,
				'title'           => esc_html__( 'Menu Preset', 'metafans' ),
				'default'         => 'style-plain',
				'css_format'      => 'html_class',
				'choices'         => array(
					'style-plain'         => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_1.svg',
					),
					'style-full-height'   => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_2.svg',
					),
					'style-border-bottom' => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_3.svg',
					),
					'style-border-top'    => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/menu_style_4.svg',
					),
				),
			),

			array(
				'name'       => $this->prefix . '_style_border_h',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'max'        => 20,
				'title'      => esc_html__( 'Border Height', 'metafans' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li > a .link-before:before, .nav-menu-desktop.style-border-top .{$this->id}-ul > li > a .link-before:before  { height: {{value}}; }",
				'required'   => array(
					$this->prefix . '_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'       => $this->prefix . '_style_border_pos',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'min'        => - 50,
				'max'        => 50,
				'title'      => esc_html__( 'Border Position', 'metafans' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li > a .link-before:before { bottom: {{value}}; } .nav-menu-desktop.style-border-top .{$this->id}-ul > li > a .link-before:before { top: {{value}}; }",
				'required'   => array(
					$this->prefix . '_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'       => $this->prefix . '_style_border_color',
				'type'       => 'color',
				'section'    => $section,
				'selector'   => 'format',
				'title'      => esc_html__( 'Border Color', 'metafans' ),
				'css_format' => ".nav-menu-desktop.style-border-bottom .{$this->id}-ul > li:hover > a .link-before:before, 
                .nav-menu-desktop.style-border-bottom .{$this->id}-ul > li.current-menu-item > a .link-before:before, 
                .nav-menu-desktop.style-border-bottom .{$this->id}-ul > li.current-menu-ancestor > a .link-before:before,
                .nav-menu-desktop.style-border-top .{$this->id}-ul > li:hover > a .link-before:before,
                .nav-menu-desktop.style-border-top .{$this->id}-ul > li.current-menu-item > a .link-before:before, 
                .nav-menu-desktop.style-border-top .{$this->id}-ul > li.current-menu-ancestor > a .link-before:before
                { background-color: {{value}}; }",
				'required'   => array(
					$this->prefix . '_style',
					'in',
					array( 'style-border-bottom', 'style-border-top' ),
				),
			),

			array(
				'name'           => $this->prefix . '__hide-arrow',
				'type'           => 'checkbox',
				'section'        => $section,
				'selector'       => '.builder-item--' . $this->id . " .{$this->id}",
				'checkbox_label' => esc_html__( 'Hide menu dropdown arrow', 'metafans' ),
				'css_format'     => 'html_class',
			),

			array(
				'name'            => $this->prefix . '_arrow_size',
				'type'            => 'slider',
				'devices_setting' => true,
				'section'         => $section,
				'selector'        => 'format',
				'max'             => 20,
				'title'           => esc_html__( 'Arrow icon size', 'metafans' ),
				'css_format'      => ".builder-item--{$this->id} .nav-icon-angle { width: {{value}}; height: {{value}}; }",
				'required'        => array( $this->prefix . '__hide-arrow', '!=', 1 ),
			),

			array(
				'name'    => $this->prefix . '_top_heading',
				'type'    => 'heading',
				'section' => $section,
				'title'   => esc_html__( 'Top Menu', 'metafans' ),
			),

			array(
				'name'        => $this->prefix . '_item_styling',
				'type'        => 'styling',
				'section'     => $section,
				'title'       => esc_html__( 'Top Menu Items Styling', 'metafans' ),
				'description' => esc_html__( 'Styling for top level menu items', 'metafans' ),
				'selector'    => array(
					'normal'        => "{$this->selector} > li > a",
					'normal_margin' => "{$this->selector} > li",
					'hover'         => ".header--row:not(.header--transparent) {$this->selector} > li > a:hover, .header--row:not(.header--transparent) {$this->selector} > li > a:focus, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-item > a, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-item > a:focus, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-ancestor > a, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-ancestor > a:focus, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-parent > a, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-parent > a:focus",
				),
				'css_format'  => 'styling',
				'fields'      => array(
					'tabs'          => array(
						'normal' => esc_html__( 'Normal', 'metafans' ),
						'hover'  => esc_html__( 'Hover/Active', 'metafans' ),
					),
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
				),
			),

			array(
				'name'        => $this->prefix . '_typography',
				'type'        => 'typography',
				'section'     => $section,
				'title'       => esc_html__( 'Top Menu Items Typography', 'metafans' ),
				'description' => esc_html__( 'Typography for menu', 'metafans' ),
				'selector'    => "{$this->selector} > li > a,.builder-item-sidebar .primary-menu-sidebar .primary-menu-ul > li > a",
				'css_format'  => 'typography',
			),

			array(
				'name'        => $this->prefix . '_dd_item_styling',
				'type'        => 'styling',
				'section'     => $section,
				'title'       => esc_html__( 'Drop Menu Items Styling', 'metafans' ),
				'description' => esc_html__( 'Styling for dropdown menu items', 'metafans' ),
				'selector'    => array(
					'normal'        => "{$this->selector} > li > ul.sub-menu li a",
					'normal_margin' => "{$this->selector} > li > ul.sub-menu",
					'normal_bg_color' => "{$this->selector} > li ul.sub-menu",
					'normal_border_radius' => "{$this->selector} > li ul.sub-menu",
					'hover'         => ".header--row:not(.header--transparent) {$this->selector} > li > ul.sub-menu li a:hover, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-item > ul.sub-menu li a:hover, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-ancestor > ul.sub-menu li a:hover, .header--row:not(.header--transparent) {$this->selector} > li.current-menu-parent > ul.sub-menu li a:hover",
				),
				'css_format'  => 'styling',
				'fields'      => array(
					'tabs'          => array(
						'normal' => esc_html__( 'Normal', 'metafans' ),
						'hover'  => esc_html__( 'Hover/Active', 'metafans' ),
					),
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_position'   => false,
					),
				),
			),

			array(
				'name'        => $this->prefix . '_dd_typography',
				'type'        => 'typography',
				'section'     => $section,
				'title'       => esc_html__( 'Dropdown Menu Items Typography', 'metafans' ),
				'description' => esc_html__( 'Typography for dropdown menu', 'metafans' ),
				'selector'    => "{$this->selector} > li > ul.sub-menu li a, .builder-item-sidebar .primary-menu-sidebar .primary-menu-ul > li > ul.sub-menu li a",
				'css_format'  => 'typography',
			),
			array(
				'name'       => $this->prefix . '_dd_width',
				'type'       => 'slider',
				'section'    => $section,
				'selector'   => 'format',
				'min'        => 200,
				'max'        => 500,
				'title'      => esc_html__( 'Drop Down Width', 'metafans' ),
				'css_format' => "{$this->selector} > li ul.sub-menu  { width: {{value}}; }",
			),


		);

		$config = apply_filters( 'tophive/customize-menu-config-more', $config, $section, $this );

		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $section ) );
	}

	function menu_fallback_cb() {
		$pages = get_pages(
			array(
				'child_of'     => 0,
				'sort_order'   => 'ASC',
				'sort_column'  => 'menu_order, post_title',
				'hierarchical' => 0,
				'parent'       => 0,
				'exclude_tree' => array(),
				'number'       => 10,
			)
		);

		echo '<ul class="' . $this->id . '-ul menu nav-menu menu--pages">';
		foreach ( (array) $pages as $p ) {
			$class = '';
			if ( is_page( $p ) ) {
				$class = 'current-menu-item';
			}

			echo '<li id="menu-item--__id__-__device__-' . esc_attr( $p->ID ) . '" class="menu-item menu-item-type--page  menu-item-' . esc_attr( $p->ID . ' ' . $class ) . '"><a href="' . esc_url( get_the_permalink( $p ) ) . '"><span class="link-before">' . apply_filters( '', $p->post_title ) . '</span></a></li>';
		}
		echo '</ul>';
	}

	/**
	 * @see Walker_Nav_Menu
	 */
	function render() {
		$style = sanitize_text_field( tophive_metafans()->get_setting( $this->prefix . '_style' ) );
		if ( $style ) {
			$style = sanitize_text_field( $style );
		}

		$hide_arrow = sanitize_text_field( tophive_metafans()->get_setting( $this->prefix . '__hide-arrow' ) );
		if ( $hide_arrow ) {
			$style .= ' hide-arrow-active';
		}

		$container_classes = $this->id . ' ' . $this->id . '-__id__ nav-menu-__device__ ' . $this->id . '-__device__' . ( $style ? ' ' . $style : '' );
		echo '<nav class="site-navigation-__id__-__device__ site-navigation ' . $container_classes . '">';
		wp_nav_menu(
			array(
				'theme_location'  => $this->theme_location,
				'container'       => false,
				'container_id'    => false,
				'container_class' => false,
				'menu_id'         => 'site-navigation-__id__-__device__-' . $this->id,
				'menu_class'      => $this->id . '-ul menu nav-menu',
				'fallback_cb'     => '',
				'link_before'     => '<span class="link-before">',
				'link_after'      => '</span>',
			)
		);

		echo '</nav>';

	}
}

/**
 * Change menu item ID
 *
 * @see Walker_Nav_Menu::start_el();
 *
 * @param string $string_id
 * @param object $item
 * @param object $args An object of wp_nav_menu() arguments.
 *
 * @return mixed
 */
function tophive_change_nav_menu_item_id( $string_id, $item, $args ) {
	if ( 'menu-1' == $args->theme_location || 'menu-2' == $args->theme_location ) {
		$string_id = 'menu-item--__id__-__device__-' . $item->ID;
	}

	return $string_id;
}

add_filter( 'nav_menu_item_id', 'tophive_change_nav_menu_item_id', 55, 3 );


/**
 * Add Nav icon to menu
 *
 * @param string $title
 * @param object $item
 * @param array  $args
 * @param int    $depth
 *
 * @return string
 */
function tophive_add_icon_to_menu( $title, $item, $args, $depth ) {
	if ( in_array( 'menu-item-has-children', $item->classes ) ) { // phpcs:ignore
		$title .= '<span class="nav-icon-angle">&nbsp;</span>';

	}

	return $title;
}

add_filter( 'nav_menu_item_title', 'tophive_add_icon_to_menu', 25, 4 );

/**
 * Add more sub menu classes
 *
 * @since 0.1.1
 * @see   Walker_Nav_Menu::start_lvl
 *
 * @param array $classes
 * @param array $args
 * @param int   $depth
 *
 * @return array
 */
function tophive_add_sub_menu_classes( $classes, $args, $depth ) {
	$classes[] = 'sub-lv-' . $depth;

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tophive_add_sub_menu_classes', 35, 3 );

class Tophive_Builder_Item_Secondary_Menu extends Tophive_Builder_Item_Primary_Menu{
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;
	public $theme_location;

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->id             = 'secondary-menu';
		$this->label          = esc_html__( 'Secondary Menu', 'metafans' );
		$this->prefix         = 'secondary_menu';
		$this->selector       = '.builder-item--' . $this->id . ' .nav-menu-desktop .secondary-menu-ul';
		$this->section        = 'header_menu_secondary';
		$this->theme_location = 'menu-2';
	}
}


// Register header item.
Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_Primary_Menu() );
Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_Secondary_Menu() );
