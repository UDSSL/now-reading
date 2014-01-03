<?php
/**
 * UDSSL Now Reading Administration
 */
class UDSSL_NR_Admin{
    /**
     * UDSSL Now Reading Admin Menu Slug
     */
    private $admin_slug;

    /**
     * UDSSL Now Reading Default Options
     */
    private $defaults;

    /**
     * UDSSL Now Reading Administrative Tabs
     */
    private $tabs;

    /**
     * UDSSL Theme Constructor
     */
     function __construct(){
        /**
         * Add Admin Menu for UDSSL Now Reading
         */
        add_action( 'admin_menu', array($this, 'add_udssl_nr_admin_menu'));

        /**
         * Set UDSSL Now Reading Default Options
         */
        $this->set_udssl_nr_default_options();

        /**
         * UDSSL Now Reading Options Initialization
         */
        add_action('init', array($this, 'udssl_nr_options_init'));

        /**
         * Set UDSSL Now Reading Administrative Tabs
         */
        $this->set_udssl_nr_tabs();

        /**
         * Register UDSSL Now Reading Settings
         */
  		add_action('admin_init', array($this, 'register_nr_settings'));
     }

    /**
     * Add UDSSL Now Reading Admin Menu
     */
    function add_udssl_nr_admin_menu(){
        $this->admin_slug = add_menu_page(
            __('UDSSL Now Reading Administration Interface', 'nr'),
            __('Now Reading', 'nr'),
            'manage_options',
            'manage-udssl-nr',
            array($this, 'udssl_nr_admin_page'),
            UDSSL_NR_URL . 'assets/favicon.png'
        );

        /**
         * Admin Scripts
         */
  		add_action('admin_print_scripts-' . $this->admin_slug, array($this, 'admin_scripts'));
        global $udssl_nr;
        add_action('admin_print_scripts-' . $this->admin_slug, array($udssl_nr->heartbeat, 'heartbeat_enqueue'));
    }

    /**
     * UDSSL Now Reading Options Defaults
     */
    function set_udssl_nr_default_options(){
        $this->defaults = array(
            'settings' => array(
                'enable_ajax_refresh' => true,
                'ajax_refresh_interval' => 30,
                'no_of_readings' => 10
            ),

            /**
             * Customizer Defaults
             */
            'nr_title_color' => '#877575',
            'nr_title_text' => __('Now Reading', 'nr'),
            'nr_title_font_size' => '22',
            'nr_read_now_color' => '#777777',
            'nr_read_now_text' => __('Read Now', 'nr'),
            'nr_text_color' => '#37adfc',
            'nr_text_font_size' => '16',
            'nr_text_ratio' => '0.9'
        );
    }

    /**
     * UDSSL Now Reading Options Initialization
     */
    function udssl_nr_options_init(){
        $udssl_nr_options = get_option('udssl_nr_options');
        if(false == $udssl_nr_options)
            update_option('udssl_nr_options', $this->defaults);
    }

    /**
     * UDSSL Now Reading Administrative Tabs
     */
    function set_udssl_nr_tabs(){
        $this->tabs = array(
            'settings' => __('Settings', 'nr'),
            'monitor' => __('Monitor', 'nr')
        );
    }

    /**
     * UDSSL Now Reading Admin Page
     */
    function udssl_nr_admin_page(){
  		echo '<div class="wrap">';
            echo '<div id="icon-udssl-nr" class="icon32"><br /></div>';
            echo '<h2>' . __('UDSSL Now Reading Dashboard', 'nr') . '</h2>';
            $this->udssl_nr_settings_tabs();
            settings_errors();
            echo '<form action="options.php" method="post">';
                if ( isset ( $_GET['tab'] ) ) :
                    $tab = $_GET['tab'];
                else:
                    $tab = 'settings';
                endif;

                switch ( $tab ) :
                case 'settings' :
                    require UDSSL_NR_PATH . 'admin/tabs/tab-settings.php';
                    break;
                case 'monitor' :
                    require UDSSL_NR_PATH . 'admin/tabs/tab-monitor.php';
                    break;
                endswitch;

                settings_fields('udssl_nr_options');
                do_settings_sections('manage-udssl-nr');

            echo '</form>';
  		echo '</div>';
    }

    /**
     * UDSSL Now Reading Tabs
     */
    function udssl_nr_settings_tabs(){
        if ( isset ( $_GET['tab'] ) ) :
            $current = $_GET['tab'];
        else:
            $current = 'settings';
        endif;

        $links = array();
        foreach( $this->tabs as $tab => $name ) :
            if ( $tab == $current ) :
                $links[] = '<a class="nav-tab nav-tab-active"
                href="?page=manage-udssl-nr&tab=' .
                $tab . '" > ' . $name . '</a>';
            else :
                $links[] = '<a class="nav-tab"
                href="?page=manage-udssl-nr&tab=' .
                $tab . '" >' . $name . '</a>';
            endif;
        endforeach;

        echo '<h2 class="nav-tab-wrapper">';
            foreach ( $links as $link ):
                echo $link;
            endforeach;
        echo '</h2>';
    }

    /**
     * Register UDSSL Now Reading Settings
     */
	function register_nr_settings(){
        register_setting(
            'udssl_nr_options',
            'udssl_nr_options',
            array( $this, 'udssl_nr_options_validate' )
        );
	}

    /**
     * UDSSL Now Reading Options Validate
     */
    function udssl_nr_options_validate($input){
        $options = get_option('udssl_nr_options');
        $output = $options;

        /**
         * Save NR Settings
         */
  		if(isset($input['save_settings'])){
            $output['settings']['enable_ajax_refresh'] = isset($input['settings']['enable_ajax_refresh']) ? true : false;
            $output['settings']['ajax_refresh_interval'] = (int) $input['settings']['ajax_refresh_interval'];
            $output['settings']['no_of_readings'] = (int) $input['settings']['no_of_readings'];

            $message = __('UDSSL Now Reading Settings Saved', 'nr');
            $type = 'updated';
  		}

        /**
         * Reset NR Settings
         */
  		if(isset($input['reset_settings'])){
            $output['settings'] = $this->defaults['settings'];

            $message = __('UDSSL Now Reading Settings Reset', 'nr');
            $type = 'updated';
  		}

        /**
         * Customizer input validation
         */
        if(isset($input['nr_title_color']))
            $output['nr_title_color'] = $input['nr_title_color'];
        if(isset($input['nr_title_text']))
            $output['nr_title_text'] = $input['nr_title_text'];
        if(isset($input['nr_title_font_size']))
            $output['nr_title_font_size'] = $input['nr_title_font_size'];
        if(isset($input['nr_read_now_color']))
            $output['nr_read_now_color'] = $input['nr_read_now_color'];
        if(isset($input['nr_read_now_text']))
            $output['nr_read_now_text'] = $input['nr_read_now_text'];
        if(isset($input['nr_text_color']))
            $output['nr_text_color'] = $input['nr_text_color'];
        if(isset($input['nr_text_font_size']))
            $output['nr_text_font_size'] = $input['nr_text_font_size'];
        if(isset($input['nr_text_ratio']))
            $output['nr_text_ratio'] = $input['nr_text_ratio'];

        add_settings_error(
            'udssl-nr',
            esc_attr('settings_updated'),
            $message,
            $type
        );

        return $output;
    }

    /**
     * Now Reading Admin Scripts
     */
    function admin_scripts(){
        wp_enqueue_style( 'udssl-nr-admin', UDSSL_NR_URL . 'css/udssl-nr-admin.css' );
    }
}
?>
