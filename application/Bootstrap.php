<?php

class Bootstrap extends \Yaf\Bootstrap_Abstract {

    public function _initConfig(\Yaf\Dispatcher $dispatcher) {
        $config = \Yaf\Application::app()->getConfig();
        \Yaf\Registry::set("config", $config);
    }

    public function _initPlugin(\Yaf\Dispatcher $dispatcher) {
        
    }

    //加载公共函数库
    public function _initFunction(Yaf\Dispatcher $dispatcher) {
        \Yaf\Loader::import('Function/Common.php');
    }

    
    public function _initRoute(\Yaf\Dispatcher $dispatcher) {
        $router = \Yaf\Dispatcher::getInstance()->getRouter(); 
        $router->addConfig(\Yaf\Registry::get("config")->routes);
    }

     /**
     * 注册composer
     */
    public function _initComposer(\Yaf\Dispatcher $dispatcher) {
        require APP_PATH.'/vendor/autoload.php';
    }
}
