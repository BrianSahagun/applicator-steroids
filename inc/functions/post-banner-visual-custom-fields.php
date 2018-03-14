<?php

// ------------------------------------ Post Banner Visual via Custom Fields
function applicator_post_banner_visual_cf()
{
    $post_banner_visual_obj = '';
    $featured_image_post_meta = get_post_meta( get_the_ID(), 'Applicator: Featured Image', true );
    $post_banner_visual_a_MU = '<a class="post-banner-visual---a" href="'. get_the_permalink(). '"></a>';

    if ( $featured_image_post_meta )
    {
        $post_banner_visual_obj = applicator_htmlok( array(
            'name'      => 'Post Banner Visual',
            'structure' => array(
                'type'      => 'object',
            ),
            'title'     => esc_html( get_the_title() ),
            'content'   => array(
                'object'    => array(
                    $post_banner_visual_a_MU,
                    $featured_image_post_meta,
                ),
            ),
        ) );
    }
    
    return $post_banner_visual_obj;
}


// Remove the Featured Image via Meta Box if Featured Image via Custom Fields is present 
function applicator_post_banner_visual_hooked_remove()
{
    if ( '' !== get_the_post_thumbnail() && get_post_meta( get_the_ID(), 'Applicator: Featured Image', true ) )
    {
        remove_action( 'applicator_hook_after_post_meta_header_aside', 'applicator_post_banner_visual_hooked' );
    }
}
add_action( 'wp_head', 'applicator_post_banner_visual_hooked_remove' );


// Post Banner Visual Inserted via Hook
function applicator_post_banner_visual_cf_hooked()
{
    echo applicator_post_banner_visual_cf();
}
add_action( 'applicator_hook_after_post_meta_header_aside', 'applicator_post_banner_visual_cf_hooked' );


// Post Banner Visual via Custom Fields - HTML Class
function applicator_post_banner_visual_cf_body_class( $classes )
{
    if ( is_single() && get_post_meta( get_the_ID(), 'Applicator: Featured Image', true ) )
    {   
        $classes[] = 'post-banner-visual-custom-field--enabled';
    }
    return $classes;
}
add_action( 'body_class', 'applicator_post_banner_visual_cf_body_class');


// Post Class
function applicator_post_banner_visual_cf_post_class( $classes )
{
	if ( get_post_meta( get_the_ID(), 'Applicator: Featured Image', true ) )
    {
        $classes[] = 'post-banner-visual-custom-field--enabled';
    }
    return $classes;
}
add_filter( 'post_class', 'applicator_post_banner_visual_cf_post_class' );