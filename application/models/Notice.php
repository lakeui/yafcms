<?php

class NoticeModel extends BaseModel{

    private $table = 'wt_notice';
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    
    
    
}
