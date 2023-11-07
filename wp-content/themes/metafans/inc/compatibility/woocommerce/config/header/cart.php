<?php

class Tophive_Builder_Item_WC_Cart {
	/**
	 * @var string Item Id.
	 */
	public $id = 'wc_cart'; // Required.
	/**
	 * @var string Section ID.
	 */
	public $section = 'wc_cart'; // Optional.
	/**
	 * @var string Item Name.
	 */
	public $name = 'wc_cart'; // Optional.
	/**
	 * @var string|void Item label.
	 */
	public $label = ''; // Optional.
	/**
	 * @var int Priority.
	 */
	public $priority = 200;
	/**
	 * @var string Panel ID.
	 */
	public $panel = 'header_settings';

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	public function __construct() {
		$this->label = esc_html__( 'Shopping Cart', 'metafans' );
	}

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	public function item() {
		return array(
			'name'    => $this->label,
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => $this->section, // Customizer section to focus when click settings.
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => $this->section,
				'type'     => 'section',
				'panel'    => $this->panel,
				'priority' => $this->priority,
				'title'    => $this->label,
			),

			array(
				'name'            => "{$this->name}_text",
				'type'            => 'text',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'title'           => esc_html__( 'Label', 'metafans' ),
				'default'         => esc_html__( 'Cart', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_icon",
				'type'            => 'icon',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => array(
					'icon' => 'fa fa-shopping-basket',
					'type' => 'font-awesome',
				),
				'title'           => esc_html__( 'Icon', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_icon_position",
				'type'            => 'select',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => 'after',
				'choices'         => array(
					'before' => esc_html__( 'Before', 'metafans' ),
					'after'  => esc_html__( 'After', 'metafans' ),
				),
				'title'           => esc_html__( 'Icon Position', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_link_to",
				'type'            => 'select',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => 'cart',
				'choices'         => array(
					'cart'     => esc_html__( 'Cart Page', 'metafans' ),
					'checkout' => esc_html__( 'Checkout', 'metafans' ),
				),
				'title'           => esc_html__( 'Link To', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_show_label",
				'type'            => 'checkbox',
				'default'         => array(
					'desktop' => 1,
					'tablet'  => 1,
					'mobile'  => 0,
				),
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'label'           => esc_html__( 'Show Label', 'metafans' ),
				'checkbox_label'  => esc_html__( 'Show Label', 'metafans' ),
				'device_settings' => true,
			),

			array(
				'name'            => "{$this->name}_show_sub_total",
				'type'            => 'checkbox',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'theme_supports'  => '',
				'label'           => esc_html__( 'Sub Total', 'metafans' ),
				'checkbox_label'  => esc_html__( 'Show Sub Total', 'metafans' ),
				'device_settings' => true,
				'default'         => array(
					'desktop' => 1,
					'tablet'  => 1,
					'mobile'  => 0,
				),
			),

			array(
				'name'            => "{$this->name}_show_qty",
				'type'            => 'checkbox',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => 1,
				'label'           => esc_html__( 'Quantity', 'metafans' ),
				'checkbox_label'  => esc_html__( 'Show Quantity', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_sep",
				'type'            => 'text',
				'section'         => $this->section,
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'title'           => esc_html__( 'Separator', 'metafans' ),
				'default'         => esc_html__( '/', 'metafans' ),
			),

			array(
				'name'       => "{$this->name}_label_styling",
				'type'       => 'styling',
				'section'    => $this->section,
				'title'      => esc_html__( 'Styling', 'metafans' ),
				'selector'   => array(
					'normal' => '.builder-header-' . $this->id . '-item .cart-item-link',
					'hover'  => '.builder-header-' . $this->id . '-item:hover .cart-item-link',
				),
				'css_format' => 'styling',
				'default'    => array(),
				'fields'     => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'margin'        => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

			array(
				'name'       => "{$this->name}_typography",
				'type'       => 'typography',
				'section'    => $this->section,
				'title'      => esc_html__( 'Typography', 'metafans' ),
				'selector'   => '.builder-header-' . $this->id . '-item',
				'css_format' => 'typography',
				'default'    => array(),
			),

			array(
				'name'    => "{$this->name}_icon_h",
				'type'    => 'heading',
				'section' => $this->section,
				'title'   => esc_html__( 'Icon Settings', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_icon_size",
				'type'            => 'slider',
				'section'         => $this->section,
				'device_settings' => true,
				'max'             => 150,
				'title'           => esc_html__( 'Icon Size', 'metafans' ),
				'selector'        => '.builder-header-' . $this->id . '-item .cart-icon i:before',
				'css_format'      => 'font-size: {{value}};',
				'default'         => array(),
			),

			array(
				'name'        => "{$this->name}_icon_styling",
				'type'        => 'styling',
				'section'     => $this->section,
				'title'       => esc_html__( 'Styling', 'metafans' ),
				'description' => esc_html__( 'Advanced styling for cart icon', 'metafans' ),
				'selector'    => array(
					'normal' => '.builder-item--'. $this->id .' .builder-header-' . $this->id . '-item .cart-item-link .cart-icon i',
					'hover'  => '.builder-item--'. $this->id .' .builder-header-' . $this->id . '-item:hover .cart-item-link .cart-icon i',
				),
				'css_format'  => 'styling',
				'default'     => array(),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

			array(
				'name'        => "{$this->name}_qty_styling",
				'type'        => 'styling',
				'section'     => $this->section,
				'title'       => esc_html__( 'Quantity', 'metafans' ),
				'description' => esc_html__( 'Advanced styling for cart quantity', 'metafans' ),
				'selector'    => array(
					'normal' => '.builder-item--'. $this->id .' .builder-header-' . $this->id . '-item  .cart-icon .cart-qty .tophive-wc-total-qty',
					'hover'  => '.builder-item--'. $this->id .' .builder-header-' . $this->id . '-item:hover .cart-icon .cart-qty .tophive-wc-total-qty',
				),
				'css_format'  => 'styling',
				'default'     => array(),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // disable for special field.
					),
				),
			),

			array(
				'name'    => "{$this->name}_d_h",
				'type'    => 'heading',
				'section' => $this->section,
				'title'   => esc_html__( 'Dropdown Settings', 'metafans' ),
			),

			array(
				'name'            => "{$this->name}_d_align",
				'type'            => 'select',
				'section'         => $this->section,
				'title'           => esc_html__( 'Dropdown Alignment', 'metafans' ),
				'selector'        => '.builder-header-' . $this->id . '-item',
				'render_callback' => $fn,
				'default'         => array(),
				'choices'         => array(
					'left'  => esc_html__( 'Left', 'metafans' ),
					'right' => esc_html__( 'Right', 'metafans' ),
				),
			),

			array(
				'name'            => "{$this->name}_d_width",
				'type'            => 'slider',
				'section'         => $this->section,
				'device_settings' => true,
				'min'             => 280,
				'max'             => 600,
				'title'           => esc_html__( 'Dropdown Width', 'metafans' ),
				'selector'        => '.builder-header-' . $this->id . '-item  .cart-dropdown-box',
				'css_format'      => 'width: {{value}};',
				'default'         => array(),
			),

		);

		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}

	function array_to_class( $array, $prefix ) {
		if ( ! is_array( $array ) ) {
			return $prefix . '-' . $array;
		}
		$classes = array();
		$array   = array_reverse( $array );
		foreach ( $array as $k => $v ) {
			if ( 1 == $v ) {
				$v = 'show';
			} elseif ( 0 == $v ) {
				$v = 'hide';
			}
			$classes[] = "{$prefix}-{$k}-{$v}";
		}

		return join( ' ', $classes );
	}

	/**
	 * Optional. Render item content
	 */
	public function render() {
		$icon          = tophive_metafans()->get_setting( "{$this->name}_icon" );
		$icon_position = tophive_metafans()->get_setting( "{$this->name}_icon_position" );
		$text          = tophive_metafans()->get_setting( "{$this->name}_text" );

		$show_label     = tophive_metafans()->get_setting( "{$this->name}_show_label", 'all' );
		$show_sub_total = tophive_metafans()->get_setting( "{$this->name}_show_sub_total", 'all' );
		$show_qty       = tophive_metafans()->get_setting( "{$this->name}_show_qty" );
		$sep            = tophive_metafans()->get_setting( "{$this->name}_sep" );
		$link_to        = tophive_metafans()->get_setting( "{$this->name}_link_to" );

		$classes = array();

		$align = tophive_metafans()->get_setting( "{$this->name}_d_align" );
		if ( ! $align ) {
			$align = 'right';
		}
		$classes[] = $this->array_to_class( $align, 'd-align' );

		$label_classes    = $this->array_to_class( $show_label, 'wc-cart' );
		$subtotal_classes = $this->array_to_class( $show_sub_total, 'wc-cart' );

		$icon = wp_parse_args(
			$icon,
			array(
				'type' => '',
				'icon' => '',
			)
		);

		$icon_html = '';
		if ( $icon['icon'] ) {
			$icon_html = '<i class="' . esc_attr( $icon['icon'] ) . '"></i> ';
		}

		if ( $text ) {
			$text = '<span class="cart-text cart-label ' . esc_attr( $label_classes ) . '">' . sanitize_text_field( $text ) . '</span>';
		}

		$sub_total  = WC()->cart->get_cart_subtotal();
		$quantities = WC()->cart->get_cart_item_quantities();

		$html = $text;

		if ( $sep && $html ) {
			$html .= '<span class="cart-sep cart-label ' . esc_attr( $label_classes ) . '">' . sanitize_text_field( $sep ) . '</span>';
		}
		$html .= '<span class="cart-subtotal cart-label ' . esc_attr( $subtotal_classes ) . '"><span class="tophive-wc-sub-total">' . $sub_total . '</span></span>';

		$qty   = array_sum( $quantities );
		$class = 'tophive-wc-total-qty';
		if ( $qty <= 0 ) {
			$class .= ' hide-qty';
		}

		if ( $icon_html ) {
			$icon_html = '<span class="cart-icon">' . $icon_html;
			if ( $show_qty ) {
				$icon_html .= '<span class="cart-qty"><span class="' . $class . '">' . array_sum( $quantities ) . '</span></span>';
			}
			$icon_html .= '</span>';
		}

		if ( 'before' == $icon_position ) {
			$html = $icon_html . $html;
		} else {
			$html = $html . $icon_html;
		}

		$classes[] = 'builder-header-' . $this->id . '-item';
		$classes[] = 'item--' . $this->id;

		$link = '';
		if ( 'checkout' == $link_to ) {
			$link = get_permalink( wc_get_page_id( 'checkout' ) );
		} else {
			$link = get_permalink( wc_get_page_id( 'cart' ) );
		}

		echo '<div class="' . esc_attr( join( ' ', $classes ) ) . '">';

		echo '<a href="' . esc_url( $link ) . '" class="cart-item-link text-uppercase text-small link-meta">';
		echo tophive_sanitize_filter($html); // WPCS: XSS OK.
		echo '</a>';

		add_filter( 'woocommerce_widget_cart_is_hidden', '__return_false', 999 );

		echo '<div class="cart-dropdown-box widget-area">';
		the_widget(
			'WC_Widget_Cart',
			array(
				'hide_if_empty' => 0,
			)
		);
		echo '</div>';

		// remove_filter( 'woocommerce_widget_cart_is_hidden', '__return_false', 999 );

		echo '</div>';
	}
}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_WC_Cart() );
