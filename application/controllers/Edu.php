<?php

class EduController extends BaseController {

  
    
    public function indexAction() {  
        $url = $this->getRequest()->getParam('url');
        $p = $this->getRequest()->getParam('p',1);
        $config = $this->getConfig();
        $viewPath = $this->getView()->getScriptPath();
        $size = 10;
        $start = ($p-1)*$size;
        
        //获取文章
        $obj = new KaoshiModel();
        $list = $obj->select([
            'ORDER'=>['id'=>'DESC'],
            'LIMIT'=>[$start,$size]
        ],[
            'id','title','create_time'
        ]);
        
        //分页处理
        $total = $obj->count();
        $pageObj = new Pager($total, 10, 5, 'p', [
            'first'=>$url.'/',
            'end'=>'',
            'firstpage'=>'/'.$url
        ]);
        $page = $pageObj->show();
        $seo = $this->getSeo('edu'); 
        
        
        
        $params = [  
            'viewPath'=>$viewPath,
            'seo'=>$seo,
            'url'=>$url,
            'config'=>$config, 
            'list'=>$list,
            'page'=>$page,
        ];
        $this->getView()->assign($params);
    }
    
    
    public function detailAction() {   
        $uuid = $this->getRequest()->getParam('uuid');
        $obj = new ArticleModel();
        $row = $obj->getRelate($uuid);
        if(!$row){
            throw new \Yaf\Exception('文章已经不存在');
        }
        
        $seo = $this->getSeo('article',[
            '{val}'=>$row['title']
        ]); 
         
        $config = $this->getConfig();
        $viewPath = $this->getView()->getScriptPath();
        $crumb = crumb('文章详情', [
            '/cate/'.$row['url']=>$row['typename']
        ]);
        
        
        //分类
        $type = $this->pluginTypeList();
        
         //标签
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        
        
        $params = [ 
            'type'=>$type,
            'tag'=>$tag,
            'row'=>$row,
            'viewPath'=>$viewPath,
            'seo'=>$seo,
            'config'=>$config,
            'crumb'=>$crumb
        ];
        $this->getView()->assign($params);
    }
 
  
}
