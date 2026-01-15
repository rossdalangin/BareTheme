<?php
/**
 * Customizer Control: Builder
 *
 * @package CLOSECLIENT_CUSTOMIZER_PRO
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * A custom control for the header/footer builder.
 */
class CLOSECLIENT_Builder_Control extends WP_Customize_Control {
	public $type = 'closeclient_builder';
	public $builder_type = 'header'; // 'header' or 'footer'

	/**
	 * Render the control's content.
	 */
	public function render_content() {
		?>
		<div class="closeclient-builder-control">
			<div class="available-modules">
				<h3><?php esc_html_e( 'Available Modules', 'closeclient-customizer-pro' ); ?></h3>
				<div class="module" data-type="logo"><?php esc_html_e( 'Logo', 'closeclient-customizer-pro' ); ?></div>
				<div class="module" data-type="navigation"><?php esc_html_e( 'Navigation', 'closeclient-customizer-pro' ); ?></div>
				<div class="module" data-type="button"><?php esc_html_e( 'Button', 'closeclient-customizer-pro' ); ?></div>
				<div class="module" data-type="social_icons"><?php esc_html_e( 'Social Icons', 'closeclient-customizer-pro' ); ?></div>
				<div class="module" data-type="search"><?php esc_html_e( 'Search', 'closeclient-customizer-pro' ); ?></div>
				<div class="module" data-type="announcement_bar"><?php esc_html_e( 'Announcement Bar', 'closeclient-customizer-pro' ); ?></div>
			</div>
            <div class="global-components-area">
                <h3><?php esc_html_e( 'Global Components', 'closeclient-customizer-pro' ); ?></h3>
                <div class="global-components-list">
                    <!-- Global components will be rendered here by JS -->
                </div>
            </div>
			<div class="builder-area">
				<!-- Rows will be rendered here by JS -->
			</div>
			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>">

			<div class="module-settings-modal" style="display:none;">
				<div class="modal-content">
					<span class="close">&times;</span>
					<div class="settings-form"></div>
				</div>
			</div>

            <div class="module-conditionals-modal" style="display:none;">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3><?php esc_html_e( 'Display Conditions', 'closeclient-customizer-pro' ); ?></h3>
                    <div class="conditionals-form">
                        <!-- Conditionals UI will be built by JS -->
                    </div>
                </div>
            </div>
		</div>
		<?php
	}
}
