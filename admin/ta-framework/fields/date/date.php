<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: date
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'TAF_Field_date' ) ) {
	class TAF_Field_date extends TAF_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$default_settings = array(
				'dateFormat' => 'mm/dd/yy',
			);

			$settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
			$settings = wp_parse_args( $settings, $default_settings );

			echo wp_kses_post( $this->field_before() );

			if ( ! empty( $this->field['from_to'] ) ) {

				$args = wp_parse_args(
					$this->field,
					array(
						'text_from' => esc_html__( 'From', 'ta-framework' ),
						'text_to'   => esc_html__( 'To', 'ta-framework' ),
					)
				);

				$value = wp_parse_args(
					$this->value,
					array(
						'from' => '',
						'to'   => '',
					)
				);

				echo '<label class="taf--from">' . esc_attr( $args['text_from'] ) . ' <input type="text" name="' . esc_attr( $this->field_name( '[from]' ) ) . '" value="' . esc_attr( $value['from'] ) . '"' . wp_kses_post( $this->field_attributes() ) . '/></label>';
				echo '<label class="taf--to">' . esc_attr( $args['text_to'] ) . ' <input type="text" name="' . esc_attr( $this->field_name( '[to]' ) ) . '" value="' . esc_attr( $value['to'] ) . '"' . wp_kses_post( $this->field_attributes() ) . '/></label>';

			} else {

				echo '<input type="text" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '"' . wp_kses_post( $this->field_attributes() ) . '/>';

			}

			echo '<div class="taf-date-settings" data-settings="' . esc_attr( wp_json_encode( $settings ) ) . '"></div>';

			echo wp_kses_post( $this->field_after() );
		}

		public function enqueue() {

			if ( ! wp_script_is( 'jquery-ui-datepicker' ) ) {
				wp_enqueue_script( 'jquery-ui-datepicker' );
			}
		}
	}
}
