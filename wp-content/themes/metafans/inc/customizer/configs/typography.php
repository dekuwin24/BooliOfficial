<?php
if ( ! function_exists( 'tophive_customizer_typography_config' ) ) {
	/**
	 * Add typograhy settings.
	 *
	 * @since 0.0.1
	 * @since 0.2.6
	 *
	 * @param array $configs
	 * @return array
	 */
	function tophive_customizer_typography_config( $configs ) {

		$section = 'global_typography';

		$config = array(
			array(
				'name'     => 'typography_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Typography', 'metafans' ),
			),

			// Base.
			array(
				'name'  => "{$section}_base",
				'type'  => 'section',
				'panel' => 'typography_panel',
				'title' => esc_html__( 'Base', 'metafans' ),
			),

			array(
				'name'        => "{$section}_base_p",
				'type'        => 'typography',
				'section'     => "{$section}_base",
				'title'       => esc_html__( 'Body & Paragraph', 'metafans' ),
				'description' => esc_html__( 'Apply to body and paragraph text.', 'metafans' ),
				'css_format'  => 'typography',
				'selector'    => 'body, .activity-list .activity-item .activity-content p, .tophive-mc-recent-post-widget h6 small',
			),

			array(
				'name'        => "{$section}_base_heading",
				'type'        => 'typography',
				'section'     => "{$section}_base",
				'title'       => esc_html__( 'Heading', 'metafans' ),
				'description' => esc_html__( 'Apply to all heading elements.', 'metafans' ),
				'css_format'  => 'typography',
				'selector'    => 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6',
				'fields'      => array(
					'font_size'      => false,
					'line_height'    => false,
					'letter_spacing' => false,
				),
			),
			array(
				'name'        => "{$section}_base_widget_title",
				'type'        => 'typography',
				'section'     => "{$section}_base",
				'title'       => esc_html__( 'Widget Title', 'metafans' ),
				'description' => esc_html__( 'Apply to all widget title in site content.', 'metafans' ),
				'css_format'  => 'typography',
				'selector'    => 'body .site-content .widget-title, .widget-area .widget .widget-title, .elementor-widget .widget-title, .buddypress.widget .widget-title, .buddypress .widget .widget-title, .elementor-widget h5, .buddypress.widget .widget-title, .buddypress .widget .widget-title',
			),

			// Site Title and Tagline.
			array(
				'name'  => "{$section}_site_tt",
				'type'  => 'section',
				'panel' => 'typography_panel',
				'title' => esc_html__( 'Site Title & Tagline', 'metafans' ),
			),

			array(
				'name'       => "{$section}_site_tt_title",
				'type'       => 'typography',
				'section'    => "{$section}_site_tt",
				'title'      => esc_html__( 'Site Title', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.site-branding .site-title, .site-branding .site-title a',
			),

			array(
				'name'       => "{$section}_site_tt_desc",
				'type'       => 'typography',
				'section'    => "{$section}_site_tt",
				'title'      => esc_html__( 'Tagline', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.site-branding .site-description',
			),

			// Content.
			array(
				'name'  => "{$section}_content",
				'type'  => 'section',
				'panel' => 'typography_panel',
				'title' => esc_html__( 'Content', 'metafans' ),
			),

			array(
				'name'       => "{$section}_heading_h1",
				'type'       => 'typography',
				'section'    => "{$section}_content",
				'title'      => esc_html__( 'Heading H1', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.entry-content h1, .wp-block h1, .entry-single .entry-title',
			),

			array(
				'name'       => "{$section}_heading_h2",
				'type'       => 'typography',
				'section'    => "{$section}_content",
				'title'      => esc_html__( 'Heading H2', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.entry-content h2, .wp-block h2',
			),

			array(
				'name'       => "{$section}_heading_h3",
				'type'       => 'typography',
				'section'    => "{$section}_content",
				'title'      => esc_html__( 'Heading H3', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.entry-content h3, .wp-block h3',
			),

			array(
				'name'       => "{$section}_heading_h4",
				'type'       => 'typography',
				'section'    => "{$section}_content",
				'title'      => esc_html__( 'Heading H4', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.entry-content h4, .wp-block h4',
			),

			array(
				'name'       => "{$section}_heading_h5",
				'type'       => 'typography',
				'section'    => "{$section}_content",
				'title'      => esc_html__( 'Heading H5', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.entry-content h5, .wp-block h5',
			),

			array(
				'name'       => "{$section}_heading_h6",
				'type'       => 'typography',
				'section'    => "{$section}_content",
				'title'      => esc_html__( 'Heading H6', 'metafans' ),
				'css_format' => 'typography',
				'selector'   => '.entry-content h6, .wp-block h6',
			),

		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'tophive/customizer/config', 'tophive_customizer_typography_config' );
