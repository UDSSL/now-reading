<?php
/**
 * UDSSL Now Reading Display Shortcode and function
 */
class UDSSL_NR_Shortcode{
    /**
     * Constructor
     */
    function __construct(){
        add_shortcode('udssl_now_reading', array($this, 'now_reading'));
    }

    /**
     * Return UDSSL Now Reading Pages
     */
    function now_reading($atts){
        require_once UDSSL_NR_PATH . 'widgets/widget-udssl-nr.php';
        $widget = new UDSSL_NR_Widget();
        $widget->widget(null, null);
        return '';
    }
}
?>
