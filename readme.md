# Facebook Comments for Genesis #
Contributors: blogjunkie
Donate link: http://clickwp.com/support-clickwp/
Tags: genesis, genesiswp, facebook, comments
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 0.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An better way to to integrate Facebook comments on Genesis child themes. Requires the <a href="http://clickwp.com/go/genesis">Genesis Framework</a>.

## Description ##

The way that the official Facebook plugin integrates comments into WordPress sucks, especially on Genesis. The comments are rendered in the wrong place and the WordPress comments form is simply hidden with CSS - not removed.

The Facebook Comments for Genesis plugin provides an optimized integration of Facebook Comments into themes using the Genesis theme framework. It uses the built-in Genesis hooks to really remove the comment form.

**Features**

* Renders Facebook Comments in the correct position in Genesis (at the `genesis_comment_form()` hook).
* Allows you to specify the width and color scheme of the rendered Facebook Comments.
* Works with responsive Genesis child themes.

**Known issues**

* Unfortunately the `[post_comments]` shortcode will only display the number of top level Facebook comments. Apparently replies to the top level comments are not counted.


**Important**

This plugin requires you to setup a Facebook App for your site. Please review the Installation and FAQ pages.


This is my first ever plugin and the code is likely terrible. Feel free to school me but please [explain like I'm five](http://www.reddit.com/r/explainlikeimfive/). Feature suggestions and bug reports are welcome at [http://clickwp.com/contact/](http://clickwp.com/contact/). 

ClickWP provides [professional WordPress support](http://clickwp.com/wordpress-support/) for bloggers and small businesses. Come join us on Facebook ([www.facebook.com/ClickWP](http://www.facebook.com/ClickWP)) or follow us on Twitter ([@ClickWP](http://twitter.com/clickwp)).


## Installation ##

1. Make sure you are using a [Genesis Framework theme](http://clickwp.com/go/genesis)

2. Install the plugin either via the WordPress.org plugin directory, or by uploading the files to your server (in the `/wp-content/plugins/` directory).

3. Activate the plugin. A new settings metabox will appear in the Genesis Settings page (WordPress admin → Genesis → Theme Settings). Enter your Facebook App ID and other settings. If you haven't yet, [create a Facebook app here](https://developers.facebook.com/apps).


### Tips ###

If you are using it with the [official Facebook plugin](http://wordpress.org/extend/plugins/facebook/), you must deactivate the Comments in the plugins Main Settings (WordPress admin → Facebook → Main Settings). 

Make use of a  plugin like WordPress SEO by Yoast to include the necessary `fb:admins` or `fb:app_id` meta tags. This will allow you to set moderators for your site's comments. 

Also note that the official Facebook plugin adds Open Graph tags to your content, so you disable other plugins or theme options that add Open Graph metadata to your site. In the WordPress SEO plugin to add Open Graph metadata, you can disable this under the WordPress admin → SEO → Social.



## Screenshots ##

1. New settings metabox for the plugin (in the Genesis Theme Settings page)

2. Facebook Comments replaces native WordPress comments



## Frequently Asked Questions ##

**Does this plugin sync Facebook and WordPress comments?**

No, sorry.



## Changelog ##

= 0.1.1 =
* Added conditional to only load comments if is_singular returns true

= 0.1 =
* Initial release