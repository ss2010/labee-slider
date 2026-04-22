<?php
/**
 * Plugin Name: Labee Slider
 * Plugin URI: https://github.com/ss2010/labee-slider
 * Description: A responsive slider plugin that integrates with WordPress using custom post types.
 * Author: ASHRAMTECH
 * Author URI: https://example.com
 * Version: 2.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: labee-slider
 * Domain Path: /languages
 *
 * @package Labee_Slider
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'LS_VERSION', '2.0.0' );
define( 'LS_PLUGIN_FILE', __FILE__ );
define( 'LS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'LS_NAME', 'Labee Slider' );
define( 'LS_TEXT_DOMAIN', 'labee-slider' );

// Metaboxes directory constant.
define( 'CUSTOM_METABOXES_DIR', LS_PLUGIN_URL . 'metaboxes' );


/**
 * Enqueue frontend scripts and styles.
 *
 * @since 2.0.0
 */
function ls_enqueue_scripts() {
	// Only load on frontend, not in admin.
	if ( is_admin() ) {
		return;
	}

	// Enqueue Scripts.
	wp_enqueue_script(
		'bootstrap-js',
		LS_PLUGIN_URL . 'js/bootstrap.min.js',
		array( 'jquery' ),
		LS_VERSION,
		true
	);

	wp_enqueue_script(
		'labee-slider-main',
		LS_PLUGIN_URL . 'js/main.js',
		array( 'jquery', 'bootstrap-js' ),
		LS_VERSION,
		true
	);

	wp_enqueue_script(
		'prettyPhoto',
		LS_PLUGIN_URL . 'js/jquery.prettyPhoto.js',
		array( 'jquery' ),
		LS_VERSION,
		true
	);

	// Enqueue Styles.
	wp_enqueue_style(
		'bootstrap-min',
		LS_PLUGIN_URL . 'css/bootstrap.min.css',
		array(),
		LS_VERSION
	);

	wp_enqueue_style(
		'animate',
		LS_PLUGIN_URL . 'css/animate.css',
		array(),
		LS_VERSION
	);

	wp_enqueue_style(
		'prettyPhoto',
		LS_PLUGIN_URL . 'css/prettyPhoto.css',
		array(),
		LS_VERSION
	);

	wp_enqueue_style(
		'fontawesome',
		LS_PLUGIN_URL . 'css/font-awesome.min.css',
		array(),
		LS_VERSION
	);

	wp_enqueue_style(
		'labee-slider-style',
		LS_PLUGIN_URL . 'css/style.css',
		array( 'bootstrap-min' ),
		LS_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'ls_enqueue_scripts' );


// Include metabox functionality.
require_once LS_PLUGIN_DIR . 'metaboxes/meta_box.php';

/**
 * Get post thumbnail URL.
 *
 * @param int $post_id Post ID.
 * @return string|bool Attachment URL or false if not found.
 * @since 2.0.0
 */
function ls_get_thumb_url( $post_id ) {
	$attachment_id = get_post_thumbnail_id( $post_id );
	if ( ! $attachment_id ) {
		return false;
	}
	return wp_get_attachment_url( $attachment_id );
}

/**
 * Extract video ID from YouTube or Vimeo URL.
 *
 * @param string $link Video URL.
 * @return string|bool Video ID or false if unable to extract.
 * @since 2.0.0
 */
function ls_get_video_id( $link ) {
	if ( empty( $link ) ) {
		return false;
	}

	$path = trim( wp_parse_url( $link, PHP_URL_PATH ), '/' );
	$query_string = wp_parse_url( $link, PHP_URL_QUERY );

	if ( ! empty( $query_string ) ) {
		parse_str( $query_string, $output );
		if ( ! empty( $output['v'] ) ) {
			return sanitize_text_field( $output['v'] );
		}
	}

	return sanitize_text_field( $path );
}
 
//Slider Shortcode
/**
 * Get slider HTML output.
 *
 * @return string HTML output of slider.
 * @since 2.0.0
 */
function ls_get_slider() {
	$args = array(
		'post_type'      => 'ls_slider',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'posts_per_page' => -1,
	);
	$sliders = get_posts( $args );
	$total_sliders = count( $sliders );

	if ( $total_sliders < 1 ) {
		return;
	}

	ob_start();
	?>
	<section id="main-slider" style="margin: 0; padding: 0;">
		<div class="carousel slide wet-asphalt">
			<ol class="carousel-indicators">
				<?php for ( $i = 0; $i < $total_sliders; $i++ ) { ?>
					<li data-target="#main-slider" data-slide-to="<?php echo absint( $i ); ?>" class="<?php echo ( 0 === $i ) ? 'active' : ''; ?>"></li>
				<?php } ?>
			</ol>
			<div class="carousel-inner">
				<?php foreach ( $sliders as $key => $slider ) { 
					$full_img = wp_get_attachment_image_src( get_post_thumbnail_id( $slider->ID ), 'full' );

					$slider_position = sanitize_text_field( get_post_meta( $slider->ID, 'slider_position', true ) );
					$boxed = ( 'yes' === sanitize_text_field( get_post_meta( $slider->ID, 'slider_boxed', true ) ) ) ? 'boxed' : '';
					$button_text = sanitize_text_field( get_post_meta( $slider->ID, 'slider_button_text', true ) );
					$has_button = ! empty( $button_text );
					$button_url = esc_url( get_post_meta( $slider->ID, 'slider_button_url', true ) );
					$video_url = esc_url( get_post_meta( $slider->ID, 'slider_video_link', true ) );
					$video_type = sanitize_text_field( get_post_meta( $slider->ID, 'slider_video_type', true ) );
					$bg_image_url = get_post_meta( $slider->ID, 'slider_background_image', true );
					
					$embed_code = '';
					if ( $full_img ) {
						$embed_code = '<img src="' . esc_url( $full_img[0] ) . '" alt="' . esc_attr( $slider->post_title ) . '">';
					} elseif ( ! empty( $video_url ) ) {
						if ( 'youtube' === $video_type ) {
							$video_id = ls_get_video_id( $video_url );
							$embed_code = '<iframe width="640" height="480" src="' . esc_url( 'https://www.youtube.com/embed/' . $video_id . '?rel=0' ) . '" frameborder="0" allowfullscreen></iframe>';
						} elseif ( 'vimeo' === $video_type ) {
							$video_id = ls_get_video_id( $video_url );
							$embed_code = '<iframe src="' . esc_url( 'https://player.vimeo.com/video/' . $video_id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=a22c2f' ) . '" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
						}
					}

					$columns = ! empty( $embed_code );
					$background_image = '';
					
					if ( ! empty( $bg_image_url ) ) {
						$bg_url = wp_get_attachment_url( intval( $bg_image_url ) );
						$background_image = 'background-image: url(' . esc_url( $bg_url ) . ');';
					}
				?>
					<div class="item <?php echo ( 0 === $key ) ? 'active' : ''; ?>" style="<?php echo esc_attr( $background_image ); ?>">
						<div class="container">
							<div class="row">
								<div class="<?php echo ( $columns ) ? 'col-sm-6' : 'col-sm-12'; ?>">
									<div class="carousel-content centered <?php echo esc_attr( $slider_position ); ?>">
										<h2 class="<?php echo esc_attr( $boxed ); ?> animation animated-item-1">
											<?php echo esc_html( $slider->post_title ); ?>
										</h2>
										<p class="<?php echo esc_attr( $boxed ); ?> animation animated-item-2">
											<?php echo wp_kses_post( do_shortcode( $slider->post_content ) ); ?>
										</p>
										<?php if ( $has_button ) { ?>
											<br>
											<a class="btn btn-md animation animated-item-3" href="<?php echo esc_url( $button_url ); ?>">
												<?php echo esc_html( $button_text ); ?>
											</a>
										<?php } ?>
									</div>
								</div>
								<?php if ( $columns ) { ?>
									<div class="col-sm-6 hidden-xs animation animated-item-4">
										<div class="centered" style="margin-top: 129px;">
											<div class="embed-container">
												<?php echo wp_kses_post( $embed_code ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<a class="prev hidden-xs" href="#main-slider" data-slide="prev">
				<i class="icon-angle-left"></i>
			</a>
			<a class="next hidden-xs" href="#main-slider" data-slide="next">
				<i class="icon-angle-right"></i>
			</a>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
 

/**
 * Insert slider shortcode for use in editor.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Shortcode content.
 * @return string HTML output of slider.
 * @since 2.0.0
 */
function ls_insert_slider( $atts, $content = null ) {
	return ls_get_slider();
}
add_shortcode( 'ls_slider', 'ls_insert_slider' );

/**
 * Template tag for use in themes.
 *
 * @since 2.0.0
 */
function ls_slider() {
	echo ls_get_slider(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

 // Post type: Sliders.
/**
 * Register custom post type for sliders.
 *
 * @since 2.0.0
 */
function ls_register_post_type() {
	$labels = array(
		'name'               => esc_html__( 'Sliders', LS_TEXT_DOMAIN ),
		'singular_name'      => esc_html__( 'Slider', LS_TEXT_DOMAIN ),
		'menu_name'          => esc_html__( 'Sliders', LS_TEXT_DOMAIN ),
		'all_items'          => esc_html__( 'All Sliders', LS_TEXT_DOMAIN ),
		'add_new'            => esc_html__( 'Add New', LS_TEXT_DOMAIN ),
		'add_new_item'       => esc_html__( 'Add New Slider', LS_TEXT_DOMAIN ),
		'edit_item'          => esc_html__( 'Edit Slider', LS_TEXT_DOMAIN ),
		'new_item'           => esc_html__( 'New Slider', LS_TEXT_DOMAIN ),
		'view_item'          => esc_html__( 'View Slider', LS_TEXT_DOMAIN ),
		'search_items'       => esc_html__( 'Search Sliders', LS_TEXT_DOMAIN ),
		'not_found'          => esc_html__( 'No sliders found', LS_TEXT_DOMAIN ),
		'not_found_in_trash' => esc_html__( 'No sliders found in Trash', LS_TEXT_DOMAIN ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'menu_icon'           => LS_PLUGIN_URL . 'images/icon-slider.png',
		'rewrite'             => array( 'slug' => 'slider' ),
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'page-attributes', 'editor', 'thumbnail' ),
		'taxonomies'          => array(),
	);

	register_post_type( 'ls_slider', $args );
}
add_action( 'init', 'ls_register_post_type' );


// Slider metabox fields configuration.
$prefix = 'slider_';
$fields = array(
	array(
		'label' => esc_html__( 'Background Image', LS_TEXT_DOMAIN ),
		'desc'  => esc_html__( 'Show background image in slider', LS_TEXT_DOMAIN ),
		'id'    => $prefix . 'background_image',
		'type'  => 'image',
	),
	array(
		'label' => esc_html__( 'Button Text', LS_TEXT_DOMAIN ),
		'desc'  => esc_html__( 'Show Slider Button and Button Text', LS_TEXT_DOMAIN ),
		'id'    => $prefix . 'button_text',
		'type'  => 'text',
	),
	array(
		'label' => esc_html__( 'Button URL', LS_TEXT_DOMAIN ),
		'desc'  => esc_html__( 'Slider URL link.', LS_TEXT_DOMAIN ),
		'id'    => $prefix . 'button_url',
		'type'  => 'text',
	),
	array(
		'label'   => esc_html__( 'Boxed Style', LS_TEXT_DOMAIN ),
		'desc'    => esc_html__( 'Show boxed style.', LS_TEXT_DOMAIN ),
		'id'      => $prefix . 'boxed',
		'type'    => 'select',
		'options' => array(
			array(
				'value' => 'no',
				'label' => esc_html__( 'No', LS_TEXT_DOMAIN ),
			),
			array(
				'value' => 'yes',
				'label' => esc_html__( 'Yes', LS_TEXT_DOMAIN ),
			),
		),
	),
	array(
		'label'   => esc_html__( 'Position', LS_TEXT_DOMAIN ),
		'desc'    => esc_html__( 'Show slider position.', LS_TEXT_DOMAIN ),
		'id'      => $prefix . 'position',
		'type'    => 'select',
		'options' => array(
			array(
				'value' => 'left',
				'label' => esc_html__( 'Left', LS_TEXT_DOMAIN ),
			),
			array(
				'value' => 'center',
				'label' => esc_html__( 'Center', LS_TEXT_DOMAIN ),
			),
			array(
				'value' => 'right',
				'label' => esc_html__( 'Right', LS_TEXT_DOMAIN ),
			),
		),
	),
);

$fields_video = array(
	array(
		'label'   => esc_html__( 'Video Type', LS_TEXT_DOMAIN ),
		'desc'    => esc_html__( 'Select video type.', LS_TEXT_DOMAIN ),
		'id'      => $prefix . 'video_type',
		'type'    => 'radio',
		'options' => array(
			array(
				'value' => '',
				'label' => esc_html__( 'None', LS_TEXT_DOMAIN ),
			),
			array(
				'value' => 'youtube',
				'label' => esc_html__( 'Youtube', LS_TEXT_DOMAIN ),
			),
			array(
				'value' => 'vimeo',
				'label' => esc_html__( 'Vimeo', LS_TEXT_DOMAIN ),
			),
		),
	),
	array(
		'label' => esc_html__( 'Video Link', LS_TEXT_DOMAIN ),
		'desc'  => esc_html__( 'Video link', LS_TEXT_DOMAIN ),
		'id'    => $prefix . 'video_link',
		'type'  => 'text',
	),
);

// Initialize metaboxes.
new Custom_Add_Meta_Box(
	'ls_slider_box',
	esc_html__( 'Slider Settings', LS_TEXT_DOMAIN ),
	$fields,
	'ls_slider',
	true
);
new Custom_Add_Meta_Box(
	'ls_slider_box_video',
	esc_html__( 'Video Settings', LS_TEXT_DOMAIN ),
	$fields_video,
	'ls_slider',
	true
);

<?php
// End of Labee Slider Plugin
