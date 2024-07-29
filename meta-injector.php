<?php
/**
* Plugin Name: Meta Injector
* Plugin URI: https://rinaldiamfine.wordpress.com/
* Description: Easy add the meta tag on your website
* Version: 0.1
* Author: Rinaldi
* Author URI: https://github.com/rinaldiamfine
**/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'MetaInjector' ) ) {
    /**
     * Main MetaInjector Class
     *
     * @class MetaInjector
     */
    final class MetaInjector {

        protected static $_instance = null;

        /**
         * Main MetaInjector Instance
         *
         * Ensures only one instance of MetaInjector is loaded or can be loaded
         *
         * @static
         * @return MetaInjector - Main instance
         */
        public static function instance() {
            include_once 'setting-page.php';

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new MetaInjectorSettingPage();
                add_action( 'init', array( self::$_instance, 'setup_hooks' ) );
            }

            return self::$_instance;
        }

        /**
         * Cloning is forbidden.
         */
        public function __clone() {
            _doing_it_wrong(
                __FUNCTION__, 
                __( 'An error has occurred. Please reload the page and try again.' ), 
                '1.0' 
            );
        }

        /**
         * Unserializing instances of this class is forbidden.
         */
        public function __wakeup() {
            _doing_it_wrong(
                __FUNCTION__, 
                __( 'An error has occurred. Please reload the page and try again.' ), 
                '1.0' 
            );
        }
    }
}

if ( ! function_exists( 'MetaInjector' ) ) {
    /**
     * Returns the main instance of MetaInjector
     *
     * @return MetaInjector
     */
    function setup() {
        return MetaInjector::instance();
    }

    setup();
}
?>
