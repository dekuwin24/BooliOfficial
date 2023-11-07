<?php
// Nav Menu Item Custom fields for adding icons

add_action( 'admin_init', array( 'Tophive_Nav_Menu_Item_Custom_Fields', 'setup' ) );

class Tophive_Nav_Menu_Item_Custom_Fields {
	static $options = array(
		'item_tpl' => '
			<p class="additional-menu-field-{name} description description-thin">
				<label for="edit-menu-item-{name}-{id}">{label}</label>
					<br>
					<input
						type="{input_type}"
						id="edit-menu-item-{name}-{id}"
						class="widefat code edit-menu-item-{name}"
						name="menu-item-{name}[{id}]"
						value="{value}">
			</p>
		',
	);

	static function setup() {
		if ( !is_admin() )
			return;

		$new_fields = apply_filters( 'tophive_nav_menu_item_additional_fields', array() );
		if ( empty($new_fields) )
			return;
		self::$options['fields'] = self::get_fields_schema( $new_fields );

		add_filter( 'wp_edit_nav_menu_walker', function () {
			return 'Tophive_Walker_Nav_Menu_Edit';
		});
		//add_filter( 'tophive_nav_menu_item_additional_fields', array( __CLASS__, '_add_fields' ), 10, 5 );
		add_action( 'save_post', array( __CLASS__, '_save_post' ), 10, 2 );
	}

	static function get_fields_schema( $new_fields ) {
		$schema = array();
		foreach( $new_fields as $name => $field) {
			if (empty($field['name'])) {
				$field['name'] = $name;
			}
			$schema[] = $field;
		}
		return $schema;
	}

	static function get_menu_item_postmeta_key($name) {
		return '_menu_item_' . $name;
	}

	/**
	 * Inject the 
	 * @hook {action} save_post
	 */
	static function get_field( $item, $depth, $args ) {
		$icon_url = get_post_meta($item->ID, '_menu_item_menu-icon-text', true);
		$new_fields = '';
			foreach( self::$options['fields'] as $field ) {
				$field['value'] = get_post_meta($item->ID, self::get_menu_item_postmeta_key($field['name']), true);
				$field['id'] = $item->ID;

				// $new_fields .= $item->ID;
				if( $field['name'] == 'menu-icon' ){
					if(!empty($icon_url)){
						$new_fields .= '<p class="additional-menu-field-'. $field['name'] .' description description-thin has-image">
							<label for="edit-menu-item-'. $field['name'] .'-'. $field['id'] .'">'. $field['label'] .'</label>
								<br>
								<input
									type="'. $field['input_type'] .'"
									id="edit-menu-item-'. $field['name'] .'-'. $field['id'] .'"
									class="widefat code edit-menu-item-'. $field['name'] .'"
									name="menu-item-'. $field['name'] .'['. $field['id'] .']"
									value="">
								<img src="'. $icon_url .'" />
								<span class="remove-img">✕</span>
						</p>';
					}else{
						$new_fields .= str_replace(
							array_map(function($key){ return '{' . $key . '}'; }, array_keys($field)),
							array_values(array_map('esc_attr', $field)),
							self::$options['item_tpl']
						);
					}
				}else{
					$new_fields .= str_replace(
						array_map(function($key){ return '{' . $key . '}'; }, array_keys($field)),
						array_values(array_map('esc_attr', $field)),
						self::$options['item_tpl']
					);
				}
			}
		return $new_fields;
	}

	/**
	 * Save the newly submitted fields
	 * @hook {action} save_post
	 */
	static function _save_post($post_id, $post) {
		if ( $post->post_type !== 'nav_menu_item' ) {
			return $post_id; // prevent weird things from happening
		}

		foreach( self::$options['fields'] as $field_schema ) {
			$form_field_name = 'menu-item-' . $field_schema['name'];
			// @todo FALSE should always be used as the default $value, otherwise we wouldn't be able to clear checkboxes
			if (isset($_POST[$form_field_name][$post_id])) {
				$key = self::get_menu_item_postmeta_key($field_schema['name']);
				$value = stripslashes($_POST[$form_field_name][$post_id]);
				update_post_meta($post_id, $key, $value);
			}
		}
	}

}

// @todo This class needs to be in it's own file so we can include id J.I.T.
// requiring the nav-menu.php file on every page load is not so wise
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
class Tophive_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
	function start_el(&$output, $item, $depth = 0, $args = NULL, $id = 0) {
		$item_output = '';
		parent::start_el($item_output, $item, $depth, $args);
		// Inject $new_fields before: <div class="menu-item-actions description-wide submitbox">
		if ( $new_fields = Tophive_Nav_Menu_Item_Custom_Fields::get_field( $item, $depth, $args ) ) {
			$item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $new_fields, $item_output);
		}
		$output .= $item_output;
	}
}

add_filter( 'tophive_nav_menu_item_additional_fields', 'tophive_menu_item_additional_fields' );
function tophive_menu_item_additional_fields( $fields ) {
	$fields['icon'] = array(
		'name' => 'menu-icon',
		'label' => __('Menu Icon', 'metafans'),
		'container_class' => 'menu-icon',
		'input_type' => 'file',
	);
	$fields['icon-text'] = array(
		'name' => 'menu-icon-text',
		'label' => __('', 'metafans'),
		'container_class' => 'menu-icon-text',
		'input_type' => 'hidden',
	);
	
	return $fields;
}

function tophive_register_menus(){
	register_nav_menus( 
		array(
	        'vertical-menu' => __( 'Vertical Menu', 'metafans' ),
	    )
	);	
	register_nav_menus( 
		array(
	        'footer-menu' => __( 'Footer Menu', 'metafans' ),
	    )
	);
}
add_action( 'after_setup_theme', 'tophive_register_menus', 0 );