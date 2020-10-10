<?php

class BookController extends BaseController {

 
    public function indexAction() {  
        $obj = new TypeModel();
        $list = $obj->select([
            'AND'=>[
                'status'=>1,
                'type'=>2
            ],
            'ORDER'=>[
                'rise'=>'ASC',
                'id'=>'DESC'
            ]
        ], ['url','typename','shortdesc','is_new','books','num']);
        
        $seo = $this->getSeo('book');  
        $params = [
            'list'=>$list,
            'seo'=>$seo,
        ];
        $this->getView()->assign($params);
    } 
     
    
    
    public function listAction() {  
        $order = [
            'rise'=>'ASC',
            'id'=>'DESC'
        ];
        $obj = new BookModel();
        $list = $obj->select([
            'status'=>1,
            'ORDER'=>$order
        ], ['url','title','shortdesc','viewnum','num','img']);
        $seo = $this->getSeo('zhuanti');  
        $params = [
            'list'=>$list,
            'seo'=>$seo,
            'sort'=>$sort,
        ];
        $this->getView()->assign($params);
    } 
    
    
}
