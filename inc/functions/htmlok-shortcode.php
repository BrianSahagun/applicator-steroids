<?php

// ------------------------------------ Applicator HTML_OK Shortcode
// [applicator_htmlok_cp name="Name"]Content[/applicator_htmlok_cp]
// https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/#complete-example

function applicator_htmlok_shortcode( $atts = [], $content = null, $tag = '' )
{
    $atts = array_change_key_case( ( array ) $atts, CASE_LOWER );
 
    $htmlok_atts = shortcode_atts( [
        'name' => 'HTML_OK',
    ], $atts, $tag );
 
    $o = '';
 
    $o .= '<div id="'. sanitize_title( $htmlok_atts['name'] ). '" class="cp'. ' '. sanitize_title( $htmlok_atts['name'] ). ' '. 'applicator-html-ok-shortcode'. '" data-name="'. esc_html( $htmlok_atts['name'] ). ' CP">';
        $o .= '<div class="cr'. ' '. sanitize_title( $htmlok_atts['name'] ). '---cr">';
            $o .= '<div class="h">' . esc_html__( $htmlok_atts['name'], 'applicator' ). '</div>';
            $o .= '<div class="ct'. ' '. sanitize_title( $htmlok_atts['name'] ). '---ct">';

            if ( ! is_null( $content ) )
            {
                $o .= do_shortcode( $content );
            }

            $o .= '</div>';
        $o .= '</div>';
    $o .= '</div>';
 
    return $o;
}