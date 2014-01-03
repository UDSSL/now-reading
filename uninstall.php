<?php
if(!defined('ABSPATH') && !defined('WP_INSTALL_PLUGIN'))
	exit();

/**
 * Delete UDSSL Now Reading Options
 */
delete_option('udssl_nr_options');

/**
 * Delete UDSSL Now Reading Data
 */
delete_option('udssl_nr_readings');
?>
