<?php
/**
 * UDSSL 'Now Reading' implementing
 * WordPress Heartbeat API
 */
class UDSSL_NR_Heartbeat{
    /**
     * Constructor
     */
    function __construct(){
        add_filter('heartbeat_settings', array($this, 'heartbeat_settings'));
        add_filter('heartbeat_received', array($this, 'heartbeat_received'), 10, 3);
        add_filter('heartbeat_nopriv_received', array($this, 'heartbeat_received'), 10, 3);
    }

    /**
     * Heartbeat Settings
     */
    function heartbeat_settings($settings){
        $udssl_nr_options = get_option('udssl_nr_options');
        $interval = $udssl_nr_options['settings']['ajax_refresh_interval'];
        $settings['interval'] = $interval;
        return $settings;
    }

    /**
     * Heartbeat Received
     */
    function heartbeat_received($response, $data, $screen_id){
        if('front' == $screen_id || 'toplevel_page_manage-udssl-nr' == $screen_id){
            $readings = get_option('udssl_nr_readings');
            if(false == $readings){
                $readings = array();
            }

            $index = 0;
            foreach($readings as $title => $reading){
                $visitors[$index] = array(
                    'index' => $index++,
                    'title' => $reading['title'],
                    'time' => date('Y-m-d H:i:s', $reading['time']),
                    'elapsed' => human_time_diff( $reading['time'], current_time('timestamp') ) . ' ' . __('ago', 'nr'),
                    'ip' => $reading['ip'],
                    'user_agent' => $reading['user_agent'],
                    'url' => $reading['url']
                );
            }

            $data['udssl_nr'] = $visitors;
            $data['udssl_nr_time'] = current_time('mysql');
        }
        return $data;
    }

    /**
     * Hearbeat Enqueues
     *
     * Call this on Admin Page Init and Widget Front End Init
     */
    function heartbeat_enqueue(){
        $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';

        if(is_admin() && 'monitor' != $tab) return false;

        wp_enqueue_script('udssl-nr-app',
            UDSSL_NR_URL . 'js/udssl-nr-app.js',
            array('jquery', 'heartbeat', 'backbone', 'underscore'),
            false,
            true
        );

        if(is_admin()){
            wp_enqueue_script('udssl-nr-heartbeat-admin',
                UDSSL_NR_URL . 'js/udssl-nr-heartbeat-admin.js',
                array('udssl-nr-app'),
                false,
                true
            );
        } else {
            $options = get_option('udssl_nr_options');
            if($options['settings']['enable_ajax_refresh']){
                wp_enqueue_script('udssl-nr-heartbeat-front',
                    UDSSL_NR_URL . 'js/udssl-nr-heartbeat-front.js',
                    array('udssl-nr-app'),
                    false,
                    true
                );
            }
        }
    }
}
?>
