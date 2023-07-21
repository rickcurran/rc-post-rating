<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Settings
 */


add_action( 'admin_menu', 'rcpr_post_rating_settings_menu' );
add_action( 'admin_init', 'rcpr_post_rating_settings_init' );

/*
 * Add Menu Page under Settings
 */
function rcpr_post_rating_settings_menu() {
    
	add_submenu_page( 'options-general.php', 'RC Post Rating', 'RC Post Rating', 'manage_options', 'rcpr_post_rating_settings_screen', 'rcpr_post_rating_settings_screen' );

}

/*
 * Settings Page Render / Storing...
 */
function rcpr_post_rating_settings_init() { 

	register_setting( 'rcpr_post_rating_admin_page', 'rcpr_post_rating_settings' );

	add_settings_section( 'rcpr_post_rating_admin_page_section',  __( 'This page allows you to change a few settings for this plugin. You can enable/disable a statistics widget in the Dashboard and also enable/disable admin columns for the post types that are active on your site.', 'rc-post-rating' ),  'rcpr_post_rating_settings_section_callback', 'rcpr_post_rating_admin_page' );

	add_settings_section( 'rcpr_post_rating_admin_page_accessiblity_section',  __( 'The following section includes some fields which can be used to aid accessibility of the rating widget. The `additional assistive text` fields are intended to only be `visible` to screen-reader users and will add span elements with a class of `show-for-sr`, but you will need to add appropriate CSS styles to render these as hidden to visual users but accessible by screen-reader users.', 'rc-post-rating' ),  'rcpr_post_rating_settings_accessibility_section_callback', 'rcpr_post_rating_admin_page' );

	add_settings_field( 'rcpr_post_rating_dashboard_widget_status', __( 'Show Ratings Statistics widget in Dashboard:', 'rc-post-rating' ), 'rcpr_post_rating_dashboard_widget_status_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_section' );

	add_settings_field( 'rcpr_post_rating_show_admin_columns_for_post_types', __( 'Show Ratings Admin Columns for the following post types:', 'rc-post-rating' ), 'rcpr_post_rating_show_admin_columns_for_post_types_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_section' );
    
	add_settings_field( 'rcpr_post_rating_up_text', __( 'Default Upvote text:', 'rc-post-rating' ), 'rcpr_post_rating_up_text_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_section' );
    
	add_settings_field( 'rcpr_post_rating_down_text', __( 'Default Downvote text:', 'rc-post-rating' ), 'rcpr_post_rating_down_text_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_section' );
    
	add_settings_field( 'rcpr_post_rating_up_assistive_text', __( 'Upvote additional assistive text:', 'rc-post-rating' ), 'rcpr_post_rating_up_assistive_text_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_accessiblity_section' );
    
	add_settings_field( 'rcpr_post_rating_down_assistive_text', __( 'Downvote additional assistive text:', 'rc-post-rating' ), 'rcpr_post_rating_down_assistive_text_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_accessiblity_section' );
    
	add_settings_field( 'rcpr_post_rating_labelledby', __( 'ARIA Labelledby value (use this to associate the rating buttons to an HTML element):', 'rc-post-rating' ), 'rcpr_post_rating_labelledby_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_accessiblity_section' );

    add_settings_field( 'rcpr_post_rating_button_classes', __( 'Default button CSS classes (space separated):', 'rc-post-rating' ), 'rcpr_post_rating_button_classes_render', 'rcpr_post_rating_admin_page', 'rcpr_post_rating_admin_page_section' );
    
    add_settings_section( 'rcpr_post_rating_admin_page_save_section', '', 'rcpr_post_rating_save_section_callback', 'rcpr_post_rating_admin_page' );
    
    add_settings_section( 'rcpr_post_rating_admin_page_donate_section', __( 'Support this plugin', 'rc-post-rating' ), 'rcpr_post_rating_settings_donate_section_callback', 'rcpr_post_rating_admin_page' );
    
}

function rcpr_post_rating_settings_screen() { 

	?>
    <div class="wrap">
        <form action='options.php' method='post'>

            <h1><?php echo esc_attr__( 'Post Rating settings', 'rc-post-rating' ); ?></h1>

            <?php
              settings_fields( 'rcpr_post_rating_admin_page' );
              do_settings_sections( 'rcpr_post_rating_admin_page' );
            ?>

        </form>
    </div>
	<?php
}

function rcpr_post_rating_settings_section_callback() {
    // Currently no callback functions used
}

function rcpr_post_rating_settings_accessibility_section_callback() {
    // Currently no callback functions used
}

function rcpr_post_rating_dashboard_widget_status_render() {

	$options = get_option( 'rcpr_post_rating_settings' );
    
	?>
	<select name='rcpr_post_rating_settings[rcpr_post_rating_dashboard_widget_status]'>
		<option value='disabled' <?php selected( sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_dashboard_widget_status' ] ) ), 'disabled' ); ?>><?php echo esc_attr__( 'Disabled', 'rc-post-rating' ); ?></option>
		<option value='enabled' <?php selected( sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_dashboard_widget_status' ] ) ), 'enabled' ); ?>><?php echo esc_attr__( 'Enabled', 'rc-post-rating' ); ?></option>
	</select>

<?php
    
    if ( $options[ 'rcpr_post_rating_dashboard_widget_status' ] === 'disabled' ) {
        
        echo '<p style="color:darkorange;font-weight:bold;">&uarr; ' . esc_attr__( 'Changing this to "Enabled" will enable a statistics widget in the Dashboard', 'rc-post-rating' ) . '</p>';
        
    }

}

function rcpr_post_rating_show_admin_columns_for_post_types_render() {

	$options = get_option( 'rcpr_post_rating_settings' );
    
    $rcpr_post_rating_show_admin_columns_for_post_types = array();
    if ( isset( $options[ 'rcpr_post_rating_show_admin_columns_for_post_types' ] ) ) {
        $rcpr_post_rating_show_admin_columns_for_post_types = maybe_unserialize( $options[ 'rcpr_post_rating_show_admin_columns_for_post_types' ] );
    }
    
    $args = array(
       'public'   => true,
       '_builtin' => false,
       'publicly_queryable' => true
    );

    $output = 'objects';
    $operator = 'or';

    $post_types = get_post_types( $args, $output, $operator );

    if ( $post_types ) { // Get post types.

        echo '<ul>';
        
        foreach( $post_types as $post_type ) {

            $checked = '';
            if ( is_array($rcpr_post_rating_show_admin_columns_for_post_types) && in_array( $post_type->name, $rcpr_post_rating_show_admin_columns_for_post_types ) ) {
                $checked = ' checked';
            }
            
            if ( $post_type->name != 'attachment' ) { // Excluding attachment post types as it unlikely to be used for rating, plus it also doesn't use Admin columns in the same way as other posts
                echo '<li><label style="padding:0 10px 0 8px;display:block;"><input type="checkbox" name="rcpr_post_rating_settings[rcpr_post_rating_show_admin_columns_for_post_types][]" value="' . esc_attr( $post_type->name ) . '"' . $checked . '> <span>' . esc_attr( $post_type->labels->singular_name ) . '</span></label></li>';
            }

        }

        echo '<ul>';
        
        //echo print_r($rcpr_post_rating_show_admin_columns_for_post_types);
    }
    
    

}


function rcpr_post_rating_up_text_render() {
    
    $options = get_option( 'rcpr_post_rating_settings' );
    
    if ( $options[ 'rcpr_post_rating_up_text' ] ) {
        $uptext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_up_text' ] ) );
    } else {
        $uptext = __( 'Up', 'rc-post-rating' );
    }
    
    echo '<input type="text" name="rcpr_post_rating_settings[rcpr_post_rating_up_text]" value="' . esc_attr( $uptext ) . '">';
    
}


function rcpr_post_rating_down_text_render() {
    
    $options = get_option( 'rcpr_post_rating_settings' );
    
    if ( $options[ 'rcpr_post_rating_down_text' ] ) {
        $downtext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_down_text' ] ) );
    } else {
        $downtext = __( 'Down', 'rc-post-rating' );
    }
    
    echo '<input type="text" name="rcpr_post_rating_settings[rcpr_post_rating_down_text]" value="' . esc_attr( $downtext ) . '">';
    
}

function rcpr_post_rating_up_assistive_text_render() {
    
    $options = get_option( 'rcpr_post_rating_settings' );
    
    if ( $options[ 'rcpr_post_rating_up_assistive_text' ] ) {
        $upassistivetext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_up_assistive_text' ] ) );
    } else {
        $upassistivetext = '';
    }
    
    echo '<input type="text" name="rcpr_post_rating_settings[rcpr_post_rating_up_assistive_text]" value="' . esc_attr( $upassistivetext ) . '" style="width:100%;">';
    
}

function rcpr_post_rating_down_assistive_text_render() {
    
    $options = get_option( 'rcpr_post_rating_settings' );
    
    if ( $options[ 'rcpr_post_rating_down_assistive_text' ] ) {
        $downassistivetext = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_down_assistive_text' ] ) );
    } else {
        $downassistivetext = '';
    }
    
    echo '<input type="text" name="rcpr_post_rating_settings[rcpr_post_rating_down_assistive_text]" value="' . esc_attr( $downassistivetext ) . '" style="width:100%;">';
    
}

function rcpr_post_rating_button_classes_render() {
    
    $options = get_option( 'rcpr_post_rating_settings' );
    
    $rcpr_post_rating_button_classes = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_button_classes' ] ) );
    
    echo '<input type="text" name="rcpr_post_rating_settings[rcpr_post_rating_button_classes]" value="' . esc_attr( $rcpr_post_rating_button_classes ) . '" style="width:100%;">';
    
}

function rcpr_post_rating_labelledby_render() {
    
    $options = get_option( 'rcpr_post_rating_settings' );
    
    $rcpr_post_rating_labelledby = sanitize_text_field( strip_tags( $options[ 'rcpr_post_rating_labelledby' ] ) );
    
    echo '<input type="text" name="rcpr_post_rating_settings[rcpr_post_rating_labelledby]" value="' . esc_attr( $rcpr_post_rating_labelledby ) . '" style="width:100%;">';
    
}


function rcpr_post_rating_save_section_callback( $arg ) {
	
    echo '<hr>';
    
    submit_button();
    
    echo '<hr>';
}

function rcpr_post_rating_settings_donate_section_callback( $arg ) {
	
    echo __( '<p><strong>If you have found this plugin to be useful then please consider a donation. Donations like these help to provide time for <strong><a href="https://qreate.co.uk/about">me</a></strong> to develop plugins like this.</strong></p>', 'rc-post-rating' );
    echo __( '<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G" class="button button-primary" target="_blank">Donate</a></p>', 'rc-post-rating' );
    
}


?>