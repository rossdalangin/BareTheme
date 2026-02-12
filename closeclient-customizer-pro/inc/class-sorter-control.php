<?php
/**
 * Customizer Control: Sorter
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * A custom control for sorting and enabling/disabling sections.
 */
class Sorter_Control extends WP_Customize_Control {
	public $type = 'sorter';

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="sorter-container">
				<ul class="sorter-list">
					<?php
					$saved_value = $this->value();
					foreach ( $this->choices as $value => $label ) {
						$enabled = isset( $saved_value[ $value ] ) ? $saved_value[ $value ] : true;
						?>
						<li data-value="<?php echo esc_attr( $value ); ?>">
							<span class="dashicons dashicons-menu handle"></span>
							<?php echo esc_html( $label ); ?>
							<input type="checkbox" <?php checked( $enabled ); ?> class="sorter-checkbox" />
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		</label>
		<input type="hidden" <?php $this->link(); ?> />
		<?php
	}
}
