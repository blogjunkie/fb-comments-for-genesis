<?php
/*
Plugin Name: Facebook Comments for Genesis
Plugin URI: http://clickwp.com/
Description: An optimized method to replace the default WordPress comments with Facebook comments. You must be using the Genesis Framework to use this plugin.
Version: 0.1.1
Author: ClickWP
Author URI: http://clickwp.com
License: GPLv2 
*/


/**
 * Activation Hook
 *
 * Confirm site is using Genesis
 *
 * @since 0.1
 */
function activation_hook() {
	if ( 'genesis' != basename( TEMPLATEPATH ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( sprintf( __( 'Sorry, this plugin only works with <a href="%s">Genesis themes</a>', 'fb-comments-for-genesis'), 'http://clickwp.com/go/genesis' ) );
	}
}

/**
 * Init
 *
 * Register all our functions to the appropriate hook
 *
 * @since 0.1
 */
add_action( 'init', 'click_fbcomments_init' );
function click_fbcomments_init() {

	if ( !is_singular() )
		return;

	// Translations
	// load_plugin_textdomain( 'fb-comments-for-genesis', false, basename( dirname( __FILE__ ) ) . '/languages' );
	
	// Setup Facebook JS SDK
	add_action( 'wp_head', 'click_fbcomments_jssdk_setup' ); 

	// Remove comments & related functions
	remove_action( 'genesis_comments', 'genesis_do_comments' );
	remove_action( 'genesis_pings', 'genesis_do_pings' );
	remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );
	remove_shortcode( 'post_comments' );
	
	// Add Facebook comments
	add_action( 'genesis_comment_form', 'click_do_fbcomments' );
	
	// Replace [post_comments] shortcode with Facebook-aware one
	add_shortcode( 'post_comments', 'click_post_fbcomments_shortcode' );
	
}


/** Register defaults */
add_filter( 'genesis_theme_settings_defaults', 'click_fbcomments_defaults' );
function click_fbcomments_defaults( $defaults ) {

	$defaults['fb_app_id'] = '';
	$defaults['fb_app_secret'] = '';
	$defaults['fb_app_namespace'] = '';
	$defaults['fb_comments_width'] = '400';
	$defaults['fb_comments_replytitle'] = 'Speak Your Mind';
	$defaults['fb_comments_colorscheme'] = 'light';
	$defaults['fb_comments_numposts'] = '5';
	$defaults['fb_comments_mobile'] = 'auto-detect';
	
	return $defaults;
}

/** Sanitize options */
add_action( 'genesis_settings_sanitizer_init', 'click_register_fbcomments_sanitization_filters' );
function click_register_fbcomments_sanitization_filters() {
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD,
		array(
			'fb_app_id',
			'fb_app_secret',
			'fb_app_namespace',
			'fb_comments_width',
			'fb_comments_colorscheme',
			'fb_comments_numposts',
			'fb_comments_mobile',
		) );
	genesis_add_option_filter( 'safe_html', GENESIS_SETTINGS_FIELD,
		array(
			'fb_comments_replytitle',
		) );
}

/** Register Metabox */
add_action('genesis_theme_settings_metaboxes', 'click_register_fbcomments_settings_box' );
function click_register_fbcomments_settings_box( $_genesis_theme_settings_pagehook ) {
	add_meta_box('facebook_settings', __( 'Facebook Comments Settings', 'fb-comments-for-genesis' ), 'click_fbcomments_metabox_fb_settings', $_genesis_theme_settings_pagehook, 'main', '');
}

/** Create Settings Metabox */
function click_fbcomments_metabox_fb_settings() {

	$fb_options = get_option('fb_options');
	if ( array_key_exists( 'comments', $fb_options ) && array_key_exists( 'enabled', $fb_options['comments'] ) && $fb_options['comments']['enabled'] ) {
		// display warning message
		echo 'Please disable Comments in the <a href="' . admin_url('admin.php?page=facebook-settings') . '">Facebook plugin settings</a>';
	} else {
	?>
		
	<p>Get your App ID at <a href="https://developers.facebook.com/apps">https://developers.facebook.com/apps</a>. <strong>If you already have a Facebook app for this website, it's important that you use the same information below</strong>.</p>
	
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
				<label for="genesis-settings[fb_app_id]"><?php echo __( 'Facebook App ID', 'fb-comments-for-genesis' ); ?></label>
			</th>
			<td>
				<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_app_id]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_app_id]" value="<?php echo esc_attr( genesis_get_option('fb_app_id') ); ?>" size="" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="genesis-settings[fb_comments_width]">Comments form width</label>
			</th>
			<td>
				<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_width]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_width]" value="<?php echo esc_attr( genesis_get_option('fb_comments_width') ); ?>" size="2" /> px
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="genesis-settings[fb_comments_width]">Comments form title</label>
			</th>
			<td>
				<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_replytitle]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_replytitle]" value="<?php echo esc_attr( genesis_get_option('fb_comments_replytitle') ); ?>" size="" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="">Color scheme</label>
			</th>
			<td>
				<label><input name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_colorscheme]" type="radio" value="light" <?php if ( genesis_get_option('fb_comments_colorscheme') == 'light' ) echo 'checked="checked"'; ?> /> Light</label> &nbsp; 
				<label><input name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_colorscheme]" type="radio" value="dark" <?php if ( genesis_get_option('fb_comments_colorscheme') == 'dark' ) echo 'checked="checked"'; ?> /> Dark</label>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="genesis-settings[fb_comments_numposts]">Number of comments to display</label>
			</th>
			<td>
				<input name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_numposts]" type="number" step="1" min="1" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_numposts]" value="<?php echo esc_attr( genesis_get_option('fb_comments_numposts') ); ?>" class="small-text" /> <span class="description">(Refers to top-level comments)</span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_mobile]">Enable mobile comments</label>
			</th>
			<td>
				<label><input name="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_mobile]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[fb_comments_mobile]" type="checkbox" value="false" <?php if ( genesis_get_option('fb_comments_mobile') == 'auto-detect' ) echo 'checked="checked"'; ?> /> Yes I have a responsive theme</label>
			</td>
		</tr>
	</table>
	<?php
	}
}
		


/**
 * Inits the Facebook JavaScript SDK.
 *
 * @since 0.1
 */
// add_action( 'wp_head', 'click_fbcomments_jssdk_setup' ); 
function click_fbcomments_jssdk_setup() {

	if ( function_exists( 'fb_js_sdk_setup' ) )
		return;

	if ( !genesis_get_option('fb_app_id') )
		return;

	$args = array(
		'appId' => genesis_get_option('fb_app_id'),
		'channelUrl' => plugins_url( 'channel.php' , __FILE__ ),
		'status' => true,
		'cookie' => true,
		'xfbml' => true,
		'oauth' => true
	);

	echo '<script type="text/javascript">window.fbAsyncInit=function(){FB.init(' . json_encode( $args ) . ');';
	do_action( 'fb_async_init', $args );
	echo '}</script>';

	/*
	$locale = fb_get_locale();
	if ( ! $locale )
		return;
	*/
	wp_enqueue_script( 'fb-connect', ( is_ssl() ? 'https' : 'http' ) . '://connect.facebook.net/en_US/all.js', array(), null, true );

	add_action( 'wp_footer', 'click_fbcomments_root' );
}


/**
 * Adds a root element for the Facebook JavaScript SDK
 *
 * @since 0.1
 */
function click_fbcomments_root() {
	echo '<div id="fb-root"></div>';
}


/**
 * Replaces default Genesis comments and related functions with Facebook comments
 * 
 * @since 0.1
 */
function click_do_fbcomments() {
	
	global $post, $wp_query;

	/** Bail if comments are off for this post type */
	if ( ( is_page() && ! genesis_get_option( 'comments_pages' ) ) || ( is_single() && ! genesis_get_option( 'comments_posts' ) ) )
		return;
	
	if ( 'open' == $post->comment_status ) {
		?>
		<div id="respond" class="fb-comments-for-genesis">
			<a name="comments"></a>
			<?php
			$fb_comments_mobile = ( genesis_get_option('fb_comments_mobile') == 'auto-detect' ) ? '' : 'mobile="false"';
			echo '<h3 id="reply-title">' . genesis_get_option('fb_comments_replytitle') . '</h3>';
			printf( '<div class="fb-comments" data-href="%1$s" data-width="%2$s" data-num-posts="%3$s" colorscheme="%4$s" %5$s></div>',
				esc_url( get_permalink() ),
				genesis_get_option('fb_comments_width'),
				genesis_get_option('fb_comments_numposts'),
				genesis_get_option('fb_comments_colorscheme'),
				$fb_comments_mobile
			);
			?>
		</div>
		<?php
	}

}


/** 
 * Replaces default post_comments shortcode with a Facebook aware version 
 *
 * @since 0.1
 */
add_shortcode( 'post_comments', 'click_post_fbcomments_shortcode' );
function click_post_fbcomments_shortcode( $atts ) {
	
	$defaults = array(
		'after'       => '',
		'before'      => '',
		'hide_if_off' => 'enabled',
	//  'more'        => __( '% Comments', 'genesis' ),
	//  'one'         => __( '1 Comment', 'genesis' ),
	//  'zero'        => __( 'Leave a Comment', 'genesis' ),
	);
	$atts = shortcode_atts( $defaults, $atts );

	if ( ( ! genesis_get_option( 'comments_posts' ) || ! comments_open() ) && 'enabled' === $atts['hide_if_off'] )
		return;

	$comments = sprintf( '<a href="%1$s#comments"><fb:comments-count href="%1$s"></fb:comments-count> Comments</a>', get_permalink() );

	$output = sprintf( '<span class="post-comments">%2$s%1$s%3$s</span>', $comments, $atts['before'], $atts['after'] );

	return apply_filters( 'genesis_post_comments_shortcode', $output, $atts );

}
