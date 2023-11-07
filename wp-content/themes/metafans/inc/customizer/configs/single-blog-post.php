<?php
if ( ! function_exists( 'tophive_customizer_single_blog_config' ) ) {
	function tophive_customizer_single_blog_config( $configs = array() ) {

		$args = array(
			'name'     => esc_html__( 'Single Blog Post', 'metafans' ),
			'id'       => 'single_blog_post',
			'selector' => '.entry.entry-single',
			'cb'       => 'tophive_single_post',
		);

		$top_panel     = 'blog_panel';
		$level_2_panel = 'section_' . $args['id'];

		$config = array(
			array(
				'name'  => $level_2_panel,
				'type'  => 'section',
				'panel' => $top_panel,
				'title' => $args['name'],
			),

			array(
				'name'       => $args['id'] . '_content_width',
				'section'    => $level_2_panel,
				'type'       => 'slider',
				'max'        => 1200,
				'label'      => esc_html__( 'Content Max Width', 'metafans' ),
				'selector'   => '.single-post .content-inner',
				'css_format' => 'max-width: {{value}};',
			),
			array(
				'name'       => $args['id'] . '_content_padding',
				'section'    => $level_2_panel,
				'type'       => 'css_ruler',
				'max'        => 150,
				'device_settings' => true,
				'label'      => esc_html__( 'Content Padding', 'metafans' ),
				'selector'   => '.single-post .content-inner',
				'css_format' => array(
					'top' 		=> 'padding-top:{{value}} !important;',
					'right' 	=> 'padding-right:{{value}};',
					'bottom' 	=> 'padding-bottom:{{value}} !important;',
					'left' 		=> 'padding-left:{{value}};'
				),
			),
			array(
				'name'       => $args['id'] . '_content_margin',
				'section'    => $level_2_panel,
				'type'       => 'css_ruler',
				'max'        => 150,
				'device_settings' => true,
				'label'      => esc_html__( 'Content Margin', 'metafans' ),
				'selector'   => '.single-post .content-inner',
				'css_format' => array(
					'top' 		=> 'margin-top:{{value}};',
					'right' 	=> 'margin-right:{{value}};',
					'bottom' 	=> 'margin-bottom:{{value}};',
					'left' 		=> 'margin-left:{{value}};'
				),
			),
			array(
				'name'            => $args['id'] . '_page_cover',
				'type'            => 'checkbox',
				'section'         => $level_2_panel,
				'default'         => 1,
				'selector'        => '#page-cover',
				'render_callback' => $args['cb'],
				'checkbox_label'  => esc_html__( 'Show page cover', 'metafans' ),
			),


			array(
				'name'       => 'blog_single_background',
				'type'       => 'styling',
				'section'    => $level_2_panel,
				'title'      => __( 'Blog Single Background', 'metafans' ),
				'selector'   => array(
					'normal'            => '.single-post .content-inner',
				),
				'css_format' => 'styling', // styling.
				'fields'     => array(
					'normal_fields' => array(
						'text_color' => false,
						'link_color' => false,
						// 'padding'     => false,
						'margin'     => false,
						// 'border_heading' => false,
						// 'border_width' => false,
						// 'border_color' => false,
						// 'border_radius' => false,
						'box_shadow' => false,
						// 'border_style'  => false,
					),
					'hover_fields'  => false,
				),
			),

			array(
				'name'             => $args['id'] . '_items',
				'section'          => $level_2_panel,
				'type'             => 'repeater',
				'title'            => esc_html__( 'Items Display', 'metafans' ),
				'live_title_field' => 'title',
				'addable'          => false,
				'title_only'       => true,
				'selector'         => $args['selector'],
				'render_callback'  => $args['cb'],
				'default'          => array(
					array(
						'_visibility' => '',
						'_key'        => 'title',
						'title'       => esc_html__( 'Title', 'metafans' ),
					),
					array(
						'_key'        => 'meta',
						'_visibility' => '',
						'title'       => esc_html__( 'Meta', 'metafans' ),
					),
					array(
						'_key'        => 'thumbnail',
						'_visibility' => '',
						'title'       => esc_html__( 'Thumbnail', 'metafans' ),
					),
					array(
						'_key'        => 'content',
						'_visibility' => '',
						'title'       => esc_html__( 'Content', 'metafans' ),
					),
					array(
						'_key'        => 'categories',
						'_visibility' => 'hidden',
						'title'       => esc_html__( 'Categories', 'metafans' ),
					),
					array(
						'_key'        => 'tags',
						'_visibility' => '',
						'title'       => esc_html__( 'Tags', 'metafans' ),
					),
					array(
						'_key'        => 'author_bio',
						'_visibility' => 'hidden',
						'title'       => esc_html__( 'Author Biography', 'metafans' ),
					),
					array(
						'_key'        => 'navigation',
						'_visibility' => '',
						'title'       => esc_html__( 'Post Navigation', 'metafans' ),
					),

					array(
						'_key'        => 'related',
						'_visibility' => 'hidden',
						'title'       => esc_html__( 'Related Posts', 'metafans' ),
					),

					array(
						'_key'        => 'comment_form',
						'_visibility' => '',
						'title'       => esc_html__( 'Comment Form', 'metafans' ),
					),

				),
				'fields'           => array(
					array(
						'name' => '_key',
						'type' => 'hidden',
					),
					array(
						'name'  => 'title',
						'type'  => 'hidden',
						'label' => esc_html__( 'Title', 'metafans' ),
					),
				),
			),

			array(
				'name'            => $args['id'] . '_thumbnail_size',
				'type'            => 'select',
				'section'         => $level_2_panel,
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'default'         => 'large',
				'label'           => esc_html__( 'Thumbnail Size', 'metafans' ),
				'choices'         => tophive_get_all_image_sizes(),
			),

			array(
				'name'    => $level_2_panel . '_h_title',
				'type'    => 'heading',
				'section' => $level_2_panel,
				'title'   => esc_html__( 'Heading & Thumb Settings', 'metafans' ),
			),
			array(
				'name'            => $args['id'] . '_heading_typo',
				'section'         => $level_2_panel,
				'type'            => 'typography',
				'default'         => '',
				'label'           => esc_html__( 'Heading Typography', 'metafans' ),
				'description'     => esc_html__( 'Typo setting for single blog posts', 'metafans' ),
				'selector'        => '.entry.entry-single .entry-title',
				'css_format'  	  => 'typography',
			),	
			array(
				'name'            => $args['id'] . '_media_ratio',
				'type'            => 'slider',
				'section'         => $level_2_panel,
				'label'           => esc_html__( 'Media Ratio', 'metafans' ),
				'selector'        => "{$args['selector']} .entry-thumbnail",
				'css_format'      => 'height: {{value_no_unit}}px;',
				'default'         => 400,
				'max'             => 1000,
				'min'             => 100,
				'device_settings' => true,
				'unit'            => 'px',
			),		
			array(
				'name'            => $args['id'] . '_media_br',
				'type'            => 'slider',
				'section'         => $level_2_panel,
				'label'           => esc_html__( 'Media Border Radius', 'metafans' ),
				'selector'        => "{$args['selector']} .entry-thumbnail",
				'css_format'      => 'border-radius: {{value_no_unit}}px;',
				'max'             => 100,
				'min'             => 0,
				'device_settings' => false,
				'unit'            => 'px',
			),
			array(
				'name'            => $args['id'] . '_media_styling',
				'type'            => 'styling',
				'section'         => $level_2_panel,
				'label'           => esc_html__( 'Media Styling', 'metafans' ),
				'selector'        => "{$args['selector']} .entry-thumbnail",
				'css_format'      => 'styling'
			),		
			array(
				'name'    => $level_2_panel . '_h_meta',
				'type'    => 'heading',
				'section' => $level_2_panel,
				'title'   => esc_html__( 'Meta Settings', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_meta_sep',
				'section'         => $level_2_panel,
				'type'            => 'text',
				'default'         => '',
				'label'           => esc_html__( 'Separator', 'metafans' ),
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
			),

			array(
				'name'       => $args['id'] . '_meta_sep_width',
				'section'    => $level_2_panel . '_meta',
				'type'       => 'slider',
				'max'        => 20,
				'label'      => esc_html__( 'Separator Width', 'metafans' ),
				'selector'   => $args['selector'] . ' .entry-meta .sep',
				'css_format' => 'margin-left: calc( {{value}} / 2 ); margin-right: calc( {{value}} / 2 );',
			),

			array(
				'name'             => $args['id'] . '_meta_config',
				'section'          => $level_2_panel,
				'type'             => 'repeater',
				'description'      => esc_html__( 'Drag to reorder the meta item.', 'metafans' ),
				'live_title_field' => 'title',
				'limit'            => 4,
				'addable'          => false,
				'title_only'       => true,
				'selector'         => $args['selector'],
				'render_callback'  => $args['cb'],
				'default'          => array(
					array(
						'_key'  => 'author',
						'title' => esc_html__( 'Author', 'metafans' ),
					),
					array(
						'_key'  => 'date',
						'title' => esc_html__( 'Date', 'metafans' ),
					),
					array(
						'_key'  => 'categories',
						'title' => esc_html__( 'Categories', 'metafans' ),
					),
					array(
						'_key'  => 'comment',
						'title' => esc_html__( 'Comment', 'metafans' ),
					),

				),
				'fields'           => array(
					array(
						'name' => '_key',
						'type' => 'hidden',
					),
					array(
						'name'  => 'title',
						'type'  => 'hidden',
						'label' => esc_html__( 'Title', 'metafans' ),
					),
				),
			),
			array(
				'name'            => $args['id'] . '_meta_icon',
				'type'            => 'select',
				'section'         => $level_2_panel,
				'selector'        => '.entry-meta .meta-item i',
				'render_callback' => $args['cb'],
				'default'         => 'initial',
				'label'           => esc_html__( 'Show Meta icons?', 'metafans' ),
				'choices'         => array(
					'initial' => esc_html__( 'Yes', 'metafans'),
					'none' => esc_html__( 'No', 'metafans')
				),
				'css_format' => 'display : {{value}};'
			),
			array(
				'name'            => $args['id'] . '_meta_typo',
				'type'            => 'typography',
				'section'         => $level_2_panel,
				'selector'        => '.entry-single .entry-meta .meta-item a, .entry-single .entry-meta .meta-item span',
				'label'           => esc_html__( 'Meta Typography', 'metafans' ),
				'css_format' 	  => 'typography'
			),
			array(
				'name'            => $args['id'] . '_author_avatar',
				'type'            => 'checkbox',
				'section'         => $level_2_panel,
				'default'         => 0,
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label'  => esc_html__( 'Show author avatar', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_avatar_size',
				'type'            => 'slider',
				'section'         => $level_2_panel,
				'default'         => 32,
				'max'             => 150,
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'label'           => esc_html__( 'Avatar Size', 'metafans' ),
				'required'        => array( $args['id'] . '_author_avatar', '==', '1' ),
			),

		);

		return array_merge( $configs, $config );

	}
}

add_filter( 'tophive/customizer/config', 'tophive_customizer_single_blog_config' );

