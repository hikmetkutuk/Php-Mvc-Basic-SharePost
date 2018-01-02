<?php

// Load Config
require_once 'config/config.php';
//Load helper
require_once 'helper/url_helper.php';
require_once 'helper/session_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'lib/' . $className . '.php';
});

 ?>