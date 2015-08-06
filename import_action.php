<?php
/**
 * This file contains the functions to perform import action from Admin side.
 */

function fi_import_action() 
{
    $page_title = 'Facebook Posts Import Action';
    $menu_title = 'Facebook Posts Import Action';
    $capability = 'edit_posts';
    $menu_slug = 'awesome_page';
    $function = 'fi_import_action_page_display';
    $icon_url = '';
    $position = 24;

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
}

function fi_import_action_page_display() 
{
    if (file_exists(LOCK_FILE)) {
        echo include_once VIEW_PATH . 'alert.php';
    }

    if (isset($_POST['submit'])) {
        if (!file_exists(LOCK_FILE)) {
            file_put_contents(LOCK_FILE, $cmd);
            $cmd = '/usr/bin/php ' . CMD_PATH . 'import.php > /dev/null 2>&1 &';
            exec($cmd);
        }
    }

    include_once 'views/action_form.php';
}
