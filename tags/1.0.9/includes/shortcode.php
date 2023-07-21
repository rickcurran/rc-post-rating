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
		'labelledby' => '',
		'uptext' => '',
		'downtext' => '',
		'upassistivetext' => '',
		'downassistivetext' => '',
		'type' => 'a',
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
    
    if ( $options[ 'rcpr_post_rating_up_assistive_text' ] ) {
        $rcpr_post_rating_up_assistive_text = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_up_assistive_text' ] ) );
    } else {
        $rcpr_post_rating_up_assistive_text = '';
    }
    
    if ( $options[ 'rcpr_post_rating_down_assistive_text' ] ) {
        $rcpr_post_rating_down_assistive_text = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_down_assistive_text' ] ) );
    } else {
        $rcpr_post_rating_down_assistive_text = '';
    }
    
    
    if ( $options[ 'rcpr_post_rating_button_classes' ] ) {
        $rcpr_post_rating_button_classes = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_button_classes' ] ) );
    } else {
        $rcpr_post_rating_button_classes = '';
    }  
    
    if ( $options[ 'rcpr_post_rating_labelledby' ] ) {
        $rcpr_post_rating_labelledby = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_labelledby' ] ) );
    } else {
        $rcpr_post_rating_labelledby = '';
    }  
    
    if ( $atts[ 'labelledby' ] != '' ) {
        $labelledby = sanitize_text_field( strip_tags( $atts[ 'labelledby' ] ) ) . ' ';
    } else {
        $labelledby = $rcpr_post_rating_labelledby;
    }
    
    if ( $labelledby != '' ) {
        $labelledby_value = ' aria-labelledby="' . $labelledby . '"';
    } else {
        $labelledby_value = '';
    }
    
    if ( $atts[ 'upassistivetext' ] != '' ) {
        $upassistivetext = sanitize_text_field( strip_tags( $atts[ 'upassistivetext' ] ) ) . ' ';
    } else {
        $upassistivetext = $rcpr_post_rating_up_assistive_text;
    }
    
    if ( $upassistivetext != '' ) {
        $upassistivetext_value = ' <span class="show-for-sr">' . $upassistivetext . '</span>';
    } else {
        $upassistivetext_value = '';
    }
    
    if ( $atts[ 'downassistivetext' ] != '' ) {
        $downassistivetext = sanitize_text_field( strip_tags( $atts[ 'downassistivetext' ] ) ) . ' ';
    } else {
        $downassistivetext = $rcpr_post_rating_down_assistive_text;
    }
    
    if ( $downassistivetext != '' ) {
        $downassistivetext_value = ' <span class="show-for-sr">' . $downassistivetext . '</span>';
    } else {
        $downassistivetext_value = '';
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
	
    // Format vote widget markup
    $type = $atts[ 'type' ] ?? 'a';
    
	$data = '<div class="post-rating-tool" data-post-rating-id="' . esc_attr( $id ) . '"' . $labelledby_value . '>';
    
    if ( $type == 'button' ) {
        $data .= '<button class="' . esc_attr( $classes ) . ' rating-up" aria-label="' . esc_attr( $up . strip_tags( $upassistivetext_value ) ) . '">' . esc_attr( $up ) . '</button>';
        $data .= '<button class="' . esc_attr( $classes ) . ' rating-down" aria-label="' . esc_attr( $down . strip_tags( $downassistivetext_value ) ) .'">' . esc_attr( $down ) . '</button>';
    } else {
        $data .= '<a href="#' . sanitize_title( esc_attr( $up ) ) . '" class="' . esc_attr( $classes ) . ' rating-up">' . esc_attr( $up ) . esc_attr( $upassistivetext_value ) . '</a>';
        $data .= '<a href="#' . sanitize_title( esc_attr( $down ) ) . '" class="' . esc_attr( $classes ) . ' rating-down">' . esc_attr( $down ) . esc_attr( $downassistivetext_value ) . '</a>';
    }
    $data .= '</div>';
	
	return $data;
}

add_shortcode( 'rc_post_rating', 'rcpr_post_rating_shortcode' );

?>