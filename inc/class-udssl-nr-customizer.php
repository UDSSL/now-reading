<?php
/**
 * UDSSL Now Reading Theme Customizer Integration
 */
class UDSSL_NR_Customizer{
    /**
     * The Constructor
     */
    function __construct(){
        add_action('customize_register', array($this, 'register_theme_customizer'));
        add_action('customize_preview_init', array($this, 'customizer_live_preview'));
    }

    /**
     * Register Theme Customizer
     */
    function register_theme_customizer($wp_customize){
        /**
         * UDSSL Now Reading Customizer Section
         */
        $wp_customize->add_section(
            'udssl_nr_section',
            array(
                'title' =>  __('UDSSL Now Reading Options', 'nr'),
                'priority' => 100
            )
        );

        /**
         * Title Color
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_title_color]',
            array(
                'default' => '#000000',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'nr_title_color',
                array(
                    'label' => __( 'Title Color', 'nr' ),
                    'settings' => 'udssl_nr_options[nr_title_color]',
                    'section' => 'udssl_nr_section'
                )
            )
        );

        /**
         * Title Text
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_title_text]',
            array(
                'default' => 'Now Reading',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
                'udssl_nr_options[nr_title_text]',
                array(
                    'section'  => 'udssl_nr_section',
                    'label'    => __('Title Text', 'nr'),
                    'type'     => 'text'
                )
        );

        /**
         * Title Font Size
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_title_font_size]',
            array(
                'default' => '22',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
                'udssl_nr_options[nr_title_font_size]',
                array(
                    'section'  => 'udssl_nr_section',
                    'label'    => __('Title Font Size', 'nr'),
                    'type'     => 'text'
                )
        );

        /**
         * Read Now Color
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_read_now_color]',
            array(
                'default' => '#000000',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'nr_read_now_color',
                array(
                    'label' => __( 'Read Now Color', 'nr' ),
                    'settings' => 'udssl_nr_options[nr_read_now_color]',
                    'section' => 'udssl_nr_section'
                )
            )
        );

        /**
         * Read Now Text
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_read_now_text]',
            array(
                'default' => 'Read Now',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
                'udssl_nr_options[nr_read_now_text]',
                array(
                    'section'  => 'udssl_nr_section',
                    'label'    => __('Read Now Text', 'nr'),
                    'type'     => 'text'
                )
        );

        /**
         * Text Color
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_text_color]',
            array(
                'default' => '#000000',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'nr_text_color',
                array(
                    'label' => __( 'Text Color', 'nr' ),
                    'settings' => 'udssl_nr_options[nr_text_color]',
                    'section' => 'udssl_nr_section'
                )
            )
        );

        /**
         * Text Font Size
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_text_font_size]',
            array(
                'default' => '16',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
                'udssl_nr_options[nr_text_font_size]',
                array(
                    'section'  => 'udssl_nr_section',
                    'label'    => __('Text Font Size', 'nr'),
                    'type'     => 'text'
                )
        );

        /**
         * Text to Link Font Size Ratio
         */
        $wp_customize->add_setting(
            'udssl_nr_options[nr_text_ratio]',
            array(
                'default' => '0.8',
                'type' => 'option',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control(
                'udssl_nr_options[nr_text_ratio]',
                array(
                    'section'  => 'udssl_nr_section',
                    'label'    => __('Text to Link Font Size Ratio', 'nr'),
                    'type'     => 'text'
                )
        );

    }

    /**
     * Customizer Live Preview
     */
    function customizer_live_preview(){
        wp_enqueue_script(
            'udssl-nr-customizer',
            UDSSL_NR_URL . 'js/udssl-nr-customizer.js',
            array( 'jquery', 'customize-preview' ),
            null,
            true
        );
    }
}
?>
