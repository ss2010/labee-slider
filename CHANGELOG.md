# Labee Slider Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2024-04-23

### Added
- Text domain and domain path support for internationalization (i18n)
- Proper WordPress constants for plugin directories (`LS_PLUGIN_DIR`, `LS_PLUGIN_URL`)
- Comprehensive code documentation with PHPDoc comments
- Output buffering in `ls_get_slider()` for safer template rendering
- Security improvements with input sanitization and output escaping
- Better error handling and validation
- Support for PHP 7.4+

### Changed
- Complete plugin code refactor for modern WordPress coding standards
- Replaced deprecated `WP_PLUGIN_URL` with `plugin_dir_url()`
- Updated `__()` functions to include text domain parameter
- Improved function naming conventions (e.g., `get_video_ID()` → `ls_get_video_id()`)
- Enhanced escaping for all HTML output
- Better variable naming and code organization
- Updated hook names for consistency (e.g., `ls_scripts` → `ls_enqueue_scripts`)
- Improved priority and dependency management for enqueued scripts/styles
- Updated plugin header with proper metadata

### Fixed
- Fixed nonce verification logic in metabox save handler
- Improved capability checks (changed from `edit_page` to `edit_post`)
- Fixed missing sanitization in $_POST data
- Added proper escaping for all echo statements
- Fixed HTML structure in metabox output
- Corrected WordPress function deprecation warnings
- Better handling of video URL extraction with sanitization

### Removed
- Removed unused `ls_the_attached_image()` function
- Removed deprecated function `get_video_ID()` (replaced with `ls_get_video_id()`)
- Removed unused `upload.js` from frontend enqueue

### Security
- Added `wp_unslash()` and `sanitize_text_field()` for POST data
- Improved nonce verification logic
- Added proper escaping functions: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- Enhanced capability checks
- Fixed XSS vulnerabilities in template output

### Requirements
- Requires WordPress 5.0 or higher (previously 3.5)
- Requires PHP 7.4 or higher (previously no minimum version)
- Tested up to WordPress 6.4

### Development
- Added proper file access protection at beginning of all PHP files
- Improved error handling with early exits
- Better function organization within the plugin structure
- Code now follows WordPress Coding Standards (WPCS)

## [1.0.0] - Initial Release

### Features
- Custom post type for sliders
- Bootstrap-based responsive carousel
- Support for background images
- Custom button text and URLs
- YouTube and Vimeo video embeds
- Boxed styling options
- Text positioning (left, center, right)
- Admin metaboxes for slider configuration
- Shortcode support: `[ls_slider]`
- Template tag support: `ls_slider()`

---

## Migration Guide from 1.0 to 2.0

### For Theme/Plugin Developers

1. **Text Domain Changes:**
   - All localization strings now use `LS_TEXT_DOMAIN` constant
   - When translating, use the text domain: `labee-slider`

2. **Function Changes:**
   - `get_video_ID()` has been renamed to `ls_get_video_id()`
   - `ls_get_slider()` now returns HTML (instead of outputting directly)
   - `ls_slider()` template tag continues to output slider as before

3. **Hook Changes:**
   - The main script enqueue hook remains the same: `wp_enqueue_scripts`
   - All functions are properly namespaced with `ls_` prefix

4. **Database:**
   - No database changes - all existing slider posts will continue to work
   - Post meta values remain unchanged

### For WordPress Administrators

- No action required - activate and use as normal
- All existing sliders should work without modification
- Check your site functionality after updating
