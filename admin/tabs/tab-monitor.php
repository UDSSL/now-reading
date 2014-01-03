<?php
/**
 * UDSSL Now Reading Monitor
 */
add_settings_section(
    'udssl_nr_monitor',
    __('Now Reading Monitor', 'nr'),
    'udssl_nr_monitor_callback',
    'manage-udssl-nr');

/**
 * UDSSL Now Reading Monitor Callback
 */
function udssl_nr_monitor_callback($options){
    $udssl_nr_readings = get_option('udssl_nr_readings');
    if(false == $udssl_nr_readings){
        echo __('No Readings Yet', 'nr');
        return false;
    }

    $nr_monitor = '
        <table id="udssl_nr_body" class="widefat">
            <thead>
                <tr>
                    <th class="row-title">' . __('Index', 'nr') . '</th>
                    <th>' . __('Title', 'nr') . '</th>
                    <th>' . __('Time', 'nr') . '</th>
                    <th>' . __('Elapsed Time', 'nr') . '</th>
                    <th>' . __('IP', 'nr') . '</th>
                    <th>' . __('User Agent', 'nr') . '</th>
                    <th>' . __('Link', 'nr') . '</th>
                </tr>
            </thead>
            <tbody>';

    $index = 0;
    foreach($udssl_nr_readings as $title => $reading){
        $link = '<a href="' . $reading['url'] . '" >' . __('View Page', 'nr') . '</a>';
        $nr_monitor .= '
                <tr>
                    <td class="row-title">' . $index++ . '</td>
                    <td>' . $reading['title'] . '</td>
                    <td>' . date("Y-m-d H:i:s", $reading['time']) . '</td>
                    <td>' . human_time_diff( $reading['time'], current_time('timestamp') ) . ' ' . __('ago', 'nr') . '</td>
                    <td>' . $reading['ip'] . '</td>
                    <td>' . $reading['user_agent'] . '</td>
                    <td>' . $link . '</td>
                </tr>
            ';
    }

    $nr_monitor .= '
            </tbody>
            <tfoot>
                <tr>
                    <th class="row-title">' . __('Index', 'nr') . '</th>
                    <th>' . __('Title', 'nr') . '</th>
                    <th>' . __('Time', 'nr') . '</th>
                    <th>' . __('Elapsed Time', 'nr') . '</th>
                    <th>' . __('IP', 'nr') . '</th>
                    <th>' . __('User Agent', 'nr') . '</th>
                    <th>' . __('Link', 'nr') . '</th>
                </tr>
            </tfoot>
        </table>

        <script type="text/template" id="visitor-template">
            <td class="row-title index" ><%- index %></td>
            <td class="title" ><%- title %></td>
            <td class="time" ><%- time %></td>
            <td class="elapsed" ><%- elapsed %></td>
            <td class="ip" ><%- ip %></td>
            <td class="user_agent" ><%- user_agent %></td>
            <td class="link" ><a href="<%- link %>" >' . __('View Page', 'nr') . '</a></td>
        </script>
        ';
    $nr_monitor .= '<p class="description" >' . __('Current Time', 'nr') . ': <span id="udssl_nr_time" >' . current_time('mysql') . '</span></p>';
    echo $nr_monitor;
}
?>
