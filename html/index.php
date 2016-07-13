<?php

define('CLASSES', __DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR);
define('LAYOUTS', __DIR__ . DIRECTORY_SEPARATOR . 'Layouts' . DIRECTORY_SEPARATOR);

require 'Loader.php';
Loader::init();

$controller = new \Controllers\AppController();
$controller->init();    

?>