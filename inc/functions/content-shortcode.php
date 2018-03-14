<?php

/**
 * Applicator Content Shortcode
 *
 * Usage: [applicator_o post_id="<post id>"]
 *
 * @package WordPress\Applicator\Plugin\Function\Shortcode
 *
 * @version 1.0.0
 *
 * @link https://wordpress.stackexchange.com/questions/9667/get-wordpress-post-content-by-post-id#comment110575_67255
 */
function applicator_content_shortcode( $atts )
{
    extract( shortcode_atts( array(
        'post_name' => NULL,
        'page_name' => NULL,
    ), $atts ) );
    
    
    if ( NULL === $post_name && NULL === $page_name )
    {
        return;
    }
    
    
    $args = array(
        'post_type'     => array(
            'post',
            'page',
        ),
        'post_status'   => 'publish',
        'name'          => $post_name,
        'pagename'      => $page_name,
    );

    
    $the_query = new WP_Query( $args );

    
    if ( $the_query->have_posts() )
    {   
        ob_start();
        while ( $the_query->have_posts() )
        {
            $the_query->the_post();
            echo apply_filters( 'the_content', get_the_content() );
        }
        $query_content_ob = ob_get_clean();


        return $query_content_ob;
    }
    wp_reset_postdata();
}