<?php

class ConfigModel extends BaseModel{

    private $table = 'wt_config';
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    
    
}
