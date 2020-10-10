<?php

class BookModel extends BaseModel{

    private $table = 'wt_book';
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function get($condition=[],$field="*"){
        return $this->db->get($this->table,$field,$condition);
    }
    
    
    
}
