<?php
/**
 * Plugin Name: UDSSL Now Reading
 * Plugin URI: http://udssl.com/udssl-now-reading/
 * Description: Pages being read now. Display which pages of your site being served now. Realtime information via WordPress HeartBeat API.
 * Version: 0.1
 * Author: Praveen Dias
 * Author URI: http://udssl.com/praveen-chathuranga-dias/
 * Text Domain: nr
 * Domain Path: /languages/
 */
if( !defined( 'ABSPATH' ) ){
    header('HTTP/1.0 403 Forbidden');
    die('No Direct Access Allowed!');
}

/**
 * Path and URL definitions
 */
if ( !defined('UDSSL_NR_PATH') )
    define( 'UDSSL_NR_PATH', plugin_dir_path( __FILE__ ) );
if ( !defined('UDSSL_NR_URL') )
    define( 'UDSSL_NR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The UDSSL Now Reading Class
 */
class UDSSL_NR{
    /**
     * UDSSL Now Reading Core Functionality
     */
    public $core;

    /**
     * UDSSL Now Reading Customizer
     */
    public $customizer;

    /**
     * UDSSL Now Reading Administrator
     */
    public $admin;

    /**
     * UDSSL Now Reading Heartbeat
     */
    public $heartbeat;

    /**
     * UDSSL Now Reading Shortcodes
     */
    public $shortcode;

    /**
     * UDSSL Now Reading Constructor
     */
    function __construct(){
        /**
         * Load Translation Files.
         */
        $this->load_language('nr');
        add_action('plugins_loaded', array($this, 'initialize_nr_core'));
        add_action('widgets_init', array($this, 'register_udssl_nr_widget'));
        add_filter('plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
    }

    /**
     * UDSSL Now Readin Core Functionality
     */
    function initialize_nr_core(){
        require_once UDSSL_NR_PATH . 'inc/class-udssl-nr-core.php';
        $this->core = new UDSSL_NR_Core();

        require_once UDSSL_NR_PATH . 'inc/class-udssl-nr-customizer.php';
        $this->customizer = new UDSSL_NR_Customizer();

        require_once UDSSL_NR_PATH . 'inc/class-udssl-nr-heartbeat.php';
        $this->heartbeat = new UDSSL_NR_Heartbeat();

        require_once UDSSL_NR_PATH . 'inc/class-udssl-nr-shortcode.php';
        $this->shortcode = new UDSSL_NR_Shortcode();

        require_once UDSSL_NR_PATH . 'admin/class-udssl-nr-admin.php';
        $this->admin = new UDSSL_NR_Admin();
    }

    /**
     * Register UDSSL Now Reading Widget
     */
    function register_udssl_nr_widget(){
        /**
         * Register widget with WordPress
         */
        require_once UDSSL_NR_PATH . 'widgets/widget-udssl-nr.php';
        register_widget('UDSSL_NR_Widget');
    }

    /**
     * UDSSL Now Reading Plugin Action Links
     */
    function plugin_action_links($links, $file){
        if('udssl-now-reading/index.php' == $file){
            $links[] = '<a href="'. get_admin_url(null, 'admin.php?page=manage-udssl-nr&tab=monitor') .'" >' . __('Monitor', 'nr') . '</a>';
            $links[] = '<a href="' . get_admin_url(null, 'admin.php?page=manage-udssl-nr') . '" >' . __('Configure', 'nr') . '</a>';
        }
        return $links;
    }

    /**
     * Load Translation Files
     *
     * Translation domain: nr
     */
    function load_language($domain){
        load_plugin_textdomain(
            $domain,
            null,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
}

/**
 * Instantiate UDSSL Now Reading
 */
$udssl_nr = new UDSSL_NR();
?>
