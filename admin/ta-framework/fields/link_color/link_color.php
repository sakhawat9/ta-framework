<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: link_color
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'TAF_Field_link_color' ) ) {
	class TAF_Field_link_color extends TAF_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'color'   => true,
					'hover'   => true,
					'active'  => false,
					'visited' => false,
					'focus'   => false,
				)
			);

			$default_values = array(
				'color'   => '',
				'hover'   => '',
				'active'  => '',
				'visited' => '',
				'focus'   => '',
			);

			$color_props = array(
				'color'   => esc_html__( 'Normal', 'ta-framework' ),
				'hover'   => esc_html__( 'Hover', 'ta-framework' ),
				'active'  => esc_html__( 'Active', 'ta-framework' ),
				'visited' => esc_html__( 'Visited', 'ta-framework' ),
				'focus'   => esc_html__( 'Focus', 'ta-framework' ),
			);

			$value = wp_parse_args( $this->value, $default_values );

			echo wp_kses_post( $this->field_before() );

			foreach ( $color_props as $color_prop_key => $color_prop_value ) {

				if ( ! empty( $args[ $color_prop_key ] ) ) {

					$default_attr = ( ! empty( $this->field['default'][ $color_prop_key ] ) ) ? ' data-default-color="' . esc_attr( $this->field['default'][ $color_prop_key ] ) . '"' : '';

					echo '<div class="taf--left taf-field-color">';
					echo '<div class="taf--title">' . esc_attr( $color_prop_value ) . '</div>';
					echo '<input type="text" name="' . esc_attr( $this->field_name( '[' . $color_prop_key . ']' ) ) . '" value="' . esc_attr( $value[ $color_prop_key ] ) . '" class="taf-color"' . $default_attr . wp_kses_post( $this->field_attributes() ) . '/>';
					echo '</div>';

				}
			}

			echo wp_kses_post( $this->field_after() );
		}

		public function output() {

			$output    = '';
			$elements  = ( is_array( $this->field['output'] ) ) ? $this->field['output'] : array_filter( (array) $this->field['output'] );
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';

			if ( ! empty( $elements ) && isset( $this->value ) && $this->value !== '' ) {
				foreach ( $elements as $element ) {

					if ( isset( $this->value['color'] ) && $this->value['color'] !== '' ) {
						$output .= $element . '{color:' . $this->value['color'] . $important . ';}'; }
					if ( isset( $this->value['hover'] ) && $this->value['hover'] !== '' ) {
						$output .= $element . ':hover{color:' . $this->value['hover'] . $important . ';}'; }
					if ( isset( $this->value['active'] ) && $this->value['active'] !== '' ) {
							$output .= $element . ':active{color:' . $this->value['active'] . $important . ';}'; }
					if ( isset( $this->value['visited'] ) && $this->value['visited'] !== '' ) {
							$output .= $element . ':visited{color:' . $this->value['visited'] . $important . ';}'; }
					if ( isset( $this->value['focus'] ) && $this->value['focus'] !== '' ) {
						$output .= $element . ':focus{color:' . $this->value['focus'] . $important . ';}'; }
				}
			}

			$this->parent->output_css .= $output;

			return $output;
		}
	}
}
