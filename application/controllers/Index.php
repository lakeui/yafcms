<?php

class IndexController extends Yaf\Controller_Abstract {

 
    public function indexAction() {   
       
      
        // dump($obj->select());
      
        return false;
        $this->getView()->assign("content", "Hello Yaf");
    }

    public function testAction() {   
        $obj = new Db();
        $rs = $obj->insert('cate',[
            'cate_id'=>  rand(100,9999),
            'cate_name'=>'wtest2'
        ]);
        dump($rs);
//       $rs = $obj->get('cate','*',['cate_id'=>1]);
//        dump($rs);
        exit;
        
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
