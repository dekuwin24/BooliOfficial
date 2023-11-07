<?php
if ( ! function_exists( 'tophive_customizer_blog_config' ) ) {
	function tophive_customizer_blog_config( $args = array() ) {

		$args          = wp_parse_args(
			$args,
			array(
				'name'     => esc_html__( 'Blog Posts', 'metafans' ),
				'id'       => 'blog_post',
				'selector' => '#blog-posts',
				'cb'       => 'tophive_blog_posts',
			)
		);
		$top_panel     = 'blog_panel';
		$level_2_panel = 'panel_' . $args['id'];

		$config = array(
			array(
				'name'  => $level_2_panel,
				'type'  => 'panel',
				'panel' => $top_panel,
				'title' => $args['name'],
			),

			array(
				'name'  => $level_2_panel . '_layout',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Layout', 'metafans' ),
			),

			array(
				'name'             => $args['id'] . '_layout',
				'type'             => 'image_select',
				'section'          => $level_2_panel . '_layout',
				'label'            => esc_html__( 'Layout', 'metafans' ),
				'default'          => 'blog_column',
				'selector'         => $args['selector'],
				'render_callback'  => $args['cb'],
				'disabled_msg'     => esc_html__( 'This option is available in Tophive Pro plugin only.', 'metafans' ),
				'disabled_pro_msg' => esc_html__( 'Please activate module Blog Posts to use this layout.', 'metafans' ),
				'choices'          => array(
					'blog_classic' => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/blog_classic.svg',
					),
					'blog_column'  => array(
						'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/blog_column.svg',
					),
					'blog_masonry' => array(
						'img'     => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/blog_masonry.svg',
					),
					'blog_lateral' => array(
						'img'     => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/blog_lateral.svg',
					),

				),
				'reset_controls'   => array(
					$args['id'] . '_media_ratio',
					$args['id'] . '_media_width',
				),
			),

			array(
				'name'    => $level_2_panel . '_layout_h1',
				'type'    => 'heading',
				'section' => $level_2_panel . '_layout',
				'title'   => esc_html__( 'Article Styling', 'metafans' ),
			),

			array(
				'name'       => $args['id'] . '_a_item',
				'type'       => 'styling',
				'section'    => $level_2_panel . '_layout',
				'selector'   => array(
					'normal'        => "{$args['selector'] } .entry-inner",
					'hover'         => "{$args['selector'] } .entry-inner:hover",
					'normal_margin' => "{$args['selector'] } .entry-inner",
				),
				'css_format' => 'styling',
				'label'      => esc_html__( 'Article Wrapper', 'metafans' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false,
					),
				),
			),
			array(
				'name'       => $args['id'] . '_a_s_item',
				'type'       => 'styling',
				'section'    => $level_2_panel . '_layout',
				'selector'   => array(
					'normal'        => "{$args['selector'] } .entry",
					'hover'         => "{$args['selector'] } .entry:hover",
					'normal_margin' => "{$args['selector'] } .entry",
				),
				'css_format' => 'styling',
				'label'      => esc_html__( 'Single Article Wrapper', 'metafans' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false,
					),
				),
			),
			array(
				'name'       => $args['id'] . '_a_content_item',
				'type'       => 'styling',
				'section'    => $level_2_panel . '_layout',
				'selector'   => array(
					'normal'        => "{$args['selector'] } .entry-content-data"
				),
				'css_format' => 'styling',
				'label'      => esc_html__( 'Article Content Wrapper', 'metafans' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color'    => false,
						'text_color'    => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'box_shadow' 	=> false,
					),
					'hover_fields'  => false
				),
			),
			array(
				'name'  => $level_2_panel . '_typo',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Typography', 'metafans' ),
			),
			array(
				'name'            => $args['id'] . '_heading_typo',
				'section'         => $level_2_panel . '_typo',
				'type'            => 'typography',
				'default'         => '',
				'label'           => esc_html__( 'Heading Typography', 'metafans' ),
				'description'     => esc_html__( 'Typo setting for blog posts', 'metafans' ),
				'selector'        => '#blog-posts .entry .entry-title a',
				'css_format'  	  => 'typography',
			),
			array(
				'name'       => $args['id'] . '_hd_item',
				'type'       => 'styling',
				'section'    => $level_2_panel . '_typo',
				'selector'   => array(
					'normal'        => "#blog-posts .entry .entry-title a",
					'hover'         => "#blog-posts .entry .entry-title a:hover",
					'normal_margin' => "#blog-posts .entry .entry-title a",
				),
				'css_format' => 'styling',
				'label'      => esc_html__( 'Header Styling', 'metafans' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_heading'    => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_color'		=> false,
						'border_heading' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => false,
						'box_shadow' => false,
						'border_style'  => false,
					),
					'hover_fields'  => array(
						'link_color'    => false, // disable for special field.
						'bg_heading'    => false,
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'bg_color'		=> false,
						'border_heading' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => false,
						'box_shadow' => false,
						'border_style'  => false,
					),
				),
			),
			array(
				'name'  => $level_2_panel . '_media',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Media', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_media_hide',
				'type'            => 'checkbox',
				'section'         => $level_2_panel . '_media',
				'checkbox_label'  => esc_html__( 'Hide Media', 'metafans' ),
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
			),

			array(
				'name'            => $args['id'] . '_media_ratio',
				'type'            => 'slider',
				'section'         => $level_2_panel . '_media',
				'label'           => esc_html__( 'Media Ratio', 'metafans' ),
				'selector'        => "{$args['selector']} .posts-layout .entry .entry-media",
				'css_format'      => 'padding-top: {{value_no_unit}}%;',
				'max'             => 200,
				'min'             => 0,
				'device_settings' => true,
				'unit'            => '%',
				'required'        => array( $args['id'] . '_media_hide', '!=', '1' ),
			),
			array(
				'name'            => $args['id'] . '_media_width',
				'type'            => 'slider',
				'section'         => $level_2_panel . '_media',
				'label'           => esc_html__( 'Media Width', 'metafans' ),
				'device_settings' => true,
				'max'             => 100,
				'min'             => 20,
				'unit'            => '%',
				'selector'        => "{$args['selector']} .posts-layout .entry-media, {$args['selector']} .posts-layout.layout--blog_classic .entry-media",
				'css_format'      => 'flex-basis: {{value_no_unit}}%; width: {{value_no_unit}}%;',
				'required'        => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			array(
				'name'       => $args['id'] . '_media_radius',
				'type'       => 'css_ruler',
				'section'    => $level_2_panel . '_media',
				'label'      => esc_html__( 'Media Radius', 'metafans' ),
				'max'        => 100,
				'min'        => 0,
				'device_settings' => true,
				'selector'   => "{$args['selector']} .posts-layout .entry-media",
				'css_format' => array(
					'top' 	=> 'border-top-left-radius:{{value}};',
					'right' => 'border-top-right-radius:{{value}};',
					'bottom'=> 'border-bottom-right-radius:{{value}};',
					'left' 	=> 'border-bottom-left-radius:{{value}};',
				),
				'required'   => array( $args['id'] . '_media_hide', '!=', '1' ),
			),
			array(
				'name'       => $args['id'] . '_box_shadow',
				'section'    => $level_2_panel . '_media',
				'type'       => 'shadow',
				'label'      => esc_html__( 'Box Shadow', 'metafans' ),
				'css_format' => 'box-shadow: {{value}};',
				'selector'   => '#blog-posts .entry-media .entry-thumbnail img',
			),
			array(
				'name'            => $args['id'] . '_thumbnail_size',
				'type'            => 'select',
				'section'         => $level_2_panel . '_media',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'default'         => 'medium',
				'label'           => esc_html__( 'Thumbnail Size', 'metafans' ),
				'choices'         => tophive_get_all_image_sizes(),
				'required'        => array( $args['id'] . '_media_hide', '!=', '1' ),
			),
			array(
				'name'            => $args['id'] . '_hide_thumb_if_empty',
				'type'            => 'checkbox',
				'section'         => $level_2_panel . '_media',
				'default'         => '1',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label'  => esc_html__( 'Hide featured image if empty.', 'metafans' ),
				'required'        => array( $args['id'] . '_media_hide', '!=', '1' ),
			),

			// Article Excerpt ---------------------------------------------------------------------------------.
			array(
				'name'  => $level_2_panel . '_excerpt',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Excerpt', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_excerpt_type',
				'type'            => 'select',
				'section'         => $level_2_panel . '_excerpt',
				'default'         => 'custom',
				'choices'         => array(
					'custom'   => esc_html__( 'Custom', 'metafans' ),
					'excerpt'  => esc_html__( 'Use excerpt metabox', 'metafans' ),
					'more_tag' => esc_html__( 'Strip excerpt by more tag', 'metafans' ),
					'content'  => esc_html__( 'Full content', 'metafans' ),
				),
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'label'           => esc_html__( 'Excerpt Type', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_excerpt_length',
				'type'            => 'number',
				'section'         => $level_2_panel . '_excerpt',
				'default'         => 25,
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'label'           => esc_html__( 'Excerpt Length', 'metafans' ),
				'required'        => array( $args['id'] . '_excerpt_type', '=', 'custom' ),
			),
			array(
				'name'            => $args['id'] . '_excerpt_more',
				'type'            => 'text',
				'section'         => $level_2_panel . '_excerpt',
				'default'         => '',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'label'           => esc_html__( 'Excerpt More', 'metafans' ),
			),

			array(
				'name'  => $level_2_panel . '_meta',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Metas', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_meta_sep',
				'section'         => $level_2_panel . '_meta',
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
				'section'          => $level_2_panel . '_meta',
				'type'             => 'repeater',
				'description'      => esc_html__( 'Drag to reorder the meta item.', 'metafans' ),
				'live_title_field' => 'title',
				'limit'            => 5,
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
					array(
						'_key'  => 'views',
						'title' => esc_html__( 'Post View', 'metafans' ),
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
				'name'            => $args['id'] . '_author_avatar',
				'type'            => 'checkbox',
				'section'         => $level_2_panel . '_meta',
				'default'         => 0,
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label'  => esc_html__( 'Show author avatar', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_avatar_size',
				'type'            => 'slider',
				'section'         => $level_2_panel . '_meta',
				'default'         => 32,
				'max'             => 150,
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'label'           => esc_html__( 'Avatar Size', 'metafans' ),
				'required'        => array( $args['id'] . '_author_avatar', '==', '1' ),
			),

			array(
				'name'            => $args['id'] . '_meta_typo',
				'type'            => 'typography',
				'section'         => $level_2_panel . '_meta',
				'selector'        => '#blog-posts .entry-meta .meta-item a, #blog-posts .entry-meta .meta-item span',
				'css_format' 	  => 'typography',
				'label'           => esc_html__( 'Meta Typography', 'metafans' ),
			),

			array(
				'name'  => $level_2_panel . '_readmore',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Read More', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_more_display',
				'type'            => 'checkbox',
				'default'         => 1,
				'section'         => $level_2_panel . '_readmore',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'checkbox_label'  => esc_html__( 'Show Read More Button', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_more_text',
				'type'            => 'text',
				'section'         => $level_2_panel . '_readmore',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'label'           => esc_html__( 'Read More Text', 'metafans' ),
				'required'        => array( $args['id'] . '_more_display', '==', '1' ),
			),
			array(
				'name'       => $args['id'] . '_more_typography',
				'type'       => 'typography',
				'css_format' => 'typography',
				'section'    => $level_2_panel . '_readmore',
				'selector'   => "{$args['selector'] } .entry-readmore a",
				'label'      => esc_html__( 'Typography', 'metafans' ),
				'required'   => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name'       => $args['id'] . '_more_styling',
				'type'       => 'styling',
				'section'    => $level_2_panel . '_readmore',
				'selector'   => array(
					'normal'        => "{$args['selector'] } .entry-readmore a",
					'hover'         => "{$args['selector'] } .entry-readmore a:hover",
					'normal_margin' => "{$args['selector'] } .entry-readmore",
				),
				'css_format' => 'styling',
				'label'      => esc_html__( 'Styling', 'metafans' ),
				'fields'     => array(
					'normal_fields' => array(
						'link_color'    => false, // Disable for special field.
						'bg_image'      => false,
						'bg_cover'      => false,
						'bg_position'   => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
					),
					'hover_fields'  => array(
						'link_color' => false, // Disable for special field.
					),
				),
				'required'   => array( $args['id'] . '_more_display', '==', '1' ),
			),

			array(
				'name'  => $level_2_panel . '_pagination',
				'type'  => 'section',
				'panel' => $level_2_panel,
				'title' => esc_html__( 'Pagination', 'metafans' ),
			),

			array(
				'name'            => $args['id'] . '_pg_show_paging',
				'section'         => $level_2_panel . '_pagination',
				'type'            => 'checkbox',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'default'         => 1,
				'checkbox_label'  => esc_html__( 'Show Pagination', 'metafans' ),
			),
			array(
				'name'            => $args['id'] . '_pg_show_nav',
				'section'         => $level_2_panel . '_pagination',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'type'            => 'checkbox',
				'default'         => 1,
				'checkbox_label'  => esc_html__( 'Show Next, Previous Label', 'metafans' ),
				'required'        => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),
			array(
				'name'            => $args['id'] . '_pg_prev_text',
				'section'         => $level_2_panel . '_pagination',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'type'            => 'text',
				'label'           => esc_html__( 'Previous Label', 'metafans' ),
				'required'        => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),
			array(
				'name'            => $args['id'] . '_pg_next_text',
				'section'         => $level_2_panel . '_pagination',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'type'            => 'text',
				'label'           => esc_html__( 'Next Label', 'metafans' ),
				'required'        => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),

			array(
				'name'            => $args['id'] . '_pg_mid_size',
				'section'         => $level_2_panel . '_pagination',
				'selector'        => $args['selector'],
				'render_callback' => $args['cb'],
				'type'            => 'text',
				'default'         => 3,
				'label'           => esc_html__( 'How many numbers to either side of the current pages', 'metafans' ),
				'required'        => array( $args['id'] . '_pg_show_paging', '==', '1' ),
			),

		);

		return $config;
	}
}


if ( ! function_exists( 'tophive_customizer_blog_posts_config' ) ) {
	function tophive_customizer_blog_posts_config( $configs ) {

		$config = array(
			array(
				'name'     => 'blog_panel',
				'type'     => 'panel',
				'priority' => 20,
				'title'    => esc_html__( 'Blog', 'metafans' ),
			),
		);

		$blog   = tophive_customizer_blog_config();
		$config = array_merge( $config, $blog );

		return array_merge( $configs, $config );
	}
}

add_filter( 'tophive/customizer/config', 'tophive_customizer_blog_posts_config' );
