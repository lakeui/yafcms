<?php

class LinkModel extends BaseModel{

    private $table = 'wt_friendlink';
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }
    
    
    
    
}
