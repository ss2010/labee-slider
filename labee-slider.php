<?php
/*
Plugin Name: Labee Slider
Plugin URI: 
Description: A simple plugin that integrates Slider with WordPress using custom post types!
Author: ASHRAMTECH
Version: 1.0
Author URI: Your URL
*/
define('LS_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('LS_NAME', "Labee Slider");
define ("LS_VERSION", "1.0");
// metaboxes directory constant
define( 'CUSTOM_METABOXES_DIR', LS_PATH . '/metaboxes' );

// adding scripts
    add_action('wp_enqueue_scripts', 'ls_scripts');

    function ls_scripts() {

    // Javascripts
        wp_enqueue_script('bootstrap-js',   LS_PATH . '/js/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('main-js',        LS_PATH . '/js/main.js');
        wp_enqueue_script('upload-js',      LS_PATH . '/js/upload.js');
        wp_enqueue_script('prettyPhoto',    LS_PATH . '/js/jquery.prettyPhoto.js');
        
        

    // Stylesheet
        wp_enqueue_style('bootstrap-min',   LS_PATH . '/css/bootstrap.min.css');
        wp_enqueue_style('animate',         LS_PATH . '/css/animate.css');
        wp_enqueue_style('prettyPhoto',     LS_PATH . '/css/prettyPhoto.css');
        wp_enqueue_style('fontawesome',     LS_PATH . '/css/font-awesome.min.css');    
        wp_enqueue_style('style',           LS_PATH . '/css/style.css');
   
    }
    
   // Meta boxes
require_once('metaboxes/meta_box.php'); 

/**
 * Getting post thumbnail url
 * @param  [int]                $pots_ID [Post ID]
 * @return [string]             [Return thumbail source url]
 */
function ls_get_thumb_url($pots_ID){
    return wp_get_attachment_url( get_post_thumbnail_id( $pots_ID ) );
}
 
//Slider Shortcode
function ls_get_slider(){ ?>
 <?php $args = array( 'post_type'=>'ls_slider', 'orderby' => 'menu_order','order' => 'ASC' );
$sliders = get_posts( $args );
$total_sliders = count($sliders);?>
<section id="main-slider" style="margin: 0; padding: 0;">
    <div class="carousel slide wet-asphalt">
        <ol class="carousel-indicators">

            <?php for($i = 0; $i<$total_sliders; $i++){ ?>
            <li data-target="#main-slider" data-slide-to="<?php echo $i ?>" class="<?php echo ($i==0)?'active':'' ?>"></li>
            <?php } ?>

        </ol>
        <div class="carousel-inner">
            <?php foreach ($sliders as $key => $slider) { 

                $full_img           =   wp_get_attachment_image_src( get_post_thumbnail_id( $slider->ID ), 'full');

                $slider_position    =   get_post_meta($slider->ID, 'slider_position', true );

                $boxed              =   (get_post_meta($slider->ID, 'slider_boxed', true )=='yes') ? 'boxed' : '';

                $has_button         =   (get_post_meta($slider->ID, 'slider_button_text', true )=='') ? false : true;

                $button             =   get_post_meta($slider->ID, 'slider_button_text', true );

                $button_url         =   get_post_meta($slider->ID, 'slider_button_url', true );

                $video_url          =   get_post_meta($slider->ID, 'slider_video_link', true );

                $video_type         =   get_post_meta($slider->ID, 'slider_video_type', true );

                $bg_image_url       =   get_post_meta($slider->ID, 'slider_background_image', true );

                $background_image   =   'background-image: url('.wp_get_attachment_url($bg_image_url).')';

                $columns            =   false;



                if( !empty($image_url) or !empty($video_url) ){

                    $columns        =   true;
                }


                if( $video_type=='youtube' ) {

                    $embed_code = '<iframe width="640" height="480" src="//www.youtube.com/embed/' . get_video_ID( $video_url ) . '?rel=0" frameborder="0" allowfullscreen></iframe>';

                } elseif( $video_type=='vimeo' ) {
                    $embed_code = '<iframe src="//player.vimeo.com/video/' . get_video_ID( $video_url ) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=a22c2f" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
                }

                if( $full_img ){

                    $embed_code     = '<img src="' . $full_img[0] . '" alt="">';
                    $columns        =   true;
                }


                ?>

                <div class="item <?php echo ($key==0) ? 'active' : '' ?>" style="<?php echo ( $bg_image_url ) ? $background_image : '' ?>">
                    <div class="container">
                        <div class="row">


                            <div class="<?php echo ($columns) ? 'col-sm-6' : 'col-sm-12'  ?>">
                                <div class="carousel-content centered <?php echo $slider_position ?>">
                                    <h2 class="<?php echo $boxed ?> animation animated-item-1">
                                        <?php echo $slider->post_title ?>
                                    </h2>

                                    <p class="<?php echo $boxed ?> animation animated-item-2">
                                        <?php echo do_shortcode( $slider->post_content ) ?>
                                    </p>
                                    
                                    <?php if( $has_button ){ ?>
                                    <br>
                                    <a class="btn btn-md animation animated-item-3" href="<?php echo $button_url ?>"><?php echo $button ?></a>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php if($columns){ ?>

                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="centered" style="margin-top: 129px;">
                                    <div class="embed-container">
                                        <?php echo $embed_code; ?>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>


                        </div>
                    </div>
                </div><!--/.item-->


                <?php } // endforeach ?>

            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="icon-angle-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="icon-angle-right"></i>
        </a>
    </section>

 <?php }
 

/**add the shortcode for the slider- for use in editor**/
 
function ls_insert_slider($atts, $content=null){
 
$slider= ls_get_slider();
 
return $slider;
 
}
 
 
add_shortcode('ls_slider', 'ls_insert_slider');
 
 
 
/**add template tag- for use in themes**/
 
function ls_slider(){
 
    print ls_get_slider();
}

 // Post type: Sliders 
  function ls_register(){

    $labels = array(
        'name'                  => __( 'Slider' ),
        'singular_name'         => __( 'Slider' ),
        'menu_name'             => __( 'Sliders'),
        'all_items'             => __( 'All Sliders'),
        'add_new'               => __( 'Add New'),
        'add_new_item'          => __( 'Add New Slider'),
        'edit_item'             => __( 'Edit Slider'),
        'new_item'              => __( 'New Slider' ),
        'view_item'             => __( 'View Slider'),
        'search_items'          => __( 'Search Portfolios' ),
        'not_found'             => __( 'No item found'),
        'not_found_in_trash'    => __( 'No item found in Trash' )
        );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'menu_icon'             => LS_PATH . '/images/icon-slider.png',
        'rewrite'               => true,
        'capability_type'       => 'post',
        'supports'              => array('title', 'page-attributes', 'editor', 'thumbnail') 
        );
    register_post_type('ls_slider', $args);
    flush_rewrite_rules();
}
add_action('init','ls_register');

    // slider metaboxes

$prefix = 'slider_';
$fields = array(
    array( 
        'label'                     => __('Background Image'),
        'desc'                      => __('Show background image in slider'), 
        'id'                        => $prefix . 'background_image',
        'type'                      => 'image'
        ),



    array( 
        'label'                     => __('Button Text'),
        'desc'                      => __('Show Slider Button and Button Text'), 
        'id'                        => $prefix . 'button_text',
        'type'                      => 'text'
        ),   

    array( 
        'label'                     => __('Button URL'),
        'desc'                      => __('Slider URL link.'), 
        'id'                        => $prefix . 'button_url',
        'type'                      => 'text'
        ),

    array( 
        'label'                     => __('Boxed Style'),
        'desc'                      => __('Show boxed Style.'), 
        'id'                        => $prefix . 'boxed',
        'type'                      => 'select',
        'options'                   => array(

            array(
                'value'=>'no',
                'label'=>__('No')
                ),   

            array(
                'value'=>'yes',
                'label'=>__('Yes')
                )
            )
        ),
    array( 
        'label'                     => __('Position'),
        'desc'                      => __('Show slider Position.'), 
        'id'                        => $prefix . 'position',
        'type'                      => 'select',
        'options'                   => array(

            array(
                'value'=>'left',
                'label'=>__('Left')
                ),   

            array(
                'value'=>'center',
                'label'=>__('Center')
                ),          

            array(
                'value'=>'right',
                'label'=>__('Right')
                ),
            )
        )
    );



$fields_video = array(

    array( 
        'label'                     => __('Video Type'),
        'desc'                      => __('Select video type.'), 
        'id'                        => $prefix . 'video_type',
        'type'                      => 'radio',
        'options'                   => array(

            array(
                'value'=>'',
                'label'=>__('None')
                ),

            array(
                'value'=>'youtube',
                'label'=>__('Youtube')
                ),   

            array(
                'value'=>'vimeo',
                'label'=>__('Vimeo')
                )
            )
        ),

    array( 
        'label'                     => __('Video Link'),
        'desc'                      => __('Video link'), 
        'id'                        => $prefix . 'video_link',
        'type'                      => 'text'
        ), 
    );


new Custom_Add_Meta_Box( 'ls_slider_box', __('Slider Settings'), $fields, 'ls_slider', true );
new Custom_Add_Meta_Box( 'ls_slider_box_video', __('Video Settings'), $fields_video, 'ls_slider', true );

//ls_the_attached_image
function ls_the_attached_image() {
    $post                = get_post();
    $attachment_size     = array( 724, 724 );
    $next_attachment_url = wp_get_attachment_url();

    /**
     * Grab the IDs of all the image attachments in a gallery so we can get the URL
     * of the next adjacent image in a gallery, or the first image (if we're
     * looking at the last image in a gallery), or, in a gallery of one, just the
     * link to that image file.
     */
    $attachment_ids = get_posts( array(
        'post_parent'    => $post->post_parent,
        'fields'         => 'ids',
        'numberposts'    => -1,
        'post_status'    => 'inherit',
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'order'          => 'ASC',
        'orderby'        => 'menu_order ID'
        ) );

    // If there is more than 1 attachment in a gallery...
    if ( count( $attachment_ids ) > 1 ) {
        foreach ( $attachment_ids as $attachment_id ) {
            if ( $attachment_id == $post->ID ) {
                $next_id = current( $attachment_ids );
                break;
            }
        }

        // get the URL of the next image attachment...
        if ( $next_id )
            $next_attachment_url = get_attachment_link( $next_id );

        // or get the URL of the first image attachment.
        else
            $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
    }

    printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
        esc_url( $next_attachment_url ),
        the_title_attribute( array( 'echo' => false ) ),
        wp_get_attachment_image( $post->ID, $attachment_size )
        );
}

function get_video_ID($link){

    if( empty($link) ) return false;

    $path  =  trim(parse_url($link, PHP_URL_PATH), '/');

    $query_string = parse_url($link, PHP_URL_QUERY);

    parse_str($query_string, $output);

    if( empty($output) ){
        return $path;
    } else {
        return $output['v'];
    }
}

?>
