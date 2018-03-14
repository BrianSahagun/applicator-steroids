<?php

/*!
Plugin Name: Applicator on Steroids
Plugin URI: http://applicator.dysinelab.com/plugins/applicator-steroids/
Description: Applicator Transformation Pack
Author: Brian Dys Sahagun
Version: 0.0.0.12
Author URI: http://briansahagun.com
*/





$theme = wp_get_theme();
$applicator_term = 'Applicator';

if ( $applicator_term == $theme->name || $applicator_term == $theme->parent_theme )
{
    require( plugin_dir_path( __FILE__ ). 'functions.php' );
    require( plugin_dir_path( __FILE__ ). 'prezo/functions.php' );
}