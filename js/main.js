/**
 * Labee Slider - Main JavaScript
 * Modern jQuery implementation for slider functionality
 *
 * @version 2.0.0
 * @since 2.0.0
 */

(function($) {
	'use strict';

	/**
	 * Initialize slider carousel
	 */
	function initSlider() {
		var $slider = $('#main-slider.carousel');

		if ($slider.length) {
			$slider.carousel({
				interval: 8000,
				pause: 'hover'
			});
		}
	}

	/**
	 * Center slider content vertically
	 */
	function centerSliderContent() {
		$('.centered').each(function() {
			var $this = $(this),
				$slider = $('#main-slider'),
				sliderHeight = $slider.height(),
				contentHeight = $this.height();

			if (sliderHeight > 0 && contentHeight > 0) {
				var marginTop = (sliderHeight - contentHeight) / 2;
				$this.css('margin-top', marginTop + 'px');
			}
		});
	}

	/**
	 * Initialize prettyPhoto for image galleries
	 */
	function initPrettyPhoto() {
		if (typeof $.fn.prettyPhoto === 'function') {
			$("a[rel^='prettyPhoto']").prettyPhoto({
				social_tools: false,
				theme: 'pp_default',
				horizontal_padding: 20,
				opacity: 0.8,
				show_title: false,
				allow_resize: true,
				default_width: 500,
				default_height: 344
			});
		}
	}

	/**
	 * Handle window resize events
	 */
	function handleResize() {
		centerSliderContent();
	}

	/**
	 * Initialize all slider functionality
	 */
	function init() {
		initSlider();
		centerSliderContent();
		initPrettyPhoto();

		// Bind resize event with debounce for performance
		var resizeTimer;
		$(window).on('resize', function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(handleResize, 250);
		});
	}

	// Initialize when DOM is ready
	$(document).ready(init);

})(jQuery);