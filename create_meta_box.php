<?php
/**
 * This file contains functions to Show Meta info Box in edit post
 */

function show_meta() {
    add_meta_box('show_meta', 'Other Information', 'show_meta_cb', 'facebook_post', 'side', 'high');
}

function show_meta_cb($post) {
    $fi_status_type = get_post_meta($post->ID, '_fi_status_type', true);
    $fi_type = get_post_meta($post->ID, '_fi_type', true);
    $fi_picture = get_post_meta($post->ID, '_fi_picture', true);
    $fi_link = get_post_meta($post->ID, '_fi_link', true);
    $fi_source_category = get_post_meta($post->ID, '_fi_source_category', true);
    $fi_source_name = get_post_meta($post->ID, '_fi_source_name', true);
    $fi_caption = get_post_meta($post->ID, '_fi_caption', true);
 
    include_once 'views/post-meta-view.php';
}
