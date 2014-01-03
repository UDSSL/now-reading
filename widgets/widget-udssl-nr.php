<?php
/**
 * UDSSL Now Reading Widget
 */
class UDSSL_NR_Widget extends WP_Widget{
    /**
     * The UDSSL Now Reading Constructor
     */
	public function __construct(){
		parent::__construct(
			'udssl_nr_widget',
			__('UDSSL Now Reading Widget', 'nr'),
			array('description' => __('Display your content being read now. Real time updates with WP HeatBeat API.', 'nr' ))
		);
	}

    /**
     * Front End Display
     */
	public function widget($args, $instance){
        global $udssl_nr;
        $front = $udssl_nr->core->get_now_reading();
        echo $front;

        /**
         * Enqueue Heartbeat Scripts
         */
        $udssl_nr->heartbeat->heartbeat_enqueue();

        /**
         * Default styles for UDSSL Now Reading
         */
        echo '<style>';
        $default_style = '
            .udssl_nr_reading_item_title{
                font-weight: bold;
                padding: 5px 0 3px 0;
                display: block;
            }
            .udssl_nr_time_ago{
                font-style: italic;
            }
            ';
        $default_style = apply_filters('udssl_nr_front_style_default', $default_style);
        echo $default_style;

        $udssl_nr_options = get_option('udssl_nr_options');
        if(false == $udssl_nr_options){;
            echo '</style>';
            return true;
        }

        /**
         * UDSSL Reading Now Customizer Styles
         */
        $title_font_size = $udssl_nr_options['nr_title_font_size'];
        $text_font_size = $udssl_nr_options['nr_text_font_size'];
        $link_font_size = $udssl_nr_options['nr_text_font_size'] * $udssl_nr_options['nr_text_ratio'];
        $customizer_style = '
            #udssl_nr_title {
                color: ' . $udssl_nr_options['nr_title_color'] . ';
                font-size: ' . $title_font_size . 'px;
            }

            #udssl_nr_body {
                color: ' . $udssl_nr_options['nr_text_color'] . ';
                font-size: ' . $text_font_size . 'px;
            }

            .udssl_nr_read_now, .udssl_nr_read_now:visited {
                color: ' . $udssl_nr_options['nr_read_now_color'] . ';
            }

            .udssl_nr_reading_item_text{
                font-size: ' . $link_font_size . 'px;
            }

            ';
        $customizer_style = apply_filters('udssl_nr_front_style_customizer', $customizer_style);
        echo $customizer_style;
        echo '</style>';
	}

    /**
     * Backend Administration Form
     */
 	public function form($instance){
        $icon = UDSSL_NR_URL . 'assets/now-reading-icon.png';
        $back = '<table width="100%" ><tr><td width="50%">';
        $back .= '<img style="border:1px dashed #ccc; padding:5px;" src="' . $icon . '" />';
        $back .= '</td><td>';
        $back .= '<a href="' . admin_url('admin.php?page=manage-udssl-nr&tab=monitor') . '" class="button button-primary" >' . __('Monitor', 'nr') . '</a><br /><br />';
        $back .= '<a href="' . admin_url('admin.php?page=manage-udssl-nr') . '" class="button button-secondary" >' . __('Configure', 'nr') . '</a>';
        $back .= '</td></tr></table>';
        echo $back;
	}

    /**
     * Widget Settings Update Routine
     */
	public function update($new_instance, $old_instance){
        return $new_instance;
	}
}
?>
