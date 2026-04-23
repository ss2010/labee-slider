/**
 * Labee Slider - Media Upload JavaScript
 * Modern WordPress media uploader implementation
 *
 * @version 2.0.0
 * @since 2.0.0
 */

(function($) {
	'use strict';

	/**
	 * Initialize media uploader for a specific button
	 *
	 * @param {string} buttonSelector - CSS selector for the upload button
	 * @param {string} imageSelector - CSS selector for the image preview
	 * @param {string} urlSelector - CSS selector for the URL input field
	 * @param {string} idSelector - CSS selector for the ID input field
	 */
	function initMediaUploader(buttonSelector, imageSelector, urlSelector, idSelector) {
		$(buttonSelector).on('click', function(e) {
			e.preventDefault();

			var $button = $(this),
				$image = $(imageSelector),
				$url = $(urlSelector),
				$id = $(idSelector);

			// If the media frame already exists, reopen it
			if (typeof wp.media !== 'undefined') {
				var custom_uploader = wp.media({
					title: labee_slider_media.title || 'Select Image',
					button: {
						text: labee_slider_media.button_text || 'Use this image'
					},
					multiple: false
				});

				custom_uploader.on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();

					// Update image preview
					if ($image.length) {
						$image.attr('src', attachment.url).show();
					}

					// Update URL field
					if ($url.length) {
						$url.val(attachment.url);
					}

					// Update ID field
					if ($id.length) {
						$id.val(attachment.id);
					}
				});

				custom_uploader.open();
			} else {
				alert('WordPress media uploader is not available.');
			}
		});
	}

	/**
	 * Initialize all media uploaders
	 */
	function init() {
		// Initialize primary media uploader
		initMediaUploader(
			'.custom_media_upload',
			'.custom_media_image',
			'.custom_media_url',
			'.custom_media_id'
		);

		// Initialize secondary media uploader
		initMediaUploader(
			'.custom_media_upload2',
			'.custom_media_image2',
			'.custom_media_url2',
			'.custom_media_id2'
		);
	}

	// Initialize when DOM is ready
	$(document).ready(init);

})(jQuery);