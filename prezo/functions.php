<?php

/**
 * Applicator on Steroids – Prezo Functions
 */





/**
 * Custom Fields
 */
function applicator_steroids_prezo_cf()
{
    $class_name_post_meta = get_post_meta( get_the_ID(), 'Applicator: Prezo', true );
    $class_name_post_meta_clean = substr( sanitize_title( preg_replace( '/\s+/', '', trim( $class_name_post_meta ) ) ), 0, 16 );
    
    $on_terms = array(
        '1',
        'active',
        'activate',
        'activated',
        'enable',
        'enabled',
        'fire',
        'go',
        'on',
        'run',
    );
    
    return ( is_singular() && in_array( $class_name_post_meta_clean, $on_terms, true ) );
}





/**
 * Body Class
 */
function applicator_steroids_prezo_body_class( $classes )
{
    if ( applicator_steroids_prezo_cf() )
    {
        $classes[] = 'prezo---a8r_f';
    }
    return $classes;
}
add_filter( 'body_class', 'applicator_steroids_prezo_body_class' );





/**
 * Styles & Scripts
 */
function applicator_steroids_prezo_styles_scripts()
{
    if ( applicator_steroids_prezo_cf() )
    {
        wp_enqueue_style( 'applicator-steroids-prezo-default--style', plugin_dir_url( __FILE__ ). 'assets/css/default.css' );
        wp_enqueue_script( 'applicator-steroids-prezo-default--script', plugin_dir_url( __FILE__ ). 'assets/js/default.js', array( 'applicator-enhancements--script' ), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'applicator_steroids_prezo_styles_scripts', 0 );