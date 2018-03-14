<?php

/**
 * Applicator Custom Fields Shortcode
 *
 * Usage: [applicator_cf "<custom field name>"]
 * To get a Custom Field from another post: [applicator_o "<custom field name>" post_id="<post id>"]
 * For Post Slug instead of post id [applicator_o "<custom field name>" post_name="<post title>"]
 * For Page Slug instead of post id [applicator_o "<custom field name>" page_name="<page title>"]
 *
 * Warning: Posts that use this shortcode to output content will not retain the perceived content in exporting.
 * A remedy is to copy and paste the output in browser and "hardcode" the content—replacing all the shortcodes.
 *
 * @package WordPress\Applicator\Plugin\Function\Shortcode
 *
 * @version 1.0.1
 *
 * @link http://wpsnipp.com/index.php/functions-php/get-custom-field-value-with-shortcode/
 * @link https://wordpress.stackexchange.com/questions/9667/get-wordpress-post-content-by-post-id#comment110575_67255
 */
function applicator_custom_fields_shortcode( $atts )
{
    extract( shortcode_atts( array(
        'post_id'   => NULL,
        'post_name' => NULL,
        'page_name' => NULL,
    ), $atts ) );
    
    
    if ( !isset( $atts[0] ) )
    {
        return;
    }
    
    
    global $post;
    
    
    // Determines the value of Post ID
    if ( NULL !== $post_id )
    {
        $post_id = $post_id;
    }
    elseif ( NULL !== $post_name && $post_slug = get_page_by_title( $post_name, OBJECT, 'post' ) )
    {
        $post_id = $post_slug->ID;
    }
    elseif ( NULL !== $page_name && $post_slug = get_page_by_title( $page_name, OBJECT, 'page' ) )
    {
        $post_id = $post_slug->ID;
    }
    else
    {
        $post_id = $post->ID;
    }
    

    $field = esc_attr( $atts[0] );


    return get_post_meta( $post_id, $field, true );
}