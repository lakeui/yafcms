<?php

class TagModel extends BaseModel{

    private $table = 'wt_tags';
    private $relate = 'wt_article_tag';


    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function get($condition='',$field="*"){ 
        return $this->db->get($this->table,$field,$condition); 
    }
    
    public function getArticleList($condition=''){ 
        $article_ids = [];
        $res = $this->db->select($this->relate,'*',$condition); 
        if(empty($res)){
           return $article_ids; 
        }
        foreach ($res as $vo) {
            $article_ids[]=$vo['article_id'];
        }
        return $article_ids;
    }
    
    
    
}
