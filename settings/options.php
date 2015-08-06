<?php
/**
 * This page holds all the functions to add Settings Page for this plugin
 */

function fi_settings_menu() 
{
    add_options_page(
        'Facebook Posts Import Settings', 'Facebook Posts Import Settings', 'manage_options', 'fi_plugin_settings', 'fi_plugin_settings_page'
    );
}


function fi_plugin_settings_page() 
{
    include_once 'views/main.php';
}

function fi_plugin_settings_init() {
    add_settings_section(
        'fi_plugin_settings_section', 'Settings', 'fi_plugin_settings_section_callback', 'fi_plugin_settings'
    );

    add_settings_field(
        'fi_url', 'URL', 'fi_url_input', 'fi_plugin_settings', 'fi_plugin_settings_section'
    );

    register_setting('fi_plugin_settings_group', 'fi_url');
}



function fi_plugin_settings_section_callback() 
{
    
}

function fi_url_input() 
{
    echo( '<input type="text" name="fi_url" id="fi_url" value="' . get_option('fi_url') . '" />' );
}
