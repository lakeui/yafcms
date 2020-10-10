<?php

class SearchController extends BaseController {

  
    public function indexAction() {  
        $url = $this->getRequest()->getRequestUri();
        $q = $this->getRequest()->getQuery('q');
        $p = $this->getRequest()->getQuery('p',1);
        if(empty($q)){
            $this->getResponse()->setRedirect ('/');
        } 
        $seo = $this->getSeo('search',[
            '{val}'=>$q
        ]); 
     
        //获取文章
        $objArticle = new ArticleModel();
        $list = $objArticle->selectRelateByKeyword($q,$p,10);
        
        //分页处理
        $total = $objArticle->count([
            'AND'=>[
                'status'=>1,
                'OR'=>[
                    'title[~]'=>$q,
                    'shortdesc[~]'=>$q
                ] 
            ] 
        ]); 
        $pageObj = new Pager($total, 10, 5, 'p', [
            'first'=>$url.'?q='.$q,
            'end'=>'',
            'firstpage'=>$url.'?q='.$q,
        ]);
        $page = $pageObj->show();
        
        
        $crumb = crumb('搜索');
        
        
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        
        //阅读排行
        $topArticle = $this->pluginTopRead();
        //分类
        $type = $this->pluginTypeList();
        
        $params = [  
            'type'=>$type,
            'topArticle'=>$topArticle,
            'tag'=>$tag,
            'seo'=>$seo,
            'url'=>$url,
            'list'=>$list,
            'page'=>$page,
            'q'=>$q,
            'total'=>$total,
            'crumb'=>$crumb
        ];
        $this->getView()->assign($params);
    }
    
    
  
}
