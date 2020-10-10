<?php

class TagController extends BaseController {

 
    public function detailAction() {   
        $tag = $this->getRequest()->getParam('tag');
        $seo = $this->getSeo('tag'); 
        if(empty($tag)){
            //
        }
        
        $tag = urldecode($tag); 
        //获取tag详情
        $objTag = new TagModel();
        $row = $objTag->get([
            'tagname'=>$tag
        ]);
        
        if(empty($row)){
            throw new \Yaf\Exception('标签不存在');
        } 
        $seo['seo_title'] = str_replace("{val}", $tag, $seo['seo_title']);

        
        //获取tag下的文章
        $list = [];
        $article_ids = $objTag->getArticleList([
            'tag_id'=>$row['id']
        ]);
        
        if(!empty($article_ids)){
            $obj = new ArticleModel();
            $list = $obj->selectRelate('list',1,0,0,$article_ids);
        } 
        
        
        
        //分类
        $objType = new TypeModel();
        $type = $this->pluginTypeList();
        
         //标签
        $tagRow = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        //阅读排行
        $topArticle = $this->pluginTopRead();
        
        
        $params = [  
            'type'=>$type,
            'tag'=>$tagRow,
            'seo'=>$seo, 
            'row'=>$row, 
            'topArticle'=>$topArticle,
            'list'=>$list
        ];
        $this->getView()->assign($params);
    }
 
}
