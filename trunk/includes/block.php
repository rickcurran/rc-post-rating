<?php

function qr_post_rating_block_render_callback( $attrs, $content ) {
	
    global $post;

    $id = $post->ID;
    $classes = esc_attr( $attrs[ 'classes' ] );
    $up = esc_attr( $attrs[ 'uptext' ] );
    $down = esc_attr( $attrs[ 'downtext' ] );

    return sprintf(
        '<div class="post-rating-tool" data-post-rating-id="' . $id . '">
            <a class="' . $classes . ' rating-up">' . $up . '</a>
            <a class="' . $classes . ' rating-down">' . $down . '</a>
        </div>',
        ''
    );
    
}


function qr_post_rating_block_register_block() {
	// automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
	
    // Get default up/down vote text, either from stored values or default to 'Up' or 'Down'
    $options = get_option( 'qr_post_rating_settings' );
    
    if ( $options[ 'qr_post_rating_up_text' ] ) {
        $uptext = $options[ 'qr_post_rating_up_text' ];
    } else {
        $uptext = __( 'Up', 'qr_post_rating_plugin' );
    }
    
    if ( $options[ 'qr_post_rating_down_text' ] ) {
        $downtext = $options[ 'qr_post_rating_down_text' ];
    } else {
        $downtext = __( 'Down', 'qr_post_rating_plugin' );
    }
    
    if ( $options[ 'qr_post_rating_button_classes' ] ) {
        $qr_post_rating_button_classes = $options[ 'qr_post_rating_button_classes' ];
    } else {
        $qr_post_rating_button_classes = '';
    }
    
    wp_register_script(
        'post-rating-block',
        plugins_url( 'build/index.js', __DIR__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
 
    register_block_type( 'post-rating/post-rating-block', array(
		'api_version' => 2,
        'editor_script' => 'post-rating-block',
		'render_callback' => 'qr_post_rating_block_render_callback',
		'attributes' => array(
            /*'id' => array(
                'type' => 'number',
                'default' => null,
            ),*/
            'classes' => array(
                'type' => 'string',
                'default' => $qr_post_rating_button_classes,
            ),
            'uptext' => array(
                'type' => 'string',
                'default' => $uptext,
            ),
            'downtext' => array(
                'type' => 'string',
                'default' => $downtext,
            ),
		),
    ) );
 
}
add_action( 'init', 'qr_post_rating_block_register_block' );