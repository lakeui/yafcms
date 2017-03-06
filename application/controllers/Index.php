<?php

class IndexController extends Yaf\Controller_Abstract {

 
    public function indexAction() {   
       
         $obj = new CateModel();
        // dump($obj->select());
      
        return false;
        $this->getView()->assign("content", "Hello Yaf");
    }

    public function testAction() {   
       
     
        $this->getView()->assign("content", "Hello Yaf");
    }
    
    public function saveAction() {   
        $files = $this->getRequest()->getFiles();
        var_dump($files);
        $up = new Upload();
        $rs = $up->uploadOne($files['pic']);
        var_dump($rs);
       
        return false; 
    }
}
