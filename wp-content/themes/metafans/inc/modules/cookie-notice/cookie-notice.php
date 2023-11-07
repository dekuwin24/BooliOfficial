<?php

TophiveCore()->register_module(
	'TophiveCore_Module_Cookie_Notice'
);

class TophiveCore_Module_Cookie_Notice extends TophiveCoreModulesBasics {

	private $section = 'cookie_notice';

	public function __construct() {
		add_filter( 'tophive/customizer/config', array( $this, 'config' ), 5 );
		add_filter( 'body_class', array( $this, 'body_class' ) );

		if ( ! is_admin() ) {
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );
			add_action( 'wp_footer', array( $this, 'render' ) );
		}
	}
	public function assets() {
		$this->is_assets = true;
		$this->add_css();
		$this->add_js();
		$this->add_local_js_args( 'cn_cookie_expiry', tophive_metafans()->get_setting( "{$this->section}_cookie_expiry" ) );
	}
	public function config( $configs = array() ) {
		$section = $this->section;
		$selector = '#tophive_cookie_notice';
		$fn = array( $this, 'render' );
		$config = array(
			// Global layout section.
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'footer_settings',
				'title'    => __( 'Cookie Notice', 'metafans' ),
				'priority' => 210,
			),

			array(
				'name'            => "{$section}_message",
				'type'            => 'textarea',
				'section'         => $section,
				'default'         => __( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'metafans' ),
				'title'           => __( 'Message', 'metafans' ),
				'selector'        => "{$selector}",
				'render_callback' => $fn,
			),

			array(
				'name'            => "{$section}_button_text",
				'type'            => 'text',
				'section'         => $section,
				'default'         => __( 'Ok', 'metafans' ),
				'title'           => __( 'Button text', 'metafans' ),
				'description'     => __( 'The text of the option to accept the usage of the cookies and make the notification disappear.', 'metafans' ),
				'selector'        => "{$selector}",
				'render_callback' => $fn,
			),

			array(
				'name'            => "{$section}_cookie_expiry",
				'type'            => 'select',
				'choices'         => array(
					'hour'        => __( 'An hour', 'metafans' ),
					'day'         => __( '1 day', 'metafans' ),
					'week'        => __( '1 week', 'metafans' ),
					'month'       => __( '1 month', 'metafans' ),
					'3months'     => __( '3 months', 'metafans' ),
					'6months'     => __( '6 months', 'metafans' ),
					'year'        => __( '1 year', 'metafans' ),
					'infinity'    => __( 'Infinity', 'metafans' ),
				),
				'section'         => $section,
				'default'         => 'hour',
				'label'           => __( 'Cookie expiry', 'metafans' ),
				'description'     => __( 'The amount of time that cookie should be stored for.', 'metafans' ),
				'selector'        => "{$selector}",
				'render_callback' => $fn,
			),

			array(
				'name'            => "{$section}_message_position",
				'type'            => 'select',
				'choices'         => array(
					'top'             => __( 'Top - Full Width', 'metafans' ),
					'bottom'          => __( 'Bottom - Full Width', 'metafans' ),
					'top-left'        => __( 'Top Left', 'metafans' ),
					'top-right'       => __( 'Top Right', 'metafans' ),
					'bottom-left'     => __( 'Bottom Left', 'metafans' ),
					'bottom-right'    => __( 'Bottom Right', 'metafans' ),
				),
				'section'         => $section,
				'default'         => 'bottom',
				'label'           => __( 'Message Position', 'metafans' ),
				'description'     => __( 'Select location for your cookie notice.', 'metafans' ),
				'selector'        => "{$selector}",
				'render_callback' => $fn,
			),
			array(
				'name'       => "{$section}_box_styling",
				'type'       => 'styling',
				'section'    => $section,
				'title'      => __( 'Box Styling', 'metafans' ),
				'selector'   => array(
					'normal' => '.tophive-has-cookie-bar .tophive_cookie_notice, .tophive-has-cookie-bar .tophive_cookie_notice.tophive-cn-box',
				),
				'css_format' => 'styling', // styling.
				'fields'     => array(
					'normal_fields' => array(
						'text_color' => true,
						'link_color' => false,
						'padding'     => true,
						'margin'     => true,
						'border_heading' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => true,
						'box_shadow' => true,
						'border_style'  => false,
					),
					'hover_fields'  => false,
				),
			),
			array(
				'name'            => "{$section}_box_typo",
				'type'            => 'typography',
				'section'         => $section,
				'label'           => __( 'Message Typography', 'metafans' ),
				'selector'        => "{$selector} .notice-content",
				'css_format'      => 'typography',
			),

			array(
				'name'       => "{$section}_button_styling",
				'type'       => 'styling',
				'section'    => $section,
				'title'      => __( 'Button Styling', 'metafans' ),
				'selector'   => array(
					'normal' => '.tophive_cookie_notice .tophive-set-cookie.button, .tophive_cookie_notice.tophive-cn-box .tophive-set-cookie.button',
					'hover' => '.tophive_cookie_notice .tophive-set-cookie.button:hover, .tophive_cookie_notice.tophive-cn-box .tophive-set-cookie.button:hover',
				),
				'css_format' => 'styling', // styling.
				'fields'     => array(
					'normal_fields' => array(
						'text_color' => true,
						'link_color' => false,
						'padding'     => true,
						'margin'     => true,
						'border_heading' => false,
						'border_width' => false,
						'border_color' => false,
						'border_radius' => true,
						'box_shadow' => false,
						'border_style'  => false,
					),
					'hover_fields'  => array(
						'text_color' => true,
						'link_color' => false,
						'padding'     => false,
						'margin'     => false,
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
				'name'            => "{$section}_button_typo",
				'type'            => 'typography',
				'section'         => $section,
				'label'           => __( 'Button Typography', 'metafans' ),
				'selector'        => "{$selector} #tophive-accept-cookie",
				'css_format'      => 'typography',
			),
		);

		return array_merge( $configs, $config );
	}

	public function render() {
		$section = $this->section;
		$notice_message = tophive_metafans()->get_setting( "{$section}_message" );
		$ok_btn_text = tophive_metafans()->get_setting( "{$section}_button_text" );
		$message_position = tophive_metafans()->get_setting( "{$section}_message_position" );

		$position_class = array();

		$position_class[] = 'cn-position-' . $message_position;

		if ( 'top' != $message_position && 'bottom' != $message_position ) {
			$position_class[] = 'tophive-cn-box';
		}

		?>
		<div id="tophive_cookie_notice" class="tophive_cookie_notice <?php echo esc_attr( implode( ' ', $position_class ) ); ?>">
			<?php if ( '' != $notice_message ) { ?>
				<span class="notice-content"><?php echo wp_kses_post( $notice_message ); ?></span>
			<?php } ?>
			<?php if ( '' != $ok_btn_text ) { ?>
				<a href="#" id="tophive-accept-cookie" data-cookie-set="accept" class="tophive-set-cookie button"><?php echo esc_html( $ok_btn_text ); ?></a>
			<?php } ?>
		</div>
		<?php
	}

	public function body_class( $classes ) {
		$classes[] = 'no-cookie-bar';
		return $classes;
	}
}
