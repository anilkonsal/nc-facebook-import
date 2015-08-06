<?php
/**
 * This file contains all the constants used in valious files
 */

$root = dirname(__FILE__);
define('DS', DIRECTORY_SEPARATOR);
define('TMP_PATH', $root. DS. 'tmp'. DS);
define('CMD_PATH', $root. DS. 'command'. DS);
define('CLASS_PATH', $root. DS. 'classes'. DS);
define('SETTINGS_PATH', $root. DS. 'settings'. DS);
define('VIEW_PATH', $root. DS. 'views'. DS);
define('LOCK_FILE', TMP_PATH.'import-running.txt');