<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'TAF_Field_backup' ) ) {
	class TAF_Field_backup extends TAF_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$unique = $this->unique;
			$nonce  = wp_create_nonce( 'taf_backup_nonce' );
			$export = add_query_arg(
				array(
					'action' => 'taf-export',
					'unique' => $unique,
					'nonce'  => $nonce,
				),
				admin_url( 'admin-ajax.php' )
			);

			echo wp_kses_post( $this->field_before() );

			echo '<textarea name="taf_import_data" class="taf-import-data"></textarea>';
			echo '<button type="submit" class="button button-primary taf-confirm taf-import" data-unique="' . esc_attr( $unique ) . '" data-nonce="' . esc_attr( $nonce ) . '">' . esc_html__( 'Import', 'ta-framework' ) . '</button>';
			echo '<hr />';
			echo '<textarea readonly="readonly" class="taf-export-data">' . esc_attr( json_encode( get_option( $unique ) ) ) . '</textarea>';
			echo '<a href="' . esc_url( $export ) . '" class="button button-primary taf-export" target="_blank">' . esc_html__( 'Export & Download', 'ta-framework' ) . '</a>';
			echo '<hr />';
			echo '<button type="submit" name="taf_transient[reset]" value="reset" class="button taf-warning-primary taf-confirm taf-reset" data-unique="' . esc_attr( $unique ) . '" data-nonce="' . esc_attr( $nonce ) . '">' . esc_html__( 'Reset', 'ta-framework' ) . '</button>';

			echo wp_kses_post( $this->field_after() );
		}
	}
}
