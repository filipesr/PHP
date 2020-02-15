<?php

// HTTP
define('HTTP_SERVER', 'http://localhost/finotraco.com.br/loja1/');
define('HTTP_IMAGE', HTTP_SERVER . 'image/');
define('HTTP_ADMIN', HTTP_SERVER . 'admin/');

// HTTPS
define('HTTPS_SERVER', HTTP_SERVER);
define('HTTPS_IMAGE', HTTP_SERVER . 'image/');

// DIR
define('DIR_ROOT', 'D:\wamp\www\finotraco.com.br\loja1/');
define('DIR_APPLICATION', DIR_ROOT . 'catalog/');
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_DATABASE', DIR_ROOT . 'system/database/');
define('DIR_LANGUAGE', DIR_ROOT . 'catalog/language/');
define('DIR_TEMPLATE', DIR_ROOT . 'catalog/view/theme/');
define('DIR_CONFIG', DIR_ROOT . 'system/config/');
define('DIR_IMAGE', DIR_ROOT . 'image/');
define('DIR_CACHE', DIR_ROOT . 'system/cache/');
define('DIR_DOWNLOAD', DIR_ROOT . 'download/');
define('DIR_LOGS', DIR_ROOT . 'system/logs/');

// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'opencart');
define('DB_PREFIX', '');
?>