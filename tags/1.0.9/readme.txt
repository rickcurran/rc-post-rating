=== RC Post Rating ===
Contributors: rickcurran
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G
Tags: post rating, rate page, rate post, user-feedback, votes
Requires at least: 4.6
Tested up to: 6.6
Stable tag: 1.0.9
Requires PHP: 7.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


This plugin adds the ability for users to provide feedback on pages / posts via up / down rating (up/downvoting) buttons.

== Description ==

This plugin adds a pair of buttons that provide the ability for visitors to your website to give feedback on page / post / custom post type content by up / down rating. The Up/down rating statistics can be viewed on the respective post lists in the WordPress admin and also via a table of statistics in a Dashboard widget, these statistics can be exported in a CSV format file.


== Example usage: ==

Enable the plugin and access the "RC Post Rating" page in the Settings menu in your WordPress Admin to configure the required settings. The settings screen allows you to enable/disable the Dashboard widget, admin columns for the various post types on your site, set the global default Up / Downvote button text and also global default CSS classes for the buttons.

There are two methods that can be used to add the buttons to your site, a shortcode and a block for the modern block editor. Note that the simplest way to use it is to set the global attributes in the settings page then add the shortcode or block to the page / post / cpt content, the global defaults will automatically be brought in to the rendered code from each of these blocks. Note however that the shortcode (unlike the block version at this time) does provide a way to override these defaults, so if alternatve Up / Down text was needed for a specific page then these can be set per page if needed. The shortcode attributes are as follows:

- `id` - defaults to the ID of the page that the shortcode is on, so this doesn't need to be specifically set in the shortcode so normally you would omit this attribute
- `classes` - defaults to the global values from the plugin settings page, or empty if these haven't been set
- `uptext` - defaults to the global values from the plugin settings page, or 'Up' if these haven't been set
- `downtext` - defaults to the global values from the plugin settings page, or 'Down' if these haven't been set

The most basic shortcode format is:

`[rc_post_rating]`

To override the default classes and button text you would use:

`[rc_post_rating classes="my-buttons" uptext="Yes" downtext="No"]`

This will use the default settings from the plugin's admin page.

== Screenshots ==

1. This screenshot shows the administration page for the "RC Post Rating" plugin in the WordPress backend
2. This screenshot shows "Add post Rating" block in the block inserter with the block added to the page content
3. This screenshot shows the shortcode method of adding the Post ratings buttons to page content which allows setting custom attributes
4. This screenshot shows the Post ratings buttons in a web page in their default unclicked state
5. This screenshot shows the Post ratings buttons in a web page in their clicked / activated state

== Installation ==
	
1. Upload the plugin package to the plugins directory of your site, or search for "RC Post Rating" in the WordPress plugins directory from the Plugins section of your WordPress dashboard.
2. Once uploaded or installed you must activate the plugin from the Plugins section of your WordPress dashboard.
3. Go to the "RC Post Rating" page in the Settings menu in your WordPress Admin to configure your plugin.
	
== Frequently Asked Questions ==
	
= What does this plugin do? =

This plugin adds a pair of buttons that provide the ability for visitors to your website to give feedback on page / post / custom post type content by up / down rating. The Up/down rating statistics can be view on the respective post lists in the WordPress admin and also via a table of statistics in a Dashboard widget, these statistics can be exported in a CSV format file.

= How do I configure the plugin settings? =

You can configure all of the plugin settings from the "RC Post Rating" menu found in the "Settings" menu in your WordPress admin.

= Can I use this in the block editor? =

Yes, this plugin adds a new block called "Add Post Rating Block" in the 'Widgets' category of the block inserter. Note that using shortcode provides the ability to override the default settings, currently this is not possible with the block, however, it is possible to use the "Shortcode" block in the editor and add the buttons using the shortcode method instead.

= Can I add this to my theme? =

Yes, you can add this to your theme by using the shortcode, you can use the following PHP code in the appropriate file(s) within your site's theme:

`<?php echo do_shortcode( '[rc_post_rating]' ); ?>`

= Can I change the wording on the buttons? =

Yes, you can set the default button text on the plugin settings page, use the "RC Post Rating" menu found in the "Settings" menu in your WordPress admin. If using the shortcode method of adding the buttons to your site you can also override these defaults with shortcode attributes.

= Can I change the type of element used for the buttons? =

Yes, but only when using the shortcode. By default the buttons render using `a` links, whilst this works it is not always the best for accessibility to instead there is an option to use `button` elements instead. To do this add the `type` parameter to the shortcode as follows:

`[rc_post_rating type="button"]`

For compatibility reasons for existing sites using this plugin the use of `type="button"` has been added as an optional parameter rather than changing the default button markup. 

= How do I style the buttons? Can I customise the CSS? =

This plugin doesn't add any CSS styles so you will need to either add some CSS styles to the theme of your site or use the "Additional CSS" function in the WordPress admin to add some CSS styles.

The HTML markup for the buttons has a containing DIV element with a class of `post-rating-tool`, inside this div are two elements that function as clickable buttons, one for up-rating with a class `rating-up` and one for down-rating with a class `rating-down`. When a user clicks on one of the button links it will add an additional class of `active` to that button and a class of `disabled` to the other button (note that these states persist for the user via a local storage setting in their browser which prevents them from rating a page more than once). Note that as per the previous FAQ item "Can I change the type of element used for the buttons?" it is possible to change the element used for these buttons.

Here is an example of the default generated HTML markup:

`<div class="post-rating-tool" data-post-rating-id="123">
    <a href="#yes" class="rating-up active">Yes</a>
    <a href="#no" class="rating-up disabled">No</a>
</div>`

Here is an example of the generated HTML markup with the `type="button"` parameter added to the shortcode:

`<div class="post-rating-tool" data-post-rating-id="123">
    <button class="rating-up active">Yes</button>
    <button class="rating-up disabled">No</button>
</div>`

Here is some example CSS to provide styling for the basic states of the buttons, note that these include styles for both the use of `a` or `button` elements:

`.post-rating-tool a, .post-rating-tool button {
	border-radius: 6px;
	background-color: #bbb;
	color: #000;
	padding: 10px;
	margin-left: 5px;
	margin-right: 5px;
	box-shadow: 0 2px 3px rgba(0,0,0,0.2);
}

.post-rating-tool a:hover, .post-rating-tool button:hover {
	background-color: #ddd;
	color: #000;
	box-shadow: 0 2px 3px rgba(0,0,0,0.3);
}

.post-rating-tool a.active, .post-rating-tool a.active:hover, .post-rating-tool button.active, .post-rating-tool button.active:hover {
	background-color: #000;
	color: #fff;
}

.post-rating-tool a.disabled, .post-rating-tool a.disabled:hover, .post-rating-tool button.disabled, .post-rating-tool button.disabled:hover {
	background-color: #ddd;
	color: #ccc;
	cursor: not-allowed;
	box-shadow: 0 2px 3px rgba(0,0,0,0.2);
}`

= How can I tell if it is working? Troubleshooting tips =

If the plugin has been installed and activated and you have added rating buttons via either a shortcode or a block to a page on your site or to a template in your theme then you should see the buttons on the content. Click one of the Up / Down buttons and it should save that rating to that content. If you check that content in the WordPress admin you should be able to see "Upvotes" and "Downvotes" columns in the Page / Post listing screen, look for the page / post you clicked the rating button on and you should see a numeric value in either of those columns. You should also be able to see a Dashboard widghet with a statistics table if you have enabled this in the plugin settings.

If you think you have this all set up but the buttons don't seem to be working then it's possible something else may be clashing with their functionality. The buttons when clicked submit the rating via WordPress's REST API, if you have somehow disabled the REST API then this will prevent the ratings from working, if this isn't something you have knowingly disabled then it's possible that security plugins such as Wordfence that provide web application firewall type protection may also be blocking it from working. Please check any security software to see if it may be mistakenly blocking it, usually there will be some kind of method to whitelist certain actions within security plugins.


== Changelog ==

= 1.0.9 =

- Added some fields which can be used to aid accessibility of the rating widget. There is an `ARIA Labelledby value` field which can be used to associate the rating widget with an HTML element. There are two `additional assistive text` fields can be used to add text which is only `visible` to screen-reader users, these will add span elements with a class of `show-for-sr` to the default `a` anchor button type or will add an `aria-label` with a combination of the regular label and the additional assistive text label to the `button` type, note that you will need to add appropriate CSS styles to render these as hidden to visual users but accessible by screen-reader users.

= 1.0.8 =

- Fixed an issue with version numbering of JS and CSS files which was causing some rendering issues after updating to 1.0.7
- Updated Readme to provide more details about using the new `type="button"` parameter in the shortcode.

= 1.0.7 =

- Added an optional `type` parameter to the shortcode to render vote buttons as actual HTML `button` elements instead of the default `a` elements, using `button` elements can be an improvement to accessibility.
- Fixed an error that occurred when using PHP8.1 which caused the plugin settings screen to not display.
- Fixed some other PHP8.1 compatibility issues

= 1.0.6 =

- Fixed an issue where only votes for Pages and Posts but not custom post type were being displayed in the Dashboard widget.

= 1.0.5 =

- Various changes / improvements to code to meet requirements for submission to WordPress.org plugin directory. Updated function prefixes, increased escaping of output and change of text-domain to match plugin slug.

= 1.0.4 =

- Initial plugin build.