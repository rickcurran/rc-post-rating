<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Settings
 */


add_action( 'admin_menu', 'qr_post_rating_settings_menu' );
add_action( 'admin_init', 'qr_post_rating_settings_init' );

/*
 * Add Menu Page under Settings
 */
function qr_post_rating_settings_menu() {
    
	add_submenu_page( 'options-general.php', 'Post Rating', 'Post Rating', 'manage_options', 'qr_post_rating_settings_screen', 'qr_post_rating_settings_screen' );

}

/*
 * Settings Page Render / Storing...
 */
function qr_post_rating_settings_init() { 

	register_setting( 'qr_post_rating_admin_page', 'qr_post_rating_settings' );

	add_settings_section( 'qr_post_rating_admin_page_section',  __( 'This page allows you to change a few settings for this plugin. You can enable/disable a statistics widget in the Dashboard and also enable/disable admin columns for the post types that are active on your site.', 'qr_post_rating_plugin' ),  'qr_post_rating_settings_section_callback', 'qr_post_rating_admin_page' );

	add_settings_field( 'qr_post_rating_dashboard_widget_status', __( 'Show Ratings Statistics widget in Dashboard:', 'qr_post_rating_plugin' ), 'qr_post_rating_dashboard_widget_status_render', 'qr_post_rating_admin_page', 'qr_post_rating_admin_page_section' );

	add_settings_field( 'qr_post_rating_show_admin_columns_for_post_types', __( 'Show Ratings Admin Columns for the following post types:', 'qr_post_rating_plugin' ), 'qr_post_rating_show_admin_columns_for_post_types_render', 'qr_post_rating_admin_page', 'qr_post_rating_admin_page_section' );
    
	add_settings_field( 'qr_post_rating_up_text', __( 'Default Upvote text:', 'qr_post_rating_plugin' ), 'qr_post_rating_up_text_render', 'qr_post_rating_admin_page', 'qr_post_rating_admin_page_section' );
    
	add_settings_field( 'qr_post_rating_down_text', __( 'Default Downvote text:', 'qr_post_rating_plugin' ), 'qr_post_rating_down_text_render', 'qr_post_rating_admin_page', 'qr_post_rating_admin_page_section' );
    
	add_settings_field( 'qr_post_rating_button_classes', __( 'Default button CSS classes (space separated):', 'qr_post_rating_plugin' ), 'qr_post_rating_button_classes_render', 'qr_post_rating_admin_page', 'qr_post_rating_admin_page_section' );
    
    add_settings_section( 'qr_post_rating_admin_page_save_section', '', 'qr_post_rating_save_section_callback', 'qr_post_rating_admin_page' );
    
    add_settings_section( 'qr_post_rating_admin_page_donate_section', __( 'Support this plugin', 'qr_post_rating_plugin' ), 'qr_post_rating_settings_donate_section_callback', 'qr_post_rating_admin_page' );
    
}

function qr_post_rating_settings_screen() { 

	?>
    <div class="wrap">
        <form action='options.php' method='post'>

            <h1><?php echo __( 'Post Rating settings', 'qr_post_rating_plugin' ); ?></h1>

            <?php
              settings_fields( 'qr_post_rating_admin_page' );
              do_settings_sections( 'qr_post_rating_admin_page' );
            ?>

        </form>
    </div>
	<?php
}

function qr_post_rating_dashboard_widget_status_render() {

	$options = get_option( 'qr_post_rating_settings' );
    
	?>
	<select name='qr_post_rating_settings[qr_post_rating_dashboard_widget_status]'>
		<option value='disabled' <?php selected( $options[ 'qr_post_rating_dashboard_widget_status' ], 'disabled' ); ?>><?php echo __( 'Disabled', 'qr_post_rating_plugin' ); ?></option>
		<option value='enabled' <?php selected( $options[ 'qr_post_rating_dashboard_widget_status' ], 'enabled' ); ?>><?php echo __( 'Enabled', 'qr_post_rating_plugin' ); ?></option>
	</select>

<?php
    
    if ( $options[ 'qr_post_rating_dashboard_widget_status' ] === 'disabled' ) {
        
        echo '<p style="color:darkorange;font-weight:bold;">&uarr; ' . __( 'Changing this to "Enabled" will enable a statistics widget in the Dashboard', 'qr_post_rating_plugin' ) . '</p>';
        
    }

}

function qr_post_rating_show_admin_columns_for_post_types_render() {

	$options = get_option( 'qr_post_rating_settings' );
    
    $qr_post_rating_show_admin_columns_for_post_types = array();
    if ( isset( $options[ 'qr_post_rating_show_admin_columns_for_post_types' ] ) ) {
        $qr_post_rating_show_admin_columns_for_post_types = maybe_unserialize( $options[ 'qr_post_rating_show_admin_columns_for_post_types' ] );
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
        
        foreach( $post_types  as $post_type ) {

            $checked = '';
            if ( is_array($qr_post_rating_show_admin_columns_for_post_types) && in_array( $post_type->name, $qr_post_rating_show_admin_columns_for_post_types ) ) {
                $checked = ' checked';
            }
            
            if ( $post_type->name != 'attachment' ) { // Excluding attachment post types as it unlikely to be used for rating, plus it also doesn't use Admin columns in the same way as other posts
                echo '<li><label style="padding:0 10px 0 8px;display:block;"><input type="checkbox" name="qr_post_rating_settings[qr_post_rating_show_admin_columns_for_post_types][]" value="' . $post_type->name . '"' . $checked . '> <span>' . $post_type->labels->singular_name . '</span></label></li>';
            }

        }

        echo '<ul>';
        
        //echo print_r($qr_post_rating_show_admin_columns_for_post_types);
    }
    
    

}


function qr_post_rating_up_text_render() {
    
    $options = get_option( 'qr_post_rating_settings' );
    
    if ( $options[ 'qr_post_rating_up_text' ] ) {
        $uptext = $options[ 'qr_post_rating_up_text' ];
    } else {
        $uptext = __( 'Up', 'qr_post_rating_plugin' );
    }
    
    echo '<input type="text" name="qr_post_rating_settings[qr_post_rating_up_text]" value="' . $uptext . '">';
    
}


function qr_post_rating_down_text_render() {
    
    $options = get_option( 'qr_post_rating_settings' );
    
    if ( $options[ 'qr_post_rating_down_text' ] ) {
        $downtext = $options[ 'qr_post_rating_down_text' ];
    } else {
        $downtext = __( 'Down', 'qr_post_rating_plugin' );
    }
    
    echo '<input type="text" name="qr_post_rating_settings[qr_post_rating_down_text]" value="' . $downtext . '">';
    
}

function qr_post_rating_button_classes_render() {
    
    $options = get_option( 'qr_post_rating_settings' );
    
    $qr_post_rating_button_classes = $options[ 'qr_post_rating_button_classes' ];
    
    echo '<input type="text" name="qr_post_rating_settings[qr_post_rating_button_classes]" value="' . $qr_post_rating_button_classes . '" style="width:100%;">';
    
}


function qr_post_rating_save_section_callback( $arg ) {
	
    submit_button();
    
    echo '<hr>';
}

function qr_post_rating_settings_donate_section_callback( $arg ) {
	
    echo __( '<p><strong>If you have found this plugin to be useful then please consider a donation. Donations like these help to provide time for <strong><a href="https://qreate.co.uk/about">me</a></strong> to develop plugins like this.</strong></p>', 'qr_post_rating_plugin' );
    echo __( '<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G" class="button button-primary" target="_blank">Donate</a></p>', 'rc_geo_access_plugin' );
    
}


?>