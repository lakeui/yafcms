<?php

class TongjiController extends BaseController {

 
    
    public function countArticleViewAction() {   
        $uuid =  $this->getRequest()->getPost('uuid');
        if(empty($uuid)){
            finish(1,'参数错误');
        }
        $row = new ArticleModel();
        $flag = $row->update([
            'view_num[+]'=>1
        ], [
            'uuid'=>$uuid
        ]);
        if(!empty($flag)){
            finish(0);
        }
        finish(1,'操作失败');
    }

    
    public function saveAction() {   
         
         
    }
}
