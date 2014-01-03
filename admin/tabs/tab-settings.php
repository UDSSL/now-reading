<?php
/**
 * UDSSL Now Reading Settings
 */
$options = get_option('udssl_nr_options');
$options = $options['settings'];

/**
 * Ajax Settings Section
 */
add_settings_section(
    'ajax_refresh',
    __('Ajax Refresh', 'nr'),
    'ajax_refresh_callback',
    'manage-udssl-nr');

/**
 * Ajax Settings Section Callback
 */
function ajax_refresh_callback(){
    _e('Configure Ajax Refresh', 'nr');
}

/**
 * Enable Ajax Refresh
 */
add_settings_field(
    'enable_ajax_refresh',
    __('Enable Ajax Refresh', 'nr'),
    'enable_ajax_refresh_callback',
    'manage-udssl-nr',
    'ajax_refresh',
    $options
);

/**
 * Enable Ajax Refresh Callback
 */
function enable_ajax_refresh_callback($options){
    echo '<input name="udssl_nr_options[settings][enable_ajax_refresh]" type="checkbox" ' .  checked($options['enable_ajax_refresh'], true, false) .
        '"> <span class="description" >' . __('Enable Ajax Refresh of Reading Widget', 'nr') . '</span>';
}

/**
 * Ajax Refresh Interval
 */
add_settings_field(
    'ajax_refresh_interval',
    __('Refresh Interval', 'nr'),
    'ajax_refresh_interval_callback',
    'manage-udssl-nr',
    'ajax_refresh',
    $options
);

/**
 * Ajax Refresh Interval Callback
 */
function ajax_refresh_interval_callback($options){
    echo '<input name="udssl_nr_options[settings][ajax_refresh_interval]" type="text" class="small-text" value="' .  $options['ajax_refresh_interval'] .
        '"> <span class="description" >' . __('Ajax Refresh Interval', 'nr') . '</span>';
}

/**
 * List Settings Section
 */
add_settings_section(
    'list_settings',
    __('Now Reading List', 'nr'),
    'list_settings_callback',
    'manage-udssl-nr');

/**
 * List Settings Section Callback
 */
function list_settings_callback(){
    _e('Configure Now Reading List Settings', 'nr');
}

/**
 * No of Readings
 */
add_settings_field(
    'no_of_readings',
    __('No of Readings', 'nr'),
    'no_of_readings_callback',
    'manage-udssl-nr',
    'list_settings',
    $options
);

/**
 * No of Readings Callback
 */
function no_of_readings_callback($options){
    echo '<input name="udssl_nr_options[settings][no_of_readings]" type="text" class="small-text" value="' .  $options['no_of_readings'] .
        '"> <span class="description" >' . __('No of entries to show on the widget', 'nr') . '</span>';
}


/**
 * Save UDSSL Now Reading Settings
 */
add_settings_section(
    'save_udssl_nr',
    __('Save Settings', 'nr'),
    'save_callback',
    'manage-udssl-nr');

/**
 * Save Settings Callback
 */
function save_callback($options){
    echo '<input name="udssl_nr_options[save_settings]" type="submit" class="button-primary" value="' . __('Save Settings', 'nr') . '" />';
    echo ' <input name="udssl_nr_options[reset_settings]" type="submit" class="button-secondary" value="' . __('Reset', 'nr') . '" />';
}
?>
