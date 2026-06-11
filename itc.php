<?php

/**
 * Plugin Name: ITC - is this cached?
 * Description: Detects caching layers for any WordPress content.
 * Version: 0.1.0
 * Author: oilerart
 * Author URI: https://oiler.art.br
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
        add_action( 'admin_menu' , array( $this, 'register_menu') );
    }

    public static function init() {
        new self();
    }

    public function register_menu() {
        add_options_page(
            'ITC - is this cached?',
            'ITC',
            'manage_options',
            'itc',
            array ( $this, 'render_page' )
        );
    }

    public function render_page() {
        echo '<div class="wrap"><h1>Is this cached?</h1></div>';
    }
}

add_action( 'plugins_loaded', array( 'ITC', 'init' ) );