# Changelog 

## 1.0.8

- Fixed an issue with version numbering of JS and CSS files which was causing some rendering issues after updating to 1.0.7
- Updated Readme to provide more details about using the new `type="button"` parameter in the shortcode.

## 1.0.7

- Added an optional `type` parameter to the shortcode to render vote buttons as actual HTML `button` elements instead of the default `a` elements, using `button` elements can be an improvement to accessibility.
- Fixed an error that occurred when using PHP8.1 which caused the plugin settings screen to not display.
- Fixed some other PHP8.1 compatibility issues

## 1.0.6

- Fixed an issue where only votes for Pages and Posts but not custom post type were being displayed in the Dashboard widget.

## 1.0.5

- Various changes / improvements to code to meet requirements for submission to WordPress.org plugin directory. Updated function prefixes, increased escaping of output and change of text-domain to match plugin slug.

## 1.0.4

- Initial plugin build.