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

interface ITC_Detector {

    public function detect( $response );

}

class ITC_HTTP_Detector implements ITC_Detector {

    public function detect( $response ) {

        $headers = wp_remote_retrieve_headers( $response );

        $cache_control = $headers['cache-control'] ?? '';
        $expires = $headers['expires'] ?? '';
        $etag = $headers['etag'] ?? '';
        $last_modified = $headers['last-modified'] ?? '';
        $age = $headers['age'] ?? '';
        $verdict = '';

        if ( $age !== '' && (int) $age > 0 ) {
            $verdict = 'Currently served from cache';
        } elseif ( str_contains( $cache_control, 'no-store' ) ) {
            $verdict = 'Not cacheable (no-store)';
        } elseif ( str_contains( $cache_control, 'public' ) || str_contains( $cache_control, 'max-age' ) || $expires !== '' ) {
            $verdict = 'Cacheable, but not currently cached, or just unknown if cached at all';
        } else {
            $verdict = 'No cache headers found';
        }

        return array(
            'cache_control' => $cache_control,
            'expires'       => $expires,
            'etag'          => $etag,
            'last_modified' => $last_modified,
            'age'           => $age,
            'verdict'       => $verdict,
        );
    }
}

class ITC_CDN_Detector implements ITC_Detector {

    public function detect( $response ) {

        $headers = wp_remote_retrieve_headers( $response );

        $cf_cache_status = $headers['cf-cache-status'] ?? '';
        $cf_ray = $headers['cf-ray'] ?? '';
        $x_cache = $headers['x-cache'] ?? '';
        $via = $headers['via'] ?? '';

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

        return array( 'cdn' => $cdn );

    }

}

class ITC_Plugin_Detector implements ITC_Detector {

    public function detect( $response ) {

        $known = array(
            'LiteSpeed Cache'  => 'LSCWP_V',
            'W3 Total Cache'   => 'W3TC',
            'WP Super Cache'   => 'WPCACHEHOME',
            'Hummingbird'      => 'WPHB_VERSION',
            'WP Fastest Cache' => 'WpFastestCache',
        );

        $detected = array();

        foreach ( $known as $plugin => $signal ) {
            if ( defined( $signal ) || class_exists( $signal ) ) {
                $detected[] = $plugin;
            }
        }

        if ( empty( $detected ) ) {
            $cache_plugin = 'No cache plugin detected';
        } else {
            $cache_plugin = implode( ', ' , $detected );
        }

        $body = wp_remote_retrieve_body( $response );

        $footprints = array(
            'WP Super Cache' => 'WP-Super-Cache',
            'W3 Total Cache' => 'Performance optimized by W3 Total Cache',
            'LiteSpeed Cache' => 'LiteSpeed Cache',
            'WP Fastest Cache' => 'WP Fastest Cache',
        );

        $matches = array();

        foreach ( $footprints as $plugin => $string ) {
            if ( str_contains( $body, $string ) ) {
                $matches[] = $plugin;
            }
        }
        
        if ( empty( $matches ) ) {
            $cache_plugin_footprint = 'No cache plugin detected';
        } else {
            $cache_plugin_footprint = implode( ', ', $matches );
        }

        return array(
            'cache_plugin' => $cache_plugin,
            'cache_plugin_footprint' => $cache_plugin_footprint,
        );

    }    

}

class ITC_Server_Detector implements ITC_Detector {
        
    public function detect( $response ) {

        $headers = wp_remote_retrieve_headers( $response );

        $server = $headers['server'] ?? '';
        $x_varnish = $headers['x-varnish'] ?? '';
        $via = $headers['via'] ?? '';
        $varnish_verdict = '';
        $kinsta = $headers['x-kinsta-cache'] ?? '';
        $wpengine = $headers['x-powered-by'] ?? '';
        $siteground = $headers['x-proxy-cache'] ?? '';
        $host = '';

        if ( str_contains( $x_varnish, ' ' ) ) {
            $varnish_verdict = 'Varnish HIT';
        } elseif ( $x_varnish !== '' ) {
            $varnish_verdict = 'Varnish detected (miss)';
        }  elseif ( str_contains( strtolower( $via ), 'varnish' ) ) {
            $varnish_verdict = 'Varnish detected (via)';
        } else {
            $varnish_verdict = 'No varnish detected';
        }

        if ( $kinsta !== '' ) {
            $host = 'Kinsta';
        } elseif ( str_contains( strtolower( $wpengine ), 'wp engine' ) ) {
            $host = 'WP Engine';
        } elseif ( $siteground !== '') {
            $host = 'SiteGround (or Nginx proxy)';
        } else {
            $host = 'Host not defined';
        }

        return array(
            'server' => $server,
            'varnish_verdict' => $varnish_verdict,
            'host' => $host,
        );

    }

}

class ITC_Object_Cache_Detector implements ITC_Detector {

    public function detect( $response ) {

        if ( wp_using_ext_object_cache() ) {
            $object_cache = 'Persistent object cache active';
        } else {
            $object_cache = 'No persistent object cache';
        }

        return array(
            'object_cache' => $object_cache,
        );

    }

}

class ITC_OPcache_Detector implements ITC_Detector {

    public function detect ( $response ) {

        if ( function_exists( 'opcache_get_status' ) && opcache_get_status( false ) ) {
            $opcache = 'OPcache enabled';
        } else {
            $opcache = 'OPcache not enabled';
        }

        return array(
            'opcache' => $opcache,
        );

    }

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

    public function scan( $url, $cookies = array() ) {

        $result = array(
            'cache_control' => '',
            'expires' => '',
            'etag' => '',
            'last_modified' => '',
            'age' => '',
            'verdict' => '',
            'cdn' => '',
            'cache_plugin' => '',
            'cache_plugin_footprint' => '',
            'server' => '',
            'varnish_verdict' => '',
            'host' => '',
            'object_cache' => '',
            'opcache' => '',
            'error' => '',
        );
    
        $response = wp_remote_get( $url, array( 'cookies' => $cookies ) );
    
        if ( is_wp_error( $response ) ) {
            $result['error'] = $response->get_error_message();
            return $result;
        }    
        
        $http_detector = new ITC_HTTP_Detector;
        $http_result = $http_detector->detect( $response );

        $cdn_detector = new ITC_CDN_Detector;        
        $cdn_result = $cdn_detector->detect( $response );

        $cache_plugin_detector = new ITC_Plugin_Detector;
        $cache_plugin_result = $cache_plugin_detector->detect( $response );

        $server_detector = new ITC_Server_Detector;
        $server_result = $server_detector->detect( $response );

        $object_cache_detector = new ITC_Object_Cache_Detector;
        $object_cache_result = $object_cache_detector->detect( $response );

        $opcache_detector = new ITC_OPcache_Detector;
        $opcache_result = $opcache_detector->detect( $response );
        
        $result = array_merge( $result, $http_result, $cdn_result, $cache_plugin_result, $server_result, $object_cache_result, $opcache_result );
    
        return $result;
    }

        public function render_page() {
            
            $default = array(
                'cache_control' => '',
                'expires' => '',
                'etag' => '',
                'last_modified' => '',
                'age' => '',
                'verdict' => '',            
                'cdn' => '',
                'cache_plugin' => '',
                'cache_plugin_footprint' => '',
                'server' => '',
                'varnish_verdict' => '',
                'host' => '',
                'object_cache' => '',
                'opcache' => '',
                'error' => '',
            );

            $result_anon = $default;
            $result_auth = $default;
            $scanned_url = '';

            if ( isset( $_POST['itc_nonce'] ) && wp_verify_nonce( $_POST['itc_nonce'], 'itc_scan' ) ) {
                $scanned_url = esc_url_raw( $_POST['itc_url'] ?? '' );

                if ( $scanned_url ) {
                    $result_anon = $this->scan( $scanned_url );
                    $result_auth = $this->scan( $scanned_url, $_COOKIE );
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

                <?php if ( $result_anon['error'] ) : ?>
                    <p>Error: <?php echo esc_html( $result_anon['error'] ); ?></p>
                <?php elseif ( $scanned_url ) : ?>
                    <p>Scanning: <?php echo esc_url( $scanned_url ); ?></p>
                    <p>Cache control: <?php echo esc_html( $result_anon['cache_control'] ); ?></p>
                    <p>Expires: <?php echo esc_html( $result_anon['expires'] ); ?></p>
                    <p>Etag: <?php echo esc_html( $result_anon['etag'] ); ?></p>
                    <p>Last modified: <?php echo esc_html( $result_anon['last_modified'] ); ?></p>
                    <p>Age: <?php echo esc_html( $result_anon['age'] ); ?></p>
                    <p><strong>Verdict (logged out): <?php echo esc_html( $result_anon['verdict'] ); ?></strong></p>
                    <p>Verdict (logged in): <?php echo esc_html( $result_auth['verdict'] ); ?></p>
                    <p>CDN: <?php echo esc_html( $result_anon['cdn'] ); ?></p>     
                    <p>Cache plugin: <?php echo esc_html( $result_anon['cache_plugin'] ); ?></p>
                    <p>Cache plugin footprint: <?php echo esc_html( $result_anon['cache_plugin_footprint'] ); ?></p>
                    <p>Server: <?php echo esc_html( $result_anon['server'] ); ?> </p>
                    <p>Varnish verdict: <?php echo esc_html( $result_anon['varnish_verdict'] ); ?> </p>
                    <p>Host: <?php echo esc_html( $result_anon['host'] ); ?></p>
                    <p>Object cache: <?php echo esc_html( $result_anon['object_cache'] ); ?></p>
                    <p>OPcache: <?php echo esc_html( $result_anon['opcache'] ); ?></p>
                <?php endif; ?>
            </div>
            <?php
        }
        
}

add_action( 'plugins_loaded', array( 'ITC', 'init' ) );
