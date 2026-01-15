<?php
/**
 * Customizer Control: Multi-Select
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * A custom control for selecting multiple items.
 */
class Multi_Select_Control extends WP_Customize_Control {
	public $type = 'multi-select';

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<?php
				foreach ( $this->choices as $value => $label ) {
					$selected = ( in_array( $value, $this->value() ) ) ? 'selected="selected"' : '';
					echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . esc_html( $label ) . '</option>';
				}
				?>
			</select>
		</label>
		<?php
	}
}
