<?php

class ZhuantiController extends BaseController {

 
    public function indexAction() {  
        $sort = $this->getRequest()->getQuery('sort','default');
        $order = [
            'id'=>'DESC'
        ];
        if($sort=='hot'){
            $order = [
                'rise'=>'ASC'
            ];
        }
        $obj = new ZhuantiModel();
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
    
    
    public function detailAction() {  
        $url = $this->getRequest()->getParam('url');
        if(empty($url)){
            throw new \Yaf\Exception('非法url');
        } 
        $obj = new ZhuantiModel();
        $row = $obj->get([
            'status'=>1,
            'url'=>$url
        ]);
        if(empty($row)){
            throw new \Yaf\Exception('专题已经不存在');
        }
        $seo = [
            'seo_title'=>$row['seo_title'],
            'seo_key'=>$row['seo_key'],
            'seo_desc'=>$row['seo_desc']
        ];  
        
        //获取专题文章
        $objArticle = new ArticleModel();
        $list = $objArticle->selectRelateByZhuanti($row['id']);
        
        $crumb = crumb($row['title'], [
            '/zhuanti'=>'热门专题'
        ]);
        $params = [
            'list'=>$list,
            'row'=>$row,
            'crumb'=>$crumb,
            'seo'=>$seo,
        ];
        $this->getView()->assign($params);
    } 
    
    
}
