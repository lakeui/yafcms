<?php

class SoulModel extends BaseModel{

    private $table = 'wt_soul';
    
    public function findRand(){ 
        return $this->db->query('select * from '.$this->table.' order by rand( ) limit 1')->fetch(PDO::FETCH_ASSOC);
    }
    
     
    
}
