<?php
class Tophive_Customizer_Control_Styling extends Tophive_Customizer_Control_Modal {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-tophive-styling">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="tophive-actions">
			<a href="#" title="<?php esc_attr_e( 'Reset to default', 'metafans' ); ?>" class="action--reset" data-control="{{ field.name }}"><span class="dashicons dashicons-image-rotate"></span></a>
			<a href="#" title="<?php esc_attr_e( 'Toggle edit panel', 'metafans' ); ?>" class="action--edit" data-control="{{ field.name }}"><span class="dashicons dashicons-edit"></span></a>
		</div>
		<div class="tophive-field-settings-inner">
			<input type="hidden" class="tophive-hidden-modal-input tophive-only" data-name="{{ field.name }}" value="{{ JSON.stringify( field.value ) }}" data-default="{{ JSON.stringify( field.default ) }}">
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<script type="text/html" id="tmpl-tophive-modal-settings">
			<div class="tophive-modal-settings">
				<div class="tophive-modal-settings--inner">
					<div class="tophive-modal-settings--fields"></div>
				</div>
			</div>
		</script>
		<?php
	}
}
