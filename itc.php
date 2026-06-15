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
        
        $scanned_url = '';
        $cache_control = '';
        $error = '';

        if ( isset( $_POST['itc_nonce'] ) && wp_verify_nonce( $_POST['itc_nonce'], 'itc_scan' ) ) {
            $scanned_url = esc_url_raw( $_POST['itc_url'] ?? '' );

            if ( $scanned_url ) {
                $response = wp_remote_get( $scanned_url );

                if ( is_wp_error( $response ) ) {
                    $error = $response->get_error_message();
                } else {
                    $headers = wp_remote_retrieve_headers( $response );
                    $cache_control = $headers['cache-control'] ?? '';
                }
            }

        }

    }
}

add_action( 'plugins_loaded', array( 'ITC', 'init' ) );