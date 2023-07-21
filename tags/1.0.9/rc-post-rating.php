<?php
/*
Plugin Name: RC Post Rating
Plugin URI: https://qreate.co.uk/projects/#rc-post-rating
Description: This plugin adds the ability for users to provide feedback on pages / posts via up / down rating buttons.
Version: 1.0.9
Author: Rick Curran
Author URI: https://qreate.co.uk
Text Domain: rc-post-rating
*/

/*
 * SETTINGS
 */
include( 'includes/settings.php' );

/*
 * POST RATING SHORTCODE
 */
include( 'includes/shortcode.php' );

/*
 * ADD CUSTOM COLUMNS TO POST / PAGE LISTINGS
 */
include( 'includes/columns.php' );

/*
 * ADD CUSTOM REST API ENDPOINT
 */
include( 'includes/rest.php' );

/*
 * ADD STATISTICS DASHBOARD WIDGET
 */
include( 'includes/stats.php' );

/*
 * BLOCK EDITOR
 */
include( 'includes/block.php' );

/*
 * JAVASCRIPT
 */
add_action( 'wp_enqueue_scripts', 'rcpr_post_rating_js' );
function rcpr_post_rating_js() {
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'rcpr_post_rating', plugin_dir_url( __FILE__ ) . 'js/rc-post-rating.js', array( 'jquery' ), '1.08', true );
    wp_localize_script( 'rcpr_post_rating', 'wpApiSettings', array( 'root' => esc_url_raw( rest_url() ), 'nonce' => wp_create_nonce( 'wp_rest' ) ) );
}

add_action( 'admin_enqueue_scripts', 'rcpr_post_rating_admin_js' );
function rcpr_post_rating_admin_js() {
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'rcpr_post_rating_admin', plugin_dir_url( __FILE__ ) . 'js/rc-post-rating-admin.js', array( 'jquery' ), '1.08', true );
    
    wp_register_style( 'rcpr_post_rating_admin_css', plugin_dir_url( __FILE__ ) . 'css/rc-post-rating-admin.css', false, '1.0.8' );
    wp_enqueue_style( 'rcpr_post_rating_admin_css' );
}

/*
 * ADDITIONAL LINKS ON PLUGIN LIST PAGE
 */
add_filter( 'plugin_row_meta', 'rcpr_post_rating_row_meta', 10, 4 );
function rcpr_post_rating_row_meta( $links_array, $plugin_file_name, $plugin_data, $status ) {
    
    if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
        if ( ! is_network_admin() ) {
            $links_array[] = '<a href="options-general.php?page=rcpr_post_rating_settings_screen">' . esc_attr__( 'Settings', 'rc-post-rating' ) . '</a>';
        }
        $links_array[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G">' . esc_attr__( 'Donate', 'rc-post-rating' ) . '</a>';
    }
    return $links_array;
}

/*
 * REDIRECT TO SETTINGS PAGE ON PLUGIN ACTIVATION
 */
add_action( 'activated_plugin', 'rcpr_post_rating_activate' );
function rcpr_post_rating_activate( $plugin ) {
    if ( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'options-general.php?page=rcpr_post_rating_settings_screen' ) ) );
    }
}

?>