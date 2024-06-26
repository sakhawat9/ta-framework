<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: typography
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'TAF_Field_typography' ) ) {
	class TAF_Field_typography extends TAF_Fields {

		public $chosen = false;

		public $value = array();

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			echo wp_kses_post( $this->field_before() );

			$args = wp_parse_args(
				$this->field,
				array(
					'font_family'        => true,
					'font_weight'        => true,
					'font_style'         => true,
					'font_size'          => true,
					'line_height'        => true,
					'letter_spacing'     => true,
					'text_align'         => true,
					'text_transform'     => true,
					'color'              => true,
					'chosen'             => true,
					'preview'            => true,
					'subset'             => true,
					'multi_subset'       => false,
					'extra_styles'       => false,
					'backup_font_family' => false,
					'font_variant'       => false,
					'word_spacing'       => false,
					'text_decoration'    => false,
					'custom_style'       => false,
					'compact'            => false,
					'exclude'            => '',
					'unit'               => 'px',
					'line_height_unit'   => '',
					'preview_text'       => 'The quick brown fox jumps over the lazy dog',
				)
			);

			if ( $args['compact'] ) {
				$args['text_transform'] = false;
				$args['text_align']     = false;
				$args['font_size']      = false;
				$args['line_height']    = false;
				$args['letter_spacing'] = false;
				$args['preview']        = false;
				$args['color']          = false;
			}

			$default_value = array(
				'font-family'        => '',
				'font-weight'        => '',
				'font-style'         => '',
				'font-variant'       => '',
				'font-size'          => '',
				'line-height'        => '',
				'letter-spacing'     => '',
				'word-spacing'       => '',
				'text-align'         => '',
				'text-transform'     => '',
				'text-decoration'    => '',
				'backup-font-family' => '',
				'color'              => '',
				'custom-style'       => '',
				'type'               => '',
				'subset'             => '',
				'extra-styles'       => array(),
			);

			$default_value    = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;
			$this->value      = wp_parse_args( $this->value, $default_value );
			$this->chosen     = $args['chosen'];
			$chosen_class     = ( $this->chosen ) ? ' taf--chosen' : '';
			$line_height_unit = ( ! empty( $args['line_height_unit'] ) ) ? $args['line_height_unit'] : $args['unit'];

			echo '<div class="taf--typography' . esc_attr( $chosen_class ) . '" data-depend-id="' . esc_attr( $this->field['id'] ) . '" data-unit="' . esc_attr( $args['unit'] ) . '" data-line-height-unit="' . esc_attr( $line_height_unit ) . '" data-exclude="' . esc_attr( $args['exclude'] ) . '">';

			echo '<div class="taf--blocks taf--blocks-selects">';

			//
			// Font Family
			if ( ! empty( $args['font_family'] ) ) {	
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Font Family', 'ta-framework' ) . '</div>';
				echo $this->create_select( array( $this->value['font-family'] => $this->value['font-family'] ), 'font-family', esc_html__( 'Select a font', 'ta-framework' ) );
				echo '</div>';
			}

			//
			// Backup Font Family
			if ( ! empty( $args['backup_font_family'] ) ) {
				echo '<div class="taf--block taf--block-backup-font-family hidden">';
				echo '<div class="taf--title">' . esc_html__( 'Backup Font Family', 'ta-framework' ) . '</div>';
				echo $this->create_select(
					apply_filters(
						'taf_field_typography_backup_font_family',
						array(
							'Arial, Helvetica, sans-serif',
							"'Arial Black', Gadget, sans-serif",
							"'Comic Sans MS', cursive, sans-serif",
							'Impact, Charcoal, sans-serif',
							"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
							'Tahoma, Geneva, sans-serif',
							"'Trebuchet MS', Helvetica, sans-serif",
							'Verdana, Geneva, sans-serif',
							"'Courier New', Courier, monospace",
							"'Lucida Console', Monaco, monospace",
							'Georgia, serif',
							'Palatino Linotype',
						)
					),
					'backup-font-family',
					esc_html__( 'Default', 'ta-framework' )
				);
				echo '</div>';
			}

			//
			// Font Style and Extra Style Select
			if ( ! empty( $args['font_weight'] ) || ! empty( $args['font_style'] ) ) {

				//
				// Font Style Select
				echo '<div class="taf--block taf--block-font-style hidden">';
				echo '<div class="taf--title">' . esc_html__( 'Font Style', 'ta-framework' ) . '</div>';
				echo '<select class="taf--font-style-select" data-placeholder="Default">';
				echo '<option value="">' . ( ! $this->chosen ? esc_html__( 'Default', 'ta-framework' ) : '' ) . '</option>';
				if ( ! empty( $this->value['font-weight'] ) || ! empty( $this->value['font-style'] ) ) {
					echo '<option value="' . esc_attr( strtolower( $this->value['font-weight'] . $this->value['font-style'] ) ) . '" selected></option>';
				}
				echo '</select>';
				echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[font-weight]' ) ) . '" class="taf--font-weight" value="' . esc_attr( $this->value['font-weight'] ) . '" />';
				echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[font-style]' ) ) . '" class="taf--font-style" value="' . esc_attr( $this->value['font-style'] ) . '" />';

				//
				// Extra Font Style Select
				if ( ! empty( $args['extra_styles'] ) ) {
					echo '<div class="taf--block-extra-styles hidden">';
					echo ( ! $this->chosen ) ? '<div class="taf--title">' . esc_html__( 'Load Extra Styles', 'ta-framework' ) . '</div>' : '';
					$placeholder = ( $this->chosen ) ? esc_html__( 'Load Extra Styles', 'ta-framework' ) : esc_html__( 'Default', 'ta-framework' );
					echo $this->create_select( $this->value['extra-styles'], 'extra-styles', $placeholder, true );
					echo '</div>';
				}

				echo '</div>';

			}

			//
			// Subset
			if ( ! empty( $args['subset'] ) ) {
				echo '<div class="taf--block taf--block-subset hidden">';
				echo '<div class="taf--title">' . esc_html__( 'Subset', 'ta-framework' ) . '</div>';
				$subset = ( is_array( $this->value['subset'] ) ) ? $this->value['subset'] : array_filter( (array) $this->value['subset'] );
				echo $this->create_select( $subset, 'subset', esc_html__( 'Default', 'ta-framework' ), $args['multi_subset'] );
				echo '</div>';
			}

			//
			// Text Align
			if ( ! empty( $args['text_align'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Text Align', 'ta-framework' ) . '</div>';
				echo $this->create_select(
					array(
						'inherit' => esc_html__( 'Inherit', 'ta-framework' ),
						'left'    => esc_html__( 'Left', 'ta-framework' ),
						'center'  => esc_html__( 'Center', 'ta-framework' ),
						'right'   => esc_html__( 'Right', 'ta-framework' ),
						'justify' => esc_html__( 'Justify', 'ta-framework' ),
						'initial' => esc_html__( 'Initial', 'ta-framework' ),
					),
					'text-align',
					esc_html__( 'Default', 'ta-framework' )
				);
				echo '</div>';
			}

			//
			// Font Variant
			if ( ! empty( $args['font_variant'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Font Variant', 'ta-framework' ) . '</div>';
				echo $this->create_select(
					array(
						'normal'         => esc_html__( 'Normal', 'ta-framework' ),
						'small-caps'     => esc_html__( 'Small Caps', 'ta-framework' ),
						'all-small-caps' => esc_html__( 'All Small Caps', 'ta-framework' ),
					),
					'font-variant',
					esc_html__( 'Default', 'ta-framework' )
				);
				echo '</div>';
			}

			//
			// Text Transform
			if ( ! empty( $args['text_transform'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Text Transform', 'ta-framework' ) . '</div>';
				echo $this->create_select(
					array(
						'none'       => esc_html__( 'None', 'ta-framework' ),
						'capitalize' => esc_html__( 'Capitalize', 'ta-framework' ),
						'uppercase'  => esc_html__( 'Uppercase', 'ta-framework' ),
						'lowercase'  => esc_html__( 'Lowercase', 'ta-framework' ),
					),
					'text-transform',
					esc_html__( 'Default', 'ta-framework' )
				);
				echo '</div>';
			}

			//
			// Text Decoration
			if ( ! empty( $args['text_decoration'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Text Decoration', 'ta-framework' ) . '</div>';
				echo $this->create_select(
					array(
						'none'               => esc_html__( 'None', 'ta-framework' ),
						'underline'          => esc_html__( 'Solid', 'ta-framework' ),
						'underline double'   => esc_html__( 'Double', 'ta-framework' ),
						'underline dotted'   => esc_html__( 'Dotted', 'ta-framework' ),
						'underline dashed'   => esc_html__( 'Dashed', 'ta-framework' ),
						'underline wavy'     => esc_html__( 'Wavy', 'ta-framework' ),
						'underline overline' => esc_html__( 'Overline', 'ta-framework' ),
						'line-through'       => esc_html__( 'Line-through', 'ta-framework' ),
					),
					'text-decoration',
					esc_html__( 'Default', 'ta-framework' )
				);
				echo '</div>';
			}

			echo '</div>';

			echo '<div class="taf--blocks taf--blocks-inputs">';

			//
			// Font Size
			if ( ! empty( $args['font_size'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Font Size', 'ta-framework' ) . '</div>';
				echo '<div class="taf--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[font-size]' ) ) . '" class="taf--font-size taf--input taf-input-number" value="' . esc_attr( $this->value['font-size'] ) . '" step="any" />';
				echo '<span class="taf--unit">' . esc_attr( $args['unit'] ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Line Height
			if ( ! empty( $args['line_height'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Line Height', 'ta-framework' ) . '</div>';
				echo '<div class="taf--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[line-height]' ) ) . '" class="taf--line-height taf--input taf-input-number" value="' . esc_attr( $this->value['line-height'] ) . '" step="any" />';
				echo '<span class="taf--unit">' . esc_attr( $line_height_unit ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Letter Spacing
			if ( ! empty( $args['letter_spacing'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Letter Spacing', 'ta-framework' ) . '</div>';
				echo '<div class="taf--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[letter-spacing]' ) ) . '" class="taf--letter-spacing taf--input taf-input-number" value="' . esc_attr( $this->value['letter-spacing'] ) . '" step="any" />';
				echo '<span class="taf--unit">' . esc_attr( $args['unit'] ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			//
			// Word Spacing
			if ( ! empty( $args['word_spacing'] ) ) {
				echo '<div class="taf--block">';
				echo '<div class="taf--title">' . esc_html__( 'Word Spacing', 'ta-framework' ) . '</div>';
				echo '<div class="taf--input-wrap">';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[word-spacing]' ) ) . '" class="taf--word-spacing taf--input taf-input-number" value="' . esc_attr( $this->value['word-spacing'] ) . '" step="any" />';
				echo '<span class="taf--unit">' . esc_attr( $args['unit'] ) . '</span>';
				echo '</div>';
				echo '</div>';
			}

			echo '</div>';

			//
			// Font Color
			if ( ! empty( $args['color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['color'] ) ) ? ' data-default-color="' . esc_attr( $default_value['color'] ) . '"' : '';
				echo '<div class="taf--block taf--block-font-color">';
				echo '<div class="taf--title">' . esc_html__( 'Font Color', 'ta-framework' ) . '</div>';
				echo '<div class="taf-field-color">';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[color]' ) ) . '" class="taf-color taf--color" value="' . esc_attr( $this->value['color'] ) . '"' . wp_kses_post($default_color_attr) . ' />';
				echo '</div>';
				echo '</div>';
			}

			//
			// Custom style
			if ( ! empty( $args['custom_style'] ) ) {
				echo '<div class="taf--block taf--block-custom-style">';
				echo '<div class="taf--title">' . esc_html__( 'Custom Style', 'ta-framework' ) . '</div>';
				echo '<textarea name="' . esc_attr( $this->field_name( '[custom-style]' ) ) . '" class="taf--custom-style">' . esc_attr( $this->value['custom-style'] ) . '</textarea>';
				echo '</div>';
			}

			//
			// Preview
			$always_preview = ( $args['preview'] !== 'always' ) ? ' hidden' : '';

			if ( ! empty( $args['preview'] ) ) {
				echo '<div class="taf--block taf--block-preview' . esc_attr( $always_preview ) . '">';
				echo '<div class="taf--toggle fas fa-toggle-off"></div>';
				echo '<div class="taf--preview">' . esc_attr( $args['preview_text'] ) . '</div>';
				echo '</div>';
			}

			echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[type]' ) ) . '" class="taf--type" value="' . esc_attr( $this->value['type'] ) . '" />';
			echo '<input type="hidden" name="' . esc_attr( $this->field_name( '[unit]' ) ) . '" class="taf--unit-save" value="' . esc_attr( $args['unit'] ) . '" />';

			echo '</div>';

			echo wp_kses_post( $this->field_after() );
		}

		public function create_select( $options, $name, $placeholder = '', $is_multiple = false ) {

			$multiple_name = ( $is_multiple ) ? '[]' : '';
			$multiple_attr = ( $is_multiple ) ? ' multiple data-multiple="true"' : '';
			$chosen_rtl    = ( $this->chosen && is_rtl() ) ? ' chosen-rtl' : '';

			$output  = '<select name="' . esc_attr( $this->field_name( '[' . $name . ']' . $multiple_name ) ) . '" class="taf--' . esc_attr( $name ) . esc_attr( $chosen_rtl ) . '" data-placeholder="' . esc_attr( $placeholder ) . '"' . wp_kses_post($multiple_attr) . '>';
			$output .= ( ! empty( $placeholder ) ) ? '<option value="">' . esc_attr( ( ! $this->chosen ) ? $placeholder : '' ) . '</option>' : '';

			if ( ! empty( $options ) ) {
				foreach ( $options as $option_key => $option_value ) {
					if ( $is_multiple ) {
						$selected = ( in_array( $option_value, $this->value[ $name ] ) ) ? ' selected' : '';
						$output  .= '<option value="' . esc_attr( $option_value ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $option_value ) . '</option>';
					} else {
						$option_key = ( is_numeric( $option_key ) ) ? $option_value : $option_key;
						$selected   = ( $option_key === $this->value[ $name ] ) ? ' selected' : '';
						$output    .= '<option value="' . esc_attr( $option_key ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $option_value ) . '</option>';
					}
				}
			}

			$output .= '</select>';

			return $output;
		}

		public function enqueue() {

			if ( ! wp_script_is( 'taf-webfontloader' ) ) {

				TAF::include_plugin_file( 'fields/typography/google-fonts.php' );

				wp_enqueue_script( 'webfontloader', TAF_DIR_URL . 'admin/ta-framework/assets/js/webfontloader.min.js', array( 'taf' ), '1.6.28', true );

				$webfonts = array();

				$customwebfonts = apply_filters( 'taf_field_typography_customwebfonts', array() );

				if ( ! empty( $customwebfonts ) ) {
					$webfonts['custom'] = array(
						'label' => esc_html__( 'Custom Web Fonts', 'ta-framework' ),
						'fonts' => $customwebfonts,
					);
				}

				$webfonts['safe'] = array(
					'label' => esc_html__( 'Safe Web Fonts', 'ta-framework' ),
					'fonts' => apply_filters(
						'taf_field_typography_safewebfonts',
						array(
							'Arial',
							'Arial Black',
							'Helvetica',
							'Times New Roman',
							'Courier New',
							'Tahoma',
							'Verdana',
							'Impact',
							'Trebuchet MS',
							'Comic Sans MS',
							'Lucida Console',
							'Lucida Sans Unicode',
							'Georgia, serif',
							'Palatino Linotype',
						)
					),
				);

				$webfonts['google'] = array(
					'label' => esc_html__( 'Google Web Fonts', 'ta-framework' ),
					'fonts' => apply_filters(
						'taf_field_typography_googlewebfonts',
						taf_get_google_fonts()
					),
				);

				$defaultstyles = apply_filters( 'taf_field_typography_defaultstyles', array( 'normal', 'italic', '700', '700italic' ) );

				$googlestyles = apply_filters(
					'taf_field_typography_googlestyles',
					array(
						'100'       => __('Thin 100', 'ta-framework'),
						'100italic' => __('Thin 100 Italic', 'ta-framework'),
						'200'       => __('Extra-Light 200', 'ta-framework'),
						'200italic' => __('Extra-Light 200 Italic', 'ta-framework'),
						'300'       => __('Light 300', 'ta-framework'),
						'300italic' => __('Light 300 Italic', 'ta-framework'),
						'normal'    => __('Normal 400', 'ta-framework'),
						'italic'    => __('Normal 400 Italic', 'ta-framework'),
						'500'       => __('Medium 500', 'ta-framework'),
						'500italic' => __('Medium 500 Italic', 'ta-framework'),
						'600'       => __('Semi-Bold 600', 'ta-framework'),
						'600italic' => __('Semi-Bold 600 Italic', 'ta-framework'),
						'700'       => __('Bold 700', 'ta-framework'),
						'700italic' => __('Bold 700 Italic', 'ta-framework'),
						'800'       => __('Extra-Bold 800', 'ta-framework'),
						'800italic' => __('Extra-Bold 800 Italic', 'ta-framework'),
						'900'       => __('Black 900', 'ta-framework'),
						'900italic' => __('Black 900 Italic', 'ta-framework'),
					)
				);

				$webfonts = apply_filters( 'taf_field_typography_webfonts', $webfonts );

				wp_localize_script(
					'taf',
					'taf_typography_json',
					array(
						'webfonts'      => $webfonts,
						'defaultstyles' => $defaultstyles,
						'googlestyles'  => $googlestyles,
					)
				);

			}
		}

		public function enqueue_google_fonts( $method = 'enqueue' ) {

			$is_google = false;

			if ( ! empty( $this->value['type'] ) ) {
				$is_google = ( $this->value['type'] === 'google' ) ? true : false;
			} else {
				TAF::include_plugin_file( 'fields/typography/google-fonts.php' );
				$is_google = ( array_key_exists( $this->value['font-family'], taf_get_google_fonts() ) ) ? true : false;
			}

			if ( $is_google ) {

				// set style
				$font_family = ( ! empty( $this->value['font-family'] ) ) ? $this->value['font-family'] : '';
				$font_weight = ( ! empty( $this->value['font-weight'] ) ) ? $this->value['font-weight'] : '';
				$font_style  = ( ! empty( $this->value['font-style'] ) ) ? $this->value['font-style'] : '';

				if ( $font_weight || $font_style ) {
					$style = $font_weight . $font_style;
					if ( ! empty( $style ) ) {
						$style = ( $style === 'normal' ) ? '400' : $style;
						TAF::$webfonts[ $method ][ $font_family ][ $style ] = $style;
					}
				} else {
					TAF::$webfonts[ $method ][ $font_family ] = array();
				}

				// set extra styles
				if ( ! empty( $this->value['extra-styles'] ) ) {
					foreach ( $this->value['extra-styles'] as $extra_style ) {
						if ( ! empty( $extra_style ) ) {
								$extra_style = ( $extra_style === 'normal' ) ? '400' : $extra_style;
								TAF::$webfonts[ $method ][ $font_family ][ $extra_style ] = $extra_style;
						}
					}
				}

				// set subsets
				if ( ! empty( $this->value['subset'] ) ) {
					$this->value['subset'] = ( is_array( $this->value['subset'] ) ) ? $this->value['subset'] : array_filter( (array) $this->value['subset'] );
					foreach ( $this->value['subset'] as $subset ) {
						if ( ! empty( $subset ) ) {
								TAF::$subsets[ $subset ] = $subset;
						}
					}
				}

				return true;

			}

			return false;
		}

		public function output() {

			$output    = '';
			$bg_image  = array();
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
			$element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

			$font_family   = ( ! empty( $this->value['font-family'] ) ) ? $this->value['font-family'] : '';
			$backup_family = ( ! empty( $this->value['backup-font-family'] ) ) ? ', ' . $this->value['backup-font-family'] : '';

			if ( $font_family ) {
				$output .= 'font-family:"' . $font_family . '"' . $backup_family . $important . ';';
			}

			// Common font properties
			$properties = array(
				'color',
				'font-weight',
				'font-style',
				'font-variant',
				'text-align',
				'text-transform',
				'text-decoration',
			);

			foreach ( $properties as $property ) {
				if ( isset( $this->value[ $property ] ) && $this->value[ $property ] !== '' ) {
					$output .= $property . ':' . $this->value[ $property ] . $important . ';';
				}
			}

			$properties = array(
				'font-size',
				'line-height',
				'letter-spacing',
				'word-spacing',
			);

			$unit             = ( ! empty( $this->value['unit'] ) ) ? $this->value['unit'] : 'px';
			$line_height_unit = ( ! empty( $this->value['line_height_unit'] ) ) ? $this->value['line_height_unit'] : $unit;

			foreach ( $properties as $property ) {
				if ( isset( $this->value[ $property ] ) && $this->value[ $property ] !== '' ) {
					$unit    = ( $property === 'line-height' ) ? $line_height_unit : $unit;
					$output .= $property . ':' . $this->value[ $property ] . $unit . $important . ';';
				}
			}

			$custom_style = ( ! empty( $this->value['custom-style'] ) ) ? $this->value['custom-style'] : '';

			if ( $output ) {
				$output = $element . '{' . $output . $custom_style . '}';
			}

			$this->parent->output_css .= $output;

			return $output;
		}
	}
}
