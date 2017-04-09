<?php
// Creating the widget 
class wpb_widget_followers extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'blogpost-directory-followers', 

			// Widget name will appear in UI
			__('BlogPost - Followers', 'functionality-for-blogpostlite-theme'), 

			// Widget description
			array( 'description' => __( 'Just a simple widget that displays social icons with follower count.', 'functionality-for-blogpostlite-theme' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		global $post, $wpdb, $wp_query;
		$maintitle      = $instance['maintitle'];
		$facebook_username = $instance['facebook_username'];
		$twitter_username = $instance['twitter_username'];
		$googleplus_username = $instance['googleplus_username'];
		$pinterest_username = $instance['pinterest_username'];
		$googleplus_api = $instance['googleplus_api'];
		$thePostID      = $wp_query->post->ID;

		// before and after widget arguments are defined by themes

		echo $args['before_widget'];
		
		if ( !empty($maintitle) ) {
			echo '<div class="item-title-bg">';
				echo '<h4>' . esc_html( $maintitle ) . '</h4>';
			echo '</div>';
		}

		if ( $facebook_username != '' ) {
			$FBFollow = file_get_contents('http://api.facebook.com/method/fql.query?format=json&query=select+fan_count+from+page+where+page_id%3D'.$facebook_username.'');
			$data = json_decode($FBFollow);

			echo '
			<div class="follow-me-facebook">
				<a href="https://facebook.com/'.esc_attr($facebook_username).'" class="social-icon icon-facebook" target="_blank"></a>
				<span class="follower-count">'.$data['0']->fan_count.'</span><span class="follower-text">'.__('followers', 'functionality-for-blogpostlite-theme').'</span>
			</div>';


		}

		if ( $twitter_username != '' ) {
			require_once(VH_HOME . '/twitterOauth/twitteroauth.php');
			$consumer_key = get_theme_mod( 'blogpost_twitter_consumer_key', '' );
			$consumer_secret = get_theme_mod( 'blogpost_twitter_consumer_secret', '' );
			$user_token = get_theme_mod( 'blogpost_twitter_user_token', '' );
			$user_secret = get_theme_mod( 'blogpost_twitter_user_secret', '' );
			$username = $twitter_username; //Your twitter screen name or page name
			$connection = new TwitterOAuth($consumer_key, $consumer_secret, $user_token, $user_secret);
			$followers = $connection->get('https://api.twitter.com/1.1/users/show.json?screen_name='.$username);

			echo '
			<div class="follow-me-twitter">
				<a href="https://twitter.com/'.esc_attr($twitter_username).'" class="social-icon icon-twitter-1" target="_blank"></a>
				<span class="follower-count">'.$followers->followers_count.'</span><span class="follower-text">'.__('followers', 'functionality-for-blogpostlite-theme').'</span>
			</div>';
		}

		if ( $googleplus_username != '' && $googleplus_api != '' ) {
			$google = 'https://www.googleapis.com/plus/v1/people/' . $googleplus_username . '?key=' . $googleplus_api;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $google);
			$json_data = curl_exec($ch);
			curl_close($ch);
			$data =  json_decode($json_data);

			echo '
			<div class="follow-me-googleplus">
				<a href="https://plus.google.com/'.$googleplus_username.'" class="social-icon icon-gplus" target="_blank"></a>
				<span class="follower-count">'.$data->plusOneCount.'</span><span class="follower-text">'.__('followers', 'functionality-for-blogpostlite-theme').'</span>
			</div>';
		}

		if ( $pinterest_username != '' ) {
			$metas = get_meta_tags('http://pinterest.com/'.$pinterest_username.'/');

			echo '
			<div class="follow-me-pinterest">
				<a href="https://pinterest.com/'.$pinterest_username.'" class="social-icon icon-pinterest" target="_blank"></a>
				<span class="follower-count">'.$metas['pinterestapp:followers'].'</span><span class="follower-text">'.__('followers', 'functionality-for-blogpostlite-theme').'</span>
			</div>';
		}

	
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {

		if ( isset( $instance[ 'maintitle' ] ) ) {
			$maintitle = $instance[ 'maintitle' ];
		} else {
			$maintitle = '';
		}

		if ( isset( $instance[ 'pinterest_username' ] ) ) {
			$pinterest_username = $instance[ 'pinterest_username' ];
		} else {
			$pinterest_username = '';
		}

		if ( isset( $instance[ 'facebook_username' ] ) ) {
			$facebook_username = $instance[ 'facebook_username' ];
		} else {
			$facebook_username = '';
		}

		if ( isset( $instance[ 'twitter_username' ] ) ) {
			$twitter_username = $instance[ 'twitter_username' ];
		} else {
			$twitter_username = '';
		}

		if ( isset( $instance[ 'googleplus_username' ] ) ) {
			$googleplus_username = $instance[ 'googleplus_username' ];
		} else {
			$googleplus_username = '';
		}

		if ( isset( $instance[ 'googleplus_api' ] ) ) {
			$googleplus_api = $instance[ 'googleplus_api' ];
		} else {
			$googleplus_api = '';
		}

		// Widget admin form
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'maintitle' ) ); ?>"><?php _e( 'Widget title:', 'functionality-for-blogpostlite-theme' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'maintitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'maintitle' ) ); ?>" type="text" value="<?php echo esc_attr( $maintitle ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook_username' ) ); ?>"><?php _e( 'Facebook username:', 'functionality-for-blogpostlite-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook_username' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook_username ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_username' ) ); ?>"><?php _e( 'Twitter username:', 'functionality-for-blogpostlite-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_username' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_username ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus_username' ) ); ?>"><?php _e( 'Google+ username:', 'functionality-for-blogpostlite-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'googleplus_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus_username' ) ); ?>" type="text" value="<?php echo esc_attr( $googleplus_username ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus_api' ) ); ?>"><?php _e( 'Google+ API key:', 'functionality-for-blogpostlite-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'googleplus_api' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus_api' ) ); ?>" type="text" value="<?php echo esc_attr( $googleplus_api ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pinterest_username' ) ); ?>"><?php _e( 'Pinterest username:', 'functionality-for-blogpostlite-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest_username' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest_username ); ?>" />
		</p>

		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['maintitle'] = ( ! empty( $new_instance['maintitle'] ) ) ? strip_tags( $new_instance['maintitle'] ) : '';
		$instance['pinterest_username'] = ( ! empty( $new_instance['pinterest_username'] ) ) ? strip_tags( $new_instance['pinterest_username'] ) : '';
		$instance['facebook_username'] = ( ! empty( $new_instance['facebook_username'] ) ) ? strip_tags( $new_instance['facebook_username'] ) : '';
		$instance['twitter_username'] = ( ! empty( $new_instance['twitter_username'] ) ) ? strip_tags( $new_instance['twitter_username'] ) : '';
		$instance['googleplus_username'] = ( ! empty( $new_instance['googleplus_username'] ) ) ? $new_instance['googleplus_username'] : '';
		$instance['googleplus_api'] = ( ! empty( $new_instance['googleplus_api'] ) ) ? strip_tags( $new_instance['googleplus_api'] ) : '';

		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
add_action( 'widgets_init', create_function( '', 'register_widget( "wpb_widget_followers" );' ) );