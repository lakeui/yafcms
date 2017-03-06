<?php

class IndexController extends Yaf\Controller_Abstract {

 
    public function indexAction() {   
       
         $obj = new CateModel();
        // dump($obj->select());
      
        return false;
        $this->getView()->assign("content", "Hello Yaf");
    }

}
