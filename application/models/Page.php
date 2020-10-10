<?php

class PageModel extends BaseModel{

    private $table = 'wt_single';
    
    
    public function select(){ 
        return $this->db->select($this->table,[
            'flag','title','css'
        ],[
            'status'=>1,
            'ORDER'=>[
                'rise'=>'ASC',
                'id'=>'ASC'
            ]
        ]); 
    }
    
    
    public function get($flag){
        return $this->db->get($this->table,'*',[
            'flag'=>$flag,
            'status'=>1
        ]);
    }
    
}
