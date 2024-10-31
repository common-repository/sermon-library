<?php

class WH_Sermons {

    protected static $instance;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Register autoloader
        spl_autoload_register( array( 'WH_Sermons', 'class_loader' ) );

        // Initialize plugin
        $this->initialize();
    }

    private function initialize() {
        // Register action hooks
        $this->register_actions();
        
        // Register shortcodes
        WH_Sermons_Shortcodes::init();
        
        // Initialize admin
        if( is_admin() ) {
            WH_Sermons_Admin::init();
            WH_Sermons_Admin::add_shortcode_button();
        }

        // Set hook for after initialization
        do_action ( 'after_wh_sermons_init' );
    }

    public function register_actions() {
        add_action( 'init', array( 'WH_Sermons_Post_Type', 'init' ) );
        add_action( 'wp_enqueue_scripts', array('WH_Sermons', 'enqueue_assets') );
        add_action( 'widgets_init', array('WH_Sermons_Widget_Latest_Sermon', 'register') );
    }

    public function register_filters() {
        // Add all post types to main feed
        add_filter( 'request', function( $qv ) {
            if ( isset( $qv['feed'] ) ) {
                $qv['post_type'] = get_post_types();
            }
            return $qv;
        });
    }

    public static function enqueue_assets() {
        $wh_sermons_css = WH_Sermons::plugin_url() . '/assets/css/wh-sermons.css';
        wp_enqueue_style( 'wh-sermons', $wh_sermons_css, false );
        wp_enqueue_script( 'datatables-js', '//cdn.datatables.net/v/dt/dt-1.10.15/r-2.1.1/datatables.min.js', array('jquery'), false );
        wp_enqueue_style( 'datatables-css', '//cdn.datatables.net/v/dt/dt-1.10.15/r-2.1.1/datatables.min.css', false, false ); 
    }

    public static function class_loader($class) {
        if ( self::starts_with( $class, 'WH_Sermons' ) ) {
            $class = strtolower( $class );
            $file = 'class-' . str_replace( '_', '-', $class ) . '.php';
            $root = self::plugin_path();
            $include_path = '';

            if ( self::starts_with( $class, 'wh_sermons_exception' ) ) {
                $include_path = $root . 'includes/exception-library.php';
            } elseif ( self::starts_with( $class, 'wh_sermons_admin' ) ) {
                $include_path = $root . 'includes/admin/' . $file;
            } else {
                $include_path = $root . 'includes/' . $file;
            }

            if ( file_exists( $include_path ) ) {
                include_once( $include_path );
            }
        }
    }

    public static function starts_with( $haystack, $needle ) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function contains( $haystack, $needle ) {
        return strpos ( $haystack, $needle ) !== false;
    }

    public static function ends_with( $haystack, $needle ) {
        return substr($haystack, -strlen($needle)) == $needle;
    }

    /**
     * Get the plugin url
     *
     * @return string
     */
    public static function plugin_url() {
        $plugin_dir = basename(dirname(__DIR__));
        return WP_PLUGIN_URL . '/' . $plugin_dir . '/';
    }

    /**
     * Get the plugin path
     *
     * @return string
     */
    public static function plugin_path() {
        $plugin_dir = basename(dirname(__DIR__));
        return WP_PLUGIN_DIR . '/' . $plugin_dir . '/';
    }

    public static function view_path() {
        return self::plugin_path() . 'views/';
    }

    /**
     * Return true if debug mode is on, otherwise false.
     *
     * If the debug constant is false or not defined then debug mode is off.
     * If the CALVARY_MEDIA_DEBUG is true, then debug mode is on.
     *
     * @return boolean
     */
    public static function debug() {
        $debug = defined( 'WH_SERMONS_DEBUG' ) ? WH_SERMONS_DEBUG : false;
        return $debug;
    }
}
