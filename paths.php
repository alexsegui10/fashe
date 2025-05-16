<?php
// utils/paths.php

// 1. Ruta del proyecto desde DOCUMENT_ROOT
define('PROJECT', '/Fashe/');

// 2. Rutas absolutas y URL base
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . PROJECT);
define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . PROJECT);

// 3. Carpeta de módulos, utilidades y vistas
define('MODULES_PATH', SITE_ROOT . 'module/');
define('UTILS_PATH',   SITE_ROOT . 'utils/');
define('VIEWS_PATH',   SITE_ROOT . 'views/');

// 4. Aquí definimos dónde están los fragmentos comunes (header, footer…)
define('VIEW_PATH_INC', VIEWS_PATH . 'html/');

// 5. Para tu módulo Home:
define('VIEW_HOME', MODULES_PATH . 'home/view/');
define('MODEL_HOME', MODULES_PATH . 'home/model/');


// 5. Para tu módulo Home:
define('VIEW_SHOP', MODULES_PATH . 'shop/view/');
define('MODEL_SHOP', MODULES_PATH . 'shop/model/');


// 5. Para tu módulo Home:
define('VIEW_SEARCH', MODULES_PATH . 'search/view/');
define('MODEL_SEARCH', MODULES_PATH . 'search/model/');
