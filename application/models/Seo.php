<?php

class SeoModel extends BaseModel{

    private $table = 'wt_seo';
    
    public function get($condition='',$field="*"){ 
        return $this->db->get($this->table,$field,$condition); 
    }
    
    
    
    
}
