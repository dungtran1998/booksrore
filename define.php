<?php

// ====================== PATHS ===========================
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__));                        // Định nghĩa đường dẫn đến thư mục gốc
define('LIBRARY_PATH', ROOT_PATH . DS . 'libs' . DS);            // Định nghĩa đường dẫn đến thư mục thư viện
define('PUBLIC_PATH', ROOT_PATH . DS . 'public' . DS);            // Định nghĩa đường dẫn đến thư mục public							
define('APPLICATION_PATH', ROOT_PATH . DS . 'application' . DS);        // Định nghĩa đường dẫn đến thư mục public							
define('MODULE_PATH', APPLICATION_PATH . 'module' . DS);        // Định nghĩa đường dẫn đến thư mục module							
define('TEMPLATE_PATH', PUBLIC_PATH . 'template' . DS);        // Định nghĩa đường dẫn đến thư mục public							
define('BLOCK_PATH', APPLICATION_PATH . 'block' . DS);        // Định nghĩa đường dẫn đến thư mục block							

// define('ROOT_URL', DS . "project-MVC/lecture-project/bookstore" . DS);
// define('APPLICATION_URL', ROOT_URL . 'application' . DS);
// define('PUBLIC_URL', ROOT_URL . 'public' . DS);
// define('TEMPLATE_URL', PUBLIC_URL . 'template' . DS);


define('ROOT_URL', "/project-MVC/lecture-project/bookstore/");
define('APPLICATION_URL', ROOT_URL . 'application/');
define('PUBLIC_URL', ROOT_URL . 'public/');
define('TEMPLATE_URL', PUBLIC_URL . 'template/');



define('DEFAULT_MODULE', 'backend');
define('DEFAULT_CONTROLLER', 'group');
define('DEFAULT_ACTION', 'index');

// ====================== DATABASE ===========================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'project-mvc');
define('DB_TABLE', 'user');

// ====================== DATABASE TABLE ===========================
define('TBL_GROUP', 'group');
define('TBL_USER', 'user');
