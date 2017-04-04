<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cohhe.com
 * @since             1.0
 * @package           blogpost_func
 *
 * @wordpress-plugin
 * Plugin Name:       Functionality for Blogpost Lite theme
 * Plugin URI:        http://cohhe.com/
 * Description:       This plugin contains Blogpost Lite theme core functionality
 * Version:           1.3.1
 * Author:            Cohhe
 * Author URI:        https://cohhe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       functionality-for-blogpostlite-theme
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-blogpostlite-functionality-activator.php
 */
function blogpost_activate_blogpost_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blogpostlite-functionality-activator.php';
	blogpost_func_Activator::blogpost_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-blogpostlite-functionality-deactivator.php
 */
function blogpost_deactivate_blogpost_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blogpostlite-functionality-deactivator.php';
	blogpost_func_Deactivator::blogpost_deactivate();
}

register_activation_hook( __FILE__, 'blogpost_activate_blogpost_func' );
register_deactivation_hook( __FILE__, 'blogpost_deactivate_blogpost_func' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
define('BLOGPOSTLITE_PLUGIN', plugin_dir_path( __FILE__ ));
require plugin_dir_path( __FILE__ ) . 'includes/class-blogpostlite-functionality.php';

// Widgets
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/followers-widget.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/contactform.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/googlemap.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/social_links.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/advertisement.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/recent-posts-plus.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/recent-comments.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/sidebar-comments.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/fast-flickr-widget.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/about-us.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/widgets/twitter/twitter.php';

// 
require_once plugin_dir_path( __FILE__ ) . 'includes/Tax-meta-class/Tax-meta-class.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/sidebars/multiple_sidebars.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_blogpost_func() {

	$plugin = new blogpost_func();
	$plugin->blogpost_run();

}
run_blogpost_func();


function blogpost_customizer_register_func( $wp_customize ) {
	// Add twitter widget setting panel and configure settings inside it
	$wp_customize->add_panel( 'blogpost_twitter_settings_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Twitter widget settings' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'You can configure your themes twitter widget settings here.' , 'functionality-for-blogpostlite-theme')
	) );

	// Login Screen Logo
	$wp_customize->add_section( 'blogpost_general_login_logo', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Login Screen Logo' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Upload a custom logo.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_general_panel'
	) );

	$wp_customize->add_setting( 'blogpost_login_logo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'blogpost_login_logo', array(
		'label'    => __( 'Login Screen Logo', 'functionality-for-blogpostlite-theme' ),
		'section'  => 'blogpost_general_login_logo',
		'settings' => 'blogpost_login_logo',
	) ) );

	// Consumer key
	$wp_customize->add_section( 'blogpost_twt_consumer_key', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Consumer key' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Please enter your Twitter API consumer key.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_twitter_settings_panel'
	) );

	$wp_customize->add_setting( 'blogpost_twitter_consumer_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_twitter_consumer_key',
		array(
			'label'      => __( 'Consumer key', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_twt_consumer_key',
			'type'       => 'text',
		)
	);

	// Consumer secret
	$wp_customize->add_section( 'blogpost_twt_consumer_secret', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Consumer secret' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Please enter your Twitter API consumer secret.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_twitter_settings_panel'
	) );

	$wp_customize->add_setting( 'blogpost_twitter_consumer_secret', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_twitter_consumer_secret',
		array(
			'label'      => __( 'Consumer secret', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_twt_consumer_secret',
			'type'       => 'text',
		)
	);

	// User token
	$wp_customize->add_section( 'blogpost_twt_user_token', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'User token' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Please enter your Twitter API User token.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_twitter_settings_panel'
	) );

	$wp_customize->add_setting( 'blogpost_twitter_user_token', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_twitter_user_token',
		array(
			'label'      => __( 'User token', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_twt_user_token',
			'type'       => 'text',
		)
	);

	// User secret
	$wp_customize->add_section( 'blogpost_twt_user_secret', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'User secret' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Please enter your Twitter API User secret.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_twitter_settings_panel'
	) );

	$wp_customize->add_setting( 'blogpost_twitter_user_secret', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_twitter_user_secret',
		array(
			'label'      => __( 'User secret', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_twt_user_secret',
			'type'       => 'text',
		)
	);

	// Custom JavaScript
	$wp_customize->add_section( 'blogpost_general_js', array(
		'priority'       => 80,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Custom JavaScript' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Copy your custom JavaScript code here. You have to add any needed html tags yourself.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_general_panel'
	) );

	$wp_customize->add_setting( 'blogpost_custom_js', array( 'default' => '', 'sanitize_callback' => 'blogpost_sanitize_textarea_field' ) );

	$wp_customize->add_control(
		'blogpost_custom_js',
		array(
			'label'      => __( 'Custom JavaScript', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_general_js',
			'type'       => 'textarea',
		)
	);

	// Custom CSS
	$wp_customize->add_section( 'blogpost_general_css', array(
		'priority'       => 90,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Custom CSS' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Copy your custom CSS code here. Use plain CSS without any html tags.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_general_panel'
	) );

	$wp_customize->add_setting( 'blogpost_custom_css', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_custom_css',
		array(
			'label'      => __( 'Custom CSS', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_general_css',
			'type'       => 'textarea',
		)
	);

	// Add Header setting panel and configure settings inside it
	$wp_customize->add_panel( 'blogpost_social_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Side-menu settings' , 'blogpost-lite'),
		'description'    => __( 'You can configure your theme side-menu settings here.' , 'blogpost-lite')
	) );

	// Header twitter
	$wp_customize->add_section( 'blogpost_social_twitter', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Twitter URL' , 'blogpost-lite'),
		'description'    => __( 'Twitter URL for your menu social icon.' , 'blogpost-lite'),
		'panel'          => 'blogpost_social_panel'
	) );

	$wp_customize->add_setting( 'blogpost_socialtwitter', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_socialtwitter',
		array(
			'label'      => 'Twitter URL',
			'section'    => 'blogpost_social_twitter',
			'type'       => 'text',
		)
	);

	// Header facebook
	$wp_customize->add_section( 'blogpost_social_facebook', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Facebook URL' , 'blogpost-lite'),
		'description'    => __( 'Facebook URL for your menu social icon.' , 'blogpost-lite'),
		'panel'          => 'blogpost_social_panel'
	) );

	$wp_customize->add_setting( 'blogpost_socialfacebook', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_socialfacebook',
		array(
			'label'      => 'Facebook URL',
			'section'    => 'blogpost_social_facebook',
			'type'       => 'text',
		)
	);

	// Header google plus
	$wp_customize->add_section( 'blogpost_social_gplus', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Google+ URL' , 'blogpost-lite'),
		'description'    => __( 'Google+ URL for your menu social icon.' , 'blogpost-lite'),
		'panel'          => 'blogpost_social_panel'
	) );

	$wp_customize->add_setting( 'blogpost_socialgplus', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_socialgplus',
		array(
			'label'      => 'Google+ URL',
			'section'    => 'blogpost_social_gplus',
			'type'       => 'text',
		)
	);

	// Header pinterest
	$wp_customize->add_section( 'blogpost_social_pinterest', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Pinterest URL' , 'blogpost-lite'),
		'description'    => __( 'Pinterest URL for your menu social icon.' , 'blogpost-lite'),
		'panel'          => 'blogpost_social_panel'
	) );

	$wp_customize->add_setting( 'blogpost_socialpinterest', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_socialpinterest',
		array(
			'label'      => 'Pinterest URL',
			'section'    => 'blogpost_social_pinterest',
			'type'       => 'text',
		)
	);

	// Header instagram
	$wp_customize->add_section( 'blogpost_social_instagram', array(
		'priority'       => 50,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Instagram URL' , 'blogpost-lite'),
		'description'    => __( 'Instagram URL for your menu social icon.' , 'blogpost-lite'),
		'panel'          => 'blogpost_social_panel'
	) );

	$wp_customize->add_setting( 'blogpost_socialinstagram', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_socialinstagram',
		array(
			'label'      => 'Instagram URL',
			'section'    => 'blogpost_social_instagram',
			'type'       => 'text',
		)
	);

	// Header vkontakte
	$wp_customize->add_section( 'blogpost_social_vkontakte', array(
		'priority'       => 60,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'VKontakte URL' , 'blogpost-lite'),
		'description'    => __( 'VKontakte URL for your menu social icon.' , 'blogpost-lite'),
		'panel'          => 'blogpost_social_panel'
	) );

	$wp_customize->add_setting( 'blogpost_socialvkontakte', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_socialvkontakte',
		array(
			'label'      => 'VKontakte URL',
			'section'    => 'blogpost_social_vkontakte',
			'type'       => 'text',
		)
	);

	// Google maps
	$wp_customize->add_section( 'blogpost_google_maps', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Google maps key' , 'functionality-for-blogpostlite-theme'),
		'description'    => __( 'Please enter your Google maps API key for your contact us map.' , 'functionality-for-blogpostlite-theme'),
		'panel'          => 'blogpost_general_panel'
	) );

	$wp_customize->add_setting( 'blogpost_gmap_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'blogpost_gmap_key',
		array(
			'label'      => __( 'Google maps key', 'functionality-for-blogpostlite-theme'),
			'section'    => 'blogpost_google_maps',
			'type'       => 'text',
		)
	);
}
add_action( 'customize_register', 'blogpost_customizer_register_func' );

function blogspot_add_metabox() {

	add_meta_box(
		'post_format_metabox',                                   						  // Unique ID
		esc_html__( 'Advanced post format fields', 'functionality-for-blogpostlite-theme' ),  // Title
		'blogpost_post_format_function',                          								  // Callback function
		'post',                                           								  // Admin page (or post type)
		'normal',                                          								  // Context
		'high'                                             								  // Priority
	);

}

add_action( 'load-post.php', 'blogspot_metabox_setup' );
add_action( 'load-post-new.php', 'blogspot_metabox_setup' );
function blogspot_metabox_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'blogspot_add_metabox' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'blogpost_post_format_save_metabox', 10, 2 );
}

function blogpost_post_format_save_metabox( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['post_format_nonce'] ) || !wp_verify_nonce( $_POST['post_format_nonce'], basename( __FILE__ ) ) )
	return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	return $post_id;

	$custom_metabox = array('post_embed_code', 'post_twitter_username', 'post_twitter_link', 'post_ad_button_text', 'post_ad_button_url', 'post_ad_background');

	foreach ($custom_metabox as $metabox_value) {
		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value  = ( isset( $_POST[$metabox_value] ) ?  $_POST[$metabox_value]  : '' );

		/* Get the meta key. */
		$meta_key  = $metabox_value;

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}

}

function blogpost_post_format_function( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'post_format_nonce' ); ?>

	<p class="post-type-a">
		<label for="post_embed_code"><?php _e( "Post embed code", 'functionality-for-blogpostlite-theme' ); ?></label>
		<br />
		<input class="widefat" type="text" name="post_embed_code" id="post_embed_code" value="<?php echo esc_attr( get_post_meta( $object->ID, 'post_embed_code', true ) ); ?>" size="30" />
	</p>

	<p class="post-type-status">
		<label for="post_twitter_username"><?php _e( "Post twitter username", 'functionality-for-blogpostlite-theme' ); ?></label>
		<br />
		<input class="widefat" type="text" name="post_twitter_username" id="post_twitter_username" value="<?php echo esc_attr( get_post_meta( $object->ID, 'post_twitter_username', true ) ); ?>" size="30" />
	</p>

	<p class="post-type-status">
		<label for="post_twitter_link"><?php _e( "Used tweet link, like https://twitter.com/Cohhe_Themes/status/577814278192959488", 'functionality-for-blogpostlite-theme' ); ?></label>
		<br />
		<input class="widefat" type="text" name="post_twitter_link" id="post_twitter_link" value="<?php echo esc_attr( get_post_meta( $object->ID, 'post_twitter_link', true ) ); ?>" size="30" />
	</p>

	<p class="post-type-quote">
		<label for="post_ad_button_text"><?php _e( "Add your custom button text", 'functionality-for-blogpostlite-theme' ); ?></label>
		<br />
		<input class="widefat" type="text" name="post_ad_button_text" id="post_ad_button_text" value="<?php echo esc_attr( get_post_meta( $object->ID, 'post_ad_button_text', true ) ); ?>" size="30" />
	</p>

	<p class="post-type-quote">
		<label for="post_ad_button_url"><?php _e( "External button URL", 'functionality-for-blogpostlite-theme' ); ?></label>
		<br />
		<input class="widefat" type="text" name="post_ad_button_url" id="post_ad_button_url" value="<?php echo esc_attr( get_post_meta( $object->ID, 'post_ad_button_url', true ) ); ?>" size="30" />
	</p>

	<p class="post-type-quote">
		<label for="post_ad_background"><?php _e( "Media ID for a picture background", 'functionality-for-blogpostlite-theme' ); ?></label>
		<br />
		<input class="widefat" type="text" name="post_ad_background" id="post_ad_background" value="<?php echo esc_attr( get_post_meta( $object->ID, 'post_ad_background', true ) ); ?>" size="30" />
	</p>

<?php }

function blogspot_setup() {
	/*
	* configure taxonomy custom fields
	*/
	$config = array(
		'id' => 'category_custom_meta_box',
		'title' => 'Category Custom Meta Box',
		'pages' => array('category'),
		'context' => 'normal',
		'fields' => array(),
		'local_images' => false,
		'use_with_theme' => true
	);

	$custom_meta = new Tax_Meta_Class($config);

	//Image field
	$custom_meta->addImage('image_field_id',array('name'=> 'Category Image '));

	//Finish Taxonomy Extra fields Deceleration
	$custom_meta->Finish();
}
add_action('after_setup_theme', 'blogspot_setup');

function blogpost_display_social_icons() {
	$output = '';
	$icon_count = 1;
	$menu_header_twitter_url   = get_theme_mod( 'blogpost_socialtwitter', '' );
	$menu_header_facebook_url  = get_theme_mod( 'blogpost_socialfacebook', '' );
	$menu_header_google_url    = get_theme_mod( 'blogpost_socialgplus', '' );
	$menu_header_pinterest_url = get_theme_mod( 'blogpost_socialpinterest', '' );

	if ( !empty($menu_header_twitter_url) ) {
		$output .= '<a href="' . esc_url( $menu_header_twitter_url ) . '" class="header-social-icon icon-count-' . $icon_count . ' icon-twitter-1"></a>';
		$icon_count++;
	}

	if ( !empty($menu_header_facebook_url) ) {
		$output .= '<a href="' . esc_url( $menu_header_facebook_url ) . '" class="header-social-icon icon-count-' . $icon_count . ' icon-facebook"></a>';
		$icon_count++;
	}

	if ( !empty($menu_header_google_url) ) {
		$output .= '<a href="' . esc_url( $menu_header_google_url ) . '" class="header-social-icon icon-count-' . $icon_count . ' icon-gplus"></a>';
		$icon_count++;
	}

	if ( !empty($menu_header_pinterest_url) ) {
		$output .= '<a href="' . esc_url( $menu_header_pinterest_url ) . '" class="header-social-icon icon-count-' . $icon_count . ' icon-pinterest"></a>';
		$icon_count++;
	}

	return $output;
}

function get_tweet_buttons( $postid, $follow = true ) {
	$output = '';
	if ( get_post_meta( $postid, 'post_twitter_link', true ) != '' ) {
		$twitter_link = esc_url( get_post_meta( $postid, 'post_twitter_link', true ) );
		$twitter_link_arr = explode('/', $twitter_link);
		$output = '';

		if ( $follow ) {
			$output .= '
			<div class="twitter-follow-button">
				<a href="https://twitter.com/intent/user?screen_name='.esc_attr( $twitter_link_arr['3'] ).'" target="_blank" class="twitter-follow">'.__('Follow', 'functionality-for-blogpostlite-theme').'</a>
			</div>';
		}

		$output .= '
		<div class="twitter-buttons">
			<a href="https://twitter.com/intent/tweet?in_reply_to='.esc_attr( $twitter_link_arr['5'] ).'" target="_blank" class="twitter-button icon-reply">'.__('reply', 'functionality-for-blogpostlite-theme').'</a>
			<a href="https://twitter.com/intent/retweet?tweet_id='.esc_attr( $twitter_link_arr['5'] ).'" target="_blank" class="twitter-button icon-retweet">'.__('retweet', 'functionality-for-blogpostlite-theme').'</a>
			<a href="https://twitter.com/intent/favorite?tweet_id='.esc_attr( $twitter_link_arr['5'] ).'" target="_blank" class="twitter-button icon-star">'.__('favorite', 'functionality-for-blogpostlite-theme').'</a>
		</div>';
	}
	echo $output;
}

function get_twitter_link( $postid ) {
	if ( get_post_meta( $postid, 'post_twitter_username', true ) != '' ) {
		$twitter_user = esc_html( get_post_meta( $postid, 'post_twitter_username', true ) );
		$user_link = 'https://twitter.com/'.str_replace('@', '', $twitter_user);
		echo '<a href="' . esc_url( $user_link ) . '" class="twitter-link">' . $twitter_user . '</a>';
	}
}

function get_embed_code( $postid ) {
	if ( get_post_meta( $postid, 'post_embed_code', true ) != '' ) {
		echo wp_kses( 
				get_post_meta( $postid, 'post_embed_code', true ), 
				array(
					'iframe' => array(
						'width' => array(),
						'height' => array(),
						'src' => array(),
						'frameborder' => array()
					)
				)
			);
	}
}

function get_ad_background( $postid ) {
	if ( get_post_meta( $postid, 'post_ad_background', true ) != '' ) {
		$ad_background_id = get_post_meta( $postid, 'post_ad_background', true );
		$ad_background = wp_get_attachment_image_src( $ad_background_id, 'blogpost-post-gallery-medium' );
		return 'style="background: url(' . esc_url( $ad_background['0'] ) . ') no-repeat;"';
	} else {
		return '';
	}
}

function get_ad_button_text( $postid ) {
	if ( get_post_meta( $postid, 'post_ad_button_text', true ) != '' ) {
		return get_post_meta( $postid, 'post_ad_button_text', true );
	} else {
		return __('Open ad', 'functionality-for-blogpostlite-theme');
	}
}

function get_ad_button_url( $postid ) {
	if ( get_post_meta( $postid, 'post_ad_button_url', true ) != '' ) {
		return get_post_meta( $postid, 'post_ad_button_url', true );
	} else {
		return get_permalink( $postid );
	}
}

add_filter('widget_text', 'do_shortcode');

function blogpost_sanitize_textarea_field( $input ) {
	return esc_js( $input );
}

if (file_exists( plugin_dir_path( __FILE__ ) . 'includes/featured-images/featured-images.php')) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/featured-images/featured-images.php');

	if( class_exists( 'vhFeaturedImages' ) ) {
		$i = 1;
		$posts_slideshow = ( get_option('blogpost_posts_slideshow_number') ) ? get_option('blogpost_posts_slideshow_number') : 5;

		while($i <= $posts_slideshow) {
			$args = array(
				'id'        => 'gallery-image-'.$i,
				'post_type' => 'post', // Set this to post or page
				'labels'    => array(
					'name'   => 'Gallery image '.$i,
					'set'    => 'Set gallery image '.$i,
					'remove' => 'Remove gallery image '.$i,
					'use'    => 'Use as gallery image '.$i,
				)
			);

			new vhFeaturedImages( $args );

			$i++;
		}
	}
}


// Label
function blogpost_gap($atts, $content = null, $code) {
	extract( shortcode_atts( array(
		'height' => 10,
	), $atts ) );

	$output = '<div class="gap" style="line-height: ' . absint($height) . 'px; height: ' . absint($height) . 'px;"></div>';

	return $output;
}
add_shortcode('vh_gap', 'blogpost_gap');

// Blockquote
function blogpost_blockquote($atts, $content = null, $code) {
	extract( shortcode_atts( array(
		'quote' => '',
		'quote_author' => '',
		'quote_width' => '',
		'quote_align' => '',
		'quote_background' => ''
	), $atts ) );

	$extra_style = '';

	if ( $quote_width != '' && $quote_width != 'auto' ) {
		$extra_style .= 'width:'.$quote_width.';';
	}

	if ( $quote_align == 'left' ) {
		$extra_style .= 'float: left;';
	} elseif ( $quote_align == 'center' ) {
		$extra_style .= 'float: none; width: 100%;';
	} elseif ( $quote_align == 'right' ) {
		$extra_style .= 'float: right;';
	}

	if ( $quote_background != '' ) {
		$bg_img = wp_get_attachment_image_src($quote_background, 'full');
		$bg_url = $bg_img['0'];
		$extra_style .= 'background: url(\''.$bg_url.'\') no-repeat;';
	}

	$output = '
	<div class="quote-container" style="' . $extra_style . '">
		<span class="quote-symbol icon-quote-left-1"></span>
		<div class="quote-text"><p>' . $quote . '</p></div>
		<span class="quote-author">' . $quote_author . '</span>
	</div>';

	return $output;
}
add_shortcode('vh_blockquote', 'blogpost_blockquote');

// Share icons
function blogpost_share_icons($atts, $content = null, $code) {
	extract( shortcode_atts( array(
		'facebook' => '',
		'twitter' => '',
		'googleplus' => '',
		'pinterest' => '',
		'vkontakte' => ''
	), $atts ) );

	$output = '<div class="social-icon-container">';

		if ( $twitter == '1' ) {
			$output .= '<a href="http://twitter.com/share?url=' . get_permalink() . '&amp;text=' . urlencode( get_the_title() ) . '" class="social-icon icon-twitter-1" target="_blank">' . __( 'Twitter', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}
		
		if ( $facebook == '1' ) {
			$output .= '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '" class="social-icon icon-facebook" target="_blank">' . __( 'Facebook', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

		if ( $googleplus == '1' ) {
			$output .= '<a href="https://plus.google.com/share?url=' . get_permalink() . '" class="social-icon icon-gplus" target="_blank">' . __( 'Google+', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

		if ( $pinterest == '1' ) {
			$output .= "<a href=\"javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());\" class=\"social-icon icon-pinterest\" target=\"_blank\">" . __( 'Pinterest', 'functionality-for-blogpostlite-theme' ) . "</a>";
		}

		if ( $vkontakte == '1' ) {
			$output .= '<a href="http://vk.com/share.php?url=' . get_permalink() . '" class="social-icon icon-vkontakte" target="_blank">' . __( 'VKontakte', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

	$output .= '<div class="clearfix"></div></div>';

	return $output;
}
add_shortcode('vh_share_icons', 'blogpost_share_icons');

// Social icons
function blogpost_social_icons($atts, $content = null, $code) {
	extract( shortcode_atts( array(
		'facebook' => '',
		'twitter' => '',
		'googleplus' => '',
		'instagram' => '',
		'pinterest' => '',
		'vkontakte' => ''
	), $atts ) );

	$output = '<div class="social-icon-container">';

		if ( $twitter != '' ) {
			$output .= '<a href="' . $twitter . '" class="social-icon icon-twitter-1" target="_blank">' . __( 'Twitter', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}
		
		if ( $facebook != '' ) {
			$output .= '<a href="' . $facebook . '" class="social-icon icon-facebook" target="_blank">' . __( 'Facebook', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

		if ( $googleplus != '' ) {
			$output .= '<a href="' . $googleplus . '" class="social-icon icon-gplus" target="_blank">' . __( 'Google+', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

		if ( $instagram != '' ) {
			$output .= '<a href="' . $instagram . '" class="social-icon icon-instagram" target="_blank">' . __( 'Instagram', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

		if ( $pinterest != '' ) {
			$output .= '<a href="' . $pinterest . '" class="social-icon icon-pinterest" target="_blank">' . __( 'Pinterest', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

		if ( $vkontakte != '' ) {
			$output .= '<a href="' . $vkontakte . '" class="social-icon icon-vkontakte" target="_blank">' . __( 'VKontakte', 'functionality-for-blogpostlite-theme' ) . '</a>';
		}

	$output .= '<div class="clearfix"></div></div>';

	return $output;
}
add_shortcode('vh_social_icons', 'blogpost_social_icons');

// Contact us
function blogpost_contact_us($atts, $content = null, $code) {
	extract( shortcode_atts( array(
		'email' => '',
		'phone' => '',
		'address' => false
	), $atts ) );

	$output = '<div class="contact-us-container">';
		if ( $address ) {
			$output .= '
			<div class="contact-us-left">
				<script type="text/javascript">
					var map;
					window.blogpost_contact_map = function() {
						if ( jQuery("#contact-us-map").length ) {
							if (typeof google === "object" && typeof google.maps === "object") {
								start_geolocation();
							}
						};
					}
					window.start_geolocation = function() {
						if (typeof google === "object" && typeof google.maps === "object") {
							var geocoder = new google.maps.Geocoder();
							var address = "' . $address . '";

							geocoder.geocode( { "address": address}, function(results, status) {

								if (status == google.maps.GeocoderStatus.OK) {
									var latitude = results[0].geometry.location.G;
									var longitude = results[0].geometry.location.K;
									initialize(results[0].geometry.location);
								} 
							});
						}
					}
					window.initialize = function(location) {
						var mapCanvas = document.getElementById("contact-us-map");
						var myLatlng = location;
						var mapOptions = {
							center: myLatlng,
							zoom: 13,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							scrollwheel: false,
							navigationControl: false,
							mapTypeControl: false,
							scaleControl: false
						}
						map = new google.maps.Map(mapCanvas, mapOptions);
						var image = "' . get_template_directory_uri() . '/images/marker.png";

						var marker = new google.maps.Marker({
							position: myLatlng,
							map: map,
							icon: image
						});
					}
					jQuery(window).load(function() {
						if ( jQuery("#contact-us-map").length ) {
							blogpost_contact_map();
						}
					});
					jQuery(window).ajaxStop(function() {
						if ( jQuery("#contact-us-map").length ) {
							blogpost_contact_map();
						}
					});
				</script>
				<div id="contact-us-map"></div>
			</div>';
		}

		$output .= '
		<div class="contact-us-right">
			<div class="contact-us-right-inner">
				<a href="mailto:' . $email . '" class="contact-us-email"><i class="icon-paper-plane"></i>' . $email . '</a>
				<span class="contact-us-phone"><i class="icon-mobile"></i>' . $phone . '</span>
				<span class="contact-us-address"><i class="icon-direction"></i>' . $address . '</span>
			</div>
		</div>';

	$output .= '<div class="clearfix"></div></div>';

	return $output;
}
add_shortcode('vh_contact_us', 'blogpost_contact_us');


// Ajax posts
function blogpost_ajax_posts($atts, $content = null, $code) {
	extract( shortcode_atts( array(
		'initial_posts' => 8,
		'next_posts' => 4,
		'post_categories' => '',
		'favorite' => ''
	), $atts ) );

	if ( $favorite != '1' ) {
		query_posts(array(
			'post_type' => 'post',
			'posts_per_page' => $initial_posts,
			'category_name' => $post_categories

		));
	} else {
		$user_favorites = blogpost_get_user_favorites();

		if ( !empty($user_favorites) ) {
			query_posts(array(
				'post_type' => 'post',
				'posts_per_page' => $initial_posts,
				'post__in' => blogpost_get_user_favorites()
			));
		} else {
			return '<p class="align_center">'.__('You haven\'t favorited any articles.', 'functionality-for-blogpostlite-theme').'</p>';
		}

	}


	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	$output = '
	<div class="teaser_grid_container">
		<ul class="wpb_thumbnails-posts module">';

	while(have_posts()) {
		the_post();

		$post_format = get_post_format();
		$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blogpost-post-gallery-medium');
		$excerpt = get_the_excerpt();

		ob_start();

		if ( $post_format != '' ) {
			get_template_part( 'content', get_post_format() );
		} else { ?>
			<li class="isotope-item blog-inner-container standart-format">
				<div  <?php post_class(); ?>>
					<?php if( !empty($img[0]) ) { ?>
						<div class="post-image">
							<a href="<?php the_permalink(); ?>" class="post-image-link"><img src="<?php echo $img[0]; ?>" alt="post-img" class="post-inner-picture"></a>
							<?php if ( get_the_category_list(', ') != '' ) { ?>
								<div class="blog-category <?php echo blogpost_get_random_circle(); ?>">
									<?php echo get_the_category_list(', '); ?>
								</div>
							<?php } ?>
							<?php blogpost_get_favorite_icon(get_the_ID()); ?>
						</div>
					<?php } ?>
					<div class="post-inner entry-content <?php echo get_post_type(); ?>">
						<div class="blog-title">
							<a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php echo get_the_title(); ?></a>
						</div>
						<div class="blog-excerpt">
						<?php
							$post_content = '';
							if( empty($excerpt) ) {
								$post_content = __( 'No excerpt for this posting.', 'functionality-for-blogpostlite-theme' );
							} else {
								echo $excerpt;
							}
						?>
						</div>
						<div class="blog-post-info">
							<div class="blog-comments icon-comment-1">
								<?php
								$tc = wp_count_comments( get_the_ID() );
								echo $tc->approved;
								?>
							</div>
							<?php if( empty($img[0]) ) {
								blogpost_get_favorite_icon(get_the_ID());
							} ?>
							<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="blog-read-more ripple-slow wpb_button wpb_btn-danger wpb_regularsize square"><?php _e('Read', 'functionality-for-blogpostlite-theme'); ?></a>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</li>
		<?php }
		$output .= ob_get_contents();
		ob_end_clean();
	}

	$output .= '
		</ul>
		<input type="hidden" id="ajax-posts-initial" value="' . $initial_posts . '">
		<input type="hidden" id="ajax-posts-next" value="' . $next_posts . '">
		<input type="hidden" id="ajax-posts-categories" value="' . $post_categories . '">
		<input type="hidden" id="ajax-posts-pagination" value="' . $initial_posts . '">
		<input type="hidden" id="ajax-posts-favorite" value="' . $favorite . '">
		<button id="load-more-posts" class="wpb_button  wpb_btn-danger wpb_regularsize square"><span>'.__('Load more', 'functionality-for-blogpostlite-theme').'</span></button>
		<div class="loading-effect"></div>
		<div class="no-more-posts">' . __('No more posts', 'functionality-for-blogpostlite-theme') . '</div>
	</div>';

	wp_reset_query();
	wp_reset_postdata();

	return $output;

}
add_shortcode('vh_ajax_posts', 'blogpost_ajax_posts');

function blogpost_display_menu_social_icons( $class ) {
	$output = '';
	$icon_count = 0;
	$menu_header_twitter_url   = get_theme_mod( 'blogpost_socialtwitter', '' );
	$menu_header_facebook_url  = get_theme_mod( 'blogpost_socialfacebook', '' );
	$menu_header_google_url    = get_theme_mod( 'blogpost_socialgplus', '' );
	$menu_header_pinterest_url = get_theme_mod( 'blogpost_socialpinterest', '' );
	$menu_header_instagram_url = get_theme_mod( 'blogpost_socialinstagram', '' );
	$menu_header_vkontakte_url = get_theme_mod( 'blogpost_socialvkontakte', '' );

	$output .= '
	<div class="' . $class . ' share">
		<button class="share-toggle-button">
			<i class="share-icon icon-share"></i>
		</button>
		<ul class="share-items">';
		if ( !empty($menu_header_twitter_url) ) {
			$output .= '<li class="share-item"><a href="' . esc_url( $menu_header_twitter_url ) . '" class="share-button twitter"><i class="share-icon icon-twitter-1"></i></a></li>';
			$icon_count++;
		}

		if ( !empty($menu_header_facebook_url) ) {

			$output .= '<li class="share-item"><a href="' . esc_url( $menu_header_facebook_url ) . '" class="share-button facebook"><i class="share-icon icon-facebook"></i></a></li>';
			$icon_count++;
		}

		if ( !empty($menu_header_google_url) ) {
			$output .= '<li class="share-item"><a href="' . esc_url( $menu_header_google_url ) . '" class="share-button gplus"><i class="share-icon icon-gplus"></i></a></li>';
			$icon_count++;
		}

		if ( !empty($menu_header_pinterest_url) ) {
			$output .= '<li class="share-item"><a href="' . esc_url( $menu_header_pinterest_url ) . '" class="share-button pinterest"><i class="share-icon icon-pinterest"></i></a></li>';
			$icon_count++;
		}

		if ( !empty($menu_header_instagram_url) ) {
			$output .= '<li class="share-item"><a href="' . esc_url( $menu_header_instagram_url ) . '" class="share-button instagram"><i class="share-icon icon-instagram"></i></a></li>';
			$icon_count++;
		}

		if ( !empty($menu_header_vkontakte_url) ) {
			$output .= '<li class="share-item"><a href="' . esc_url( $menu_header_vkontakte_url ) . '" class="share-button vkontakte"><i class="share-icon icon-vkontakte"></i></a></li>';
			$icon_count++;
		}
		$output .= '</ul>';

	$output .= '
	</div>';

	if ( $icon_count == 0 ) {
		$output = '';
	}

	return $output;
}

function ajax_contact() {
	if(!empty($_POST)) {
		$sitename = get_bloginfo('name');
		$siteurl  = home_url();
		$to       = isset($_POST['contact_to'])? sanitize_email(trim($_POST['contact_to'])) : '';
		$name     = isset($_POST['contact_name'])? sanitize_text_field(trim($_POST['contact_name'])) : '';
		$email    = isset($_POST['contact_email'])? sanitize_email(trim($_POST['contact_email'])) : '';
		$content  = isset($_POST['contact_content'])? sanitize_text_field(trim($_POST['contact_content'])) : '';

		$error = false;
		$error = ($to === '' || $email === '' || $content === '' || $name === '') ||
				 (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)) ||
				 (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $to));

		if($error == false) {
			$subject = "$sitename message from $name";
			$body    = "Site: $sitename ($siteurl) \n\nName: $name \n\nEmail: $email \n\nMessage: $content";
			$headers = "From: $name ($sitename) <$email>\r\nReply-To: $email\r\n";
			$sent    = wp_mail($to, $subject, $body, $headers);

			// If sent
			if ($sent) {
				echo 'sent';
				die();
			} else {
				echo 'error';
				die();
			}
		} else {
			echo _e('Please fill all fields!', 'vh');
			die();
		}
	}
}
add_action('wp_ajax_nopriv_contact_form', 'ajax_contact');
add_action('wp_ajax_contact_form', 'ajax_contact');

add_action( 'wp_ajax_nopriv_ajax_favorite_post', 'blogpost_favorite_article' );
add_action( 'wp_ajax_ajax_favorite_post', 'blogpost_favorite_article' );
function blogpost_favorite_article() {
	$post_id = sanitize_text_field($_POST['fpost_id']);
	$fav_action = sanitize_text_field($_POST['fav_action']);

	$favorite_articles = array();

	if ( isset($_COOKIE['blogpost_favorite_articles']) ) {
		$user_favorites = json_decode(str_replace('\\', '', $_COOKIE['blogpost_favorite_articles']), true);
	} else {
		$user_favorites = array();
	}

	if ( !empty($user_favorites) ) {
		$favorite_articles = $user_favorites;
	}

	if ( $fav_action == 'favorite' && !array_key_exists($post_id, $favorite_articles) ) {
		$favorite_articles[$post_id] = 'favorite';
		setcookie("blogpost_favorite_articles", json_encode($favorite_articles), time() + (10 * 365 * 24 * 60 * 60), '/');
	} else if ( $fav_action == 'unfavorite' && array_key_exists($post_id, $favorite_articles) ) {
		unset($favorite_articles[$post_id]);
		setcookie("blogpost_favorite_articles", json_encode($favorite_articles), time() + (10 * 365 * 24 * 60 * 60), '/');
	}

	echo json_encode($favorite_articles);
	
	die(1);
}

function blogpost_rename_post_formats($translation, $text, $context, $domain) {
	$names = array(
		'Quote'  => 'Ad',
		'Status' => 'Tweet'
	);
	if ($context == 'Post format') {
		$translation = str_replace(array_keys($names), array_values($names), $text);
	}
	return $translation;
}
add_filter('gettext_with_context', 'blogpost_rename_post_formats', 10, 4);