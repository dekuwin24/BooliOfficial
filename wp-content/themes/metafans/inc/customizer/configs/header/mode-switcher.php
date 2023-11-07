<?php

class Tophive_Builder_Item_Mode_Switcher {
	public $id = 'theme_mode_switch';
	public $section = 'theme_mode_switch';
	public $name = 'theme_mode_switch';
	public $label = '';

	/**
	 * Optional construct
	 *
	 * Tophive_Builder_Item_HTML constructor.
	 */
	function __construct() {
		$this->label = esc_html__( 'Theme Skin Switcher', 'metafans' );
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
		$selector = ".header-{$this->id}-item";

		$config   = array(
			array(
				'name'  => $this->section,
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => $this->label,
			),

			array(
				'name'            => $this->section . '_placeholder',
				'type'            => 'text',
				'section'         => $this->section,
				'selector'        => "$selector",
				'render_callback' => $fn,
				'label'           => esc_html__( 'Placeholder', 'metafans' ),
				'default'         => esc_html__( 'Search ...', 'metafans' ),
				'priority'        => 10,
			),

			array(
				'name'            => $this->section . '_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $this->section,
				'selector'        => "$selector .search-form-fields",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Search Form Width', 'metafans' ),
				'description'     => esc_html__( 'Note: The width can not greater than grid width.', 'metafans' ),
				'priority'        => 15,
			),

			array(
				'name'            => $this->section . '_height',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $this->section,
				'min'             => 25,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-form-fields, $selector .search-form-fields .search-field",
				'css_format'      => 'height: {{value}};',
				'label'           => esc_html__( 'Input Height', 'metafans' ),
				'priority'        => 20,
			),

			array(
				'name'            => $this->section . '_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => $this->section,
				'min'             => 5,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-submit svg,$selector .header-search-form button.search-submit svg",
				'css_format'      => 'height: {{value}}; width: {{value}};',
				'label'           => esc_html__( 'Icon Size', 'metafans' ),
				'priority'        => 25,
			),

			array(
				'name'        => $this->section . '_icon_styling',
				'type'        => 'styling',
				'section'     => $this->section,
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Icon Styling', 'metafans' ),
				'description' => esc_html__( 'Search input styling', 'metafans' ),
				'selector'    => array(
					'normal' => "{$selector} .header-search-form button.search-submit",
					'hover'  => "{$selector} .header-search-form button.search-submit",
					'normal_text_color' => ".dark-mode {$selector} .header-search-form button.search-submit",
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'border_radius' => false,
					), // disable hover tab and all fields inside.
				),
				'priority'        => 45,
			),

		);

		// Item Layout.
		return array_merge( $config, tophive_header_layout_settings( $this->id, $this->section ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		/**
		 * Hook: tophive/builder_item/mode-switcher/before_html
		 *
		 * @since 0.2.8
		 */
		do_action( 'tophive/builder_item/mode-switcher/before_html' );

		// if( !current_user_can('edit_options' ) ) return;
		$theme_mode_dark = tophive_metafans()->get_setting( 'global_dark_version_show' );
		if( $theme_mode_dark ){
			$current_mode = "dark";
			$sun_class = "";
			$moon_class = " hidden";
		}else{
			$sun_class = " hidden";
			$moon_class = "";
			$current_mode = "light";
		}

		$html = '<div class="mode-switcher" data-switcher-mode="'. $current_mode .'">';
		$html .= '<span class="sun '. $sun_class .'"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width="24px" height="24px">
			<g id="surface61198079">
			<path style=" stroke:none;fill-rule:nonzero;fill:#fff;fill-opacity:1;" d="M 11 0 L 11 3 L 13 3 L 13 0 Z M 4.222656 2.808594 L 2.808594 4.222656 L 4.929688 6.34375 L 6.34375 4.929688 Z M 19.777344 2.808594 L 17.65625 4.929688 L 19.070312 6.34375 L 21.191406 4.222656 Z M 12 5 C 8.132812 5 5 8.132812 5 12 C 5 15.867188 8.132812 19 12 19 C 15.867188 19 19 15.867188 19 12 C 19 8.132812 15.867188 5 12 5 Z M 0 11 L 0 13 L 3 13 L 3 11 Z M 21 11 L 21 13 L 24 13 L 24 11 Z M 4.929688 17.65625 L 2.808594 19.777344 L 4.222656 21.191406 L 6.34375 19.070312 Z M 19.070312 17.65625 L 17.65625 19.070312 L 19.777344 21.191406 L 21.191406 19.777344 Z M 11 21 L 11 24 L 13 24 L 13 21 Z M 11 21 "/>
			</g>
			</svg></span>';
		$html .= '<span class="moon '. $moon_class .'">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">    <path d="M22,21c-6.627,0-12-5.373-12-12c0-1.95,0.475-3.785,1.3-5.412C6.485,5.148,3,9.665,3,15c0,6.627,5.373,12,12,12 c4.678,0,8.72-2.682,10.7-6.588C24.534,20.79,23.292,21,22,21z"></path></svg></span>';
		echo $html .= '</div>';

		/**
		 * Hook: tophive/builder_item/mode-switcher/after_html
		 *
		 * @since 0.2.8
		 */
		do_action( 'tophive/builder_item/mode-switcher/after_html' );
	}
}

Tophive_Customize_Layout_Builder()->register_item( 'header', new Tophive_Builder_Item_Mode_Switcher() );
