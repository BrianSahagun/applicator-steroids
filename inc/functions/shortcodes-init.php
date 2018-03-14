<?php





function applicator_shortcodes_init()
{
    add_shortcode( 'applicator_cf', 'applicator_custom_fields_shortcode' );
    add_shortcode( 'applicator_content', 'applicator_content_shortcode' );
    add_shortcode( 'applicator_htmlok_cp', 'applicator_htmlok_shortcode' );
    add_shortcode( 'applicator_tag', 'applicator_tag_shortcode' );
}
add_action('init', 'applicator_shortcodes_init');





/**
 * Remove <p> and <br> around [shortcode]
 *
 * @author Borek
 *
 * @link https://wordpress.stackexchange.com/a/130185/59838
 */
function the_content_filter( $content )
{
    $shortcode = join( '|', array(
        'applicator_cf',
        'applicator_content',
        'applicator_htmlok_cp',
        'applicator_tag',
    ) );
    
    $clean_shortcode = preg_replace( "/(<p>)?\[($shortcode)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
		
	$clean_shortcode = preg_replace( "/(<p>)?\[\/($shortcode)](<\/p>|<br \/>)?/", "[/$2]", $clean_shortcode );
	
    return $clean_shortcode;
}
add_filter( 'the_content', 'the_content_filter' );





add_filter( 'widget_text', 'do_shortcode' );