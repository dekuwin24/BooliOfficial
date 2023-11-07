<?php
/**
 * Tophive Theme Customizer
 *
 * @package tophive
 */
class  Tophive_Customizer {
	static $config;
	static $_instance;
	static $has_icon = false;
	static $has_font = false;
	public $devices = array( 'desktop', 'tablet', 'mobile' );
	private $selective_settings = array();

	function __construct() {

	}

	/**
	 * Main initial
	 */
	function init() {

		require_once get_template_directory() . '/inc/customizer/class-customizer-sanitize.php';
		require_once get_template_directory() . '/inc/customizer/class-customizer-auto-css.php';

		if ( is_admin() || is_customize_preview() ) {
			add_action( 'customize_register', array( $this, 'register' ), 666 );
			add_action( 'customize_preview_init', array( $this, 'preview_js' ) );
			add_action( 'wp_ajax_tophive/customizer/ajax/get_icons', array( $this, 'get_icons' ) );

			require_once get_template_directory() . '/inc/customizer/class-customizer-fonts.php';
			require_once get_template_directory() . '/inc/customizer/class-customizer.php';
		}

		add_action( 'wp_ajax_tophive__reset_section', array( 'Tophive_Customizer', 'reset_customize_section' ) );
	}

	/**
	 * Instance.
	 *
	 * @return Tophive_Customizer
	 */
	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Reset Customize section
	 */
	static function reset_customize_section() {
		if ( ! current_user_can( 'customize' ) ) {
			wp_send_json_error();
		}

		$settings = isset( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : array(); // phpcs:ignore

		foreach ( $settings as $k ) {
			$k = sanitize_text_field( $k );
			remove_theme_mod( $k );
		}

		wp_send_json_success();
	}

	/**
	 * Reset Customize section
	 */
	function get_icons() {
		if ( ! current_user_can( 'customize' ) ) {
			wp_send_json_error();
		}

		require_once get_template_directory() . '/inc/customizer/class-customizer-icons.php';
		wp_send_json_success( Tophive_Font_Icons::get_instance()->get_icons() );
		die();
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	function preview_js() {
		if ( is_customize_preview() ) {
			$suffix = tophive_metafans()->get_asset_suffix();

			wp_enqueue_script( 'tophive-customizer-auto-css', esc_url( get_template_directory_uri() ) . '/assets/js/customizer/auto-css' . $suffix . '.js', array( 'customize-preview' ), '20151215', true );
			wp_enqueue_script(
				'tophive-customizer',
				esc_url( get_template_directory_uri() ) . '/assets/js/customizer/customizer' . $suffix . '.js',
				array(
					'customize-preview',
					'customize-selective-refresh',
				),
				'20151215',
				true
			);
			wp_localize_script(
				'tophive-customizer-auto-css',
				'Tophive_Preview_Config',
				array(
					'fields'         => $this->get_config(),
					'devices'        => $this->devices,
					'typo_fields'    => $this->get_typo_fields(),
					'styling_config' => $this->get_styling_config(),
				)
			);
		}
	}

	/**
	 * Get all customizer settings/control that added via `tophive/customizer/config` hook
	 *
	 *  Ensure you call this method after all config files loaded
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return array
	 */
	static function get_config( $wp_customize = null ) {
		if ( is_null( self::$config ) ) {

			$_config = apply_filters( 'tophive/customizer/config', array(), $wp_customize );
			$config  = array();
			foreach ( $_config as $f ) {

				$f = wp_parse_args(
					$f,
					array(

						'priority'    => null,
						'title'       => null,
						'label'       => null,
						'name'        => null,
						'type'        => null,
						'description' => null,
						'capability'  => null,
						'mod'         => null, // Can be theme_mod or option, default theme_mod.
						'settings'    => null,

						'active_callback'      => null, // For control.

						/**
						 * For settings
						 */
						'sanitize_callback'    => array( 'Tophive_Sanitize_Input', 'sanitize_customizer_input' ),
						'sanitize_js_callback' => null,
						'theme_supports'       => null,
						'default'              => null,

						/**
						 * For selective refresh
						 */
						'selector'             => null,
						'render'               => null, // same render_callback.
						'render_callback'      => null,
						'css_format'           => null,

						'device'          => null,
						'device_settings' => null,

						'field_class' => null, // Custom class for control.
					)
				);

				if ( ! isset( $f['type'] ) ) {
					$f['type'] = null;
				}

				switch ( $f['type'] ) {
					case 'panel':
						$config[ 'panel|' . $f['name'] ] = $f;
						break;
					case 'section':
						$config[ 'section|' . $f['name'] ] = $f;
						break;
					default:
						if ( 'icon' == $f['type'] ) {
							self::$has_icon = true;
						}

						if ( 'font' == $f['type'] ) {
							self::$has_font = true;
						}

						if ( isset( $f['fields'] ) ) {
							if ( ! in_array( $f['type'], array( 'typography', 'styling', 'modal' ) ) ) { //phpcs:ignore
								$types = wp_list_pluck( $f['fields'], 'type' );
								if ( in_array( 'icon', $types ) ) { //phpcs:ignore
									self::$has_icon = true;
								}

								if ( in_array( 'font', $types ) ) { //phpcs:ignore
									self::$has_font = true;
								}
							}
						}

						$config[ 'setting|' . $f['name'] ] = $f;

				}
			}

			self::$config = $config;
		}

		return self::$config;
	}

	/**
	 * Check if has icon field;
	 *
	 * @return bool
	 */
	function has_icon() {
		return self::$has_icon;
	}

	/**
	 * Check if has font field;
	 *
	 * @return bool
	 */
	function has_font() {
		return self::$has_icon;
	}

	/**
	 *  Get Customizer setting.
	 *
	 * @param string      $name   Customize setting id.
	 * @param string      $device Device type for settings.
	 * @param string|bool $key    Value of this array key that you want to get.
	 *
	 * @return array|bool|string
	 */
	function get_setting( $name, $device = 'desktop', $key = false ) {
		$config    = self::get_config();
		$get_value = null;
		if ( isset( $config[ 'setting|' . $name ] ) ) {
			$default = isset( $config[ 'setting|' . $name ]['default'] ) ? $config[ 'setting|' . $name ]['default'] : false;
			$default = apply_filters( 'tophive/customize/settings-default', $default, $name );

			if ( 'option' == $config[ 'setting|' . $name ]['mod'] ) {
				$value = get_option( $name, $default );
			} else {
				$value = get_theme_mod( $name, $default );
			}

			// Maybe need merge defined items with saved item for defined list.
			if (
				'repeater' == $config[ 'setting|' . $name ]['type']
				&& isset( $config[ 'setting|' . $name ]['addable'] )
				&& false == $config[ 'setting|' . $name ]['addable']
			) {
				$value = self::merge_items( $value, $default );
			}

			if ( ! $config[ 'setting|' . $name ]['device_settings'] ) {
				return $value;
			}
		} else {
			$value = get_theme_mod( $name, null );
		}

		if ( ! $key ) {
			if ( 'all' != $device ) {
				if ( is_array( $value ) && isset( $value[ $device ] ) ) {
					$get_value = $value[ $device ];
				} else {
					$get_value = $value;
				}
			} else {
				$get_value = $value;
			}
		} else {
			$value_by_key = isset( $value[ $key ] ) ? $value[ $key ] : false;
			if ( 'all' != $device && is_array( $value_by_key ) ) {
				if ( is_array( $value_by_key ) && isset( $value_by_key[ $device ] ) ) {
					$get_value = $value_by_key[ $device ];
				} else {
					$get_value = $value_by_key;
				}
			} else {
				$get_value = $value_by_key;
			}
		}

		return $get_value;
	}


	/**
	 * Merge 2 array width `_key` is key of each item
	 *
	 * @since 0.2.5
	 *
	 * @param array $destination
	 * @param array $new_array
	 *
	 * @return array
	 */
	public static function merge_items( $destination = array(), $new_array = array() ) {

		$keys     = array();
		$new_keys = array();

		foreach ( $destination as $item ) {
			if ( isset( $item['_key'] ) ) {
				$keys[ $item['_key'] ] = $item['_key'];
			}
		}

		if ( empty( $keys ) ) {
			return $destination;
		}

		// Add item if it not in saved list.
		foreach ( $new_array as $item ) {
			if ( isset( $item['_key'] ) ) {
				$new_keys[ $item['_key'] ] = $item['_key'];
				if ( ! isset( $keys[ $item['_key'] ] ) ) {
					$destination[] = $item;
				}
			}
		}

		// Remove the item not in the defined list.
		$new_destination = array();
		foreach ( $destination as $_dk => $item ) {
			if ( isset( $item['_key'] ) ) {
				if ( isset( $new_keys[ $item['_key'] ] ) ) {
					$new_destination[] = $item;
				}
			} else {
				$new_destination[] = $item;
			}
		}

		return $new_destination;
	}

	/**
	 * Get customizer setting data when the field type is `modal`
	 *
	 * @param string      $name Setting name.
	 * @param string|bool $tab  String tab name.
	 *
	 * @return array|bool
	 */
	function get_setting_tab( $name, $tab = null ) {
		$values = $this->get_setting( $name, 'all' );
		if ( ! $tab ) {
			return $values;
		}
		if ( is_array( $values ) && isset( $values[ $tab ] ) ) {
			return $values[ $tab ];
		}

		return false;
	}

	/**
	 * Get typography fields
	 *
	 * @return array
	 */
	function get_typo_fields() {
		$typo_fields = array(
			array(
				'name'    => 'font',
				'type'    => 'select',
				'label'   => esc_html__( 'Font Family', 'metafans' ),
				'choices' => array(),
			),
			array(
				'name'    => 'font_weight',
				'type'    => 'select',
				'label'   => esc_html__( 'Font Weight', 'metafans' ),
				'choices' => array(),
			),
			array(
				'name'  => 'languages',
				'type'  => 'checkboxes',
				'label' => esc_html__( 'Font Languages', 'metafans' ),
			),
			array(
				'name'            => 'font_size',
				'type'            => 'slider',
				'label'           => esc_html__( 'Font Size', 'metafans' ),
				'device_settings' => true,
				'min'             => 9,
				'max'             => 80,
				'step'            => 1,
			),
			array(
				'name'            => 'line_height',
				'type'            => 'slider',
				'label'           => esc_html__( 'Line Height', 'metafans' ),
				'device_settings' => true,
				'min'             => 9,
				'max'             => 80,
				'step'            => 1,
			),
			array(
				'name'  => 'letter_spacing',
				'type'  => 'slider',
				'label' => esc_html__( 'Letter Spacing', 'metafans' ),
				'min'   => - 10,
				'max'   => 10,
				'step'  => 0.1,
			),
			array(
				'name'    => 'style',
				'type'    => 'select',
				'label'   => esc_html__( 'Font Style', 'metafans' ),
				'choices' => array(
					''        => esc_html__( 'Default', 'metafans' ),
					'normal'  => esc_html__( 'Normal', 'metafans' ),
					'italic'  => esc_html__( 'Italic', 'metafans' ),
					'oblique' => esc_html__( 'Oblique', 'metafans' ),
				),
			),
			array(
				'name'    => 'text_decoration',
				'type'    => 'select',
				'label'   => esc_html__( 'Text Decoration', 'metafans' ),
				'choices' => array(
					''             => esc_html__( 'Default', 'metafans' ),
					'underline'    => esc_html__( 'Underline', 'metafans' ),
					'overline'     => esc_html__( 'Overline', 'metafans' ),
					'line-through' => esc_html__( 'Line through', 'metafans' ),
					'none'         => esc_html__( 'None', 'metafans' ),
				),
			),
			array(
				'name'    => 'text_transform',
				'type'    => 'select',
				'label'   => esc_html__( 'Text Transform', 'metafans' ),
				'choices' => array(
					''           => esc_html__( 'Default', 'metafans' ),
					'uppercase'  => esc_html__( 'Uppercase', 'metafans' ),
					'lowercase'  => esc_html__( 'Lowercase', 'metafans' ),
					'capitalize' => esc_html__( 'Capitalize', 'metafans' ),
					'none'       => esc_html__( 'None', 'metafans' ),
				),
			),
		);

		return $typo_fields;
	}

	/**
	 * Get styling field
	 *
	 * @return array
	 */
	function get_styling_config() {
		$fields = array(
			'tabs'          => array(
				'normal' => esc_html__( 'Normal', 'metafans' ),  // null or false to disable.
				'hover'  => esc_html__( 'Hover', 'metafans' ), // null or false to disable.
			),
			'normal_fields' => array(
				array(
					'name'       => 'text_color',
					'type'       => 'color',
					'label'      => esc_html__( 'Color', 'metafans' ),
					'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
				),
				array(
					'name'       => 'link_color',
					'type'       => 'color',
					'label'      => esc_html__( 'Link Color', 'metafans' ),
					'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
				),

				array(
					'name'            => 'margin',
					'type'            => 'css_ruler',
					'device_settings' => true,
					'css_format'      => array(
						'top'    => 'margin-top: {{value}};',
						'right'  => 'margin-right: {{value}};',
						'bottom' => 'margin-bottom: {{value}};',
						'left'   => 'margin-left: {{value}};',
					),
					'label'           => esc_html__( 'Margin', 'metafans' ),
				),

				array(
					'name'            => 'padding',
					'type'            => 'css_ruler',
					'device_settings' => true,
					'css_format'      => array(
						'top'    => 'padding-top: {{value}};',
						'right'  => 'padding-right: {{value}};',
						'bottom' => 'padding-bottom: {{value}};',
						'left'   => 'padding-left: {{value}};',
					),
					'label'           => esc_html__( 'Padding', 'metafans' ),
				),

				array(
					'name'  => 'bg_heading',
					'type'  => 'heading',
					'label' => esc_html__( 'Background', 'metafans' ),
				),

				array(
					'name'       => 'bg_color',
					'type'       => 'color',
					'label'      => esc_html__( 'Background Color', 'metafans' ),
					'css_format' => 'background-color: {{value}};',
				),
				array(
					'name'       => 'bg_image',
					'type'       => 'image',
					'label'      => esc_html__( 'Background Image', 'metafans' ),
					'css_format' => 'background-image: url("{{value}}");',
				),
				array(
					'name'       => 'bg_cover',
					'type'       => 'select',
					'choices'    => array(
						''        => esc_html__( 'Default', 'metafans' ),
						'auto'    => esc_html__( 'Auto', 'metafans' ),
						'cover'   => esc_html__( 'Cover', 'metafans' ),
						'contain' => esc_html__( 'Contain', 'metafans' ),
					),
					'required'   => array( 'bg_image', 'not_empty', '' ),
					'label'      => esc_html__( 'Size', 'metafans' ),
					'class'      => 'field-half-left',
					'css_format' => '-webkit-background-size: {{value}}; -moz-background-size: {{value}}; -o-background-size: {{value}}; background-size: {{value}};',
				),
				array(
					'name'       => 'bg_position',
					'type'       => 'select',
					'label'      => esc_html__( 'Position', 'metafans' ),
					'required'   => array( 'bg_image', 'not_empty', '' ),
					'class'      => 'field-half-right',
					'choices'    => array(
						''              => esc_html__( 'Default', 'metafans' ),
						'center'        => esc_html__( 'Center', 'metafans' ),
						'top left'      => esc_html__( 'Top Left', 'metafans' ),
						'top right'     => esc_html__( 'Top Right', 'metafans' ),
						'top center'    => esc_html__( 'Top Center', 'metafans' ),
						'bottom left'   => esc_html__( 'Bottom Left', 'metafans' ),
						'bottom center' => esc_html__( 'Bottom Center', 'metafans' ),
						'bottom right'  => esc_html__( 'Bottom Right', 'metafans' ),
					),
					'css_format' => 'background-position: {{value}};',
				),
				array(
					'name'       => 'bg_repeat',
					'type'       => 'select',
					'label'      => esc_html__( 'Repeat', 'metafans' ),
					'class'      => 'field-half-left',
					'required'   => array(
						array( 'bg_image', 'not_empty', '' ),
					),
					'choices'    => array(
						'repeat'    => esc_html__( 'Default', 'metafans' ),
						'no-repeat' => esc_html__( 'No repeat', 'metafans' ),
						'repeat-x'  => esc_html__( 'Repeat horizontal', 'metafans' ),
						'repeat-y'  => esc_html__( 'Repeat vertical', 'metafans' ),
					),
					'css_format' => 'background-repeat: {{value}};',
				),

				array(
					'name'       => 'bg_attachment',
					'type'       => 'select',
					'label'      => esc_html__( 'Attachment', 'metafans' ),
					'class'      => 'field-half-right',
					'required'   => array(
						array( 'bg_image', 'not_empty', '' ),
					),
					'choices'    => array(
						''       => esc_html__( 'Default', 'metafans' ),
						'scroll' => esc_html__( 'Scroll', 'metafans' ),
						'fixed'  => esc_html__( 'Fixed', 'metafans' ),
					),
					'css_format' => 'background-attachment: {{value}};',
				),

				array(
					'name'  => 'border_heading',
					'type'  => 'heading',
					'label' => esc_html__( 'Border', 'metafans' ),
				),

				array(
					'name'       => 'border_style',
					'type'       => 'select',
					'class'      => 'clear',
					'label'      => esc_html__( 'Border Style', 'metafans' ),
					'default'    => '',
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
				),

				array(
					'name'       => 'border_width',
					'type'       => 'css_ruler',
					'label'      => esc_html__( 'Border Width', 'metafans' ),
					'required'   => array(
						array( 'border_style', '!=', 'none' ),
						array( 'border_style', '!=', '' ),
					),
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
					'required'   => array(
						array( 'border_style', '!=', 'none' ),
						array( 'border_style', '!=', '' ),
					),
					'css_format' => 'border-color: {{value}};',
				),

				array(
					'name'       => 'border_radius',
					'type'       => 'css_ruler',
					'label'      => esc_html__( 'Border Radius', 'metafans' ),
					'css_format' => array(
						'top'    => 'border-top-left-radius: {{value}};',
						'right'  => 'border-top-right-radius: {{value}};',
						'bottom' => 'border-bottom-right-radius: {{value}};',
						'left'   => 'border-bottom-left-radius: {{value}};',
					),
				),

				array(
					'name'       => 'box_shadow',
					'type'       => 'shadow',
					'label'      => esc_html__( 'Box Shadow', 'metafans' ),
					'css_format' => 'box-shadow: {{value}};',
				),

			),

			'hover_fields' => array(
				array(
					'name'       => 'text_color',
					'type'       => 'color',
					'label'      => esc_html__( 'Color', 'metafans' ),
					'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
				),
				array(
					'name'       => 'link_color',
					'type'       => 'color',
					'label'      => esc_html__( 'Link Color', 'metafans' ),
					'css_format' => 'color: {{value}}; text-decoration-color: {{value}};',
				),
				array(
					'name'  => 'bg_heading',
					'type'  => 'heading',
					'label' => esc_html__( 'Background', 'metafans' ),
				),
				array(
					'name'       => 'bg_color',
					'type'       => 'color',
					'label'      => esc_html__( 'Background Color', 'metafans' ),
					'css_format' => 'background-color: {{value}};',
				),
				array(
					'name'  => 'border_heading',
					'type'  => 'heading',
					'label' => esc_html__( 'Border', 'metafans' ),
				),
				array(
					'name'       => 'border_style',
					'type'       => 'select',
					'label'      => esc_html__( 'Border Style', 'metafans' ),
					'default'    => '',
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
				),
				array(
					'name'       => 'border_width',
					'type'       => 'css_ruler',
					'label'      => esc_html__( 'Border Width', 'metafans' ),
					'required'   => array( 'border_style', '!=', 'none' ),
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
					'css_format' => 'border-color: {{value}};',
				),
				array(
					'name'       => 'border_radius',
					'type'       => 'css_ruler',
					'label'      => esc_html__( 'Border Radius', 'metafans' ),
					'css_format' => array(
						'top'    => 'border-top-left-radius: {{value}};',
						'right'  => 'border-top-right-radius: {{value}};',
						'bottom' => 'border-bottom-right-radius: {{value}};',
						'left'   => 'border-bottom-left-radius: {{value}};',
					),
				),
				array(
					'name'       => 'box_shadow',
					'type'       => 'shadow',
					'label'      => esc_html__( 'Box Shadow', 'metafans' ),
					'css_format' => 'box-shadow: {{value}};',
				),

			),

		);

		return apply_filters( 'tophive/get_styling_config', $fields );
	}

	/**
	 * Setup icon args
	 *
	 * @param array $icon
	 *
	 * @return array
	 */
	function setup_icon( $icon ) {
		if ( ! is_array( $icon ) ) {
			$icon = array();
		}

		return wp_parse_args(
			$icon,
			array(
				'type' => '',
				'icon' => '',
			)
		);
	}

	/**
	 * Get customize setting data
	 *
	 * @param string $key Setting name.
	 *
	 * @return bool|mixed
	 */
	function get_field_setting( $key ) {
		$config = self::get_config();
		if ( isset( $config[ 'setting|' . $key ] ) ) {
			return $config[ 'setting|' . $key ];
		}

		return false;
	}

	/**
	 * Get Media url from data
	 *
	 * @param string/array $value   media data.
	 * @param null|string  $size WordPress image size name.
	 *
	 * @return string|false Media url or empty
	 */
	function get_media( $value, $size = null ) {

		if ( empty( $value ) ) {
			return false;
		}

		if ( ! $size ) {
			$size = 'full';
		}

		if ( is_numeric( $value ) ) {
			$image_attributes = wp_get_attachment_image_src( $value, $size );
			if ( $image_attributes ) {
				return $image_attributes[0];
			} else {
				return false;
			}
		} elseif ( is_string( $value ) ) {
			$img_id = attachment_url_to_postid( $value );
			if ( $img_id ) {
				$image_attributes = wp_get_attachment_image_src( $img_id, $size );
				if ( $image_attributes ) {
					return $image_attributes[0];
				} else {
					return false;
				}
			}

			return $value;
		} elseif ( is_array( $value ) ) {
			$value = wp_parse_args(
				$value,
				array(
					'id'   => '',
					'url'  => '',
					'mime' => '',
				)
			);

			if ( empty( $value['id'] ) && empty( $value['url'] ) ) {
				return false;
			}

			$url = '';

			if ( strpos( $value['mime'], 'image/' ) !== false ) {
				$image_attributes = wp_get_attachment_image_src( $value['id'], $size );
				if ( $image_attributes ) {
					$url = $image_attributes[0];
				}
			} else {
				$url = wp_get_attachment_url( $value['id'] );
			}

			if ( ! $url ) {
				$url = $value['url'];
				if ( $url ) {
					$img_id = attachment_url_to_postid( $url );
					if ( $img_id ) {
						return wp_get_attachment_url( $img_id );
					}
				}
			}

			return $url;
		}

		return false;
	}

	/**
	 * Load support controls
	 */
	function load_controls() {
		$fields = array(
			'base',
			'select',
			'font',
			'font_style',
			'text_align',
			'text_align_no_justify',
			'checkbox',
			'css_ruler',
			'shadow',
			'icon',
			'slider',
			'color',
			'textarea',
			'radio',

			'media',
			'image',
			'video',

			'text',
			'hidden',
			'heading',
			'typography',
			'modal',
			'styling',
			'hr',

			'repeater',

			'pro',
		);

		$fields = apply_filters( 'tophive/customize/register-controls', $fields );

		foreach ( $fields as $k => $f ) {

			if ( is_numeric( $k ) ) {
				$field_type = $f;
				$file       = get_template_directory() . '/inc/customizer/controls/class-control-' . str_replace( '_', '-', $field_type ) . '.php';
			} else {
				$field_type = $k;
				$file       = $f;
			}

			if ( file_exists( $file ) ) {

				$control_class_name = 'Tophive_Customizer_Control_';
				$tpl_type           = str_replace( '_', ' ', $field_type );
				$tpl_type           = str_replace( ' ', '_', ucfirst( $tpl_type ) );
				$control_class_name .= $tpl_type;
				require_once $file;

				if ( $control_class_name ) {
					if ( method_exists( $control_class_name, 'field_template' ) ) {
						add_action(
							'customize_controls_print_footer_scripts',
							array(
								$control_class_name,
								'field_template',
							)
						);
					}
				}
			}
		}

	}


	/**
	 * Register Customize Settings
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager.
	 */
	function register( $wp_customize ) {

		// Custom panel.
		require_once get_template_directory() . '/inc/customizer/class-tophive-panel.php';
		// Load custom section.
		require_once get_template_directory() . '/inc/customizer/class-tophive-section.php';

		// Register new panel and section type.
		$wp_customize->register_panel_type( 'Tophive_WP_Customize_Panel' );
		$wp_customize->register_section_type( 'Tophive_WP_Customize_Section' );

		$this->load_controls();

		foreach ( self::get_config( $wp_customize ) as $args ) {
			switch ( $args['type'] ) {
				case 'panel':
					$name = $args['name'];
					unset( $args['name'] );
					if ( ! $args['title'] ) {
						$args['title'] = $args['label'];
					}
					if ( ! $name ) {
						$name = $args['title'];
					}
					unset( $args['name'] );
					unset( $args['type'] );
					$panel = new Tophive_WP_Customize_Panel( $wp_customize, $name, $args );
					$wp_customize->add_panel( $panel );
					break;
				case 'section':
					$name = $args['name'];
					unset( $args['name'] );
					if ( ! $args['title'] ) {
						$args['title'] = $args['label'];
					}
					if ( ! $name ) {
						$name = $args['title'];
					}
					unset( $args['name'] );
					unset( $args['type'] );
					if ( isset( $args['section_class'] ) && class_exists( $args['section_class'] ) ) { // Allow custom class.
						$wp_customize->add_section( new $args['section_class']( $wp_customize, $name, $args ) );
					} else {
						$wp_customize->add_section( new Tophive_WP_Customize_Section( $wp_customize, $name, $args ) );
					}

					break;
				default:
					switch ( $args['type'] ) {
						case 'image_select':
							$args['setting_type'] = 'radio';
							$args['field_class']  = 'custom-control-image_select' . ( $args['field_class'] ? ' ' . $args['field_class'] : '' );
							break;
						case 'radio_group':
							$args['setting_type'] = 'radio';
							$args['field_class']  = 'custom-control-radio_group' . ( $args['field_class'] ? ' ' . $args['field_class'] : '' );
							break;
						default:
							$args['setting_type'] = $args['type'];
					}

					$args['default_value']    = $args['default'];
					$settings_args            = array(
						'sanitize_callback'    => $args['sanitize_callback'],
						'sanitize_js_callback' => $args['sanitize_js_callback'],
						'theme_supports'       => $args['theme_supports'],
						'type'                 => $args['mod'],
					);
					$settings_args['default'] = apply_filters( 'tophive/customize/settings-default', $args['default'], $args['name'] );

					$settings_args['transport'] = 'refresh';
					if ( ! $settings_args['sanitize_callback'] ) {
						$settings_args['sanitize_callback'] = array(
							'Tophive_Sanitize_Input',
							'sanitize_customizer_input',
						);
					}

					foreach ( $settings_args as $k => $v ) {
						unset( $args[ $k ] );
					}

					unset( $args['mod'] );
					$name = $args['name'];
					unset( $args['name'] );

					unset( $args['type'] );
					if ( ! $args['label'] ) {
						$args['label'] = $args['title'];
					}

					$selective_refresh = null;
					if ( $args['selector'] && ( ( $args['render_callback'] || $args['render'] ) || $args['css_format'] ) ) {
						$selective_refresh = array(
							'selector'        => $args['selector'],
							'render_callback' => ( $args['render'] ) ? $args['render'] : $args['render_callback'],
						);

						if ( $args['css_format'] ) {
							$settings_args['transport'] = 'postMessage';
							$selective_refresh          = null;
						} else {
							$settings_args['transport'] = 'postMessage';
						}
					}
					unset( $args['default'] );

					$wp_customize->add_setting(
						$name,
						array_merge(
							array(
								'sanitize_callback' => array(
									'Tophive_Sanitize_Input',
									'sanitize_customizer_input',
								),
							),
							$settings_args
						)
					);

					$control_class_name = 'Tophive_Customizer_Control_';
					$tpl_type           = str_replace( '_', ' ', $args['setting_type'] );
					$tpl_type           = str_replace( ' ', '_', ucfirst( $tpl_type ) );
					$control_class_name .= $tpl_type;

					if ( 'js_raw' != $settings_args['type'] ) {
						if ( class_exists( $control_class_name ) ) {
							$wp_customize->add_control( new $control_class_name( $wp_customize, $name, $args ) );
						} else {
							$wp_customize->add_control( new Tophive_Customizer_Control_Base( $wp_customize, $name, $args ) );
						}
					}

					if ( $selective_refresh ) {
						$s_id = $selective_refresh['render_callback'];
						if ( is_array( $s_id ) ) {
							if ( is_string( $s_id[0] ) ) {
								$__id = $s_id[0] . '__' . $s_id[1];
							} else {
								$__id = get_class( $s_id[0] ) . '__' . $s_id[1];
							}
						} else {
							$__id = $s_id;
						}
						if ( ! isset( $this->selective_settings[ $__id ] ) ) {
							$this->selective_settings[ $__id ] = array(
								'settings'            => array(),
								'selector'            => $selective_refresh['selector'],
								'container_inclusive' => ( strpos( $__id, 'Tophive_Customizer_Auto_CSS' ) === false ) ? true : false,
								'render_callback'     => $s_id,
							);
						}

						$this->selective_settings[ $__id ]['settings'][] = $name;
					}

					break;
			}// end switch.
		} // End loop config.

		// Remove partial for default custom logo and add this by theme custom.
		$wp_customize->selective_refresh->remove_partial( 'custom_logo' );

		$wp_customize->get_section( 'title_tagline' )->panel        = 'header_settings';
		$wp_customize->get_section( 'title_tagline' )->title        = esc_html__( 'Logo & Site Identity', 'metafans' );
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		// Add selective refresh.
		$wp_customize->get_setting( 'custom_logo' )->transport     = 'postMessage';
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		foreach ( $this->selective_settings as $cb => $settings ) {
			reset( $settings['settings'] );
			if ( 'Tophive_Builder_Item_Logo__render' == $cb ) {
				$settings['settings'][] = 'custom_logo';
				$settings['settings'][] = 'blogname';
				$settings['settings'][] = 'blogdescription';
			}
			$settings = apply_filters( $cb, $settings );
			$wp_customize->selective_refresh->add_partial( $cb, $settings );
		}

		// For live CSS.
		$wp_customize->add_setting(
			'tophive__css',
			array(
				'default'           => '',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'Tophive_Sanitize_Input', 'sanitize_css_code' ),
			)
		);

		do_action( 'tophive/customize/register_completed', $this );
	}

}
