<?php

// ------------------------------------ Class Name via Custom Fields – Inserted into the Body Class
function applicator_class_name_cf_body_class( $classes )
{
    $class_name_post_meta = get_post_meta( get_the_ID(), 'Applicator: Class Name', true );
    
    if ( $class_name_post_meta )
    {
        $classes[] = sanitize_title( wp_strip_all_tags( $class_name_post_meta ) );
    }
    return $classes;
}
add_filter( 'body_class', 'applicator_class_name_cf_body_class' );