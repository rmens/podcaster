<?php 
/**
 * Do NOT edit this file. This file is used to display your galleries and slideshows.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
Gallery Styling*/

add_filter('gallery_style',    create_function(
        '$css',
        'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
		)
    );


/*
Remove default gallery styling*/

 add_filter( 'use_default_gallery_style', '__return_false' );


/*
Gallery Styling*/

add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;
    static $instance = 0;
    $instance++;
	

	/*
	We're trusting author input, so let's at least make sure it looks like a valid orderby statement*/


    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }


    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'li',
        'icontag'    => 'div',
        'captiontag' => 'p',
        'columns'    => 3,
        'size'       => 'regular-large',
        'include'    => '',
        'link'       => 'file',
        'exclude'    => ''
    ), $attr));
    $id = intval($id);


    if ( 'RAND' == $order )
        $orderby = 'none';


    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array(
            'include' => $include, 
            'post_status' => 'inherit', 
            'post_type' => 'attachment', 
            'post_mime_type' => 'image', 
            'order' => $order, 
            'orderby' => $orderby
        ) );
        $attachments = array();

        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }

    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array(
            'post_parent' => $id, 
            'exclude' => $exclude, 
            'post_status' => 'inherit', 
            'post_type' => 'attachment', 
            'post_mime_type' => 'image', 
            'order' => $order, 
            'orderby' => $orderby
        ) );

    } else {
        $attachments = get_children( array(
            'post_parent' => $id, 
            'post_status' => 'inherit', 
            'post_type' => 'attachment', 
            'post_mime_type' => 'image', 
            'order' => $order, 
            'orderby' => $orderby
        ) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";

        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";

        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';
    $selector = "gallery-{$instance}";

    $output = apply_filters('', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }

            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           
			}

            #{$selector} img {
                border: 2px solid #cfcfcf;
            }

            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='gallery loading_post flexslider galleryid-{$id}'><ul class='slides'>");

    $i = 0;

    foreach ( $attachments as $id => $attachment ) {
        //$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
        $link = wp_get_attachment_image($id, $size);
		$image_attributes = wp_get_attachment_image_src( $id );
        $output .= "<{$itemtag} class='gallery-item' data-thumb='{$image_attributes[0]}'>";
        $output .= "<div class='image_cont'>";
        $output .= "$link";
		$output .= "</div>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <div class='flex-caption'><{$captiontag} >

                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}></div>";
        }
        $output .= "</{$itemtag}>";

        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '';
    }

    $output .= "
        </ul></div>\n";
    return $output;
}

 ?>