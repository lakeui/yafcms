<?php

class PageController extends BaseController {

    public function init() {
        Yaf\Dispatcher::getInstance()->disableView();
        parent::init();
    }


    public function detailAction() {   
        $s = $this->getRequest()->getParam('s');
        $s = rtrim($s,'/');
        if(empty($s)){
            //404
            $this->error('参数错误');
        }
        //获取页面内容
        $obj = new PageModel();
        $row = $obj->get($s);
        if(empty($row)){
            $this->error('页面已经不存在');
        } 
         
        $seo = $this->getSeo('page',[
            '{val}'=>$row['title']
        ]); 
          
        $tpl = 'detail.html';
        if($row['type']==3){
            $tpl = $row['flag'].'.html';
        }
        $list = [];
        
        
        if($row['flag']=='friendlink'){
            $obj = new LinkModel();
            $list = $obj->select([
                'status'=>1
            ], [
                'id','title','logo','url'
            ]);
        }
         
        $params = [  
            'seo'=>$seo, 
            'row'=>$row, 
            'list'=>$list,
        ]; 
        return $this->getView()->assign($params)->display('page/'.$tpl);
    }
 
}
