<?php
require_once dirname(__FILE__). '/../constants.php';
require_once CLASS_PATH . 'FacebookImport.php';

$objFi = new FacebookImport();
$objFi->setUrl(get_option('fi_url'))
        ->importData();
unlink(LOCK_FILE);

$admin_email = get_option('admin_email');

mail($admin_email, 'Facebook Posts Import finished!', 'Facebook Posts Import has finished!');

