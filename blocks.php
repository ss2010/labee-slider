<?php
/**
 * Gutenberg Block for Labee Slider
 *
 * @package Labee_Slider
 * @since 2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Labee Slider Gutenberg block.
 *
 * @since 2.0.0
 */
function ls_register_slider_block() {
	// Only register if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Register the block.
	register_block_type(
		'labee-slider/slider',
		array(
			'editor_script'   => 'labee-slider-block-editor',
			'editor_style'    => 'labee-slider-block-editor',
			'style'           => 'labee-slider-block',
			'render_callback' => 'ls_render_slider_block',
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
		)
	);
}
add_action( 'init', 'ls_register_slider_block' );

/**
 * Render callback for the Labee Slider block.
 *
 * @param array $attributes Block attributes.
 * @return string Block HTML.
 * @since 2.0.0
 */
function ls_render_slider_block( $attributes ) {
	// Add custom class if provided.
	$class = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// Get the slider HTML.
	$slider_html = ls_get_slider();

	if ( empty( $slider_html ) ) {
		// Return a placeholder if no sliders exist.
		return sprintf(
			'<div class="labee-slider-block-placeholder %s"><p>%s</p><p><a href="%s">%s</a></p></div>',
			esc_attr( $class ),
			esc_html__( 'No sliders found. Create your first slider to get started.', LS_TEXT_DOMAIN ),
			esc_url( admin_url( 'post-new.php?post_type=ls_slider' ) ),
			esc_html__( 'Create Slider', LS_TEXT_DOMAIN )
		);
	}

	// Wrap the slider in a div with custom class.
	return sprintf(
		'<div class="wp-block-labee-slider %s">%s</div>',
		esc_attr( $class ),
		$slider_html
	);
}

/**
 * Enqueue block editor assets.
 *
 * @since 2.0.0
 */
function ls_enqueue_block_editor_assets() {
	// Only load in admin.
	if ( ! is_admin() ) {
		return;
	}

	// Enqueue the block editor script.
	wp_enqueue_script(
		'labee-slider-block-editor',
		LS_PLUGIN_URL . 'js/block-editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
		LS_VERSION,
		true
	);

	// Enqueue the block editor styles.
	wp_enqueue_style(
		'labee-slider-block-editor',
		LS_PLUGIN_URL . 'css/block-editor.css',
		array( 'wp-edit-blocks' ),
		LS_VERSION
	);

	// Localize script for translations.
	wp_set_script_translations( 'labee-slider-block-editor', LS_TEXT_DOMAIN );
}
add_action( 'enqueue_block_editor_assets', 'ls_enqueue_block_editor_assets' );

/**
 * Enqueue block frontend assets.
 *
 * @since 2.0.0
 */
function ls_enqueue_block_assets() {
	// Only load on frontend.
	if ( is_admin() ) {
		return;
	}

	// Enqueue the block frontend styles.
	wp_enqueue_style(
		'labee-slider-block',
		LS_PLUGIN_URL . 'css/block.css',
		array(),
		LS_VERSION
	);
}
add_action( 'enqueue_block_assets', 'ls_enqueue_block_assets' );