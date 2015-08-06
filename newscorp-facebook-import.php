<?php

/**
 * Plugin Name: Newscorp Facebook Import
 * Plugin URI: http://newscorp.com.au/
 * Description: This plugin imports the facbook posts into the wordpress db
 * Version: 1.0
 * Author: Anil Konsal
 * Author URI: http://www.anilkonsal.com
 * License: GPL12
 */
require_once 'constants.php';
require_once 'create_facebook_post_type.php';
require_once 'create_meta_box.php';
require_once 'classes/FacebookImport.php';
require_once 'settings/options.php';
require_once 'import_action.php';



/*
 * Create custom post type for facebook posts
 */
add_action('init', 'create_facebook_post_type');

/*
 * Show Meta info in Edit Post
 */
add_action('add_meta_boxes', 'show_meta');

/*
 * Add Setting Menu and Page
 */
add_action('admin_menu', 'fi_settings_menu');
add_action('admin_init', 'fi_plugin_settings_init');

/*
 * Add URL field in settings
 */
add_option('fi_url', '');

/*
 * Add Import Action Menu Item and Page
 */
add_action('admin_menu', 'fi_import_action');


