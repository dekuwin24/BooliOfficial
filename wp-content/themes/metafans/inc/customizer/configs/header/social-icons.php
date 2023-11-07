<?php

class Tophive_Builder_Item_Social_Icons {
	public $id = 'social-icons';
	public $section = 'header_social_icons';
	public $class = 'header-social-icons';
	public $selector = '';
	public $panel = 'header_settings';

	function __construct() {
		$this->selector = '.' . $this->class;
		add_filter( 'tophive/icon_used', array( $this, 'used_icon' ) );
	}

	function used_icon( $list = array() ) {
		$list[ $this->id ] = 1;

		return $list;
	}

	function item() {
		return array(
			'name'    => esc_html__( 'Social Icons', 'metafans' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	function customize() {
		$section  = $this->section;
		$prefix   = $this->section;
		$fn       = array( $this, 'render' );
		$selector = "{$this->selector}.tophive-builder-social-icons";
		$config   = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => $this->panel,
				'theme_supports' => '',
				'title'          => esc_html__( 'Social Icons', 'metafans' ),
			),

			array(
				'name'             => $prefix . '_items',
				'type'             => 'repeater',
				'section'          => $section,
				'selector'         => $this->selector,
				'render_callback'  => $fn,
				'title'            => esc_html__( 'Social Profiles', 'metafans' ),
				'live_title_field' => 'title',
				'default'          => array(
					array(
						'title' => 'Facebook',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-facebook',
						),
					),
					array(
						'title' => 'Twitter',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-twitter',
						),
					),
					array(
						'title' => 'Youtube',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-youtube-play',
						),
					),
					array(
						'title' => 'Instagram',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-instagram',
						),
					),
					array(
						'title' => 'Pinterest',
						'url'   => '#',
						'icon'  => array(
							'type' => 'font-awesome',
							'icon' => 'fa fa-pinterest',
						),
					),
				),
				'fields'           => array(
					array(
						'name'  => 'title',
						'type'  => 'text',
						'label' => esc_html__( 'Title', 'metafans' ),
					),
					array(
						'name'  => 'icon',
						'type'  => 'icon',
						'label' => esc_html__( 'Icon', 'metafans' ),
					),

					array(
						'name'  => 'url',
						'type'  => 'text',
						'label' => esc_html__( 'URL', 'metafans' ),
					),

				),
			),

			array(
				'name'            => $prefix . '_target',
				'type'            => 'checkbox',
				'section'         => $section,
				'selector'        => $this->selector,
				'render_callback' => $fn,
				'default'         => 1,
				'checkbox_label'  => esc_html__( 'Open link in a new tab.', 'metafans' ),
			),
			array(
				'name'            => $prefix . '_nofollow',
				'type'            => 'checkbox',
				'section'         => $section,
				'render_callback' => $fn,
				'default'         => 1,
				'checkbox_label'  => esc_html__( 'Adding rel="nofollow" for social links.', 'metafans' ),
			),

			array(
				'name'            => $prefix . '_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $section,
				'min'             => 10,
				'step'            => 1,
				'max'             => 100,
				'selector'        => 'format',
				'css_format'      => "$selector li a { font-size: {{value}}; }",
				'label'           => esc_html__( 'Size', 'metafans' ),
			),

			array(
				'name'            => $prefix . '_padding',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $section,
				'min'             => .1,
				'step'            => .1,
				'max'             => 5,
				'selector'        => "$selector li a",
				'unit'            => 'em',
				'css_format'      => 'padding: {{value_no_unit}}em;',
				'label'           => esc_html__( 'Padding', 'metafans' ),
			),

			array(
				'name'            => $prefix . '_spacing',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $section,
				'min'             => 0,
				'max'             => 30,
				'selector'        => "$selector li",
				'css_format'      => 'margin-left: {{value}}; margin-right: {{value}};',
				'label'           => esc_html__( 'Icon Spacing', 'metafans' ),
			),

			array(
				'name'            => $prefix . '_shape',
				'type'            => 'select',
				'section'         => $section,
				'selector'        => '.header-social-icons',
				'default'         => 'circle',
				'render_callback' => $fn,
				'title'           => esc_html__( 'Shape', 'metafans' ),
				'choices'         => array(
					'rounded' => esc_html__( 'Rounded', 'metafans' ),
					'square'  => esc_html__( 'Square', 'metafans' ),
					'circle'  => esc_html__( 'Circle', 'metafans' ),
					'none'    => esc_html__( 'None', 'metafans' ),
				),
			),

			array(
				'name'            => $prefix . '_color_type',
				'type'            => 'select',
				'section'         => $section,
				'selector'        => $this->selector,
				'default'         => 'default',
				'render_callback' => $fn,
				'title'           => esc_html__( 'Color', 'metafans' ),
				'choices'         => array(
					'default' => esc_html__( 'Official Color', 'metafans' ),
					'custom'  => esc_html__( 'Custom', 'metafans' ),
				),
			),

			array(
				'name'       => $prefix . '_custom_color',
				'type'       => 'modal',
				'section'    => $section,
				'selector'   => "{$this->selector} li a",
				'required'   => array( $prefix . '_color_type', '==', 'custom' ),
				'css_format' => 'styling',
				'title'      => esc_html__( 'Custom Color', 'metafans' ),
				'fields'     => array(
					'tabs'           => array(
						'default' => esc_html__( 'Normal', 'metafans' ),
						'hover'   => esc_html__( 'Hover', 'metafans' ),
					),
					'default_fields' => array(
						array(
							'name'       => 'primary',
							'type'       => 'color',
							'label'      => esc_html__( 'Background Color', 'metafans' ),
							'selector'   => "$selector.color-custom li a",
							'css_format' => 'background-color: {{value}};',
						),
						array(
							'name'       => 'secondary',
							'type'       => 'color',
							'label'      => esc_html__( 'Icon Color', 'metafans' ),
							'selector'   => "$selector.color-custom li a",
							'css_format' => 'color: {{value}};',
						),
					),
					'hover_fields'   => array(
						array(
							'name'       => 'primary',
							'type'       => 'color',
							'label'      => esc_html__( 'Background Color', 'metafans' ),
							'selector'   => "$selector.color-custom li a:hover",
							'css_format' => 'background-color: {{value}};',
						),
						array(
							'name'       => 'secondary',
							'type'       => 'color',
							'label'      => esc_html__( 'Icon Color', 'metafans' ),
							'selector'   => "$selector.color-custom li a:hover",
							'css_format' => 'color: {{value}};',
						),
					),
				),
			),

			array(
				'name'        => $prefix . '_border',
				'type'        => 'modal',
				'section'     => $section,
				'selector'    => "{$this->selector} li a",
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Border', 'metafans' ),
				'description' => esc_html__( 'Border & border radius', 'metafans' ),
				'fields'      => array(
					'tabs'           => array(
						'default' => '_',
					),
					'default_fields' => array(
						array(
							'name'       => 'border_style',
							'type'       => 'select',
							'class'      => 'clear',
							'label'      => esc_html__( 'Border Style', 'metafans' ),
							'default'    => 'none',
							'choices'    => array(
								''       => esc_html__( 'Default', 'metafans' ),
								'none'   => esc_html__( 'None', 'metafans' ),
								'solid'  => esc_html__( 'Solid', 'metafans' ),
								'dotted' => esc_html__( 'Dotted', 'metafans' ),
								'dashed' => esc_html__( 'Dashed', 'metafans' ),
								'double' => esc_html__( 'Double', 'metafans' ),
								'ridge'  => esc_html__( 'Ridge', 'metafans' ),
								'inset'  => esc_html__( 'Inset', 'metafans' ),
								'outset' => esc_html__( 'Outset', 'metafans' ),
							),
							'css_format' => 'border-style: {{value}};',
							'selector'   => "$selector li a",
						),

						array(
							'name'       => 'border_width',
							'type'       => 'css_ruler',
							'label'      => esc_html__( 'Border Width', 'metafans' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'selector'   => "$selector li a",
							'css_format' => array(
								'top'    => 'border-top-width: {{value}};',
								'right'  => 'border-right-width: {{value}};',
								'bottom' => 'border-bottom-width: {{value}};',
								'left'   => 'border-left-width: {{value}};',
							),
						),
						array(
							'name'       => 'border_color',
							'type'       => 'color',
							'label'      => esc_html__( 'Border Color', 'metafans' ),
							'required'   => array( 'border_style', '!=', 'none' ),
							'selector'   => "$selector li a",
							'css_format' => 'border-color: {{value}};',
						),

						array(
							'name'       => 'border_radius',
							'type'       => 'slider',
							'label'      => esc_html__( 'Border Radius', 'metafans' ),
							'selector'   => "$selector li a",
							'css_format' => 'border-radius: {{value}};',
						),
					),
				),
			),

		);

		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $section ) );
	}

	function render( $item_config = array() ) {

		$shape        = tophive_metafans()->get_setting( $this->section . '_shape', 'all' );
		$color_type   = tophive_metafans()->get_setting( $this->section . '_color_type' );
		$items        = tophive_metafans()->get_setting( $this->section . '_items' );
		$nofollow     = tophive_metafans()->get_setting( $this->section . '_nofollow' );
		$target_blank = tophive_metafans()->get_setting( $this->section . '_target' );

		$rel = '';
		if ( 1 == $nofollow ) {
			$rel = 'rel="nofollow" ';
		}

		$target = '_self';
		if ( 1 == $target_blank ) {
			$target = '_blank';
		}

		if ( ! empty( $items ) ) {
			$classes   = array();
			$classes[] = $this->class;
			$classes[] = 'tophive-builder-social-icons';
			if ( $shape ) {
				$shape = ' shape-' . sanitize_text_field( $shape );
			}
			if ( $color_type ) {
				$classes[] = 'color-' . sanitize_text_field( $color_type );
			}

			echo '<ul class="' . esc_attr( join( ' ', $classes ) ) . '">';
			foreach ( (array) $items as $index => $item ) {
				$item = wp_parse_args(
					$item,
					array(
						'title'       => '',
						'icon'        => '',
						'url'         => '',
						'_visibility' => '',
					)
				);

				if ( 'hidden' !== $item['_visibility'] ) {
					echo '<li>';
					if ( ! $item['url'] ) {
						$item['url'] = '#';
					}

					$icon = wp_parse_args(
						$item['icon'],
						array(
							'type' => '',
							'icon' => '',
						)
					);

					if ( $item['url'] && $icon['icon'] ) {
						echo '<a class="social-' . str_replace(
							array( ' ', 'fa-fa' ),
							array(
								'-',
								'icon',
							),
							esc_attr( $icon['icon'] )
						) . $shape . '" ' . $rel . 'target="' . esc_attr( $target ) . '" href="' . esc_url( $item['url'] ) . '">';
					}

					if ( $icon['icon'] ) {
						echo '<i class="icon ' . esc_attr( $icon['icon'] ) . '" title="' . esc_attr( $item['title'] ) . '"></i>';
					}

					if ( $item['url'] ) {
						echo '</a>';
					}
					echo '</li>';
				}
			}

			echo '</ul>';
		}

	}

}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_Social_Icons() );
