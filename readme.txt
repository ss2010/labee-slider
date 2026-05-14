=== Labee Slider ===
Contributors: ss_2010, ashramtech
Tags: slider, carousel, bootstrap, responsive-slider, custom-post-type
Donate link: https://example.com
Requires at least: 5.0
Requires PHP: 7.4
Tested up to: 6.4
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A responsive and SEO-optimized WordPress slider plugin using custom post types with modern coding standards and Gutenberg block support.

== Description ==

Labee Slider is a lightweight, responsive slider plugin for WordPress. Create SEO-optimized responsive slides with support for:

* Background images
* Custom button text and URLs
* YouTube and Vimeo video embeds
* Boxed and positioned text layouts
* Automatic carousel controllers
* Bootstrap-powered responsive design
* **NEW:** Gutenberg Block Editor support

The plugin uses WordPress custom post types and metaboxes for easy slider management from the WordPress admin dashboard.

**Gutenberg Block Usage:**
In the WordPress Block Editor, simply add the "Labee Slider" block to display your sliders. The block will automatically show all published sliders.

== Installation ==

1. Upload the `labee-slider` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to 'Sliders' in the WordPress admin menu
4. Click 'Add New' to create your first slider

== Usage ==

**In WordPress Block Editor (Gutenberg):**
1. Open any post or page in the Block Editor
2. Click the "+" button to add a new block
3. Search for "Labee Slider" or browse the "Media" category
4. Add the Labee Slider block to your content
5. The block will automatically display all published sliders

**In WordPress Classic Editor:**
Use the shortcode `[ls_slider]` to display the slider

**In Theme Templates:**
Add the following PHP code to your template:
```php
<?php
if ( function_exists( 'ls_slider' ) ) {
    ls_slider();
}
?>
```

== Frequently Asked Questions ==

= How do I add a new slider? =
Go to WP Admin Dashboard > Sliders > Add New. The slider supports:
- Title
- Content/Description (with shortcode support)
- Featured Image (thumbnail)
- Custom metaboxes for slider-specific settings

= Can I use multiple sliders on the same page? =
Currently, the plugin displays all sliders in a single carousel. For multiple independent sliders, you can modify the shortcode or add custom template code.

= What video platforms are supported? =
The plugin supports YouTube and Vimeo videos. You can select the video type and paste the video URL.

= Is the plugin responsive? =
Yes! Labee Slider uses Bootstrap CSS framework for full responsive design across all devices.

== Changelog ==

= 2.0.0 =
* Complete code refactor for modern WordPress standards
* Added text domain support for i18n/translation
* Improved security with proper nonce verification and sanitization
* Better escaping of all output
* Updated to use plugin_dir_url() instead of deprecated WP_PLUGIN_URL
* Improved code documentation and comments
* Fixed deprecated function usage
* Better error handling and validation
* **NEW:** Added Gutenberg Block Editor support
* **NEW:** Proper CSS and JS asset enqueuing
* Requires PHP 7.4+ and WordPress 5.0+

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.0.0 =
This major release includes significant code improvements and security enhancements. Please backup your site before upgrading. All existing sliders should continue to work normally.

== Screenshots ==

1. Slider admin dashboard interface
2. Slider settings metabox
3. Video settings metabox
4. Frontend responsive slider display

== Support ==

For issues, questions, or feature requests, please visit the plugin repository on GitHub.

== Credits ==

* Original Developer: ASHRAMTECH
* Modern Updates: Code Maintenance Team
* Built with Bootstrap and jQuery 
