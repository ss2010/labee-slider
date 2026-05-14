/**
 * Labee Slider Gutenberg Block
 *
 * @package Labee_Slider
 * @since 2.0.0
 */

( function( blocks, element, editor, components, i18n ) {
	var el = element.createElement;
	var __ = i18n.__;
	var RichText = editor.RichText;
	var InspectorControls = editor.InspectorControls;
	var PanelBody = components.PanelBody;

	/**
	 * Register the Labee Slider block.
	 */
	blocks.registerBlockType( 'labee-slider/slider', {
		title: __( 'Labee Slider', 'labee-slider' ),
		description: __( 'Display a responsive slider created with Labee Slider.', 'labee-slider' ),
		icon: 'images-alt2',
		category: 'media',
		keywords: [
			__( 'slider', 'labee-slider' ),
			__( 'carousel', 'labee-slider' ),
			__( 'gallery', 'labee-slider' ),
		],

		/**
		 * Block attributes.
		 */
		attributes: {
			className: {
				type: 'string',
			},
		},

		/**
		 * Edit function - what the block looks like in the editor.
		 */
		edit: function( props ) {
			var className = props.attributes.className;

			return [
				// Inspector controls (sidebar)
				el( InspectorControls, { key: 'inspector' },
					el( PanelBody, {
						title: __( 'Slider Settings', 'labee-slider' ),
						initialOpen: true
					},
						el( 'p', {},
							__( 'This block displays all published sliders. Configure individual sliders in the Sliders menu.', 'labee-slider' )
						),
						el( 'p', {},
							el( 'a', {
								href: wp.data.select( 'core/editor' ).getPermalink() ? wp.data.select( 'core/editor' ).getPermalink().replace( 'edit', 'post-new.php?post_type=ls_slider' ) : '/wp-admin/post-new.php?post_type=ls_slider',
								target: '_blank',
								rel: 'noopener noreferrer'
							},
								__( 'Create New Slider', 'labee-slider' )
							)
						)
					)
				),

				// Block content in editor
				el( 'div', {
					className: 'wp-block-labee-slider-editor ' + ( className || '' ),
					style: {
						border: '2px dashed #ccc',
						padding: '20px',
						textAlign: 'center',
						backgroundColor: '#f9f9f9',
						minHeight: '200px',
						display: 'flex',
						flexDirection: 'column',
						justifyContent: 'center',
						alignItems: 'center'
					}
				},
					el( 'div', {
						className: 'slider-icon',
						style: {
							fontSize: '48px',
							color: '#007cba',
							marginBottom: '10px'
						}
					}, '📸' ),
					el( 'h3', {
						style: {
							margin: '0 0 10px 0',
							color: '#333'
						}
					}, __( 'Labee Slider', 'labee-slider' ) ),
					el( 'p', {
						style: {
							margin: '0 0 15px 0',
							color: '#666'
						}
					}, __( 'Responsive slider block', 'labee-slider' ) ),
					el( 'div', {
						className: 'slider-preview-placeholder',
						style: {
							backgroundColor: '#fff',
							border: '1px solid #ddd',
							borderRadius: '4px',
							padding: '15px',
							marginTop: '10px',
							width: '100%',
							maxWidth: '300px'
						}
					},
						el( 'p', {
							style: {
								margin: '0',
								fontStyle: 'italic',
								color: '#999'
							}
						}, __( 'Slider preview will appear here on the frontend', 'labee-slider' ) )
					)
				)
			];
		},

		/**
		 * Save function - what gets saved to the database.
		 */
		save: function( props ) {
			// This block is dynamic, so we return null and use render_callback
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.editor,
	window.wp.components,
	window.wp.i18n
);