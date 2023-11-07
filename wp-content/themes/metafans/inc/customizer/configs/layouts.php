<?php
if ( ! function_exists( 'tophive_customizer_layouts_config' ) ) {
	/**
	 * Add layout settings.
	 *
	 * @since 0.0.1
	 * @since 0.2.6
	 *
	 * @param array $configs
	 * @return array
	 */
	function tophive_customizer_layouts_config( $configs ) {
		$config = array(

			// Layout panel.
			array(
				'name'           => 'layout_panel',
				'type'           => 'panel',
				'priority'       => 18,
				'theme_supports' => '',
				'title'          => esc_html__( 'Layouts', 'metafans' ),
			),

			// Global layout section.
			array(
				'name'           => 'global_layout_section',
				'type'           => 'section',
				'panel'          => 'layout_panel',
				'theme_supports' => '',
				'title'          => esc_html__( 'Global', 'metafans' ),
			),
			array(
				'name'        => 'site_layout',
				'type'        => 'radio_group',
				'section'     => 'global_layout_section',
				'title'       => esc_html__( 'Site layout', 'metafans' ),
				'description' => esc_html__( 'Select global site layout.', 'metafans' ),
				'default'     => 'site-full-width',
				'css_format'  => 'html_class',
				'selector'    => 'body',
				'choices'     => array(
					'site-full-width' => esc_html__( 'Full Width', 'metafans' ),
					'site-boxed'      => esc_html__( 'Boxed', 'metafans' ),
					'site-framed'     => esc_html__( 'Framed', 'metafans' ),
				),
			),

			array(
				'name'       => 'site_box_shadow',
				'type'       => 'radio_group',
				'section'    => 'global_layout_section',
				'title'      => esc_html__( 'Site boxed/framed shadow', 'metafans' ),
				'choices'    => array(
					'box-shadow'    => esc_html__( 'Yes', 'metafans' ),
					'no-box-shadow' => esc_html__( 'No', 'metafans' ),
				),
				'default'    => 'box-shadow',
				'css_format' => 'html_class',
				'selector'   => '#page',
				'required'   => array(
					array( 'site_layout', '=', array( 'site-boxed', 'site-framed' ) ),
				),
			),

			array(
				'name'            => 'site_margin',
				'type'            => 'css_ruler',
				'section'         => 'global_layout_section',
				'title'           => esc_html__( 'Site framed margin', 'metafans' ),
				'device_settings' => true,
				'fields_disabled' => array(
					'left'  => '',
					'right' => '',
				),
				'css_format'      => array(
					'top'    => 'margin-top: {{value}};',
					'bottom' => 'margin-bottom: {{value}};',
				),
				'selector'        => '.site-framed .site',
				'required'        => array(
					array( 'site_layout', '=', 'site-framed' ),
				),
			),
			/**
			 * @since 0.2.6 Change css_format and selector.
			 */
			array(
				'name'            => 'container_width',
				'type'            => 'slider',
				'device_settings' => false,
				'default'         => 1200,
				'min'             => 700,
				'step'            => 10,
				'max'             => 2000,
				'section'         => 'global_layout_section',
				'title'           => esc_html__( 'Container width', 'metafans' ),
				'selector'        => 'format',
				'css_format'      => '.tophive-container, .layout-contained, .site-framed .site, .site-boxed .site { max-width: {{value}}; } .main-layout-content .entry-content > .alignwide { width: calc( {{value}} - 4em ); max-width: 100vw;  }',
			),

			// Site content layout.
			array(
				'name'       => 'site_content_layout',
				'type'       => 'radio_group',
				'section'    => 'global_layout_section',
				'title'      => esc_html__( 'Site content layout', 'metafans' ),
				'choices'    => array(
					'site-content-fullwidth' => esc_html__( 'Full width', 'metafans' ),
					'site-content-boxed'     => esc_html__( 'Boxed', 'metafans' ),
				),
				'default'    => 'site-content-boxed',
				'css_format' => 'html_class',
				'selector'   => '.site-content',
			),
			array(
				'name'       => 'site_footer_layout',
				'type'       => 'radio_group',
				'section'    => 'global_layout_section',
				'title'      => esc_html__( 'Footer layout', 'metafans' ),
				'choices'    => array(
					'footer-relative' => esc_html__( 'Footer Default', 'metafans' ),
					'footer-fixed'     => esc_html__( 'Footer Fixed', 'metafans' ),
				),
				'default'    => 'footer-relative',
				'css_format' => 'html_class',
				'selector'   => '#page',
			),
			array(
				'name'            => 'site_content_padding',
				'type'            => 'css_ruler',
				'section'         => 'global_layout_section',
				'title'           => esc_html__( 'Site content padding', 'metafans' ),
				'device_settings' => true,
				
				'css_format'      => array(
					'top'    => 'padding-top: {{value}};',
					'right'  => 'padding-right: {{value}};',
					'bottom' => 'padding-bottom: {{value}};',
					'left'   => 'padding-left: {{value}};',
				),
				'selector'        => '#page .site-content',
			),
			array(
				'name'            => 'site_content_padding',
				'type'            => 'css_ruler',
				'section'         => 'global_layout_main_section',
				'title'           => esc_html__( 'Main content padding', 'metafans' ),
				'device_settings' => true,
				
				'css_format'      => array(
					'top'    => 'padding-top: {{value}};',
					'right'  => 'padding-right: {{value}};',
					'bottom' => 'padding-bottom: {{value}};',
					'left'   => 'padding-left: {{value}};',
				),
				'selector'        => '#page .site-content .tophive-container',
			),
			array(
				'name'            => 'site_content_margin',
				'type'            => 'css_ruler',
				'section'         => 'global_layout_section',
				'title'           => esc_html__( 'Site content margin', 'metafans' ),
				'device_settings' => true,
				
				'css_format'      => array(
					'top'    => 'margin-top: {{value}};',
					'right'  => 'margin-right: {{value}};',
					'bottom' => 'margin-bottom: {{value}};',
					'left'   => 'margin-left: {{value}};',
				),
				'selector'        => 'body .site-content',
			),

			// Page layout.
			array(
				'name'           => 'sidebar_layout_section',
				'type'           => 'section',
				'panel'          => 'layout_panel',
				'theme_supports' => '',
				'title'          => esc_html__( 'Sidebars', 'metafans' ),
			),
			// Global sidebar layout.
			array(
				'name'    => 'sidebar_layout',
				'type'    => 'select',
				'default' => 'content-sidebar',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Default Sidebar Layout', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
			array(
				'title'           	=> esc_html__( 'Sidebar spacing', 'metafans' ),
				'section' 			=> 'sidebar_layout_section',
				'name'            	=> 'sidebar_spacing',
				'type'            	=> 'select',
				'choices'      => array(
					'md-space' 	=> esc_html__( 'Medium space', 'metafans' ),
					'xm-space'  => esc_html__( 'Extra small space', 'metafans' ),
					'sm-space' 	=> esc_html__( 'Small space', 'metafans' ),
					'lg-space' 	=> esc_html__( 'Large space', 'metafans' ),
					'xl-space' 	=> esc_html__( 'Xtra Large space', 'metafans' ),
					'no-gap'    => esc_html__( 'No gap', 'metafans' ),
				),
				'default' => 'sm-space'
			),
			// Sidebar vertical border.
			array(
				'name'       => 'sidebar_vertical_border',
				'type'       => 'radio_group',
				'section'    => 'sidebar_layout_section',
				'title'      => esc_html__( 'Sidebar with vertical border', 'metafans' ),
				'choices'    => array(
					'sidebar_vertical_border'    => esc_html__( 'Yes', 'metafans' ),
					'no-sidebar_vertical_border' => esc_html__( 'No', 'metafans' ),
				),
				'default'    => 'no-sidebar_vertical_border',
				'css_format' => 'html_class',
				'selector'   => 'body',
			),

			// Page sidebar layout.
			array(
				'name'    => 'page_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Pages', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
			// Blog Posts sidebar layout.
			array(
				'name'    => 'posts_sidebar_layout',
				'type'    => 'select',
				'default' => 'content-sidebar',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Blog posts', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
			// Blog Posts sidebar layout.
			array(
				'name'    => 'posts_archives_sidebar_layout',
				'type'    => 'select',
				'default' => 'content-sidebar',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Blog Archive Page', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
			// Search.
			array(
				'name'    => 'search_sidebar_layout',
				'type'    => 'select',
				'default' => 'content-sidebar',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Search Page', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
			// 404.
			array(
				'name'    => 'profile_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Profile Page', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
			// 404.
			array(
				'name'    => '404_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( '404 Page', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),
			),
		);
		
		if( tophive_metafans()->is_buddypress_active() ){
			$config[] = array(
				'name'    => 'buddypress_activity_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Buddypress Activity Pages', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),	
			);
		}
		if( tophive_metafans()->is_buddypress_active() ){
			$config[] = array(
				'name'    => 'buddypress_groups_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Buddypress Groups Pages', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),	
			);
		}
		if( tophive_metafans()->is_buddypress_active() ){
			$config[] = array(
				'name'    => 'buddypress_groups_single_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Buddypress Group Single Page', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),	
			);
		}
		if( tophive_metafans()->is_buddypress_active() ){
			$config[] = array(
				'name'    => 'buddypress_memebrs_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Buddypress Membeers Pages', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),	
			);
		}
		if( tophive_metafans()->is_buddypress_active() ){
			$config[] = array(
				'name'    => 'buddypress_profile_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Buddypress Profile Pages', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),	
			);
		}
		if( tophive_metafans()->is_bbpress_active() ){
			$config[] = array(
				'name'    => 'bbpress_sidebar_layout',
				'type'    => 'select',
				'default' => 'content',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'BBPress Pages', 'metafans' ),
				'choices' => tophive_get_config_sidebar_layouts(),	
			);
		}

		$post_types = tophive_metafans()->get_post_types( false );

		if ( count( $post_types ) ) {
			$config[] = array(
				'name'    => 'post_types_sidebar_h_tb',
				'type'    => 'heading',
				'section' => 'sidebar_layout_section',
				'title'   => esc_html__( 'Post Type Settings', 'metafans' ),
			);

			foreach ( $post_types as $pt => $label ) {
				$config[] = array(
					'name'    => "{$pt}_sidebar_layout",
					'type'    => 'select',
					'default' => 'content',
					'section' => 'sidebar_layout_section',
					'title'   => sprintf( esc_html__( 'Single %s', 'metafans' ), $label['singular_name'] ),
					'choices' => array_merge(
						array( 'default' => esc_html__( 'Default', 'metafans' ) ),
						tophive_get_config_sidebar_layouts()
					),
				);
			}
		}

		return array_merge( $configs, $config );
	}
}

add_filter( 'tophive/customizer/config', 'tophive_customizer_layouts_config' );
