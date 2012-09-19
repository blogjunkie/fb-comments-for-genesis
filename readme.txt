=== Facebook Comments for Genesis ===
Contributors: blogjunkie
Donate link: http://clickwp.com/support-clickwp/
Tags: genesis, genesiswp, facebook, comments
Requires at least: 3.4
Tested up to: 3.4.2
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An better way to to integrate Facebook comments on Genesis child themes. Requires the <a href="http://clickwp.com/go/genesis">Genesis Framework</a>.

== Description ==

The way that the official Facebook plugin integrates comments into WordPress sucks, especially on Genesis. The comments are rendered in the wrong place and the WordPress comments form is simply hidden with CSS - not removed.

The Facebook Comments for Genesis plugin provides an optimized integration of Facebook Comments into themes using the Genesis theme framework. It uses the built-in Genesis hooks to really remove the comment form.

**Features**<br/>
* Renders Facebook Comments in the correct position in Genesis (at the <code>genesis_comment_form()</code> hook).
* Allows you to specify the width and color scheme of the rendered Facebook Comments.
* Works with responsive Genesis child themes.

**Known issues**<br/>
* Unfortunately the [post_comments] shortcode will only display the number of top level Facebook comments. Apparently replies to the top level comments are not counted.


**Important**<br/>
This plugin requires you to setup a Facebook App for your site. Please review the Installation and FAQ pages.


This is my first ever plugin and the code is likely terrible. Feel free to school me but please <a href="http://www.reddit.com/r/explainlikeimfive/">explain like I'm five</a>. Feature suggestions and bug reports are welcome at <a href="http://clickwp.com/contact/">http://clickwp.com/contact/</a>. 

ClickWP provides <a href="http://clickwp.com/wordpress-support/">professional WordPress support</a> for bloggers and small businesses. Come join us on Facebook (<a href="http://www.facebook.com/ClickWP">www.facebook.com/ClickWP</a>) or follow us on Twitter (<a href="http://twitter.com/clickwp">@ClickWP</a>).


== Installation ==

1. Make sure you are using a <a href="http://clickwp.com/go/genesis">Genesis Framework theme</a>

2. Install the plugin either via the WordPress.org plugin directory, or by uploading the files to your server (in the `/wp-content/plugins/` directory).

3. Activate the plugin. A new settings metabox will appear in the Genesis Settings page (WordPress admin → Genesis → Theme Settings). Enter your Facebook App ID and other settings. If you haven't yet, <a href="https://developers.facebook.com/apps">create a Facebook app here</a>.


=== Tips ===

If you are using it with the <a href="http://wordpress.org/extend/plugins/facebook/">official Facebook plugin</a>, you must deactivate the Comments in the plugins Main Settings (WordPress admin → Facebook → Main Settings). 

Make use of a  plugin like WordPress SEO by Yoast to include the necessary `fb:admins` or `fb:app_id` meta tags. This will allow you to set moderators for your site's comments. 

Also note that the official Facebook plugin adds Open Graph tags to your content, so you disable other plugins or theme options that add Open Graph metadata to your site. In the WordPress SEO plugin to add Open Graph metadata, you can disable this under the WordPress admin → SEO → Social.



== Screenshots ==

1. New settings metabox for the plugin (in the Genesis Theme Settings page)

2. Facebook Comments replaces native WordPress comments



== Frequently Asked Questions ==

= Does this plugin sync Facebook and WordPress comments? =

No, sorry.



== Changelog ==

= 0.1 =
* Initial release