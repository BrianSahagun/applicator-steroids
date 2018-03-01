<?php





// Styles and Scripts
function applicator_prezo_cf()
{
    $class_name_post_meta = get_post_meta( get_the_ID(), 'Applicator: Prezo', true );
    $class_name_post_meta_clean = substr( sanitize_title( preg_replace( '/\s+/', '', trim( $class_name_post_meta ) ) ), 0, 8 );
    
    $on_terms = array(
        'enable',
        'enabled',
        'active',
        'activate',
        'activated',
        'on',
        '1',
        'run',
        'go',
    );
    
    return ( in_array( $class_name_post_meta_clean, $on_terms, true ) );
}





// ------------------------------------ Prezo Feature via Custom Fields – Inserted into the Body Class
function applicator_prezo_cf_body_class( $classes )
{
    if ( applicator_prezo_cf() )
    {
        $classes[] = 'prezo---a8r_f';
    }
    return $classes;
}
add_filter( 'body_class', 'applicator_prezo_cf_body_class' );





function applicator_steroid_prezo_styles_scripts()
{
    if ( applicator_prezo_cf() )
    {
        wp_enqueue_style( 'applicator-prezo-style--default', plugin_dir_url( __FILE__ ). 'assets/css/default.css' );
        wp_enqueue_script( 'applicator-prezo-script-default', plugin_dir_url( __FILE__ ). 'assets/js/default.js', array( 'jquery' ), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'applicator_steroid_prezo_styles_scripts', 0 );