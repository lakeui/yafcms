<?php

class ContentModel extends BaseModel{

    private $table = 'wt_content';
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    
    
    
}
