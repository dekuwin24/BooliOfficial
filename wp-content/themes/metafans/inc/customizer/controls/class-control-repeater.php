<?php

class Tophive_Customizer_Control_Repeater extends Tophive_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-tophive-repeater">
			<?php
			self::before_field();
			?>
			<?php echo self::field_header(); ?>
			<div class="tophive-field-settings-inner">
			</div>
			<?php
			self::after_field();
			?>
		</script>
		<script type="text/html" id="tmpl-customize-control-repeater-item">
			<div class="tophive--repeater-item">
				<div class="tophive--repeater-item-heading">
					<label class="tophive--repeater-visible" title="<?php esc_attr_e( 'Toggle item visible', 'metafans' ); ?>">
						<input type="checkbox" class="r-visible-input">
						<span class="r-visible-icon"></span>
						<span class="screen-reader-text"><?php _e( 'Show', 'metafans' ); ?></label>
					<span class="tophive--repeater-live-title"></span>
					<div class="tophive-nav-reorder">
						<span class="tophive--down" tabindex="-1">
							<span class="screen-reader-text"><?php _e( 'Move Down', 'metafans' ); ?></span></span>
						<span class="tophive--up" tabindex="0">
							<span class="screen-reader-text"><?php _e( 'Move Up', 'metafans' ); ?></span>
						</span>
					</div>
					<a href="#" class="tophive--repeater-item-toggle">
						<span class="screen-reader-text"><?php _e( 'Close', 'metafans' ); ?></span></a>
				</div>
				<div class="tophive--repeater-item-settings">
					<div class="tophive--repeater-item-inside">
						<div class="tophive--repeater-item-inner"></div>
						<# if ( data.addable ){ #>
						<a href="#" class="tophive--remove"><?php _e( 'Remove', 'metafans' ); ?></a>
						<# } #>
					</div>
				</div>
			</div>
		</script>
		<script type="text/html" id="tmpl-customize-control-repeater-inner">
			<div class="tophive--repeater-inner">
				<div class="tophive--settings-fields tophive--repeater-items"></div>
				<div class="tophive--repeater-actions">
				<a href="#" class="tophive--repeater-reorder"
				data-text="<?php esc_attr_e( 'Reorder', 'metafans' ); ?>"
				data-done="<?php _e( 'Done', 'metafans' ); ?>"><?php _e( 'Reorder', 'metafans' ); ?></a>
					<# if ( data.addable ){ #>
					<button type="button"
							class="button tophive--repeater-add-new"><?php _e( 'Add an item', 'metafans' ); ?></button>
					<# } #>
				</div>
			</div>
		</script>
		<?php
	}
}
