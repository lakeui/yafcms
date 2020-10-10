<?php

class TypeModel extends BaseModel{

    private $table = 'wt_type';
 
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function get($condition=[],$field="*"){
        return $this->db->get($this->table,$field,$condition);
    }
    
    
    
}
