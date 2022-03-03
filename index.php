<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once 'define.php';

// function __autoload($className)
// {
// 	require_once LIBRARY_PATH . "{$className}.php";
// }
spl_autoload_register(function ($clasName) {
	require_once LIBRARY_PATH . "{$clasName}.php";
	// echo LIBRARY_PATH . "{$clasName}.php"."<br>";
});

Session::init();
$bootstrap = new Bootstrap();
$bootstrap->init();
