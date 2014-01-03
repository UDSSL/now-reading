<?php
/**
 * UDSSL Now Reading Core
 */
class UDSSL_NR_Core{
    /**
     * The Constructor
     */
    function __construct(){
        add_filter('wp_title', array($this, 'record_reading'), 99, 2);
    }

    /**
     * Record the current content being accessed
     */
    function record_reading($title, $sep ){
        if(is_admin()) return false;

        $time = current_time('timestamp');
        $title = $title;

        global $wp;
        $url = home_url($wp->request);

        $readings = get_option('udssl_nr_readings');
        if(false == $readings){
            $readings = array();
        }

        foreach($readings as $last_time => $reading){
            if($title == $reading['title'])
                unset($readings[$last_time]);
        }

        $readings[$time] = array(
            'time' => $time,
            'title' => $title,
            'url' => $url,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );

        krsort($readings);
        $udssl_nr_options = get_option('udssl_nr_options');
        $limit = $udssl_nr_options['settings']['no_of_readings'];
        $readings = array_slice($readings, 0, $limit, true);

        update_option('udssl_nr_readings', $readings);
    }

    /**
     * Content being read now
     */
    function get_now_reading(){
        $readings = get_option('udssl_nr_readings');
        if(false == $readings){
            return false;
        }

        $udssl_nr_options = get_option('udssl_nr_options');
        if(false == $udssl_nr_options){
            $udssl_nr_options['nr_title_text'] = __('Now Reading', 'nr');
            $udssl_nr_options['nr_read_now_text'] = __('Read Now', 'nr');
        }

        $options = get_option('udssl_nr_options');
        $front = '<div id="udssl_nr" >';
        $front .= '<h3 id="udssl_nr_title">' . apply_filters('udssl_nr_title', $udssl_nr_options['nr_title_text']) . '</h3>';
        $front .= '<div id="udssl_nr_body" >';
        foreach($readings as $title => $reading){
            $link_title = ' title="' . __('Visit Page Now', 'nr') . ' > ' . $reading['title'] . '" ';
            $front .= '<span class="udssl_nr_reading_item_title">' . $reading['title'] . '</span> ';
            $front .= '<span class="udssl_nr_reading_item_text">';
            $front .= '<span class="udssl_nr_time_ago">';
            $front .= human_time_diff( $reading['time'], current_time('timestamp') ) . ' ' . __('ago', 'nr') . ' ';
            $front .= '</span>';
            $front .= '<a class="udssl_nr_read_now" href="' . $reading['url'] . '" ' . $link_title . ' >' . $udssl_nr_options['nr_read_now_text'] . '</a> ';
            $front .= '</span>';
        }
        $front .= '</div>';
        $front .= '</div>';
        $front = apply_filters('udssl_nr_front', $front, $readings, $options);
        $front .= '
        <script type="text/template" id="visitor-template">
            <span class="udssl_nr_reading_item_title"><%- title %></span>
            <span class="udssl_nr_reading_item_text">
            <span class="udssl_nr_time_ago"><%- elapsed %> </span>
            <a class="udssl_nr_read_now" href="<%- link %>"
            title="Visit Page Now &gt; <%- title %>">' . $udssl_nr_options['nr_read_now_text'] . '</a> </span>
        </script>
            ';
        return $front;
    }
}
?>
