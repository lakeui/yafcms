<?php

class KaoshiModel extends BaseModel{

    private $table = 'wt_kaoshi';
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function get($condition=[],$field="*"){
        return $this->db->get($this->table,$field,$condition);
    }
    
     public function count($condition=[]){
        return $this->db->count($this->table,$condition);
    }
    
     
}

