<?php

/**
 * Post Version
 *
 * Enables the display of Post Version after the Post Title
 *
 * @version 1.0.1
 */
function applicator_post_version_cf()
{
    $post_version_post_meta = get_post_meta( get_the_ID(), 'Applicator: Version', true );
    $post_version_post_meta_clean = substr( preg_replace( '/\s\s+/', ' ', trim( $post_version_post_meta ) ), 0, 160 );
    
    if ( $post_version_post_meta )
    {
        $post_version = $post_version_post_meta_clean;
    }
    else
    {
        return;
    }
    
    $allowed_html = array(
        'a' => array(
            'class' => array(),
            'href'  => array(),
            'title' => array(),
        ),
    );
    
    $post_version_obj = applicator_htmlok( array(
        'name'      => 'Post Version',
        'structure' => array(
            'type'      => 'object',
            'attr'      => array(
                'elem'      => array(
                    'title'     => __( 'Version', 'applicator' ),
                ),
            ),
        ),
        'content'   => array(
            'object'        => wp_kses( $post_version, $allowed_html ),
        ),
        'echo'      => true,
    ) );
}
add_action( 'applicator_after_post_title_hook', 'applicator_post_version_cf');