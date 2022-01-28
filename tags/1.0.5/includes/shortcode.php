<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Shortcode
 */

function rcpr_post_rating_shortcode( $atts ) {
    $atts = shortcode_atts( array(
		'id' => '',
		'classes' => '',
		'uptext' => '',
		'downtext' => '',
	), $atts, 'rc_post_rating' );
    
    
    // Get default up/down vote text, either from stored values or default to 'Up' or 'Down'
    $options = get_option( 'rcpr_post_rating_settings' );
    
    if ( $options[ 'rcpr_post_rating_up_text' ] ) {
        $uptext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_up_text' ] ) );
    } else {
        $uptext = __( 'Up', 'rc-post-rating' );
    }
    
    if ( $options[ 'rcpr_post_rating_down_text' ] ) {
        $downtext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_down_text' ] ) );
    } else {
        $downtext = __( 'Down', 'rc-post-rating' );
    }
    
    if ( $options[ 'rcpr_post_rating_button_classes' ] ) {
        $rcpr_post_rating_button_classes = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_button_classes' ] ) );
    } else {
        $rcpr_post_rating_button_classes = '';
    }  
    
    
    if ( $atts[ 'classes' ] != '' ) {
        $classes = sanitize_text_field( strip_tags( $atts[ 'classes' ] ) ) . ' ';
    } else {
        $classes = $rcpr_post_rating_button_classes;
    }
    
    if ( $atts[ 'id' ] != '' ) {
        $id = sanitize_text_field( strip_tags( $atts[ 'id' ] ) );
    } else {
        global $post;
        $id = $post->ID;
    }
	
    if ( $atts[ 'uptext' ] != '' ) {
        $up = sanitize_text_field( strip_tags( $atts[ 'uptext' ] ) );
    } else {
        $up = $uptext;
    }
	
    if ( $atts[ 'downtext' ] != '' ) {
        $down = sanitize_text_field( strip_tags( $atts[ 'downtext' ] ) );
    } else {
        $down = $downtext;
    }
	
	$data = '<div class="post-rating-tool" data-post-rating-id="' . esc_attr( $id ) . '">
                <a href="#' . sanitize_title( esc_attr( $up ) ) . '" class="' . esc_attr( $classes ) . ' rating-up">' . esc_attr( $up ) . '</a>
                <a href="#' . sanitize_title( esc_attr( $down ) ) . '" class="' . esc_attr( $classes ) . ' rating-down">' . esc_attr( $down ) . '</a>
            </div>';
	
	return $data;
}

add_shortcode( 'rc_post_rating', 'rcpr_post_rating_shortcode' );

?>