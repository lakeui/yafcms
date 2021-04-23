<?php

/**
 * 文章biz 
 * @author zhangheng
 */
namespace biz;
use ArticleModel;

class ArticleBizModel {
    
    
    protected $handle ;
    
    public function __construct() {
        if(empty($this->handle)){
            $this->handle = new ArticleModel(); 
        }
    }

   
    public function getArticleById($uuid,$field="*") { 
        return $this->handle->get([
            'uuid'=>$uuid
        ],$field); 
    }

    
    
 
     
}
