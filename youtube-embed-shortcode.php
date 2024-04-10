<?php
/*
Plugin Name: YouTube Embed Shortcode
Description: Embed YouTube videos using a shortcode with a keyword search.
Version: 1.0
Author: Rajon Kobir
Author URI: https://github.com/RajonKobir
*/

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

// Define plugin constants 
define( 'YOUTUBE_EMBED_SHORTCODE_PLUGIN_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( 'YOUTUBE_EMBED_SHORTCODE_PLUGIN_URL', trailingslashit( plugins_url('/', __FILE__) ) );
define( 'YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME', 'youtube_embed_shortcode' );

//  add shortcodes
if( !is_admin() ) {
    require_once YOUTUBE_EMBED_SHORTCODE_PLUGIN_PATH . '/inc/shortcodes/shortcodes.php';
}

//  add settings page 
if( is_admin() ) {
    require_once YOUTUBE_EMBED_SHORTCODE_PLUGIN_PATH . '/inc/settings/settings.php';
}



?>