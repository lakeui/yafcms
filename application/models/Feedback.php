<?php

class FeedbackModel extends BaseModel{

    private $table = 'wt_feedback';
    
    
     
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }
    
}

