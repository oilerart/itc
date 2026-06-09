<?php

/**
 * Plugin Name: itc - is this cached?
 * Description: Detects caching layers for any WordPress content.
 * Version: 0.1.0
 * Author: oilerart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'ITC_VERSION', '0.1.0');
define( 'ITC_DIR', plugin_dir_path( __FILE__) );
define( 'ITC_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook( __FILE__, 'itc_activate' );
register_deactivation_hook( __FILE__, 'itc_deactivate' );

function itc_activate() {
    
}

function itc_deactivate() {

}

class ITC {
    
    public function __construct() {

    }

    public static function init() {
        new self();
    }
}

add_action( 'plugins_loaded', array( 'ITC', 'init' ) );