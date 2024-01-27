<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: code_editor
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'TAF_Field_code_editor' ) ) {
	class TAF_Field_code_editor extends TAF_Fields {

		public $version = '6.65.7';

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$default_settings = array(
				'tabSize'     => 2,
				'lineNumbers' => true,
				'theme'       => 'default',
				'mode'        => 'htmlmixed',
			);

			$settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
			$settings = wp_parse_args( $settings, $default_settings );

			echo wp_kses_post( $this->field_before() );
			echo '<textarea name="' . esc_attr( $this->field_name() ) . '"' . wp_kses_post( $this->field_attributes() ) . ' data-editor="' . esc_attr( json_encode( $settings ) ) . '">' . wp_kses_post($this->value) . '</textarea>';
			echo wp_kses_post( $this->field_after() );
		}

		public function enqueue() {

			$page = ( ! empty( $_GET['page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

			// Do not loads CodeMirror in revslider page.
			if ( in_array( $page, array( 'revslider' ) ) ) {
				return; }

			if ( ! wp_script_is( 'taf-codemirror' ) ) {
				wp_enqueue_script( 'codemirror', TAF_DIR_URL . 'admin/ta-framework/assets/js/codemirror.min.js', array( 'ta-framework' ), $this->version, true );
				wp_enqueue_script( 'loadmode', TAF_DIR_URL . 'admin/ta-framework/assets/js/loadmode.min.js', array( 'taf-codemirror' ), $this->version, true );
			}

			if ( ! wp_style_is( 'taf-codemirror' ) ) {
				wp_enqueue_style( 'codemirror', TAF_DIR_URL . 'admin/ta-framework/assets/css/codemirror.min.css', array(), $this->version );
			}
		}
	}
}
