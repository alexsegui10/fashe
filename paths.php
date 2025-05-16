<?php
// utils/paths.php

define('PROJECT', '/Fashe/');

define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . PROJECT);
define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . PROJECT);

define('MODULES_PATH', SITE_ROOT . 'module/');
define('UTILS_PATH',   SITE_ROOT . 'utils/');
define('VIEWS_PATH',   SITE_ROOT . 'views/');

define('VIEW_PATH_INC', VIEWS_PATH . 'html/');

define('VIEW_HOME', MODULES_PATH . 'home/view/');
define('MODEL_HOME', MODULES_PATH . 'home/model/');


define('VIEW_SHOP', MODULES_PATH . 'shop/view/');
define('MODEL_SHOP', MODULES_PATH . 'shop/model/');


define('VIEW_SEARCH', MODULES_PATH . 'search/view/');
define('MODEL_SEARCH', MODULES_PATH . 'search/model/');



define('VIEW_AUTH', MODULES_PATH . 'auth/view/');
define('MODEL_AUTH', MODULES_PATH . 'auth/model/');

