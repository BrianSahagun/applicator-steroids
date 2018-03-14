<?php

/**
 * Functions
 */





$r_functions = array(
    'class-name-custom-fields',
    'content-shortcode',
    'custom-fields-shortcode',
    'htmlok-shortcode',
    'tag-shortcode',
    'post-banner-visual-custom-fields',
    'post-version-custom-fields',
    'shortcodes-init',
    'svg',
);


foreach ( $r_functions as $file_name )
{
    require( plugin_dir_path( __FILE__ ). 'inc/functions/'. $file_name. '.php' );
}