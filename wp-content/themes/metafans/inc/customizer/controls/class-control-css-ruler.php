<?php
class Tophive_Customizer_Control_Css_Ruler extends Tophive_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-tophive-css_ruler">
		<?php
		self::before_field();
		?>
		<#
		if ( ! _.isObject( field.value ) ) {
			field.value = { link: 1 };
		}

		var fields_disabled;
		if ( ! _.isObject( field.fields_disabled ) ) {
			fields_disabled = {};
		} else {
			fields_disabled = _.clone( field.fields_disabled );
		}

		var defaultpl = <?php echo json_encode( esc_html__( 'Auto', 'metafans' ) ); // phpcs:ignore ?>;

		_.each( [ 'top', 'right', 'bottom', 'left' ], function( key ){
			if ( ! _.isUndefined( fields_disabled[ key ] ) ) {
				if ( ! fields_disabled[ key ] ) {
					fields_disabled[ key ] = defaultpl;
				}
			} else {
				fields_disabled[ key ] = false;
			}
		} );

		var uniqueID = field.name + ( new Date().getTime() );
		#>
		<?php echo self::field_header(); ?>
		<div class="tophive-field-settings-inner">
			<div class="tophive--css-unit" title="<?php esc_attr_e( 'Chose an unit', 'metafans' ); ?>">
				<label class="<# if ( field.value.unit == 'px' || ! field.value.unit ){ #> tophive--label-active <# } #>">
					<?php _e( 'px', 'metafans' ); ?>
					<input type="radio" class="tophive-input tophive--label-parent change-by-js" <# if ( field.value.unit == 'px' || ! field.value.unit ){ #> checked="checked" <# } #> data-name="{{ field.name }}-unit" name="r{{ uniqueID }}" value="px">
				</label>
				<label class="<# if ( field.value.unit == 'rem' ){ #> tophive--label-active <# } #>">
					<?php _e( 'rem', 'metafans' ); ?>
					<input type="radio" class="tophive-input tophive--label-parent change-by-js" <# if ( field.value.unit == 'rem' ){ #> checked="checked" <# } #> data-name="{{ field.name }}-unit" name="r{{ uniqueID }}" value="rem">
				</label>
				<label class="<# if ( field.value.unit == 'em' ){ #> tophive--label-active <# } #>">
					<?php _e( 'em', 'metafans' ); ?>
					<input type="radio" class="tophive-input tophive--label-parent change-by-js" <# if ( field.value.unit == 'em' ){ #> checked="checked" <# } #> data-name="{{ field.name }}-unit" name="r{{ uniqueID }}" value="em">
				</label>
				<label class="<# if ( field.value.unit == '%' ){ #> tophive--label-active <# } #>">
					<?php _e( '%', 'metafans' ); ?>
					<input type="radio" class="tophive-input tophive--label-parent change-by-js" <# if ( field.value.unit == '%' ){ #> checked="checked" <# } #> data-name="{{ field.name }}-unit" name="r{{ uniqueID }}" value="%">
				</label>
			</div>
			<div class="tophive--css-ruler tophive--gr-inputs">
				<span>
					<input type="number" class="tophive-input tophive-input-css change-by-js" <# if ( fields_disabled['top'] ) {  #> disabled="disabled" placeholder="{{ fields_disabled['top'] }}" <# } #> data-name="{{ field.name }}-top" value="{{ field.value.top }}">
					<span class="tophive--small-label"><?php _e( 'Top', 'metafans' ); ?></span>
				</span>
				<span>
					<input type="number" class="tophive-input tophive-input-css change-by-js" <# if ( fields_disabled['right'] ) {  #> disabled="disabled" placeholder="{{ fields_disabled['right'] }}" <# } #> data-name="{{ field.name }}-right" value="{{ field.value.right }}">
					<span class="tophive--small-label"><?php _e( 'Right', 'metafans' ); ?></span>
				</span>
				<span>
					<input type="number" class="tophive-input tophive-input-css change-by-js" <# if ( fields_disabled['bottom'] ) {  #> disabled="disabled" placeholder="{{ fields_disabled['bottom'] }}" <# } #> data-name="{{ field.name }}-bottom" value="{{ field.value.bottom }}">
					<span class="tophive--small-label"><?php _e( 'Bottom', 'metafans' ); ?></span>
				</span>
				<span>
					<input type="number" class="tophive-input tophive-input-css change-by-js" <# if ( fields_disabled['left'] ) {  #> disabled="disabled" placeholder="{{ fields_disabled['left'] }}" <# } #> data-name="{{ field.name }}-left" value="{{ field.value.left }}">
					<span class="tophive--small-label"><?php _e( 'Left', 'metafans' ); ?></span>
				</span>
				<label title="<?php esc_attr_e( 'Toggle values together', 'metafans' ); ?>" class="tophive--css-ruler-link <# if ( field.value.link == 1 ){ #> tophive--label-active <# } #>">
					<input type="checkbox" class="tophive-input tophive--label-parent change-by-js" <# if ( field.value.link == 1 ){ #> checked="checked" <# } #> data-name="{{ field.name }}-link" value="1">
				</label>
			</div>
		</div>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
