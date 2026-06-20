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
            array ( $this, 'render_page' ),
        );
    }

    public function scan($url) {

        $error = '';
        $cache_control = '';
        $expires = '';
        $etag = '';
        $last_modified = '';
        $age = '';
        $verdict = '';
        $cf_cache_status = '';
        $cf_ray = '';
        $x_cache = '';
        $via = '';
        $cdn = '';

        $response = wp_remote_get( $url );

        if ( is_wp_error( $response ) ) {
            $error = $response->get_error_message();
        } else {
            $headers = wp_remote_retrieve_headers( $response );
            $cache_control = $headers['cache-control'] ?? '';
            $expires = $headers['expires'] ?? '';
            $etag = $headers['etag'] ?? '';
            $last_modified = $headers['last-modified'] ?? '';
            $age = $headers['age'] ?? '';
            $cf_cache_status = $headers['cf-cache-status'] ?? '';
            $cf_ray = $headers['cf-ray'] ?? '';
            $x_cache = $headers['x-cache'] ?? '';
            $via = $headers['via'] ?? '';

            if ( $age !== '' && (int) $age > 0 ) {
                $verdict = 'Currently served from cache';                
            } elseif ( str_contains( $cache_control, 'no-store' ) ) {
                $verdict = 'Not cacheable (no-store)';
            } elseif ( str_contains( $cache_control, 'public' ) || str_contains( $cache_control, 'max-age' ) || $expires !== '' ) {
                $verdict = 'Cacheable, but not currently cached, or just unknown if cached at all';
            } else {
                $verdict = 'No cache headers found';
            }

            if ( $cf_ray !== '' ) {
                $cdn = 'Cloudflare';
                if ( $cf_cache_status !== '' ) {
                    $cdn .= ' (' . $cf_cache_status . ')';
                }
            } elseif ( str_contains( strtolower( $x_cache ), 'cloudfront' ) ) {
                $cdn = 'AWS CloudFront (' . $x_cache . ')';
            } elseif ( $x_cache !== '' ) {
                $cdn = 'CDN/proxy detected (x-cache: ' . $x_cache . ')';
            } elseif ( $via !== '' ) {
                $cdn = 'Proxy detected (via: ' . $via . ')';
            } else {
                $cdn = 'No CDN detected';
            }
        }

        return array(
            'cache_control' => $cache_control,
            'expires' => $expires,
            'etag' => $etag,
            'last_modified' => $last_modified,
            'age' => $age,
            'verdict' => $verdict,
            'error' => $error,
            'cdn' => $cdn,
        );

    }

    public function render_page() {        
        
        $scanned_url = '';
        $result = array(
            'cache_control' => '',
            'expires' => '',
            'etag' => '',
            'last_modified' => '',
            'age' => '',
            'verdict' => '',
            'error' => '',
            'cdn' => '',
        );

        if ( isset( $_POST['itc_nonce'] ) && wp_verify_nonce( $_POST['itc_nonce'], 'itc_scan' ) ) {
            $scanned_url = esc_url_raw( $_POST['itc_url'] ?? '' );

            if ( $scanned_url ) {
                $result = $this->scan( $scanned_url );
            }
        }
        
        ?>

        <div class="wrap">
            <h1>Is this cached?</h1>
            <form method="post">
                <?php wp_nonce_field( 'itc_scan', 'itc_nonce' ); ?>
                <input type="url" name="itc_url" placeholder="https://example.com" class="regular-text">
                <input type="submit" class="button button-primary" value="Scan">
            </form>

            <?php if ( $result['error'] ) : ?>
                <p>Error: <?php echo esc_html( $result['error'] ); ?></p>
            <?php elseif ( $scanned_url ) : ?>
                <p>Scanning: <?php echo esc_url( $scanned_url ); ?></p>
                <p>Cache control: <?php echo esc_html( $result['cache_control'] ); ?></p>
                <p>Expires: <?php echo esc_html( $result['expires'] ); ?></p>
                <p>Etag: <?php echo esc_html( $result['etag'] ); ?></p>
                <p>Last modified: <?php echo esc_html( $result['last_modified'] ); ?></p>
                <p>Age: <?php echo esc_html( $result['age'] ); ?></p>
                <p><strong>Verdict: <?php echo esc_html( $result['verdict'] ); ?></strong></p>
                <p>CDN: <?php echo esc_html( $result['cdn'] ); ?></p>               
            <?php endif; ?>
        </div>
        <?php
    }
    
}

add_action( 'plugins_loaded', array( 'ITC', 'init' ) );