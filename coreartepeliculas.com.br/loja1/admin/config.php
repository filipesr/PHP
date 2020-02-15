<?php
// SERVER
//define('SERVER_ROOT', 'www.coreartepeliculas.com.br');
define('SERVER_ROOT', 'localhost/coreartepeliculas.com.br/loja1/');
define('SERVER_DB', 'localhost');

// HTTP
define('HTTP_CATALOG', 'http://' . SERVER_ROOT . '/');
define('HTTP_SERVER', HTTP_CATALOG . 'admin/');
define('HTTP_IMAGE', HTTP_CATALOG . 'image/');

// HTTPS
define('HTTPS_SERVER', HTTP_CATALOG . 'admin/');
define('HTTPS_CATALOG', HTTP_CATALOG);
define('HTTPS_IMAGE', HTTP_CATALOG . 'image/');

// DIR
//define('DIR_ROOT', '/home/corearte/public_html/');
define('DIR_ROOT', 'D:\\wamp\\www\\coreartepeliculas.com.br\\loja1\\');
define('DIR_APPLICATION', DIR_ROOT . 'admin/');
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_DATABASE', DIR_ROOT . 'system/database/');
define('DIR_LANGUAGE', DIR_ROOT . 'admin/language/');
define('DIR_TEMPLATE', DIR_ROOT . 'admin/view/template/');
define('DIR_CONFIG', DIR_ROOT . 'system/config/');
define('DIR_IMAGE', DIR_ROOT . 'image/');
define('DIR_CACHE', DIR_ROOT . 'system/cache/');
define('DIR_DOWNLOAD', DIR_ROOT . 'download/');
define('DIR_LOGS', DIR_ROOT . 'system/logs/');
define('DIR_CATALOG', DIR_ROOT . 'catalog/');

// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', SERVER_DB);
//define('DB_USERNAME', 'corearte_site');
define('DB_USERNAME', 'root');
//define('DB_PASSWORD', 'e.pIVH4-oMgD');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'corearte_opencart');
define('DB_PREFIX', '');
?>
