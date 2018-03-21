<?php

/**
 * Applicator Percept Shortcode
 *
 * Usage: [applicator_percept post_id="<post id>"]
 *
 * @package WordPress\Applicator\Plugin\Function\Shortcode
 *
 * @version 1.0.0
 */
function applicator_percept_shortcode( $atts )
{
    $atts = array_change_key_case( ( array ) $atts, CASE_LOWER );
 
    $clean_atts = extract( shortcode_atts( array(
        'content'   => NULL,
        'post_name' => NULL,
        'post_id'   => NULL,
        'page_name' => NULL,
        'page_id'   => NULL,
    ), $atts ) );
    
    
    $args = array(
        'post_status'   => 'publish',
        'name'          => sanitize_title( $post_name ),
        'p'             => $post_id,
        'pagename'      => sanitize_title( $page_name ),
        'page_id'       => $page_id,
    );
    
    
    // From Custom Fields
    if ( NULL !== $content || isset( $atts[0] ) )
    {
        // If content="" is set
        if ( NULL !== $content && ! isset( $atts[0] ) )
        {
            $content = $content;
        }
        
        // If root attribute is set
        elseif ( NULL === $content && isset( $atts[0] ) )
        {
            $content = esc_attr( $atts[0] );
        }
        
        
        // If no Post is defined, use the current Post
        if ( NULL === $post_name && NULL === $post_id && NULL === $page_name && NULL === $page_id )
        {
            global $post;
            
            $post_id = $post->ID;
        }
        
        // If Post ID or Name is defined, get the ID of that
        else
        {
            $the_query = new WP_Query( $args );


            if ( $the_query->have_posts() )
            {   
                while ( $the_query->have_posts() )
                {
                    $the_query->the_post();

                    $post_id = get_the_id();
                }
            }
            wp_reset_postdata();
        }
        
        
        return get_post_meta( $post_id, $content, true );
    }
    
    // From Content
    else
    {
        // Gatekeeper
        if ( NULL === $post_name && NULL === $post_id && NULL === $page_name && NULL === $page_id )
        {
            return;
        }

        
        $the_query = new WP_Query( $args );


        if ( $the_query->have_posts() )
        {   
            while ( $the_query->have_posts() )
            {
                $the_query->the_post();

                $section_mu = '<section class="applicator-percept" data-source-url="'. get_the_permalink().'">';
                    $section_mu .= '<h1>%2$s</h1>';
                    $section_mu .= '%1$s';
                $section_mu .= '</section>';

                $percept_section = sprintf( $section_mu,
                    apply_filters( 'the_content', do_shortcode( get_the_content() ) ),
                    get_the_title()
                );
                
                return $percept_section;
            }
        }
        wp_reset_postdata();
    }
    
    
    
}