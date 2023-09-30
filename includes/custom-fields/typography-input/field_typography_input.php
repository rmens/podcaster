<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - render()
 * - enqueue()
 * - makeGoogleWebfontLink()
 * - makeGoogleWebfontString()
 * - output()
 * - getGoogleArray()
 * - getSubsets()
 * - getVariants()
 * Classes list:
 * - ReduxFramework_typography
 */

if ( ! class_exists( 'ReduxFramework_typography_input' ) ) {
    class ReduxFramework_typography_input {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since ReduxFramework 1.0.0
         */
        function __construct( $field = array(), $value = '', $parent ) {

            // Define the fields of the class.
            $this->parent = $parent;
            $this->field  = $field;
            $this->value  = $value;
            
            if( ! is_admin()){
            }

            // Shim out old arg to new
            if ( isset( $this->field['all_styles'] ) && ! empty( $this->field['all_styles'] ) ) {
                $this->field['all-styles'] = $this->field['all_styles'];
                unset ( $this->field['all_styles'] );
            }

            // Set field array defaults. No errors please.
            $defaults    = array(
                'font-family'     => true,
                'font-size'       => true,
                'font-weight'     => true,
                'font-style'      => true,
                'font-backup'     => false,
                'text-state'      => true,
                'custom_fonts'    => true,
                'text-align'      => true,
                'text-transform'  => false,
                'font-variant'    => false,
                'text-decoration' => false,
                'color'           => true,
                'line-height'     => true,
                'word-spacing'    => false,
                'letter-spacing'  => false,
            );

            // Merge together the array of $this->field and $defaults array
            $this->field = wp_parse_args( $this->field, $defaults );

            // Set value defaults.
            $defaults    = array(
                'font-family'     => '',
                'text-state'      => '',
                'font-options'    => '',
                'font-backup'     => '',
                'text-align'      => '',
                'text-transform'  => '',
                'font-variant'    => '',
                'text-decoration' => '',
                'line-height'     => '',
                'word-spacing'    => '',
                'letter-spacing'  => '',
                'font-script'     => '',
                'font-weight'     => '',
                'font-style'      => '',
                'color'           => '',
                'font-size'       => '',
            );

            // Merge together the array of $this->value and $defaults array
            $this->value = wp_parse_args( $this->value, $defaults );


        }


        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since ReduxFramework 1.0.0
         */
        function render() {
            // Since fonts declared is CSS (@font-face) are not rendered in the preview,
            // they can be declared in a CSS file and passed here so they DO display in
            // font preview. Do NOT pass style.css in your theme, as that will mess up
            // admin page styling. It's recommended to pass a CSS file with ONLY font
            // declarations.

            // If field is set and not blank, then enqueue field
            if ( isset( $this->field['ext-font-css'] ) && $this->field['ext-font-css'] != '' ) {
                wp_register_style( 'redux-external-fonts', $this->field['ext-font-css'] );
                wp_enqueue_style( 'redux-external-fonts' );
            }

            // Manage typography defualt unit.
            if ( empty( $this->field['units'] ) && ! empty( $this->field['default']['units'] ) ) {
                $this->field['units'] = $this->field['default']['units'];
            }

            if ( empty( $this->field['units'] ) || ! in_array( $this->field['units'], array(
                    'px',
                    'em',
                    'rem',
                    '%'
                ) )
            ) {
                $this->field['units'] = 'px';
            }

            $unit = $this->field['units'];

            // Open <div> for the entire typography input field.
            echo '<div id="' . $this->field['id'] . '" class="redux-typography-container" data-id="' . $this->field['id'] . '" data-units="' . $unit . '">';

            // If there are any fields that are select2, use the following.
            if ( isset( $this->field['select2'] ) ) { // if there are any let's pass them to js
                $select2_params = json_encode( $this->field['select2'] );
                $select2_params = htmlspecialchars( $select2_params, ENT_QUOTES );

                echo '<input type="hidden" class="select2_params" value="' . $select2_params . '">';
            }

            /* Font Family: If the font-family field is active, display the following field. 
             * It consists of a <div> wrapper, label and input text field. */
            if ( $this->field['font-family'] === true ) {
                echo '<div class="select_wrapper typography-family" style="width: 220px; margin-right: 5px;">';
                
                    echo '<label>' . esc_html__( 'Font Family', "podcaster" ) . '</label>';
                    echo '<input type="text" class="redux-typography-font-family ' . $this->field['class'] . '" style="width:100%" name="' . $this->field['name'] . $this->field['name_suffix'] . '[font-family]' . '" value="' . $this->value['font-family'] . '" data-id="' . $this->field['id'] . '" />';

                echo '</div>';
            }

            /* Font Style: If the font-style field is active, display the following field.
             * It consists of:
             * <div>-wrapper
             * label
             * input field with 
             * select
                * options
             */

            if ( $this->field['font-style'] === true  ) {

                echo '<div class="select_wrapper typography-style" original-title="' . esc_html__( 'Font style', "podcaster" ) . '">';

                    echo '<label>' . esc_html__( 'Font Style', "podcaster" ) . '</label>';

                    // Defines variable ($style) that contains font style.
                    $style = $this->value['font-style'];
                    
                    echo '<input type="hidden" class="typography-font-style" name="' . $this->field['name'] . $this->field['name_suffix'] . '[font-style]' . '" value="' . $this->value['font-style'] . '" data-id="' . $this->field['id'] . '"  /> ';

                    //## Defines variable ($multi) that contains font multiple styles.
                    $multi = ( isset( $this->field['multi']['style'] ) && $this->field['multi']['style'] ) ? ' multiple="multiple"' : "";
                    
                    // Creates drop-down menu which contains font styles.
                    echo '<select' . $multi . ' data-placeholder="' . esc_html__( 'Style', "podcaster" ) . '" class="redux-typography redux-typography-style select ' . $this->field['class'] . '" original-title="' . esc_html__( 'Font style', "podcaster" ) . '" id="' . $this->field['id'] . '_style" data-id="' . $this->field['id'] . '" data-value="' . $style . '">';

                        // If empty, display empty option.
                        if ( empty( $this->value['font-style'] ) ) {
                            echo '<option value=""></option>';
                        }

                        // Styles to be used.
                        $stylesArray = array(
                            'normal' => 'Normal',
                            'italic' => 'Italic',
                        );

                        // Use foreach to loop styles into <option>-tags.
                        foreach ( $stylesArray as $i => $style ) {

                            // If font-stlye is not set, set it to false.
                            if ( ! isset( $this->value['font-style'] ) ) {
                                $this->value['font-style'] = false;
                            }

                            echo '<option value="' . $i . '" ' . selected( $this->value['font-style'], $i, false ) . '>' . $style . '</option>';
                        }

                    echo '</select>';

                echo '</div>';
            }


            /* Text Align: If the text-align field is active, display the following field.
             * It constists of:
             * <div>-wrapper
             * label
             * select menu
                * options
             */
            if ( $this->field['text-align'] === true ) {
                echo '<div class="select_wrapper typography-align tooltip" original-title="' . esc_html__( 'Text Align', "podcaster" ) . '">';
                echo '<label>' . esc_html__( 'Text Align', "podcaster" ) . '</label>';
                echo '<select data-placeholder="' . esc_html__( 'Text Align', "podcaster" ) . '" class="redux-typography redux-typography-align ' . $this->field['class'] . '" original-title="' . esc_html__( 'Text Align', "podcaster" ) . '"  id="' . $this->field['id'] . '-align" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text-align]' . '" data-value="' . $this->value['text-align'] . '" data-id="' . $this->field['id'] . '" >';
                echo '<option value=""></option>';

                $align = array(
                    'inherit',
                    'left',
                    'right',
                    'center',
                    'justify',
                    'initial'
                );

                foreach ( $align as $v ) {
                    // ucfirst() --> Make a string's first character uppercase.
                    echo '<option value="' . $v . '" ' . selected( $this->value['text-align'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
                }

                echo '</select></div>';
            }

            /* Text Transform: If the text-transform field is active, display the following field. */
            if ( $this->field['text-transform'] === true ) {
                echo '<div class="select_wrapper typography-transform tooltip" original-title="' . esc_html__( 'Text Transform', "podcaster" ) . '">';
                echo '<label>' . esc_html__( 'Text Transform', "podcaster" ) . '</label>';
                echo '<select data-placeholder="' . esc_html__( 'Text Transform', "podcaster" ) . '" class="redux-typography redux-typography-transform ' . $this->field['class'] . '" original-title="' . esc_html__( 'Text Transform', "podcaster" ) . '"  id="' . $this->field['id'] . '-transform" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text-transform]' . '" data-value="' . $this->value['text-transform'] . '" data-id="' . $this->field['id'] . '" >';
                echo '<option value=""></option>';

                $values = array(
                    'none',
                    'capitalize',
                    'uppercase',
                    'lowercase',
                    'initial',
                    'inherit'
                );

                foreach ( $values as $v ) {
                    // ucfirst() --> Make a string's first character uppercase.
                    echo '<option value="' . $v . '" ' . selected( $this->value['text-transform'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
                }

                echo '</select></div>';
            }

            /* Font Variant: If the font-variant field is active, display the following field. */
            if ( $this->field['font-variant'] === true ) {
                echo '<div class="select_wrapper typography-font-variant tooltip" original-title="' . esc_html__( 'Font Variant', "podcaster" ) . '">';
                echo '<label>' . esc_html__( 'Font Variant', "podcaster" ) . '</label>';
                echo '<select data-placeholder="' . esc_html__( 'Font Variant', "podcaster" ) . '" class="redux-typography redux-typography-font-variant ' . $this->field['class'] . '" original-title="' . esc_html__( 'Font Variant', "podcaster" ) . '"  id="' . $this->field['id'] . '-font-variant" name="' . $this->field['name'] . $this->field['name_suffix'] . '[font-variant]' . '" data-value="' . $this->value['font-variant'] . '" data-id="' . $this->field['id'] . '" >';
                echo '<option value=""></option>';

                $values = array(
                    'inherit',
                    'normal',
                    'small-caps'
                );

                foreach ( $values as $v ) {
                    // ucfirst() --> Make a string's first character uppercase.
                    echo '<option value="' . $v . '" ' . selected( $this->value['font-variant'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
                }

                echo '</select></div>';
            }

            /* Text Decoration: If the text-decoration field is active, display the following field. */
            if ( $this->field['text-decoration'] === true ) {
                echo '<div class="select_wrapper typography-decoration tooltip" original-title="' . esc_html__( 'Text Decoration', "podcaster" ) . '">';
                echo '<label>' . esc_html__( 'Text Decoration', "podcaster" ) . '</label>';
                echo '<select data-placeholder="' . esc_html__( 'Text Decoration', "podcaster" ) . '" class="redux-typography redux-typography-decoration ' . $this->field['class'] . '" original-title="' . esc_html__( 'Text Decoration', "podcaster" ) . '"  id="' . $this->field['id'] . '-decoration" name="' . $this->field['name'] . $this->field['name_suffix'] . '[text-decoration]' . '" data-value="' . $this->value['text-decoration'] . '" data-id="' . $this->field['id'] . '" >';
                echo '<option value=""></option>';

                $values = array(
                    'none',
                    'inherit',
                    'underline',
                    'overline',
                    'line-through',
                    'blink'
                );

                foreach ( $values as $v ) {
                    echo '<option value="' . $v . '" ' . selected( $this->value['text-decoration'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
                }

                echo '</select></div>';
            }

            /* Text Weight: If the text-weight field is active, display the following field. */
            if ( $this->field['font-weight'] === true ) {
                echo '<div class="select_wrapper typography-weight tooltip" original-title="' . esc_html__( 'Text Weight', "podcaster" ) . '">';
                echo '<label>' . esc_html__( 'Font Weight', "podcaster" ) . '</label>';
                echo '<select data-placeholder="' . esc_html__( 'Font Weight', "podcaster" ) . '" class="redux-typography redux-typography-weight ' . $this->field['class'] . '" original-title="' . esc_html__( 'Font Weight', "podcaster" ) . '"  id="' . $this->field['id'] . '-decoration" name="' . $this->field['name'] . $this->field['name_suffix'] . '[font-weight]' . '" data-value="' . $this->value['font-weight'] . '" data-id="' . $this->field['id'] . '" >';
                echo '<option value=""></option>';

                $values = array(
                    '100',
                    '200',
                    '300',
                    '400',
                    '500',
                    '600',
                    '700',
                    '800',
                    '900'
                );

                foreach ( $values as $v ) {
                    echo '<option value="' . $v . '" ' . selected( $this->value['font-weight'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
                }

                echo '</select></div>';
            }

            /* Font Size: If the font-size field is active, display the following field. */
            if ( $this->field['font-size'] === true ) {
                echo '<div class="input_wrapper font-size redux-container-typography">';
                echo '<label>' . esc_html__( 'Font Size', "podcaster" ) . '</label>';
                echo '<div class="input-append"><input type="text" class="span2 redux-typography redux-typography-size mini typography-input ' . $this->field['class'] . '" title="' . esc_html__( 'Font Size', "podcaster" ) . '" placeholder="' . __( 'Size', "podcaster" ) . '" id="' . $this->field['id'] . '-size" name="' . $this->field['name'] . $this->field['name_suffix'] . '[font-size]' . '" value="' . str_replace( $unit, '', $this->value['font-size'] ) . '" data-value="' . str_replace( $unit, '', $this->value['font-size'] ) . '"><span class="add-on">' . $unit . '</span></div>';
                echo '<input type="hidden" class="typography-font-size" name="' . $this->field['name'] . $this->field['name_suffix'] . '[font-size]' . '" value="' . $this->value['font-size'] . '" data-id="' . $this->field['id'] . '"  />';
                echo '</div>';
            }

            /* Line Height: If the line-height field is active, display the following field. */
            if ( $this->field['line-height'] === true ) {
                echo '<div class="input_wrapper line-height redux-container-typography">';
                echo '<label>' . esc_html__( 'Line Height', "podcaster" ) . '</label>';
                echo '<div class="input-append"><input type="text" class="span2 redux-typography redux-typography-height mini typography-input ' . $this->field['class'] . '" title="' . esc_html__( 'Line Height', "podcaster" ) . '" placeholder="' . esc_html__( 'Height', "podcaster" ) . '" id="' . $this->field['id'] . '-height" value="' . str_replace( $unit, '', $this->value['line-height'] ) . '" data-value="' . str_replace( $unit, '', $this->value['line-height'] ) . '"><span class="add-on">' . $unit . '</span></div>';
                echo '<input type="hidden" class="typography-line-height" name="' . $this->field['name'] . $this->field['name_suffix'] . '[line-height]' . '" value="' . $this->value['line-height'] . '" data-id="' . $this->field['id'] . '"  />';
                echo '</div>';
            }

            /* Word Spacing: If the word-spacing field is active, display the following field. */
            if ( $this->field['word-spacing'] === true ) {
                echo '<div class="input_wrapper word-spacing redux-container-typography">';
                echo '<label>' . esc_html__( 'Word Spacing', "podcaster" ) . '</label>';
                echo '<div class="input-append"><input type="text" class="span2 redux-typography redux-typography-word mini typography-input ' . $this->field['class'] . '" title="' . esc_html__( 'Word Spacing', "podcaster" ) . '" placeholder="' . esc_html__( 'Word Spacing', "podcaster" ) . '" id="' . $this->field['id'] . '-word" value="' . str_replace( $unit, '', $this->value['word-spacing'] ) . '" data-value="' . str_replace( $unit, '', $this->value['word-spacing'] ) . '"><span class="add-on">' . $unit . '</span></div>';
                echo '<input type="hidden" class="typography-word-spacing" name="' . $this->field['name'] . $this->field['name_suffix'] . '[word-spacing]' . '" value="' . $this->value['word-spacing'] . '" data-id="' . $this->field['id'] . '"  />';
                echo '</div>';
            }

            /* Letter Spacing: If the letter-spacing field is active, display the following field. */
            if ( $this->field['letter-spacing'] === true ) {
                echo '<div class="input_wrapper letter-spacing redux-container-typography">';
                echo '<label>' . esc_html__( 'Letter Spacing', "podcaster" ) . '</label>';
                echo '<div class="input-append"><input type="text" class="span2 redux-typography redux-typography-letter mini typography-input ' . $this->field['class'] . '" title="' . esc_html__( 'Letter Spacing', "podcaster" ) . '" placeholder="' . esc_html__( 'Letter Spacing', "podcaster" ) . '" id="' . $this->field['id'] . '-letter" value="' . str_replace( $unit, '', $this->value['letter-spacing'] ) . '" data-value="' . str_replace( $unit, '', $this->value['letter-spacing'] ) . '"><span class="add-on">' . $unit . '</span></div>';
                echo '<input type="hidden" class="typography-letter-spacing" name="' . $this->field['name'] . $this->field['name_suffix'] . '[letter-spacing]' . '" value="' . $this->value['letter-spacing'] . '" data-id="' . $this->field['id'] . '"  />';
                echo '</div>';
            }

            echo '<div class="clearfix"></div>';

            /* Font Color: If the font-color field is active, display the following field. */
            if ( $this->field['color'] === true ) {
                $default = "";

                if ( empty( $this->field['default']['color'] ) && ! empty( $this->field['color'] ) ) {
                    $default = $this->value['color'];
                } else if ( ! empty( $this->field['default']['color'] ) ) {
                    $default = $this->field['default']['color'];
                }

                echo '<div class="picker-wrapper">';
                echo '<label>' . esc_html__( 'Font Color', "podcaster" ) . '</label>';
                echo '<div id="' . $this->field['id'] . '_color_picker" class="colorSelector typography-color"><div style="background-color: ' . $this->value['color'] . '"></div></div>';
                echo '<input data-default-color="' . $default . '" class="redux-color redux-typography-color ' . $this->field['class'] . '" original-title="' . esc_html__( 'Font color', "podcaster" ) . '" id="' . $this->field['id'] . '-color" name="' . $this->field['name'] . $this->field['name_suffix'] . '[color]' . '" type="text" value="' . $this->value['color'] . '" data-id="' . $this->field['id'] . '" />';
                echo '</div>';
            }

            echo '<div class="clearfix"></div>';

        }  //function

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since ReduxFramework 1.0.0
         */
        function enqueue() {
            if (!wp_style_is('select2-css')) {
                wp_enqueue_style( 'select2-css' );
            }

            if (!wp_style_is('wp-color-picker')) {
                wp_enqueue_style( 'wp-color-picker' );
            }

            if (!wp_script_is ( 'redux-field-typography-input-js' )) {
                wp_enqueue_script(
                    'redux-field-typography-input-js',
                    get_template_directory_uri(). '/includes/custom-fields/typography-input' . '/field_typography_input.js',
                    array( 'jquery', 'wp-color-picker', 'select2-js', 'redux-js' ),
                    time(),
                    true
                );
            }
            
            wp_localize_script(
                'redux-field-typography-js',
                'redux_ajax_script',
                array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
            );

            if ($this->parent->args['dev_mode']) {
                if (!wp_style_is('redux-color-picker-css')) {
                    wp_enqueue_style( 'redux-color-picker-css' );
                }

                if (!wp_style_is('redux-field-typography-input-css')) {
                    wp_enqueue_style(
                        'redux-field-typography-input-css',
                        get_template_directory_uri(). '/includes/custom-fields/typography-input' . '/field_typography_input.css',
                        array(),
                        time(),
                        'all'
                    );
                }
            }
        }  //function


        function output() {
            // Font array with all values of the field.
            $font = $this->value;            

            // Shim out old arg to new
            if ( isset( $this->field['all_styles'] ) && ! empty( $this->field['all_styles'] ) ) {
                $this->field['all-styles'] = $this->field['all_styles'];
                unset ( $this->field['all_styles'] );
            }

            // Check for font-backup.  If it's set, stick it on a variable for
            // later use.
            if ( ! empty( $font['font-family'] ) && ! empty( $font['font-backup'] ) ) {
                $font['font-family'] = str_replace( ', ' . $font['font-backup'], '', $font['font-family'] );
                $fontBackup          = ',' . $font['font-backup'];
            }

            $style = '';

            $fontValueSet = false;

            if ( ! empty( $font ) ) {
                foreach ( $font as $key => $value ) {
                    if ( ! empty( $value ) && in_array( $key, array( 'font-family'/*, 'font-weight'*/, 'font-style' ) ) ) {
                        $fontValueSet = true;
                    }
                }
            }

            // If $font is not empty, do the following
            if ( ! empty( $font ) ) {

                // For each key/value pair in $font, do the following
                foreach ( $font as $key => $value ) {

                    // If the current key is "font-options", continue.
                    if ( $key == 'font-options' ) {
                        continue;
                    }

                    // Check for font-family key
                    if ( 'font-family' == $key ) {

                        // Enclose font family in quotes if spaces are in the
                        // name.  This is necessary because if there are numerics
                        // in the font name, they will not render properly.
                        // Google should know better.
                        if (strpos($value, ' ') && !strpos($value, ',')){
                            $value = '"' . $value . '"';
                        }

                        // Ensure fontBackup isn't empty (we already option
                        // checked this earlier.  No need to do it again.
                        if ( ! empty( $fontBackup ) ) {

                            // Apply the backup font to the font-family element
                            // via the saved variable.  We do this here so it
                            // doesn't get appended to the Google stuff below.
                            $value .= $fontBackup;
                        }
                    }

                    // Set font-style at normal if nothinf is set.
                    if ( empty( $value ) && in_array( $key, array(
                            'font-style'
                        ) ) && $fontValueSet == true
                    ) {
                        $value = "normal";
                    }

                    // Check for font-style key
                    if ($key == 'font-style' && $this->field['font-style'] == false) {
                        continue;
                    }


                    if ( $key == "google" || $key == "subsets" || $key == "font-backup" || empty( $value ) ) {
                        continue;
                    }

                    //Line up key/value pair to be added to CSS output.
                    $style .= $key . ':' . $value . ';';
                }
                if ( isset( $this->parent->args['async_typography'] ) && $this->parent->args['async_typography'] ) {
                    $style .= 'opacity: 1;visibility: visible;-webkit-transition: opacity 0.24s ease-in-out;-moz-transition: opacity 0.24s ease-in-out;transition: opacity 0.24s ease-in-out;';
                }
            }

            // If $style is not empty, do the following:
            if ( ! empty( $style ) ) {

                // Check for the "output" field
                if ( ! empty( $this->field['output'] ) && is_array( $this->field['output'] ) ) {

                    $keys = implode( ",", $this->field['output'] );
                    $this->parent->outputCSS .= $keys . "{" . $style . '}';

                    if ( isset( $this->parent->args['async_typography'] ) && $this->parent->args['async_typography'] ) {
                        $key_string    = "";
                        $key_string_ie = "";
                        foreach ( $this->field['output'] as $value ) {
                            $key_string .= ".wf-loading " . $value . ',';
                            $key_string_ie .= ".ie.wf-loading " . $value . ',';
                        }
                        $this->parent->outputCSS .= $key_string . "{opacity: 0;}";
                        $this->parent->outputCSS .= $key_string_ie . "{visibility: hidden;}";
                    }
                }

                // Check for the "compiler" field
                if ( ! empty( $this->field['compiler'] ) && is_array( $this->field['compiler'] ) ) {
                    $keys = implode( ",", $this->field['compiler'] );
                    $this->parent->compilerCSS .= $keys . "{" . $style . '}';
                    if ( isset( $this->parent->args['async_typography'] ) && $this->parent->args['async_typography'] ) {
                        $key_string    = "";
                        $key_string_ie = "";
                        foreach ( $this->field['compiler'] as $value ) {
                            $key_string .= ".wf-loading " . $value . ',';
                            $key_string_ie .= ".ie.wf-loading " . $value . ',';
                        }
                        $this->parent->compilerCSS .= $key_string . "{opacity: 0;}";
                        $this->parent->compilerCSS .= $key_string_ie . "{visibility: hidden;}";
                    }
                }

            }
        }


        /*private function localizeStdFonts() {
            if ( false == $this->user_fonts ) {
                if ( isset( $this->parent->fonts['std'] ) && ! empty( $this->parent->fonts['std'] ) ) {
                    return;
                }

                $this->parent->font_groups['std'] = array(
                    'text'     => esc_html__( 'Standard Fonts', "podcaster" ),
                    'children' => array(),
                );

                foreach ( $this->field['fonts'] as $font => $extra ) {
                    $this->parent->font_groups['std']['children'][] = array(
                        'id'          => $font,
                        'text'        => $font,
                        'data-google' => 'false',
                    );
                }
            }

            if ( $this->field['custom_fonts'] !== false ) {
                $this->field['custom_fonts'] = apply_filters( "redux/{$this->parent->args['opt_name']}/field/typography/custom_fonts", array() );

                if ( ! empty( $this->field['custom_fonts'] ) ) {
                    foreach ( $this->field['custom_fonts'] as $group => $fonts ) {
                        $this->parent->font_groups['customfonts'] = array(
                            'text'     => $group,
                            'children' => array(),
                        );

                        foreach ( $fonts as $family => $v ) {
                            $this->parent->font_groups['customfonts']['children'][] = array(
                                'id'          => $family,
                                'text'        => $family,
                                'data-google' => 'false',
                            );
                        }
                    }
                }
            }
        }*/
    }
}
