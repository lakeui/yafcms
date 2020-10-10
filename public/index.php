<?php

define("WEB_PATH", realpath(dirname(__FILE__)).'/'); 
define("APP_PATH", realpath(dirname(__FILE__) . '/../'));     
$app = new Yaf\Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->run();
