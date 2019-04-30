<?php

/**
 * Define an application root_directory by passing condition statements
 * @param string $_SERVER[SCRIPT_FILENAME]
 * @param string $_SERVER[DOCUMENT_ROOT]
 * @param string $_SERVER[SCRIPT_NAME]
 * @return string $_SERVER[ROOT_DIR]
 */
if ($_SERVER['SCRIPT_FILENAME'] !== $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME']) {
    $_SERVER['ROOT_DIR'] = (string)$_SERVER['DOCUMENT_ROOT'];
} else {
    $_SERVER['ROOT_DIR'] = (string)dirname($_SERVER['DOCUMENT_ROOT']);
}

/**
 * Register an Autoload from Composer Vendor Directory
 * @param string $_SERVER[ROOT_DIR]
 * @return string $_SERVER[COMPOSER_VENDOR_DIR]
 * @return string|boolean $_SERVER[COMPOSER_AUTOLOAD] | false
 */
if (
    is_dir($_SERVER['COMPOSER_VENDOR_DIR'] = $_SERVER['ROOT_DIR'] . '/vendor') &&
    is_file($_SERVER['COMPOSER_AUTOLOAD'] = $_SERVER['COMPOSER_VENDOR_DIR'] . '/autoload.php')
) {
    require_once $_SERVER['COMPOSER_AUTOLOAD'];
} else {
    header("Content-Type: text/plain; charset=UTF-8", true, 500);
    echo "Could not found `vendor/autload.php` file in `$_SERVER[ROOT_DIR]`";
    return false;
}

/**
 * RequestURI Info
 * @param string $_SERVER[REQUEST_URL]
 * @return string $_SERVER[PATH_INFO]
 * @return array $_SERVER[REQUEST_PATH]
 */
if (($_SERVER['PATH_INFO'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) === '/') {
    $_SERVER['REQUEST_PATH'] = (array)[];
} else {
    $_SERVER['REQUEST_PATH'] = (array)explode('/', trim($_SERVER['PATH_INFO'], '/'));
}

/**
 * Detect ServerAPI(SAPI) to differentiate LOCAL[Dev] or WEB[Prod] Environment
 * 
 */
$_ENV['PHP_SAPI'] = PHP_SAPI;
if (preg_match('!cgi!', $_ENV['PHP_SAPI'])) {
    return require __DIR__ . '/server/cgi.php';
} elseif (preg_match('!cli!', $_ENV['PHP_SAPI'])) {
    return require __DIR__ . '/server/cli.php';
} else {
    header("Content-Type: text/plain; charset=UTF-8", true, 502);
    echo $_ENV['PHP_SAPI'] . ' was not supported!';
    return false;
}