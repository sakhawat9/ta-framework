<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'TAF_Field_icon' ) ) {
	class TAF_Field_icon extends TAF_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'button_title' => esc_html__( 'Add Icon', 'ta-framework' ),
					'remove_title' => esc_html__( 'Remove Icon', 'ta-framework' ),
				)
			);

			echo wp_kses_post( $this->field_before() );

			$nonce  = wp_create_nonce( 'taf_icon_nonce' );
			$hidden = ( empty( $this->value ) ) ? ' hidden' : '';

			echo '<div class="taf-icon-select">';
			echo '<span class="taf-icon-preview' . esc_attr( $hidden ) . '"><i class="' . esc_attr( $this->value ) . '"></i></span>';
			echo '<a href="#" class="button button-primary taf-icon-add" data-nonce="' . esc_attr( $nonce ) . '">' . $args['button_title'] . '</a>';
			echo '<a href="#" class="button taf-warning-primary taf-icon-remove' . esc_attr( $hidden ) . '">' . $args['remove_title'] . '</a>';
			echo '<input type="hidden" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '" class="taf-icon-value"' . $this->field_attributes() . ' />';
			echo '</div>';

			echo wp_kses_post( $this->field_after() );
		}

		public function enqueue() {
			add_action( 'admin_footer', array( 'TAF_Field_icon', 'add_footer_modal_icon' ) );
			add_action( 'customize_controls_print_footer_scripts', array( 'TAF_Field_icon', 'add_footer_modal_icon' ) );
		}

		public static function add_footer_modal_icon() {
			?>
		<div id="taf-modal-icon" class="taf-modal taf-modal-icon hidden">
		<div class="taf-modal-table">
			<div class="taf-modal-table-cell">
			<div class="taf-modal-overlay"></div>
			<div class="taf-modal-inner">
				<div class="taf-modal-title">
				<?php esc_html_e( 'Add Icon', 'ta-framework' ); ?>
				<div class="taf-modal-close taf-icon-close"></div>
				</div>
				<div class="taf-modal-header">
				<input type="text" placeholder="<?php esc_html_e( 'Search...', 'ta-framework' ); ?>" class="taf-icon-search" />
				</div>
				<div class="taf-modal-content">
				<div class="taf-modal-loading"><div class="taf-loading"></div></div>
				<div class="taf-modal-load"></div>
				</div>
			</div>
			</div>
		</div>
		</div>
			<?php
		}
	}
}
