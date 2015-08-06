<?php
/**
 * This file contains functions to register custom post type
 */

function create_facebook_post_type() {
  $labels = array(
    'name'               => _x( 'Facebook Post', 'post type general name' ),
    'singular_name'      => _x( 'Facebook Post', 'post type singular name' ),
    'all_items'          => __( 'All Facebook Posts' ),
    'view_item'          => __( 'View Facebook Post' ),
    'search_items'       => __( 'Search Facebook Posts' ),
    'not_found'          => __( 'No Facebook Posts found' ),
    'not_found_in_trash' => __( 'No Facebook Posts found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Facebook Posts'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds Facebook Posts and comments',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'facebook_post', $args );
}
