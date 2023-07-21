<?php

function rcpr_post_rating_block_render_callback( $attrs, $content ) {
	
    global $post;

    $id = $post->ID;
    $classes = sanitize_text_field( strip_tags( $attrs[ 'classes' ] ) );
    $up = sanitize_text_field( strip_tags( $attrs[ 'uptext' ] ) );
    $down = sanitize_text_field( strip_tags( $attrs[ 'downtext' ] ) );

    return sprintf(
        '<div class="post-rating-tool" data-post-rating-id="' . esc_attr( $id ) . '">
            <a href="#' . sanitize_title( esc_attr( $up ) ) . '" class="' . esc_attr( $classes ) . ' rating-up">' . esc_attr( $up ) . '</a>
            <a href="#' . sanitize_title( esc_attr( $down ) ) . '" class="' . esc_attr( $classes ) . ' rating-down">' . esc_attr( $down ) . '</a>
        </div>',
        ''
    );
    
}


function rcpr_post_rating_block_register_block() {
	// automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __DIR__ ) . 'build/index.asset.php');
	
    // Get default up/down vote text, either from stored values or default to 'Up' or 'Down'
    $options = get_option( 'rcpr_post_rating_settings' );
    
    $rcpr_post_rating_up_text = $options[ 'rcpr_post_rating_up_text' ] ?? '';
    $rcpr_post_rating_down_text = $options[ 'rcpr_post_rating_down_text' ] ?? '';
    $rcpr_post_rating_button_classes = $options[ 'rcpr_post_rating_button_classes' ] ?? '';
    
    if ( $rcpr_post_rating_up_text != '' ) {
        $uptext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_up_text' ] ) );
    } else {
        $uptext = __( 'Up', 'rc-post-rating' );
    }
    
    if ( $rcpr_post_rating_down_text != '' ) {
        $downtext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_down_text' ] ) );
    } else {
        $downtext = __( 'Down', 'rc-post-rating' );
    }
    
    if ( $rcpr_post_rating_button_classes != '' ) {
        $rcpr_post_rating_button_classes = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_button_classes' ] ) );
    } else {
        $rcpr_post_rating_button_classes = '';
    }
    
    wp_register_script(
        'rcrp-post-rating-block',
        plugins_url( 'build/index.js', __DIR__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
 
    register_block_type( 'rcrp-post-rating/post-rating-block', array(
		'api_version' => 2,
        'editor_script' => 'rcrp-post-rating-block',
		'render_callback' => 'rcpr_post_rating_block_render_callback',
		'attributes' => array(
            /*'id' => array(
                'type' => 'number',
                'default' => null,
            ),*/
            'classes' => array(
                'type' => 'string',
                'default' => esc_attr( $rcpr_post_rating_button_classes ),
            ),
            'uptext' => array(
                'type' => 'string',
                'default' => esc_attr( $uptext ),
            ),
            'downtext' => array(
                'type' => 'string',
                'default' => esc_attr( $downtext ),
            ),
		),
    ) );
 
}
add_action( 'init', 'rcpr_post_rating_block_register_block' );