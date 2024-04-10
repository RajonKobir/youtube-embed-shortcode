<?php

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

/**
 *  WordPress Shortcode
*/

// including the function file
require_once 'youtube-search-shortcode.php';

// Register the shortcode
add_shortcode('yt_embed_shortcode', 'yt_embed_function');

