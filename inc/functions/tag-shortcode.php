<?php

/**
 *
 * Applicator Tag Shortcode
 *
 * Usage: [applicator_tag "[tag]"]
 *
 * @package WordPress\Applicator\Plugin\Function\Shortcode
 *
 * @version 1.0.0
 *
 */
function applicator_tag_shortcode( $atts )
{
    extract( shortcode_atts( array(
        'post_id' => NULL,
    ), $atts ) );
    
    if ( !isset( $atts[0] ) )
    {
        return;
    }
    
    $field = esc_attr( $atts[0] );
    
    $tag = get_term_by( 'slug', $field, 'post_tag' );
    
    $tag_display = '';
    
    if ( $tag )
    {
        $tag_id = $tag->term_id;
        $tag_link = get_tag_link( $tag_id );
        
        $tag_display = '<a class="tag" href="'. $tag_link. '">'. $field. '</a>';
    }
    else
    {
        $tag_display = '<span class="untagged">'. $field. '</span>';
    }
    
    return $tag_display;
}